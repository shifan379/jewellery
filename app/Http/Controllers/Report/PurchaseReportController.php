<?php

namespace App\Http\Controllers\Report;

use App\Exports\FilteredPurchaesExport;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Exports\SalesReportExport;
use App\Exports\FilteredSalesExport;
use App\Exports\FilteredSalesExportByDate;
use App\Models\Location;
use App\Models\Order;
use App\Models\product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class PurchaseReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $purchase = Purchase::with(['supplier', 'items'])->latest()->get();

        $suppliers = Supplier::all();
      //  return $purchase;
        return view('report.purchase-report',compact('purchase','suppliers'));
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


        return Excel::download(new \App\Exports\PurchaseReportExport,'purchase_report.xlsx');
    }


    public function filterByProducts(Request $request)
    {
        $supplierId = $request->supplierId;
        $dateRange = $request->date_range;

        // Parse the date range
        [$start, $end] = explode(' - ', $dateRange);
        $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($start))->startOfDay();
        $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($end))->endOfDay();

        return Excel::download(new FilteredPurchaesExport($supplierId, $startDate, $endDate), 'purchase_sales.xlsx');
    }




}
