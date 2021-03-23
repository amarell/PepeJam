<?php

Flight::route('GET /playlist/@id', function($id){
  Flight::json(Flight::playlistService()->get_by_id($id));
});

Flight::route('PUT /playlist/@id', function($id){
  $user = Flight::playlistService()->update($id, Flight::request()->data->getData());
  Flight::json($user);
});

Flight::route('POST /playlists', function(){
  $user = Flight::request()->data->getData();
  Flight::json(Flight::playlistService()->add($user));
});

Flight::route('GET /playlists', function(){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $search = Flight::query("search");
  $order = Flight::query("order");

  Flight::json(Flight::playlistService()->get_playlists($search, $offset, $limit, $order));
});

Flight::route('GET /playlists_by_user_id/@user_id', function($user_id){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $order = Flight::query("order");

  Flight::json(Flight::playlistService()->get_playlists_by_user_id($user_id, $offset, $limit, $order));
});

//TODO: private and public playlists

Flight::route('GET /playlists_by_username/@username', function($username){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $order = Flight::query("order");

  Flight::json(Flight::playlistService()->get_playlists_by_username($username, $offset, $limit, $order));
});



?>
