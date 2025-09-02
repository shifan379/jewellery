<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Product List</h2>
    <table>
        <thead>
            <tr>
                <th>Location</th>
                <th>Supplier</th>
                <th>Product</th>
                <th>Category</th>
                <th>Date</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->locationRelation->name ?? 'N/A' }}</td>
                <td>{{ $product->supply->name ?? 'N/A' }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->cate->category ?? 'N/A' }}</td>
                <td>{{ $product->created_at->format('d M Y') }}</td>
                <td>{{ $product->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
