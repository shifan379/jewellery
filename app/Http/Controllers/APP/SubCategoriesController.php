<?php

namespace App\Http\Controllers\APP;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::get();
        $subCategories = SubCategory::with('category')->get();



        return view("app.subcategory.list", compact("categories", "subCategories"));

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
      //  return $request;
        $sub =  new SubCategory();
        $sub->cat_id = $request->cat_id;
        $sub->subcategory = $request->subcategory;
        if($request->status == 'on') {
            $sub->status =  1;
        }else{
            $sub->status = 0;
        }
        if($sub->save()) {
            return redirect()->route('sub-categories.index')->with('success','Sub Category created successfully');
        }

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
    public function update(Request $request )
    {
        //
        $sub = SubCategory::findOrFail($request->id);
        $sub->cat_id = $request->cat_id;
        $sub->subcategory = $request->subcategory;
        if($request->status == 'on') {
            $sub->status =  1;
        }else{
            $sub->status = 0;
        }
        if($sub->save()) {
            return redirect()->route('sub-categories.index')->with('success','Sub Category updated successfully');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function filterByCategory(Request $request)
    {
        $id = $request->id;
        $subCategories = [];
        if ($id !== null) {
            $subCategories = SubCategory::with('category')->where('cat_id', $id)->latest()
                ->get();
        }
        // Return only the table rows as HTML
        $html = view('app.subcategory.table', compact('subCategories'))->render();
        return response()->json(['html' => $html]);
    }
    public function filterByStatus(Request $request)
    {
        $status = $request->status;

        $subCategories = [];
        if ($status !== null) {
            $subCategories = SubCategory::with('category')->where('status', $status)->latest()
                ->get();
        }
        // Return only the table rows as HTML
        $html = view('app.subcategory.table', compact('subCategories'))->render();
        return response()->json(['html' => $html]);
    }
}
