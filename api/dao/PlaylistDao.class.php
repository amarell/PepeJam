<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class PlaylistDao extends BaseDao{

  public function __construct(){
    parent::__construct("playlists", "playlist_id");
  }

  public function get_playlists_by_username($username, $offset, $limit, $order){
    if(is_null($order)){
      $order = "-playlist_id";
    }

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT P.playlist_id, P.name, U.username user FROM playlists P
                         JOIN users U ON P.user_id = U.user_id
                         WHERE U.username = :username",
                         ["username" => $username]);
  }

  public function get_playlists_by_user_id($user_id, $offset, $limit, $order, $total = FALSE){
    if(is_null($order)){
      $order = "-playlist_id";
    }

    list($order_column, $order_direction) = self::parse_order($order);

    if($total){
      return $this->query_unique("SELECT COUNT(*) AS total FROM playlists
                                  WHERE user_id = :user_id",
                                  ["user_id" => $user_id]);
    } else {
      return $this->query("SELECT * FROM playlists
                           WHERE user_id = :user_id
                           ORDER BY ${order_column} ${order_direction}
                           LIMIT ${limit} OFFSET ${offset}",
                           ["user_id" => $user_id]);
    }
  }


  public function get_playlists($search, $offset, $limit, $order, $total = FALSE){
    if(is_null($order)){
      $order = "-playlist_id";
    }

    list($order_column, $order_direction) = self::parse_order($order);
    if($total){
      return $this->query_unique("SELECT COUNT(*) AS total FROM playlists
                           WHERE LOWER(name) LIKE LOWER('%".$search."%')",
                           []);
    } else {
      return $this->query("SELECT * FROM playlists
                           WHERE LOWER(name) LIKE LOWER('%".$search."%')
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
