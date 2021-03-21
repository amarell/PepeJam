<?php
Flight::route('GET /artist/@id', function($id){
  Flight::json(Flight::artistService()->get_by_id($id));
});

Flight::route('PUT /artist/@id', function($id){
  $artist = Flight::artistService()->update($id, Flight::request()->data->getData());
  Flight::json($artist);
});

Flight::route('GET /artists', function(){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $search = Flight::query("search");
  $order = Flight::query("order");

  Flight::json(Flight::artistService()->get_artists($search, $offset, $limit, $order));

  //Flight::json(Flight::user()->get_all($_GET["offset"] = 0, $_GET["limit"] = 25));
});

Flight::route('POST /artists', function(){
  $artist = Flight::request()->data->getData();
  Flight::json(Flight::artistService()->add($artist));
});


?>
