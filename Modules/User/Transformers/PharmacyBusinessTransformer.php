<?php


namespace Modules\User\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\User\Entities\Models\PharmacyBusiness;

class PharmacyBusinessTransformer extends TransformerAbstract
{
    public function transform(PharmacyBusiness $item)
    {
        return [
            'id'                        => $item->id,
            'pharmacy_name'             => $item->pharmacy_name,
            'pharmacy_address'          => $item->pharmacy_address,
            'bank_account'              => $item->bank_account,
            'bkash_number'              => $item->bkash_number,
            'nid_img_path'              => $item->nid_img_path,
            'trade_img_path'            => $item->trade_img_path,
            'drug_img_path'             => $item->drug_img_path,
            'start_time'                => $item->start_time,
            'end_time'                  => $item->end_time,
            'break_start_time'          => $item->break_start_time,
            'break_end_time'             => $item->break_end_time,
        ];
    }

}
