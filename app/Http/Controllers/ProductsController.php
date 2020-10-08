<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
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
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $data = $this->repository->all($request);
//        return $data;
        if (Auth::user()) {
            $cartItems = Cart::with('product')->where('customer_id', Auth::user()->id)->get();
            return view('product.index', compact('data', 'cartItems'));
        }

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
        $relatedProducts = $this->repository->getRelatedProductByProductId($id);

        return view('product.show', compact('data', 'relatedProducts'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getProductName(Request $request)
    {
        return $this->repository->getProductName($request);
    }


}
