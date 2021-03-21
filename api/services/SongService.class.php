<?php
require_once dirname(__FILE__)."/../dao/SongDao.class.php";
require_once dirname(__FILE__)."/../dao/ArtistDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

class SongService extends BaseService{

  public function __construct(){
    $this->dao = new SongDao();
  }

  public function get_songs($search, $offset, $limit, $order){
    if($search){
      return $this->dao->get_songs($search, $offset, $limit, $order);
    }
    else{
      return $this->dao->get_all($offset, $limit, $order);
    }
  }

  public function get_songs_by_artist($artist_id, $offset, $limit, $order){
    return $this->dao->get_songs_by_artist($artist_id, $offset, $limit, $order);
  }

}

?>
