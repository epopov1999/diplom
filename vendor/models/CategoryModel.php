<?php
/**
* @class CategoryModel
*/
class CategoryModel extends Model
{
    protected $table;
    
    public function __construct(){
        parent::__construct();
        $this->table = 'categories';
    }
    
    public function create($name) {
        $sql = "INSERT INTO `$this->table` (`name`) VALUES ('$name')";
        return $this->connect->query($sql);
    }
    
    public function edit($data) {
        $id = $data['id'];
        $name = $data['name'];
        return $this->connect->query("UPDATE `$this->table` SET `name`='$name' WHERE `id`=$id");
    }
    
    public function remove($id) {
        return $this->connect->query("DELETE FROM `$this->table` WHERE `id` = $id");
    }
    
    public function get($id) {
        $result = $this->connect->query("SELECT * FROM `$this->table` WHERE `id` = $id");
        $category = $result->fetch_all(MYSQLI_ASSOC);
        return $category[0] ?? false;
    }
    
    public function find() {
        $result = $this->connect->query("SELECT * FROM `$this->table`");
        $categories = $result->fetch_all(MYSQLI_ASSOC);
        return $categories ?? false;
    }
}