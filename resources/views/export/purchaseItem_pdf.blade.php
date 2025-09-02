<!DOCTYPE html>
<html>
<head>
    <title>Purchase Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        table, th, td {
            border: 1px solid #999;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h3>Purchase Items Report</h3>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Purchased Amount</th>
                <th>Purchased QTY</th>
                <th>Instock QTY</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchaseItems as $item)
                <tr>
                    <td>{{ $item->product->product_name ?? '' }}</td>
                    <td>{{ number_format($item->purchase_price * $item->qty, 2) }}</td>
                    <td>{{ (int) $item->qty }}</td>
                    <td>{{ (int) ($item->product->quantity ?? 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
