<?php

namespace Modules\Orders\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Orders\Http\Requests\CreateTransactionHistoryRequest;
use Modules\Orders\Repositories\TransactionHistoryRepository;
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

    public function pharmacyTotalSale()
    {
        $user = Auth::user();

        $data = $this->repository->pharmacyTotalSale($user->id);

        return $this->response->paginator($data, new TransactionHistoryTransformer());

    }

    public function storePharmacyTransaction(CreateTransactionHistoryRequest $request)
    {
        $user = Auth::user();

        $data = $this->repository->storePharmacyTransaction($request, $user->id);

        return $this->response->item($data, new TransactionHistoryTransformer());
    }




}
