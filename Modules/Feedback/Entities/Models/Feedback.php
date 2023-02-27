<?php

namespace Modules\Feedback\Entities\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $fillable = ['customer_id', 'pharmacy_id', 'rating', 'comment', 'status'];
}
