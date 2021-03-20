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

  $user = Flight::request()->data->getData();
  $user["created_at"] = date("Y-m-d H:i:s");

  $user = Flight::user()->add($user, "user_id");
  Flight::json($user);
});


Flight::route('GET /users', function(){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 10);

  $search = Flight::query("search");

  if($search){
    print_r(Flight::user()->get_users($search, $offset, $limit));
  }
  else{
    print_r(Flight::user()->get_all($offset, $limit));
  }

  //Flight::json(Flight::user()->get_all($_GET["offset"] = 0, $_GET["limit"] = 25));
});

?>
