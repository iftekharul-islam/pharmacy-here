<?php

namespace Modules\Products\Http\Controllers;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Products\Http\Requests\CreateCompanyRequest;
use Modules\Products\Http\Requests\UpdateCompanyRequest;
use Modules\Products\Repositories\CompanyRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyController extends Controller
{
    private $repository;

    public function __construct(CompanyRepository $repository)
    {
        $this->repository =$repository;
    }

    /**
     * Display a listing of the resource.
     * @return Factory|View
     */
    public function index()
    {
        $companyList = $this->repository->all();
        return view('products::company.index', compact('companyList'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('products::company.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateCompanyRequest $request
     * @return RedirectResponse
     */
    public function store(CreateCompanyRequest $request)
    {
        $company = $this->repository->create($request);

        if (! $company) {
            throw new StoreResourceFailedException('Company Create Failed');
        }

        return redirect()->route('company.index');
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
     * @return Response
     */
    public function edit($id)
    {
        $company = $this->repository->get($id);

        if (! $company) {
            throw new NotFoundHttpException('Company Not Found');
        }

        return view('products::company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        $company = $this->repository->update($request, $id);

        if (! $company) {
            throw new UpdateResourceFailedException('Company update failed');
        }

        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        return $this->repository->delete($id);
    }
}
