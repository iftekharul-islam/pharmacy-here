<?php


namespace Modules\Locations\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Locations\Entities\Models\Area;
use Modules\Locations\Entities\Models\Thana;

class ThanaTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'areas'
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




}
