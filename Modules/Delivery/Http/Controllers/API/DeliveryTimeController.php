<?php

namespace Modules\Delivery\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Delivery\Repositories\DeliveryTimeRepository;

class DeliveryTimeController extends Controller
{
    private $repository;

    public function __construct(DeliveryTimeRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        $month = Carbon::now()->month;

        $data = [
            'normal_delivery_time'  => $this->repository->getTimeList($month, 1),
            'express_delivery_time' => $this->repository->getTimeList($month, 2)
        ];

        return responsePreparedData($data);
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
}
