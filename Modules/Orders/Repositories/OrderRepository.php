<?php


namespace Modules\Orders\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\Address\Entities\CustomerAddress;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\OrderCancelReason;
use Modules\Orders\Entities\Models\OrderHistory;
use Modules\Orders\Entities\Models\OrderItems;
use Modules\Orders\Entities\Models\OrderPrescription;
use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\User;
use Modules\User\Entities\Models\UserDeviceId;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderRepository
{
    /**
     * @param $request
     * @param $pharmacy_id
     * @return mixed
     */
    public function byPharmacyId($request, $pharmacy_id)
    {
        $order = Order::query();

        if ($request->has('customer_name') && $request->get('customer_name')) {

            $customerName = $request->get('customer_name');
            $customerIds = User::where('name', 'LIKE', "%$customerName%")->pluck('id');
            $order->whereIn('customer_id', $customerIds);
        }
        return $order->with(['orderItems.product', 'address.area.thana.district', 'pharmacy'])
            ->where('pharmacy_id', $pharmacy_id)->paginate(10);
    }

    public function orderWeb($id) {
        return Order::with('address', 'orderItems', 'orderItems.product')->where('customer_id', Auth::user()->id)->where('id', $id)->first();
    }

    /**
     * @param $customer_id
     * @return mixed
     */
    public function byCustomerId($customer_id)
    {
        return Order::with(['orderItems.product', 'address.area.thana.district', 'pharmacy', 'feedback'])
            ->where('customer_id', $customer_id)
            ->orderBy('id', 'desc')
            ->paginate(20);
    }

    public function orderListByUser($id)
    {
        return Order::where('customer_id', $id)->get();
    }
    public function orderListByUserWeb($id)
    {
        return Order::where('customer_id', $id)->paginate(10);
    }

    public function get($id)
    {
        return Order::with('prescriptions', 'address.area.thana.district')->where('id', $id)->first();
    }

    public function getNearestPharmacyId($address_id) {
        $address = CustomerAddress::find($address_id);
        $pharmacy = PharmacyBusiness::where('area_id', $address->area_id)->inRandomOrder()->first();

        return  $pharmacy ? $pharmacy->user_id : '';
    }

    public function create($request, $customer_id)
    {
        logger('Into the Order repository create method');
        $order = new Order();
        logger('Into the Order controller create method pharmacy_id');
        $pharmacy_id = $request->get('pharmacy_id') ? $request->get('pharmacy_id') : $this->getNearestPharmacyId($request->get('shipping_address_id'));
        logger('End of Order controller create method pharmacy_id');
        if (empty($pharmacy_id)) {
            throw new NotFoundHttpException('Pharmacy Not Found');
        }
        $delivery_time = Carbon::parse($request->get('delivery_time'))->format('H:i');

        $order->phone_number = $request->get('phone_number');
        $order->payment_type = $request->get('payment_type');
        $order->delivery_type = $request->get('delivery_type');
        $order->status = 0;
        $order->delivery_charge = $request->get('delivery_charge');
        $order->amount = $request->get('amount');
        $order->order_date = Carbon::now()->format('Y-m-d');
        $order->delivery_time = $delivery_time;
        $order->notes = $request->get('notes');
        logger('Start of Order controller create method customer: '. $customer_id);
        $order->customer_id = $customer_id;
        $order->pharmacy_id = $pharmacy_id;
        logger('end of Order controller create method customer: '. $customer_id);
        $order->shipping_address_id = $request->get('shipping_address_id');
        $order->delivery_method = $request->get('delivery_method');
        $order->delivery_date = $request->get('delivery_date');
        logger('Start of generate OrderNo()');
        $order->order_no = $this->generateOrderNo();
        logger('End of generate OrderNo()');

        if ($order->delivery_type == config('subidha.home_delivery')) {

            if ($order->delivery_method == config('subidha.normal_delivery')) {

                if ($order->payment_type == config('subidha.cod_payment_type')) {

                    $delivery_value = number_format(
                    (($request->get('amount')) * config('subidha.subidha_comission_cash_percentage') / 100) +
                        config('subidha.normal_delivery_charge') ,2 );

                    $amount_value = number_format(($request->get('amount')) *
                        config('subidha.subidha_comission_cash_percentage') / 100 , 2);

                    $order->subidha_comission = $amount_value + $delivery_value;
                }
                if ($order->payment_type == config('subidha.ecash_payment_type')) {

                    $delivery_value = number_format( config('subidha.normal_delivery_charge') +
                        config('subidha.subidha_delivery_percentage') / 100 , 2);
                    $amount_value = number_format(($request->get('amount')) *
                        config('subidha.subidha_comission_ecash_percentage') / 100 , 2);
                    $order->subidha_comission = $amount_value + $delivery_value;
                }

            }
            if ($order->delivery_method == config('subidha.express_delivery')) {
                logger('Into subidha express delivery');
                if ($order->payment_type == config('subidha.cod_payment_type')) {
                    logger('Into subidha cod payment');
                    $delivery_value = number_format(
                        (($request->get('amount')) * config('subidha.subidha_comission_cash_percentage') / 100) +
                        config('subidha.express_delivery_charge') * config('subidha_delivery_percentage') /100, 2);

                    $amount_value = number_format(($request->get('amount')) *
                        config('subidha.subidha_comission_cash_percentage') / 100 , 2);

                    logger('Assigning subidha comission in cod payment');
                    $order->subidha_comission = $amount_value + $delivery_value;
                    logger('Subidha comission in cod payment: ' . $order->subidha_comission);

                }
                if ($order->payment_type == config('subidha.ecash_payment_type')) {
                    logger('Into subidha ecash payment method');
                    $delivery_value = number_format(
                        config('subidha.express_delivery_charge') * config('subidha_delivery_percentage') /100 , 2);

                    $amount_value = number_format(($request->get('amount')) *
                        config('subidha.subidha_comission_ecash_percentage') / 100 , 2);

                    $order->subidha_comission = $amount_value + $delivery_value;
                }
            }

        }
        if ($order->delivery_type == config('subidha.pickup_from_pharmacy')) {

            if ($order->payment_type == config('subidha.cod_payment_type')) {

                $amount_value = number_format(($request->get('amount')) *
                    config('subidha.subidha_comission_collect_from_pharmacy_cash_percentage') / 100 , 2);

                $order->subidha_comission = $amount_value ;

            }
            if ($order->payment_type == config('subidha.ecash_payment_type')) {

                $amount_value = number_format(($request->get('amount')) *
                    config('subidha.subidha_comission_collect_from_pharmacy_ecash_percentage') / 100 , 2);

                $order->subidha_comission = $amount_value;
            }
        }




        logger($order);
        $order->save();

        OrderHistory::create([
            'order_id' => $order->id,
            'user_id' => $pharmacy_id,
            'status' => $order->status
        ]);

        if ( $request->order_items ) {
            logger('Into the Order items');
            // $order->orderItems()->saveMany($request->order_items);
            $this->storeAssociateProducts($request->order_items, $order->id);
            logger('End of Order Items');
        }

        if ( $request->prescriptions ) {
            logger('Into the prescription');
            $this->storeAssociatePrescriptions($request->prescriptions, $order->id);
            logger('End of prescription');
        }

        $deviceIds = UserDeviceId::where('user_id',$pharmacy_id)->get();
        $title = 'New Order Available';
        $message = 'You have a new order from Subidha. Please check.';

        foreach ($deviceIds as $deviceId){
            sendPushNotification($deviceId->device_id, $title, $message, $id="");
        }

        return $order;
    }


    public function generateOrderNo()
    {
        $latestOrder = Order::orderBy('id', 'desc')->first();
        if ($latestOrder) {
            $lastNumber = explode('-', $latestOrder->order_no);
            $lastNumber = preg_replace("/[^0-9]/", "", end($lastNumber) );
//            $orderNo =  date('Y').'-'.date('m').'-'.str_pad( (int) $lastNumber + 1 , 4, '0', STR_PAD_LEFT);
            $orderNo =  'SBD-'.str_pad( (int) $lastNumber + 1 , 6, '0', STR_PAD_LEFT);
            if (Order::where('order_no', $orderNo)->count() > 0) {
                $this->generateOrderNo();
            }

            return $orderNo;
        }

        return date('Y').'-'.date('m').'-001';
    }

    public function storeAssociateProducts($items, $order_id)
    {
        if (is_array($items) && count($items) > 0 ) {
            foreach($items as $item) {
                OrderItems::create([
                    'product_id' => $item['product_id'],
                    'rate' => $item['rate'],
                    'quantity' => $item['quantity'],
                    'order_id' => $order_id,
                ]);
            }
        }
    }

    public function storeAssociatePrescriptions($items, $order_id)
    {
        if (is_array($items) && count($items) > 0 ) {
            foreach($items as $item) {
                OrderPrescription::create([
                    'prescription_id' => $item,
                    'order_id' => $order_id,
                ]);
            }
        }
    }

    public function updateStatus($order_id, $status_id) {
        $order = Order::with('address')->find($order_id);

        if ($order->status == 8 ) {
            return responseData('Orphan order');
        }

        if ($status_id == 5 || $status_id == 6) {

            $user = Auth::user();
            $pharmacy_id = Order::where('pharmacy_id', $user->id)->where('id', $order_id)->first();

            if (! $pharmacy_id) {
                return responsePreparedData([
                    'error' => true,
                    'message' => 'This order is already forwarded'
                ]);
            }

           return $this->forwardOrder($order_id, $status_id);
        }

        $order->status = $status_id;
        $order->save();

        return responseData('Order status updated');
    }

    public function forwardOrder($order_id, $status_id) {
        $order = Order::with('address')->find($order_id);

        $previousPharmacyOrderHistory = OrderHistory::where('user_id',$order->pharmacy_id)->where('order_id', $order_id)->first();
        $previousPharmacyOrderHistory->status = $status_id;
        $previousPharmacyOrderHistory->save();

        $previousPharmacies = OrderHistory::where('order_id', $order->id)->pluck('user_id');
        $previousPharmacies[] = $order->pharmacy_id;
        $nearestPharmacy = PharmacyBusiness::where('area_id', $order->address->area_id)
            ->whereNotIn('user_id', $previousPharmacies)
            ->inRandomOrder()->first();

        if ($nearestPharmacy) {
            $orderHistory = new OrderHistory();
            $orderHistory->order_id = $order->id;
            $orderHistory->user_id = $nearestPharmacy->user_id;
            $orderHistory->status = 0;
            $orderHistory->save();

            $order->pharmacy_id = $nearestPharmacy->user_id;
            $order->status = 0;
            $order->save();
            return responseData('Order status updated');
        }

        $order->status = 8;
        $order->save();

        $orderHistory = new OrderHistory();
        $orderHistory->order_id = $order->id;
        $orderHistory->user_id = $order->pharmacy_id;
        $orderHistory->status = $status_id;
        $orderHistory->save();

        return responseData('Order status updated');
    }

    public function pharmacyOrdersByStatus($request, $pharmacy_id, $status_id)
    {
        $order = Order::query();


        if ($request->has('search') && $request->get('search')) {
            $search = $request->get('search');
            $order->where('order_no', $search);
        }

        if ($status_id == 2) {
            return $order->with(['orderItems.product', 'address.area.thana.district', 'pharmacy'])
                ->where('pharmacy_id', $pharmacy_id)
                ->whereIn('status', [2,9])
                ->orderBy('id','desc')
                ->paginate(5);
        }
        return $order->with(['address.area.thana.district', 'orderItems.product' => function($q) {
            $q->orderBy('is_pre_order', 'desc');
        }])
            ->where('pharmacy_id', $pharmacy_id)
            ->where('status', $status_id)
            ->orderBy('delivery_method','ASC')
            ->orderBy('updated_at', 'desc')
//            ->orderBy('id','desc')
            ->paginate(20);

//        return $order->with(['address', 'pharmacy'])
//            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
//            ->where('pharmacy_id', $pharmacy_id)
//            ->where('status', $status_id)
//            ->orderBy('delivery_method','ASC')
//            ->orderBy('id','desc')
//            ->paginate(20);
    }

    public function pharmacyOrderCancelReason($pharmacy_id, $request)
    {
        return OrderCancelReason::create([
            'user_id' => $pharmacy_id,
            'order_id' => $request->order_id,
            'reason' => $request->reason,
        ]);
    }

    public function ordersByStatus($request)
    {
        $order = Order::query();

        if ($request->has('status')) {

            $status = $request->get('status');
            if ( $status == 2) {
                $order->whereIn('status', [2,9]);
            } else {
                $order->where('status', $status);
            }

//            return Order::with(['orderItems.product', 'address', 'pharmacy'])
//                ->where('status', $request->get('status'))
//                ->orderBy('id','desc')
//                ->paginate(10);
        }
        return $order->with(['orderItems.product', 'address', 'pharmacy'])
            ->orderBy('id','desc')
            ->paginate(10);

    }

    public function getOrderDetails($id)
    {
        return Order::with(['orderItems.product', 'address.area.thana.district', 'pharmacy.pharmacyBusiness', 'customer'])
            ->where('id', $id)
            ->first();

    }
}
