<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentLogbook;
use App\Models\PosPrinterSettings;
use App\Models\ReturnLog;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\product;
use Illuminate\Http\Request;

class POSController extends Controller
{
    //

    protected $userId;
    // protected $returnActive;

    public function __construct()
    {

        $this->userId = Auth::id() ?? 1;
        // $this->returnActive = session()->has('returnEnable') ?? false;

    }


    public function index()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $orderId = 'order_#' . now()->timestamp;
        $carts = Cart::with('product')->where('order_id', $orderId)->get();
        $cust_numbers = Customer::get('phone');
        // Recent Orders
        $recent_orders = Order::with(['transaction', 'items', 'customer'])
            ->whereDate('created_at', $today)
            ->where('cashier_id', $this->userId)
            ->latest()->get();
        // Paybook
        $paybook = PaymentLogbook::where('user_id', $this->userId)
            ->whereDate('created_at', $today)->get();
        $total_sales = Order::with(['transaction', 'items', 'customer'])
            ->whereDate('created_at', $today)
            ->get();

        // Return
        $total_return = ReturnLog::whereDate('created_at', $today)->get();

        // Today's Profit
        $todayProfit = OrderItem::whereHas('order', fn($q) => $q->whereDate('created_at', $today))
            ->with('product')
            ->get()
            ->sum(fn($item) => ($item->net_price - ($item->product->buying_price ?? 0)) * $item->qty);

        // Revenue
       $productRevenue = OrderItem::whereHas('order', fn($q) => $q->whereDate('created_at', $today))
        ->get()
        ->sum(fn($item) => $item->net_price * $item->qty);

         // Cost
        $productCost = OrderItem::whereHas('order', fn($q) => $q->whereDate('created_at', $today))
            ->get()
            ->sum(fn($item) => ($item->product->buying_price ?? 0) * $item->qty);

            $paylog = PaymentLogbook::whereDate('created_at', $today)->get();


        // Items Today
        $todayItems = OrderItem::whereHas('order', fn($q) => $q->whereDate('created_at', $today))->get();

        // 🎯 Top 3 Selling Products Today
        $topProducts = OrderItem::select('productID', DB::raw('SUM(qty) as total_qty'))
            ->whereHas('order', fn($q) => $q->whereDate('created_at', $today))
            ->groupBy('productID')
            ->orderByDesc('total_qty')
            ->with('product')
            ->take(3)
            ->get();

        // 🔁 Yesterday Comparisons
        $yesterday_sales = Order::whereDate('created_at', $yesterday)->sum('total');

        $yesterday_profit = OrderItem::whereHas('order', fn($q) => $q->whereDate('created_at', $yesterday))
            ->with('product')
            ->get()
            ->sum(fn($item) => ($item->net_price - ($item->product->buying_price ?? 0)) * $item->qty);

        $sales_change = $yesterday_sales > 0 ? ($productRevenue - $yesterday_sales) : 0;
        $sales_change_percent = $yesterday_sales > 0 ? ($sales_change / $yesterday_sales) * 100 : 0;

        $profit_change = $yesterday_profit > 0 ? ($todayProfit - $yesterday_profit) : 0;
        $profit_change_percent = $yesterday_profit > 0 ? ($profit_change / $yesterday_profit) * 100 : 0;


        // Take products for search
        $products  = product::get(['product_name','item_code','selling_price','unit']);

