<?php

namespace Modules\Products\Entities\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Form extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'status'];

    protected static function boot() {
        parent::boot();

        static::creating(function ($form) {
            $form->slug = Str::slug($form->name);
        });

        static::updating(function ($form) {
            $form->slug = Str::slug($form->name);
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
