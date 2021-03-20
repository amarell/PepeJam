<?php

Flight::route('GET /user/@id', function($id){
  Flight::json(Flight::user()->get_by_id($id));
});

Flight::route('PUT /user/@id', function($id){
  $user = Flight::userService()->update($id, Flight::request()->data->getData());
  Flight::json($user);
});

Flight::route('POST /users', function(){
  $user = Flight::request()->data->getData();
  $user["created_at"] = date("Y-m-d H:i:s");
  Flight::json(Flight::userService()->add($user));
});


Flight::route('GET /users', function(){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 10);
  $search = Flight::query("search");
  Flight::json(Flight::userService()->get_users($search, $offset, $limit));

  //Flight::json(Flight::user()->get_all($_GET["offset"] = 0, $_GET["limit"] = 25));
});

?>
