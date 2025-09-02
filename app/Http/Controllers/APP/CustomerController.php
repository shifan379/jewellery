<?php

namespace App\Http\Controllers\App;
use App\Exports\CustomersExport;
use App\Http\Controllers\Controller;


use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

// use Maatwebsite\Excel\Excel;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('app.customer.view', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
            // 'last_name' => 'required',
            // 'email' => 'required',
            // 'phone' => 'required',
            // 'address' => 'required',
            // 'city' => 'required',
            // 'province' => 'required',
            // 'status'=> 'Boolean',
            // 'image' => 'required',

        ]);

        // Prepare customer object
        $customer = new Customer();
        $customer->first_name = $validated['first_name'];
        $customer->last_name = $request->last_name ?? '';
        $customer->email = $request->email ?? '';
        $customer->phone = $request->phone ?? '';
        $customer->address = $request->address ?? '';
        $customer->city = $request->city ?? '';
        $customer->province = $request->province ?? '';
        $customer->status = $request->has('addstatus') ? 1 : 0;



        // Handle image upload

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image && $image->isValid()) {
                $extension = $image->getClientOriginalExtension();
                $baseName = Str::slug($request->first_name ?? 'customers');
                $filename = sprintf(
                    '%s_%s_%s.%s',
                    $baseName,
                    time(),
                    Str::random(6),
                    $extension
                );
                // Make sure the directory exists
                $uploadDir = public_path('storage/customers');
                File::ensureDirectoryExists($uploadDir, 0755, true);

                // Move the file to the directory
                $image->move($uploadDir, $filename);

                // Save the public path
                $customer->image = asset('storage/customers/' . $filename);
            }
        }

        $customer->save();


        return back()->with('success', 'Customer added successfully!');
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        return response()->json($customer);

    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB

        ]);

        // Update fields
        $customer->first_name = $validated['first_name'];
        $customer->last_name = $request->last_name ?? '';
        $customer->email = $request->email ?? '';
        $customer->phone = $request->phone ?? '';
        $customer->address = $request->address ?? '';
        $customer->city = $request->city ?? '';
        $customer->province = $request->province ?? '';
        $customer->status = $request->has('addstatus') ? 1 : 0;


        // $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $extension = $image->getClientOriginalExtension();
                $baseName = Str::slug($customer->first_name ?? 'customer');
                $filename = $baseName . '_' . time() . '_' . Str::random(6) . '.' . $extension;

                $uploadDir = public_path('storage/customers');
                File::ensureDirectoryExists($uploadDir, 0755, true);

                $image->move($uploadDir, $filename);

                $customer->image = asset('storage/customers/' . $filename);
            }
        }

        $customer->save();

        return back()->with('success', 'Customer updated successfully!');


    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return back()->with('success', 'Customer deleted successfully!');
    }

    // public function downloadPdf(Request $request)
    // {
    //     $ids = explode(',', $request->query('ids'));
    //     $customers = Customer::whereIn('id', $ids)->get();

    //     $pdf = Pdf::loadView('exports.customers-pdf', compact('customers'));
    //     return $pdf->download('selected-customers.pdf');
    // }

    public function downloadPdf(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'No Customer selected.');
        }

        $customers = Customer::whereIn('id', $ids)->get();

        $pdf = Pdf::loadView('exports.customers-pdf', compact('customers'));
        return $pdf->download('selected-customers.pdf');
    }


    // public function downloadExcel(Request $request)
    // {
    //     $ids = explode(',', $request->query('ids'));
    //     $customers = Customer::whereIn('id', $ids)->get();

    //     return Excel::download(new CustomersExport($customers), 'selected-customers.xlsx');
    // }

    public function downloadExcel(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'No Customer selected.');
        }

        return Excel::download(new CustomersExport($ids), 'selected-customers.xlsx');
    }


}
