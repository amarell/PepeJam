<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/dao/UserDao.class.php";
require_once dirname(__FILE__)."/dao/AccountDao.class.php";
require_once dirname(__FILE__)."/dao/ArtistDao.class.php";

$artist_dao = new ArtistDao();

$artist = $artist_dao->get_artist_by_name("aMAR");


print_r($artist);

?>
