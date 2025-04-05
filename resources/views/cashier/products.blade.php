<!-- resources/views/products.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            height: 100vh;
            background-color: #e0f7fa;
        }

        .sidebar {
            width: 200px;
            background-color: #4caf50;
            color: white;
            padding: 20px;
        }

        .sidebar h2 {
            text-align: center;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
        }

        .sidebar ul li a:hover {
            text-decoration: underline;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
        }

        .product-table th, .product-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .product-table th {
            background-color: #4caf50;
            color: white;
        }

        .product-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Transaction</a></li>
                <li><a href="#">Employee</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h1>Product Details</h1>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>