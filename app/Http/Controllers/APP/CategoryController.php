<?php

namespace App\Http\Controllers\APP;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\TodayRate;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use \Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::latest()->get();
        return view("app.category.list", compact("categories"));

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
            'category' => 'required|string|max:255',
        ]);

        $cat = new Category();
        $cat->category = $request->category;


        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image && $image->isValid()) {
                $extension = $image->getClientOriginalExtension();
                $baseName = Str::slug($request->category ?? 'category');
                $filename = sprintf(
                    '%s_%s_%s.%s',
                    $baseName,
                    time(),
                    Str::random(6),
                    $extension
                );
                // Make sure the directory exists
                $uploadDir = public_path('storage/categories');
                File::ensureDirectoryExists($uploadDir, 0755, true);

                // Move the file to the directory
                $image->move($uploadDir, $filename);

                // Save the public path
                $cat->images = asset('storage/categories/' . $filename);
            }
        }

        $cat->save();

        return response()->json([
            'status' => 'success',
            'id' => $cat->id,
            'category' => $cat->category,

        ]);


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
      //   return $request->all();
        //
        $category = Category::find($request->id);
        $category->category = $request->category;

        if($request->status == 'on') {
            $category->status =  1;
        }else{
            $category->status = 0;
        }

        if($category->save()){
            return redirect()->back()->with('success','Category is updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $category = Category::with('products')->find($request->id);
        return $category->products()->count() > 0
            ? redirect()->back()->with('error', 'Category cannot be deleted because it has associated products.')
            : $this->deleteCategory($category);
    }

    protected function deleteCategory($category)
    {
        if ($category) {
            $category->delete();
            return redirect()->back()->with('success', 'Category deleted successfully.');
        }
        return redirect()->back()->with('error', 'Category not found.');
    }

    public function subData(Request $request)
    {

        $categoryId = $request->category_id;
        $subcategories = SubCategory::where('cat_id', $categoryId)->get(columns: ['subcategory']);

        return response()->json($subcategories);
    }

    // Fiterby Status
    public function filterByStatus(Request $request)
    {

        $status = $request->status;

        $categories = [];
        if ($status !== null) {
            $categories = Category::where('status', $status)->latest()
                ->get();
        }

        // Return only the table rows as HTML
        $html = view('app.category.table', compact('categories'))->render();
        return response()->json(['html' => $html]);
    }


    public function todayRate()
    {
        //
        $rate = TodayRate::with('category')->with('user')->latest()->get();
        $categories = Category::where('status', 1)->latest()->get();
        return view('app.today-rate.list', compact('categories', 'rate'));

    }

    public function storeTodayRate(Request $request)
    {
        $request->validate([
            'categoryID' => 'required|integer',
            'rate' => 'required|numeric',
        ]);

        $todayRate = new TodayRate();
        $todayRate->categoryID = $request->categoryID;
        $todayRate->rate = $request->rate;
        $todayRate->userID = Auth::user()->id ?? '1';

        if ($todayRate->save()) {
            return redirect()->back()->with('success', 'Today rate saved successfully.');
        }

        return redirect()->back()->with('error', 'Failed to save today rate.');

    }

    public function updateTodayRate(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:today_rates,id',
            'categoryID' => 'required|integer|exists:categories,id',
            'rate' => 'required|numeric',
        ]);

        $todayRate = TodayRate::find($request->id);
        $todayRate->categoryID = $request->categoryID;
        $todayRate->rate = $request->rate;

        if ($todayRate->save()) {
            return redirect()->back()->with('success', 'Today rate updated successfully.');
        }

        return redirect()->back()->with('error', 'Failed to update today rate.');

    }

    public function destroyTodayRate(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $todayRate = TodayRate::find($request->id);
        if ($todayRate) {
            $todayRate->delete();
            return redirect()->back()->with('success', 'Today rate deleted successfully.');
        }

        return redirect()->back()->with('error', 'Today rate not found.');
    }


}
