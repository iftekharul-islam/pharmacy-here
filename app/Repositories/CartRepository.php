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
            $cartData->amount = $cartData->amount + $product->purchase_price;
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
        if ($item === null) {
            $item = Cart::where('customer_id', Auth::user()->id)->where('product_id', $request->productId)->first();
        }
        $product = Product::find($item->product_id);

//        if ($item === null) {
//            abort(404);
//        }

        if($request->id && $request->quantity)
        {
            $item->quantity = $request->quantity;
            $item->amount = $product->purchase_price * $request->quantity;


            $item->save();

            return $item;
        }
    }

    public function delete($request)
    {
        logger($request->id);
        logger('out');
        if (is_array( $request->id)) {
            logger($request->id);
            logger('in');
            foreach ($request->id as $id) {
                $item = Cart::find($id);
                $item->delete();
            }
            return true;
        } elseif (!empty($request->id)) {
            $item = Cart::find($request->id);
                logger($item);
                logger('out product id');
                if (!$item) {
                    logger('in product id');
                    $item = Cart::where('customer_id', Auth::user()->id)->where('product_id', $request->productId)->first();
                    logger($item);
                    if (!$item){
                        return false;
                    }
                    $item->delete();
                    return true;
                }

            if ($item != null) {
                $item->delete();
                return true;
            }
            return false;
        }
//        elseif ($request->id == null){
//
//            $item = Cart::find($request->id);
//            $item->delete();
//        }
        return false;
    }

    public function getCartByCustomer($customer_id)
    {
        return Cart::with('product', 'product.form')->where('customer_id', $customer_id)->get();
    }

    public function getCartAmount($customer_id)
    {
        $items =  Cart::with('product')->where('customer_id', $customer_id)->get();
        return $sum_amount =  Cart::with('product')->where('customer_id', $customer_id)->sum('amount');
//
//        foreach ($items as $item) {
//            $amount = $item->amount;
//        }
    }

    public function getCartItemCount($customer_id)
    {
        return Cart::where('customer_id', $customer_id)->count();
    }
}
