<?php
require_once dirname(__FILE__)."/../dao/UserDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../clients/SMTPClient.class.php";

class UserService extends BaseService{

  private $smtpClient;

  public function __construct(){
    $this->dao = new UserDao();
    $this->smtpClient = new SMTPClient();
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
    $user["password"] = md5($user["password"]);

    parent::add($user);

    $info = $this->dao->get_user_by_email($user["email"]);

    $this->smtpClient->send_token_to_registered_user($info);

    return $info;
  }

  public function confirm($token){
    $user = $this->dao->get_user_by_token($token);

    if(!isset($user["user_id"])){
      throw new Exception("The user doesn't exist");
    }

    $this->dao->update($user["user_id"], ["status" => "ACTIVE", "token" => NULL]);
    $user = $this->dao->get_user_by_token($token);
    return $user;
  }

  public function login($user){
    $db_user = $this->dao->get_user_by_email($user["email"]);

    if(!isset($db_user["user_id"])){
      throw new Exception("User doesn't exist", 400);
    }

    if($db_user["status"] != 'ACTIVE'){
      throw new Exception("User not active", 400);
    }

    if($db_user["password"] != md5($user['password'])){
       throw new Exception("Invalid password or email", 400);
    }

    return $db_user;
  }

  public function forgot($user){
    $db_user = $this->dao->get_user_by_email($user["email"]);

    if(!isset($db_user["user_id"])){
      throw new Exception("User doesn't exist", 400);
    }

    //generate new token and update in db
    $db_user = $this->update($db_user["user_id"], ["token" => md5(random_bytes(16)), "token_created_at" => date(Config::DATE_FORMAT)]);
    //send mail with token
    $this->smtpClient->send_recovery_token($db_user);
  }

  public function reset($user){
    $db_user = $this->dao->get_user_by_token($user["token"]);

    if(!isset($db_user["user_id"])){
      throw new Exception("User doesn't exist", 400);
    }

    if(strtotime(date(Config::DATE_FORMAT)) - strtotime($db_user["token_created_at"]) < 300){
      throw new Exception("You have to wait at least 5 minutes before reseting password again", 400);
    }

    $this->update($db_user["user_id"], ["password" => md5($user["password"]), "token" => NULL]);
  }



}

?>
