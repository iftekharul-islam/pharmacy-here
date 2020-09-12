<?php


namespace Modules\Orders\Repositories;


use Modules\Products\Entities\Model\Cart;
use Modules\Products\Entities\Model\CartItem;

class CartRepository
{
    public function all()
    {

    }

    public function findById($id)
    {

    }

    public function create()
    {


    }

    public function findBySlug($slug)
    {

    }

    public function update($request, $id)
    {

    }

    public function delete($id)
    {

    }

    public function createCartItem($request, $cart_id)
    {
//        $cartItemsInfo = new CartItem();
//        $cartItemsInfo->cart_id = $cart_id;
//        $cartItemsInfo->product_id = $request->product_id;
//        $cartItemsInfo->quantity = $request->quantity;
//        $cartItemsInfo->amount = $request->amount;
//        $cartItemsInfo->save();

//        $cartItemsInfo = CartItem::create([
//            'cart_id' => $cart_id,
//            'product_id' => $request['product_id'],
//            'quantity' => $request['quantity'],
//            'amount' => $request['amount'],
//        ]);
//
//        return $cartItemsInfo;
    }

    public function updateCartItem($request, $cartItemId)
    {
//        $cartItemInfo = CartItem::findOrFail($cartItemId);
//
//        if (!$cartItemInfo) {
//            throw new NotFoundHttpException('Cart Item not found');
//        }
//
//        if ($request->has('quantity')){
//            $cartItemInfo->quantity = $request->quantity;
//        }
//
//        $cartItemInfo->save();
//        return $cartItemInfo;
    }
}
