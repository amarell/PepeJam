<?php

Flight::route('GET /album/@id', function($id){
  Flight::json(Flight::albumService()->get_by_id($id));
});

Flight::route('PUT /album/@id', function($id){
  $album = Flight::albumService()->update($id, Flight::request()->data->getData());
  Flight::json($album);
});

Flight::route('POST /albums', function(){
  $album = Flight::request()->data->getData();
  Flight::json(Flight::albumService()->add($album));
});

Flight::route('GET /albums', function(){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $search = Flight::query("search");
  $order = Flight::query("order");

  Flight::json(Flight::albumService()->get_albums($search, $offset, $limit, $order));
});

?>
