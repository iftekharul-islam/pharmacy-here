<?php

namespace Modules\Orders\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Orders\Http\Requests\DeliveryChargeRequest;
use Modules\Orders\Repositories\DeliveryChargeRepository;

class DeliveryChargeController extends BaseController
{
    private $repository;

    public function __construct(DeliveryChargeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @param DeliveryChargeRequest $request
     * @return JsonResponse
     */
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(DeliveryChargeRequest $request)
    {
        $normalDeliveryCash = $request->get('amount')  > config('subidha.free_delivery_limit')
            ? $request->get('amount') * config('subidha.cash_payment_charge_percentage') / 100
            : config('subidha.normal_delivery_charge') + $request->get('amount') * config('subidha.cash_payment_charge_percentage') / 100;

        $normalDelivery = [
            'cash'  => number_format($normalDeliveryCash, 2)
        ];

        $expressDeliveryCash = config('subidha.express_delivery_charge') + ($request->get('amount') * config('subidha.cash_payment_charge_percentage') / 100);

        $expressDelivery = [
            'cash'  =>  number_format($expressDeliveryCash, 2)
        ];

        $collectFromPharmacyCash = number_format(config('subidha.collect_from_pharmacy_charge') - ($request->get('amount') * config('subidha.collect_from_pharmacy_discount_percentage') / 100), 2);

        $collectFromPharmacy = [
            'cash'      => number_format($collectFromPharmacyCash, 2),
            'discount'  => number_format($request->get('amount') * config('subidha.collect_from_pharmacy_discount_percentage') / 100, 2)
        ];

        //check if ecash payment allowed
        if ($request->get('amount') <= config('subidha.ecash_payment_limit'))
        {
            $normalDeliveryEcash =  $request->get('amount')  > config('subidha.free_delivery_limit')
                ? $request->get('amount') * config('subidha.ecash_payment_charge_percentage') / 100
                : config('subidha.normal_delivery_charge') + (config('subidha.normal_delivery_charge') + $request->get('amount')) * (config('subidha.ecash_payment_charge_percentage') / 100);

            $expressDeliveryEcash = config('subidha.express_delivery_charge') + (config('subidha.express_delivery_charge') + $request->get('amount')) * config('subidha.ecash_payment_charge_percentage') / 100;

            $collectFromPharmacyEcash = $request->get('amount') * config('subidha.ecash_payment_charge_percentage') / 100;

            $normalDelivery ['ecash'] = number_format($normalDeliveryEcash, 2);

            $expressDelivery['ecash'] = number_format($expressDeliveryEcash, 2);

            $collectFromPharmacy['ecash'] = number_format($collectFromPharmacyEcash, 2);
        }

        return responsePreparedData([
            'normal_delivery'       => $normalDelivery,
            'express_delivery'      => $expressDelivery,
            'collect_from_pharmacy' => $collectFromPharmacy
        ]);
    }

//    public function index(DeliveryChargeRequest $request)
//    {
//
//        $data = $this->repository->deliveryCharge($request->amount);
//
//        return responsePreparedData($data);
//    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('orders::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('orders::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('orders::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
