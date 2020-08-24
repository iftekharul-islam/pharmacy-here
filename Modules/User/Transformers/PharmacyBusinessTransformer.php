<?php


namespace Modules\User\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\User\Entities\Models\PharmacyBusiness;

class PharmacyBusinessTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'weekends'
    ];
    public function transform(PharmacyBusiness $item)
    {
        return [
            'id'                        => $item->id,
            'pharmacy_name'             => $item->pharmacy_name,
            'pharmacy_address'          => $item->pharmacy_address,
            'bank_account_name'         => $item->bank_account_name,
            'bank_account_number'       => $item->bank_account_number,
            'bank_name'                 => $item->bank_name,
            'bank_brunch_name'          => $item->bank_brunch_name,
            'bkash_number'              => $item->bkash_number,
            'nid_img_path'              => $item->nid_img_path,
            'trade_img_path'            => $item->trade_img_path,
            'drug_img_path'             => $item->drug_img_path,
            'start_time'                => $item->start_time,
            'end_time'                  => $item->end_time,
            'break_start_time'          => $item->break_start_time,
            'break_end_time'            => $item->break_end_time,
            'bank_routing_number'       => $item->bank_routing_number
        ];
    }

    public function includeWeekends(PharmacyBusiness $item)
    {
        return $this->collection($item->weekends, new WeekendsTransformer());
    }

}
