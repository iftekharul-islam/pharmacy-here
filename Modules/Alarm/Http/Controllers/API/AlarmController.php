<?php

namespace Modules\Alarm\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Alarm\Http\Requests\CreateAlarmRequest;
use Modules\Alarm\Http\Requests\UpdateAlarmRequest;
use Modules\Alarm\Repositories\AlarmRepository;

class AlarmController extends Controller
{
    private $repository;

    public function __construct(AlarmRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        $user = Auth::guard('api')->user();
        $data = $this->repository->all($user->id);

        return responsePreparedData($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateAlarmRequest $request
     * @return JsonResponse
     */
    public function store(CreateAlarmRequest $request)
    {
        $user = Auth::guard('api')->user();
        $data = $this->repository->create($request, $user->id);

        return responsePreparedData($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateAlarmRequest $request, $id)
    {

        $user = Auth::guard('api')->user();
        $data = $this->repository->update($request, $id);

        return responsePreparedData($data);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $data = $this->repository->delete($id);

        return responseData('Alarm deletion successful');
    }
}
