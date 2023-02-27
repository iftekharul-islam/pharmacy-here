<?php

namespace Modules\Products\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Products\Entities\Model\Unit;
use Modules\Products\Http\Requests\UnitCreateRequest;
use Modules\Products\Repositories\UnitRepository;
use Modules\Products\Transformers\UnitTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UnitController extends BaseController
{
    private $repository;

    public function __construct(UnitRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $unitList = $this->repository->all();

        if (! $unitList) {
            throw new NotFoundHttpException('Unit list Not Found');
        }

        $unit = Unit::paginate(10);

        return $this->response->paginator($unit, new UnitTransformer());
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
     * @return \Dingo\Api\Http\Response
     */
    public function store(UnitCreateRequest $request)
    {
        $unit = $this->repository->create($request);

        if (! $unit) {
            throw new StoreResourceFailedException('Unit Create failed');
        }

        return $this->response->created('/products/units', $unit);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $unit = $this->repository->findById($id);

        if (! $unit ) {
            throw new NotFoundHttpException('Unit Not Found');
        }

        return $this->response->item($unit, new UnitTransformer());
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
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $unit = $this->repository->delete($id);

        if (! $unit) {
            throw new DeleteResourceFailedException('Unit Delete Failed');
        }

        return responseData('Unit delete successful');
    }
}
