<?php

namespace App\Http\Controllers\APP;

use App\Http\Controllers\Controller;
use App\Models\Warranty;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $warranties = Warranty::latest()->get();
        return view('app.warranty.list', compact('warranties'));
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
        $warrenty =  new Warranty();
        $warrenty->warranty = $request->warranty;
        $warrenty->description = $request->description;
        $warrenty->duration = $request->duration;
        $warrenty->period = $request->period;
        $warrenty->save();
        return redirect()->back()->with('success', 'New Warrenty created successfully.');


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
        $warranty = Warranty::find($request->id);
        $warranty->warranty = $request->warranty;
        $warranty->description = $request->description;
        $warranty->duration = $request->duration;
        $warranty->period = $request->period;
        $warranty->save();
        return redirect()->back()->with('success', 'Warranty updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $warranty = Warranty::find($request->id);
        $warranty->delete();
        return redirect()->back()->with('success','Warranty deleted successfully.');
    }
}
