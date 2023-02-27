<?php


namespace Modules\Notice\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Notice\Entities\Models\Notice;

class NoticeTransformer extends TransformerAbstract
{
    public function transform(Notice $item)
    {
        return [
            'id'                        => $item->id,
            'notice'                    => $item->notice,
            'bn_notice'                 => $item->bn_notice,
            "status"                    => $item->status,
            "type"                      => $item->type,
        ];
    }
}
