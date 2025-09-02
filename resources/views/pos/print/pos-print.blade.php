<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .center {
            text-align: center;
        }

        .receipt-logo {
            width: 100px;
            margin: 0 auto 10px;
        }

        .total {
            font-size: 16px;
            font-weight: bold;
        }

        .footer {
            font-size: 10px;
            text-align: right;
        }

        .warranty-section {
            margin-top: 12px;
            padding: 8px;
            border: 1px dashed #000;
            font-size: 11px;
            background-color: #f9f9f9;
        }

        .warranty-title {
            font-weight: bold;
            text-decoration: underline;
            text-align: center;
            margin-bottom: 8px;
        }

        .warranty-item {
            margin: 6px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 12px;
        }

        thead tr {
            border-bottom: 1px solid #000;
        }

        th,
        td {
            padding: 6px 4px;
        }

        .right {
            text-align: right;
        }

        .center-text {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        hr {
            border-top: 1px dashed #000;
            margin: 12px 0;
        }

        .section-title {
            font-weight: bold;
            background-color: #eaeaea;
            padding: 6px 8px;
            margin-bottom: 6px;
            border: 1px solid #ccc;
        }

        .barcode {
            margin-top: 10px;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="center">
        @if (!empty($print_set))
            @if ($print_set->logo == 1 && !empty($print_set->logo_path))
                <img src="{{ $print_set->logo_path }}" alt="Logo" class="receipt-logo" />
            @endif
            @if (!empty($print_set->header_1))
                <h3>{{ $print_set->header_1 }}</h3>
            @endif
            @if (!empty($print_set->header_2) || !empty($print_set->header_3) || !empty($print_set->header_4))
                <p>
                    {!! nl2br(e($print_set->header_2)) !!}<br />
                    {!! nl2br(e($print_set->header_3)) !!}<br />
                    {!! nl2br(e($print_set->header_4)) !!}
                </p>
            @endif
        @else
            <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo" class="receipt-logo" />
            <h3>Dreamguys Technologies Pvt Ltd</h3>
            <p>Phone: +1 5656665656<br />Email: example@gmail.com</p>
        @endif
    </div>

    <hr />

    <p class="center bold" style="font-size: 18px; margin-bottom: 6px;">Invoice</p>
    <p>
        <strong>Name:</strong> {{ $orders->customer->first_name ?? 'Walk-in Customer' }}<br />
        <strong>Invoice No:</strong> <span id="invoiceNo">{{ $orders->invoice_no }}</span><br />
        <strong>Date:</strong> {{ \Carbon\Carbon::parse($orders->created_at)->format('d.m.Y h:i A') }}
    </p>

    <hr />

    <!-- Items Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                    <th style="width: 20%;" class="center-text">Qty</th>
                    <th style="width: 20%;" class="right">MRP</th>
                    <th style="width: 20%;" class="right">Price</th>
                    <th style="width: 35%;" class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            {{-- Normal Purchased Items --}}
            @forelse ($orders->items as $item)
                 {{-- First row: Product Name --}}
                <tr>
                    <td class="center-text">{{ $loop->iteration }}</td>
                    <td colspan="5">{{ $item->product->product_name }}</td>
                </tr>

                {{-- Second row: Details --}}
                <tr>
                    <td></td>
                    <td class="right">{{ $item->qty }}&nbsp;{{ $item->product->unit }}</td>
                    <td class="right">{{ number_format($item->product->selling_price, 2) }}</td>
                    <td class="right">{{ number_format($item->net_price, 2) }}</td>
                    <td class="right">Rs. {{ number_format($item->total, 2) }}</td>
                </tr>
            @empty

            @endforelse

            {{-- Return Items Separator --}}
            @if ($orders->return_data ->count())
                <tr>
                    <td colspan="5"
                        style="border-top: 2px solid #000; padding-top: 10px; font-weight: bold; background-color: #f0f0f0; text-align: center;">
                        Returned Items
                    </td>
                </tr>

                @php $return_total_value = 0; @endphp

                {{-- Returned Items --}}
                @foreach ($orders->return_data as $return)
                    <tr>
                        <td class="center-text">{{ $loop->iteration }}</td>
                        <td colspan="5">{{ $return->product_data->product_name }}</td>
                    </tr>
                    <tr>
                         <td></td>
                        <td class="center-text">{{ $return->return_qty }}&nbsp;{{ $return->product_data->unit }}</td>
                        <td class="right">{{ number_format($return->product_data->selling_price, 2) }}</td>
                        <td class="right">{{ number_format($return->return_net_price, 2) }}</td>
                        <td class="right">Rs. {{ number_format($return->total, 2) }}</td>
                    </tr>
                    @php
                        $return_total_value += $return->total;
                    @endphp
                @endforeach
            @endif
        </tbody>
    </table>

    <hr />
    <!-- Summary Table -->
    <table>
        <tr>
            <td>Sub Total</td>
            <td class="right">Rs. {{ number_format($orders->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td>Discount</td>
            <td class="right">(-) Rs. {{ number_format($orders->discount, 2) }}</td>
        </tr>

        @if ($orders->return_data ->count())
            <tr>
                <td>Return Deduction</td>
                <td class="right">(-) Rs. {{ number_format($return_total_value, 2) }}</td>
            </tr>
        @endif

        @if ($orders->total == 0 && $orders->return_amount > 0)
            <tr class="bold total">
                <td>Net Payable Amount</td>
                <td class="right">Rs. {{ number_format($orders->return_amount, 2) }}</td>
            </tr>
        @elseif ($orders->total == 0 && $orders->return_amount == 0)
            <tr class="bold total">
                <td></td>
                <td class="right">Exchange</td>

            </tr>
        @else
            <tr class="bold total">
                <td>Total</td>
                <td class="right">Rs. {{ number_format($orders->total, 2) }}</td>
            </tr>
        @endif

        @if ($orders->transaction->payment_method == 'cash' || $orders->transaction->payment_method == 'credit')
            <tr>
                <td>
                    @if ($orders->transaction->payment_method == 'cash')
                        Cash
                    @else
                        Card
                    @endif
                </td>
                <td class="right">Rs. {{ number_format($orders->transaction->total_recived, 2) }}</td>
            </tr>
            <tr>
                <td>Change</td>
                <td class="right">Rs. {{ number_format($orders->transaction->change, 2) }}</td>
            </tr>
        @endif

    </table>

    <!-- Warranty Section -->
    @php $hasWarranty = false; @endphp
    @foreach ($orders->items as $item)
        @if ($item->product->warranty)
            @php
                $hasWarranty = true;
                break;
            @endphp
        @endif
    @endforeach

    @if ($hasWarranty)
        <div class="warranty-section">
            <div class="warranty-title">Warranty Information</div>
            @foreach ($orders->items as $item)
                @if ($item->product->warranty)
                    @php
                        $startDate = \Carbon\Carbon::parse($orders->created_at);
                        $duration = (int) $item->product->warranty_item->duration;
                        $period = strtolower($item->product->warranty_item->period);

                        $endDate = match ($period) {
                            'month', 'months' => $startDate->copy()->addMonths($duration),
                            'year', 'years' => $startDate->copy()->addYears($duration),
                            'day', 'days' => $startDate->copy()->addDays($duration),
                            default => $startDate,
                        };
                    @endphp
                    <div class="warranty-item">
                        <strong>{{ $item->product->product_name }}</strong><br />
                        Warranty: {{ $item->product->warranty_item->warranty }}<br />
                        Period: {{ $duration }} {{ ucfirst($period) }}<br />
                        Valid From: {{ $startDate->format('d-m-Y') }} to {{ $endDate->format('d-m-Y') }}
                    </div>
                @endif
            @endforeach
        </div>
    @endif


    @php
        $total_saving = 0;
        foreach ($orders->items as $item) {
            $item_saving = ($item->product->selling_price - $item->net_price) * $item->qty;
            $total_saving += $item_saving;
        }
        // Add manual discount too
        $total_saving += $orders->discount;
    @endphp

    @if ( $total_saving > 0)
        <h3 class="center bold">You saved Rs. {{ number_format($total_saving, 2) }} today!</h3>
    @endif

    <div class="center barcode">
        <svg id="barcode"></svg>
    </div>

    <hr />

    <div class="center">
        @if (!empty($print_set))
            @if (!empty($print_set->footer_1) || !empty($print_set->footer_2) || !empty($print_set->footer_3))
                <p>
                    {!! nl2br(e($print_set->footer_1)) !!}<br />
                    {!! nl2br(e($print_set->footer_2)) !!}<br />
                    {!! nl2br(e($print_set->footer_3)) !!}
                </p>
            @endif
        @else
            <p>Thank you for shopping with us!</p>
        @endif
    </div>

    <div class="footer">
        Developed by ZB Solutions.
    </div>

    <!-- JsBarcode CDN -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <script>
        JsBarcode("#barcode", document.getElementById("invoiceNo").textContent, {
            format: "CODE128",
            displayValue: true,
            fontSize: 14,
            height: 40
        });

        // Redirect after print
        window.onafterprint = function() {
            window.location.href = "{{ route('pos') }}"; // Adjust redirect URL as needed
        };
    </script>

</body>

</html>
