<?php


namespace Modules\Orders\Repositories;

use App\Jobs\SendNotificationToAdmin;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Modules\Address\Entities\CustomerAddress;
use Modules\Locations\Entities\Models\District;
use Modules\Orders\Emails\SendOrderStatusEmail;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\OrderCancelReason;
use Modules\Orders\Entities\Models\OrderHistory;
use Modules\Orders\Entities\Models\OrderItems;
use Modules\Orders\Entities\Models\OrderPrescription;
use Modules\Points\Entities\Models\Points;
use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\User;
use Modules\User\Entities\Models\UserDeviceId;
use Modules\User\Entities\Models\Weekends;
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

    public function orderWeb($id)
    {
        return Order::with('address.area.thana.district', 'orderItems', 'orderItems.product')->where('customer_id', Auth::user()->id)->where('id', $id)->first();
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
        return Order::where('customer_id', $id)->orderBy('id', 'desc')->paginate(10);
    }

    public function get($id)
    {
        return Order::with('prescriptions', 'address.area.thana.district')->where('id', $id)->first();
    }

    public function getNearestPharmacyId($address_id)
    {
        $address = CustomerAddress::with('area.thana.district')->find($address_id);
        $dhaka_district = District::where('slug', 'dhaka')->first();

        $pharmacy = PharmacyBusiness::where('area_id', $address->area_id)
            ->whereHas('user', function ($q) {
                $q->where('status', 1);
            })->inRandomOrder()->first();

        if (!$pharmacy && $dhaka_district->id != $address->area->thana->district_id) {
            $pharmacy = PharmacyBusiness::whereHas('area', function ($q) use ($address) {
                $q->where('thana_id', $address->area->thana_id);
            })->whereHas('user', function ($q) {
                $q->where('status', 1);
            })->inRandomOrder()->first();

            return $pharmacy ? $pharmacy->user_id : '';
        }
        return $pharmacy ? $pharmacy->user_id : '';
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
        $order->delivery_method = $request->get('delivery_method');
        $order->delivery_date = $request->get('delivery_date');
        $order->is_rated = "no";
        $order->order_no = $this->generateOrderNo();
        $order->point_amount = round($request->get('point_amount'), 2);
        $order->points = $request->get('points');
        $order->delivery_duration = $request->get('delivery_duration');
        $order->ssl_charge = $request->get('ssl_charge') ?? '';

        if ($order->delivery_type == config('subidha.home_delivery')) {

            if ($request->amount <= config('subidha.free_delivery_limit')) {
                if ($order->delivery_method == config('subidha.normal_delivery')) {

                    if ($order->payment_type == config('subidha.cod_payment_type')) {

                        $delivery_value = config('subidha.normal_delivery_charge') * config('subidha.subidha_delivery_percentage') / 100;

                        $amount_value = round(($request->get('amount')) *
                            config('subidha.subidha_comission_cash_percentage') / 100, 2);

                        $total_value = round((($request->get('amount')) * config('subidha.subidha_comission_cash_percentage') / 100), 2);

                        $order->subidha_comission = ($amount_value + $delivery_value + $total_value - $order->point_amount);

//                        $order->pharmacy_amount = (($request->get('amount')) + config('subidha.normal_delivery_charge') + $amount_value - $order->subidha_comission);
//                        $order->customer_amount = (($request->get('amount')) + config('subidha.normal_delivery_charge') + $amount_value);

                        $order->pharmacy_amount = (($request->get('amount')) + config('subidha.normal_delivery_charge') + $amount_value - $order->subidha_comission);
//                        $order->subidha_comission = $order->subidha_comission - $order->point_amount;
                        $order->customer_amount = (($request->get('amount')) + config('subidha.normal_delivery_charge') + $amount_value - $order->point_amount);
                    }
                    if ($order->payment_type == config('subidha.ecash_payment_type')) {

                        $delivery_value = round(config('subidha.normal_delivery_charge') *
                            config('subidha.subidha_delivery_percentage') / 100, 2);

                        $amount_value = round(($request->get('amount')) *
                            config('subidha.subidha_comission_ecash_percentage') / 100, 2);

                        $ssl_value = round((($request->get('amount')) + config('subidha.normal_delivery_charge')) *
                            config('subidha.ecash_payment_charge_percentage') / 100, 2);

                        $order->subidha_comission = round(($amount_value + $delivery_value), 2);
                        $order->pharmacy_amount = round((($request->get('amount')) + config('subidha.normal_delivery_charge') - $order->subidha_comission), 2);
                        $order->customer_amount = round((($request->get('amount')) + config('subidha.normal_delivery_charge') + $ssl_value), 2);


                    }

                }

                if ($order->delivery_method == config('subidha.express_delivery')) {
                    if ($order->payment_type == config('subidha.cod_payment_type')) {

                        $delivery_value = config('subidha.express_delivery_charge') * config('subidha.subidha_delivery_percentage') / 100;

                        $amount_value = round(($request->get('amount')) *
                            config('subidha.subidha_comission_cash_percentage') / 100, 2);

                        $total_value = round(($request->get('amount')) * config('subidha.subidha_comission_cash_percentage') / 100, 2);

                        logger('Assigning subidha comission in epay payment');

                        $order->subidha_comission = round(($amount_value + $delivery_value + $total_value), 2);
                        $order->pharmacy_amount = round((($request->get('amount')) + config('subidha.express_delivery_charge') + $amount_value - $order->subidha_comission), 2);
                        $order->customer_amount = round((($request->get('amount')) + config('subidha.express_delivery_charge') + $amount_value), 2);

                    }
                    if ($order->payment_type == config('subidha.ecash_payment_type')) {

                        $delivery_value = config('subidha.express_delivery_charge') *
                            config('subidha.subidha_delivery_percentage') / 100;

                        $amount_value = number_format(($request->get('amount')) *
                            config('subidha.subidha_comission_ecash_percentage') / 100, 2);

                        $ssl_value = number_format((($request->get('amount')) + config('subidha.express_delivery_charge')) *
                            config('subidha.ecash_payment_charge_percentage') / 100, 2);

                        $order->subidha_comission = round(($amount_value + $delivery_value), 2);
                        $order->pharmacy_amount = round((($request->get('amount')) + config('subidha.express_delivery_charge') - $order->subidha_comission), 2);
                        $order->customer_amount = round((($request->get('amount')) + config('subidha.express_delivery_charge') + $ssl_value), 2);

                    }
                }

            } else {
                if ($order->delivery_method == config('subidha.normal_delivery')) {

                    if ($order->payment_type == config('subidha.cod_payment_type')) {

                        $amount_value = round(($request->get('amount')) *
                            config('subidha.subidha_comission_cash_percentage') / 100, 2);

                        $total_value = round((($request->get('amount')) * config('subidha.subidha_comission_cash_percentage') / 100));

                        $order->subidha_comission = $amount_value + $total_value;
                        $order->pharmacy_amount = round((($request->get('amount')) + $amount_value - $order->subidha_comission), 2);
                        $order->customer_amount = round((($request->get('amount')) + $amount_value), 2);

                    }
                    if ($order->payment_type == config('subidha.ecash_payment_type')) {

                        $amount_value = ($request->get('amount')) *
                            config('subidha.subidha_comission_ecash_percentage') / 100;

                        $ssl_value = round(($request->get('amount')) *
                            config('subidha.ecash_payment_charge_percentage') / 100, 2);


                        $order->subidha_comission = round($amount_value, 2);
                        $order->pharmacy_amount = round((($request->get('amount')) - $order->subidha_comission), 2);
                        $order->customer_amount = round((($request->get('amount')) + $ssl_value), 2);

                    }

                }

                if ($order->delivery_method == config('subidha.express_delivery')) {
                    if ($order->payment_type == config('subidha.cod_payment_type')) {

                        $delivery_value = config('subidha.express_delivery_charge') * config('subidha.subidha_delivery_percentage') / 100;

                        $amount_value = round(($request->get('amount')) *
                            config('subidha.subidha_comission_cash_percentage') / 100, 2);

                        $total_value = round(($request->get('amount')) * config('subidha.subidha_comission_cash_percentage') / 100, 2);

                        $order->subidha_comission = round(($amount_value + $delivery_value + $total_value), 2);
                        $order->pharmacy_amount = round((($request->get('amount')) + config('subidha.express_delivery_charge') + $amount_value - $order->subidha_comission), 2);
                        $order->customer_amount = round((($request->get('amount')) + config('subidha.express_delivery_charge') + $amount_value), 2);

                    }
                    if ($order->payment_type == config('subidha.ecash_payment_type')) {

                        $delivery_value = config('subidha.express_delivery_charge') *
                            config('subidha.subidha_delivery_percentage') / 100;

                        $amount_value = round(($request->get('amount')) *
                            config('subidha.subidha_comission_ecash_percentage') / 100, 2);

                        $ssl_value = round((($request->get('amount')) + config('subidha.express_delivery_charge')) *
                            config('subidha.ecash_payment_charge_percentage') / 100, 2);

                        $order->subidha_comission = round(($amount_value + $delivery_value), 2);
                        $order->pharmacy_amount = round((($request->get('amount')) + config('subidha.express_delivery_charge') - $order->subidha_comission), 2);
                        $order->customer_amount = round((($request->get('amount')) + config('subidha.express_delivery_charge') + $ssl_value), 2);

                    }
                }
            }


        }
        if ($order->delivery_type == config('subidha.pickup_from_pharmacy')) {

            if ($order->payment_type == config('subidha.cod_payment_type')) {

                $amount_value = round(($request->get('amount')) *
                    config('subidha.subidha_comission_collect_from_pharmacy_cash_percentage') / 100, 2);

                $orderAmount = $request->get('amount') - $amount_value;

                $order->subidha_comission = round($amount_value, 2);
                $order->pharmacy_amount = round(($orderAmount - $order->subidha_comission), 2);
                $order->customer_amount = round($orderAmount, 2);

            }
            if ($order->payment_type == config('subidha.ecash_payment_type')) {

                $amount_value = round(($request->get('amount')) *
                    config('subidha.subidha_comission_collect_from_pharmacy_ecash_percentage') / 100, 2);

                $ssl_value = round(($request->get('amount')) * config('subidha.ecash_payment_charge_percentage') / 100, 2);

                $order->subidha_comission = round($amount_value, 2);
                $order->pharmacy_amount = round(($request->get('amount') - ($ssl_value + $order->subidha_comission)), 2);
                $order->customer_amount = round(($request->get('amount')), 2);


            }
        }

        if ($order->point_amount != null) {
            $order->subidha_comission = $order->subidha_comission - $order->point_amount;
            $order->customer_amount = $order->customer_amount - $order->point_amount;
        }
        $order->ssl_charge = $ssl_value ?? '';


        logger("Before Saving LOG");
        logger($order);
        $order->save();

        if ($request->has('points') && $request->get('points')) {
            Points::create([
                'user_id' => $customer_id,
                'points' => 0 - $request->get('points'),
                'type' => 'order',
                'type_id' => $order->id,
            ]);
        }

        OrderHistory::create([
            'order_id' => $order->id,
            'user_id' => $pharmacy_id,
            'status' => $order->status
        ]);

        if ($request->order_items) {
            $this->storeAssociateProducts($request->order_items, $order->id);
        }

        if ($request->prescriptions) {
            $this->storeAssociatePrescriptions($request->prescriptions, $order->id);
        }

        $deviceIds = UserDeviceId::where('user_id', $pharmacy_id)->get();
        $title = 'New Order Available';
        $message = 'You have a new order from Subidha. Please check.';

        foreach ($deviceIds as $deviceId) {
            sendPushNotification($deviceId->device_id, $title, $message, $id = "");
        }

        return $order;
    }

    public function createWeb($request)
    {
        $data = $request->only([
            'phone_number',
            'payment_type',
            'delivery_type',
            'delivery_charge',
            'delivery_method',
            'status',
            'amount',
            'order_date',
            'pharmacy_id',
            'shipping_address_id',
            'prescriptions',
            'delivery_method',
            'delivery_date',
            'customer_id',
            'delivery_time',
            'is_rated',
            'note',
            'subidha_comission',
            'pharmacy_amount',
            'customer_amount',
            'delivery_duration',
            'point_amount'

        ]);

        $data['order_no'] = $this->generateOrderNo();
        $data['order_date'] = Carbon::today()->format('Y-m-d');
        $data['customer_id'] = Auth::user()->id;
        $data['pharmacy_id'] = $request->pharmacy_id ? $request->pharmacy_id : $this->getNearestPharmacyId($data['shipping_address_id']);
        $data['notes'] = "Its a sample for cod";
        $data['is_rated'] = "no";
        $data['point_amount'] = 0;

        if ($request->delivery_charge_amount != null) {
            $data['delivery_charge'] = $request->delivery_charge_amount;
        } else {
            $data['delivery_charge'] = 0;
        }

        if ($request->delivery_charge == 1) {
            $data['delivery_method'] = 'normal';
        } else {
            $data['delivery_method'] = 'express';
        }

        if ($request->delivery_charge == 1) {
            $data['delivery_date'] = $request->normal_delivery_date;
            $data['delivery_time'] = $request->normal_delivery_time;
        } else {
            $data['delivery_date'] = $request->express_delivery_date;
            $data['delivery_time'] = $request->express_delivery_time;
        }

        if (isset($data['delivery_date'])) {
            $data['delivery_date'] = Carbon::createFromFormat('d-m-Y', $data['delivery_date'])->format('Y-m-d');
        }


        if ($request->delivery_type == config('subidha.home_delivery')) {
            logger('1 st in');
            if ($request->amount <= config('subidha.free_delivery_limit')) {
                logger('1 st in 1 st');
                if ($data['delivery_method'] == config('subidha.normal_delivery')) {
                    logger('1 st in 1 st in 1st');
                    if ($request->payment_type == config('subidha.cod_payment_type')) {
                        logger('1 in');

                        $delivery_value = config('subidha.normal_delivery_charge') * config('subidha.subidha_delivery_percentage') / 100;

                        $amount_value = round(($request->get('amount')) *
                            config('subidha.subidha_comission_cash_percentage') / 100, 2);

                        $total_value = round((($request->get('amount')) * config('subidha.subidha_comission_cash_percentage') / 100), 2);

                        $data['subidha_comission'] = ($amount_value + $delivery_value + $total_value);

                        $data['pharmacy_amount'] = (($request->get('amount')) + config('subidha.normal_delivery_charge') + $amount_value - $data['subidha_comission']);
                        $data['customer_amount'] = (($request->get('amount')) + config('subidha.normal_delivery_charge') + $amount_value);

                    }
                    if ($request->payment_type == config('subidha.ecash_payment_type')) {
                        logger('2 in');

                        $delivery_value = round(config('subidha.normal_delivery_charge') *
                            config('subidha.subidha_delivery_percentage') / 100, 2);

                        $amount_value = round(($request->get('amount')) *
                            config('subidha.subidha_comission_ecash_percentage') / 100, 2);

                        $ssl_value = round((($request->get('amount')) + config('subidha.normal_delivery_charge')) *
                            config('subidha.ecash_payment_charge_percentage') / 100, 2);

                        $data['subidha_comission'] = round(($amount_value + $delivery_value), 2);
                        $data['pharmacy_amount'] = round((($request->get('amount')) + config('subidha.normal_delivery_charge') - $data['subidha_comission']), 2);
                        $data['customer_amount'] = round((($request->get('amount')) + config('subidha.normal_delivery_charge') + $ssl_value), 2);


                    }

                }
                if ($data['delivery_method'] == config('subidha.express_delivery')) {
                    if ($request->payment_type == config('subidha.cod_payment_type')) {
                        logger('3 in');
                        logger('Into subidha epay payment');

                        $delivery_value = config('subidha.express_delivery_charge') * config('subidha.subidha_delivery_percentage') / 100;

                        $amount_value = round(($request->get('amount')) *
                            config('subidha.subidha_comission_cash_percentage') / 100, 2);

                        $total_value = round(($request->get('amount')) * config('subidha.subidha_comission_cash_percentage') / 100, 2);

                        logger('Assigning subidha comission in epay payment');

                        $data['subidha_comission'] = round(($amount_value + $delivery_value + $total_value), 2);
                        $data['pharmacy_amount'] = round((($request->get('amount')) + config('subidha.express_delivery_charge') + $amount_value - $data['subidha_comission']), 2);
                        $data['customer_amount'] = round((($request->get('amount')) + config('subidha.express_delivery_charge') + $amount_value), 2);

                    }
                    if ($request->payment_type == config('subidha.ecash_payment_type')) {
                        logger('Into subidha ecash payment method');
                        logger('4 in');

                        $delivery_value = config('subidha.express_delivery_charge') *
                            config('subidha.subidha_delivery_percentage') / 100;

                        $amount_value = number_format(($request->get('amount')) *
                            config('subidha.subidha_comission_ecash_percentage') / 100, 2);

                        $ssl_value = number_format((($request->get('amount')) + config('subidha.express_delivery_charge')) *
                            config('subidha.ecash_payment_charge_percentage') / 100, 2);

                        $data['subidha_comission'] = round(($amount_value + $delivery_value), 2);
                        $data['pharmacy_amount'] = round((($request->get('amount')) + config('subidha.express_delivery_charge') - $data['subidha_comission']), 2);
                        $data['customer_amount'] = round((($request->get('amount')) + config('subidha.express_delivery_charge') + $ssl_value), 2);

                    }
                }

            } else {
                logger('inside else');
                if ($data['delivery_method'] == config('subidha.normal_delivery')) {

                    if ($request->payment_type == config('subidha.cod_payment_type')) {
                        logger('5 in');

                        $amount_value = round(($request->get('amount')) *
                            config('subidha.subidha_comission_cash_percentage') / 100, 2);

                        $total_value = round((($request->get('amount')) * config('subidha.subidha_comission_cash_percentage') / 100), 2);

                        $data['subidha_comission'] = $amount_value + $total_value;
                        $data['pharmacy_amount'] = round((($request->get('amount')) + $amount_value - $data['subidha_comission']), 2);
                        $data['customer_amount'] = round((($request->get('amount')) + $amount_value), 2);

                    }
                    if ($request->payment_type == config('subidha.ecash_payment_type')) {
                        logger('6 in');

                        $amount_value = ($request->get('amount')) *
                            config('subidha.subidha_comission_ecash_percentage') / 100;

                        $ssl_value = round(($request->get('amount')) *
                            config('subidha.ecash_payment_charge_percentage') / 100, 2);


                        $data['subidha_comission'] = round($amount_value, 2);
                        $data['pharmacy_amount'] = round((($request->get('amount')) - $data['subidha_comission']), 2);
                        $data['customer_amount'] = round((($request->get('amount')) + $ssl_value), 2);

                    }

                }

                if ($data['delivery_method'] == config('subidha.express_delivery')) {
                    if ($request->payment_type == config('subidha.cod_payment_type')) {
                        logger('Into subidha epay payment');
                        logger('7 in');

                        $delivery_value = config('subidha.express_delivery_charge') * config('subidha.subidha_delivery_percentage') / 100;

                        $amount_value = round(($request->get('amount')) *
                            config('subidha.subidha_comission_cash_percentage') / 100, 2);

                        $total_value = round(($request->get('amount')) * config('subidha.subidha_comission_cash_percentage') / 100, 2);

                        logger('Assigning subidha comission in epay payment');

                        $data['subidha_comission'] = round(($amount_value + $delivery_value + $total_value), 2);
                        $data['pharmacy_amount'] = round((($request->get('amount')) + config('subidha.express_delivery_charge') + $amount_value - $data['subidha_comission']), 2);
                        $data['customer_amount'] = round((($request->get('amount')) + config('subidha.express_delivery_charge') + $amount_value), 2);

                        logger('Subidha comission in epay payment: ' . $data['subidha_comission']);

                    }
                    if ($request->payment_type == config('subidha.ecash_payment_type')) {
                        logger('Into subidha ecash payment method');
                        logger('8 in');

                        $delivery_value = config('subidha.express_delivery_charge') *
                            config('subidha.subidha_delivery_percentage') / 100;

                        $amount_value = number_format(($request->get('amount')) *
                            config('subidha.subidha_comission_ecash_percentage') / 100, 2);

                        $ssl_value = number_format((($request->get('amount')) + config('subidha.express_delivery_charge')) *
                            config('subidha.ecash_payment_charge_percentage') / 100, 2);

                        $data['subidha_comission'] = round(($amount_value + $delivery_value), 2);
                        $data['pharmacy_amount'] = round((($request->get('amount')) + config('subidha.express_delivery_charge') - $data['subidha_comission']), 2);
                        $data['customer_amount'] = round((($request->get('amount')) + config('subidha.express_delivery_charge') + $ssl_value), 2);

                    }
                }
            }


        }
        if ($request->delivery_type == config('subidha.pickup_from_pharmacy')) {

            if ($request->payment_type == config('subidha.cod_payment_type')) {

                $amount_value = round(($request->get('amount')) *
                    config('subidha.subidha_comission_collect_from_pharmacy_cash_percentage') / 100, 2);

                $orderAmount = $request->get('amount') - $amount_value;

                $data['subidha_comission'] = round($amount_value, 2);
                $data['pharmacy_amount'] = round(($orderAmount - $data['subidha_comission']), 2);
                $data['customer_amount'] = round($orderAmount, 2);

            }
            if ($request->payment_type == config('subidha.ecash_payment_type')) {

                $amount_value = round(($request->get('amount')) *
                    config('subidha.subidha_comission_collect_from_pharmacy_ecash_percentage') / 100, 2);

                $ssl_value = round(($request->get('amount')) * config('subidha.ecash_payment_charge_percentage') / 100, 2);

                $data['subidha_comission'] = round($amount_value, 2);
                $data['pharmacy_amount'] = round(($request->get('amount') - ($ssl_value + $data['subidha_comission'])), 2);
                $data['customer_amount'] = round(($request->get('amount')), 2);

            }
        }
        logger('data amount');
        logger($data['subidha_comission']);
        logger($data['pharmacy_amount']);
        logger($data['customer_amount']);

        $data['amount'] = round($request->amount, 2);
        $data['subidha_comission'] = round($data['subidha_comission'], 2);
        $data['pharmacy_amount'] = round($data['pharmacy_amount'], 2);
        $data['customer_amount'] = round($data['customer_amount'], 2);

        $order = Order::create($data);

        OrderHistory::create([
            'order_id' => $order->id,
            'user_id' => $data['pharmacy_id'],
            'status' => $order->status
        ]);

        if ($request->order_items) {
            $items = json_decode($request->order_items, true);
            foreach ($items as $item) {
                OrderItems::create([
                    'product_id' => $item['product_id'],
                    'rate' => $item['product']['purchase_price'],
                    'quantity' => $item['quantity'],
                    'order_id' => $order->id,
                ]);
            }
        }

        if (session()->has('prescriptions')) {
            $prescriptions = session()->get('prescriptions');
            foreach ($prescriptions as $item) {
                OrderPrescription::create([
                    'prescription_id' => $item,
                    'order_id' => $order->id,
                ]);
            }
            session()->forget('prescriptions');
        }

        foreach ($request->cart_ids as $id) {
            $item = Cart::find($id);
            $item->delete();
        }
        session()->forget('cartCount');

        logger($data['pharmacy_id']);
        $deviceIds = UserDeviceId::where('user_id', $data['pharmacy_id'])->groupBy('device_id')->get();
        logger($deviceIds);
        $title = 'New Order Available';
        $message = 'You have a new order from Subidha. Please check.';

        foreach ($deviceIds as $deviceId) {
            logger('sendPushNotification foreach in');
            sendPushNotification($deviceId->device_id, $title, $message, $id = "");
        }

        return true;

    }

    public function generateOrderNo()
    {
        $latestOrder = Order::orderBy('id', 'desc')->first();
        if ($latestOrder) {
            $lastNumber = explode('-', $latestOrder->order_no);
            $lastNumber = preg_replace("/[^0-9]/", "", end($lastNumber));
//            $orderNo =  date('Y').'-'.date('m').'-'.str_pad( (int) $lastNumber + 1 , 4, '0', STR_PAD_LEFT);
            $orderNo = 'SBD-' . str_pad((int)$lastNumber + 1, 6, '0', STR_PAD_LEFT);
            if (Order::where('order_no', $orderNo)->count() > 0) {
                $this->generateOrderNo();
            }

            return $orderNo;
        }

        return 'SBD-' . date('Y') . date('m') . '-001';
    }

    public function storeAssociateProducts($items, $order_id)
    {
        if (is_array($items) && count($items) > 0) {
            foreach ($items as $item) {
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
        if (is_array($items) && count($items) > 0) {
            foreach ($items as $item) {
                OrderPrescription::create([
                    'prescription_id' => $item,
                    'order_id' => $order_id,
                ]);
            }
        }
    }

    public function updateStatus($order_id, $status_id)
    {
        logger('update status Status id');
        logger($status_id);

        $order = Order::with('address')->find($order_id);

        if ($status_id == 3) {
            logger('Order status 3 , completed section');
            $deviceIds = UserDeviceId::where('user_id', $order['customer_id'])->get();
            logger($deviceIds);
            $title = 'Your order is Delivered';
            $message = 'You have a new order notification from Subidha. Please check.';

            foreach ($deviceIds as $deviceId) {
                logger('sendPushNotification foreach in');
                sendPushNotification($deviceId->device_id, $title, $message, $id = "");
            }
        }

        if ($order->status == 8) {
            return responseData('Orphan order');
        }

        if ($status_id == 5 || $status_id == 6) {

            $user = Auth::user();
            $pharmacy_id = Order::where('pharmacy_id', $user->id)->where('id', $order_id)->first();

            if (!$pharmacy_id) {
                return responsePreparedData([
                    'error' => true,
                    'message' => 'This order is already forwarded'
                ]);
            }

            return $this->forwardOrder($order_id, $status_id);
        }

        if ($status_id == 10) {
            $subject = 'An order ID: ' . $order->order_no . ' has been canceled from ' . $order->pharmacy->name;
            SendNotificationToAdmin::dispatch($order, $subject, $isCancel = true);
            logger('Status id');
            logger($status_id);
            logger('Order status canceled');

            return $this->forwardOrder($order_id, $status_id);
        }

        $order->status = $status_id;
        $order->save();

        return responseData('Order status updated');
    }

    public function forwardOrder($order_id, $status_id)
    {
        $order = Order::with('address.area.thana')->where('id', $order_id)->first();

        $previousPharmacyOrderHistory = OrderHistory::where('user_id', $order->pharmacy_id)->where('order_id', $order_id)->first();

        logger('Previous Pharmacy Order History');
        logger($previousPharmacyOrderHistory);
        logger('End of Previous Pharmacy Order History');

        if (!$previousPharmacyOrderHistory) {
            throw new NotFoundHttpException('Previous Pharmacy of this order not found');
        }

        $previousPharmacyOrderHistory->status = $status_id;
        $previousPharmacyOrderHistory->save();

        $previousPharmacies = OrderHistory::where('order_id', $order_id)->pluck('user_id');
        logger('Previous Pharmacies');
        logger($previousPharmacies);

        $previousPharmacies[] = $order->pharmacy_id;

        $dhaka_district = District::where('slug', 'dhaka')->first();

        $nearestPharmacy = PharmacyBusiness::where('area_id', $order->address->area_id)
            ->whereHas('user', function ($q) {
                $q->where('status', 1);
            })->whereNotIn('user_id', $previousPharmacies)->inRandomOrder()->first();

        if (!$nearestPharmacy && $dhaka_district->id != $order->address->area->thana->district_id) {
            $nearestPharmacy = PharmacyBusiness::whereHas('area', function ($q) use ($order) {
                $q->where('thana_id', $order->address->area->thana_id);
            })->whereHas('user', function ($q) {
                $q->where('status', 1);
            })->whereNotIn('user_id', $previousPharmacies)->inRandomOrder()->first();
        }

        if ($nearestPharmacy ?? false) {
            logger('Nearest Pharmacy found');
            logger($nearestPharmacy);

            $orderHistory = new OrderHistory();
            $orderHistory->order_id = $order->id;
            $orderHistory->user_id = $nearestPharmacy->user_id;
            $orderHistory->status = 0;
            $orderHistory->save();

            $order->pharmacy_id = $nearestPharmacy->user_id;
            $order->status = 0;
            $order->save();

            $deviceIds = UserDeviceId::where('user_id', $order->pharmacy_id)->groupBy('device_id')->get();
            $title = 'New Order Available';
            $message = 'You have a new order from Subidha. Please check.';

            foreach ($deviceIds as $deviceId) {
                sendPushNotification($deviceId->device_id, $title, $message, $id = "");
            }

            return responseData('Order status updated');
        }

        $subject = 'An order ID: ' . $order->order_no . ' has been Orphaned';
        SendNotificationToAdmin::dispatch($order, $subject, $isCancel = false);

        $orderHistory = new OrderHistory();
        $orderHistory->order_id = $order->id;
        $orderHistory->user_id = $order->pharmacy_id;
        $orderHistory->status = 8;
        $orderHistory->save();

        $order->pharmacy_id = null;
        $order->status = 8;
        $order->save();

//        $emailMessage = $order->order_no . ' Order status is orphan, please take action immediately.';
//        sendOrderStatusEmail($emailMessage);

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
                ->whereIn('status', [2, 9])
                ->orderBy('id', 'desc')
                ->paginate(5);
        }

        return $order->with('address.area.thana.district', 'orderItems.product')
            ->where('pharmacy_id', $pharmacy_id)
            ->where('status', $status_id)
            ->orderBy('delivery_method', 'ASC')
            ->orderBy('updated_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(20);
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
        $district_id = $request->district_id;
        $thana_id = $request->thana_id;
        $area_id = $request->area_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $data = Order::query();
        $data->with('pharmacy.pharmacyBusiness', 'orderHistory', 'orderHistory.pharmacy')->orderBy('id', 'desc');

        if ($area_id !== null) {
            $data->whereHas('pharmacy.pharmacyBusiness', function ($query) use ($area_id) {
                $query->where('area_id', $area_id);
            });
        }
        if ($thana_id !== null && $area_id == null) {
            $data->whereHas('pharmacy.pharmacyBusiness.area', function ($query) use ($thana_id) {
                $query->where('thana_id', $thana_id);
            });
        }
        if ($district_id !== null && $thana_id == null && $area_id == null) {
            $data->whereHas('pharmacy.pharmacyBusiness.area.thana', function ($query) use ($district_id) {
                $query->where('district_id', $district_id);
            });
        }
        if ($request->status !== null) {
            $data->where('status', $request->status);
        }
        if ($startDate !== null || $endDate !== null) {
            $data->whereBetween('order_date', [$startDate ?? Carbon::today()->subDays(30), $endDate ?? Carbon::today()]);
        }

        return $data->paginate(config('subidha.item_per_page'));

    }

    public function getOrderDetails($id)
    {
        return Order::with(['cancelReason', 'orderItems.product', 'address.area.thana.district', 'pharmacy.pharmacyBusiness', 'customer'])
            ->where('id', $id)
            ->first();

    }

    /**
     * @param $order_id
     * @param $history_id
     * @param $pharmacy_id
     * @return bool
     */
    public function activeOrphanOrder($order_id, $history_id, $pharmacy_id)
    {
        $order = Order::find($order_id);
        if (!$order) {
            return false;
        }
        $order->status = 0;
        $order->pharmacy_id = $pharmacy_id;
        $order->save();

        $orderHistory = OrderHistory::find($history_id);

        if (!$orderHistory) {
            return false;
        }
        $orderHistory->status = 0;
        $orderHistory->save();

        return true;
    }

    /**
     * @param $order_id
     * @param $history_id
     * @param $pharmacy_id
     * @return bool
     */
    public function cancelOrder($order_id, $history_id, $pharmacy_id)
    {
        $order = Order::find($order_id);
        if (!$order) {
            return false;
        }
        $order->status = 10;
        $order->pharmacy_id = $pharmacy_id;
        $order->save();

        $orderHistory = OrderHistory::find($history_id);

        if (!$orderHistory) {
            return false;
        }
        $orderHistory->status = 10;
        $orderHistory->save();

        return true;
    }
}
