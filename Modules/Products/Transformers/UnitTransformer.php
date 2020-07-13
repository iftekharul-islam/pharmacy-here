<?php


namespace Modules\Products\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Products\Entities\Model\Unit;

class UnitTransformer extends TransformerAbstract
{
    public function transform(Unit $unit)
    {
        return [
            'id'                        => $unit->id,
            'name'                      => $unit->name,
            'status'                    => $unit->status,
        ];
    }

}
