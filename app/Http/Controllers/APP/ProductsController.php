<?php

namespace App\Http\Controllers\APP;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Mail\LowstockProductListMail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Location;
use App\Models\product as Product;
use App\Models\Service;
use App\Models\Stocks;
use App\Models\SubCategory;
use App\Models\Unit;
use App\Models\Variant;
use App\Models\Warranty;

use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\isEmpty;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
      $products = Product::with(['cate', 'supply'])->where('quantity', '!=', '0')->latest()
                    ->get();
        $catgeories = Category::latest()->get();
        $location = Location::latest()->get();

        return view("app.products.list", compact("products", "catgeories", "location"));
    }

    // Product Fillter function
    public function filterByCategory(Request $request)
    {
        $categoryName = $request->category;
        $category = Category::where('category', $categoryName)->first();

        $products = [];
        if ($category) {
            $products = Product::with('cate', 'supply')
                ->where('category', $category->id)
                ->latest()
                ->get();
        }

        // Return only the table rows as HTML
        $html = view('app.products.table', compact('products'))->render();
        return response()->json(['html' => $html]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::where('status', 1)
            ->orderBy('category')
            ->get();
        $units = Unit::all();
        $locations = Location::where('status', 1)
            ->orderBy('name')
            ->get();

        return view('app.products.create', compact('categories', 'units', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Handle image upload and get URLs

        // Common fields for both single and variants
        $baseData = [
            'product_name' => $request->product_name,
            'prefix' => $request->prefix ?? '',
            'category' => $request->category,
            'sub_category' => $request->sub_category,
            // 'wholesale_price' => $request->wholesale_price ?? 0.00,
            'location' => $request->location,
            'unit' => $request->unit,
            // 'images' => $imagesJson,
            // Custome Fileds
        ];

        // Variants
            $count = count($request->quantity ?? []);
            for ($i = 0; $i < $count; $i++) {
                $variantData = array_merge($baseData, [
                    'product_type' => 0,
                    'mark' => $request->mark[$i] ?? 0,
                    'quantity' => $request->quantity[$i] ?? 0,
                    'buying_price' => $request->buying_price[$i] ?? 0.00,
                    'item_code' => $request->item_code[$i] ?? 0.00,
                    'weight' => $request->weight[$i] ?? 0.00,
                ]);
                $variant = Product::create($variantData);

                // product::create($variantData);

                // 🔄 Add each variant to stock table
                Stocks::updateOrCreate(
                    [
                        'product_id' => $variant->id,
                        'location_id' => $request->location,

                    ],
                    [
                        'product_id' => $variant->id,
                        'location_id' => $request->location,
                        'stock' => $variant->quantity,
                    ]
                );
            }


        return redirect()
            ->route('product.index')
            ->with('success', 'Product(s) added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $product = Product::with(['cate', 'warranty_item'])->findOrFail($id);
        $generator = new BarcodeGeneratorHTML();
        return view('app.products.view', compact('product', 'generator'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $product = Product::with(['cate', 'warranty_item'])->with('supply')->findOrFail($id);
        $categories = Category::all();
        $units = Unit::all();
        $subCategories = SubCategory::all();
        $locations = Location::all();

        return view('app.products.edit', compact('categories', 'units', 'locations','subCategories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $commonData = [
            'product_name' => $request->product_name,
            'prefix' => $request->prefix ?? '',
            'category' => $request->category,
            'sub_category' => $request->sub_category,
            'location' => $request->location,
            'unit' => $request->unit,
            'quantity' => $request->quantity ?? 0,
            'buying_price' => $request->buying_price ?? 0.00,
            'weight' => $request->weight ?? 0.00,
        ];

        $product->update($commonData);

        // 🔄 Update or Create Stock record
        Stocks::updateOrCreate(
            [
                'product_id' => $product->id,
                'location_id' => $product->location,
            ],
            [
                'stock' => $product->quantity,
            ]
        );

        return redirect()
            ->route('product.index')
            ->with('success', 'Product updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $product = Product::findOrFail($request->id);
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully!');
    }


    // custo

    public function nextItemCode(Request $request)
    {
        $lastProduct = Product::where('prefix', $request->val)
            ->orderBy('item_code', 'desc')
            ->first();

        $nextId = $lastProduct ? $lastProduct->item_code + 1 : 1;

        // Format with leading zeros (always 4 digits)
        $autoItemCode = str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return response()->json(['code' => $autoItemCode]);
    }

    // AI Image GEN
    public function generateAiImage(Request $request)
    {
        try {
            $response = Http::post(config('python.url') . '/generate', [
                'prompt' => "Product photo: " . $request->input('product_name'),
                'negative_prompt' => 'blurry, low quality, text, watermark',
                'width' => 512,
                'height' => 512
            ]);

            if ($response->successful()) {
                $imageData = $response->json()['image'];
                // Save image to storage
                $path = 'products/' . time() . '.png';
                Storage::put($path, base64_decode($imageData));

                return response()->json(['path' => $path]);
            }

            return response()->json(['error' => 'Generation failed'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Export to excel
    public function exportSelected(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'No products selected.');
        }

        return Excel::download(new ProductsExport($ids), 'products_lists.xlsx');
    }


    public function exportSelectedPdf(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'No products selected.');
        }

        $products = Product::with('locationRelation')->whereIn('id', $ids)->get();

        $pdf = Pdf::loadView('export.products_pdf', compact('products'));
        return $pdf->download('Products-list.pdf');
    }


    // Expired Product List
    public function expiredProducts()
    {

        $products = Product::with('cate')->with('supply')->where('expiry_date', '<', Carbon::today())->latest()->get();
        $catgeories = Category::latest()->get();
        $location = Location::latest()->get();

        return view("app.products.expired-product", compact("products", "catgeories", "location"));
    }

    public function expiredFilterByCategory(Request $request)
    {

        $categoryName = $request->category;
        $category = Category::where('category', $categoryName)->first();

        $products = [];
        if ($category) {
            $products = Product::with('cate', 'supply')
                ->where('category', $category->id)
                ->where('expiry_date', '<', Carbon::today())
                ->latest()
                ->get();
        }
        // Return only the table rows as HTML
        $html = view('app.products.expired-table', compact('products'))->render();
        return response()->json(['html' => $html]);
    }

    public function restoreProduct(Request $request)
    {

        // Format date helper
        $formatDate = function ($date) {
            return $date ? Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d') : null;
        };
        $product = Product::find($request->id);
        $product->product_name = $request->product_name;
        $product->manufacturer_date = $formatDate($request->manufacturer_date);
        $product->expiry_date = $formatDate($request->expiry_date);
        $product->save();
        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function lowStockProducts()
    {
        //
        $products = Product::with(['cate', 'supply'])
            ->whereRaw('quantity <= quantity_alert * 2')
            ->latest()
            ->get();
        $OutProducts = Product::with(['cate', 'supply'])
            ->where('quantity', '<=', 0)
            ->latest()
            ->get();

        $catgeories = Category::latest()->get();
        $location = Location::latest()->get();

        return view("app.products.low-stock", compact("products", "catgeories", "location", 'OutProducts'));
    }
    public function stockSendMail(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'No products selected.');
        }

        $products = Product::whereIn('id', $ids)->get();

        // Generate the PDF content as a string
        $pdf = Pdf::loadView('export.products_pdf', compact('products'));
        $pdfContent = $pdf->output();

        // Send email to admin
        Mail::to('nithurshan002@gmail.com')->send(new LowstockProductListMail($pdfContent));

        return redirect()->back()->with('success', 'Email sent successfully to admin.');
    }

    // Low Stock Edit Product list
    public function lowStockProductsEdit(Request $request)
    {

        $product = Product::find($request->id);
        $product->product_name = $request->product_name;
        $product->quantity = $request->quantity ?? 0;
        $product->quantity_alert = $request->quantity_alert ?? 0;
        $product->save();
        return redirect()->back()->with('success', 'The product has been restocked and is now available in your inventory.');
    }
}
