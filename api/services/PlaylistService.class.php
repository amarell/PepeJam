<?php
require_once dirname(__FILE__)."/../dao/PlaylistDao.class.php";
require_once dirname(__FILE__)."/../dao/UserDao.class.php";
require_once dirname(__FILE__)."/../dao/SongDao.class.php";
require_once dirname(__FILE__)."/../dao/ArtistDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

class PlaylistService extends BaseService{

  public function __construct(){
    $this->dao = new PlaylistDao();
  }

  public function get_playlists($search, $offset, $limit, $order, $total = FALSE){
    return $this->dao->get_playlists($search, $offset, $limit, $order, $total);
    /*if($search){
      return $this->dao->get_playlists($search, $offset, $limit, $order);
    }
    else{
      return $this->dao->get_all($offset, $limit, $order);
    }*/
  }

  public function get_playlists_by_user_id($user_id, $offset, $limit, $order, $total = FALSE){
    return $this->dao->get_playlists_by_user_id($user_id, $offset, $limit, $order, $total);
  }

  public function get_playlists_by_username($username, $offset, $limit, $order){
    return $this->dao->get_playlists_by_username($username, $offset, $limit, $order);
  }

  public function get_albums_by_artist($artist_id, $offset, $limit, $order){
    return $this->dao->get_albums_by_artist($artist_id, $offset, $limit, $order);
  }




}

?>
