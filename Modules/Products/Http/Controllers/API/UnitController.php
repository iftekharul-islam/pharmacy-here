<?php

namespace Modules\Products\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Products\Http\Requests\UnitCreateRequest;
use Modules\Products\Repositories\UnitRepository;

class UnitController extends Controller
{
    private $repository;

    public function __construct(UnitRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        return $this->repository->all();
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('products::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param UnitCreateRequest $request
     * @return JsonResponse
     */
    public function store(UnitCreateRequest $request)
    {
        return $this->repository->create($request);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return $this->repository->findById($id);
    }

    /**
     * @param $slug
     * @return JsonResponse
     */
    public function showBySlug($slug)
    {
        return $this->repository->findBySlug($slug);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('products::edit');
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
        return $this->repository->delete($id);
    }
}
