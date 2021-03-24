<?php

namespace Modules\Orders\Http\Controllers;

use App\Exports\OrderExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Locations\Repositories\LocationRepository;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\OrderHistory;
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

    public function exportOrder(Request $request)
    {
        $district = $request->district;
        $thana = $request->thana;
        $area = $request->area;
        $toDate = $request->toDate;
        $endDate = $request->endDate;
        $status = $request->status;
        $date = Carbon::now()->format('d-m-Y');

        return (new OrderExport($district, $thana, $area, $toDate, $endDate, $status))->download('order-report-'. time() . '-' . $date . '.xls');
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activeOrder(Request $request)
    {
        $order_id = $request->order_id;
        $history_id = $request->history_id;
        $pharmacy_id = $request->pharmacy_id;
        $data = $this->repository->activeOrphanOrder($order_id, $history_id, $pharmacy_id);

        if ($data == false){
            return redirect()->back()->with('failed', 'Order reverse is not successful');
        }

        return redirect()->back()->with('success', 'Order reverse successful');

    }

    public function cancelOrder(Request $request)
    {
        $order_id = $request->order_id;
        $history_id = $request->history_id;
        $pharmacy_id = $request->pharmacy_id;
        $data = $this->repository->cancelOrder($order_id, $history_id, $pharmacy_id);

        if ($data == false) {
            return redirect()->back()->with('failed', 'Order cancel is not successful');
        }

        return redirect()->back()->with('success', 'Order cancel successful');

    }
}
