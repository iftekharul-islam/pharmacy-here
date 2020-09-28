<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutCreateRequest;
use App\Models\Cart;
use App\Repositories\CartRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            return 'its E payment';
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

    /**
     * @param Request $request
     */
    public function payment(Request $request)
    {
        $requestData = $request->all();


        $direct_api_url = env('SSL_COMMERZ_URL');
//        dd($direct_api_url);
        $post_data = array();
        $post_data['store_id'] = env('SSL_STORE_ID');
        $post_data['store_passwd'] = env('SSL_STORE_PASSWORD');
//        $post_data['total_amount'] = round($productDetail['totalAmount']+$deliveryCharge, 2);
        $post_data['total_amount'] = '500';
        $post_data['currency'] = "BDT";
//        $post_data['tran_id'] = $tranId;
        $post_data['tran_id'] = '3131312312';
        $post_data['success_url'] = url('success');
        $post_data['fail_url'] = url('failed');
        $post_data['cancel_url'] = url('cancel');
        $post_data['value_a'] = 'VALUE_A';
        $post_data['value_b'] = 'VALUE_B';
        $post_data['value_c'] = 'VALUE_C';
        $post_data['value_d'] = 'VALUE_D';
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $direct_api_url);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC
        $content = curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        logger($content);
        if ($code == 200 && !(curl_errno($handle))) {
            curl_close($handle);
            $sslcommerzResponse = $content;
        } else {
            curl_close($handle);
            echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
            exit;
        }
        # PARSE THE JSON RESPONSE
        $sslcz = json_decode($sslcommerzResponse, true);
//        dd($sslcz['GatewayPageURL']);
        if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
            # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
            # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
            echo "<meta http-equiv='refresh' content='0;url=" . $sslcz['GatewayPageURL'] . "'>";
            # header("Location: ". $sslcz['GatewayPageURL']);
            exit;
        } else {
            echo "JSON Data parsing error!";
        }
    }

    public function paymentSuccess()
    {
        return 'Success';

    }

    public function paymentFailed()
    {
        return 'Failed';

    }

    public function paymentCancel()
    {
        return 'Cancel';
    }
}
