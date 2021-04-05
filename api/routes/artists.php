<?php

/**
 * @OA\Get(path="/artist/{artist_id}", tags={"everyone"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="artist_id", default=0, description="Id of the artist"),
 *     @OA\Response(response="200", description="List songs from database")
 * )
 */
Flight::route('GET /artist/@id', function($id){
  Flight::json(Flight::artistService()->get_by_id($id));
});


/**
 * @OA\Put(path="/admin/artist/{artist_id}", tags={"admin", "artist"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="artist_id", default=0, description="Id of the artist that needs to be updated"),
 *     @OA\RequestBody(description="Data that needs to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="artist_name", type="string", example="artist1",	description="Name of the artist"),
 *    				 @OA\Property(property="number_of_followers", type="integer", example="1",	description="The number of followers that the artist has")
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update artist with given id")
 * )
 */
Flight::route('PUT /admin/artist/@id', function($id){
  $artist = Flight::artistService()->update($id, Flight::request()->data->getData());
  Flight::json($artist);
});


/**
 * @OA\Get(path="/artists", tags={"everyone"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search for an artist by its name. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-artist_id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List artists from database")
 * )
 */
Flight::route('GET /artists', function(){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $search = Flight::query("search");
  $order = Flight::query("order");

  Flight::json(Flight::artistService()->get_artists($search, $offset, $limit, $order));

});


/**
 * @OA\Post(path="/admin/artists", tags={"admin", "artist"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic artist info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="artist_name", required="true", type="string", example="The Weeknd",	description="Name of the artist"),
 *             @OA\Property(property="number_of_followers", type="integer", example="1000",	description="The number of followers")
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Add an artist")
 * )
 */
Flight::route('POST /admin/artists', function(){
  $artist = Flight::request()->data->getData();
  Flight::json(Flight::artistService()->add($artist));
});


?>
