<?php

Flight::register('user', 'UserDao');

Flight::route('GET /user/@id', function($id){
  Flight::json(Flight::user()->get_by_id($id, "user_id"));
});

Flight::route('PUT /user/@id', function($id){

  $request = Flight::request();
  $data = $request->data->getData();
  Flight::user()->update($id, $data, "user_id");

  $account = Flight::user()->get_by_id($id, "user_id");

  Flight::json($account);

});

Flight::route('POST /users', function(){
  $request = Flight::request();

  $data = $request->data->getData();


  $user = Flight::user()->add($data, "user_id");

  Flight::json($user);
});


Flight::route('GET /users', function(){
  Flight::json(Flight::user()->get_all($_GET["offset"] = 0, $_GET["limit"] = 25));
});

?>
