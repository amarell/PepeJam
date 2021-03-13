<?php
require_once dirname(__FILE__)."/../config.php";

class BaseDao{
  protected $connection;

  public function __construct(){

    try {
      $this->connection = new PDO("mysql:host=".Config::DB_HOST.";dbname=".Config::DB_SCHEME, Config::DB_USERNAME, Config::DB_PASSWORD);
      // set the PDO error mode to exception
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //echo "Connected successfully <br> Amar was here <br>";
    } catch(PDOException $e) {
      throw $e;
    }
  }

  public function insert(){

  }

  public function update($table, $id, $entity, $primary_key = "id"){

    $query = "UPDATE ${table} SET ";
    foreach($entity as $name => $value){
      $query .= $name ."= :".$name.", ";
    }
    $query = substr($query, 0, -2);
    $query .= " WHERE ${primary_key} = :id";
    $stmt= $this->connection->prepare($query);
    $entity['id'] = $id;
    $stmt->execute($entity);
  }

  public function query($query, $params){
    $stmt = $this->connection->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function query_unique($query, $params){
    $result = $this->query($query, $params);
    return reset($result);
  }
}
?>
