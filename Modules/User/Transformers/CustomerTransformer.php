<?php


namespace Modules\User\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Address\Transformers\AddressTransformer;
use Modules\User\Entities\Models\User;

class CustomerTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'customerAddress'
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

    public function includeCustomerAddress(User $item)
    {
        return $this->collection($item->customerAddress, new AddressTransformer());
    }




}


