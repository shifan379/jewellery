<!DOCTYPE html>
<html>
<head>
    <title>Stock Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 6px; border: 1px solid #000; text-align: left; }
    </style>
</head>
<body>
    <h2>Stock Report</h2>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Location</th>
                {{-- <th>Date</th> --}}
                {{-- <th>Responsible Person</th> --}}
                <th>Quantity</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
                <tr>
                    <td>{{ $stock->product->product_name ?? 'N/A' }}</td>
                    <td>{{ $stock->location->name ?? 'N/A' }}</td>
                    {{-- <td>{{ $stock->date->format('Y-m-d') }}</td> --}}
                    {{-- <td>{{ $stock->responsible_person ?? 'N/A' }}</td> --}}
                    <td>{{ $stock->stock }}</td>
                    <td>{{ $stock->updated_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
