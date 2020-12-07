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
    <textarea>An order ID: {{ $order->order_no }} has been canceled from {{ $order->pharmacy->name }}</textarea>
    <br>
    <p>Ordered by:</p>
    <textarea>Order ID: {{ $order->order_no }}</textarea><br>
    <textarea>Order Amount: {{ $order->customer_amount }} tk</textarea><br>
    <textarea>Customer Name: {{ $order->customer->name }}</textarea>
    <br>
    <br>
    <p>Order Cancel from:</p>
    <textarea>Pharmacy name: {{ $order->pharmacy->name }}</textarea><br>
    <textarea>
        Cancel From:
        {{ $order->status === 0 ? 'pending' : 'On processing' }}
    </textarea>
    <br>
    @else

    <p>An order ID: {{ $order->order_no }} has been Orphaned</p>
    <p>Ordered by:</p>
    <textarea>Order ID: {{ $order->order_no }}</textarea><br>
    <textarea>order Amount: {{ $order->amount }}</textarea><br>
    <textarea>Customer Name: {{ $order->customer->name }}</textarea>
    <br>
    <br>
@endif

    <p>Thank You</p>

    <textarea>Disclaimer Message</textarea><br>
    <textarea>This is automatic generated email, please do not reply.</textarea>
</body>
</html>
