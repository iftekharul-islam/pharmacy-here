<?php

namespace Modules\Delivery\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Delivery\Http\Requests\CreateDeliveryTimeRequest;
use Modules\Delivery\Http\Requests\UpdateDeliveryTimeRequest;
use Modules\Delivery\Repositories\DeliveryTimeRepository;
use Modules\Orders\Repositories\DeliveryChargeRepository;

class DeliveryTimeController extends Controller
{
    private $repository;

    public function __construct(DeliveryTimeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
//        return view('delivery::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('delivery::deliveryTime.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateDeliveryTimeRequest $request
     * @return RedirectResponse
     */
    public function store(CreateDeliveryTimeRequest $request)
    {

        $data = $this->repository->create($request);

        if ($data->delivery_method == 1) {
            return redirect()->route('normal-delivery-time');
        }
        return redirect()->route('express-delivery-time');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return void
     */
    public function show($id)
    {
//        return view('delivery::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = $this->repository->get($id);
        return view('delivery::deliveryTime.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateDeliveryTimeRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateDeliveryTimeRequest $request, $id)
    {
        $data = $this->repository->update($request, $id);

        if ($data->delivery_method == 1) {
            return redirect()->route('normal-delivery-time');
        }
        return redirect()->route('express-delivery-time');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $data = $this->repository->get($id);
        $item = $this->repository->delete($id);
        if ($data->delivery_method == 1) {
            return redirect()->route('normal-delivery-time');
        }
        return redirect()->route('express-delivery-time');
    }

    public function normalDeliveryList()
    {
        $page_title = "Normal Delivery Time";
        $timeList = $this->repository->timeList(1);
        return view('delivery::deliveryTime.index', compact('page_title', 'timeList'));
    }

    public function expressDeliveryList()
    {
        $page_title = "Express Delivery Time";
        $timeList = $this->repository->timeList(2);
        return view('delivery::deliveryTime.index', compact('page_title', 'timeList'));
    }
}
