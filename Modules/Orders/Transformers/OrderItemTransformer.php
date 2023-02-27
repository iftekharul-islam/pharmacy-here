<?php


namespace Modules\Orders\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Orders\Entities\Models\OrderItems;
use Modules\Products\Transformers\ProductTransformer;

class OrderItemTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'product'
    ];

    public function transform(OrderItems $item)
    {
        return [
            'id'            => $item->id,
            'quantity'      => $item->quantity,
            'rate'          => $item->rate
        ];
    }

    public function includeProduct(OrderItems $item)
    {
        return $this->item($item->product, new ProductTransformer());
    }


}

