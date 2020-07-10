<?php


namespace Modules\Products\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Products\Entities\Model\Form;

class FormTransformer extends TransformerAbstract
{
    public function transform(Form $product)
    {
        return [
            'id'                        => $product->id,
            'name'                      => $product->name,
            'status'                    => $product->status,
        ];
    }
}
