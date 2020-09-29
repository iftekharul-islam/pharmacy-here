<?php

namespace Modules\Orders\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Orders\Http\Requests\CreateTransactionHistoryRequest;
use Modules\Orders\Repositories\TransactionHistoryRepository;
use Modules\Orders\Transformers\OrderTransformer;
use Modules\Orders\Transformers\TransactionHistoryTransformer;

class TransactionHistoryController extends BaseController
{
    private $repository;

    public function __construct(TransactionHistoryRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function getPharmacyTransaction()
    {
        $user = Auth::user();

        $data = $this->repository->getPharmacyTransaction($user->id);

        return $this->response->paginator($data, new TransactionHistoryTransformer());

    }

    public function getPharmacyTransactionAmount()
    {
        $user = Auth::user();

        $data = $this->repository->getPharmacyTransactionAmount($user->id);

        return responsePreparedData( $data );
    }

    public function pharmacySalesHistory()
    {
        $user = Auth::user();

        $data = $this->repository->pharmacySalesHistory($user->id);

        return $this->response->paginator($data, new OrderTransformer());
    }

    public function pharmacyTotalSale()
    {
        $user = Auth::user();


        $pharmacySales = $this->repository->pharmacyTotalSale($user->id);

        $saleInfo = [];
        $totalSale = 0;

        foreach($pharmacySales as $item) {
            $totalSale = $totalSale + ($item['amount'] - $item['subidha_comission']);
        }

        $data = [
            'total_sale' => $totalSale,
            'sale_count' => count($pharmacySales)
        ];

        return responsePreparedData($data);

//        return $this->response->paginator($data, new OrderTransformer());

    }

    public function storePharmacyTransaction(CreateTransactionHistoryRequest $request)
    {
        $user = Auth::user();

        $data = $this->repository->storePharmacyTransaction($request, $user->id);

        return $this->response->item($data, new TransactionHistoryTransformer());
    }




}
