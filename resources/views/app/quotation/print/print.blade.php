<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Quotation</title>
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
            <h3>Company Name</h3>
            <p>Phone: 123456789<br />Email: demo@example.com</p>
        @endif
    </div>

    <hr />

    <p class="center bold" style="font-size: 18px; margin-bottom: 6px;">Quotation</p>
    <p>
        <strong>Name:</strong> {{ $quotation->customer->first_name ?? 'Walk-in Customer' }}<br />
        <strong>Quotation No:</strong> <span id="quotationNo">#QUT00{{ $quotation->id }}</span><br />
        <strong>Date:</strong> {{ \Carbon\Carbon::parse($quotation->date)->format('d.m.Y h:i A') }}
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

                {{-- <th style="width: 5%;">#</th>
                <th style="width: 35%;">Product</th>
                <th style="width: 15%;" class="center-text">Qty</th>
                <th style="width: 20%;" class="right">Price</th>
                <th style="width: 25%;" class="right">Total</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse ($quotation->items as $item)
                {{-- First row: Product Name --}}
                <tr>
                    <td class="center-text">{{ $loop->iteration }}</td>
                    <td colspan="5">{{ $item->product->product_name }}</td>
                </tr>

                {{-- Second row: Details --}}
                <tr>
                    <td></td>
                    <td class="right">{{ $item->quantity }}&nbsp;{{ $item->product->unit }}</td>
                    <td class="right">{{ number_format($item->product->selling_price, 2) }}</td>
                    <td class="right">{{ number_format($item->unit_cost, 2) }}</td>
                    <td class="right">Rs. {{ number_format($item->total_cost, 2) }}</td>
                </tr>

                {{-- <tr>
                    <td class="center-text">{{ $loop->iteration }}</td>
                    <td>{{ $item->product->product_name }}</td>
                    <td class="center-text">{{ $item->quantity }} {{ $item->product->unit }}</td>
                    <td class="right">{{ number_format($item->unit_cost, 2) }}</td>
                    <td class="right">Rs. {{ number_format($item->total_cost, 2) }}</td>
                </tr> --}}
            @empty
                <tr>
                    <td colspan="5" class="center">No items</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <hr />

    <!-- Summary Table -->
    <table>
        <tr>
            <td>Sub Total</td>
            <td class="right">Rs. {{ number_format($quotation->items->sum('total_cost'), 2) }}</td>
        </tr>
        <tr>
            <td>Discount</td>
            <td class="right">- Rs. {{ number_format($quotation->discount, 2) }}</td>
        </tr>
        <tr>
            <td>Shipping</td>
            <td class="right">Rs. {{ number_format($quotation->shipping, 2) }}</td>
        </tr>
        <tr class="bold total">
            <td>Grand Total</td>
            <td class="right">Rs.
                {{ number_format($quotation->items->sum('total_cost') - $quotation->discount + $quotation->shipping, 2) }}
            </td>
        </tr>
    </table>

    <!-- Warranty Section -->
    @php $hasWarranty = false; @endphp
    @foreach ($quotation->items as $item)
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
            @foreach ($quotation->items as $item)
                @if ($item->product->warranty)
                    <div class="warranty-item">
                        <strong>{{ $item->product->product_name }}</strong><br />
                        Warranty: {{ $item->product->warranty_item->warranty ?? 'N/A' }}
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    @php
        $total_saving = 0;
        foreach ($quotation->items as $item) {
            $item_saving = ($item->product->selling_price - $item->unit_cost) * $item->quantity;
            $total_saving += $item_saving;
        }
        // Add manual discount too
        $total_saving += $quotation->discount;
    @endphp

    @if ($total_saving > 0)
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
            <p>Thank you for your business!</p>
        @endif
    </div>

    <div class="footer">
        Developed by ZB Solutions.
    </div>

    <!-- JsBarcode -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <script>
        JsBarcode("#barcode", document.getElementById("quotationNo").textContent, {
            format: "CODE128",
            displayValue: true,
            fontSize: 14,
            height: 40
        });

        window.onafterprint = function() {
            window.location.href = "{{ route('quotation.index') }}";
        };
    </script>

</body>

</html>
