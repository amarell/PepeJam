<?php

use \Firebase\JWT\JWT;

/**
 * @OA\Get(path="/admin/playlist/{playlist_id}", tags={"admin", "playlist"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="playlist_id", default=1, description="Id of the playlist"),
 *     @OA\Response(response="200", description="List playlist from database with a given id")
 * )
 */
Flight::route('GET /admin/playlist/@id', function($id){
  Flight::json(Flight::playlistService()->get_by_id($id));
});


/**
 * @OA\Get(path="/playlist/{playlist_id}", tags={"user", "playlist"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="playlist_id", default=1, description="Id of the playlist"),
 *     @OA\Response(response="200", description="List playlist from database with a given id if it belongs to the logged in user")
 * )
 */
Flight::route('GET /playlist/@id', function($id){
  $playlist = Flight::playlistService()->get_by_id($id);
  $user = (array)JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, array('HS256'));

  if($playlist["user_id"] != $user["id"]){
    Flight::json(["message" => "This playlist is not yours"], 403);
    die;
  }
  Flight::json(Flight::playlistService()->get_by_id($id));
});


/**
 * @OA\Put(path="/admin/playlist/{playlist_id}", tags={"admin", "playlist"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="playlist_id", default=1, description="Id of the playlist that needs to be updated"),
 *     @OA\RequestBody(description="Data that needs to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", type="string", example="playlist1",	description="Name of the playlist"),
 *    				 @OA\Property(property="user_id", type="integer", example="17",	description="Playlist owner id")
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update playlist with given id")
 * )
 */
Flight::route('PUT /admin/playlist/@id', function($id){
  $user = Flight::playlistService()->update($id, Flight::request()->data->getData());
  Flight::json($user);
});


/**
 * @OA\Put(path="/user/playlist/{playlist_id}", tags={"user", "playlist"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="playlist_id", default=1, description="Id of the playlist that needs to be updated"),
 *     @OA\RequestBody(description="Data that needs to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", type="string", example="playlist1",	description="Name of the playlist")
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update own playlist with given id")
 * )
 */
Flight::route('PUT /user/playlist/@id', function($id){
  $playlist = Flight::playlistService()->get_by_id($id);

  if($playlist["user_id"] != Flight::get("user")["id"]){
    Flight::json(["message" => "This playlist is not yours"], 403);
    die;
  }

  $user = Flight::playlistService()->update($id, Flight::request()->data->getData());
  Flight::json($user);
});


/**
 * @OA\Post(path="/admin/playlists", tags={"admin", "playlist"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic playlist info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", type="string", example="playlist1",	description="Name of the playlist"),
 *    				 @OA\Property(property="user_id", type="integer", example="17",	description="Playlist owner id")
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Added a playlist")
 * )
 */
Flight::route('POST /admin/playlists', function(){
  $playlist = Flight::request()->data->getData();
  Flight::json(Flight::playlistService()->add($playlist));
});

/**
 * @OA\Post(path="/user/playlists", tags={"user", "playlist"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic playlist info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", type="string", example="playlist1",	description="Name of the playlist")
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Added a playlist")
 * )
 */
Flight::route('POST /user/playlists', function(){
  $playlist = Flight::request()->data->getData();
  $playlist["user_id"] = Flight::get("user")["id"];
  Flight::json(Flight::playlistService()->add($playlist));
});

/**
 * @OA\Get(path="/admin/playlists", tags={"admin"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search for a playlist by its name. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-playlist_id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List playlists from database")
 * )
 */
Flight::route('GET /admin/playlists', function(){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $search = Flight::query("search");
  $order = Flight::query("order");

  Flight::json(Flight::playlistService()->get_playlists($search, $offset, $limit, $order));
});



/**
 * @OA\Get(path="/admin/playlists_by_user_id/{user_id}", tags={"admin", "playlist"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="user_id", default=1, description="Id of the user"),
 *     @OA\Response(response="200", description="List all playlists that were created by a user with the given id")
 * )
 */
Flight::route('GET /admin/playlists_by_user_id/@user_id', function($user_id){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $order = Flight::query("order");

  Flight::json(Flight::playlistService()->get_playlists_by_user_id($user_id, $offset, $limit, $order));
});

//TODO: private and public playlists


/**
 * @OA\Get(path="/admin/playlists_by_username/{username}", tags={"admin", "playlist"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="string", in="path", name="username", default=1, description="Username of the user"),
 *     @OA\Response(response="200", description="List all playlists that were created by a user with the given username")
 * )
 */
Flight::route('GET /admin/playlists_by_username/@username', function($username){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $order = Flight::query("order");


  Flight::json(Flight::playlistService()->get_playlists_by_username($username, $offset, $limit, $order));
});



?>
