<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutCreateRequest;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Cart;
use App\Repositories\CartRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Address\Repositories\AddressRepository;
use Modules\Locations\Repositories\LocationRepository;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\OrderHistory;
use Modules\Orders\Entities\Models\OrderItems;
use Modules\Orders\Entities\Models\OrderPrescription;
use Modules\Orders\Repositories\DeliveryChargeRepository;
use Modules\Orders\Repositories\OrderRepository;
use Modules\User\Entities\Models\User;
use Modules\User\Entities\Models\UserDeviceId;
use Modules\User\Repositories\PharmacyRepository;

class CheckoutController extends Controller
{

    private $addressRepository;
    private $cartRepository;
    private $deliveryRepository;
    private $locationRepository;
    private $orderRepository;
    private $pharmacyRepository;

    public function __construct(CartRepository $cartRepository,
                                AddressRepository $addressRepository,
                                DeliveryChargeRepository $deliveryRepository,
                                LocationRepository $locationRepository,
                                OrderRepository $orderRepository,
                                PharmacyRepository $pharmacyRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->addressRepository = $addressRepository;
        $this->deliveryRepository = $deliveryRepository;
        $this->locationRepository = $locationRepository;
        $this->orderRepository = $orderRepository;
        $this->pharmacyRepository = $pharmacyRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->cartRepository->getCartByCustomer(Auth::user()->id);
        if (count($data) == 0 ) {
            return redirect()->back()->with('failed', 'please add product in cart');
        }
        $delivery_charge = $this->deliveryRepository->deliveryCharge($data->sum('amount'));
        $addresses = $this->addressRepository->getCustomerAddress(Auth::user()->id);
        $isPreOrderMedicine = $this->isPreOrderMedicine($data);
        $allLocations = $this->locationRepository->getLocation();
        $user = User::find(Auth::guard('web')->user()->id);

        return view('checkout.index', compact('data', 'user', 'addresses', 'delivery_charge', 'isPreOrderMedicine', 'allLocations'));
    }
    private function isPreOrderMedicine($medicines) {
        foreach ($medicines as $item) {
            if ($item['product']['is_pre_order']) {
                return true;
            }
        }
        return false;
    }

