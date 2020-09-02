<?php

namespace Modules\Orders\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Orders\Http\Requests\CreateOrderRrequest;
use Modules\Orders\Repositories\OrderRepository;
use Modules\Orders\Transformers\OrderTransformer;

class PaymentController extends BaseController
{
//    private $repository;
//
//    public function __construct(OrderRepository $repository)
//    {
//        $this->repository = $repository;
//    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
//        $user = Auth::guard('api')->user();
//
//        if ($user->hasRole('pharmacy')) {
//            $orders = $this->repository->byPharmacyId($user->id);
//        } else {
//            $orders = $this->repository->byCustomerId($user->id);
//        }
//
//        return $this->response->collection($orders, new OrderTransformer());
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(CreateOrderRrequest $request)
    {
//        //$user = Auth::user();
//
//        $order = $this->repository->create($request, Auth::guard('api')->user()->id);
//
//        return $this->response->item($order, new OrderTransformer());
//        // return responseData($order);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
//        $orderDetails = $this->repository->get($id);
//
//        return $this->response->item($orderDetails, new OrderTransformer());
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
//        return view('orders::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function payment(Request $request)
    {
//        $aa = $request->all();
//        foreach ($aa as $k=>$v){
//            $cc = $k;
//        }
//        $postData = json_decode($cc, true);
//        $customerProductInfo = $postData['CustomerProductInfo'];
//        $productDetail = $postData['ProductDetail'];
        // get current delivery charge
//        $deliveryCharge = DeliveryCharges::where('valid_from', '<=', Carbon::parse(date('Y-m-d'))->format('Y-m-d'))->where('valid_upto', '>=', Carbon::parse(date('Y-m-d'))->format('Y-m-d'))->first();
//        $deliveryCharge = isset($deliveryCharge->amount)?$deliveryCharge->amount:0;
//        $CustomerProductInfoTable = CustomerProductInfo::where('customer_id', $customerProductInfo['CustomerId'])->latest()->first();
//        $customerProduct = [];
//        $customerProduct['plan_name'] = $productDetail['plan_name'];
//        $customerProduct['partyTypeId'] = $productDetail['partyTypeId'];
//        $customerProduct['vehicle_type_id'] = $productDetail['vehicle_type_id'];
//        $customerProduct['temp_id'] = $productDetail['temp_id'];
//        $customerProduct['cc'] = $customerProductInfo['CC'];
//        $customerProduct['seats'] = $customerProductInfo['NoOfSeats'];
//        $customerProduct['ton'] = $customerProductInfo['Ton'];
//        $customerProduct['fitness_expiry_date'] = null;
//        $customerProduct['token_expiry_date'] = null;
//        $customerProduct['no_driver'] = $productDetail['no_driver'];
//        $customerProduct['per_driver_cost'] = $productDetail['per_driver_cost'];
//        $customerProduct['per_pasenger_cost'] = $productDetail['per_pasenger_cost'];
//        $customerProduct['no_passenger'] = $productDetail['no_passenger'];
//        $customerProduct['insurance_start_date'] = $customerProductInfo['InsStartDate'];
//        $customerProduct['insurance_end_date'] = $customerProductInfo['InsEndDate'];
//        $customerProduct['capacity'] = $productDetail['capacity'];
//        $customerProduct['act_liability_premium'] = $productDetail['act_liability_premium'];
//        $customerProduct['total_pasenger_cost'] = $productDetail['total_pasenger_cost'];
//        $customerProduct['total_driver_cost'] = $productDetail['total_driver_cost'];
//        $customerProduct['netPremium'] = $productDetail['netPremium'];
//        $customerProduct['vatPercentageValue'] = $productDetail['vatPercentageValue'];
//        $customerProduct['grossPremium'] = $productDetail['grossPremium'];
//        $customerProduct['grossPremiumDiscount'] = $productDetail['grossPremiumDiscount'];
//        $customerProduct['discount_type'] = $productDetail['discount_type'];
//        $customerProduct['discount_value'] = $productDetail['discount_value'];
//        $customerProduct['discount_text'] = $productDetail['discount_text'];
//        $customerProduct['totalDays'] = $productDetail['totalDays'];
//        $customerProduct['vendor_id'] = $productDetail['vendor_id'];
//        $customerProduct['customer_product_info_id'] = $CustomerProductInfoTable['id'];
//        $customerProduct['delivery_charge'] = $deliveryCharge;
//        $cKey = 'CustomerApp-'.$customerProductInfo['CustomerId'];
//        Cache::put($cKey, $customerProduct, now()->addMinutes(60));
//        $fromCache = Cache::get($cKey);
//        $tranId = $this->generateOrderNo($customerProductInfo['CustomerId'], $productDetail['vendor_id']);
        // dd($customerProduct);

//        $direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v3/api.php";
        $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";
        $post_data = array();
        $post_data['store_id'] = 'subid5f4f5f3ee699c';
        $post_data['store_passwd'] = 'subid5f4f5f3ee699c@ssl';
//        $post_data['total_amount'] = round($productDetail['totalAmount']+$deliveryCharge, 2);
        $post_data['total_amount'] = 150;
        $post_data['currency'] = "BDT";
//        $post_data['tran_id'] = $tranId;
        $post_data['tran_id'] = 1;
        $post_data['success_url'] = url('/api/initialPaymentSuccess');
        $post_data['fail_url'] = url('/api/initialPaymentFail');
        $post_data['cancel_url'] = url('/api/initialPaymentCancel');
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
//        print_r('CONTENT : '.$content."\n") ;
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


}
