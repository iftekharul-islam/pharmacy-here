<?php

namespace Modules\Products\Http\Controllers;

use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Modules\Products\Http\Requests\CreateCompanyRequest;
use Modules\Products\Http\Requests\UpdateCompanyRequest;
use Modules\Products\Repositories\GenericRepository;
use Modules\Products\Transformers\GenericTransformer;
use Nwidart\Modules\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GenericController extends Controller
{
    private $repository;

    public function __construct(GenericRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return Factory|View
     */
    public function index()
    {
        $genericList = $this->repository->all();

        if (! $genericList) {
            throw new NotFoundHttpException('Generic list Not Found');
        }

        return view('products::generic.index', compact('genericList'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Factory|View
     */
    public function create()
    {
        return view('products::generic.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateCompanyRequest $request
     * @return RedirectResponse
     */
    public function store(CreateCompanyRequest $request)
    {
        $generic = $this->repository->create($request);

        if (! $generic) {
            throw new StoreResourceFailedException('Generic Create failed');
        }

        return redirect()->route('generic.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $generic = $this->repository->get($id);

        if (! $generic ) {
            throw new NotFoundHttpException('Generic Not Found');
        }
        return view('products::generic.edit', compact('generic'));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateCompanyRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        $generic = $this->repository->update($request, $id);

        if (!$generic) {
            throw new UpdateResourceFailedException('Generic Update Failed');
        }

        return redirect()->route('generic.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $generic = $this->repository->delete($id);

        if (! $generic) {
            throw new DeleteResourceFailedException('Generic Delete Failed');
        }

        return redirect()->route('generic.index');
    }
}
