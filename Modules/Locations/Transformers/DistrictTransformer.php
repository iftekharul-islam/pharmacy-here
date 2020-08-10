<?php


namespace Modules\Locations\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Locations\Entities\Models\District;

class DistrictTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'thanas'
    ];

    public function transform(District $item)
    {
        return [
            'id'                        => $item->id,
            'name'                      => $item->name,
            'bn_name'                   => $item->bn_name,
            'slug'                      => $item->slug
        ];
    }

    public function includeThanas(District $item)
    {
        return $this->collection($item->thanas, new ThanaTransformer());
    }


}
