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
        return ($this->connect->query($sql)) ? $this->connect->lastInsertId() : false;
    }
    
    public function edit($data) {
        $id = $data['id'];
        $name = $data['name'];
        return $this->connect->query("UPDATE `$this->table` SET `name`='$name' WHERE `id`=$id");
    }
    
    /**
    * при удалении категории, в товарах с этой категорией она заменяется на категорию по умолчанию (id=0)
    */
    public function remove($id) {
        return ($this->connect->query("UPDATE `products` SET `category_id`=0 WHERE `category_id`=$id") && $this->connect->query("DELETE FROM `$this->table` WHERE `id` = $id"));
    }
    
    public function get($id) {
        $get_category = $this->connect->query("SELECT * FROM `$this->table` WHERE `id` = $id");
        return ($get_category) ? $get_category->fetchAll(PDO::FETCH_ASSOC)[0] : false;
    }
    
    public function find($filter = null) {
        $get_categories = $this->connect->query("SELECT * FROM `$this->table`");
        return ($get_categories) ? $get_categories->fetchAll(PDO::FETCH_ASSOC) : [];
    }
}