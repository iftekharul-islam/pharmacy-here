<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\BaseController;
use Carbon\Carbon;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Products\Entities\Model\Generic;
use Modules\Products\Http\Requests\CreateProductRequest;
use Modules\Products\Http\Requests\UpdateProductRequest;
use Modules\Products\Imports\ProductImport;
use Modules\Products\Repositories\ProductRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductsController extends Controller
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository =$repository;
    }

    /**
     * Display a listing of the resource.
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $productList = $this->repository->all($request);

        if (! $productList) {
            throw new NotFoundHttpException('Product List Not Found');
        }

        return view('products::index', compact('productList'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Factory|View
     */
    public function create()
    {
        $categories = $this->repository->getAllCategory();
        $generics = $this->repository->getAllGeneric();
        $forms = $this->repository->getAllForm();
        $companies = $this->repository->getAllCompany();
        $units = $this->repository->getAllUnit();

        return view('products::create', compact('categories', 'generics', 'forms', 'companies', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateProductRequest $request
     * @return RedirectResponse
     */
    public function store(CreateProductRequest $request)
    {
        $product = $this->repository->create($request);

        if (!$product) {
            throw new StoreResourceFailedException('Product create failed');
        }

        return redirect()->route('index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Factory|View
     */
    public function show($id)
    {
        return view('products::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $product = $this->repository->get($id);
        $categories = $this->repository->getAllCategory();
        $generics = $this->repository->getAllGeneric();
        $forms = $this->repository->getAllForm();
        $companies = $this->repository->getAllCompany();
        $units = $this->repository->getAllUnit();

        return view('products::edit', compact('product', 'categories', 'generics', 'forms', 'companies', 'units'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $product = $this->repository->update($request, $id);

        if (!$product) {
            throw new UpdateResourceFailedException('Product update failed');
        }

        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
//        print_r($id);die();
        $product = $this->repository->delete($id);

        if (!$product) {
            throw new DeleteResourceFailedException('Product Delete Failed');
        }

        return redirect()->route('index');
    }

    public function importCsv(Request $request)
    {

        Excel::import(new ProductImport, $request->file('file'));

        return redirect()->back()->with('success', 'Product Import Successful');
    }
}
