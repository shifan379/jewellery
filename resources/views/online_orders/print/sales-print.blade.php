<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Invoice</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0077cc;
            --primary-dark: #005588;
            --primary-darker: #003366;
            --success: #2e7d32;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.5;
            color: var(--gray-800);
            background: #fff;
            width: 210mm;
            height: 148.5mm;
            margin: auto;
            padding: 10mm 15mm;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            body {
                padding: 10mm 15mm;
            }
        }

        .invoice-container {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 6mm;
        }

        .logo {
            width: 20mm;
            height: 20mm;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2mm;
            font-weight: bold;
            font-size: 5mm;
            background: var(--gray-100);
            color: var(--primary-dark);
        }

        .header h1 {
            font-size: 6mm;
            font-weight: 700;
            color: var(--gray-900);
        }

        .header p {
            font-size: 3.5mm;
            color: var(--gray-600);
        }

        .divider {
            height: 0.5mm;
            background: var(--gray-200);
            margin: 3mm 0;
        }

        .invoice-title {
            font-size: 5mm;
            font-weight: 700;
            text-align: center;
            margin-bottom: 5mm;
            color: var(--gray-900);
        }

        /* Customer Info */
        .customer-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 3mm;
            margin-bottom: 5mm;
        }

        .info-group p:first-child {
            font-size: 3.5mm;
            font-weight: 500;
            color: var(--gray-600);
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 2mm 3mm;
            font-size: 3.5mm;
        }

        th {
            background: var(--gray-50);
            font-size: 3mm;
            font-weight: 600;
            color: var(--gray-600);
            text-transform: uppercase;
        }

        td {
            border-bottom: 0.5mm solid var(--gray-100);
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* Summary */
        .summary {
            background: var(--gray-50);
            border-radius: 2mm;
            padding: 3mm;
            margin: 5mm 0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
        }

        .summary-row.total {
            border-top: 0.5mm solid var(--gray-200);
            margin-top: 2mm;
            padding-top: 2mm;
            font-weight: 600;
            color: var(--primary-darker);
        }

        /* Savings */
        .savings {
            background: #f0fdf4;
            border: 0.5mm solid #dcfce7;
            border-radius: 2mm;
            padding: 2mm;
            text-align: center;
            font-weight: 500;
            color: var(--success);
            margin-bottom: 5mm;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: auto;
            font-size: 3.5mm;
        }

        .footer p:last-child {
            color: var(--gray-500);
            font-size: 3mm;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            @isset($print_set)
                @if ($print_set->logo && $print_set->logo_path)
                    <div class="logo"><img src="{{ $print_set->logo_path }}" alt="Logo" style="max-width:100%; max-height:100%;"></div>
                @else
                    <div class="logo">LOGO</div>
                @endif

                @if (!empty($print_set->header_1))
                    <h1>{{ $print_set->header_1 }}</h1>
                @endif

                @if ($print_set->header_2 || $print_set->header_3 || $print_set->header_4)
                    <p>{!! nl2br(e($print_set->header_2)) !!}<br>
                        {!! nl2br(e($print_set->header_3)) !!}<br>
                        {!! nl2br(e($print_set->header_4)) !!}
                    </p>
                @endif
            @else
                <div class="logo">LOGO</div>
                <h1>Company Name</h1>
                <p>Phone: +1 5656665656<br>Email: example@gmail.com</p>
            @endisset
        </div>

        <div class="divider"></div>

        <!-- Invoice Title -->
        <h2 class="invoice-title">INVOICE</h2>

        <!-- Customer Info -->
        <div class="customer-info">
            <div class="info-group">
                <p>Customer Name</p>
                <p>{{ $orders->customer->first_name ?? 'Walk-in Customer' }}</p>
            </div>
            <div class="info-group">
                <p>Invoice No</p>
                <p>{{ $orders->invoice_no }}</p>
            </div>
            <div class="info-group">
                <p>Date</p>
                <p>{{ $orders->created_at->format('d.m.Y h:i A') }}</p>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Weight</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders->items as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->product->product_name }}</td>
                        <td class="text-center">{{ $item->qty }} pcs</td>
                        <td class="text-right">{{ number_format($item->product->weight, 2) }} {{ $item->product->unit }}</td>
                        <td class="text-right">{{ number_format($item->net_price, 2) }}</td>
                        <td class="text-right">Rs. {{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach

                @if ($orders->return_data->count())
                    <tr>
                        <td colspan="6" style="text-align:center; font-weight:bold; background:#f0f0f0;">OLD GOLD</td>
                    </tr>
                    @php $return_total_value = 0; @endphp
                    @foreach ($orders->return_data as $return)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $return->product_data->product_name }}</td>
                            <td class="text-center">{{ $return->return_qty }} pcs</td>
                            <td class="text-right">{{ number_format($return->return_weight, 2) }} {{ $return->product_data->unit }}</td>
                            <td class="text-right">{{ number_format($return->return_net_price, 2) }}</td>
                            <td class="text-right">Rs. {{ number_format($return->total, 2) }}</td>
                        </tr>
                        @php $return_total_value += $return->total; @endphp
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-row"><span>Sub Total</span><span>Rs. {{ number_format($orders->subtotal, 2) }}</span></div>
            <div class="summary-row"><span>Discount</span><span>- Rs. {{ number_format($orders->discount, 2) }}</span></div>

            @if ($orders->return_data->count())
                <div class="summary-row"><span>Return Deduction</span><span>- Rs. {{ number_format($return_total_value, 2) }}</span></div>
            @endif

            <div class="summary-row total">
                <span>{{ $orders->total == 0 ? 'Net Payable Amount' : 'Total' }}</span>
                <span>Rs. {{ number_format($orders->total == 0 ? $orders->return_amount : $orders->total, 2) }}</span>
            </div>
            @if ($orders->transaction->payment_method == 'cash' || $orders->transaction->payment_method == 'credit')

            @if ($orders->transaction->total_recived >0)
                    <div class="summary-row ">
                        <span>
                            @if ($orders->transaction->payment_method == 'cash')
                                Cash
                            @else
                                Card
                            @endif
                        </span>
                        <span >Rs. {{ number_format($orders->transaction->total_recived, 2) }}</span>
                    </div>
                @endif
                @if ($orders->transaction->change > 0 )
                    <div class="summary-row ">
                        <span>Change</span>
                        <span>Rs. {{ number_format($orders->transaction->change, 2) }}</span>
                    </div>
                @endif
            @endif
             @if ($orders->transaction->total > 0 )
                @if (!empty($orders->customer->summer))
                    @php
                        $customer = App\Models\Customer::find($orders->customer->id);
                        $Previous_due = $customer->summer()
                            ->where('id', '!=', $customer->summer()->latest('id')->value('id'))
                            ->sum('amount');
                        $due = $customer->summer->sum('amount');
                    @endphp

                    @if ($Previous_due != 0)
                        <div class="summary-row ">
                            <span> Previous @if($Previous_due > 0) Balance @else Due @endif</span>
                            <span >Rs. {{ number_format($Previous_due, 2) }}</span>
                        </div>
                    @endif


                    @if ($due > 0)
                        <div class="summary-row ">
                            <span>Available Balance</span>
                            <span class="right">Rs. {{ number_format($due, 2) }}</span>
                        </div>
                    @else
                        @php
                            $due = abs($due);
                            $Previous_due = abs($Previous_due);
                        @endphp
                        <div class="summary-row ">
                            <span>Total Due Amount</span>
                            <span class="right">Rs. {{ number_format($due, 2) }}</span>
                        </div>
                    @endif
                @endif
            @endif
        </div>


        <!-- Barcode -->
        <div class="text-center"><svg id="barcode"></svg></div>

        <div class="divider"></div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for shopping with us!</p>
            <p>Developed by ZB Solutions</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            JsBarcode("#barcode", "INV-{{ $orders->invoice_no }}", {
                format: "CODE128",
                displayValue: true,
                fontSize: 14,
                height: 50,
                margin: 10
            });

            window.onafterprint = () => window.location.href = "{{ route('sales') }}";
        });
    </script>
</body>
</html>
