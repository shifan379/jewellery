<?php

namespace App\Http\Controllers\APP;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\CustomerSheet;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PosPrinterSettings;
use App\Models\product;
use App\Models\ReturnLog;
use App\Models\SalesPrinterSettings;
use App\Models\TodayRate;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
// use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as DB;

class SalesController extends Controller
{


    protected $userId;
    // protected $returnActive;

    public function __construct()
    {

        $this->userId = Auth::id() ?? 1;
        // $this->returnActive = session()->has('returnEnable') ?? false;

    }

    public function index()
    {

        $orderId = 'order_#' . now()->timestamp;
        $carts = Cart::with('product')->where('order_id', $orderId)->get();

        // Fetch customers from the database or any other source
        $customers = Customer::all();
        // Take products for search

        $products  = product::where('quantity', '!=', '0')->get(['product_name','mark','unit','weight']);
        // take today Rate
        $todayRate = TodayRate::with('category')
                        ->where(function ($query) {
                            $query->whereDate('created_at', Carbon::today())
                                ->orWhereDate('updated_at', Carbon::today());
                        })
                        ->get();
                 //       return $todayRate;
        return view('online_orders.addsales', compact('customers', 'carts', 'orderId', 'products', 'todayRate'));
    }


    public function scan(Request $request)
    {
        // Validate the request to ensure 'barcode' is present
        $request->validate([
            'barcode' => 'required|string',
        ]);
        $orderID = $request->input('orderID');

        $ItemCode = $request->input('barcode');
        $product = product::with('cate')->with('rate')
            ->where('mark', $ItemCode)
            ->where('quantity', '>', 0)
            ->get();

        // If no products found or all are out of stock
        if ($product->isEmpty()) {
            return response()->json(['success' => false, 'error' => 'Invalid product barcode or out of stock.']);
        }

        // Single product
        if ($product->count() === 1) {
            return $this->addTocart($product->first(), $orderID);
        }

        // Multiple products
        $productListHtml = view('online_orders.model-product', compact('product'))->render();
        return response()->json([
            'success' => true,
            'multiple' => true,
            'productListHtml' => $productListHtml,
        ]);


    }

    public function addById(Request $request)
    {
        //
        $request->validate([
            'product_id' => 'required|integer',
            'orderID' => 'required',
            'sales_type' => 'required|string|in:retail,wholesale,online',
        ]);

        $product = product::find($request->product_id);

        if (!$product) {
            return response()->json(['error' => 'Product not found']);
        }

        return $this->addTocart($product, $request->orderID);
    }


