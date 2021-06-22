<?php
require_once dirname(__FILE__)."/../dao/AlbumDao.class.php";
require_once dirname(__FILE__)."/../dao/SongDao.class.php";
require_once dirname(__FILE__)."/../dao/ArtistDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

class AlbumService extends BaseService{

  public function __construct(){
    $this->dao = new AlbumDao();
  }

  public function get_albums($search, $offset, $limit, $order, $total = FALSE){
    return $this->dao->get_albums($search, $offset, $limit, $order, $total);
    /*
    if($search){
      return $this->dao->get_albums($search, $offset, $limit, $order);
    }
    else{
      return $this->dao->get_all($offset, $limit, $order);
    }*/
  }

  public function get_albums_by_artist($artist_id, $offset, $limit, $order){
    return $this->dao->get_albums_by_artist($artist_id, $offset, $limit, $order);
  }

  //TODO: function that retunrs list of songs that are on a specific album


}

?>
