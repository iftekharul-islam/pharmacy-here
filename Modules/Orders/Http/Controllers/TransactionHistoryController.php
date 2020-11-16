<?php

namespace Modules\Orders\Http\Controllers;

use App\Exports\CodTransactionHistoryByIdExport;
use App\Exports\CodTransactionExport;
use App\Exports\TransactionHistoryByIdExport;
use App\Exports\TranscationExport;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Modules\Locations\Repositories\LocationRepository;
use Modules\Orders\Http\Requests\CreateTransactionHistoryRequest;
use Modules\Orders\Repositories\TransactionHistoryRepository;
use Modules\User\Entities\Models\PharmacyBusiness;

class TransactionHistoryController extends Controller
{
    private $repository;
    private $locationRepository;

    public function __construct(TransactionHistoryRepository $repository, LocationRepository $locationRepository)
    {
        $this->repository = $repository;
        $this->locationRepository = $locationRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $district_new_id = $request->district_id;
        $thana_new_id = $request->thana_id;
        $area_new_id = $request->area_id;
        $transactionHistories = $this->repository->getEpayTransactionHistories($request);

        $total_order = 0;
        $total_pharmacy_amount = 0;
        $total_paid_amount = 0;
        foreach ($transactionHistories as $totalAmount) {
            $total_order += isset($totalAmount->pharmacy->pharmacyOrder[0]->customer_amount) ? $totalAmount->pharmacy->pharmacyOrder[0]->customer_amount : 0 ;
            $total_pharmacy_amount += isset($totalAmount->pharmacy->pharmacyOrder[0]->pharmacy_amount) ? $totalAmount->pharmacy->pharmacyOrder[0]->pharmacy_amount : 0 ;
            $total_paid_amount += isset($totalAmount->amount) ? $totalAmount->amount: 0 ;
        }
        $allLocations = $this->locationRepository->getLocation();

        return view('orders::transactionHistory.epay.index',
            compact('transactionHistories', 'allLocations', 'total_order', 'total_pharmacy_amount',
                            'total_paid_amount', 'district_new_id', 'thana_new_id', 'area_new_id'));
    }


    public function allTransaction()
    {
        $allLocations = $this->locationRepository->getLocation();
        $transactionHistories = $this->repository->getAllTransactionHistories();

        return view('orders::transactionHistory.all.index', compact('allLocations', 'transactionHistories'));
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function cod(Request $request)
    {
        $district_new_id = $request->district_id;
        $thana_new_id = $request->thana_id;
        $area_new_id = $request->area_id;

        $transactionHistories = $this->repository->getCodTransactionHistories($request);
        $total_customer_amount = 0;
        $total_pharmacy_amount = 0;
        $total_subidha_comission = 0;
        foreach ($transactionHistories as $totalAmount) {
            $total_customer_amount += isset($totalAmount->customer_amount) ? $totalAmount->customer_amount : 0 ;
            $total_pharmacy_amount += isset($totalAmount->pharmacy_amount) ? $totalAmount->pharmacy_amount : 0 ;
            $total_subidha_comission += isset($totalAmount->subidha_comission) ? $totalAmount->subidha_comission: 0 ;
        }
        $allLocations = $this->locationRepository->getLocation();

        return view('orders::transactionHistory.cod.index',
            compact('transactionHistories', 'total_customer_amount', 'total_pharmacy_amount',
                            'total_subidha_comission', 'allLocations', 'district_new_id', 'thana_new_id', 'area_new_id'));
    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $userId = $id;

        $data = $this->repository->get($request, $id);
        return view('orders::transactionHistory.epay.show', compact('data', 'userId', 'startDate', 'endDate'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return Factory|View
     */
    public function codShow(Request $request, $id)
    {
        $startDate = $request->start_date ? $request->start_date : Carbon::today()->subDays(30);
        $endDate = $request->end_date ? $request->end_date : Carbon::today();
        $userId = $id;

        $data = $this->repository->getCod($request, $id);
        return view('orders::transactionHistory.cod.show', compact('data', 'userId', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     * @param $id
     * @return Response
     */
    public function create($id)
    {
        $data = $this->repository->getPharmacyInfo($id);

        return view('orders::transactionHistory.epay.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateTransactionHistoryRequest $request
     * @return RedirectResponse
     */
    public function store(CreateTransactionHistoryRequest $request)
    {
        $data = $this->repository->store($request);

        return redirect()->route('transactionHistory.index');
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

    public function exportPharmacyTransaction(Request $request)
    {
        $district = $request->district;
        $thana = $request->thana;
        $area = $request->area;
        $date = Carbon::now()->format('d-m-Y');

        return (new TranscationExport($district, $thana, $area))->download( 'Transaction-history-'. time() . '-' . $date . '.xls');
    }
    public function exportPharmacyTransactionById(Request $request)
    {
        $toDate = $request->toDate;
        $endDate = $request->endDate;
        $userId = $request->userId;
        $date = Carbon::now()->format('d-m-Y');
        $data = PharmacyBusiness::where('user_id', Auth::user()->id)->select('pharmacy_name')->first();
        $pharmacy = Str::slug($data->pharmacy_name);

        return (new TransactionHistoryByIdExport($toDate, $endDate, $userId))->download($pharmacy . '-' . time() . '-' . $date . '.xls');
    }
    public function codExportPharmacyTransaction(Request $request)
    {
        $district = $request->district;
        $thana = $request->thana;
        $area = $request->area;
        $date = Carbon::now()->format('d-m-Y');

        return (new CodTransactionExport($district, $thana, $area))->download( 'Transaction-history-'. time() . '-' . $date . '.xls');
    }
    public function codExportPharmacyTransactionById(Request $request)
    {
        $toDate = $request->toDate;
        $endDate = $request->endDate;
        $userId = $request->userId;
        $date = Carbon::now()->format('d-m-Y');
        $data = PharmacyBusiness::where('user_id', Auth::user()->id)->select('pharmacy_name')->first();
        $pharmacy = Str::slug($data->pharmacy_name);

        return (new CodTransactionHistoryByIdExport($toDate, $endDate, $userId))->download($pharmacy.'-'.time().'-'. $date . '.xls');
    }
}
