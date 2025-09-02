<?php

namespace App\Http\Controllers\APP;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $units = Unit::with('product_count')->get();
        return view('app.unit.list', compact('units'));
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
        $unit =  new Unit();
        $unit->name = $request->name;
        if($request->status == 'on') {
            $unit->status =  1;
        }else{
            $unit->status = 0;
        }
        $unit->save();
        return redirect()->back()->with('success', 'Unit created successfully.');

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
        $unit = Unit::findOrFail($request->id);
        $unit->name = $request->name;
        if($request->status == 'on') {
            $unit->status =  1;
        }else{
            $unit->status = 0;
        }
        $unit->save();
        return redirect()->back()->with('success', 'Unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $unit = Unit::findOrFail($request->id);
        $unit->delete();
        return redirect()->back()->with('success', 'Unit deleted successfully.');
    }


    /**
     * Filter units by status.
     */
    public function filterByStatus(Request $request)
    {
         $status = $request->status;

        $units = [];
        if ($status !== null) {
            $units = Unit::with('product_count')->where('status', $status)->latest()
                ->get();
        }

        // Return only the table rows as HTML
        $html = view('app.unit.table', compact('units'))->render();
        return response()->json(['html' => $html]);
    }
}
