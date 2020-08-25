<?php


namespace Modules\Address\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Address\Entities\CustomerAddress;
use Modules\Locations\Entities\Models\Area;
use Modules\Locations\Transformers\AreaTransformer;

class AddressTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'area'
    ];

    public function transform(CustomerAddress $item)
    {
        return [
            'id'       => $item->id,
            'address'  => $item->address,
            'area_id'  => $item->area_id,
            'user_id'  => $item->user_id,
        ];
    }

    public function includeArea(CustomerAddress $item)
    {
        return $this->item($item->area, new AreaTransformer());
    }

}
