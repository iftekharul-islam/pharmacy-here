<?php


namespace Modules\User\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\User\Entities\Models\Weekends;

class WeekendsTransformer extends TransformerAbstract
{

    public function transform(Weekends $item)
    {
        return [
            'id'                            => $item->id,
            'days'                          => $item->days,
            'user_id'                       => $item->user_id,
        ];
    }

}


