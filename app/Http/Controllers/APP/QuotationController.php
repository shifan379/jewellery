<?php

namespace App\Http\Controllers\APP;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\product;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\SalesPrinterSettings;
use DB;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        $products = Product::all();
        $quotations = Quotation::with('customer', 'items.product')->get();
        $quotation_items = QuotationItem::all();
        return view('app.quotation.index', compact('customers', 'products', 'quotations', 'quotation_items'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Scan product by barcode (like POS).
     */
    public function scan(Request $request)
    {
        $request->validate(['barcode' => 'required|string']);

        $product = Product::with('rate')->where('item_code', $request->barcode)
            ->where('quantity', '>', 0)
            ->first();

        if (!$product) {
            return response()->json(['success' => false, 'error' => 'Invalid product or out of stock']);
        }
        $todayRate = $product->rate->rate ?? 0;
        $price =   $product->weight * $todayRate;

        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->product_name,
                'unit' => $product->unit,
                'price' => $price,
                'weight' => $product->weight,
            ]
        ]);
    }

    /**
     * Fetch product by ID (used in dropdown select).
     */
    public function addById(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $product = product::find($request->product_id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'id' => $product->id,
            'name' => $product->product_name,
            'quantity' => $product->quantity, // stock quantity
            'discount' => $product->discount_amount ?? 0,
            'unit' => $product->unit ?? '', // optional if you have unit column
            'price' => $product->selling_price, // selling price
            'buying_price' => $product->buying_price,
        ]);
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Save quotation with its items.
     */
    // public function store(Request $request)
    // {
    //     DB::beginTransaction();

    //     try {
    //         // Save Quotation
    //         $quotation = Quotation::create([
    //             'customer_id' => $request->customer_id,
    //             'date' => $request->date,
    //             'reference' => $request->reference ?? '',
    //             'discount' => $request->discount ?? 0,
    //             'total_amount' => $request->subtotal ?? 0,
    //             // 'shipping' => $request->shipping ?? 0,
    //             // 'status' => $request->status,
    //         ]);

    //         // Save Quotation Items
    //         $productIds = $request->input('product_id', []);
    //         $quantities = $request->input('quantity', []);
    //         $prices = $request->input('purchase_price', []);
    //         $discounts = $request->input('discount', []);
    //         $unitCosts = $request->input('unit_cost', []);
    //         $totalCosts = $request->input('total_cost', []);

    //         foreach ($productIds as $index => $productId) {
    //             if (!$productId)
    //                 continue; // skip empty rows
    //             QuotationItem::create([
    //                 'quotation_id' => $quotation->id,
    //                 'product_id' => $productId,
    //                 'quantity' => $quantities[$index] ?? 0,
    //                 'purchase_price' => $prices[$index] ?? 0,
    //                 'discount' => $discounts[$index] ?? 0,
    //                 'unit_cost' => $unitCosts[$index] ?? 0,
    //                 'total_cost' => $totalCosts[$index] ?? 0,
    //             ]);
    //         }

    //         DB::commit();
    //         // 🔹 Redirect to print page instead of back
    //         return redirect()->route('quotation.print', $quotation->id);
    //         // return redirect()->back()->with('success', 'Quotation created successfully!');

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    //     }
    // }


    // Store quotation

    // public function store(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $quotation = Quotation::create([
    //             'customer_id' => $request->customer_id,
    //             'date' => $request->date,
    //             'reference' => $request->reference ?? '',
    //             'discount' => $request->main_discount ?? 0,

    //             'total_amount' => $request->subtotal,
    //         ]);
    //         // return $request;

    //         $productIds = $request->product_id ?? [];
    //         $quantities = $request->quantity ?? [];
    //         $prices = $request->purchase_price ?? [];
    //         $discounts = $request->discount ?? [];
    //         $unitCosts = $request->unit_cost ?? [];
    //         $totalCosts = $request->total_cost ?? [];


    //         foreach ($productIds as $i => $pid) {
    //             if (!$pid)
    //                 continue;
    //             QuotationItem::create([
    //                 'quotation_id' => $quotation->id,
    //                 'product_id' => $pid,
    //                 'quantity' => $quantities[$i] ?? 0,
    //                 'purchase_price' => $prices[$i] ?? 0,
    //                 'discount' => $discounts[$i] ?? 0,
    //                 'unit_cost' => $unitCosts[$i] ?? 0,
    //                 'total_cost' => $totalCosts[$i] ?? 0,
    //             ]);
    //         }

    //         DB::commit();
    //         return redirect()->route('quotation.print', $quotation->id);

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $productIds = $request->product_id ?? [];
            $quantities = $request->quantity ?? [];
            $prices = $request->purchase_price ?? [];
            $discounts = $request->discount ?? [];
            $unitCosts = $request->unit_cost ?? [];
            $totalCosts = $request->total_cost ?? [];

            // Step 1: Calculate subtotal from item rows
            $itemsTotal = 0;
            foreach ($productIds as $i => $pid) {
                if (!$pid)
                    continue;
                $itemsTotal += $totalCosts[$i] ?? 0;
            }

            // Step 2: Apply main discount
            $mainDiscount = floatval($request->main_discount ?? 0);
            $grandTotal = $itemsTotal - $mainDiscount;

            // Step 3: Save quotation
            $quotation = Quotation::create([
                'customer_id' => $request->customer_id,
                'date' => $request->date,
                'reference' => $request->reference ?? '',
                'discount' => $mainDiscount,       // store main discount separately
                'total_amount' => $grandTotal,     // store calculated grand total
            ]);


            // Step 4: Save quotation items
            foreach ($productIds as $i => $pid) {
                if (!$pid)
                    continue;
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $pid,
                    'quantity' => $quantities[$i] ?? 0,
                    'purchase_price' => $prices[$i] ?? 0,
                    'discount' => $discounts[$i] ?? 0,
                    'unit_cost' => $unitCosts[$i] ?? 0,
                    'total_cost' => $totalCosts[$i] ?? 0,
                ]);
            }

            DB::commit();
            return redirect()->route('quotation.print', $quotation->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    /**
     * Print Quotation
     */
    public function print($id)
    {
        $quotation = Quotation::with(['items.product', 'customer'])->findOrFail($id);
        $print_set = SalesPrinterSettings::first();

        return view('app.quotation.print.print', compact('quotation', 'print_set'));
    }


    /**
     * Autocomplete search for product name (for typing in input).
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        $products = Product::where('product_name', 'LIKE', "%{$query}%")
            ->where('quantity', '>', 0)
            ->limit(10)
            ->get();

        return response()->json($products);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quotation = Quotation::with(['items.product', 'customer'])->findOrFail($id);
        $quotation_items = QuotationItem::where('quotation_id', $id)->with('product')->get();
        // // Optionally, calculate totals if not stored in DB
        // $quotation->subtotal = $quotation->items->sum(fn($i) => $i->total);
        // $quotation->total = $quotation->subtotal - $quotation->discount;

        return view('app.quotation.view', compact('quotation', 'quotation_items'));
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
    public function destroy(string $id)
    {
        //
    }
}
