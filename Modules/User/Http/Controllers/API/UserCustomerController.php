<?php

namespace Modules\User\Http\Controllers\API;

use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Modules\User\Http\Requests\UpdatePharmacyProfileRequest;
use Modules\User\Repositories\CustomerRepository;
use Modules\User\Transformers\CustomerTransformer;

class UserCustomerController extends BaseController
{
    private $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
//        return 'Pharmacy API';
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
     * @return Response
     */
    public function show()
    {
        $data = $this->repository->get(Auth::id());
//        return $data;

        return $this->response->item($data, new CustomerTransformer());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $infoResponse = $this->repository->update($request, Auth::user()->id);

//        if (! $infoResponse) {
//            throw new UpdateResourceFailedException('Pharmacy profile update failed');
//        }

        return $this->response->item($infoResponse, new CustomerTransformer());
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

    /**
     * GET /api/user/me/pharmacy
     *
     * @return \Dingo\Api\Http\Response
     */
    public function getCustomerProfile()
    {


    }

    /**
     * PUT /api/user/me/pharmacy
     *
     * @param UpdatePharmacyProfileRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function updateCustomerProfile(UpdatePharmacyProfileRequest $request)
    {


    }
}
