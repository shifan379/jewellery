<?php

namespace App\Http\Controllers\APP;

use App\Exports\StockTransferExport;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\product;
use App\Models\Stocks;
use App\Models\StockTransfer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class StockTransferController extends Controller
{
    //
    public function index(Request $request)
    {

        $query = \App\Models\StockTransfer::with(['product', 'fromLocation', 'toLocation']);

        if ($request->has('from_location_id') && $request->from_location_id !== null) {
            $query->where('from_location_id', $request->from_location_id);
        }

        if ($request->has('to_location_id') && $request->to_location_id !== null) {
            $query->where('to_location_id', $request->to_location_id);
        }

        // Sorting
        if ($request->sort_by === 'asc') {
            $query->orderBy('created_at', 'asc');
        } elseif ($request->sort_by === 'desc') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort_by === 'last_7') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif ($request->sort_by === 'last_month') {
            $query->whereMonth('created_at', now()->subMonth()->month);
        } else {
            $query->orderBy('created_at', 'desc'); // Default
        }

        // ✅ Fix: Use filtered query results
        $stockTransfers = $query->get();

        $locations = Location::all();
        return view('app.stock_transfer.view', compact('locations', 'stockTransfers'));
    }

    public function searchProduct(Request $request)
    {
        $query = $request->get('q');

        $products = product::where('product_name', 'like', "%{$query}%")
            ->select('id', 'product_name')
            ->limit(5)
            ->get();

        return response()->json($products);
    }

    public function getProductStockDetails($productId)
    {
        $stocks = Stocks::with('location')->where('product_id', $productId)->get();

        $details = $stocks->map(function ($stock) {
            return [
                'location' => $stock->location->name ?? 'Unknown',
                'stock' => $stock->stock,
            ];
        });

        return response()->json($details);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'from_location_id' => 'required|exists:locations,id',
            'to_location_id' => 'required|exists:locations,id|different:from_location_id',
            'stock_quantity' => 'required|numeric|min:1',
            'responsible_person'=> 'nullable|string|max:255',
            'ref_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            // Get stock from source
            $fromStock = Stocks::firstOrCreate([
                'product_id' => $validated['product_id'],
                'location_id' => $validated['from_location_id'],
            ]);

            if ($fromStock->stock < $validated['stock_quantity']) {
                return redirect()->back()->withErrors('Insufficient stock at source location.');
            }

            // Decrease source stock
            $fromStock->decrement('stock', $validated['stock_quantity']);

            // Increase destination stock
            $toStock = Stocks::firstOrCreate([
                'product_id' => $validated['product_id'],
                'location_id' => $validated['to_location_id'],
            ]);

            $toStock->increment('stock', $validated['stock_quantity']);

            // Logging for debugging
            \Log::info('From stock after transfer: ', ['stock' => $fromStock->fresh()->stock]);
            \Log::info('To stock after transfer: ', ['stock' => $toStock->fresh()->stock]);

            // Save transfer
            StockTransfer::create([
                'product_id' => $validated['product_id'],
                'from_location_id' => $validated['from_location_id'],
                'to_location_id' => $validated['to_location_id'],
                'stock_quantity' => $validated['stock_quantity'],
                'responsible_person'=> $validated['responsible_person'],
                'ref_number' => $validated['ref_number'],
                'notes' => $validated['notes'],
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Stock transferred successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Transfer failed: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $transfer = \App\Models\StockTransfer::findOrFail($id);

        // Optional: Reverse stock transfer logic here if needed

        $transfer->delete();

        return redirect()->back()->with('success', 'Stock transfer deleted successfully.');
    }


    public function exportPdf(Request $request)
    {
        // $transfers = StockTransfer::with(['product', 'fromLocation', 'toLocation'])->latest()->get();

        // $pdf = Pdf::loadView('export.stock_transfers_pdf', compact('transfers'));
        // return $pdf->download('stock_transfers.pdf');

        $ids = explode(',', $request->selected_ids);
        $transfers = StockTransfer::with(['product', 'fromLocation', 'toLocation'])
            ->whereIn('id', $ids)->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('export.stock_transfers_pdf', compact('transfers'));
        return $pdf->download('selected_stock_transfers.pdf');
    }

    public function exportExcel(Request $request)
    {
        // return Excel::download(new StockTransferExport, 'stock_transfers.xlsx');

        $ids = explode(',', $request->selected_ids);
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\StockTransferExport($ids),
            'selected_stock_transfers.xlsx'
        );

    }

}
