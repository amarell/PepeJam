<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class UserDao extends BaseDao{

  public function get_user_by_id($id){
    return $this->query_unique("SELECT * FROM users WHERE user_id=:id", ["id"=>$id]);
  }

  public function add_user($user){
    $this->insert("users", $user, "user_id");
    return $user;
  }

  public function update_user($id, $user){
    $this->update("users", $id, $user, "user_id");
  }


}
?>
