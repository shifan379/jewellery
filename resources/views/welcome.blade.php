<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Invoice</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-50: #f0f9ff;
            --primary-100: #e0f2fe;
            --primary-500: #0077cc;
            --primary-600: #005588;
            --primary-700: #003366;
            --success-50: #f0fdf4;
            --success-100: #dcfce7;
            --success-500: #2e7d32;
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
            background-color: white;
            width: 210mm;
            /* A4 width */
            height: 148.5mm;
            /* Half A4 height */
            margin: 0 auto;
            padding: 10mm 15mm;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            body {
                padding: 10mm 15mm;
                width: 210mm;
                height: 148.5mm;
                margin: 0 auto;
            }
        }

        /* Invoice Container */
        .invoice-container {
            height: 128.5mm;
            /* 148.5mm - 20mm padding */
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 6mm;
        }

        .logo {
            width: 20mm;
            height: 20mm;
            background-color: var(--primary-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2mm;
            color: var(--primary-600);
            font-weight: bold;
            font-size: 5mm;
        }

        .header h1 {
            font-size: 6mm;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 1mm;
        }

        .header p {
            font-size: 3.5mm;
            color: var(--gray-600);
        }


        .divider {
            height: 0.5mm;
            background-color: var(--gray-200);
            margin: 3mm 0;
        }

        /* Invoice Title */
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
            margin-bottom: 1mm;
        }

        /* Table */
        .table-container {
            margin-bottom: 5mm;
            /* overflow-x: auto; */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th {
            background-color: var(--gray-50);
            text-align: left;
            padding: 2mm 3mm;
            font-size: 3mm;
            font-weight: 600;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td {
            padding: 2mm 3mm;
            font-size: 3.5mm;
            color: var(--gray-800);
            border-bottom: 0.5mm solid var(--gray-100);
            word-wrap: break-word;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* Summary */
        .summary {
            background-color: var(--gray-50);
            border-radius: 2mm;
            padding: 3mm;
            margin-bottom: 5mm;
        }

        .summary-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 3mm;
            margin-bottom: 1mm;
        }

        .summary-row.total {
            margin-top: 2mm;
            padding-top: 2mm;
            border-top: 0.5mm solid var(--gray-200);
            font-weight: 600;
            color: var(--primary-700);
        }

        /* Warranty */
        .warranty {
            background-color: var(--primary-50);
            border: 0.5mm solid var(--primary-100);
            border-radius: 2mm;
            padding: 3mm;
            margin-bottom: 5mm;
        }

        .warranty-title {
            display: flex;
            align-items: center;
            gap: 1mm;
            margin-bottom: 1mm;
            font-weight: 600;
            color: var(--primary-600);
            font-size: 3.5mm;
        }

        .warranty-content {
            font-size: 3.5mm;
            color: var(--gray-700);
        }

        .warranty-content p:first-child {
            font-weight: 500;
            margin-bottom: 1mm;
        }

        /* Savings */
        .savings {
            background-color: var(--success-50);
            border: 0.5mm solid var(--success-100);
            border-radius: 2mm;
            padding: 2mm;
            text-align: center;
            font-weight: 500;
            color: var(--success-500);
            margin-bottom: 5mm;
            font-size: 3.5mm;
        }

        /* Barcode */
        .barcode-container {
            display: flex;
            justify-content: center;
            margin-bottom: 5mm;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: auto;
        }

        .footer p:first-child {
            margin-bottom: 1mm;
            font-size: 3.5mm;
            color: var(--gray-600);
        }

        .footer p:last-child {
            font-size: 3mm;
            color: var(--gray-500);
        }
    </style>
</head>

<body onload="window.print()">
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            @if (!empty($print_set))
                @if ($print_set->logo == 1 && !empty($print_set->logo_path))
                    <div class="logo"> <img src="{{ $print_set->logo_path }}" alt="Logo" class="receipt-logo" />
                    </div>
                @endif
                @if (!empty($print_set->header_1))
                    <h1>{{ $print_set->header_1 }}</h1>
                @endif
                @if (!empty($print_set->header_2) || !empty($print_set->header_3) || !empty($print_set->header_4))
                    <p>
                        {!! nl2br(e($print_set->header_2)) !!}<br />
                        {!! nl2br(e($print_set->header_3)) !!}<br />
                        {!! nl2br(e($print_set->header_4)) !!}
                    </p>
                @endif
            @else
                <div class="logo">LOGO</div>
                <h1>Company Name</h1>
                <p>
                    Phone: +1 5656665656<br>
                    Email: example@gmail.com
                </p>
            @endif
        </div>

        <div class="divider"></div>

        <!-- Invoice Title -->
        <h2 class="invoice-title">INVOICE</h2>

        <!-- Customer Info -->
        <div class="customer-info">
            <div class="info-group">
                <p>Customer Name</p>
                <p> {{ $orders->customer->first_name ?? 'Walk-in Customer' }}</p>
            </div>
            <div class="info-group">
                <p>Invoice No</p>
                <p>{{ $orders->invoice_no }}</p>
            </div>
            <div class="info-group">
                <p>Date</p>
                <p>{{ \Carbon\Carbon::parse($orders->created_at)->format('d.m.Y h:i A') }}</p>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Items Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 30%">Item</th>
                        <th style="width: 15%" class="text-center">Qty</th>
                        <th style="width: 15%" class="text-center">Weight</th>
                        <th style="width: 15%" class="text-right">Price</th>
                        <th style="width: 20%" class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders->items as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->product->product_name }}</td>
                            <td class="text-center">{{ $item->qty }} pcs</td>
                            <td class="text-right">
                                {{ number_format($item->product->weight, 2) }}&nbsp;{{ $item->product->unit }}</td>
                            <td class="text-right">{{ number_format($item->net_price, 2) }}</td>
                            <td class="text-right">Rs. {{ number_format($item->total, 2) }}</td>
                        </tr>
                    @empty
                    @endif
                    @if ($orders->return_data->count())
                        <tr>
                            <td colspan="5"
                                style="border-top: 2px solid #000; padding-top: 10px; font-weight: bold; background-color: #f0f0f0; text-align: center;">
                                OLD GOLD
                            </td>
                        </tr>
                        @php $return_total_value = 0; @endphp
                        {{-- Returned Items --}}
                        @foreach ($orders->return_data as $return)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $return->product_data->product_name }}</td>
                                <td class="text-center">{{ $return->return_qty }} pcs</td>
                                <td class="text-right">
                                    {{ number_format($return->product_data->weight, 2) }}&nbsp;{{ $return->product_data->unit }}
                                </td>
                                <td class="text-right">{{ number_format($return->return_net_price, 2) }}</td>
                                <td class="text-right">Rs. {{ number_format($return->total, 2) }}</td>
                            </tr>
                            {{-- Calculate total return value --}}
                            @php
                                $return_total_value += $return->total;
                            @endphp
                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-row">
                <span>Sub Total</span>
                <span>Rs. {{ number_format($orders->subtotal, 2) }}</span>
            </div>
            <div class="summary-row">
                <span>Discount</span>
                <span>- Rs. {{ number_format($orders->discount, 2) }}</span>
            </div>
            @if ($orders->return_data->count())
                <div class="summary-row">
                    <span>Return Deduction</span>
                    <span>- Rs. {{ number_format($return_total_value, 2) }}</span>
                </div>
            @endif

            @if ($orders->total == 0 && $orders->return_amount > 0)
                <div class="summary-row total">
                    <span>Net Payable Amount</span>
                    <span>Rs. {{ number_format($orders->return_amount, 2) }}</span>
                </div>
            @elseif ($orders->total == 0 && $orders->return_amount == 0)
                <div class="summary-row total">
                    <span></span>
                    <span class="text-right">Exchange</span>
                </div>
            @else
                <div class="summary-row total">
                    <span>Total</span>
                    <span>Rs. {{ number_format($orders->total, 2) }}</span>
                </div>
            @endif


            @if ($orders->transaction->payment_method == 'cash' || $orders->transaction->payment_method == 'credit')

                @if ($orders->transaction->total_recived > 0)
                    <div class="summary-row">
                        <span>
                            @if ($orders->transaction->payment_method == 'cash')
                                Cash
                            @else
                                Card
                            @endif
                        </span>
                        <span>Rs. {{ number_format($orders->transaction->total_recived, 2) }}</span>
                    </div>
                    @if ($orders->transaction->change > 0)
                        <div class="summary-row">
                            <span>Change</span>
                            <span>Rs. {{ number_format($orders->transaction->change, 2) }}</span>
                        </div>
                    @endif

                    @if ($orders->transaction->total > 0)
                        @if (!empty($orders->customer->summer))
                            @php
                                $customer = App\Models\Customer::find($orders->customer->id);
                                $Previous_due = $customer
                                    ->summer()
                                    ->where('id', '!=', $customer->summer()->latest('id')->value('id'))
                                    ->sum('amount');
                                $due = $customer->summer->sum('amount');
                            @endphp

                            @if ($Previous_due != 0)
                                <div class="summary-row">
                                    <span> Previous @if ($Previous_due > 0)
                                            Balance
                                        @else
                                            Due @endif
                                    </span>
                                    <span>Rs. {{ number_format($Previous_due, 2) }}</span>
                                </div>
                            @endif


                            @if ($due > 0)
                                <div class="summary-row">
                                    <span>Available Balance</span>
                                    <span>Rs. {{ number_format($due, 2) }}</span>
                                </div>
                            @else
                                @php
                                    $due = abs($due);
                                    $Previous_due = abs($Previous_due);
                                @endphp

                                <div class="summary-row">
                                    <span>Total Due Amount</span>
                                    <span>Rs. {{ number_format($due, 2) }}</span>
                                </div>

                            @endif
                        @endif
                    @endif
        </div>


        @php
            $total_saving = 0;
            foreach ($orders->items as $item) {
                $item_saving = ($item->product->selling_price - $item->net_price) * $item->qty;
                $total_saving += $item_saving;
            }
            // Add manual discount too
            $total_saving += $orders->discount;
        @endphp

        @if ($total_saving > 0)
            <!-- Savings -->
            <div class="savings">
                You saved Rs. {{ number_format($total_saving, 2) }} today!
            </div>
        @endif

        <!-- Barcode -->
        <div class="barcode-container">
            <svg id="barcode"></svg>
        </div>

        <div class="divider"></div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for shopping with us!</p>
            <p>Developed by ZB Solutions</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            JsBarcode("#barcode", "INV-001", {
                format: "CODE128",
                displayValue: true,
                fontSize: 14,
                height: 50,
                margin: 10
            });
            // Redirect after print
            window.onafterprint = function() {
                window.location.href = "{{ route('sales') }}"; // Adjust redirect URL as needed
            };
        });
    </script>
</body>

</html>
