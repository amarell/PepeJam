<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class PlaylistDao extends BaseDao{

  public function __construct(){
    parent::__construct("playlists");
  }

  public function get_playlists_by_user($username){
    return $this->query("SELECT P.playlist_id, P.name, U.username user FROM playlists P
                         JOIN users U ON P.user_id = U.user_id
                         WHERE U.username = :username",
                         ["username" => $username]);
  }

  public function get_playlists_by_user_id($user_id){
    return $this->query("SELECT * FROM playlists WHERE user_id = :user_id", ["user_id" => $user_id]);
  }

  /*
  * get_by_id, add, update and get_all functionality is covered by BaseDao
  */
}
?>
