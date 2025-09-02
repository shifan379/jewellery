<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Products List</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #555;
            padding: 5px 0;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h2>Products List</h2>
    <table>
        <thead>
            <tr>
                <th>Item Code</th>
                <th>Location</th>
                <th>Product Name</th>
                <th>Buying Price</th>
                <th>Weight</th>
                <th>Unit</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->item_code }}</td>
                <td>{{ $product->locationRelation->name }}</td>
                <td>{{ $product->product_name }}</td>
                <td>Rs. {{ $product->buying_price }}</td>
                <td>{{ $product->weight }} g</td>
                <td>{{ $product->unit }}</td>
                <td>{{ $product->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        System developed by ZB Solutions
    </footer>
</body>
</html>
