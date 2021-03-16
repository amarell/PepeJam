<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class ArtistDao extends BaseDao{

  public function __construct(){
    parent::__construct("artists");
  }

  public function get_artist_by_name($name){
    return $this->query("SELECT * FROM artists WHERE artist_name = :artist_name ORDER BY number_of_followers DESC", ["artist_name"=>$name]);
  }


  /*
  * get_by_id, add, update and get_all functionality is covered by BaseDao
  */
}
?>
