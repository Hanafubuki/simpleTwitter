<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tweet;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
      $user = User::where('username', $request->input('username'));
      if(!$user){
        return get_error(404);
      }
      if (Hash::check($request->input('password'), $user->password)) {
        // The passwords match, do login
        Auth::login($user);
        return new UserResource($user);
      }
      return new get_error(401, 'Passwords doesn\'t match');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
      if($this->usernameAlreadyInUse){
        return get_error(400, 'Username already in use');
      }
      $user = new User;
      $user->name = $request->input('name');
      $user->email = $request->input('email');
      $user->username = $request->input('username');
      $user->password = Hash::make($request->input('password'));

      if($user->save()){
        // Do login
        Auth::login($user);
        return new UserResource($user);
      }
      return get_error();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOne($id)
    {
      $user = User::find($id);
      if(!$user){
        return get_error(404);
      }
      //return response()->json([$user->tweet]);
      return new UserResource($user);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
      $users = User::get();
      return UserResource::collection($users);
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
      $user = User::findOrFail($id);
      if(!$user){
        return get_error(404);
      }
      if($request->input('email')) $user->email = $request->input('email');
      if($request->input('username')) $user->username = $request->input('username');
      if($request->input('password')) $user->password = Hash::make($request->input('password'));

      if($user->save()){
        return new UserResource($user);
      }
      return get_error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::findOrFail($id);
      if(!$user){
        return get_error(404);
      }
      $user->delete();
    }
}
