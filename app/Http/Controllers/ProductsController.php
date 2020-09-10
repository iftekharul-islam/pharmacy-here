<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Modules\Products\Http\Requests\CreateProductRequest;
use Modules\Products\Http\Requests\UpdateProductRequest;
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
        $data = $this->repository->all($request);

        return view('product.index', compact('data'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Factory|View
     */
    public function show($id)
    {
        $data = $this->repository->get($id);
//        return $data->name;
        return view('product.show', compact('data'));
    }


}
