<?php

namespace Modules\Products\Entities\Model;

use Illuminate\Database\Eloquent\Model;

class ProductAdditionalInfo extends Model
{
    protected $fillable = ['product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
