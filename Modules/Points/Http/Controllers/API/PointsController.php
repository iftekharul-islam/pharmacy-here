<?php

namespace Modules\Points\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Points\Entities\Models\Points;
use Modules\Points\Repositories\PointRepository;

class PointsController extends Controller
{
    private $repository;

    public function __construct(PointRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function playstoreRating()
    {
        $rating = $this->repository->playstoreRating(Auth::guard('api')->user()->id);
        return responsePreparedData($rating);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function alarmPoint()
    {
        $data = $this->repository->alarmPoint(Auth::guard('api')->user()->id);

        if ($data !== false) {
            return responsePreparedData($data);
        }

        return responsePreparedData('Point is already given');

    }
}
