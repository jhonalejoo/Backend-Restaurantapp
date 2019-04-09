<?php

namespace App\Http\Controllers\Restaurant;

use App\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;


class Restaurantcontroller extends ApiController
{
    public function __construct()
    {
     //   $this->middleware('client.credentials')->only(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Restaurants= Restaurant::all();
        return $this->showAll($Restaurants);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
        return $this->showOne($restaurant);
    }
}
