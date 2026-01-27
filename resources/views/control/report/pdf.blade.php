<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Financial Report</title>
    <style>
        body { font-family: sans-serif; color: #1f2937; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 2rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem; }
        .title { font-size: 1.5rem; font-weight: bold; color: #111827; }
        .subtitle { color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem; }
        
        .grid { width: 100%; display: table; table-layout: fixed; margin-bottom: 2rem; }
        .col { display: table-cell; padding: 1rem; background: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb; text-align: center; }
        .col h3 { font-size: 0.75rem; text-transform: uppercase; color: #6b7280; margin: 0; }
        .col p { font-size: 1.25rem; font-weight: bold; color: #111827; margin: 0.5rem 0 0 0; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        th { text-align: left; padding: 0.75rem; background: #f3f4f6; font-size: 0.75rem; text-transform: uppercase; color: #4b5563; font-weight: bold; }
        td { padding: 0.75rem; border-bottom: 1px solid #e5e7eb; font-size: 0.875rem; }
        .text-right { text-align: right; }
        .section-title { font-size: 1rem; font-weight: bold; margin-bottom: 1rem; color: #111827; border-left: 4px solid #5b3def; padding-left: 0.5rem; }
        
        .footer { margin-top: 3rem; text-align: center; font-size: 0.75rem; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 1rem; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Setara Space - Financial Report</div>
        <div class="subtitle">Period: {{ $dateRange }}</div>
    </div>

    <!-- Summary -->
    <div class="grid">
        <div class="col" style="margin-right: 10px;">
            <h3>Total Revenue</h3>
            <p>Rp {{ number_format($financials->revenue, 0, ',', '.') }}</p>
        </div>
        <div class="col" style="margin-right: 10px;">
            <h3>Total Orders</h3>
            <p>{{ number_format($financials->total_orders) }}</p>
        </div>
        <div class="col">
            <h3>Discounts Given</h3>
            <p>Rp {{ number_format($financials->total_discount, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Top Products -->
    <div class="section-title">Top Selling Products</div>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th class="text-right">Quantity Sold</th>
                <th class="text-right">Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $product->product_name }}</td>
                <td class="text-right">{{ $product->qty }}</td>
                <td class="text-right">Rp {{ number_format($product->total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center;">No sales data available.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Payment Methods -->
    <div class="section-title">Payment Breakdown</div>
    <table>
        <thead>
            <tr>
                <th>Payment Method</th>
                <th class="text-right">Transactions</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paymentMethods as $method)
            <tr>
                <td style="text-transform: capitalize;">{{ str_replace('_', ' ', $method->payment_method) }}</td>
                <td class="text-right">{{ $method->total }}</td>
                <td class="text-right">Rp {{ number_format($method->amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generated on {{ date('d M Y H:i') }} | Setara Space Control Panel
    </div>
</body>
</html>
