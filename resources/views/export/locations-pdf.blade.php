<!DOCTYPE html>
<html>
<head>
    <title>Location PDF</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 5px; font-size: 12px; }
    </style>
</head>
<body>
    <h2>Location List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Location Name</th>
                <th>Contact Person</th>
                <th>Phone</th>
                <th>Product Count</th>
                {{-- <th>Account</th> --}}
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($location as $loc)
            <tr>
                <td>{{ $loc->id }}</td>
                <td>{{ $loc->name }}</td>
                <td>{{ $loc->contact_person }}</td>
                <td>{{ $loc->phone }}</td>
                <td>{{ $loc->product_count }}</td>
                {{-- <td>{{ $loc->bank_acc_no }}</td> --}}
                <td>{{ $loc->status ? 'Active' : 'Inactive' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
