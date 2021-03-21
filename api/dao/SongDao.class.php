<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class SongDao extends BaseDao{
  public function __construct(){
    parent::__construct("songs", "song_id");
  }

  public function get_songs_by_artist($artist_id, $offset, $limit, $order){
    if(is_null($order)){
      $order = "-song_id";
    }

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT * FROM songs
                         WHERE artist_id = :artist_id
                         ORDER BY ${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",
                         ["artist_id" => $artist_id]);
  }
}
?>
