<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UserRestaurantcontroller extends ApiController
{
    public function __construct()
    {
       parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $Restaurants=$user->restaurants;
        return $this->showAll($Restaurants);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,User $user)
    {
        $rules =[
            'name'=>'required',
            'description' => 'required',
            'url_image'=>'required|image' 
        ];
        $this->validate($request,$rules);
        $data=$request->all();
        $data['url_image']=$request->url_image->store('');

        $product = Restaurant::create($data);
        return $this->showOne($product,201);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user,Restaurant $restaurant)
    {
       $rules =[
            'url_image'=>'image', 
        ];
        $this->validate($request,$rules);

        $this->verificarusuario($user,$restaurant);
        
        $restaurant->fill($request->intersect([
            'name',
            'description',
        ]));

        if($request->hasFile('url_image')){
            Storage::delete($request->url_image);
            $restaurant->url_image=$request->url_image->store('');
        }

        if($restaurant->isclean()){
            return $this->errorResponse('se debe especificar al menos un valor diferente para actualizar',411);
        }
        $restaurant->save();
        return $this->showOne($restaurant);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user,Restaurant $restaurant)
    {
        $this->verificarusuario($user,$restaurant);
        Storage::delete($restaurant->url_image);
        $restaurant->delete();
        return $this->showOne($restaurant);
    }

    protected function verificarusuario(User $user,Restaurant $restaurant){
         if($user->id != $restaurant->user_id){
            throw new HttpException(422,'El usuario no concuerda con el restaurante'); 
         }
    }
}
