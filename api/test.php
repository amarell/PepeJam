<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/dao/UserDao.class.php";

$user_dao = new UserDao();
//$user = $user_dao->get_user_by_email("mujagicamar@gmail.com");

$user = [
  "name"=>"Ado",
  "account_id"=>1
];


print_r($user_dao->add_user($user));
?>
