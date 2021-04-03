<?php

use \Firebase\JWT\JWT;

/* middleware for regular users*/
Flight::route('/user/*', function(){
  if(str_starts_with(Flight::request()->url, "/users/")) return TRUE;

  try {
    $user = (array)JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, array('HS256'));
    Flight::set('user', $decoded);
    if(Flight::request()->method != "GET" && $user["r"] == "READ_ONLY_USER"){
      throw new Exception("Read only user are not allowed to change", 403);
    }
    return TRUE;
  } catch (\Exception $e) {
    Flight::json(["message" => $e->getMessage()], 401);
    die;
  }
});

/* middleware for admins */
Flight::route('/admin/*', function(){
  if(str_starts_with(Flight::request()->url, "/users/")) return TRUE;

  try {
    $user = (array)JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, array('HS256'));
    Flight::set('user', $decoded);
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
