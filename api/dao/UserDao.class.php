<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class UserDao extends BaseDao{

  public function __construct(){
    parent::__construct("users", "user_id");
  }

  public function get_user_by_email($email){
    return $this->query_unique("SELECT * FROM users WHERE email=:email", ["email"=>$email]);
  }

  public function update_user_by_email($email, $user){
    $this->update("users", $email, $user, "email");
  }

  public function get_users($search, $offset, $limit, $order){
    if(is_null($order)){
      $order = "-user_id";
    }

    switch(substr($order, 0, 1)){
      case "-": $order_direction = "ASC"; break;
      case "+": $order_direction = "DESC"; break;
      default: throw new Exception("Invalid format. First character should be either + or -"); break;
    }

    $order_column = substr($order, 1);
    //$this->connection->quote(substr($order, 1));

    return $this->query("SELECT * FROM users
                         WHERE LOWER(username) LIKE LOWER('%".$search."%')
                         ORDER BY ${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",
                         []);
  }

  public function get_user_by_token($token){
    return $this->query_unique("SELECT * FROM users WHERE token = :token", ["token" => $token]);
  }


}
?>
