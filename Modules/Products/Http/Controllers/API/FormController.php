<?php

namespace Modules\Products\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Products\Http\Requests\CreateFormRequest;
use Modules\Products\Http\Requests\UpdateFormRequest;
use Modules\Products\Repositories\FormRepository;

class FormController extends Controller
{
    private $repository;

    public function __construct(FormRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Database\Eloquent\Collection|\Modules\Products\Entities\Model\Form[]
     */
    public function index()
    {
        return $this->repository->all();
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateFormRequest $request
     * @return Response
     */
    public function store(CreateFormRequest $request)
    {
        return $this->repository->create($request);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return $this->repository->get($id);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateFormRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateFormRequest $request, $id)
    {
        return $this->repository->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return $this->repository->delete($id);
    }
}
