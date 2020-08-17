<?php

namespace Modules\Products\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Products\Entities\Model\Generic;
use Modules\Products\Http\Requests\CreateCompanyRequest;
use Modules\Products\Http\Requests\UpdateCompanyRequest;
use Modules\Products\Repositories\GenericRepository;
use Modules\Products\Transformers\GenericTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GenericController extends BaseController
{
    private $repository;

    public function __construct(GenericRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $genericList = $this->repository->all();

        if (! $genericList) {
            throw new NotFoundHttpException('Generic list Not Found');
        }

//        $generic = Generic::paginate(10);

        return $this->response->collection($genericList, new GenericTransformer());
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     * @param CreateCompanyRequest $request
     * @return Response
     */
    public function store(CreateCompanyRequest $request)
    {
        $generic = $this->repository->create($request);

        if (! $generic) {
            throw new StoreResourceFailedException('Generic Create failed');
        }

        return $this->response->created('/products/generic', $generic);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $generic = $this->repository->get($id);

        if (! $generic ) {
            throw new NotFoundHttpException('Generic Not Found');
        }

        return $this->response->item($generic, new GenericTransformer());

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     * @param UpdateCompanyRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        $generic = $this->repository->update($request, $id);

        if (!$generic) {
            throw new UpdateResourceFailedException('Generic Update Failed');
        }

        return $this->response->item($generic, new GenericTransformer());
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $generic = $this->repository->delete($id);

        if (! $generic) {
            throw new DeleteResourceFailedException('Generic Delete Failed');
        }

        return responseData('Generic delete successful');
    }
}
