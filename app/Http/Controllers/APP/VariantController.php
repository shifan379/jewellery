<?php

namespace App\Http\Controllers\APP;

use App\Models\Variant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $variants = Variant::latest()->get();
        return view('app.variant.list', compact('variants'));
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
            'variant' => 'required|string|max:255',
            'variantValue' => 'required|array',
            'variantValue.*' => 'string|max:255',
        ]);

        $variant = new Variant([
            'name' => $request->input('variant'),
            'values' => json_encode($request->input('variantValue')),
            'status' => $request->has('status') ? $request->status  : 1,
        ]);

        $variant->save();


        return response()->json([
            'variant' => $variant->name,
        ]);
    }

    /**w
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
    public function destroy(Request $request)
    {
        //
        $unit = Variant::findOrFail($request->id);
        $unit->delete();
        return redirect()->back()->with('success', 'Variant deleted successfully.');
    }
}
