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

        $res = [];
        $cust_name = $data['customer_name'];
        $cust_email = $data['customer_email'];
        $res[] = $this->connect->query("INSERT INTO `customers` (`name`,`email`) VALUES ('$cust_name', '$cust_email');");
        $customer_id = $this->connect->insert_id;

        $token = generateRandomString();
        $this->connect->query("INSERT INTO `$this->table` (`customer_id`, `token`) VALUES ($customer_id, '$token');");
        setcookie('ordertoken', $token, time() + (10 * 365 * 24 * 60 * 60), '/');
        $order_id = $this->connect->insert_id;

        $cart = new CartModel();
        $data['products'] = $cart->getProducts();
        
        foreach($data['products'] as $product_id) {
            $res[] = $this->connect->query("INSERT INTO `orders_products` (`order_id`, `product_id`) VALUES ($order_id, $product_id);");
        }
        
        return !empty($res);
    }

    /**
    * @todo 
    * разобраться как правильно изменять заказ (клиента?)
    * нужна ли возможность добавлять продукт и удалять его из заказа
    */
    public function edit($data) {
//        $id = $data['id'];
//        $customerId = $data['customerId']; 
//        $sql = "UPDATE `$this->table` SET (`customer_id`) VALUES ($customerId) WHERE `id` = $id;";
//        $this->table = 'orders_products';
//
//        $orderId = $id; 
//        foreach($data['products'] as $product){
//            $sql += "UPDATE `$this->table` SET (`order_id`, `product_id`) VALUES ($orderId, $product) WHERE `order_id` = $orderId;";
//        }
//
//        $this->table = 'orders';
//        return $this->connect->query($sql);
    }

    public function remove($orderId) {
        $this->table = 'orders_products';
        $res = [];
        $res[] = $this->connect->query("DELETE FROM `$this->table` WHERE `order_id` = $orderId;");
        $this->table = 'orders';
        $res[] = $this->connect->query("DELETE FROM `$this->table` WHERE `id` = $orderId;");
        return !empty($res);
    }

    public function get($id) {
        $order = [];
        $sql = "SELECT customer_id FROM `$this->table` WHERE `id` = $id";
        $result = $this->connect->query($sql);
        $customer_id = $result->fetch_all(MYSQLI_NUM)[0][0];

        $get_customer = $this->connect->query("SELECT name as customer_name, email as customer_email FROM `customers` WHERE id=$customer_id");
        $order = $get_customer->fetch_all(MYSQLI_ASSOC)[0];
        debug($order);
        return $order ?? false;
    }

    public function find(){
        $result = $this->connect->query("SELECT * FROM `$this->table` o INNER JOIN `orders_products` op ON o.id = op.order_id");
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        return $orders ?? false;
    }
    
}