    public function check(CheckoutCreateRequest $request)
    {
//        if ($request->payment_type == 1){
//        logger('Into the Order controller create method');
//        $order = $this->orderRepository->create($request, Auth::user()->id);
//        logger('End of Order controller create method');
//
//        return redirect()->route('home')->with('success', 'Order successfully placed');


//        return $request->all();

        if ($request->payment_type == 1){
            $data = $request->only([
                'phone_number',
                'payment_type',
                'delivery_type',
                'delivery_charge_amount',
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
                'customer_amount'

            ]);

//            $data['pharmacy_id'] = $this->orderRepository->getNearestPharmacyId($data['shipping_address_id']);
            $data['order_no'] = $this->generateOrderNo();
//            $data['pharmacy_id'] = 1;
            $data['order_date'] = Carbon::today();
            $data['customer_id'] = Auth::user()->id;
            $data['notes'] = "Its a sample" ;
            $data['is_rated'] = "no";

            if ($request->delivery_charge == 1) {
                $data['delivery_method'] = 'normal';
            } else {
                $data['delivery_method'] = 'express';
            }

            if ($request->delivery_charge == 1) {
                $data['delivery_date'] = $request->normal_delivery_date;
                $data['delivery_time'] = $request->normal_delivery_time;
            }else {
                $data['delivery_date'] = $request->express_delivery_date;
                $data['delivery_time'] = $request->express_delivery_time;
            }

            if (isset($data['delivery_date'])){
                $data['delivery_date'] = Carbon::createFromFormat('d-m-Y', $data['delivery_date'])->format('Y-m-d');
            }

            if ($request->delivery_type == config('subidha.home_delivery')) {

                if ($request->amount <= config('subidha.free_delivery_limit')){
                    if ($request->delivery_charge == config('subidha.normal_delivery')) {

                        if ($request->payment_type == config('subidha.cod_payment_type')) {
                            logger('1 in');

                            $delivery_value = config('subidha.normal_delivery_charge') * config('subidha.subidha_delivery_percentage') / 100;

                            $amount_value = round(($request->get('amount')) *
                                config('subidha.subidha_comission_cash_percentage') / 100 , 2);

                            $total_value = round( (($request->get('amount')) * config('subidha.subidha_comission_cash_percentage') / 100), 2);

                            $data['subidha_comission'] =  ($amount_value + $delivery_value + $total_value);

                            $data['pharmacy_amount'] = (($request->get('amount')) + config('subidha.normal_delivery_charge') + $amount_value - $data['subidha_comission'] );
                            $data['customer_amount'] = (($request->get('amount')) + config('subidha.normal_delivery_charge') + $amount_value );

                        }
                        if ($request->payment_type == config('subidha.ecash_payment_type')) {
                            logger('2 in');

                            $delivery_value = round( config('subidha.normal_delivery_charge') *
                                config('subidha.subidha_delivery_percentage') / 100 , 2);

                            $amount_value = round(($request->get('amount')) *
                                config('subidha.subidha_comission_ecash_percentage') / 100 , 2);

                            $ssl_value = round(( ($request->get('amount')) + config('subidha.normal_delivery_charge') ) *
                                config('subidha.ecash_payment_charge_percentage') / 100 , 2);

//                        print_r($amount_value);die();

                            $data['subidha_comission'] = round( ($amount_value + $delivery_value), 2) ;
                            $data['pharmacy_amount'] = round( (($request->get('amount')) + config('subidha.normal_delivery_charge') - $data['subidha_comission'] ), 2);
                            $data['customer_amount'] = round( (($request->get('amount')) + config('subidha.normal_delivery_charge') + $ssl_value), 2);


                        }

                    }

                    if ($data['delivery_method'] == config('subidha.express_delivery')) {
                        if ($request->payment_type == config('subidha.cod_payment_type')) {
                            logger('3 in');
                            logger('Into subidha cod payment');

                            $delivery_value = config('subidha.express_delivery_charge') * config('subidha.subidha_delivery_percentage') / 100;

                            $amount_value = round(($request->get('amount')) *
                                config('subidha.subidha_comission_cash_percentage') / 100 , 2);

                            $total_value = round(($request->get('amount')) * config('subidha.subidha_comission_cash_percentage') / 100,2);

                            logger('Assigning subidha comission in cod payment');

                            $data['subidha_comission'] = round( ($amount_value + $delivery_value + $total_value), 2);
                            $data['pharmacy_amount'] = round( (($request->get('amount')) + config('subidha.express_delivery_charge') + $amount_value - $data['subidha_comission'] ), 2);
                            $data['customer_amount'] = round( (($request->get('amount')) + config('subidha.express_delivery_charge') + $amount_value), 2);

                        }
                        if ($request->payment_type == config('subidha.ecash_payment_type')) {
                            logger('Into subidha ecash payment method');
                            logger('4 in');

                            $delivery_value = config('subidha.express_delivery_charge') *
                                config('subidha.subidha_delivery_percentage') / 100;

                            $amount_value = number_format(($request->get('amount')) *
                                config('subidha.subidha_comission_ecash_percentage') / 100 , 2);

                            $ssl_value = number_format(( ($request->get('amount')) + config('subidha.express_delivery_charge') ) *
                                config('subidha.ecash_payment_charge_percentage') / 100 , 2);

                            $data['subidha_comission'] = number_format( ($amount_value + $delivery_value), 2);
                            $data['pharmacy_amount'] = number_format( (($request->get('amount')) + config('subidha.express_delivery_charge') - $data['subidha_comission'] ), 2);
                            $data['customer_amount'] = number_format( (($request->get('amount')) + config('subidha.express_delivery_charge') + $ssl_value), 2);

                        }
                    }

                }
                else {
                    if ($data['delivery_method'] == config('subidha.normal_delivery')) {

                        if ($request->payment_type == config('subidha.cod_payment_type')) {
                            logger('5 in');

                            $amount_value = round(($request->get('amount')) *
                                config('subidha.subidha_comission_cash_percentage') / 100 , 2);

                            $total_value = round( (($request->get('amount')) * config('subidha.subidha_comission_cash_percentage') / 100), 2);

                            $data['subidha_comission'] = $amount_value + $total_value;
                            $data['pharmacy_amount'] = round( (($request->get('amount')) + $amount_value - $data['subidha_comission'] ), 2);
                            $data['customer_amount'] = round( (($request->get('amount')) + $amount_value), 2);

                        }
                        if ($request->payment_type == config('subidha.ecash_payment_type')) {
                            logger('6 in');

                            $amount_value = ($request->get('amount')) *
                                config('subidha.subidha_comission_ecash_percentage') / 100;

                            $ssl_value = round(($request->get('amount')) *
                                config('subidha.ecash_payment_charge_percentage') / 100 , 2);


                            $data['subidha_comission'] = round( $amount_value, 2);
                            $data['pharmacy_amount'] = round( (($request->get('amount')) - $data['subidha_comission'] ), 2);
                            $data['customer_amount'] = round( (($request->get('amount')) + $ssl_value), 2);

                        }

                    }

                    if ($request->delivery_method == config('subidha.express_delivery')) {
                        if ($request->payment_type == config('subidha.cod_payment_type')) {
                            logger('Into subidha cod payment');
                            logger('7 in');

                            $delivery_value = config('subidha.express_delivery_charge') * config('subidha.subidha_delivery_percentage') / 100;

                            $amount_value = round(($request->get('amount')) *
                                config('subidha.subidha_comission_cash_percentage') / 100 , 2);

                            $total_value = round(($request->get('amount')) * config('subidha.subidha_comission_cash_percentage') / 100, 2);

                            logger('Assigning subidha comission in cod payment');

                            $data['subidha_comission'] = round( ($amount_value + $delivery_value + $total_value), 2);
                            $data['pharmacy_amount'] = round( (($request->get('amount')) + config('subidha.express_delivery_charge') + $amount_value - $data['subidha_comission'] ), 2);
                            $data['customer_amount'] = round( (($request->get('amount')) + config('subidha.express_delivery_charge') + $amount_value), 2);

                            logger('Subidha comission in cod payment: ' . $data['subidha_comission']);

                        }
                        if ($request->payment_type == config('subidha.ecash_payment_type')) {
                            logger('Into subidha ecash payment method');
                            logger('8 in');

                            $delivery_value = config('subidha.express_delivery_charge') *
                                config('subidha.subidha_delivery_percentage') / 100;

                            $amount_value = number_format(($request->get('amount')) *
                                config('subidha.subidha_comission_ecash_percentage') / 100 , 2);

                            $ssl_value = number_format(( ($request->get('amount')) + config('subidha.express_delivery_charge') )*
                                config('subidha.ecash_payment_charge_percentage') / 100 , 2);

                            $data['subidha_comission'] = number_format( ($amount_value + $delivery_value), 2);
                            $data['pharmacy_amount'] = number_format( (($request->get('amount')) + config('subidha.express_delivery_charge') - $data['subidha_comission'] ), 2);
                            $data['customer_amount'] = number_format( (($request->get('amount')) + config('subidha.express_delivery_charge') + $ssl_value), 2);

                        }
                    }
                }


            }
            if ($request->delivery_type == config('subidha.pickup_from_pharmacy')) {

                if ($request->payment_type == config('subidha.cod_payment_type')) {

                    $amount_value = round(($request->get('amount')) *
                        config('subidha.subidha_comission_collect_from_pharmacy_cash_percentage') / 100 , 2);

                    $orderAmount = $request->get('amount') - $amount_value;

                    $data['subidha_comission'] = round( $amount_value, 2);
                    $data['pharmacy_amount'] = round( ($orderAmount - $data['subidha_comission']), 2);
                    $data['customer_amount'] = round( $orderAmount, 2);

                }
                if ($request->payment_type == config('subidha.ecash_payment_type')) {

                    $amount_value = round(($request->get('amount')) *
                        config('subidha.subidha_comission_collect_from_pharmacy_ecash_percentage') / 100 , 2);

                    $ssl_value = round( ($request->get('amount')) * config('subidha.ecash_payment_charge_percentage') / 100, 2);

                    $data['subidha_comission'] = round( $amount_value, 2);
                    $data['pharmacy_amount'] = round( ($request->get('amount') - ($ssl_value + $data['subidha_comission'] )), 2);
                    $data['customer_amount'] = round( ($request->get('amount') ), 2);

                }
            }
            $data['amount'] = round($request->amount,2);
//        return $data;
            $order = Order::create($data);

            OrderHistory::create([
                'order_id' => $order->id,
                'user_id' => $data['pharmacy_id'],
                'status' => $order->status
            ]);

//            return $data['pharmacy_id'];
            if ($request->order_items) {
                $items = json_decode($request->order_items, true);
                foreach($items as $item) {
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
                foreach($prescriptions as $item) {
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
            session()->forget('prescriptions');
            session()->forget('cartCount');

//            return $data['pharmacy_id'];
            logger($data['pharmacy_id']);
            $deviceIds = UserDeviceId::where('user_id', $data['pharmacy_id'])->get();
//            return $deviceIds;
            logger($deviceIds) ;
            $title = 'New Order Available';
            $message = 'You have a new order from Subidha. Please check.';

            foreach ($deviceIds as $deviceId){
                logger('sendPushNotification foreach in');
                sendPushNotification($deviceId->device_id, $title, $message, $id="");
            }

            return redirect()->route('home')->with('success', 'Order successfully placed');

        } else {

//            return $request->all();
            $user = Auth::user();
            $value = $this->sslPayment($request, $user);
            return $value;
        }

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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sslPayment($request, $user)
    {
//        return $request->all();
        $data = $request->only([
                'phone_number',
                'payment_type',
                'delivery_type',
                'delivery_charge_amount',
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
                'note'
        ]);
//        $data['pharmacy_id'] = $this->orderRepository->getNearestPharmacyId($data['shipping_address_id']);
        $data['pharmacy_id'] = 1;
        logger($data['pharmacy_id']);
        if ($request->delivery_charge === 1) {
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

        if (isset($data['delivery_date'])){
            $data['delivery_date'] = Carbon::createFromFormat('d-m-Y', $data['delivery_date'])->format('Y-m-d');
        }
//
//        $user = Auth::user();
//        logger($user);

        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = $data['amount']; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $this->generateOrderNo();

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer' ;
        $post_data['cus_email'] = 'email' ;
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $data['phone_number'];
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where('order_no', $post_data['tran_id'])
            ->updateOrInsert( $order =[
                'customer_id' => Auth::user()->id,
                'phone_number' => $data['phone_number'],
                'delivery_type' => $data['delivery_type'] ,
                'status' => 0 ,
                'amount' => $post_data['total_amount'],
                'delivery_charge' => $data['delivery_charge_amount'],
                'order_date' => Carbon::today(),
                'notes' => 'test',
                'order_no' =>$post_data['tran_id'],
                'pharmacy_id' => $data['pharmacy_id'],
                'shipping_address_id' => $data['shipping_address_id'],
                'delivery_date' => $data['delivery_date'],
                'delivery_time' => $data['delivery_time'],
                'created_at' => Carbon::today(),
                'updated_at' => Carbon::today(),

//                'name' => $post_data['cus_name'],
//                'email' => $post_data['cus_email'],
//                'phone' => $post_data['cus_phone'],
//                'amount' => $post_data['total_amount'],
//                'status' => 'Pending',
//                'address' => $post_data['cus_add1'],
//                'transaction_id' => $post_data['tran_id'],
//                'currency' => $post_data['currency']
            ]);
        $order = DB::table('orders')
            ->where('customer_id', Auth::user()->id)
            ->latest('id')->first();

        if ($request->order_items) {
            $items = json_decode($request->order_items, true);
            foreach($items as $item) {
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
            foreach($prescriptions as $item) {
                OrderPrescription::create([
                    'prescription_id' => $item,
                    'order_id' => $order->id,
                ]);
            }
            session()->forget('prescriptions');
        }

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');


        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
        echo "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_detials = \Illuminate\Support\Facades\DB::table('orders')
            ->where('order_no', $tran_id)
            ->select('order_no', 'status', 'amount')->first();


        if ($order_detials->status == 0 ) {
            $validation = $sslc->orderValidate($tran_id, $amount, $currency, $request->all());

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('orders')
                    ->where('order_no', $tran_id)
                    ->update(['status' => 3 ]);

//                $order = DB::table('orders')
//                    ->where('customer_id', Auth::user()->id)
//                    ->latest('id')->first();

//                $deviceIds = UserDeviceId::where('user_id',$order->pharmacy_id)->get();
//                $title = 'New Order Available';
//                $message = 'You have a new order from Subidha. Please check.';
//
//                foreach ($deviceIds as $deviceId){
//                    sendPushNotification($deviceId->device_id, $title, $message, $id="");
//                }

                $userId = Auth::user()->id;
                $items = Cart::where('customer_id', $userId)->get();
                if ($items != null) {
                    foreach ($items as $item) {
                        $item->delete();
                    }
                }
                session()->forget('cartCount');

                return redirect()->route('home')->with('success', 'Payment successful');
//                echo "<br >Transaction is successfully Completed";
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table('orders')
                    ->where('order_no', $tran_id)
                    ->update(['status' => 4 ]);

                return redirect()->route('home')->with('failed', 'validation Fail');

//                echo "validation Fail";
            }
        } else if ($order_detials->status == 2 || $order_detials->status == 3) {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            return redirect()->route('home')->with('success', 'Transaction is successfully Completed');
//            echo "Transaction is successfully Completed";
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            return redirect()->route('home')->with('failed', 'Invalid Transaction');
//            echo "Invalid Transaction";
        }


    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('order_no', $tran_id)
            ->select('order_no', 'status', 'amount')->first();

        if ($order_detials->status == 0 ) {
            $update_product = DB::table('orders')
                ->where('order_no', $tran_id)
                ->update(['status' => 4 ]);

            return redirect()->route('home')->with('failed', 'Transaction is Failed');
//            echo "Transaction is Failed";
        } else if ($order_detials->status == 2 || $order_detials->status == 3 ) {

            return redirect()->route('home')->with('success', 'Transaction is already Successful');
//            echo "Transaction is already Successful";
        } else {
            return redirect()->route('home')->with('failed', 'Transaction is Invalid');
//            echo "Transaction is Invalid";
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('order_no', $tran_id)
            ->select('order_no', 'status', 'amount')->first();

        if ($order_detials->status == 0) {
            $update_product = DB::table('orders')
                ->where('order_no', $tran_id)
                ->update(['status' => 10 ]);
            echo "Transaction is Cancel";
        } else if ($order_detials->status == 2 || $order_detials->status == 3) {

            return redirect()->route('home')->with('success', 'Transaction is already Successful');
//            echo "Transaction is already Successful";
        } else {

            return redirect()->route('home')->with('failed', 'Transaction is Invalid');
//            echo "Transaction is Invalid";
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('order_no', $tran_id)
                ->select('order_no', 'status', 'amount')->first();

            if ($order_details->status == 0 ) {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($tran_id, $order_details->amount, $order_details->currency, $request->all());
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('order_no', $tran_id)
                        ->update(['status' =>  2 ]);

                    return redirect()->route('home')->with('failed', 'Transaction is successfully Completed');
//                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('orders')
                        ->where('order_no', $tran_id)
                        ->update(['status' => 4 ]);

                    return redirect()->route('home')->with('failed', 'validation Fail');
//                    echo "validation Fail";
                }

            } else if ($order_details->status == 2 || $order_details->status == 3 ) {

                #That means Order status already updated. No need to udate database.

                return redirect()->route('home')->with('success', 'Transaction is already successfully Completed');
//                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                return redirect()->route('home')->with('failed', 'Invalid Transaction');
//                echo "Invalid Transaction";
            }
        } else {

            return redirect()->route('home')->with('failed', 'Invalid Data');
            echo "Invalid Data";
        }
    }

    public function findPharmacy (Request $request) {

        $area_id = $request->id;
        $isAvailable = $this->pharmacyRepository->checkPharmacyByArea($area_id);
        return response()->json($isAvailable);
    }

    public function availablePharmacyList (Request $request) {
        $thana_id = $request->id;
        $availablePharmacyList = $this->pharmacyRepository->getAvailablePharmacyList($thana_id);
        return response()->json($availablePharmacyList);
    }


}
