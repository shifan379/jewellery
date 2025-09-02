<?php

namespace App\Http\Controllers\APP;

use App\Exports\PurchaseExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Stocks;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class PurchaseController extends Controller
{
    //

    // public function index()
    // {
    //     // $purchase = Purchase::all();
    //     $purchases = Purchase::with('supplier', 'items')->latest()->get();
    //     // $purchases_items = PurchaseItem::with('purchase_id')->latest()->get();
    //     $suppliers = Supplier::all();

    //     // Sum qty for each purchase
    //     $purchaseQtySum = [];
    //     foreach ($purchases as $purchase) {
    //         $purchaseQtySum[$purchase->id] = $purchase->items->sum('qty');
    //     }

    //     return view('app.purchase.view', compact('suppliers', 'purchases', 'purchaseQtySum'));


    // }

    public function index(Request $request)
    {
        $status = $request->get('status'); // from query string ?status=Received

        $query = Purchase::with('supplier', 'items')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $purchases = $query->get();
        $suppliers = Supplier::all();
        $categorys = Category::all();
        $purchaseQtySum = [];
        foreach ($purchases as $purchase) {
            $purchaseQtySum[$purchase->id] = $purchase->items->sum('qty');
        }

        return view('app.purchase.view', compact('suppliers', 'purchases', 'purchaseQtySum', 'status','categorys'));
    }



    public function store(Request $request)
    {

        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'reference' => 'nullable|string',
            'purchase_date' => 'required|date',
            'discount' => 'nullable|numeric',
            'shipping' => 'nullable|numeric',
            'categoryID' => 'nullable',
            'status' => 'required|in:Pending,Received',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.purchase_price' => 'required|numeric|min:0',
            'items.*.weight' => 'required',
            'items.*.prefix' => 'nullable',
            'items.*.item_code' => 'nullable',
            'items.*.mark' => 'nullable',
            'items.*.line-total' => 'nullable',
            'items.*.total' => 'nullable|numeric',
        ]);

        $total = 0;
        foreach ($validated['items'] as $item) {
            $unit_cost = $item['purchase_price'] ;
            $line_total = $unit_cost * $item['qty'];
            $total += $line_total;
        }

        $total += $validated['shipping'] ?? 0;

        $purchase = Purchase::create([
            'supplier_id' => $validated['supplier_id'],
            'reference' => $validated['reference'],
            'purchase_date' => $validated['purchase_date'],
            'shipping' => $validated['shipping'],
            'status' => $validated['status'],
            'notes' => $validated['notes'],
            'total' => $total,
        ]);

        // Generate a custom ID like PUR001
        $purchase->purchase_code = 'PUR'. str_pad($purchase->id, 3, '0', STR_PAD_LEFT);
        $purchase->save();

        foreach ($validated['items'] as $item) {
            $unit_cost = $item['purchase_price'];
            $line_total = $unit_cost * $item['qty'];
          // Then in controller/service:
                $new_pro = Product::create([
                    'product_name'  => $request->product_name,
                    'prefix'        => $item['prefix'],
                    'category'      => $request->categoryID,
                    'location'      => 1,
                    'unit'          => 'g',
                    'product_type'  => 0,
                    'mark'          => $item['mark'],
                    'quantity'      => $item['qty'],
                    'buying_price'  => $item['purchase_price'],
                    'item_code'     => str_pad($item['item_code'], 4, '0', STR_PAD_LEFT), // ✅ PHP way
                    'weight'        => $item['weight'],
                ]);
            // Update or create stock record
                Stocks::updateOrCreate(
                    [
                        'product_id' => $new_pro->id,
                        'location_id' => $new_pro->location,
                    ],
                    [
                        'stock' => $new_pro->quantity,
                    ]
                );
                $purchase->items()->create([
                    'purchase_id'   => $purchase->id,
                    'product_id'    => $new_pro->id,
                    'qty'           => $item['qty'],
                    'categoryID'    => $request['categoryID'],
                    'purchase_price'=> $item['purchase_price'],
                    'item_code'     => $item['mark'],
                    'weight'        => $item['weight'],
                    'unit_cost'     => $unit_cost,
                    'total'         => $line_total,
                ]);
        }
        // return dd($purchase);
        return redirect()->back()->with('success', 'Purchase added successfully.');
    }

    public function updateAverageCost(Product $product)
    {
        $entries = PurchaseItem::where('product_id', $product->id)->get();
        $totalQty = $entries->sum('qty');
        $totalCost = $entries->sum(fn($e) => $e->qty * $e->purchase_price);
        $product->average_cost_price = $totalQty > 0 ? round($totalCost / $totalQty, 2) : 0;
        $product->save();
    }

    public function searchProducts(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where('product_name', 'LIKE', "%{$query}%")
            ->selectRaw('MIN(id) as id, product_name, prefix')
            ->groupBy('product_name', 'prefix')
            ->get();

        return response()->json($products);
    }


    public function getItems($id)
    {
        $items = PurchaseItem::with('product')->where('purchase_id', $id)
            ->get();

        return response()->json($items);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'reference' => 'nullable|string',
            'purchase_date' => 'required|date',
            'discount' => 'nullable|numeric',
            'shipping' => 'nullable|numeric',
            'status' => 'required|in:Pending,Received',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.purchase_price' => 'required|numeric|min:0',
            'items.*.weight' => 'nullable',
            'items.*.prefix' => 'nullable',
            'items.*.total' => 'nullable|numeric',
            'items.*.item_code' => 'nullable',
            'items.*.mark' => 'nullable',
        ]);

        $purchase = Purchase::findOrFail($id);

        // Calculate total again
        $total = 0;
        foreach ($validated['items'] as $item) {
            $unit_cost = $item['purchase_price'];
            $line_total = $unit_cost * $item['qty'];
            $total += $line_total;
        }
        $total += $validated['shipping'] ?? 0;

        // Update purchase details
        $purchase->update([
            'supplier_id' => $validated['supplier_id'],
            'reference' => $validated['reference'],
            'purchase_date' => $validated['purchase_date'],
            'shipping' => $validated['shipping'],
            'status' => $validated['status'],
            'notes' => $validated['notes'],
            'total' => $total,
        ]);

        // Existing items in DB
        $existingItemIds = $purchase->items()->pluck('id')->toArray();
        $requestItemIds = $request->input('item_id', []); // Hidden field from form

        // --- Handle Deleted Items (reduce stock) ---
        $itemsToDelete = array_diff($existingItemIds, $requestItemIds);
        if (!empty($itemsToDelete)) {
            foreach (PurchaseItem::whereIn('id', $itemsToDelete)->get() as $deletedItem) {
                $product = Product::find($deletedItem->product_id);
                if ($product) {
                    $product->decrement('quantity', $deletedItem->qty);
                    Stocks::where('product_id', $product->id)
                        ->where('location_id', $product->location)
                        ->decrement('stock', $deletedItem->qty);
                }
            }
            PurchaseItem::whereIn('id', $itemsToDelete)->delete();
        }

        // --- Handle Updated / New Items ---
        foreach ($validated['items'] as $index => $item) {
            $unit_cost = $item['purchase_price'];
            $line_total = $unit_cost * $item['qty'];
            $product = Product::find($item['product_id']);

            $itemData = [
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'purchase_price' => $item['purchase_price'],
                'item_code' => $item['mark'],
                'weight'      => $item['weight'],
                'unit_cost'    => $unit_cost,
                'total'         => $line_total,
            ];

            if (isset($requestItemIds[$index])) {
                // --- Existing item ---
                $existingItem = PurchaseItem::find($requestItemIds[$index]);
                $oldQty = $existingItem ? $existingItem->qty : 0;

                $existingItem->update($itemData);

                // Stock adjustment
                $qtyDiff = $item['qty'] - $oldQty;
                if ($qtyDiff > 0) {
                    $product->increment('quantity', $qtyDiff);
                } elseif ($qtyDiff < 0) {
                    $product->decrement('quantity', abs($qtyDiff));
                }

                // Update product details
                $product->buying_price = $item['purchase_price'];
                $product->save();

            } else {
                // --- New item ---
                $purchase->items()->create($itemData);
                if ($product) {
                    $product->increment('quantity', $item['qty']);
                    $product->buying_price = $item['purchase_price'];
                    $product->save();
                }
            }

            // Update Stocks table
            Stocks::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'location_id' => $product->location,
                ],
                [
                    'stock' => $product->quantity,
                ]
            );
        }

        return redirect()->back()->with('success', 'Purchase updated successfully.');
    }

    public function destroy($id)
    {
        $purchase = Purchase::with('items')->findOrFail($id);

        foreach ($purchase->items as $item) {
            $product = product::find($item->product_id);

            if ($product) {
                // Reduce product quantity
                $product->decrement('quantity', $item->qty);

                // Update stocks table
                Stocks::where('product_id', $product->id)
                    ->where('location_id', $product->location)
                    ->decrement('stock', $item->qty);
            }
        }

        // Delete related items first
        $purchase->items()->delete();

        // Then delete the purchase itself
        $purchase->delete();

        return redirect()->back()->with('success', 'Purchase deleted successfully and stock updated.');
    }



    // public function downloadPurchasePdf(Request $request)
    // {
    //     $ids = $request->input('ids', []);
    //     if (empty($ids))
    //         return back()->with('error', 'No purchases selected.');
    //     $purchase = Purchase::with('supplier', 'items.product')->get();
    //     // $purchase = Purchase::with('items.product')->whereIn('id', $ids)->get();
    //     $pdf = Pdf::loadView('export.purchase_pdf', compact('purchase'));
    //     return $pdf->download('selected-purchases.pdf');
    // }

    public function downloadPurchasePdf(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', 'Please select at least one purchase to export.');
        }

        $purchase = Purchase::with('supplier', 'items.product')->whereIn('id', $ids)->get();

        $pdf = Pdf::loadView('export.purchase_pdf', compact('purchase'));
        return $pdf->download('selected-purchases.pdf');
    }




    public function downloadPurchaseExcel(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids))
            return back()->with('error', 'Please select at least one purchase to export.');

        return Excel::download(new PurchaseExport($ids), 'selected-purchases.xlsx');
    }





}
