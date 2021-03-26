<?php

/* Swagger documentation */
/**
 * @OA\Info(title="PepeJam Official API", version="0.1"),
 * @OA\OpenApi(
 *   @OA\Server(
 *       url="http://localhost:8080/api/",
 *       description="Devlopment environment"
 *   )
 * )
 */

 /**
  * @OA\Get(path="/song/{song_id}", tags={"song"},
  *     @OA\Parameter(type="integer", in="query", name="song_id", default=0, description="Id of the song"),
  *     @OA\Response(response="200", description="List song from database with a given id")
  * )
  */
Flight::route('GET /song/@id', function($id){
  Flight::json(Flight::songService()->get_by_id($id));
});

/**
 * @OA\Put(path="/{song_id}", tags={"song"},
 *     @OA\Parameter(type="integer", in="query", name="song_id", default=0, description="Id of the song"),
 *     @OA\Response(response="200", description="Update song with given id")
 * )
 */

Flight::route('PUT /song/@id', function($id){
  $song = Flight::songService()->update($id, Flight::request()->data->getData());
  Flight::json($song);
});


/**
 * @OA\Get(path="/songs", tags={"song"},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search for a song by its name. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-song_id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List songs from database")
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
 * @OA\Get(path="/songs/{artist_id}", tags={"song"},
 *     @OA\Parameter(type="integer", in="query", name="artist_id", default=0, description="Id of the artist"),
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="order", default="-song_id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List songs by an artist with a given id")
 * )
 */
Flight::route('GET /songs/@artist_id', function($artist_id){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $order = Flight::query("order");

  Flight::json(Flight::songService()->get_songs_by_artist($artist_id, $offset, $limit, $order));
});


/**
 * @OA\Post(path="/songs", tags={"song"},
 *     @OA\Response(response="200", description="Add a song")
 * )
 */
Flight::route('POST /songs', function(){
  $song = Flight::request()->data->getData();
  Flight::json(Flight::songService()->add($song));
});


?>