        // Select price by sales type
        public function addTocart($product, $orderID)
    {
        // Select price by sales type
        $todayRate = $product->rate->rate ?? 0;
        $price =   $product->weight * $todayRate;


        // Determine discount and net price
        if ($product->discount_amount) {
            $discount = $product->discount_amount;
        } else {
            $discount = 0.00;
        }

        $net = $price - $discount;

        // Check if item already exists in the cart
        $cartItem = Cart::where('order_id', $orderID)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // If already in cart, increase quantity and update subtotal
            $cartItem->quantity += 1;
            $cartItem->main_sub_total += $cartItem->net_price;
            $cartItem->main_total = $cartItem->main_sub_total - $cartItem->main_discount;
            $cartItem->save();
        } else {
            // Add new cart item
            Cart::create([
                'order_id'      => $orderID,
                'product_id'    => $product->id,
                'quantity'      => 1,
                'discount'      => $discount,
                'weight'       => $product->weight,
                'net_price'     => $net,
                'sales_type'    => 'retail',
                'main_sub_total' => $net, // initial subtotal
                'act_rate'      => $todayRate,
                'main_discount' => 0,
                'main_total'    => $net,
                'created_at'    => now(),
                'updated_at'    => now(),
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
            //  $cartItem->total = $cartItem->quantity * $cartItem->net_price;
            $cartItem->save();
        }

        return $this->refreshCart($orderID);
    }

    public function decreaseQty(Request $request)
    {
        $orderID = $request->order_id;
        $productId = $request->product_id;

        $cartItem = Cart::where('order_id', $orderID)->where('product_id', $productId)->first();

        if ($cartItem && $cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            //  $cartItem->total = $cartItem->quantity * $cartItem->net_price;
            $cartItem->save();
        }

        return $this->refreshCart($orderID);
    }


    private function refreshCart($orderID)
    {
        $carts = Cart::with('product')->where('order_id', $orderID)->get();

        if ($carts->isEmpty()) {
            return response()->json([
                'card' => '',
                'amount' => ''
            ]);
        }

        // Separate sale and return items
        $saleItems = $carts->where('return', 0);
        $returnItems = $carts->where('return', 1);

        $main_sub_total = $saleItems->sum('total');
        $main_discount = $saleItems->first()->main_discount ?? 0;

        $return_amount = $returnItems->sum('total'); // total value of returned items
        $main_total = $main_sub_total - $main_discount - $return_amount;

        foreach ($carts as $cart) {
            $cart->update([
                'main_sub_total' => $main_sub_total,
                'main_discount' => $main_discount,
                'main_return_amount' => $return_amount,
                'main_total' => $main_total,
            ]);
        }


        $card = view('online_orders.card', compact('carts'))->render();
        $amount = view('online_orders.amount', compact('main_sub_total', 'main_discount', 'main_total', 'return_amount'))->render();

        return response()->json([
            'card' => $card,
            'amount' => $amount,
        ]);
    }
    public function lookupCustomer(Request $request)
    {
        $search = $request->input('phone');

        $customers = Customer::where('phone', 'LIKE', "%{$search}%")
            ->withSum('summer', 'amount')
            ->limit(5)
            ->get(['id', 'first_name', 'last_name', 'phone','customer_nic','address']);
        return response()->json($customers);
    }

    public function lookupCustomerName(Request $request)
    {
        $search = $request->input('name');

        $customers = Customer::where('first_name', 'LIKE', "%{$search}%")
            ->withSum('summer', 'amount')
            ->limit(5)
            ->get(['id', 'first_name', 'last_name', 'phone','customer_nic','address']);
        return response()->json($customers);
    }

    //   // Save the Order
    public function saveOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $orders = Order::with(['transaction', 'items.product', 'customer', 'return_data.product_data'])
                                ->find($request->orderID);
            if(!empty($orders)){
              //  return $orders;
                $orders->delete();
            }
            // Check for cart items
            $find_orderCart = Cart::where('order_id', $request->orderID)->get();
            if ($find_orderCart->isEmpty()) {
                return response()->json(['status' => false, 'message' => 'Cart is empty.'], 400);
            }
            // Generate invoice number
            do {
                $lastOrder = Order::latest('id')->first();
                $nextOrderId = optional($lastOrder)->id + 1 ?? 1;
                $invoiceNo = '#INV' . str_pad($nextOrderId, 4, '0', STR_PAD_LEFT);
            } while (Order::where('invoice_no', $invoiceNo)->exists());

            // Create new order
            $order = new Order();
            $order->invoice_no = $invoiceNo;

            // If customer is provided, verify and assign
            if (!empty($request->phone_number)) {
                $customer = Customer::where('phone', $request->phone_number)->first();
                if ($customer) {
                    $order->customer_id     = $customer->id;
                    $order->phone_number    = $customer->phone;
                    $customer->phone        = $request->phone_number;
                    $customer->first_name   = $request->customer_name ?? '';
                    $customer->customer_nic = $request->customer_nic ?? '';
                    $customer->address      = $request->address ?? '';
                    $customer->save();
                } else {
                    $new_customer               = new Customer();
                    $new_customer->phone        = $request->phone_number;
                    $new_customer->first_name   = $request->customer_name ?? '';
                    $new_customer->customer_nic = $request->customer_nic ?? '';
                    $new_customer->address      = $request->address ?? '';
                    $new_customer->save();
                    $order->customer_id         = $new_customer->id;
                    $order->phone_number        = $new_customer->phone;
                }
            }

            // Assign order values from first cart item (assuming consistent totals)
            $firstCartItem = $find_orderCart->first();
            $order->subtotal = (int) $firstCartItem->main_sub_total;
            $order->discount = (int) $firstCartItem->main_discount;
            $order->total = (int) $firstCartItem->main_total;
            $order->sales_type = $firstCartItem->sales_type; // default fallback
            $order->discount_type = $firstCartItem->discount_type ?? null;

            if ($firstCartItem->main_total > 0) {
                $order->total = (int) $firstCartItem->main_total;
                $order->order_type = 'sale';
            } elseif ($firstCartItem->main_total == 0) {
                $order->order_type = 'exchange';
                $order->total = (int) $firstCartItem->main_total;
                $order->return_amount = (int) $firstCartItem->main_total;
            } else {
                $order->total = 0;
                $order->return_amount = round(abs($firstCartItem->main_total), 2);
                $order->order_type = 'return';
            }
            $order->cashier_id = $this->userId;
            $order->save();

                /////////////////////////////////////////////////////////////////////// Advance payment -- /////////////////////////////////////////////////////New Updated
            // Add new value
            $customerId = $customer->id ?? $new_customer->id ?? null;
            if ($customerId && !empty($request->phone_number)) {
                // Case 1: Add new balance if fully covered
                if (!empty($request->balance) && $request->total_with_balance <= 0) {
                    CustomerSheet::create([
                        'customerID' => $customerId,
                        'orderId'    => $order->id,
                        'amount'     => $request->balance,
                        'type'       => 'DR',
                    ]);
                }
                // Case 2: Update last balance if partially covered
                elseif (!empty($request->balance) && $request->total_with_balance > 0) {
                    $last_value = CustomerSheet::where('customerID', $customerId)
                        ->latest('id')
                        ->first();
                    if ($last_value) {
                        $last_value->update(['amount' => $request->balance]);
                    }
                }
                // Case 3: Close account if advance payment given
                if (!empty($request->advance_payment)) {
                    $oldAmount = CustomerSheet::where('customerID', $customerId)->sum('amount');
                    CustomerSheet::create([
                        'customerID' => $customerId,
                        'orderId'    => $order->id,
                        'amount'     => abs($oldAmount),
                        'type'       => 'Paid',
                    ]);
                }
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
                        'act_rate' => (float) $item->act_rate,
                        'weight' => (float) $item->weight,
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
                        'return_weight' => (float) $item->weight,
                        'return_net_price' => (float) $item->net_price,
                        'discount' => (float) $item->discount,
                        'total' => (float) $item->total,
                    ]);

