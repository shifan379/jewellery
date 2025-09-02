<?php

namespace App\Http\Controllers\APP;

use App\Exports\PurchaseReturnExport;
use App\Http\Controllers\Controller;
use App\Models\PurchaseReturn;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseReturnController extends Controller
{
    //
    public function index(Request $request)
    {
        $PurchaseReturn = PurchaseReturn::with('product')->with('purchase')->latest()->get();

        return view("app.purchaseReturn.view", compact('PurchaseReturn'));
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'purchase_date' => 'required|date',
    //         'notes' => 'nullable|string|max:600',
    //         'purcheseID' => 'required|exists:purchases,id', // ensure purcheseID is validated
    //         'items' => 'required|array|min:1',
    //         'items.*.product_id' => 'required|exists:products,id',
    //         'items.*.qty' => 'required|numeric|min:1',
    //         'items.*.purchase_price' => 'required|numeric|min:0',
    //         'items.*.discount' => 'nullable|numeric|min:0',
    //         'items.*.unit_cost' => 'required|numeric|min:0',
    //         'items.*.line_total' => 'required|numeric|min:0',
    //     ]);

    //     $subTotal = 0;
    //     $items = [];

    //     foreach ($validated['items'] as $item) {
    //         $lineTotal = $item['line_total'] ?? 0;
    //         $subTotal += $lineTotal;

    //         $items[] = [
    //             'purchase_date' => $validated['purchase_date'],
    //             'notes' => $validated['notes'] ?? null,
    //             'purcheseID' => $validated['purcheseID'],
    //             'product_id' => $item['product_id'],
    //             'qty' => $item['qty'],
    //             'purchase_price' => $item['purchase_price'],
    //             'discount' => $item['discount'] ?? 0.00,
    //             'unit_cost' => $item['unit_cost'],
    //             'total' => $lineTotal,
    //             'return_total' => 0, // temporarily 0, will update below
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ];
    //     }

    //     // Apply return_total to each item
    //     foreach ($items as &$item) {
    //         $item['return_total'] = $subTotal;
    //     }

    //     // Bulk insert for performance
    //     PurchaseReturn::insert($items);
    //     return redirect()->back()->with('success', 'Purchase return added successfully.');
    // }

    // public function searchByCode(Request $request)
    // {

    //     $query = $request->get('q');

    //     $purchases = \App\Models\Purchase::where('purchase_code', 'LIKE', "%{$query}%")
    //         ->select('id', 'purchase_code')
    //         ->limit(5)
    //         ->get();

    //     return response()->json($purchases);

    // }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string|max:600',
            'purcheseID' => 'required|exists:purchases,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|numeric|min:1',
            'items.*.purchase_price' => 'required|numeric|min:0',
            'items.*.weight' => 'nullable|numeric|min:0',
            'items.*.item_code' => 'required',
            'items.*.unit_cost' => 'required|numeric|min:0',
            'items.*.line_total' => 'required|numeric|min:0',
        ]);

        $subTotal = 0;
        $items = [];

        foreach ($validated['items'] as $item) {
            $lineTotal = $item['line_total'] ?? 0;
            $subTotal += $lineTotal;

            $items[] = [
                'purchase_date' => $validated['purchase_date'],
                'notes' => $validated['notes'] ?? null,
                'purcheseID' => $validated['purcheseID'],
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'purchase_price' => $item['purchase_price'],
                'weight' => $item['weight'] ?? 0.00,
                'unit_cost' => $item['unit_cost'],
                'total' => $lineTotal,
                'return_total' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Apply total to each return row
        foreach ($items as &$item) {
            $item['return_total'] = $subTotal;
        }

        // Save purchase returns
        PurchaseReturn::insert($items);

        // === DECREASE STOCKS & QUANTITIES ===
        foreach ($validated['items'] as $item) {
            // 1. Decrease product quantity
            $product = Product::find($item['product_id']);
            if ($product) {
                $product->decrement('quantity', $item['qty']);

                // 2. Update Stocks table
                \App\Models\Stocks::where('product_id', $product->id)
                    ->where('location_id', $product->location)
                    ->decrement('stock', $item['qty']);
            }

            // 3. Decrease qty in purchase_items
            PurchaseItem::where('purchase_id', $validated['purcheseID'])
                ->where('product_id', $item['product_id'])
                ->decrement('qty', $item['qty']);
        }

        return redirect()->back()->with('success', 'Purchase return added successfully.');
    }


    public function searchByCode(Request $request)
    {
        $query = $request->get('q');

        $purchases = Purchase::where('purchase_code', 'LIKE', "%{$query}%")
            ->select('id', 'purchase_code') // Optional: limit fields
            ->get();

        return response()->json($purchases);
    }

    // public function getPurchaseDetails($id)
    // {
    //     $purchase = \App\Models\Purchase::with('purchase_items.product')->findOrFail($id);

    //     return response()->json([
    //         'purchase_items' => $purchase->purchase_items
    //     ]);
    // }


    public function getPurchaseDetails(Request $request)
    {
        $purchase = Purchase::with('purchase_items.product')->findOrFail($request->purchase_id);

        return response()->json($purchase);
    }

    public function destroy($id)
    {
        $purchaseDelete = PurchaseReturn::findOrFail($id);
        $purchaseDelete->delete();

        return redirect()->back()->with('success', 'Purchase deleted successfully.');
    }



    public function export(Request $request)
    {
        $request->validate([
            'format' => 'required|in:pdf,excel',
            'selected_ids' => 'required|string',
        ]);

        $ids = explode(',', $request->selected_ids);
        $returns = PurchaseReturn::with('product','purchase')->whereIn('id', $ids)->get();

        if ($returns->isEmpty()) {
            return redirect()->back()->with('error', 'No return records found for selected IDs.');
        }

        if ($request->format == 'pdf') {
            $pdf = PDF::loadView('export.purchase_return_pdf', compact('returns'));
            return $pdf->download('purchase_returns.pdf');
        }

        if ($request->format == 'excel') {
            return Excel::download(new PurchaseReturnExport($ids), 'purchase_returns.xlsx');
        }

        return redirect()->back()->with('error', 'Invalid export format.');
    }


}

