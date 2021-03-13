<?php
require_once dirname(__FILE__)."/BaseDao.class.php";


class AccountDao extends BaseDao{

  public function get_account_by_email($email){
    return $this->query_unique("SELECT * FROM accounts WHERE account_email=:email", ["email"=>$email]);
  }

  public function get_account_by_id($id){
    return $this->query_unique("SELECT * FROM accounts WHERE account_id=:account_id", ["account_id"=>$id]);
  }

  public function add_acocunt($account){

  }

}
?>
