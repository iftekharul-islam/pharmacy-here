<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Orders\Entities\Models\OrderItems;
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
            session()->put('cartCount', $data != null ? count($data) : '');

        }
        return view('cart.index', compact('data'));
    }

    public function addToCart(Request $request, $id)
    {
        if (Auth::user()) {
            $data = $this->repository->addToCart($id);
            $cartCount = $this->repository->getCartItemCount(Auth::user()->id);
            session()->put('cartCount', $cartCount);

            return redirect()->back()->with('success', __('text.add_to_cart_message'));
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
                        "minQuantity" => $product->min_order_qty,
                        "amount" => $product->purchase_price,
                    ]
                ];

                session()->put('cart', $cart);
                session()->put('cartCount', count($cart));

                return redirect()->back()->with('success', __('text.add_to_cart_message'));
            }

            // if cart not empty then check if this product exist then increment quantity
            if (isset($cart[$id])) {

                $cart[$id]['quantity']++;

                session()->put('cart', $cart);

                return redirect()->back()->with('success', __('text.add_to_cart_message'));

            }

            // if item not exist in cart then add to cart with db product qty
            $cart[$id] = [
                "product_name" => $product->name,
                "quantity" => $product->min_order_qty,
                "minQuantity" => $product->min_order_qty,
                "amount" => $product->min_order_qty * $product->purchase_price,
            ];

            session()->put('cart', $cart);
            session()->put('cartCount', count($cart));
        }

        return redirect()->back()->with('success', __('text.add_to_cart_message'));
    }

    public function update(Request $request)
    {
        logger($request->all);
        if($request->id && $request->quantity)
        {
            if (Auth::user()) {
                $data = $this->repository->update($request);
                return response()->json($data);
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

        if($request->id || is_array($request->id)) {


            if (Auth::user()) {

                $data = $this->repository->delete($request);
                return $data;
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function findCart (Request $request) {
        $itemId = Cart::where('customer_id', Auth::user()->id)->where('product_id', $request->id)->first();
        return response($itemId);
    }

    /**
     * @param Request $request
     */
    public function orderToCart (Request $request) {
        $values =  OrderItems::where('order_id', $request->itemId)->get();

        foreach ($values as $item) {
            $cartData = Cart::where('product_id', $item->product_id)->where('customer_id', Auth::user()->id)->first();

            if ($cartData) {
                $cartData->quantity = $item->quantity + $cartData->quantity ;
                $cartData->amount = $cartData->quantity * $item->rate ;
                $cartData->save();
            } else {
                 Cart::create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'amount' => $item->quantity * $item->rate,
                    'customer_id' => Auth::user()->id,
                ]);
            }
        }
        $count = Cart::where('customer_id', Auth::user()->id)->get();
        session()->forget('cartCount');
        session()->put('cartCount', count($count));
        return redirect()->back()->with('success', 'Products added to cart');
    }

    public function cartCount() {
        $count = Cart::where('customer_id', Auth::user()->id)->get();
        return response()->json($count);
    }
}
