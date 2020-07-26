<?php

namespace Modules\Products\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Products\Entities\Model\Product;
use Modules\Products\Http\Requests\CreateProductRequest;
use Modules\Products\Http\Requests\UpdateProductRequest;
use Modules\Products\Repositories\ProductRepository;
use Modules\Products\Transformers\ProductTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductsController extends BaseController
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $productList = $this->repository->all();

        if (! $productList) {
            throw new NotFoundHttpException('Product List Not Found');
        }

        $products = Product::paginate(10);
        return $this->response->paginator($products, new ProductTransformer());
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
     * @return \Dingo\Api\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $product = $this->repository->create($request);

        if (!$product) {
            throw new StoreResourceFailedException('Product create failed');
        }

        return $this->response->created('/products/products', $product);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $product = $this->repository->get($id);

        if (!$product) {
            throw new NotFoundHttpException('Product Not Found');
        }

        return $this->response->item($product, new ProductTransformer());
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
     * @param UpdateProductRequest $request
     * @param int $id
     * @return \Dingo\Api\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->repository->update($request, $id);

        if (!$product) {
            throw new UpdateResourceFailedException('Product update failed');
        }

        return $this->response->item($product, new ProductTransformer());
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $product = $this->repository->delete($id);

        if (!$product) {
            throw new DeleteResourceFailedException('Product Delete Failed');
        }

        return responseData('Product delete successful');
    }
}