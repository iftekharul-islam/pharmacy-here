<?php

namespace Modules\User\Http\Controllers\API;

use Dingo\Api\Auth\Auth;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\CreateWeekendsAndWorkingHourRequest;
use Modules\User\Http\Requests\PharmacyBusinessRequest;
use Modules\User\Repositories\PharmacyRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserPharmacyController extends Controller
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

    public function name()
    {
        return responseData('Authorised pharmacy');
    }

    public function createBusinessInfo(PharmacyBusinessRequest $request)
    {
        $id = \Illuminate\Support\Facades\Auth::id();

        return $this->repository->createBusinessInfo($request, $id);
    }

    public function createWeekendsAndWorkingHoursInfo(CreateWeekendsAndWorkingHourRequest $request)
    {
        $id = \Illuminate\Support\Facades\Auth::id();

        $infoResponse = $this->repository->createWeekendsAndWorkingHoursInfo($request, $id);

        if (! $infoResponse) {
            throw new StoreResourceFailedException('Weekends and working hour create failed');
        }

        return responseData('Weekends and working hour create successful');
    }
}
