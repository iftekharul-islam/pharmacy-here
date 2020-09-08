<?php

namespace Modules\Orders\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
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
    public function index()
    {
        $data = $this->repository->all();

//        $total_received = $this->repository->pharmacyTotalRecived();
//        return $data[0]->pharmacy->pharmacyBusiness->pharmacy_name;

        return view('orders::transactionHistory.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @param $id
     * @return Response
     */
    public function create($id)
    {
        $data = $this->repository->getPharmacyInfo($id);
//        return $data->pharmacy;
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
    public function show($id)
    {
        $data = $this->repository->get($id);
        return view('orders::transactionHistory.show', compact('data'));
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
