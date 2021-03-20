<?php
require_once dirname(__FILE__)."/../dao/UserDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

class UserService extends BaseService{

  public function __construct(){
    $this->dao = new UserDao();
  }

  public function get_users($search, $offset, $limit, $order){
    if($search){
      return $this->dao->get_users($search, $offset, $limit, $order);
    }
    else{
      return $this->dao->get_all($offset, $limit, $order);
    }
  }

  public function register($user){
    if(!isset($user["username"])){
      throw new Exception("Username field cannot be empty.");
    }

    $user["created_at"] = date(Config::DATE_FORMAT);
    $user["token"] = md5(random_bytes(16));

    parent::add($user);

    $info = $this->dao->get_user_by_email($user["email"]);

    //TODO: send email with token

    return $info;
  }

  public function confirm($token){
    $user = $this->dao->get_user_by_token($token);

    if(!isset($user["user_id"])){
      throw new Exception("The user doesn't exist");
    }

    $this->dao->update($user["user_id"], ["status" => "ACTIVE"]);
    $user = $this->dao->get_user_by_token($token);
    return $user;
  }

}

?>
