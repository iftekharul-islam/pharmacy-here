<?php

namespace Modules\Orders\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Orders\Http\Requests\CreateOrderCancelRequest;
use Modules\Orders\Http\Requests\CreateOrderRrequest;
use Modules\Orders\Repositories\OrderRepository;
use Modules\Orders\Transformers\OrderTransformer;

class OrderController extends BaseController
{
    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $user = Auth::guard('api')->user();

        if ($user->hasRole('pharmacy')) {
            $orders = $this->repository->byPharmacyId($user->id);
        } else {
            $orders = $this->repository->byCustomerId($user->id);
        }

        return $this->response->collection($orders, new OrderTransformer());
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(CreateOrderRrequest $request)
    {
        //$user = Auth::user();

        $order = $this->repository->create($request, Auth::guard('api')->user()->id);

        return $this->response->item($order, new OrderTransformer());
        // return responseData($order);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $orderDetails = $this->repository->get($id);
//            return $orderDetails;
        return $this->response->item($orderDetails, new OrderTransformer());
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('orders::edit');
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

    public function ordersByPharmacyId()
    {
        return $this->repository->byPharmacyId(Auth::guard('api')->user()->id);
    }

    public function ordersByCustomerId()
    {
        return $this->repository->byCustomerId(Auth::guard('api')->user()->id);
    }

    public function ordersStatusUpdate($order_id, $status_id)
    {
        $order = $this->repository->updateStatus($order_id, $status_id);
        // return $this->response->item($order, new OrderTransformer);
        return $order;
    }

    public function pharmacyOrdersByStatus($status_id)
    {
        $orderList = $this->repository->pharmacyOrdersByStatus(Auth::guard('api')->user()->id, $status_id);

        return $this->response->paginator($orderList, new OrderTransformer());
    }

    public function pharmacyOrderCancelReason(CreateOrderCancelRequest $request)
    {
        $data = $this->repository->pharmacyOrderCancelReason(Auth::guard('api')->user()->id, $request);

        return responseData('Order cancel reason saved');
    }



}
