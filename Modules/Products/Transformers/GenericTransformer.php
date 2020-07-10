<?php


namespace Modules\Products\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Products\Entities\Model\Generic;

class GenericTransformer extends TransformerAbstract
{
    public function transform(Generic $generic)
    {
        return [
            'id'                        => $generic->id,
            'name'                      => $generic->name,
            'status'                    => $generic->status,
        ];
    }
}
