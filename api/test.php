<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once dirname(__FILE__).'/../vendor/autoload.php';
  require_once dirname(__FILE__)."/clients/CDNClient.class.php";
  $client = new CDNClient();

  $result = $client->delete("Untitled.png");
  print_r($result);
?>
