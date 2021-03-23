<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class AlbumDao extends BaseDao{

  public function __construct(){
    parent::__construct("albums", "album_id");
  }

  public function get_album_by_name($name){
    return $this->query("SELECT * FROM albums WHERE album_name = :album_name", ["album_name" => $name]);
  }

  public function get_albums($search, $offset, $limit, $order){
    if(is_null($order)){
      $order = "-album_id";
    }

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT * FROM albums
                         WHERE LOWER(album_name) LIKE LOWER('%".$search."%')
                         ORDER BY ${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",
                         []);

  }

  public function get_album_by_artist($artist_id, $offset, $limit, $order){
    if(is_null($order)){
      $order = "-album_id";
    }

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT * FROM albums
                         WHERE artist_id = :artist_id
                         ORDER BY ${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",
                         ["artist_id" => $artist_id]);
  }
  /*
  * get_by_id, add, update and get_all functionality is covered by BaseDao
  */

}
?>
