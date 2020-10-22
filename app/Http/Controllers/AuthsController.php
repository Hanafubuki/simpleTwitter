<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthsController extends Controller
{

    /**
     * User login's function
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
      //Check if all the login information is entered
      $validator = $this->loginValidator($request->all());
      if($validator->fails()){
          return response(get_error(400, $validator->errors()->all()), 400);
      }

      //Check if username exists
      $user = User::where('username', $request->input('username'))->first();
      if(!$user){
        return response(get_error(404), 404);
      }

      //Check if passwords match
      if (Hash::check($request->input('password'), $user->password)) {
        //Generate login token
        $token = $user->createToken('Access granted')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
      }
      return get_error(401, 'Passwords doesn\'t match');
    }



    /**
     * Store a newly created user in storage.
     * Hash password before inserting
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
      //Check if all the user information is entered correct
      $validator = $this->regValidator($request->all());
      if($validator->fails()){
          return response(get_error(400, $validator->errors()->all()), 400);
      }

      //Add to the Models
      $request['password']=Hash::make($request['password']);
      $request['remember_token'] = Str::random(10);
      $user = User::create($request->toArray());
      $token = $user->createToken('Laravel Password Grant Client')->accessToken;
      $response = ['token' => $token];
      return response($response, 200);

    }


    /**
     * User logout.
     * Remove token from database
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
      $token = $request->user()->token()->revoke();
      $response = ['message' => 'You have been successfully logged out!'];
      return response($response, 200);
    }




      /**
       * Get a validator for an incoming registration request.
       * Username and email must be unique, no other users can be registered with them.
       * Password must be at least with length 8, with a special character and match the password_confirmation input.
       * @param  array  $data
       * @return \Illuminate\Contracts\Validation\Validator
       */
      protected function regValidator(array $data)
      {
          return Validator::make($data, [
              'name' => ['required', 'string', 'max:255'],
              'username' => ['required', 'string', 'max:255', 'unique:users'],
              'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
              'password' => ['required', 'min:8','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[@&!$#%]).*$/', 'confirmed'],
          ]);
      }


      /**
       * Get a validator for an incoming login request.
       * @param  array  $data
       * @return \Illuminate\Contracts\Validation\Validator
       */
      protected function loginValidator(array $data){
         return Validator::make($data, [
           'username' => 'required|string|max:255',
           'password' => 'required|string',
       ]);
      }
}
