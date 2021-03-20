<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class SongDao extends BaseDao{
  public function __construct(){
    parent::__construct("songs", "song_id");
  }

  public function get_songs_by_artist($artist_id){
    return $this->query("SELECT * FROM songs WHERE artist_id = :artist_id", ["artist_id" => $artist_id]);
  }
}
?>
