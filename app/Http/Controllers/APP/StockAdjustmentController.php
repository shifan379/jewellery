<?php

namespace App\Http\Controllers\APP;

use App\Exports\StockAdjustmentExport;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\product;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockExport;


class StockAdjustmentController extends Controller
{
    //
    public function index(Request $request)
    {

        $products = product::with('cate', 'locationRelation', 'supply')
            ->when($request->filled('location'), function ($q) use ($request) {
                $q->where('location', $request->location);
            })
            ->when($request->filled('sort'), function ($q) use ($request) {
                if ($request->sort === 'asc') {
                    $q->orderBy('created_at', 'asc');
                } elseif ($request->sort === 'desc') {
                    $q->orderBy('created_at', 'desc');
                } elseif ($request->sort === 'last_7_days') {
                    $q->where('created_at', '>=', now()->subDays(7));
                } elseif ($request->sort === 'last_month') {
                    $q->whereBetween('created_at', [now()->subMonth(), now()]);
                }
            })
            ->get();

        $locations = Location::all();

        $allProducts = product::all();

          $totalStockValue = $allProducts->sum(function ($product) {
            return $product->quantity * $product->buying_price;
        });
        $totalStockCount = $allProducts->sum(function ($product) {
            return $product->quantity ;
        });


        return view('app.stockAdjustment.view', compact('products', 'locations','totalStockValue','totalStockCount'));
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $product = product::find($request->product_id);
        $product->quantity = $request->quantity;
        $product->save();

        return redirect()->back()->with('success', 'Quantity updated successfully.');
    }

    public function destroy($id)
    {
        $product = \App\Models\product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function export(Request $request)
    {
        $request->validate([
            'format' => 'required|in:pdf,excel',
            'selected_ids' => 'required|string',
        ]);

        $ids = explode(',', $request->selected_ids);
        $format = $request->input('format');

        $products = product::with('cate', 'locationRelation', 'supply')
            ->whereIn('id', $ids)
            ->get();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('export.stockAdjustment_pdf', compact('products'));
            return $pdf->download('stock_adjustments.pdf');
        }

        if ($format === 'excel') {
            return Excel::download(new StockAdjustmentExport($products), 'stock_adjustments.xlsx');
        }
    }


}
