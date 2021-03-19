<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require dirname(__FILE__)."/../vendor/autoload.php";
require_once dirname(__FILE__)."/dao/BaseDao.class.php";
require_once dirname(__FILE__)."/dao/UserDao.class.php";

Flight::register('user', 'UserDao');


Flight::route('/', function(){
    echo 'hello world!';
});

Flight::route('/hell', function(){
  $user_dao = new UserDao();
  Flight::register('user', 'UserDao');

/*
  for($i = 0; $i<10; $i++){
    Flight::user()->add([
      "username" => base64_encode(random_bytes(4)),
      "password" => base64_encode(random_bytes(16)),
      "email" => base64_encode(random_bytes(10)),
      "token" => base64_encode(random_bytes(24)),
      "created_at" => date("Y-m-d H:i:s")
    ], "user_id");
  }
*/
    Flight::json(Flight::user()->get_all($_GET["offset"], $_GET["limit"]));
});

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
  //Flight::json(Flight::user()->get_all());
});



Flight::start();

?>
