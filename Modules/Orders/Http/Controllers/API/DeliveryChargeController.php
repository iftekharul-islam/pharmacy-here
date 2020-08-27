<?php

namespace Modules\Orders\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Orders\Http\Requests\DeliveryChargeRequest;

class DeliveryChargeController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(DeliveryChargeRequest $request)
    {

        $orderAmount = $request->get('amount');
        $normalDelivery = [];
        $expressDelivery = [];
        $collectFromPharmacy = [];

        $data = [];
        
        if ($orderAmount <= config('subidha.free_delivery_amount')) {
            $normalEcash = (config('subidha.normal_delivery_charge') + $request->get('amount')) * config('subidha.ecash_payment_charge_percentage') / 100;
            $expressEcash = (config('subidha.express_delivery_charge') + $request->get('amount')) * config('subidha.ecash_payment_charge_percentage') / 100;
            $normalDelivery = [
                'cash' => number_format( config('subidha.normal_delivery_charge') + ($request->get('amount')) * config('subidha.cash_payment_charge_percentage') / 100, 2),
                'ecash' => number_format(config('subidha.normal_delivery_charge') + $normalEcash, 2)
            ];

            $expressDelivery = [
                'cash' => number_format(config('subidha.express_delivery_charge') + ($request->get('amount') * config('subidha.cash_payment_charge_percentage') / 100), 2),
                'ecash' => number_format(config('subidha.express_delivery_charge') + $expressEcash, 2)
            ];

            $collectFromPharmacy = [
                'cash' => number_format(config('subidha.collect_from_pharmacy_charge'), 2),
                'ecash' => number_format(config('subidha.collect_from_pharmacy_charge') - ($request->get('amount') * config('subidha.collect_from_pharmacy_discount_percentage') / 100), 2),
                'ecash_discount' => number_format($request->get('amount') * config('subidha.collect_from_pharmacy_discount_percentage') / 100, 2)
            ];

            $data = [
                'normal_delivery' => $normalDelivery,
                'express_delivery' => $expressDelivery,
                'collect_from_pharmacy' => $collectFromPharmacy
            ];
        } else {
            $normalEcash = (config('subidha.normal_delivery_charge') + $request->get('amount')) * config('subidha.ecash_payment_charge_percentage') / 100;
            $expressEcash = (config('subidha.express_delivery_charge') + $request->get('amount')) * config('subidha.ecash_payment_charge_percentage') / 100;
            $normalDelivery = [
                // 'cash' => number_format( config('subidha.normal_delivery_charge') + ($request->get('amount')) * config('subidha.cash_payment_charge_percentage') / 100, 2),
                'ecash' => number_format(config('subidha.normal_delivery_charge') + $normalEcash, 2)
            ];

            $expressDelivery = [
                // 'cash' => number_format(config('subidha.express_delivery_charge') + ($request->get('amount') * config('subidha.cash_payment_charge_percentage') / 100), 2),
                'ecash' => number_format(config('subidha.express_delivery_charge') + $expressEcash, 2)
            ];

            $collectFromPharmacy = [
                // 'cash' => number_format(config('subidha.collect_from_pharmacy_charge'), 2),
                'ecash' => number_format(config('subidha.collect_from_pharmacy_charge') - ($request->get('amount') * config('subidha.collect_from_pharmacy_discount_percentage') / 100), 2),
                'ecash_discount' => number_format($request->get('amount') * config('subidha.collect_from_pharmacy_discount_percentage') / 100, 2)
            ];

            $data = [
                'normal_delivery' => $normalDelivery,
                'express_delivery' => $expressDelivery,
                'collect_from_pharmacy' => $collectFromPharmacy
            ];
        }

        return responsePreparedData($data);
    }

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
