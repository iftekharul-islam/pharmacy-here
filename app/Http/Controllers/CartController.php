<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Products\Entities\Model\Product;

class CartController extends Controller
{
    private $repository;

    public function __construct(CartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        if (Auth::user()) {
            $data = $this->repository->getCartByCustomer(Auth::user()->id);

            session()->put('cartCount', count($data) ?? '');
        }
        else {
            $data = session('cart');
            session()->put('cartCount', count($data) ?? '');

        }
        return view('cart.index', compact('data'));
    }

    public function addToCart(Request $request, $id)
    {
        if (Auth::user()) {
            $data = $this->repository->addToCart($id);
            $cartCount = $this->repository->getCartItemCount(Auth::user()->id);
            session()->put('cartCount', $cartCount);

            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
        else {
            $product = Product::find($id);

            if (!$product) {

                abort(404);

            }
            $cart = session()->get('cart');

            // if cart is empty then this the first product
            if (!$cart) {

                $cart = [
                    $id => [
                        "product_name" => $product->name,
                        "quantity" => $product->min_order_qty,
                        "amount" => $product->purchase_price,
                    ]
                ];

                session()->put('cart', $cart);
                session()->put('cartCount', count($cart));

                return redirect()->back()->with('success', 'Product added to cart successfully!');
            }

            // if cart not empty then check if this product exist then increment quantity
            if (isset($cart[$id])) {

                $cart[$id]['quantity']++;

                session()->put('cart', $cart);

                return redirect()->back()->with('success', 'Product added to cart successfully!');

            }

            // if item not exist in cart then add to cart with db product qty
            $cart[$id] = [
                "product_name" => $product->name,
                "quantity" => $product->min_order_qty,
                "amount" => $product->min_order_qty * $product->purchase_price,
            ];

            session()->put('cart', $cart);
            session()->put('cartCount', count($cart));
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        if($request->id and $request->quantity)
        {
            if (Auth::user()) {
                $data = $this->repository->update($request);
                session()->flash('success', 'Cart updated successfully');
            }
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);

            session()->put('cartCount', count($cart));
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            if (Auth::user()) {

                $this->repository->delete($request);
            }
            else {

                $cart = session()->get('cart');

                if (isset($cart[$request->id])) {

                    unset($cart[$request->id]);

                    session()->put('cart', $cart);
                    session()->put('cartCount', count($cart));
                }

                session()->flash('success', 'Product removed successfully');
            }
        }
    }
}
