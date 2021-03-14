<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class ArtistDao extends BaseDao{
  /*
  * Finds the artist that matches the specified id
  */
  public function get_artist_by_id($id){
    return $this->query_unique("SELECT * FROM artists WHERE artist_id = :artist_id", ["artist_id"=>$id]);
  }

  /*
  * Finds all artsts that match the specified name and sorts them by the number of followers
  */
  public function get_artist_by_name($name){
    return $this->query("SELECT * FROM artists WHERE artist_name = :artist_name ORDER BY number_of_followers DESC", ["artist_name"=>$name]);
  }

  public function add_artist($artist){
    $this->insert("artists", $artist, "artist_id");
    return $artist;
  }

  public function update_artist($id, $artist){
    $this->update("artists", $id, $artist, "artist_id");
  }

}
?>
