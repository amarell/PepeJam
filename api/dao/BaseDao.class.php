<?php
require_once dirname(__FILE__)."/../config.php";


/**
* The main class for interacting with the database
* All other Dao classes inherit this class
*/


class BaseDao{
  protected $connection;
  private $table;

  public function __construct($table){
    $this->table = $table;
    try {
      $this->connection = new PDO("mysql:host=".Config::DB_HOST.";dbname=".Config::DB_SCHEME, Config::DB_USERNAME, Config::DB_PASSWORD);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      throw $e;
    }
  }

  protected function insert($table, $entity, $primary_key = "id"){
    $query = "INSERT INTO ${table} (";

    foreach ($entity as $column => $value) {
      $query .= $column.", ";
    }

    $query = substr($query, 0, -2);
    $query .= ") VALUES (";

    foreach ($entity as $column => $value) {
      $query .= ":".$column.", ";
    }

    $query = substr($query, 0, -2);
    $query .= ")";

    $stmt = $this->connection->prepare($query);
    $stmt->execute($entity);
    $user[$primary_key] = $this->connection->lastInsertId();
    return $entity;
  }

  protected function execute_update($table, $id, $entity, $primary_key = "id"){
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

  protected function query($query, $params){
    $stmt = $this->connection->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  protected function query_unique($query, $params){
    $result = $this->query($query, $params);
    return reset($result);
  }

  public function add($entity, $primary_key = "id"){
    return $this->insert($this->table, $entity, $primary_key);
  }

  public function update($id, $entity, $primary_key = "id"){
    $this->execute_update($this->table, $id, $entity, $primary_key);
  }

  public function get_by_id($id, $primary_key = "id"){
    return $this->query_unique("SELECT * FROM ".$this->table." WHERE ${primary_key} = :id", ["id" => $id]);
  }

  public function get_all($offset = 0, $limit = 3){
    return $this->query("SELECT * FROM ".$this->table. " LIMIT ${limit} OFFSET ${offset}", []);
  }
}
?>
