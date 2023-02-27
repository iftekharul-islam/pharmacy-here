<?php

namespace Modules\Orders\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Http\Requests\CreateOrderCancelRequest;
use Modules\Orders\Http\Requests\CreateOrderRrequest;
use Modules\Orders\Repositories\OrderRepository;
use Modules\Orders\Transformers\OrderTransformer;
use Modules\User\Entities\Models\PharmacyBusiness;

class OrderController extends BaseController
{
    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user->hasRole('pharmacy')) {
            $orders = $this->repository->byPharmacyId($request, $user->id);
        }
        return $this->response->paginator($orders, new OrderTransformer());
    }

    public function getCustomerOrders()
    {
        $user = Auth::guard('api')->user();
        $orders = $this->repository->byCustomerId($user->id);

        return $this->response->paginator($orders, new OrderTransformer());
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Response
     */
    public function create(CreateOrderRrequest $request)
    {
        logger('Into the Order controller create method');
        $order = $this->repository->create($request, Auth::guard('api')->user()->id);
        logger('End of Order controller create method');

        return $this->response->item($order, new OrderTransformer());
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $orderDetails = $this->repository->get($id);

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
     * @return mixed
     */
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

        return $order;
    }

    public function pharmacyOrdersByStatus( Request $request, $status_id)
    {
        $orderList = $this->repository->pharmacyOrdersByStatus($request, Auth::guard('api')->user()->id, $status_id);

        return $this->response->paginator($orderList, new OrderTransformer());
    }

    public function pharmacyOrderCancelReason(CreateOrderCancelRequest $request)
    {
        $data = $this->repository->pharmacyOrderCancelReason(Auth::guard('api')->user()->id, $request);

        return responseData('Order cancel reason saved');
    }



}
