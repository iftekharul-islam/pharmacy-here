<?php


namespace Modules\User\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\User\Entities\Models\BankName;
use Modules\User\Entities\Models\Weekends;

class BankTransformer extends TransformerAbstract
{

    public function transform(BankName $item)
    {
        return [
            'id'                            => $item->id,
            'bank_name'                     => $item->bank_name,
            'bn_bank_name'                  => $item->bn_bank_name,
            'created_at'                    => $item->created_at,
            'updated_at'                    => $item->updated_at,
        ];
    }

}


