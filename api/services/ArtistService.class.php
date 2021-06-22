<?php
require_once dirname(__FILE__)."/../dao/ArtistDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

class ArtistService extends BaseService{

  public function __construct(){
    $this->dao = new ArtistDao();
  }

  public function get_artists($search, $offset, $limit, $order, $total = FALSE){
    return $this->dao->get_artists($search, $offset, $limit, $order, $total);
    /*if($search){
      return $this->dao->get_artists($search, $offset, $limit, $order);
    }
    else{
      return $this->dao->get_all($offset, $limit, $order);
    }*/
  }

}

?>
