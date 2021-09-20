<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public $timestamps = false;
    protected $fillable = [
		'user_id', 'name' , 'description', 'image', 'price', 'rating'
	];
	public function user(){
		return $this->belongsTo('App\User');
}
}