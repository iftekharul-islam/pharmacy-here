<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Order Status</title>
</head>
<body>

    <p>Dear Subidha ,</p>
@if($isCancel === true)
    <span>An order ID: {{ $order->order_no }} has been canceled from {{ $order->pharmacy->name }}</span>
    <br>
    <p>Ordered by:</p>
    <span>Order ID: {{ $order->order_no }}</span><br>
    <span>Order Amount: {{ $order->customer_amount }} tk</span><br>
    <span>Customer Name: {{ $order->customer->name }}</span>
    <br>
    <br>
    <p>Order Cancel from:</p>
    <span>Pharmacy name: {{ $order->pharmacy->name }}</span><br>
    <span>
        Cancel From:
        {{ $order->status === 0 ? 'pending' : 'On processing' }}
    </span>
    <br>
    @else

    <p>An order ID: {{ $order->order_no }} has been Orphaned</p>
    <p>Ordered by:</p>
    <span>Order ID: {{ $order->order_no }}</span><br>
    <span>order Amount: {{ $order->customer_amount }}</span><br>
    <span>Customer Name: {{ $order->customer->name }}</span>
    <br>
    <br>
@endif

    <p>Thank You</p>

    <span>Disclaimer Message</span><br>
    <span>This is automatic generated email, please do not reply.</span>
</body>
</html>
