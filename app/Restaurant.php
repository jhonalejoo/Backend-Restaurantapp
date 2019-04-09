<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
    	'name',
    	'description',
    	'url_image',
    	'user_id', 
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
