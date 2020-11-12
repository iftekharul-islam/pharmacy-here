<?php

namespace Modules\Orders\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Locations\Repositories\LocationRepository;
use Modules\Orders\Repositories\OrderRepository;

class OrdersController extends Controller
{
    private $repository;
    private $locationRepository;

    public function __construct(OrderRepository $repository, LocationRepository $locationRepository)
    {
        $this->repository = $repository;
        $this->locationRepository = $locationRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $display_area = $request->area_id;
        $display_thana = $request->thana_id;
        $display_district = $request->district_id;
        $display_Sdate = $request->start_date;
        $display_Edate = $request->end_date;
        $status = $request->status;

        $data = $this->repository->ordersByStatus($request);
        $allLocations = $this->locationRepository->getLocation();
        return view('orders::index', compact('data', 'display_Sdate','display_Edate', 'status', 'allLocations',
                                                            'display_area', 'display_thana', 'display_district'));
    }

    /**
//     * Show the form for creating a new resource.
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
        $data = $this->repository->getOrderDetails($id);
        return view('orders::show', compact('data'));
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
}
