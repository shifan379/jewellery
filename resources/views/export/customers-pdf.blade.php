<!DOCTYPE html>
<html>
<head>
    <title>Selected Customers</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Selected Customers</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>City</th>
                <th>Province</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $index => $customer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $customer->first_name }}</td>
                    <td>{{ $customer->last_name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->city }}</td>
                    <td>{{ $customer->province }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
