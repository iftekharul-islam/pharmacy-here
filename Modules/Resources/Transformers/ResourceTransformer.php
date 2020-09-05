<?php


namespace Modules\Resources\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Resources\Entities\Models\Resource;

class ResourceTransformer extends TransformerAbstract
{
    public function transform(Resource $item)
    {
        return [
            'id'                     => $item->id,
            'title'                  => $item->title,
            'bn_title'                  => $item->bn_title,
            'description'            => $item->description,
            'bn_description'            => $item->bn_description,
            'url'                    => $item->url,
        ];
    }
}
