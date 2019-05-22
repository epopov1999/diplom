<?php
/**
* @class ProductModel
*/
class ProductModel extends Model
{

    protected $table;

    public function __construct(){
        parent::__construct();
        $this->table = 'products';
    }

    public function create($data){
        $categoryId = $data['categoryId'];
        $name = $data['name'];
        $sql = "INSERT INTO `$this->table` (`name`, `categoryId`) VALUES ('$name', $categoryId);";
        $this->table = 'prices';
        $productId = null; //TODO подтянуть из таблицы выше как блять это делать
        foreach($data['prices'] as $price){
            $lic = $price['lic'];
            $sum = $price['sum'];
            $sql += "INSERT INTO `$this->table` (`product_id`, `license`, `sum`) VALUES ($productId, '$lic', $sum);";
        }

        $this->table = 'products';
        return $this->connect->query($sql);
    }

    public function edit($data){
        $id = $data['id'];
        $categoryId = $data['categoryId'];
        $name = $data['name'];
        $sql = "UPDATE `$this->table` SET (`name`, `categoryId`) VALUES ('$name', $categoryId) WHERE `id` = $id;";
        $this->table = 'prices';
        $productId = $id;
        foreach($data['prices'] as $price){
            $lic = $price['lic'];
            $sum = $price['sum'];
            $sql += "UPDATE `$this->table` SET (`product_id`, `license`, `sum`) VALUES ($productId, '$lic', $sum) WHERE `product_id` = $productId;";
        }

        $this->table = 'products';
        return $this->connect->query($sql);
    }

    public function remove($productId){
        $this->table = 'prices';
        $sql = "DELETE FROM `$this->table` WHERE `product_id` = $productId;";
        $this->table = 'products';
        $sql += "DELETE FROM `$this->table` WHERE `id` = $productId";
        return $this->connect->query($sql);
    }

    public function get($id){
        $result = $this->connect->query("SELECT * FROM `$this->table` o INNER JOIN `prices` p ON o.id = p.product_id WHERE `id` = $id");
        $product = $result->fetch_all(MYSQLI_ASSOC);
        return $product ?? false;
    }

    public function find(){
        $result = $this->connect->query("SELECT * FROM `$this->table` o INNER JOIN `prices` p ON o.id = p.product_id");
        $product = $result->fetch_all(MYSQLI_ASSOC);
        return $product ?? false;
    }
    
}