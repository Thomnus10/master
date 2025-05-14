<!DOCTYPE html>
<html>
<head>
    <title>Dowence Market Receipt</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            width: 500px; /* Increased width from 300px to 500px */
            margin: 0 auto;
            padding: 10px;
            background-color: #f9f9f9;
        }
        
        .receipt {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 8px;
        }
        
        .store-name {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
        
        .receipt-title {
            font-size: 14px;
            margin: 5px 0;
        }
        
        .info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 11px;
        }
        
        .items {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        
        .items th {
            border-bottom: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            font-size: 11px;
        }
        
        .items td {
            padding: 5px;
            border-bottom: 1px dotted #eee;
            font-size: 11px;
        }
        
        .summary {
            margin-top: 10px;
            border-top: 1px dashed #ccc;
            padding-top: 8px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }
        
        .total {
            font-weight: bold;
            font-size: 13px;
            margin: 5px 0;
        }
        
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
            color: #777;
        }
        
        .product-name {
            width: 50%;
        }
        
        .right-align {
            text-align: right;
        }
        
        .center-align {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <p class="store-name">DOWENCE MARKET</p>
            <p class="receipt-title">Official Receipt</p>
        </div>
        
        <div class="info">
            <span><strong>Order #:</strong> {{ $order->id }}</span>
            <span><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</span>
        </div>
        <div class="info">
            <span><strong>Time:</strong> {{ $order->created_at->format('h:i A') }}</span>
            <span><strong>Cashier:</strong> {{ $order->employee->Fname }} {{ $order->employee->Mname }} {{ $order->employee->Lname }}</span>
        </div>
        
        <table class="items">
            <thead>
                <tr>
                    <th class="product-name">Item</th>
                    <th class="center-align">Qty</th>
                    <th class="right-align">Price</th>
                    <th class="right-align">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $product)
                <tr>
                    <td class="product-name">{{ $product->name }}</td>
                    <td class="center-align">{{ $product->pivot->quantity }}</td>
                    <td class="right-align">Php {{ number_format($product->pivot->price, 2) }}</td>
                    <td class="right-align">Php {{ number_format($product->pivot->quantity * $product->pivot->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="summary">
            <div class="summary-row total">
                <span>TOTAL:</span>
                <span>Php {{ number_format($order->total_amount, 2) }}</span>
            </div>
            <div class="summary-row">
                <span>Amount Tendered:</span>
                <span>Php {{ number_format($order->amount_tendered, 2) }}</span>
            </div>
            <div class="summary-row">
                <span>Change:</span>
                <span>Php {{ number_format($order->change_amount, 2) }}</span>
            </div>
        </div>
        
        <div class="footer">
            <p>Thank you for shopping at Dowence Market!</p>
            <p>Please come again.</p>
        </div>
    </div>
</body>
</html>