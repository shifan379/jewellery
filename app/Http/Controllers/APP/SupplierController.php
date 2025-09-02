<?php

namespace App\Http\Controllers\App;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuppliersExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    //
    public function index()
    {
        $suppliers = Supplier::all();
        return view('app.supplier.view', compact('suppliers'));
    }

    public function create()
    {
        return view('app.purchase.supplier'); // or wherever your separate view file is
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required',
            // 'email' => 'required',
            // 'phone' => 'required',
            // 'address' => 'nullable',
            // 'bank_name' => 'required',
            // 'bank_acc_no' => 'required',
            // 'status' => 'boolean',
            // 'image' => 'required|image|max:2048'
        ]);

        // Prepare customer object
        $suppliers = new Supplier();
        $suppliers->company_name = $validated['company_name'];
        $suppliers->email = $request->last_name ?? '';
        $suppliers->phone = $request->phone ?? '';
        $suppliers->address = $request->address ?? '';
        $suppliers->bank_name = $request->bank_name ?? '';
        $suppliers->bank_acc_no = $request->bank_acc_no ?? '';
        // $suppliers->status = $request->status ?? '';
        $suppliers->status = $request->has('addstatus') ? 1 : 0;

        // if ($request->hasFile('image')) {
        //     $image = $request->file('image')->store('suppliers', 'public');
        //     $data['image'] = $image;
        // }

        // Supplier::create($data);
        // $suppliers = supplier::create($validated);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image && $image->isValid()) {
                $extension = $image->getClientOriginalExtension();
                $baseName = Str::slug($request->company_name ?? 'suppliers');
                $filename = sprintf(
                    '%s_%s_%s.%s',
                    $baseName,
                    time(),
                    Str::random(6),
                    $extension
                );
                // Make sure the directory exists
                $uploadDir = public_path('storage/suppliers');
                File::ensureDirectoryExists($uploadDir, 0755, true);

                // Move the file to the directory
                $image->move($uploadDir, $filename);

                // Save the public path
                $suppliers->image = asset('storage/suppliers/' . $filename);
            }
        }



        $suppliers->save();

        // 👇 Conditional redirect
        if ($request->input('redirect_from') === 'supplier_form') {
            return redirect()->route('purchase')->with('success', 'Supplier added Successfully Now you can Add your Purchase');
        }

        return back()->with('success', 'Supplier added Successfully');
    }

    public function show($id)
    {
        $suppliers = Supplier::findOrFail($id);

        return response()->json($suppliers);

    }


    public function update(Request $request, $id)
    {
        $suppliers = Supplier::findOrFail($id);

        $validated = $request->validate([
            'company_name' => 'required',

        ]);


        $suppliers->company_name = $validated['company_name'];
        $suppliers->email = $request->last_name ?? '';
        $suppliers->phone = $request->phone ?? '';
        $suppliers->address = $request->address ?? '';
        $suppliers->bank_name = $request->bank_name ?? '';
        $suppliers->bank_acc_no = $request->bank_acc_no ?? '';
        // $suppliers->status = $request->status ?? '';
        $suppliers->status = $request->has('addstatus') ? 1 : 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $extension = $image->getClientOriginalExtension();
                $baseName = Str::slug($suppliers->company_name ?? 'suppliers');
                $filename = $baseName . '_' . time() . '_' . Str::random(6) . '.' . $extension;

                $uploadDir = public_path('storage/suppliers');
                File::ensureDirectoryExists($uploadDir, 0755, true);

                $image->move($uploadDir, $filename);

                $suppliers->image = asset('storage/suppliers/' . $filename);
            }
        }

        $suppliers->save();

        return back()->with('success', 'Supplier updated successfully!');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return back()->with('success', 'Supplier deleted successfully!');
        // $supplier->delete();
        // return back()->with('success', 'Supplier deleted');
    }

    public function downloadPdf(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'No Supplier selected.');
        }

        $suppliers = Supplier::whereIn('id', $ids)->get();

        $pdf = Pdf::loadView('export.suppliers_pdf', compact('suppliers'));
        return $pdf->download('selected-suppliers.pdf');
    }


    public function downloadExcel(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'No Supplier selected.');
        }

        return Excel::download(new SuppliersExport($ids), 'selected-suppliers.xlsx');
    }


}
