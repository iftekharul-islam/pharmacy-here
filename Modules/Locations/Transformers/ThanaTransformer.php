<?php


namespace Modules\Locations\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Locations\Entities\Models\Thana;

class ThanaTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'areas', 'district'
    ];
    public function transform(Thana $item)
    {
        return [
            'id'                        => $item->id,
            'name'                      => $item->name,
            'bn_name'                   => $item->bn_name,
            'slug'                      => $item->slug
        ];
    }

    public function includeAreas(Thana $item)
    {
        return $this->collection($item->areas, new AreaTransformer());
    }

    public function includeDistrict(Thana $item)
    {
        return $this->item($item->district, new DistrictTransformer());
    }




}
