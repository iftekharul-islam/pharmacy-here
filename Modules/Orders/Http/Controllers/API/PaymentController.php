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
        $requestData = $request->all();

        $direct_api_url = env('SSL_COMMERZ_URL');
//        dd($direct_api_url);
        $post_data = array();
        $post_data['store_id'] = env('SSL_STORE_ID');
        $post_data['store_passwd'] = env('SSL_STORE_PASSWORD');
//        $post_data['total_amount'] = round($productDetail['totalAmount']+$deliveryCharge, 2);
        $post_data['total_amount'] = $requestData['total_amount'];
        $post_data['currency'] = "BDT";
//        $post_data['tran_id'] = $tranId;
        $post_data['tran_id'] = $requestData['tran_id'];
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
