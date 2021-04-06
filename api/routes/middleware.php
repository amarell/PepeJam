<?php

use \Firebase\JWT\JWT;

/* middleware for regular users*/
Flight::route('/user/*', function(){
  try {
    $user = (array)JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, array('HS256'));
    Flight::set('user', $user);
    if(Flight::request()->method != "GET" && $user["r"] == "READ_ONLY_USER"){
      throw new Exception("Read only user are not allowed to change anything.", 403);
    }
    
    return TRUE;
  } catch (\Exception $e) {
    throw $e;
    die;
    Flight::json(["message" => $e->getMessage()], 401);
    die;
  }
});

/* middleware for admins */
Flight::route('/admin/*', function(){
  try {
    $user = (array)JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, array('HS256'));
    Flight::set('user', $user);
    if($user["r"] != "ADMIN"){
      throw new Exception("Admin access required", 403);
    }
    
    return TRUE;
  } catch (\Exception $e) {
    Flight::json(["message" => $e->getMessage()], 401);
    die;
  }
});


?>
