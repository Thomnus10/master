<!DOCTYPE html>
<html>

<head>
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h2,
        h4 {
            margin: 0;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 6px;
            border-bottom: 1px solid #ccc;
        }

        .total {
            font-weight: bold;
        }

        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <h2>DOWENCE MARKET</h2>
    <h4>Receipt</h4>
    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>₱{{ number_format($product->pivot->price, 2) }}</td>
                    <td>₱{{ number_format($product->pivot->quantity * $product->pivot->price, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="3" class="text-end">Total:</td>
                <td>₱{{ number_format($order->total_amount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-end">Amount Tendered:</td>
                <td>₱{{ number_format($order->amount_tendered, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-end">Change:</td>
                <td>₱{{ number_format($order->change_amount, 2) }}</td>
            </tr>
        </tbody>

    </table>

    <button onclick="window.print()">Print</button>
</body>

</html>