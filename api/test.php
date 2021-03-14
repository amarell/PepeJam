<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/dao/UserDao.class.php";
require_once dirname(__FILE__)."/dao/AccountDao.class.php";
require_once dirname(__FILE__)."/dao/ArtistDao.class.php";
require_once dirname(__FILE__)."/dao/AlbumDao.class.php";

$album_dao = new AlbumDao();

$album = [
  "album_name" => "Master of PHP",
  "album_artist" => 2
];

$album_dao->add_album($album);

?>
