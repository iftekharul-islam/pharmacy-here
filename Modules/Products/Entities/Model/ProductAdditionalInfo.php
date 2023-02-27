<?php

namespace Modules\Products\Entities\Model;

use Illuminate\Database\Eloquent\Model;

class ProductAdditionalInfo extends Model
{
    protected $fillable = [
        'precaution',
        'product_id', 
        'description',
        'administration', 
        'indication',
        'contra_indication',
        'side_effect',
        'mode_of_action',
        'interaction',
        'adult_dose',
        'child_dose',
        'renal_dose'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
