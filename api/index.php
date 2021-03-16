<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require dirname(__FILE__)."/../vendor/autoload.php";
require_once dirname(__FILE__)."/dao/BaseDao.class.php";
require_once dirname(__FILE__)."/dao/UserDao.class.php";

Flight::route('/', function(){
    echo 'hello world!';
});

Flight::route('/hell', function(){
    echo 'hello world78912378923789!';
});

Flight::start();

?>
