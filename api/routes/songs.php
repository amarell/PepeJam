<?php
Flight::route('GET /song/@id', function($id){
  Flight::json(Flight::songService()->get_by_id($id));
});

Flight::route('PUT /song/@id', function($id){
  $song = Flight::songService()->update($id, Flight::request()->data->getData());
  Flight::json($song);
});

Flight::route('GET /songs', function(){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $search = Flight::query("search");
  $order = Flight::query("order");

  Flight::json(Flight::songService()->get_songs($search, $offset, $limit, $order));
});

Flight::route('GET /songs/@artist_id', function($artist_id){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $order = Flight::query("order");

  Flight::json(Flight::songService()->get_songs_by_artist($artist_id, $offset, $limit, $order));
});

Flight::route('POST /songs', function(){
  $song = Flight::request()->data->getData();
  Flight::json(Flight::songService()->add($song));
});


?>
