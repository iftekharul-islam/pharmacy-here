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
use Modules\Orders\Entities\Models\OrderItems;
use Modules\Orders\Entities\Models\OrderPrescription;
use Modules\Orders\Repositories\DeliveryChargeRepository;
use Modules\Orders\Repositories\OrderRepository;
use Modules\Products\Repositories\ProductRepository;
use Modules\User\Entities\Models\User;

class CheckoutController extends Controller
{

    private $addressRepository;
    private $cartRepository;
    private $deliveryRepository;
    private $locationRepository;
    private $orderRepository;

    public function __construct(CartRepository $cartRepository,
                                AddressRepository $addressRepository,
                                DeliveryChargeRepository $deliveryRepository,
                                LocationRepository $locationRepository,
                                OrderRepository $orderRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->addressRepository = $addressRepository;
        $this->deliveryRepository = $deliveryRepository;
        $this->locationRepository = $locationRepository;
        $this->orderRepository = $orderRepository;
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
            return redirect()->back();
        }
        $delivery_charge = $this->deliveryRepository->deliveryCharge($data->sum('amount'));
        $addresses = $this->addressRepository->getCustomerAddress(Auth::user()->id);
        $isPreOrderMedicine = $this->isPreOrderMedicine($data);
        $allLocations = $this->locationRepository->getLocation();
        $user = User::find(Auth::guard('web')->user()->id);

//        $temp = [
//            'data' => $data,
//            'addresses' => $addresses,
//            'delivery_charge' => $delivery_charge,
//            'isPreOrderMedicine' => $isPreOrderMedicine,
//            'allLocations' => $allLocations,
//        ];
//        return $temp;

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
//        return $request->cart_id;

        if ($request->payment_type == 1){
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
                'note'
            ]);

            $data['order_no'] = $this->generateOrderNo();
            $data['pharmacy_id'] = 1;
            $data['order_date'] = Carbon::today();
            $data['customer_id'] = Auth::user()->id;
            $data['notes'] = "Its a sample" ;

            if ($request->delivery_charge === 1) {
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
//        return $data;
            $order = Order::create($data);


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

            return redirect()->route('home')->with('success', 'Order successfully placed');
        } else {
//            return 'its E payment';
            $value = $this->sslPayment($request);
            return $value;
        }

    }

    public function generateOrderNo()
    {
        $latestOrder = Order::orderBy('id', 'desc')->first();
        if ($latestOrder) {
            $lastNumber = explode('-', $latestOrder->order_no);
            $lastNumber = preg_replace("/[^0-9]/", "", end($lastNumber) );
            $orderNo =  date('Y').'-'.date('m').'-'.str_pad( (int) $lastNumber + 1 , 4, '0', STR_PAD_LEFT);
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

    public function sslPayment($request)
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
                'note'
        ]);

        if ($request->delivery_charge === 1) {
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

        $user = User::where('id', Auth::user()->id)->first();
        logger($user);

        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = $data['amount']; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $this->generateOrderNo();

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $user->name ;
        $post_data['cus_email'] = $user->email ;
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
            ->updateOrInsert([
                'customer_id' => Auth::user()->id,
                'phone_number' => $data['phone_number'],
                'delivery_type' => $data['delivery_type'] ,
                'status' => 0 ,
                'amount' => $post_data['total_amount'],
                'delivery_charge' => $data['delivery_charge'],
                'order_date' => Carbon::today(),
                'notes' => 'test',
                'order_no' =>$post_data['tran_id'],
                'pharmacy_id' => 1,
                'shipping_address_id' => $data['shipping_address_id'],
                'delivery_date' => $data['delivery_date'],

//                'name' => $post_data['cus_name'],
//                'email' => $post_data['cus_email'],
//                'phone' => $post_data['cus_phone'],
//                'amount' => $post_data['total_amount'],
//                'status' => 'Pending',
//                'address' => $post_data['cus_add1'],
//                'transaction_id' => $post_data['tran_id'],
//                'currency' => $post_data['currency']
            ]);

        logger($update_product);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');
//        logger($payment_options);


        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
        return $request->all();
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

                echo "<br >Transaction is successfully Completed";
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table('orders')
                    ->where('order_no', $tran_id)
                    ->update(['status' => 4 ]);
                echo "validation Fail";
            }
        } else if ($order_detials->status == 2 || $order_detials->status == 3) {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            echo "Transaction is successfully Completed";
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
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
                ->where('transaction_id', $tran_id)
                ->update(['status' => 4 ]);
            echo "Transaction is Failed";
        } else if ($order_detials->status == 2 || $order_detials->status == 3 ) {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
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
                ->where('transaction_id', $tran_id)
                ->update(['status' => 10 ]);
            echo "Transaction is Cancel";
        } else if ($order_detials->status == 2 || $order_detials->status == 3) {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
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

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('orders')
                        ->where('order_no', $tran_id)
                        ->update(['status' => 4 ]);

                    echo "validation Fail";
                }

            } else if ($order_details->status == 2 || $order_details->status == 3 ) {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}
