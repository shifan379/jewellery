<!DOCTYPE html>
<html>
<head>
    <title>Suppliers PDF</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 5px; font-size: 12px; }
    </style>
</head>
<body>
    <h2>Suppliers List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Company</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Bank</th>
                <th>Account</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->id }}</td>
                <td>{{ $supplier->company_name }}</td>
                <td>{{ $supplier->email }}</td>
                <td>{{ $supplier->phone }}</td>
                <td>{{ $supplier->bank_name }}</td>
                <td>{{ $supplier->bank_acc_no }}</td>
                <td>{{ $supplier->status ? 'Active' : 'Inactive' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
