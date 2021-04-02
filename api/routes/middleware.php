<?php

use \Firebase\JWT\JWT;

/*
Flight::before('start', function(&$params, &$output){
  if(Flight::request()->url == "/swagger") return TRUE;
  if(str_starts_with(Flight::request()->url, "/users/")) return TRUE;

  $headers = getallheaders();
  $token = @$headers["Authentication"];

  try {
    $decoded = (array)JWT::decode($token, "JWT SECRET", array('HS256'));
    Flight::set('user', $decoded);
    return TRUE;
  } catch (\Exception $e) {
    Flight::json(["message" => $e->getMessage()], 401);
    die;
  }
});
*/


Flight::route('*', function(){
  if(str_starts_with(Flight::request()->url, "/users/")) return TRUE;

  $headers = getallheaders();
  $token = @$headers["Authentication"];

  try {
    $decoded = (array)JWT::decode($token, "JWT SECRET", array('HS256'));
    Flight::set('user', $decoded);
    return TRUE;
  } catch (\Exception $e) {
    Flight::json(["message" => $e->getMessage()], 401);
    die;
  }
});


?>
