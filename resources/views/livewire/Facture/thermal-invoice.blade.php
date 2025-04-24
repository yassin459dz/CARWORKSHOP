<!DOCTYPE html>
<html>
<head>
    <style>
        @media print {
            body {
                width: 80mm;
                max-width: 80mm;
                margin: 0 auto;
                font-family: monospace;
                font-size: 10px;
                line-height: 1.4;
            }
            .header { text-align: center; border-bottom: 1px dashed; }
            .invoice-details { display: flex; justify-content: space-between; }
            .items-table { width: 100%; border-collapse: collapse; }
            .items-table th, .items-table td { border-bottom: 1px dashed; padding: 2px; }
            .totals { text-align: right; }
            .remark { border-top: 1px dashed; margin-top: 5px; }
        }
        @page { size: 80mm auto; margin: 0; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Invoice #{{ $invoiceNumber }}</h2>
        <p>{{ $date }} - {{ $time }} | Status: {{ $status }}</p>
    </div>

    <div class="invoice-details">
        <div>
            <strong>Client:</strong> {{ $client['name'] }}
            <br>Phone: {{ $client['phone'] }}
        </div>
        <div>
            <strong>Vehicle:</strong> {{ $vehicle['model'] }}
            <br>Matricule: {{ $vehicle['matricule'] }}
        </div>
    </div>

0    <table class="items-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderItems as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ number_format($item['price'], 2) }}</td>
                <td>{{ number_format($item['total'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <p>Extra Charges: +{{ number_format($financial['extra_charge'], 2) }}</p>
        <p>Discount: -{{ number_format($financial['discount_amount'], 2) }}</p>
        <strong>Total: {{ number_format($financial['total_amount'], 2) }}</strong>
    </div>

    @if($remark)
    <div class="remark">
        <strong>Remarks:</strong>
        <p>{{ $remark }}</p>
    </div>
    @endif
</body>
</html>
