<?php


namespace Modules\Products\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Products\Entities\Model\CartItem;

class CartItemTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'product',
    ];
    public function transform(CartItem $item)
    {
        return [
            'id'                        => $item->id,
            'cart_id'                   => $item->cart_id,
            'product_id'                => $item->product_id,
            'quantity'                  => $item->quantity,
            'amount'                    => $item->amount,
        ];
    }

    public function includeProduct(CartItem $item)
    {
        return $this->collection($item->product, new ProductTransformer());
    }

}
