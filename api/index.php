<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/config.php";
require_once dirname(__FILE__)."/../vendor/autoload.php";
require_once dirname(__FILE__)."/services/UserService.class.php";
require_once dirname(__FILE__)."/services/ArtistService.class.php";
require_once dirname(__FILE__)."/services/SongService.class.php";
require_once dirname(__FILE__)."/services/AlbumService.class.php";
require_once dirname(__FILE__)."/services/PlaylistService.class.php";


Flight::set('flight.log_errors', true);


/* Error handling for API*/
/*
Flight::map('error', function(Exception $ex){
  Flight::json(["message" => $ex->getMessage()], $ex->getCode());
});*/

/* Register Bussiness Logic Layer services */
Flight::register('userService', 'UserService');
Flight::register('artistService', 'ArtistService');
Flight::register('songService', "SongService");
Flight::register('albumService', 'AlbumService');
Flight::register('playlistService', 'PlaylistService');


/* Utility function for reading parameters from the URL*/
Flight::map('query', function($name, $default_value = NULL){
  $request = Flight::request();
  $query_param = @$request->query->getData()[$name];
  $query_param = $query_param ? $query_param : $default_value;
  return $query_param;
});

/* utility function for getting header parameters */
Flight::map('header', function($name){
  $headers = getallheaders();
  return @$headers[$name];
});

/* Swagger documentation */

Flight::route('GET /swagger', function(){
  require_once dirname(__FILE__)."/../vendor/autoload.php";
  $openapi = @\OpenApi\scan(dirname(__FILE__)."/routes");
  header('Content-Type: application/json');
  echo $openapi->toJson();
});

Flight::route('GET /', function(){
  Flight::redirect("/docs");
});

/* Include all routes */
require_once dirname(__FILE__)."/routes/middleware.php";
require_once dirname(__FILE__)."/routes/users.php";
require_once dirname(__FILE__)."/routes/artists.php";
require_once dirname(__FILE__)."/routes/songs.php";
require_once dirname(__FILE__)."/routes/albums.php";
require_once dirname(__FILE__)."/routes/playlists.php";


Flight::start();


?>
