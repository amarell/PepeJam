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

  public function get_songs($search, $offset, $limit, $order, $total = FALSE){
    if(is_null($order)){
      $order = "-song_id";
    }

    list($order_column, $order_direction) = self::parse_order($order);
    if($total){
      return $this->query_unique("SELECT COUNT(*) AS total FROM songs
                           WHERE LOWER(song_name) LIKE LOWER('%".$search."%')",
                           []);
    } else {
      return $this->query("SELECT S.song_id, S.song_name, S.song_duration,
                           S.number_of_plays, A.artist_name
                           FROM songs S
                           JOIN artists A ON S.artist_id = A.artist_id
                           WHERE LOWER(song_name) LIKE LOWER('%".$search."%')
                           ORDER BY ${order_column} ${order_direction}
                           LIMIT ${limit} OFFSET ${offset}",
                           []);
    }
  }
}
?>
