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

        if (isset($_COOKIE['ordertoken'])) {
            $token = $_COOKIE['ordertoken'];
        } else {
            $token = generateRandomString();
            setcookie('ordertoken', $token, time() + (10 * 365 * 24 * 60 * 60), '/');
        }
        
        $cust_name = $data['customer_name'];
        $cust_email = $data['customer_email'];
        $get_customer = $this->connect->query("SELECT `id`, `token` FROM `customers` WHERE `email`='$cust_email'");
        if (!$get_customer) return false;
        $customer = $get_customer->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($customer)) {
            $customer_id = $customer[0]['id'];
        } else {
            if (!$this->connect->query("INSERT INTO `customers` (`name`,`email`,`token`) VALUES ('$cust_name', '$cust_email','$token');")) return false;
            $customer_id = $this->connect->insert_id;
        }

        if (!$this->connect->query("INSERT INTO `$this->table` (`customer_id`) VALUES ($customer_id);")) return false;
        
        $order_id = $this->connect->insert_id;

        foreach($data['products'] as $product) {
            if(!$this->connect->query("INSERT INTO `orders_products` (`order_id`, `product_id`, `lic`, `count`) VALUES ($order_id, $product->product_id, '$product->lic', $product->count);")) return false;
        }
        
        return $order_id;
    }

    /**
    * нужен ли метод редактирования заказа? если да, то какие конкретно входные данные (клиент, продукты и т.д.)?
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
        return ($this->connect->query("DELETE FROM `orders_products` WHERE `order_id` = $orderId;") && $this->connect->query("DELETE FROM `orders` WHERE `id` = $orderId;")) ? true : false;
    }

    public function get($token) {
        $get_customer = $this->connect->query("SELECT * FROM `customers` WHERE `token`='$token'");
        $customer = $get_customer->fetchAll(PDO::FETCH_ASSOC)[0];
        $customer_id = $customer['id'];
        
        $get_orders = $this->connect->query("SELECT `id` FROM `orders` WHERE `customer_id`=$customer_id");
        $orders_ids = array_column($get_orders->fetchAll(PDO::FETCH_ASSOC),'id',0);

        if (count($orders_ids)>1) {
            return $this->find($orders_ids);
        }
        $order_id = $orders_ids[0];
        $cart = new CartModel();
        $order = [
            'id_order' => $order_id,
            'shopperName' => $customer['name'],
            'shopperEmail' => $customer['email'],
            'order' => $cart->getProducts()
        ];

        return $order ?? false;
    }

    // @todo вернуть все заказы пользователя (если есть токен в куках)
    // иначе вернуть все заказы если админ
    public function find($orders_ids = null) {
        return null;
    }
    
}