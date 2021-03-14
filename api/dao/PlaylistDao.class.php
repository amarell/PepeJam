<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class PlaylistDao extends BaseDao{

  public function __construct(){
    parent::__construct("playlists");
  }

  public function get_playlist_by_id($id){
    return $this->query_unique("SELECT * FROM playlists WHERE playlist_id = :playlist_id", ["playlist_id" => $id]);
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

  public function add_playlist($playlist){
    $this->insert("playlists", $playlist, "playlist_id");
    return $playlist;
  }

  public function update_playlist($id, $playlist){
    $this->update("playlists", $id, $playlist, "playlist_id");
  }
}
?>
