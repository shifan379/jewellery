<!DOCTYPE html>
<html>
<head>
    <title>Stock Transfers PDF</title>
    <style>
        table, th, td {
            border: 1px solid black; border-collapse: collapse; padding: 5px;
        }
    </style>
</head>
<body>
    <h2>Stock Transfer Report</h2>
    <table width="100%">
        <thead>
            <tr>
                <th>From</th>
                <th>To</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Responsible Person</th>
                <th>Ref</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transfers as $transfer)
                <tr>
                    <td>{{ $transfer->fromLocation->name ?? 'N/A' }}</td>
                    <td>{{ $transfer->toLocation->name ?? 'N/A' }}</td>
                    <td>{{ $transfer->product->product_name ?? 'N/A' }}</td>
                    <td>{{ $transfer->stock_quantity }}</td>
                    <td>{{$transfer->responsible_person}}</td>
                    <td>{{ $transfer->ref_number }}</td>
                    <td>{{ $transfer->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
