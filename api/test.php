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

$playlist_dao = new PlaylistDao();


$playlist = $playlist_dao->get_playlists_by_user_id(17);

print_r($playlist);
?>
