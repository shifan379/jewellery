<?php

namespace App\Http\Controllers\APP;

use App\Exports\StockExport;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\product;
use App\Models\Stocks;
use App\Models\StockTransfer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StockManageController extends Controller
{
    //
    public function index(Request $request)
    {
        $locations = Location::all();
        $products = product::all();

        $query = Stocks::with(['location', 'product']);

        // Apply filters if present
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $stocks = $query->get();

        // $stocks = Stocks::all();
        // $stocks = Stocks::with(['product', 'location'])->get();
        // Add responsible person manually
        foreach ($stocks as $stock) {
            $stock->responsible_person = StockTransfer::where('product_id', $stock->product_id)
                ->where('to_location_id', $stock->location_id)
                ->latest('created_at')
                ->value('responsible_person');
        }





        return view("app.manageStock.view", compact("stocks", "products", "locations"));
    }

    public function destroy($id)
    {
        $stock = Stocks::findOrFail($id);
        $stock->delete();

        return redirect()->back()->with('success', 'Stock deleted successfully.');
    }
    public function export(Request $request)
    {
        $selectedIds = $request->input('selected_ids');

        // Check empty or empty string
        if (empty($selectedIds) || $selectedIds === '') {
            return redirect()->back()->with('error', 'Please select at least one stock to export.');
        }

        if (is_string($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
        }

        $format = $request->input('format');
        $query = Stocks::with(['product', 'location'])->whereIn('id', $selectedIds);
        $stocks = $query->get();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('export.stock_pdf', compact('stocks'));
            return $pdf->download('stock_report.pdf');
        }

        if ($format === 'excel') {
            return Excel::download(new StockExport($stocks), 'stock_report.xlsx');
        }

        return redirect()->back();
    }


}
