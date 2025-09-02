<!DOCTYPE html>
<html>
<head>
    <title>Purchase Return PDF</title>
    <style>
        @page { margin: 20px; } /* smaller page margins */
        body { font-family: sans-serif; font-size: 10px; } /* smaller text */
        table { width: 100%; border-collapse: collapse; }
        th, td {
            border: 1px solid #000;
            padding: 4px; /* reduced padding */
            text-align: left;
            word-wrap: break-word; /* wrap long text */
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        h2 {
            font-size: 14px;
            text-align: center;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <h2>All Purchase Returns</h2>
    <table>
        <thead>
            <tr>
                <th>Purchase Date</th>
                <th>Purchase Code</th>
                <th>Product Name</th>
                <th>Purchase ID</th>
                <th>Qty</th>
                <th>Purchase Price</th>
                <th>Weight</th>
                <th>Unit Cost</th>
                <th>Total</th>
                <th>Return Total</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($returns as $item)
                <tr>
                    <td>{{ $item->purchase_date }}</td>
                    <td>{{ optional($item->purchase)->purchase_code }}</td>
                    <td>{{ optional($item->product)->product_name }}</td>
                    <td>{{ $item->purcheseID }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->purchase_price }}</td>
                    <td>{{ $item->weight }}</td>
                    <td>{{ $item->unit_cost }}</td>
                    <td>{{ $item->total }}</td>
                    <td>{{ $item->return_total }}</td>
                    <td>{{ $item->notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
