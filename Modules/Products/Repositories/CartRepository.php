<?php


namespace Modules\Products\Repositories;

use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Support\Str;
use Modules\Products\Entities\Model\Cart;
use Modules\Products\Entities\Model\CartItem;
use Modules\Products\Entities\Model\Category;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CartRepository
{
    public function all()
    {

    }

    public function findById($id)
    {

    }

    public function create($request, $order_from, $customerId)
    {
        $cartId = 0;
        foreach ($request as $req)
        {
//            print_r($req['cart_id']);
//            print_r("\n");
//            print_r($req['product_id']);
//            print_r("\n");
////            print_r($req->quantity);
////            print_r("\n");
////            print_r($req->amount);
//            print_r("\n");
//            print_r("\n");

            if (!isset($req['cart_id'])) {
//                $cartInfo = new Cart();
//                $cartInfo->customer_id = $customerId;
//                $cartInfo->save();
//
//                $cartId = $cartInfo->id;

                $cartInfo = Cart::create([
                    'customer_id' => $customerId,
                    'order_from' => $order_from,
                ]);

            } else {
                $cartId = $req['cart_id'];
            }

            $this->createCartItem($req, $cartId);
        }
        die();
        return CartItem::where('cart_id', $cartId)->get();

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

        $cartItemsInfo = CartItem::create([
            'cart_id' => $cart_id,
            'product_id' => $request['product_id'],
            'quantity' => $request['quantity'],
            'amount' => $request['amount'],
        ]);

        return $cartItemsInfo;
    }

    public function updateCartItem($request, $cartItemId)
    {
        $cartItemInfo = CartItem::findOrFail($cartItemId);

        if (!$cartItemInfo) {
            throw new NotFoundHttpException('Cart Item not found');
        }

        if ($request->has('quantity')){
            $cartItemInfo->quantity = $request->quantity;
        }

        $cartItemInfo->save();
        return $cartItemInfo;
    }

}
