<?php

namespace App\Http\Controllers\APP;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerSheet;
use Illuminate\Http\Request;

class CustomerDueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data =  CustomerSheet::with('customer', 'order')->latest()->get();
        $customers = Customer::select('id', 'first_name')->get();
        return view('app.customer-due.list', compact('data','customers'));
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
        $request->validate([
            'customerID' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $customer = new CustomerSheet();
        $customer->customerID = $request->customerID;
        $customer->amount = $request->amount;
        $customer->type = 'CR';  // Assuming 'CR' is for credit/advance
        $customer->save();

        return redirect()->route('customer-due.index')->with('success', 'Advance added successfully.');
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
    public function update(Request $request)
    {
        //
        $request->validate([
            'customerID' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $customer = CustomerSheet::findOrFail($request->id);
        $customer->customerID = $request->customerID;
        $customer->amount = $request->amount;
        $customer->type = $request->type;  // Assuming 'CR' is for credit/advance
        $customer->save();

        return redirect()->route('customer-due.index')->with('success', 'Advance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function filterBy(Request $request)
    {
        $status = $request->input('status'); // Default to 'CR' if not provided
        $data = CustomerSheet::with('customer', 'order')
            ->where('type', $status)
            ->latest()
            ->get();
          $customers = Customer::select('id', 'first_name')->get();

      $html =  view('app.customer-due.table', compact('data','customers'))->render();
      return response()->json(['html' => $html]);
    }
}
