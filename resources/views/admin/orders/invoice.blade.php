<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .invoice-box {
            width: 100%;
            padding: 20px;
            border: 1px solid #eee;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        .company-details {
            text-align: right;
        }

        .details,
        .items {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .details td {
            padding: 5px;
        }

        .items th,
        .items td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .items th {
            background: #f5f5f5;
        }

        .totals {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .totals td {
            padding: 5px;
        }

        .totals tr td:last-child {
            text-align: right;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <!-- Header -->
        <div class="header">
            <h2>Invoice</h2>
            <p>Invoice #: {{ $order->order_number }}</p>
            <p>Date: {{ $order->created_at->format('d M, Y') }}</p>
        </div>

        <!-- Company & Customer Details -->
        <table class="details">
            <tr>
                <td>
                    <strong>Billing To:</strong><br>
                    {{ $order->shippingAddress->full_name }}<br>
                    {{ $order->shippingAddress->full_address }}<br>
                    Phone: {{ $order->customer_phone }}
                </td>
                <td class="company-details">
                    <strong>{{ setting('site_name') }}</strong><br>
                    {{ setting('site_address') }}<br>
                    Email: {{ setting('site_email') }}<br>
                    Phone: {{ setting('site_phone') }}
                </td>
            </tr>
        </table>

        <!-- Order Items -->
        <table class="items">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product->name ?? 'N/A' }}</td>
                        <td>{{ number_format($item->unit_price, 2) }} TK</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->total_price, 2) }} TK</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <table class="totals">
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td>{{ number_format($order->subtotal, 2) }} TK</td>
            </tr>
            <tr>
                <td><strong>Delivery Charge:</strong></td>
                <td>{{ number_format($order->shipping_cost, 2) }} TK</td>
            </tr>
            <tr>
                <td><strong>Grand Total:</strong></td>
                <td><strong>{{ number_format($order->total_amount, 2) }} TK</strong></td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            Thank you for your purchase!
            <br> This is a computer-generated invoice and does not require a signature.
        </div>
    </div>
</body>

</html>
