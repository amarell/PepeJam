<?php

/**
 * @OA\Info(title="PepeJam Official API", version="0.1")
 */

/**
 * @OA\Get(
 *     path="/song/{song_id}",
 *     @OA\Response(response="200", description="Get a song with the given id")
 * )
 */
Flight::route('GET /song/@id', function($id){
  Flight::json(Flight::songService()->get_by_id($id));
});

/**
* @OA\Put(
*     path="/song/{song_id}",
*     @OA\Parameter(@OA\Schema(type="integer"), parameter="song_id", description="the id of the song", default=" "),
*     @OA\Response(response="200", description="Update a song with a given id")
* )
*/

Flight::route('PUT /song/@id', function($id){
  $song = Flight::songService()->update($id, Flight::request()->data->getData());
  Flight::json($song);
});


/**
 * @OA\Get(
 *     path="/songs",
 *     @OA\Response(response="200", description="List all songs from the database")
 * )
 */
Flight::route('GET /songs', function(){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $search = Flight::query("search");
  $order = Flight::query("order");

  Flight::json(Flight::songService()->get_songs($search, $offset, $limit, $order));
});


/**
* @OA\Get(
*     path="/song/{artist_id}",
*     @OA\Parameter(@OA\Schema(type="integer"), parameter="artist_id", description="the id of the artist", default=""),
*     @OA\Response(response="200", description="Update a song with a given id")
* )
*/
Flight::route('GET /songs/@artist_id', function($artist_id){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $order = Flight::query("order");

  Flight::json(Flight::songService()->get_songs_by_artist($artist_id, $offset, $limit, $order));
});


/**
* @OA\Post(
*     path="/song/{song_id}",
*     @OA\Response(response="200", description="Update a song with a given id")
* )
*/
Flight::route('POST /songs', function(){
  $song = Flight::request()->data->getData();
  Flight::json(Flight::songService()->add($song));
});


?>
