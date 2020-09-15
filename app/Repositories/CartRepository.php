<?php


namespace App\Repositories;


use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Modules\Products\Entities\Model\Product;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CartRepository
{
    public function all()
    {

    }

    public function get($id)
    {

    }

    public function update($request, $id)
    {
        $item = Cart::find($id);

        if($request->id && $request->quantity)
        {
            $item->quantity = $request->quantity;

            $item->save();

            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function delete($id)
    {
        $item = Cart::find($id);

        return $item->delete();
    }

    public function getCartByCustomer($customer_id)
    {
        return Cart::where('user_id', $customer_id)->get();
    }

    public function addToCart($request, $product_id)
    {

        return Cart::create([
            'product_id' => $product_id,
            'quantity' => $request->quantity,
            'amount' => $request->amount,
            'customer_id' => Auth::user()->id,
        ]);


    }
}
