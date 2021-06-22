<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class ArtistDao extends BaseDao{

  public function __construct(){
    parent::__construct("artists", "artist_id");
  }

  public function get_artist_by_name($name){
    return $this->query("SELECT * FROM artists WHERE artist_name = :artist_name ORDER BY number_of_followers DESC", ["artist_name"=>$name]);
  }

  public function get_artists($search, $offset, $limit, $order, $total = FALSE){
    if(is_null($order)){
      $order = "-artist_id";
    }

    list($order_column, $order_direction) = self::parse_order($order);

    if($total){
      return $this->query_unique("SELECT COUNT(*) AS total FROM artists
                           WHERE LOWER(artist_name) LIKE LOWER('%".$search."%')",
                           []);
    } else {
      return $this->query("SELECT * FROM artists
                           WHERE LOWER(artist_name) LIKE LOWER('%".$search."%')
                           ORDER BY ${order_column} ${order_direction}
                           LIMIT ${limit} OFFSET ${offset}",
                           []);
    }

  }


  /*
  * get_by_id, add, update and get_all functionality is covered by BaseDao
  */
}
?>
