<?php

namespace Modules\Products\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Products\Http\Requests\CreateCompanyRequest;
use Modules\Products\Http\Requests\UpdateCompanyRequest;
use Modules\Products\Repositories\CompanyRepository;
use Modules\Products\Transformers\CompanyTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyController extends BaseController
{
    private $repository;

    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $companyList = $this->repository->all();

        if (! $companyList) {
            throw new NotFoundHttpException('Company list Not Found');
        }

        return $this->response->paginator($companyList, new CompanyTransformer());
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
        $company = $this->repository->create($request);

        if (! $company) {
            throw new StoreResourceFailedException('Company Create failed');
        }

        return $this->response->created('/products/category', $company);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $company = $this->repository->get($id);

        if (! $company) {
            throw new NotFoundHttpException('Company Not Found');
        }

        return $this->response->item($company, new CompanyTransformer());
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
     * @return \Dingo\Api\Http\Response
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        $company = $this->repository->update($request, $id);

        if (! $company) {
            throw new UpdateResourceFailedException('Company update failed');
        }

        return $this->response->item($company, new CompanyTransformer());
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $company =  $this->repository->delete($id);

        if (! $company) {
            throw new DeleteResourceFailedException('Company Delete Failed');
        }

        return responseData('Company delete successful');
    }
}
