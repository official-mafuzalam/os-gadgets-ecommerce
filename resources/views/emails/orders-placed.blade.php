<h1>Thank you for your order!</h1>

<p>Dear {{ $order->customer_email ?? $order->customer_phone }},</p>

<p>Your order <strong>#{{ $order->order_number }}</strong> has been placed successfully.</p>

<p><strong>Order Details:</strong></p>
<ul>
    @foreach ($order->items as $item)
        <li>{{ $item->product->name }} x {{ $item->quantity }} = {{ number_format($item->total_price) }} TK</li>
    @endforeach
</ul>

<p>Subtotal: {{ number_format($order->subtotal) }} TK</p>
<p>Shipping: {{ number_format($order->shipping_cost) }} TK</p>
<p><strong>Total: {{ number_format($order->total_amount) }} TK</strong></p>

<p>We will notify you once your order is shipped.</p>
