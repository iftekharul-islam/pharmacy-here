<?php


namespace Modules\Locations\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Locations\Entities\Models\Area;

class AreaTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'thana'
    ];

    public function transform(Area $item)
    {
        return [
            'id'      => $item->id,
            'name'    => $item->name,
            'bn_name' => $item->bn_name,
            'slug'    => $item->slug
        ];
    }

    public function includeThana(Area $item)
    {
        return $this->item($item->thana, new ThanaTransformer());
    }

}
