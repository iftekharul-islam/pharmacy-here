<?php

namespace Modules\Orders\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Modules\Locations\Entities\Models\Area;
use Modules\Orders\Entities\Models\TransactionHistory;
use Modules\Orders\Http\Requests\CreateTransactionHistoryRequest;
use Modules\Orders\Repositories\TransactionHistoryRepository;

class TransactionHistoryController extends Controller
{
    private $repository;

    public function __construct(TransactionHistoryRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $areaId = $request->area_id;
        $areas = Area::all();
        $transactionHistories = $this->repository->getAllTransactionHistories($request);

        return view('orders::transactionHistory.index', compact('transactionHistories', 'areas', 'areaId'));
    }

    /**
     * Show the form for creating a new resource.
     * @param $id
     * @return Response
     */
    public function create($id)
    {
        $data = $this->repository->getPharmacyInfo($id);
//        return $data;
        return view('orders::transactionHistory.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateTransactionHistoryRequest $request
     * @return RedirectResponse
     */
    public function store(CreateTransactionHistoryRequest $request)
    {
//        return $request->all();
        $data = $this->repository->store($request);

        return redirect()->route('transactionHistory.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $startDate = $request->start_date ? $request->start_date : Carbon::today()->subDays(30);
        $endDate = $request->end_date ? $request->end_date : Carbon::today();
        $userId = $id;

        $data = $this->repository->get($request, $id);
        return view('orders::transactionHistory.show', compact('data', 'userId', 'startDate', 'endDate'));
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
