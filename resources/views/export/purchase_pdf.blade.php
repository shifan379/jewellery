<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Selected Purchases PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            margin-top: 30px;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h1>Selected Purchases</h1>

    @foreach ($purchase as $p)
        <h2>Purchase #{{ $p->id }}</h2>
        <p><strong>Supplier:</strong> {{ $p->supplier->company_name ?? 'N/A' }}</p>
        <p><strong>Date:</strong> {{ $p->purchase_date }}</p>
        <p><strong>Reference:</strong> {{ $p->reference ?? '-' }}</p>

        <table>
            <thead>
                <tr>
                    <th>Unit Cost</th>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Purchase Price</th>
                    <th>Weight</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($p->items as $item)
                    <tr>
                        <td>{{$item->item_code }}</td>
                        <td>{{ $item->product->product_name ?? 'Unnamed' }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ number_format($item->purchase_price, 2) }}</td>
                        <td>{{$item->weight }} g</td>
                        <td>{{ number_format(($item->purchase_price ) * $item->qty, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">No items found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach

</body>

</html>
