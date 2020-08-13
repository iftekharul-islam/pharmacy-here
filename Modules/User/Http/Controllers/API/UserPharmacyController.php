<?php

namespace Modules\User\Http\Controllers\API;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Modules\User\Http\Requests\CreateWeekendsAndWorkingHourRequest;
use Modules\User\Http\Requests\PharmacyBusinessRequest;
use Modules\User\Http\Requests\UpdatePharmacyBankInfoRequest;
use Modules\User\Http\Requests\UpdatePharmacyProfileRequest;
use Modules\User\Http\Requests\UpdateWeekendsAndWorkingHourRequest;
use Modules\User\Repositories\PharmacyRepository;
use Modules\User\Transformers\PharmacyBusinessTransformer;
use Modules\User\Transformers\PharmacyTransformer;
use Modules\User\Transformers\WeekendsTransformer;

class UserPharmacyController extends BaseController
{
    private $repository;

    public function __construct(PharmacyRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return 'Pharmacy API';
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
        //
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

    /**
     * POST /api/user/me/pharmacy/business
     *
     * @param PharmacyBusinessRequest $request
     * @return \Modules\User\Entities\Models\PharmacyBusiness
     */
    public function createBusinessInfo(PharmacyBusinessRequest $request)
    {
        return $this->repository->createBusinessInfo($request, Auth::id());
    }


    /**
     * GET /api/user/me/pharmacy/weekends-and-working-hours
     *
     * @param CreateWeekendsAndWorkingHourRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function getWeekendsAndWorkingHoursInfo()
    {

        $infoResponse = $this->repository->getWeekendsAndWorkingHoursInfo(Auth::id());

        if (! $infoResponse) {
            throw new StoreResourceFailedException('Weekends and working hour create failed');
        }

        return $this->response->collection($infoResponse, new WeekendsTransformer());

//        return responseData('Weekends and working hour create successful');
    }

    /**
     * POST /api/user/me/pharmacy/weekends-and-working-hours
     *
     * @param CreateWeekendsAndWorkingHourRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function createWeekendsAndWorkingHoursInfo(CreateWeekendsAndWorkingHourRequest $request)
    {

        $infoResponse = $this->repository->createWeekendsAndWorkingHoursInfo($request, Auth::id());

        if (! $infoResponse) {
            throw new StoreResourceFailedException('Weekends and working hour create failed');
        }

        $pharmacy = $this->repository->getPharmacyInformation(Auth::id());

        return $this->response->item($pharmacy, new PharmacyTransformer());

//        return responseData('Weekends and working hour create successful');
    }

    /**
     * PUT /api/user/me/pharmacy/weekends-and-working-hours
     *
     * @param UpdateWeekendsAndWorkingHourRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function updateWeekendsAndWorkingHoursInfo(UpdateWeekendsAndWorkingHourRequest $request)
    {

        $infoResponse = $this->repository->updateWeekendsAndWorkingHoursInfo($request, Auth::id());

        if (! $infoResponse) {
            throw new StoreResourceFailedException('Weekends and working hour update failed');
        }

        return $this->response->item($infoResponse, new PharmacyBusinessTransformer());
    }

    /**
     * GET /api/user/me/pharmacy
     *
     * @return \Dingo\Api\Http\Response
     */
    public function getPharmacyProfile()
    {
        $infoResponse = $this->repository->getPharmacyInformation(Auth::id());

        return $this->response->item($infoResponse, new PharmacyTransformer());


    }

    /**
     * PUT /api/user/me/pharmacy
     *
     * @param UpdatePharmacyProfileRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function updatePharmacyProfile(UpdatePharmacyProfileRequest $request)
    {
        $infoResponse = $this->repository->updatePharmacyInformation($request, Auth::id());

        if (! $infoResponse) {
            throw new UpdateResourceFailedException('Pharmacy profile update failed');
        }

        return $this->response->item($infoResponse, new PharmacyTransformer());


    }

    /**
     * GET /api/user/me/pharmacy/bank-info
     *
     * @return \Dingo\Api\Http\Response
     */
    public function getPharmacyBankInfo()
    {
        $infoResponse = $this->repository->getPharmacyBankInformation(Auth::id());

        return $this->response->item($infoResponse, new PharmacyBusinessTransformer());
    }

    /**
     * PUT /api/user/me/pharmacy/bank-info
     *
     * @param UpdatePharmacyBankInfoRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function updatePharmacyBankInfo(UpdatePharmacyBankInfoRequest $request)
    {

        $infoResponse = $this->repository->updatePharmacyBankInformation($request, Auth::id());

        if (! $infoResponse) {
            throw new UpdateResourceFailedException('Pharmacy bank information update failed');
        }

        return $this->response->item($infoResponse, new PharmacyBusinessTransformer());
    }
}
