<?php

/**
 * @OA\Get(path="/user/album/{album_id}", tags={"users"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="album_id", default=0, description="Id of the album"),
 *     @OA\Response(response="200", description="List album from database")
 * )
 */
Flight::route('GET /user/album/@id', function($id){
  Flight::json(Flight::albumService()->get_by_id($id));
});



/**
 * @OA\Put(path="/admin/album/{album_id}", tags={"admin", "album"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="album_id", default=0, description="Id of the album that needs to be updated"),
 *     @OA\RequestBody(description="Data that needs to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="album_name", type="string", example="Curtains",	description="Name of the album"),
 *    				 @OA\Property(property="artist_id", type="integer", example="1",	description="The id of the artist of the album")
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update album with given id")
 * )
 */
Flight::route('PUT /admin/album/@id', function($id){
  $album = Flight::albumService()->update($id, Flight::request()->data->getData());
  Flight::json($album);
});



/**
 * @OA\Post(path="/admin/albums", tags={"admin", "album"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic album info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="album_name", required="true", type="string", example="Curtains",	description="Name of the album"),
 *             @OA\Property(property="artist_id", type="integer", example="1",	description="The id of the artist of the album")
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Add an artist")
 * )
 */
Flight::route('POST /admin/albums', function(){
  $album = Flight::request()->data->getData();
  Flight::json(Flight::albumService()->add($album));
});


/**
 * @OA\Get(path="/user/albums", tags={"users"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search for an album by its name. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-album_id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List albums from database")
 * )
 */
Flight::route('GET /user/albums', function(){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $search = Flight::query("search");
  $order = Flight::query("order");

  Flight::json(Flight::albumService()->get_albums($search, $offset, $limit, $order));
});

?>
