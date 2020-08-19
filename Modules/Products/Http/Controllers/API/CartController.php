<?php

namespace Modules\Products\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Products\Http\Requests\CartCreateRequest;
use Modules\Products\Http\Requests\UpdateCartItemRequest;
use Modules\Products\Repositories\CartRepository;
use Modules\Products\Transformers\CartItemTransformer;

class CartController extends BaseController
{

    private $repository;

    public function __construct(CartRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
//        $categoryList = $this->repository->all();
//
//        if (! $categoryList) {
//            throw new NotFoundHttpException('Category list Not Found');
//        }
//
//        $category = Category::paginate(10);
//        return $this->response->paginator($category, new CategoryTransformer());
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('products::create');
    }


    public function store(CartCreateRequest $request)
//    public function store(Request $request)
    {
//        return Auth::id();
//        return $request->all();

        $cartInfo = $this->repository->create($request->cart_items, $request->order_from, Auth::id());

        if (! $cartInfo) {
            throw new StoreResourceFailedException('Cart creation failed');
        }

        return $this->response->collection($cartInfo, new CartItemTransformer());
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
//        $category = $this->repository->findById($id);
//
//        if (! $category) {
//            throw new NotFoundHttpException('Category Not Found');
//        }
//
//        return $this->response->item($category, new CategoryTransformer());
    }

    public function showBySlug($slug)
    {
//        $category = $this->repository->findBySlug($slug);
//
//        if (! $category) {
//            throw new NotFoundHttpException('Category Not Found');
//        }
//
//        return $this->response->item($category, new CategoryTransformer());
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
//        $category = $this->repository->delete($id);
//
//        if (! $category) {
//            throw new DeleteResourceFailedException('Category Delete Failed');
//        }
//
//        return responseData('Category delete successful');
    }

    public function updateCartItem(UpdateCartItemRequest $request, $id)
    {
//        return $id;
        $cartInfo = $this->repository->updateCartItem($request, $id);

        if (! $cartInfo) {
            throw new StoreResourceFailedException('Cart creation failed');
        }

        return $this->response->item($cartInfo, new CartItemTransformer());
    }
}
