<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
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
     * @return \App\Http\Resources\User
     */
    public function getOne(User $user)
    {
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
     * @return \App\Http\Resources\User
     */
    public function update(UpdateUserRequest $request, int $id)
    {
      $user = User::findOrFail(auth('api')->user()->id);

      $notCorrectUser = $this->checkCorrectUser($user, $id);
      if($notCorrectUser) return $notCorrectUser;

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
    public function destroy(int $id)
    {
      $user = User::findOrFail(auth('api')->user()->id);

      $notCorrectUser = $this->checkCorrectUser($user, $id);
      if($notCorrectUser) return $notCorrectUser;

      //Delete tweets from user
      $user->tweet()->where('author_id', $id)->delete();

      //Delete login token from database
      auth('api')->user()->token()->revoke();
      $user->delete();

      return 204;
    }


    /**
     * Check if user with authorization code exists and if is trying to modify their own data
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function checkCorrectUser(User $user, int $id){
      //Check if user exists/Authorization token is correct
      if(!$user){
        return response(get_error(404),404);
      }

      //Check if user updating is the same user logged in
      if(!isCorrectUserApi($id)){
        return response(get_error(401),401);
      }

      return false;

    }

}
