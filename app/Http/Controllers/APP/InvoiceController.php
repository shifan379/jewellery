<?php

namespace App\Http\Controllers\APP;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PosPrinterSettings;
use App\Models\product;
use App\Models\ReturnLog;
use App\Models\TodayRate;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $lists = Order::with(['transaction','customer','items','return_data','cashier'])->latest()->get();
        return view('app.invoice.list', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $orders = Order::with(['transaction','customer','items','return_data','cashier'])->findOrFail($id);

      //  return $list;
        return view('app.invoice.view', compact('orders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
         $edit_order = Order::with(['transaction', 'items.product', 'customer', 'return_data.product_data'])
                            ->findOrFail($id);
        $today = Carbon::today();
        // Return logs for today
        $total_return = ReturnLog::whereDate('created_at', $today)->get();
        // Load carts
        $carts = Cart::with('product')->where('order_id', $edit_order->id)->get();
        // If no carts exist, create from order items
        if ($carts->isEmpty()) {
            if($edit_order->items->count() > 0){
                $cartData = $edit_order->items->map(function ($item) use ($edit_order) {
                return [
                    'order_id'       => $edit_order->id,
                    'product_id'     => $item->product->id,
                    'quantity'       => $item->qty,
                    'discount'       => $item->discount,
                     'weight'        => $item->weight,
                    'net_price'      => $item->net_price,
                    'sales_type'     => 'retail',
                    'main_sub_total' => $edit_order->subtotal,
                    'main_discount'  => $edit_order->discount,
                    'main_total'     => $edit_order->total,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
                })->toArray();
                Cart::insert($cartData);
            }if($edit_order->return_data->count() > 0)
            {
                $cartData = $edit_order->return_data->map(function ($return_data) use ($edit_order) {
                return [
                    'order_id'          => $edit_order->id,
                    'product_id'        => $return_data->productID,
                    'quantity'          => $return_data->return_qty,
                    'discount'          => $return_data->discount,
                    'weight'            => $return_data->return_weight,
                    'net_price'         => $return_data->return_net_price,
                    'sales_type'        => 'retail',
                    'return'            => 1,
                    'main_sub_total'    => $edit_order->subtotal,
                    'main_discount'     => $edit_order->discount,
                    'main_total'        => $edit_order->total,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];
                })->toArray();
                Cart::insert($cartData);
            }

            // Reload carts after insertion
            $carts = Cart::with('product')->where('order_id', $edit_order->id)->get();
        }

        // Fetch customers & products
        $customers = Customer::all();
        $products  = product::where('quantity', '!=', '0')->get(['product_name', 'mark', 'unit','weight']);

         // take today Rate
        $todayRate = TodayRate::with('category')
                        ->where(function ($query) {
                            $query->whereDate('created_at', Carbon::today())
                                ->orWhereDate('updated_at', Carbon::today());
                        })
                        ->get();
        return view('online_orders.addsales', compact(
            'customers',
            'carts',
            'edit_order',
            'total_return',
            'products','todayRate'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $orders = Order::findOrFail($request->id);
        $orders->delete();
        return redirect()->back()->with('success', 'Order deleted successfully!');
    }

    public function posFormat(string $id)
    {
        //
         //Get invoice Data
        $orders = Order::with(['transaction', 'items', 'customer', 'return_data.product_data'])->findOrFail($id);
        //
        $print_set = PosPrinterSettings::first();
        return view('pos.print.pos-print2', compact('orders', 'print_set'));
    }

    public function exportSelectedPdf(Request $request  )
    {
        //
      //  return $request->all();
        $ids = $request->input('ids');

    $order = Order::with(['items', 'return_data.product_data', 'customer', 'transaction'])
        ->whereIn('id', $ids)
        ->get();

    $zip = new \ZipArchive();
    $zipFileName = 'invoices_'.date('YmdHis').'.zip';
    $zipPath = storage_path($zipFileName);

    if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
        foreach ($order as $orders) {
            $pdf = FacadePdf::loadView('pos.print.invoice-print', compact('orders'))
                ->setPaper('a4', 'portrait')
                ->output();

            // Add PDF content as file in ZIP
            $zip->addFromString("invoice_{$orders->invoice_no}.pdf", $pdf);
        }
        $zip->close();
    }

    return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
