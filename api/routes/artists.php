<?php

Flight::route('POST /artist', function(){
  $user = Flight::request()->data->getData();
  $user["created_at"] = date("Y-m-d H:i:s");
  Flight::json(Flight::userService()->add($user));
});

?>
