<?php
require_once dirname(__FILE__)."/../dao/UserDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

class UserService extends BaseService{

  public function __construct(){
    $this->dao = new UserDao();
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
