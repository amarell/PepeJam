<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class AlbumDao extends BaseDao{

  public function get_album_by_id($id){
    return $this->query_unique("SELECT * FROM albums WHERE album_id = :album_id", ["album_id" => $id]);
  }

  public function get_album_by_name($name){
    return $this->query("SELECT * FROM albums WHERE album_name = :album_name", ["album_name" => $name]);
  }

  public function add_album($album){
    $this->insert("albums", $album, "album_id");
    return $album;
  }

  public function update_album($id, $album){
    $this->update("albums", $id, $album, "album_id");
  }

}
?>
