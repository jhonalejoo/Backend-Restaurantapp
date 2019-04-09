<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
    ];
    //Cinvertir valores del nombre en minuscula al insertar BD 
    public function setNameAttribute($valor){
        $this->attributes['name']=strtolower($valor);
    }
    //Convertir primera letra del nombre al obtener
    public function getNameAttribute($valor){
        return ucwords($valor);
    }
    //Cinvertir valores del nombre en minuscula al insertar BD 
    public function setEmailAttribute($valor){
        $this->attributes['email']=strtolower($valor);
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
    ];
    
  public function restaurants(){
    return $this->hasMany(Restaurant::class);
  }
}
