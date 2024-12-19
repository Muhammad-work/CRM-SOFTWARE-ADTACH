<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customerResponse extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_number',
        'remarks',
        'date',
        'agent',
    ];

    public function user(){
        return $this->belongsTo(user::class,'agent');
     }
}
