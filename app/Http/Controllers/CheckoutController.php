<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Address\Repositories\AddressRepository;
use Modules\Locations\Repositories\LocationRepository;
use Modules\Orders\Repositories\DeliveryChargeRepository;
use Modules\Products\Repositories\ProductRepository;
use Modules\User\Entities\Models\User;

class CheckoutController extends Controller
{

    private $addressRepository;
    private $cartRepository;
    private $deliveryRepository;
    private $locationRepository;

    public function __construct(CartRepository $cartRepository, AddressRepository $addressRepository, DeliveryChargeRepository $deliveryRepository, LocationRepository $locationRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->addressRepository = $addressRepository;
        $this->deliveryRepository = $deliveryRepository;
        $this->locationRepository = $locationRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->cartRepository->getCartByCustomer(Auth::user()->id);
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

    public function check(Request $request)
    {
        $data = $request->only([
            'phone_number',
            'delivery_type',
            'delivery_method',
            'status',
            'delivery_charge',
            'amount',
            'order_date',
            'pharmacy_id',
            'shipping_address_id',
            'prescriptions',
            'order_items',
            'deliveryMethod',
            'deliveryMethod',
            'deliveryDate'
        ]);

        return $data;
        if ($request->payType == 2){
//            return 'its COD';
            $this->payment($request);
        }


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

    public function prescriptionCreate()
    {
        return view('prescription.create');
    }
}
