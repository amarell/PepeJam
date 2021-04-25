<?php
require_once dirname(__FILE__)."/../config.php";


/**
* The main class for interacting with the database
* All other Dao classes inherit this class
*/


class BaseDao{
  protected $connection;
  private $table;
  private $primary_key;

  public function __construct($table, $primary_key){
    $this->table = $table;
    $this->primary_key = $primary_key;
    try {
      $this->connection = new PDO("mysql:host=".Config::DB_HOST().";dbname=".Config::DB_SCHEME(), Config::DB_USERNAME(), Config::DB_PASSWORD());
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {
      throw $e;
    }
  }
  
  public function beginTransaction(){
    $this->connection->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
    $this->connection->beginTransaction();
  }

  public function commit(){
    $this->connection->commit();
    $this->connection->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
  }

  public function rollBack(){
    $this->connection->rollBack();
    $this->connection->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
  }

  public static function parse_order($order){
    switch(substr($order, 0, 1)){
      case "-": $order_direction = "ASC"; break;
      case "+": $order_direction = "DESC"; break;
      default: throw new Exception("Invalid format. First character should be either + or -"); break;
    }

    //preventing SQL injection attacks
    /*$order_column = trim($this->connection->quote(substr($order, 1)),"'");*/
    $order_column = substr($order,1);

    return [$order_column, $order_direction];
  }



  protected function insert($table, $entity){
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
    $user[$this->primary_key] = $this->connection->lastInsertId();
    return $entity;
  }

  protected function execute_update($table, $id, $entity){
    $query = "UPDATE ${table} SET ";
    foreach($entity as $name => $value){
      $query .= $name ."= :".$name.", ";
    }
    $query = substr($query, 0, -2);
    $query .= " WHERE {$this->primary_key} = :id";
    $stmt= $this->connection->prepare($query);
    $entity['id'] = $id;
    $stmt->execute($entity);
  }

  public function query($query, $params){
    $stmt = $this->connection->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  protected function query_unique($query, $params){
    $result = $this->query($query, $params);
    return reset($result);
  }

  public function add($entity){
    /*
    try {
      return $this->insert($this->table, $entity);
    } catch (\Exception $e) {
      if(str_contains($e->getMessage(), "users.username_UNIQUE")){
        throw new Exception("Account with same username already exists in the database", 400, $e);
      }
      else{
        throw $e;
      }
    }*/


    return $this->insert($this->table, $entity);
  }

  public function update($id, $entity){
    $this->execute_update($this->table, $id, $entity);
  }

  public function get_by_id($id){
    return $this->query_unique("SELECT * FROM ".$this->table." WHERE {$this->primary_key} = :id", ["id" => $id]);
  }

  public function get_all($offset = 0, $limit = 10, $order = NULL){
    if(is_null($order)){
      $order = "-".$this->primary_key;
    }

    list($order_column, $order_direction) = self::parse_order($order);

    return $this->query("SELECT * FROM ".$this->table.
                        " ORDER BY ${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}", []);
  }
}
?>