        return view('pos.index', compact(
            'orderId',
            'carts',
            'cust_numbers',
            'recent_orders',
            'paybook',
            'total_sales',
            'todayProfit',
            'productRevenue',
            'productCost',
            'total_return',
            'todayItems',
            'topProducts',
            'yesterday_sales',
            'yesterday_profit',
            'sales_change',
            'sales_change_percent',
            'profit_change',
            'profit_change_percent',
            'paylog',
            'products'
        ));
    }



    public function scan(Request $request)
    {
        // Validate input
        $request->validate([
            'barcode' => 'required|string',
        ]);

        $orderID = $request->input('orderID');
        $ItemCode = $request->input('barcode');

        // Fetch products with matching barcode
        $products = Product::with('cate')
            ->where('item_code', $ItemCode)
            ->where('quantity', '>', 0)
            ->get();

        // If no products found or all are out of stock
        if ($products->isEmpty()) {
            return response()->json(['success' => false, 'error' => 'Invalid product barcode or out of stock.']);
        }

        // Single product
        if ($products->count() === 1) {
            return $this->addTocart($products->first(), $orderID);
        }

        // Multiple products
        $productListHtml = view('pos.model-product', compact('products'))->render();
        return response()->json([
            'success' => true,
            'multiple' => true,
            'productListHtml' => $productListHtml,
        ]);
    }


    // Add product(Multiypule ) by ID
    public function addById(Request $request)
    {
        //
        $request->validate([
            'product_id' => 'required|integer',
            'orderID' => 'required',
        ]);

        $product = product::find($request->product_id);

        if (!$product) {
            return response()->json(['error' => 'Product not found']);
        }

        return $this->addTocart($product, $request->orderID);
    }

    public function addTocart($product, $orderID)
    {
        // Logic to add item to cart
        $cartItem = Cart::where('order_id', $orderID)
            ->where('product_id', $product->id)
            ->first();

        // Find existing cart item for this order and product
        if ($cartItem) {
            $cartItem->quantity += 1;
            // If product has a discount, calculate the new net price
            $cartItem->main_sub_total = $cartItem->main_sub_total + $cartItem->net_price;
            $cartItem->main_total = $cartItem->main_sub_total - $cartItem->main_discount;
            $cartItem->save();
        } else {
            $discount = 0;
            $net = $product->selling_price;

            if ($product->discount_amount) {
                $discount = $product->discount_amount;
                $net = $product->selling_price - $discount;
            }
            Cart::create([
                'order_id' => $orderID,
                'product_id' => $product->id,
                'quantity' => 1,
                'discount' => $discount,
                'net_price' => $net,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $this->refreshCart($orderID);

    }

    // Cart increaseQty
    public function increaseQty(Request $request)
    {
        $orderID = $request->order_id;
        $productId = $request->product_id;

        $cartItem = Cart::where('order_id', $orderID)->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        }

        return $this->refreshCart($orderID);

    //     $orderID = $request->order_id;
    // $productId = $request->product_id;
    // $quantity = floatval($request->quantity); // allow decimals

    // $cartItem = Cart::where('order_id', $orderID)->where('product_id', $productId)->first();

    // if ($cartItem && $quantity > 0) {
    //     $cartItem->quantity = $quantity;

    //     // Recalculate net_price & total based on unit type
    //     $product = $cartItem->product;

    //     if ($product->unit == 'g') {
    //         $unitPricePerGram = $product->selling_price / 100; // assume price per 100g
    //         $cartItem->net_price = $unitPricePerGram * $quantity;
    //     } elseif ($product->unit == 'kg') {
    //         $unitPricePerGram = $product->selling_price / 100; // assume price per 100g
    //         $cartItem->net_price = $unitPricePerGram * ($quantity * 1000); // kg to grams
    //     } elseif ($product->unit == 'l') {
    //         $unitPricePerLiter = $product->selling_price; // assume price per 1L
    //         $cartItem->net_price = $unitPricePerLiter * $quantity;
    //     } else {
    //         // pcs
    //         $cartItem->net_price = $product->selling_price * $quantity;
    //     }

    //     // Reapply discount logic if needed
    //     if ($cartItem->discount_type == 'Flat') {
    //         $cartItem->total = $cartItem->net_price - $cartItem->discount;
    //     } elseif ($cartItem->discount_type == 'Percentage') {
    //         $cartItem->total = $cartItem->net_price * (1 - $cartItem->discount / 100);
    //     } else {
    //         $cartItem->total = $cartItem->net_price;
    //     }

    //     $cartItem->save();
    // }

    // return $this->refreshCart($orderID);
    }

    public function decreaseQty(Request $request)
    {
        $orderID = $request->order_id;
        $productId = $request->product_id;

        $cartItem = Cart::where('order_id', $orderID)->where('product_id', $productId)->first();

        if ($cartItem && $cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            $cartItem->save();
        }

        return $this->refreshCart($orderID);
    }

    public function unitCart(Request $request)
    {
        $orderID = $request->order_id;
        $productId = $request->product_id;
        $qty = $request->qty;

        $cartItem = Cart::where('order_id', $orderID)->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->quantity = $qty;
            $cartItem->save();
        }

        return $this->refreshCart($orderID);
    }

    private function refreshCart($orderID)
    {
        $carts = Cart::with('product')->where('order_id', $orderID)->get();

        if ($carts->isEmpty()) {
            return response()->json([
                'cartHtml' => '',
                'amountHtml' => ''
            ]);
        }

        // Separate sale and return items
        $saleItems = $carts->where('return', 0);
        $returnItems = $carts->where('return', 1);

        $main_sub_total = $saleItems->sum('total'); // sale item total
        $main_discount = $saleItems->first()->main_discount ?? 0;

        $return_amount = $returnItems->sum('total'); // total value of returned items
        $main_total = $main_sub_total - $main_discount - $return_amount;

        // Update all cart items
        foreach ($carts as $cart) {
            $cart->update([
                'main_sub_total' => $main_sub_total,
                'main_discount' => $main_discount,
                'main_return_amount' => $return_amount,
                'main_total' => $main_total,
            ]);
        }

        // Render updated views
        $cartView = view('pos.cart', compact('carts'))->render();
        $amountView = view('pos.amount', compact('main_sub_total', 'main_discount', 'return_amount', 'main_total'))->render();

        return response()->json([
            'cartHtml' => $cartView,
            'amountHtml' => $amountView,
        ]);
    }



    public function updateCart(Request $request)
    {
        $request->validate([
            'orderId' => 'required|string',
            'productId' => 'required|exists:products,id',
            'product_price' => 'required|numeric|min:0',
            'qty' => 'required',
            'discount' => 'nullable|numeric|min:0',
        ]);
        $orderID = $request->orderId;

        $cartItem = Cart::where('order_id', $orderID)
            ->where('product_id', $request->productId)
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found.'], 404);
        }

        $qty = (int) $request->qty;
        $price = (float) $request->product_price;
        $discount = (float) $request->discount;
        $type = $request->discount_type;

        // Calculate net price per item
        $net = $price;
        if ($type === 'Percentage') {
            $net = $price - ($price * ($discount / 100));
        } elseif ($type === 'Flat') {
            $net = max(0, $price - $discount); // Prevent negative
        }
        // Update cart fields
        $cartItem->quantity = $qty;
        $cartItem->discount = $discount;
        $cartItem->net_price = $net;
        $cartItem->discount_type = $type;
        $cartItem->updated_at = now();
        $cartItem->save();

        return $this->refreshCart($orderID);

    }

    public function deleteCartProduct(Request $request)
    {
        $request->validate([
            'orderId' => 'required|string',
            'productId' => 'required|exists:products,id',
        ]);

        $orderID = $request->orderId;

        $cartItem = Cart::where('order_id', $orderID)
            ->where('product_id', $request->productId)
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Cart product not found.'], 404);
        }

        $cartItem->delete();

        $carts = Cart::with('product')->where('order_id', $orderID)->get();

        $main_sub_total = $carts->sum('total');
        $main_discount = $carts->first()->main_discount ?? 0;
        $main_total = $main_sub_total - $main_discount;

        // Update all cart items
        Cart::where('order_id', $orderID)->update([
            'main_sub_total' => $main_sub_total,
            'main_discount' => $main_discount,
            'main_total' => $main_total,
        ]);

        $amountView = view('pos.amount', compact('main_sub_total', 'main_discount', 'main_total'))->render();

        return response()->json([
            'message' => 'Product removed from cart.',
            'orderId' => $orderID,
            'productId' => $request->productId,
            'amountHtml' => $amountView, // optional
        ]);


    }

    public function voidCart(Request $request)
    {
        //
        // Delete all cart items matching the order ID
        $deleted = Cart::where('order_id', $request->orderId)->delete();

        if ($deleted === 0) {
            return response()->json([
                'message' => 'No products found for this order.',
            ], 404);
        }

        return response()->json([
            'message' => 'All products for this order have been successfully removed.',
        ]);


    }

    public function mainDiscount(Request $request)
    {
        //
        $orderID = $request->orderID;
        $carts = Cart::with('product')->where('order_id', $orderID)->get();

        $main_sub_total = $carts->sum('total');
        $main_discount = $request->discount_amount ?? 0;
        $main_total = $main_sub_total - $main_discount;

        // Update all cart items
        Cart::where('order_id', operator: $orderID)->update([
            'main_sub_total' => $main_sub_total,
            'main_discount' => $main_discount,
            'main_total' => $main_total,
        ]);

        $cartView = view('pos.cart', compact('carts'))->render();
        $amountView = view('pos.amount', compact('main_sub_total', 'main_discount', 'main_total'))->render();

        return response()->json([
            'cartHtml' => $cartView,
            'amountHtml' => $amountView,
        ]);

    }


    // Payin Add in logbook
    public function payIn(Request $request)
    {
        //

        $payin = new PaymentLogbook();
        $payin->user_id = $this->userId;
        $payin->name = $request->type ?? '';
        $payin->amount = $request->amount ?? 0.00;
        $payin->reason = $request->reson ?? '';
        $payin->save();
        return response()->json([
            'message' => 'Payment Added In LogBook',
        ]);
    }

    public function payOut(Request $request)
    {
        //

        $payin = new PaymentLogbook();
        $payin->user_id = $this->userId;
        $payin->name = $request->type ?? '';
        $payin->amount = $request->amount ?? 0.00;
        $payin->reason = $request->reson ?? '';
        $payin->save();

        return response()->json([
            'message' => 'Payment Added In LogBook',
        ]);

    }

    // Save the Order
    public function saveOrder(Request $request)
    {


        DB::beginTransaction();
        try {

            // Check for cart items
            $find_orderCart = Cart::where('order_id', $request->orderID)->get();
            if ($find_orderCart->isEmpty()) {
                return response()->json(['status' => false, 'message' => 'Cart is empty.'], 400);
            }

            // Generate invoice number
            do {
                $lastOrderId = Order::max('id');
                $nextOrderId = $lastOrderId ? $lastOrderId + 1 : 1;
                $invoiceNo = '#INV' . str_pad($nextOrderId, 4, '0', STR_PAD_LEFT);
            } while (Order::where('invoice_no', $invoiceNo)->exists());

            // Create new order
            $order = new Order();
            $order->invoice_no = $invoiceNo;

            // If customer is provided, verify and assign
            if (!empty($request->customer_number)) {
                $customer = Customer::where('phone', $request->customer_number)->first();
                if ($customer) {
                    $order->customer_id = $customer->id;
                    $order->phone_number = $customer->phone;
                    // You can trigger WhatsApp message here

                } else {
                    $new_customer = new Customer();
                    $new_customer->phone = $request->customer_number;
                    $new_customer->save();
                    $order->customer_id = $new_customer->id;
                    $order->phone_number = $request->customer_number;
                }
            }

            // Assign order values from first cart item (assuming consistent totals)
            $firstCartItem = $find_orderCart->first();
            $order->discount_type = 'Rs .';
            $order->subtotal = (float) $firstCartItem->main_sub_total;
            $order->discount = (float) $firstCartItem->main_discount;
            $order->total = (float) $firstCartItem->main_total;
            $order->sales_type = 'retail'; // default retail
            if ($firstCartItem->main_total > 0) {
                $order->total = (float) $firstCartItem->main_total;
                $order->order_type = 'sale';
            } elseif ($firstCartItem->main_total == 0) {
                $order->order_type = 'exchange';
                $order->total = (float) $firstCartItem->main_total;
                $order->return_amount = (float) $firstCartItem->main_total;
            } else {
                $order->total = 0;
                $order->return_amount = round(abs($firstCartItem->main_total), 2);
                $order->order_type = 'return';
            }
            $order->cashier_id = $this->userId;
            // dd($order->toArray());
            $order->save();

            // Save order items
            foreach ($find_orderCart as $item) {
                $product = Product::find($item->product_id);
                if (!$product)
                    continue; // Skip if product not found

                if ($item->return == 0) {
                    // Normal sale
                    OrderItem::create([
                        'orderID' => $order->id,
                        'productID' => (int) $item->product_id,
                        'qty' => (int) $item->quantity,
                        'net_price' => (float) $item->net_price,
                        'discount' => (float) $item->discount,
                        'total' => (float) $item->total,
                    ]);

                    $product->quantity -= $item->quantity;
                    $product->save();

                } else {
                    // Return item
                    ReturnLog::create([
                        'user_id' => $this->userId,
                        'orderID' => $order->id,
                        'orginal_order_id' => $item->original_order_item_id,
                        'productID' => (int) $item->product_id,
                        'return_qty' => (int) $item->quantity,
                        'return_net_price' => (float) $item->net_price,
                        'discount' => (float) $item->discount,
                        'total' => (float) $item->total,
                    ]);

                    $product->quantity += $item->quantity;
                    $product->save();
                }
            }


            // Generate transaction number
            do {
                $lastTransaction = Transaction::latest('id')->first();
                $nextTransactionId = optional($lastTransaction)->id + 1 ?? 1;
                $transactionNo = '#' . str_pad($nextTransactionId, 4, '0', STR_PAD_LEFT);
            } while (Transaction::where('transaction_no', $transactionNo)->exists());

            // Save transaction
            $total = (float) str_replace(',', '', $request->total_amount ?? '0.00');
            $total_recived = (float) str_replace(',', '', $request->received_amount ?? $total ?? '0.00');

            Transaction::create([
                'transaction_no' => $transactionNo,
                'orderID' => $order->id,
                'total' => $total,
                'total_recived' => $total_recived,
                'change' => (float) ($request->change_amount ?? 0),
                'payment_method' => strip_tags($request->payment_type ?? null),
                'payment_status' => 'Paid',
                'card_number' => $request->credit_card_number ?? null,
            ]);

            // Clear the cart
            Cart::where('order_id', $request->orderID)->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Order saved successfully.',
                'order_id' => $order->id,
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Order Save Error: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }

    }


    // print invoice for POS Printer (80mm)
    public function posPrint(Request $request)
    {
        //Get invoice Data
        $orders = Order::with(['transaction', 'items', 'customer', 'return_data.product_data'])->findOrFail($request->order_id);
        //       return $orders;
        // Get Pos Printer Table Data
        $print_set = PosPrinterSettings::first();

        return view('pos.print.pos-print', compact('orders', 'print_set'));

    }

    public function billTake(Request $request)
    {
        //
        $request->validate([
            'bill_num' => 'required|string',
        ]);
        $invoice_no = $request->input('bill_num');

        $orders = Order::with(['transaction', 'items', 'customer'])->where('invoice_no', $invoice_no)->first();
        if ($orders) {

            $billView = view('pos.return-bill', compact('orders'))->render();

            return response()->json([
                'billHtml' => $billView
            ]);

        } else {
            return response()->json(['success' => false, 'error' => 'Invalid Bill barcode.']);
        }
    }

    public function returnProductToCart(Request $request)
    {
        //
        $request->validate([
            'items' => 'required|array',
            'items.*.orderItemID' => 'required|exists:order_items,id',
            'items.*.qty' => 'required|numeric|min:1',
            'return' => 'required|in:1',
            'orderID' => 'required',
        ]);

        try {
            foreach ($request->items as $item) {
                $orderItem = OrderItem::with('product')->find($item['orderItemID']);
                $orderID = $request->orderID;

                Cart::create([
                    'order_id' => $orderID,
                    'product_id' => $orderItem->productID,
                    'quantity' => $item['qty'],
                    'discount' => $orderItem->discount,
                    'net_price' => $orderItem->net_price,
                    'return' => $request->return,
                    'original_order_item_id' => $orderItem->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return $this->refreshCart($orderID);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Return failed: ' . $e->getMessage()], 500);
        }
    }

    public function returnSave(Request $request)
    {
        //
        DB::beginTransaction();
        try {
            // Check for cart items
            $find_orderCart = Cart::where('order_id', $request->orderID)->get();
            if ($find_orderCart->isEmpty()) {
                return response()->json(['status' => false, 'message' => 'Cart is empty.'], 400);
            }

            // Generate invoice number
            do {
                $lastOrderId = Order::max('id');
                $nextOrderId = $lastOrderId ? $lastOrderId + 1 : 1;
                $invoiceNo = '#INV' . str_pad($nextOrderId, 4, '0', STR_PAD_LEFT);
            } while (Order::where('invoice_no', $invoiceNo)->exists());

            // Create new order
            $order = new Order();
            $order->invoice_no = $invoiceNo;

            // If customer is provided, verify and assign
            if (!empty($request->customer_number)) {
                $customer = Customer::where('phone', $request->customer_number)->first();
                if ($customer) {
                    $order->customer_id = $customer->id;
                    $order->phone_number = $customer->phone;
                    // You can trigger WhatsApp message here
                } else {
                    $new_customer = new Customer();
                    $new_customer->phone = $request->customer_number;
                    $new_customer->save();
                    $order->customer_id = $new_customer->id;
                    $order->phone_number = $request->custNumber;
                }
            }

            // Assign order values from first cart item (assuming consistent totals)
            $firstCartItem = $find_orderCart->first();
            $order->discount_type = 'Rs .';
            $order->subtotal = (float) $firstCartItem->main_sub_total;
            $order->discount = (float) $firstCartItem->main_discount;
            $order->sales_type = 'retail'; // default retail
            if ($firstCartItem->main_total > 0) {
                $order->total = (float) $firstCartItem->main_total;
                $order->order_type = 'sale';
            } elseif ($firstCartItem->main_total == 0) {
                $order->order_type = 'exchange';
                $order->total = (float) $firstCartItem->main_total;
                $order->return_amount = (float) $firstCartItem->main_total;
            } else {
                $order->total = 0;
                $order->return_amount = round(abs($firstCartItem->main_total), 2);
                $order->order_type = 'return';
            }

            $order->cashier_id = $this->userId;
            $order->save();

            // Save order items
            foreach ($find_orderCart as $item) {
                $product = Product::find($item->product_id);
                if (!$product)
                    continue; // Skip if product not found

                if ($item->return == 0) {
                    // Normal sale
                    OrderItem::create([
                        'orderID' => $order->id,
                        'productID' => (int) $item->product_id,
                        'qty' => (int) $item->quantity,
                        'net_price' => (float) $item->net_price,
                        'discount' => (float) $item->discount,
                        'total' => (float) $item->total,
                    ]);

                    $product->quantity -= $item->quantity;
                    $product->save();

                } else {
                    // Return item
                    ReturnLog::create([
                        'user_id' => $this->userId,
                        'orderID' => $order->id,
                        'orginal_order_id' => $item->original_order_item_id,
                        'productID' => (int) $item->product_id,
                        'return_qty' => (int) $item->quantity,
                        'return_net_price' => (float) $item->net_price,
                        'discount' => (float) $item->discount,
                        'total' => (float) $item->total,
                    ]);

                    $product->quantity += $item->quantity;
                    $product->save();
                }
            }

            // Generate transaction number
            do {
                $lastTransaction = Transaction::latest('id')->first();
                $nextTransactionId = optional($lastTransaction)->id + 1 ?? 1;
                $transactionNo = '#' . str_pad($nextTransactionId, 4, '0', STR_PAD_LEFT);
            } while (Transaction::where('transaction_no', $transactionNo)->exists());

            // Save transaction
            $total = (float) str_replace(',', '', $request->total_amount ?? '0.00');
            $total_recived = (float) str_replace(',', '', $request->received_amount ?? $total ?? '0.00');
            Transaction::create([
                'transaction_no' => $transactionNo,
                'orderID' => $order->id,
                'total' => $total,
                'total_recived' => $total_recived,
                'change' => (float) ($request->change_amount ?? 0),
                'payment_method' => strip_tags($request->payment_type ?? 'Cash'),
                'payment_status' => 'Return',
                'card_number' => $request->credit_card_number ?? null,
            ]);

            // Clear the cart
            Cart::where('order_id', $request->orderID)->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Order saved successfully.',
                'order_id' => $order->id,
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Order Save Error: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }


    // print last print
    public function lastReciept(Request $request)
    {
        //Get invoice Data
        $orders = Order::with(['transaction', 'items', 'customer', 'return_data.product_data'])->where('cashier_id', $this->userId)->latest()->first();
        $print_set = PosPrinterSettings::first();

        return view('pos.print.pos-print', compact('orders', 'print_set'));
    }

    public function todayProfit(){
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $total_sales = Order::with(['transaction', 'items', 'customer'])
                            ->whereDate('created_at', $today)
                            ->get();
        // Return
        $total_return = ReturnLog::whereDate('created_at', $today)->get();
        // Today's Profit
        $todayProfit = OrderItem::whereHas('order', fn($q) => $q->whereDate('created_at', $today))
            ->with('product')
            ->get()
            ->sum(fn($item) => ($item->net_price - ($item->product->buying_price ?? 0)) * $item->qty);

        // Revenue
       $productRevenue = OrderItem::whereHas('order', fn($q) => $q->whereDate('created_at', $today))
        ->get()
        ->sum(fn($item) => $item->net_price * $item->qty);

         // Cost
        $productCost = OrderItem::whereHas('order', fn($q) => $q->whereDate('created_at', $today))
            ->get()
            ->sum(fn($item) => ($item->product->buying_price ?? 0) * $item->qty);

        // Items Today
        $todayItems = OrderItem::whereHas('order', fn($q) => $q->whereDate('created_at', $today))->get();

        // 🎯 Top 3 Selling Products Today
        $topProducts = OrderItem::select('productID', DB::raw('SUM(qty) as total_qty'))
            ->whereHas('order', fn($q) => $q->whereDate('created_at', $today))
            ->groupBy('productID')
            ->orderByDesc('total_qty')
            ->with('product')
            ->take(3)
            ->get();

        // 🔁 Yesterday Comparisons
        $yesterday_sales = Order::whereDate('created_at', $yesterday)->sum('total');

        $yesterday_profit = OrderItem::whereHas('order', fn($q) => $q->whereDate('created_at', $yesterday))
            ->with('product')
            ->get()
            ->sum(fn($item) => ($item->net_price - ($item->product->buying_price ?? 0)) * $item->qty);

        $sales_change = $yesterday_sales > 0 ? ($productRevenue - $yesterday_sales) : 0;
        $sales_change_percent = $yesterday_sales > 0 ? ($sales_change / $yesterday_sales) * 100 : 0;

        $profit_change = $yesterday_profit > 0 ? ($todayProfit - $yesterday_profit) : 0;
        $profit_change_percent = $yesterday_profit > 0 ? ($profit_change / $yesterday_profit) * 100 : 0;

        $paylog = PaymentLogbook::whereDate('created_at', $today)->get();
        return view('pos.print.today-profit', compact(
                'total_sales',
                'todayProfit',
                        'productRevenue',
                        'productCost',
                        'total_return',
                        'todayItems',
                        'topProducts',
                        'yesterday_sales',
                        'yesterday_profit',
                        'sales_change',
                        'sales_change_percent',
                        'profit_change',
                        'profit_change_percent',
                        'paylog'
        ));
    }

}
