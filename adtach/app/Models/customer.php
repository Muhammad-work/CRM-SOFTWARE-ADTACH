<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_number',
        'customer_email',
        'price',
        'remarks',
        'status',
        'a_name',
    ];

    public  $timestamps = true; 

    public function user(){
       return $this->belongsTo(user::class,'a_name');
    }
}
