<?php

namespace Modules\Delivery\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Delivery\Repositories\DeliveryTimeRepository;
use Modules\Orders\Repositories\DeliveryChargeRepository;

class DeliveryController extends Controller
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
        return view('delivery::create');
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
        return view('delivery::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('delivery::edit');
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

    public function normalDeliveryList()
    {
        $page_title = "Normal Delivery List";
        $data = $this->repository->timeList(1);
        return view('delivery::index', compact('page_title'));
    }

    public function expressDeliveryList()
    {
        $page_title = "Express Delivery List";
        $data = $this->repository->timeList(2);
        return view('delivery::index', compact('page_title'));
    }
}
