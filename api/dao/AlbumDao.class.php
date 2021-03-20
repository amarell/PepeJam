<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class AlbumDao extends BaseDao{

  public function __construct(){
    parent::__construct("albums", "album_id");
  }

  public function get_album_by_name($name){
    return $this->query("SELECT * FROM albums WHERE album_name = :album_name", ["album_name" => $name]);
  }

  /*
  * get_by_id, add, update and get_all functionality is covered by BaseDao
  */

}
?>
