<?php

namespace App\Http\Controllers\Report;

use App\Exports\SalesReportExport;
use App\Exports\FilteredSalesExport;
use App\Exports\FilteredSalesExportByDate;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Order;
use App\Models\product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SalesReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $orders = Order::with(['transaction', 'items', 'customer'])
            ->latest()->get();
        $locations = Location::all();
        $products = product::all();
        return view('report.sales-report',compact('orders','locations','products'));
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
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }

    public function exportExecl()
    {


        return Excel::download(new SalesReportExport,'sales_report.xlsx');
    }
    public function getProductsByLocation(Request $request)
    {
       $locationId = $request->location_id;
        if ($locationId == 'all') {
            $products = product::all();
        } else {
            $products = product::where('location', $locationId)->get();
        }

        return response()->json($products);
    }

    public function filterByProducts(Request $request)
    {
        $productId = $request->productID;
        $dateRange = $request->date_range;

        // Parse the date range
        [$start, $end] = explode(' - ', $dateRange);
        $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($start))->startOfDay();
        $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($end))->endOfDay();

        return Excel::download(new FilteredSalesExport($productId, $startDate, $endDate), 'product_sales.xlsx');
    }


    public function filterByDate(Request $request)
    {
         $dateRange = $request->date_range;

        // Parse the date range
        [$start, $end] = explode(' - ', $dateRange);
        $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($start))->startOfDay();
        $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($end))->endOfDay();

        return Excel::download(new FilteredSalesExportByDate($startDate, $endDate), 'sales_report.xlsx');
    }

}
