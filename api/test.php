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

$user_dao = new UserDao();

$user = [
  "username" => "amokney",
  "password" => "666"
];

$user_dao->update(1, $user, "user_id");





print_r($user_dao->get_by_id(1, "user_id"));
?>
