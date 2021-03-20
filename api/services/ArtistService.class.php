<?php
require_once dirname(__FILE__)."/../dao/ArtistDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

class ArtistService extends BaseService{

  public function __construct(){
    $this->dao = new ArtistDao();
  }

  public function get_users($search, $offset, $limit){
    if($search){
      return $this->dao->get_users($search, $offset, $limit);
    }
    else{
      return $this->dao->get_all($offset, $limit);
    }
  }

}

?>
