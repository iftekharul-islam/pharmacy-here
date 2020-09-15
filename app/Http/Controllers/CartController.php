<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Orders\Repositories\CartRepository;

class CartController extends Controller
{
    private $repository;

    public function __construct(CartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $data = session()->get('cart');
//        return $data;
    }

    public function addToCart($id)
    {

    }
}
