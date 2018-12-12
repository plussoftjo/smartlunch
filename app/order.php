<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{

	public $with = ['user','meal'];
    protected $fillable = [
        'user_id', 'meal_id', 'time','day'
    ];

    public function user() {
    	return $this->belongsTo('App\User');
    }
    public function meal() {
    	return $this->belongsTo('App\meal');
    }
}
