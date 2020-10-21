<?php

namespace Modules\Alarm\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Alarm\Http\Requests\CreateReminderRequest;
use Modules\Alarm\Http\Requests\UpdateReminderRequest;
use Modules\Alarm\Repositories\ReminderRepository;

class ReminderController extends Controller
{
    private $repository;

    public function __construct(ReminderRepository $repository)
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
     * @param CreateReminderRequest $request
     * @return JsonResponse
     */
    public function store(CreateReminderRequest $request)
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
    public function update(UpdateReminderRequest $request, $id)
    {
        $user = Auth::guard('api')->user();
        $data = $this->repository->update($request, $id, $user->id);

        return responsePreparedData($data);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $user = Auth::guard('api')->user();
        $data = $this->repository->delete($id, $user->id);

        return responseData('Reminder deletion successful');
    }
}
