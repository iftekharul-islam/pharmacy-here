<?php


namespace Modules\Orders\Repositories;

use Carbon\Carbon;
use Modules\Address\Entities\CustomerAddress;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\OrderHistory;
use Modules\Orders\Entities\Models\OrderItems;
use Modules\Orders\Entities\Models\OrderPrescription;
use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\UserDeviceId;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderRepository
{
    /**
     * @param $pharmacy_id
     * @return mixed
     */
    public function byPharmacyId($pharmacy_id)
    {
        return Order::with(['orderItems.product', 'address', 'pharmacy'])
            ->where('pharmacy_id', $pharmacy_id)->get();
    }

    /**
     * @param $customer_id
     * @return mixed
     */
    public function byCustomerId($customer_id)
    {
        return Order::with(['orderItems.product', 'address', 'pharmacy'])
            ->where('customer_id', $customer_id)
            ->paginate(20);
    }

    public function get($id)
    {
        return Order::where('id', $id)->first();
    }

    public function getNearestPharmacyId($address_id) {
        $address = CustomerAddress::find($address_id);
        $pharmacy = PharmacyBusiness::where('area_id', $address->area_id)->inRandomOrder()->first();

        return  $pharmacy ? $pharmacy->user_id : '';
    }

    public function create($request, $customer_id)
    {
        $order = new Order();
        $pharmacy_id = $request->get('pharmacy_id') ? $request->get('pharmacy_id') : $this->getNearestPharmacyId($request->get('shipping_address_id'));
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
        $order->customer_id = $customer_id;
        $order->pharmacy_id = $pharmacy_id;
        $order->shipping_address_id = $request->get('shipping_address_id');

        $order->save();

        if ( $request->order_items ) {
            // $order->orderItems()->saveMany($request->order_items);
            $this->storeAssociateProducts($request->order_items, $order->id);
        }

        if ( $request->prescriptions ) {
            $this->storeAssociatePrescriptions($request->prescriptions, $order->id);
        }

        $deviceIds = UserDeviceId::where('user_id',$pharmacy_id)->get();
        logger('device ids: '.  $deviceIds);
        $title = 'New Order Available';

        foreach ($deviceIds as $deviceId){
            sendPushNotification($deviceId, $title, $request->order_items, $id="");
        }


        return $order;
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
           return $this->forwardOrder($order_id, $status_id);
        }

        $order->status = $status_id;
        $order->save();

        return responseData('Order status updated');
    }

    public function forwardOrder($order_id, $status_id) {
        $order = Order::with('address')->find($order_id);
        $previousPharmacies = OrderHistory::where('order_id', $order->id)->pluck('user_id');
        $previousPharmacies[] = $order->pharmacy_id;
        $nearestPharmacy = PharmacyBusiness::where('area_id', $order->address->area_id)
            ->whereNotIn('user_id', $previousPharmacies)
            ->inRandomOrder()->first();

        if ($nearestPharmacy) {
            $orderHistory = new OrderHistory();
            $orderHistory->order_id = $order->id;
            $orderHistory->user_id = $order->pharmacy_id;
            $orderHistory->status = $status_id;
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

    public function pharmacyOrdersByStatus($pharmacy_id, $status_id)
    {
        return Order::with(['orderItems.product', 'address', 'pharmacy'])
            ->where('pharmacy_id', $pharmacy_id)->where('status', $status_id)->paginate(10);
    }
}
