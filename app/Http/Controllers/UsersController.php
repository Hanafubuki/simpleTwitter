<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    /**
     * Get information from user
     *
     * @return \Illuminate\Http\Response
     */
    public function getOne($id)
    {
      $user = User::find($id);
      if(!$user){
        return response(get_error(404),404);
      }
      return new UserResource($user);
    }


    /**
     * Update user name and password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $user = User::findOrFail(auth('api')->user()->id);

      //Check if user exists/Authorization token is correct
      if(!$user){
        return response(get_error(404),404);
      }

      //Check if user updating is the same user logged in
      if(!isCorrectUserApi($id)){
        return response(get_error(401),401);
      }

      //Check if all the user information is entered correct
      $validator = $this->updateValidator($request->all());
      if($validator->fails() OR (!Hash::check($request['current_password'], $user->password))){
          return response(get_error(400, $validator->errors()->all()),400);
      }

      $user->name = $request['name'];
      $user->password = Hash::make($request['password']);
      $user->save();

      return new UserResource($user);
    }

    /**
     * Remove user and tweets related to him.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::findOrFail(auth('api')->user()->id);

      //Check if user exists
      if(!$user){
        return response(get_error(404),404);
      }

      //Check if user deleting is the same user logged in
      if(!isCorrectUserApi($id)){
        return response(get_error(401),401);
      }

      //Delete tweets from user
      $user->tweet()->where('author_id', $id)->delete();

      //Delete login token from database
      $token = auth('api')->user()->token()->revoke();
      $user->delete();

      return 204;
    }




    /**
     * Get a validator for an incoming update request.
     * Must insert old\current password.
     * Password must be at least with length 8, with a special character and match the password_confirmation input.
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function updateValidator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'current_password' => ['required'],
            'password' => ['required', 'min:8','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[@&!$#%]).*$/', 'confirmed'],
        ]);
    }

}
