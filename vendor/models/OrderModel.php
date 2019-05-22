<?php
/**
* @class OrderModel
*/
class OrderModel extends Model
{
    protected $table;

    public function __construct(){
        parent::__construct();
        $this->table = 'orders';
    }

    public function create($data) {
        $customerId = $data['customerId']; 
        $sql = "INSERT INTO `$this->table` (`customer_id`) VALUES ($customerId);";
        $this->table = 'orders_products';
        $this->connect->query($sql);

        $orderId = $this->connect->insert_id;
        foreach($data['products'] as $product) {
            $sql += "INSERT INTO `$this->table` (`order_id`, `product_id`) VALUES ($orderId, $product);";
        }

        $this->table = 'orders';
        return $this->connect->query($sql);
    }

    public function edit($data) {
        $id = $data['id'];
        $customerId = $data['customerId']; 
        $sql = "UPDATE `$this->table` SET (`customer_id`) VALUES ($customerId) WHERE `id` = $id;";
        $this->table = 'orders_products';

        $orderId = $id; 
        foreach($data['products'] as $product){
            $sql += "UPDATE `$this->table` SET (`order_id`, `product_id`) VALUES ($orderId, $product) WHERE `order_id` = $orderId;";
        }

        $this->table = 'orders';
        return $this->connect->query($sql);
    }

    public function remove($orderId) {
        $this->table = 'orders_products';
        $sql = "DELETE FROM `$this->table` WHERE `order_id` = $orderId;";
        $this->table = 'orders';
        $sql += "DELETE FROM `$this->table` WHERE `id` = $orderId";
        return $this->connect->query($sql);
    }

    public function get($id) {
        $result = $this->connect->query("SELECT * FROM `$this->table` o INNER JOIN `orders_products` op ON o.id = op.order_id WHERE `id` = $id");
        $order = $result->fetch_all(MYSQLI_ASSOC);
        return $order ?? false;
    }

    public function find(){
        $result = $this->connect->query("SELECT * FROM `$this->table` o INNER JOIN `orders_products` op ON o.id = op.order_id");
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        return $orders ?? false;
    }
    
}