<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0; }
        .summary-card { 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            padding: 15px; 
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }
        .summary-grid { 
            display: grid; 
            grid-template-columns: repeat(3, 1fr); 
            gap: 15px; 
            margin-bottom: 20px;
        }
        .summary-item { text-align: center; }
        .summary-value { font-size: 24px; font-weight: bold; }
        .summary-label { font-size: 14px; color: #666; }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left;
        }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .footer { 
            margin-top: 30px; 
            text-align: center; 
            font-size: 12px; 
            color: #666;
        }
        @media print {
            .no-print { display: none; }
            body { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Generated on {{ now()->format('F j, Y h:i A') }}</p>
    </div>
    
    @if($includeSummary)
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-item">
                <div class="summary-value">₱{{ number_format($totalSales, 2) }}</div>
                <div class="summary-label">Total Sales</div>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-item">
                <div class="summary-value">{{ $totalTransactions }}</div>
                <div class="summary-label">Transactions</div>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-item">
                <div class="summary-value">{{ $totalItemsSold }}</div>
                <div class="summary-label">Items Sold</div>
            </div>
        </div>
    </div>
    @endif
    
    @if($includeTransactions && $orders->isNotEmpty())
    <h3>Transaction Details</h3>
    <table>
        <thead>
            <tr>
                <th>Order #</th>
                <th>Time</th>
                <th>Items</th>
                <th>Payment Method</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at->format('h:i A') }}</td>
                <td>{{ $order->products->sum('pivot.quantity') }}</td>
                <td>
                    @switch($order->payment_method)
                        @case('cash') Cash @break
                        @case('card') Card @break
                        @case('digital') Mobile @break
                        @default {{ ucfirst($order->payment_method) }}
                    @endswitch
                </td>
                <td class="text-right">₱{{ number_format($order->total_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    
    <div class="footer no-print">
        <p>End of report</p>
        <button onclick="window.print()" class="no-print">Print Report</button>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>