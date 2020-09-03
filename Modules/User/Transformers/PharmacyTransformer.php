<?php


namespace Modules\User\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\User\Entities\Models\User;

class PharmacyTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'pharmacyBusiness', 'weekends'
    ];

    public function transform(User $item)
    {
        return [
            'id'                            => $item->id,
            'name'                          => $item->name,
            'phone_number'                  => $item->phone_number,
            'email'                         => $item->email,
            'image'                         => $item->image,
            'alternative_phone_number'      => $item->alternative_phone_number,
            'dob'                           => $item->dob,
            'gender'                        => $item->gender,
        ];
    }

    public function includePharmacyBusiness(User $item)
    {
        if ($item->pharmacyBusiness != null) {
            return $this->item($item->pharmacyBusiness, new PharmacyBusinessTransformer());
        }
    }

    public function includeWeekends(User $item)
    {
        if($item->weekends != null) {
            return $this->collection($item->weekends, new WeekendsTransformer());
        }
    }



}


