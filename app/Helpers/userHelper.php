<?php
function isCorrectUserApi($user_id){
  return $user_id == auth('api')->user()->id;
}
