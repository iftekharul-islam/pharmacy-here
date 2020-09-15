<?php


namespace App\Repositories;


use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Modules\Products\Entities\Model\Product;

class CartRepository
{
    public function all()
    {

    }

    public function addToCart($id)
    {
        $product = Product::find($id);

        if (! $product) {
            abort(404);
        }

        $cartData = Cart::where('product_id', $id)->where('customer_id', Auth::user()->id)->first();

        if ($cartData) {
            $cartData->quantity++;
            return $cartData->save();
        }
        return Cart::create([
            'product_id' => $id,
            'quantity' => $product->min_order_qty,
            'amount' => $product->min_order_qty * $product->purchase_price,
            'customer_id' => Auth::user()->id,
        ]);


    }

    public function update($request)
    {
        $item = Cart::find($request->id);

        if (!$item) {
            abort(404);
        }

        if($request->id && $request->quantity)
        {
            $item->quantity = $request->quantity;

            $item->save();

            return $item;
        }
    }

    public function delete($request)
    {
        $item = Cart::find($request->id);

        $item->delete();

    }

    public function getCartByCustomer($customer_id)
    {
        return Cart::with('product')->where('customer_id', $customer_id)->get();
    }
}
