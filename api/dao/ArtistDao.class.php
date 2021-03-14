<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class ArtistDao extends BaseDao{

  public function get_artist_by_id($id){
    return $this->query_unique("SELECT * FROM artists WHERE artist_id = :artist_id", ["artist_id"=>$id]);
  }

  public function get_artist_by_name($name){
    return $this->query("SELECT * FROM artists WHERE artist_name = :artist_name ORDER BY number_of_followers DESC", ["artist_name"=>$name]);
  }

}
?>
