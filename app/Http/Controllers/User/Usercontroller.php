<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class Usercontroller extends ApiController
{
    public function __construct()
    {
       // $this->middleware('client.credentials')->only(['store']);
        $this->middleware('auth:api')->except(['store']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios=User::all();
        return $this->showAll($usuarios);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=[
            'name' => 'required',
            'email'=>  'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ];

        $this->validate($request,$rules);

        $campos=$request->all();
        $campos['password']=bcrypt($request->password);
        $usuario= User::create($campos);
        return $this->showOne($usuario,201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $usuario= User::findOrFail($id); 
       return $this->showOne($usuario);

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $usuario= User::findOrFail($id);
        $rules=[
            'email'=>  'email|unique:users,email,'. $usuario->id,
            'password'=>'min:6|confirmed'
        ];
        $this->validate($request,$rules);

        if($request->has('name')){
          $usuario->name =$request->name;
        }
        if($request->has('email') && $usuario->email != $request->email){
          $usuario->email =$request->email;
        }
        if($request->has('password')){
          $usuario->password =bcrypt($request->password);
        }
        if(!$usuario->isDirty()){
        return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',422); 
        }
        $usuario->save();
        return $this->showOne($usuario);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario= User::findOrFail($id);
        $usuario->delete();
        return $this->showOne($usuario);
    }
}
