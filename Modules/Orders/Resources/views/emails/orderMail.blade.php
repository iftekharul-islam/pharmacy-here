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

    <p>Dear Subidha</p>
@if($isCancel == true)
    <p>An order ID: {{ $order->order_no }} has been canceled from {{ $order->pharmacy->name }}</p>
    <p>Ordered by:</p>
    <p>Order ID: {{ $order->order_no }}</p>
    <p>Order Amount: {{ $order->customer_amount }} tk</p>
    <p>Customer Name: {{ $order->customer->name }}</p>

    <p>Order Cancel from:</p>
    <p>Pharmacy name: {{ $order->pharmacy->name }}</p>
    <p>
        Cancel From:
        {{ $order->status === 0 ? 'pending' : 'On processing' }}
    </p>

    @else

    <p>An order ID: {{ $order->order_no }} has been Orphaned</p>
    <p>Ordered by:</p>
    <p>Order ID: {{ $order->order_no }}</p>
    <p>order Amount: {{ $order->amount }}</p>
    <p>Customer Name: {{ $order->customer->name }}</p>
@endif

    <a href="" class="btn btn-primary btn-sm">View Order</a>
{{--    <p>{{ $msg }}</p>--}}
    <p>Thank You</p>

    <p>Disclaimer Message</p>
    <p>This is automatic generated email, please do not reply.</p>
</body>
</html>
