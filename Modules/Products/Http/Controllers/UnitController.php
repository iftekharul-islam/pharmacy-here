<?php

namespace Modules\Products\Http\Controllers;

use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Modules\Products\Http\Requests\UnitCreateRequest;
use Modules\Products\Http\Requests\UpdateUnitRequest;
use Modules\Products\Repositories\UnitRepository;
use Modules\Products\Transformers\UnitTransformer;
use Nwidart\Modules\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UnitController extends Controller
{
    private $repository;

    public function __construct(UnitRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return Factory|View
     */
    public function index()
    {
        $unitList = $this->repository->all();

        if (! $unitList) {
            throw new NotFoundHttpException('Unit list Not Found');
        }

        return view('products::unit.index', compact('unitList'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('products::unit.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param UnitCreateRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(UnitCreateRequest $request)
    {
        $unit = $this->repository->create($request);

        if (! $unit) {
            throw new StoreResourceFailedException('Unit Create failed');
        }

        return redirect()->route('unit.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {

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
     * @return Factory|View
     */
    public function edit($id)
    {
        $unit = $this->repository->findById($id);

        if (! $unit ) {
            throw new NotFoundHttpException('Unit Not Found');
        }

        return view('products::unit.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateUnitRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateUnitRequest $request, $id)
    {
        $unit = $this->repository->update($request, $id);

        if (! $unit) {
            throw new UpdateResourceFailedException('Unit update failed');
        }

        return redirect()->route('unit.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $unit = $this->repository->delete($id);

        if (! $unit) {
            throw new DeleteResourceFailedException('Unit Delete Failed');
        }

        return redirect()->route('unit.index');
    }
}
