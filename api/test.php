<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/dao/UserDao.class.php";
require_once dirname(__FILE__)."/dao/AccountDao.class.php";
require_once dirname(__FILE__)."/dao/ArtistDao.class.php";
require_once dirname(__FILE__)."/dao/AlbumDao.class.php";
require_once dirname(__FILE__)."/dao/AlbumDao.class.php";
require_once dirname(__FILE__)."/dao/PlaylistDao.class.php";
require_once dirname(__FILE__)."/dao/SongDao.class.php";


$dao = new SongDao();

$songs = $dao->get_songs_by_artist(2);

print_r($songs);
?>
