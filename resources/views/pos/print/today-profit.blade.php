<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Today's Profit Report</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            width: 80mm;
            margin: 0 auto;
            padding: 5px;
            font-size: 14px;
            color: #000;
        }

        h2,
        h4 {
            text-align: center;
            margin: 5px 0;
        }

        .line {
            border-top: 1px dashed #333;
            margin: 6px 0;
        }

         .center {
            text-align: center;
        }

        .receipt-logo {
            width: 200px;
            margin: 0 auto 10px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .section {
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            padding: 6px 4px;
            border-bottom: 1px dashed #ccc;
        }

        th {
            background: #f1f1f1;
            font-weight: bold;
        }

        .total {
            font-weight: bold;
        }

        .highlight {
            background: #f9f9f9;
            font-weight: bold;
        }

        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>

<body onload="window.print()">
    @php
        // use Illuminate\Support\Str;

        // Total Sales Value
        $total_sales_value = $total_sales->sum('total');

        // Total Expense
        $expense = $paylog->filter(fn($book) => $book->name === 'payout')->sum('amount');

        // Total Discount
        $total_discount = $todayItems->sum('discount');

        // Return Amount
        $return_amount = $total_sales->sum('return_amount');

        // Cash In/Out
        $payin = $paylog->filter(fn($book) => $book->name === 'payin')->sum('amount');
        $outflow = $return_amount + $expense;
        $inflow = $total_sales_value + $payin;

        // Profit
        $total_profit = $todayProfit - $expense;
        $net_profit = $total_profit - $total_discount - $return_amount;

        // Payment breakdown
        $cashPayment = $total_sales->sum(
            fn($order) => optional($order->transaction)->payment_method === 'cash' ? $order->transaction->total : 0,
        );
        $cardPayment = $total_sales->sum(
            fn($order) => optional($order->transaction)->payment_method === 'credit' ? $order->transaction->total : 0,
        );
        $onlinePayment = $total_sales->sum(
            fn($order) => optional($order->transaction)->payment_method === 'online' ? $order->transaction->total : 0,
        );

        // Gross Margin
        $grossMargin = $productRevenue > 0 ? ($todayProfit / $productRevenue) * 100 : 0;

        // Cash on Hand (approximate)
        $cashInDrawer = $inflow - $outflow - $cardPayment - $onlinePayment;
    @endphp

    <div class="center">
            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo" class="receipt-logo" />
    </div>
    <h2>🧾 Today's Profit Report</h2>
    <div class="line"></div>

    <div class="section">
        <div class="row"><strong>Total Sale:</strong><span>Rs. {{ number_format($total_sales_value, 2) }}</span></div>
        <div class="row"><strong>Expense:</strong><span>Rs. {{ number_format($expense, 2) }}</span></div>
        <div class="row"><strong>Total Profit:</strong><span>Rs. {{ number_format($total_profit, 2) }}</span></div>
    </div>

    <div class="line"></div>

    <div class="section">
        <h4>📊 Comparison</h4>
        <div class="row"><span>Sales (Yesterday):</span><span>Rs. {{ number_format($yesterday_sales, 2) }}</span>
        </div>
        <div class="row"><span>Sales (Today):</span><span>Rs. {{ number_format($productRevenue, 2) }}</span></div>
        <div class="row"><span>Change:</span><span>{{ number_format($sales_change_percent, 2) }}%</span></div>
        <div class="row"><span>Profit (Yesterday):</span><span>Rs. {{ number_format($yesterday_profit, 2) }}</span>
        </div>
        <div class="row"><span>Profit (Today):</span><span>Rs. {{ number_format($todayProfit, 2) }}</span></div>
        <div class="row"><span>Change:</span><span>{{ number_format($profit_change_percent, 2) }}%</span></div>
    </div>

    <div class="line"></div>

    <div class="section">
        <div class="row"><span>Gross Margin:</span><span>{{ number_format($grossMargin, 2) }}%</span></div>
        <div class="row"><span>Net Profit:</span><span>Rs. {{ number_format($net_profit, 2) }}</span></div>
        <div class="row"><span>Cash Payment:</span><span>Rs. {{ number_format($cashPayment, 2) }}</span></div>
        <div class="row"><span>Card Payment:</span><span>Rs. {{ number_format($cardPayment, 2) }}</span></div>
        <div class="row"><span>Online Payment:</span><span>Rs. {{ number_format($onlinePayment, 2) }}</span></div>
        <div class="row"><span>Product Revenue:</span><span>Rs. {{ number_format($productRevenue, 2) }}</span></div>
        <div class="row"><span>Product Cost:</span><span>Rs. {{ number_format($productCost, 2) }}</span></div>
        <div class="row"><span>Product Profit:</span><span>Rs. {{ number_format($todayProfit, 2) }}</span></div>
        <div class="row"><span>Total Pay-In:</span><span>Rs. {{ number_format($payin, 2) }}</span></div>
        <div class="row"><span>Total Pay-Out:</span><span>Rs.{{ number_format($expense, 2) }}</span></div>
        <div class="row"><span>Total Sell Discount:</span><span>Rs. {{ number_format($total_discount, 2) }}</span>
        </div>
        <div class="row"><span>Total Sale Return:</span><span>Rs. {{ number_format($return_amount, 2) }}</span>
        </div>
        <div class="row"><span>Return Items Value:</span><span>Rs.
                {{ number_format($total_return->sum('total'), 2) }}</span></div>
        <div class="row"><span>Total Cash Outflow:</span><span>Rs. {{ number_format($outflow, 2) }}</span></div>
        <div class="row"><span>Total Cash Inflow:</span><span>Rs. {{ number_format($inflow, 2) }}</span></div>
        <div class="row highlight"><span>Total Cash in Drawer:</span><span>Rs.
                {{ number_format($cashInDrawer, 2) }}</span></div>
    </div>

    <div class="line"></div>

    <h4>🏆 Top 3 Selling Products</h4>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($topProducts as $item)
                <tr>
                    <td>{{ $item->product->product_name ?? 'N/A' }}</td>
                    <td>{{ $item->total_qty }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No sales today</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="line"></div>
    <p style="text-align:center;">--- End of Report ---</p>
    <p style="text-align:center; font-size:12px; margin-top:10px;">
        Powered by <strong>ZB POS Software</strong><br>
        helping your business grow, one easy click at a time.
    </p>

    <script>
        // Redirect after print
        window.onafterprint = function() {
            window.location.href = "{{ route('pos') }}"; // Adjust redirect URL as needed
        };
    </script>
</body>

</html>
