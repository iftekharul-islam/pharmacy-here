<?php

namespace Modules\Products\Http\Controllers\API;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Products\Http\Requests\CreateProductRequest;
use Modules\Products\Repositories\ProductRepository;

class ProductsController extends Controller
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository =$repository;
    }

    /**
     * Display a listing of the resource.
     * @return Builder[]|Collection
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
     * @param CreateProductRequest $request
     * @return JsonResponse
     */
    public function store(CreateProductRequest $request)
    {
        return $this->repository->create($request);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function show($id)
    {
        return $this->repository->get($id);
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
     * @return JsonResponse
     */
    public function update(Request $request, $id)
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
