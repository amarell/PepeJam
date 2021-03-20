<?php

Flight::route('GET /user/@id', function($id){
  Flight::json(Flight::user()->get_by_id($id, "user_id"));
});

Flight::route('PUT /user/@id', function($id){
  Flight::user()->update($id, Flight::request()->data->getData(), "user_id");
  $account = Flight::user()->get_by_id($id, "user_id");
  Flight::json($account);

});

Flight::route('POST /users', function(){
  $user = Flight::user()->add(Flight::request()->data->getData(), "user_id");
  Flight::json($user);
});


Flight::route('GET /users', function(){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 10);

  Flight::json(Flight::user()->get_all($offset, $limit));
  //Flight::json(Flight::user()->get_all($_GET["offset"] = 0, $_GET["limit"] = 25));
});

?>
