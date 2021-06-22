<?php

use \Firebase\JWT\JWT;

/**
 * @OA\Get(path="/user/playlists", tags={"users", "playlist"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="order", default="-playlist_id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="Fetch playlists by a logged in user")
 * )
 */
Flight::route('GET /user/playlists', function(){

  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $order = Flight::query("order");

  Flight::json(Flight::playlistService()->get_playlists_by_user_id(Flight::get('user')['id'], $offset, $limit, $order));
});


/**
 * @OA\Get(path="/user", tags={"users"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Response(response="200", description="List account from logged in user")
 * )
 */
Flight::route('GET /user', function(){
  Flight::json(Flight::userService()->get_by_id(Flight::get("user")["id"]));
});

/**
 * @OA\Get(path="/admin/user/{user_id}", tags={"admin"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="user_id", default=0, description="Id of the user"),
 *     @OA\Response(response="200", description="List user from database with a given id")
 * )
 */
Flight::route('GET /admin/user/@id', function($id){
  Flight::json(Flight::userService()->get_by_id($id));
});


/**
 * @OA\Put(path="/admin/user/{user_id}", tags={"admin"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="user_id", default=0, description="Id of the user that needs to be updated"),
 *     @OA\RequestBody(description="Data that needs to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="username", type="string", example="user1",	description="Username of the user"),
 *    				 @OA\Property(property="email", type="string", example="myemail@gmail.com",	description="User's email address"),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="User's password"),
 *             @OA\Property(property="status", type="string", example="ACTIVE",	description="The status of the account"),
 *             @OA\Property(property="token", type="string", example="1234a23dbn",	description="Token that is used in the registration process"),
 *             @OA\Property(property="created_at", type="timestamp", example="2045-03-20 15:34:59",	description="Date and time when the account was created"),
 *             @OA\Property(property="role", type="string", example="USER",	description="The role of the user")
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update user with given id")
 * )
 */
Flight::route('PUT /admin/user/@id', function($id){
  $user = Flight::userService()->update($id, Flight::request()->data->getData());
  Flight::json($user);
});


/**
 * @OA\Post(path="/admin/users", tags={"admin"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="username", type="string", example="user1",	description="Username of the user"),
 *    				 @OA\Property(property="email", type="string", example="myemail@gmail.com",	description="User's email address"),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="User's password"),
 *             @OA\Property(property="role", type="string", example="USER",	description="The role of the user"),
 *             @OA\Property(property="token", type="string", example="1234a23dbn",	description="Token that is used in the registration process")
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Added a user")
 * )
 */
Flight::route('POST /admin/users', function(){
  $user = Flight::request()->data->getData();
  $user["created_at"] = date("Y-m-d H:i:s");
  Flight::json(Flight::userService()->add($user));
});



/**
 * @OA\Post(path="/register", tags={"users"},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *             @OA\Property(property="username", required="true", type="string", example="user1",	description="Name of the user" ),
 *    				 @OA\Property(property="email", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been created.")
 * )
 */
Flight::route('POST /register', function(){
  $user = Flight::request()->data->getData();
  Flight::userService()->register($user);
  Flight::json(["message" => "Confirmation email has been sent, please check your email!"]);
});




/**
 * @OA\Get(path="/confirm/{token}", tags={"users"},
 *     @OA\Parameter(type="string", in="path", name="token", default=123, description="Temporary token for activating account"),
 *     @OA\Response(response="200", description="Message upon successfull activation.")
 * )
 */
Flight::route('GET /confirm/@token', function($token){
  Flight::json([Flight::jwt(Flight::userService()->confirm($token))]);
});


/**
 * @OA\Post(path="/login", tags={"users"},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="email", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been created.")
 * )
 */
Flight::route('POST /login', function(){
  Flight::json(Flight::jwt(Flight::userService()->login(Flight::request()->data->getData())));
});




/**
 * @OA\Post(path="/forgot", tags={"users"}, description = "Send recovery link to user's email address",
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="email", required="true", type="string", example="myemail@gmail.com",	description="User's email address" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that recovery link has been sent")
 * )
 */
Flight::route('POST /forgot', function(){
  $user = Flight::request()->data->getData();
  Flight::userService()->forgot($user);
  Flight::json(["message" => "Recovery token has been sent to your email."]);
});


/**
 * @OA\Post(path="/reset", tags={"users"}, description = "Reset the password",
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="token", required="true", type="string", example="123",	description="User's recovery token" ),
  *    				 @OA\Property(property="password", required="true", type="string", example="123",	description="User's new password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that password has been reset")
 * )
 */
Flight::route('POST /reset', function(){
  Flight::json(Flight::jwt(Flight::userService()->reset(Flight::request()->data->getData())));
});



/**
 * @OA\Get(path="/admin/users", tags={"admin"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search for a user by its username. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-user_id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List users from database")
 * )
 */
Flight::route('GET /admin/users', function(){
  $offset = Flight::query("offset", 0);
  $limit = Flight::query("limit", 25);
  $search = Flight::query("search");
  $order = Flight::query("order");
  $total = Flight::userService()->get_users($search, $offset, $limit, $order, TRUE);
  header("total-records: ".$total['total']);
  Flight::json(Flight::userService()->get_users($search, $offset, $limit, $order));
});

?>
