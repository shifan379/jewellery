<?php

namespace App\Http\Controllers\APP;

use App\Exports\LocationExport;
use App\Http\Controllers\Controller;
use App\Models\Location;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::withCount('products')->get();
       // // return $locations;
        return view('app.location.view', compact('locations'));

        // $locations = Location::all();
        // return view('app.location.view', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // return view('app.location.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required',


        ]);

        // Prepare customer object
        $location = new Location();
        $location->name = $validated['name'];
        $location->contact_person = $request->contact_person ?? '';
        $location->phone = $request->phone ?? '';
        $location->status = $request->has('addstatus') ? 1 : 0;


        $location->save();


        return back()->with('success', 'Customer added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $location = Location::findOrFail($id);

        return response()->json($location);
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
    public function update(Request $request, $id)
    {
        //
        $location = Location::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB

        ]);

        // Update fields
        $location->name = $validated['name'];
        $location->contact_person = $request->contact_person ?? '';
        $location->phone = $request->phone ?? '';
        $location->status = $request->has('addstatus') ? 1 : 0;

        $location->save();

        return back()->with('success', 'Location updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Location::destroy($id);
        return back()->with('success', 'Location deleted.');

    }

    public function downloadPdf(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'No location selected.');
        }

        $location = Location::whereIn('id', $ids)->get();

        $pdf = Pdf::loadView('export.locations-pdf', compact('location'));
        return $pdf->download('selected-locations.pdf');

    }

    public function downloadExcel(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'No Location selected.');
        }

        return Excel::download(new LocationExport($ids), 'selected-locations.xlsx');
    }


}