                    if($product->id != 1){
                        $product->quantity += $item->quantity;
                    }

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
                // 'total' => (int) $request->total_amount,
                'total' => $total,
                'total_recived' => $total_recived,
                'change' => (int) ($request->change_amount ?? 0),
                'payment_method' => strip_tags($request->payment_type),
                'payment_status' => 'Paid',
                'card_number' => $request->credit_card_number ?? null,
            ]);

            // Clear the cart
            Cart::where('order_id', $request->orderID)->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Payment completed successfully.',
                'order_id' => $order->id,
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Order Save Error: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }

    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'orderId' => 'required|string',
            'productId' => 'required|exists:products,id',
            // 'qty' => 'required',
            'discount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:Flat,Percentage',
        ]);

        $orderID = $request->orderId;

        $cartItem = Cart::where('order_id', $orderID)
            ->where('product_id', $request->productId)
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found.'], 404);
        }

        $qty = 1;
        $discount = (float) ($request->discount ?? 0);
        $discountType = $request->discount_type;

        // Base net price per item (before discount)
        $baseNetPrice = (float) $request->product_price;

        // Calculate price per item after discount
        if ($discountType === 'Percentage') {
            $netPriceAfterDiscount = $baseNetPrice - ($baseNetPrice * ($discount / 100));
        } elseif ($discountType === 'Flat') {
            $netPriceAfterDiscount = max(0, $baseNetPrice - $discount);
        } else {
            $netPriceAfterDiscount = $baseNetPrice;
        }

        // Calculate totals based on discounted price
        $main_sub_total = $baseNetPrice * $qty; // subtotal before product discount
        $product_discount_total = ($baseNetPrice - $netPriceAfterDiscount) * $qty; // discount total for this product line
        $main_total = $main_sub_total - $product_discount_total;

        // Update cart item — note: main_discount is NOT updated here, only discount (product-wise)
        $cartItem->quantity = $qty;
        $cartItem->discount = $discount;
        $cartItem->discount_type = $discountType;
        $cartItem->net_price = $netPriceAfterDiscount; // price per unit after discount
        $cartItem->main_sub_total = $main_sub_total;
        // Do NOT update main_discount here; leave it as is for overall order discount
        // $cartItem->main_discount = $cartItem->main_discount;
        $cartItem->main_total = $main_total;
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


        $amount = view('online_orders.amount', compact('main_sub_total', 'main_discount', 'main_total'))->render();


        return response()->json([
            'message' => 'Product removed from cart.',
            'orderId' => $orderID,
            'productId' => $request->productId,
            'amount' => $amount // optional
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
        Cart::where('order_id', $orderID)->update([
            'main_sub_total' => $main_sub_total,
            'main_discount' => $main_discount,
            'main_total' => $main_total,
        ]);

        $card = view('online_orders.card', compact('carts'))->render();
        $amount = view('online_orders.amount', compact('main_sub_total', 'main_discount', 'main_total'))->render();

        return response()->json([
            'card' => $card,
            'amount' => $amount,
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


    // print invoice for POS Printer (80mm)
    public function salesPrint(Request $request)
    {
        //Get invoice Data
        $orders = Order::with(['transaction', 'items', 'customer'])->findOrFail($request->order_id);
        //   return $orders;
        // Get Pos Printer Table Data
        $print_set = SalesPrinterSettings::first();
        return view('online_orders.print.sales-print', compact('orders', 'print_set'));
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

            //  ReturnLog::create([
            //     'user_id' =>  $this->userId,
            // ]);

            $billView = view('online_orders.return-bill', compact('orders'))->render();

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
                    'weight' => $item['weight'],
                    'discount' => $item['discount'] ?? $orderItem->discount,
                    'net_price' => $item['net_price'] ?? $orderItem->net_price,
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
            $orders = Order::with(['transaction', 'items.product', 'customer', 'return_data.product_data'])
                                ->find($request->orderID);
            if(!empty($orders)){
              //  return $orders;
                $orders->delete();
            }
            // Check for cart items
            $find_orderCart = Cart::where('order_id', $request->orderID)->get();
            if ($find_orderCart->isEmpty()) {
                return response()->json(['status' => false, 'message' => 'Cart is empty.'], 400);
            }

            // Generate invoice number
            do {
                $lastOrder = Order::latest('id')->first();
                $nextOrderId = optional($lastOrder)->id + 1 ?? 1;
                $invoiceNo = '#INV' . str_pad($nextOrderId, 4, '0', STR_PAD_LEFT);
            } while (Order::where('invoice_no', $invoiceNo)->exists());

            // Create new order
            $order = new Order();
            $order->invoice_no = $invoiceNo;

            // If customer is provided, verify and assign
            if (!empty($request->phone_number)) {
                $customer = Customer::where('phone', $request->phone_number)->first();
                if ($customer) {
                    $order->customer_id     = $customer->id;
                    $order->phone_number    = $customer->phone;

                    $customer->phone        = $request->phone_number;
                    $customer->first_name   = $request->customer_name ?? '';
                    $customer->customer_nic = $request->customer_nic ?? '';
                    $customer->address      = $request->address ?? '';
                    $customer->save();
                } else {
                    $new_customer               = new Customer();
                    $new_customer->phone        = $request->phone_number;
                    $new_customer->first_name   = $request->customer_name ?? '';
                    $new_customer->customer_nic = $request->customer_nic ?? '';
                    $new_customer->address      = $request->address ?? '';
                    $new_customer->save();

                    $order->customer_id         = $new_customer->id;
                    $order->phone_number        = $new_customer->phone;
                }
                  // You can trigger WhatsApp message here
            }

            // Assign order values from first cart item (assuming consistent totals)
            $firstCartItem = $find_orderCart->first();
            $order->discount_type = 'Rs .';
            $order->subtotal = (float) $firstCartItem->main_sub_total;
            $order->discount = (float) $firstCartItem->main_discount;
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

             /////////////////////////////////////////////////////////////////////// Advance payment -- /////////////////////////////////////////////////////New Updated
            // Add new value
            $customerId = $customer->id ?? $new_customer->id ?? null;
            if ($customerId && !empty($request->phone_number)) {
                // Case 1: Add new balance if fully covered
                if (!empty($request->balance) && $request->total_with_balance <= 0) {
                    CustomerSheet::create([
                        'customerID' => $customerId,
                        'orderId'    => $order->id,
                        'amount'     => $request->balance,
                        'type'       => 'DR',
                    ]);
                }
                // Case 2: Update last balance if partially covered
                elseif (!empty($request->balance) && $request->total_with_balance > 0) {
                    $last_value = CustomerSheet::where('customerID', $customerId)
                        ->latest('id')
                        ->first();
                    if ($last_value) {
                        $last_value->update(['amount' => $request->balance]);
                    }
                }
                // Case 3: Close account if advance payment given
                if (!empty($request->advance_payment)) {
                    $oldAmount = CustomerSheet::where('customerID', $customerId)->sum('amount');
                    CustomerSheet::create([
                        'customerID' => $customerId,
                        'orderId'    => $order->id,
                        'amount'     => abs($oldAmount),
                        'type'       => 'Paid',
                    ]);
                }
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


            // Save order items
            foreach ($find_orderCart as $item) {
                 $product = Product::find($item->product_id);
                if (!$product)
                    continue; // Skip if product not found
                if ($item->return == 0) {
                    OrderItem::create([
                        'orderID' => $order->id,
                        'productID' => (int) $item->product_id,
                        'qty' => (int) $item->quantity,
                        'net_price' => (float) $item->net_price,
                        'discount' => (float) $item->discount,
                        'total' => (float) $item->total,
                        'weight' => (float) $item->weight,
                    ]);
                        $product->quantity -= $item->quantity;
                        $product->save();
                } else {
                    ReturnLog::create([
                        'user_id' => $this->userId,
                        'orderID' => $order->id,
                        'orginal_order_id' => $item->original_order_item_id,
                        'productID' => (int) $item->product_id,
                        'return_qty' => (int) $item->quantity,
                        'return_net_price' => (float) $item->net_price,
                        'discount' => (float) $item->discount,
                        'total' => (float) $item->total,
                        'return_weight' => (float) $item->weight,
                    ]);

                    if($product->id != 1){
                        $product->quantity += $item->quantity;
                    }
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
            Transaction::create([
                'transaction_no' => $transactionNo,
                'orderID' => $order->id,
                'total' => (float) $request->total_amount ?? 00,
                'total_recived' => (float) ($request->received_amount ?? $request->total_amount ?? 00),
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







}
