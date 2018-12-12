<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class meal extends Model
{
    protected $fillable = [
        'name', 'image', 'price'
    ];

    public function orders() {
        return $this->hasMany('App\order');
    }
}
