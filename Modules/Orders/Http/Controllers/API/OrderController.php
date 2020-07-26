<?php

namespace Modules\Orders\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();

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
    public function create()
    {
        return view('orders::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('orders::show');
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

    public function ordersByPharmacyId($pharmacy_id)
    {
        return $this->repository->all($pharmacy_id);
    }
}
