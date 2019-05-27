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
            $customer_id = $this->connect->lastInsertId();
        }

        if (!$this->connect->query("INSERT INTO `orders` (`customer_id`) VALUES ($customer_id)")) return false;
        $order_id = $this->connect->lastInsertId();

        foreach($data['products'] as $product) {
            $prod_id = $product['id_product'];
            $prod_lic = $product['lic'];
            $prod_count = $product['count'];
            if(!$this->connect->query("INSERT INTO `orders_products` (`order_id`, `product_id`, `lic`, `count`) VALUES ($order_id, $prod_id, '$prod_lic', $prod_count);")) return false;
        }
        
        return $order_id;
    }

    public function edit($data) {
        return null;
    }

    public function remove($orderId) {
        return ($this->connect->query("DELETE FROM `orders_products` WHERE `order_id` = $orderId;") && $this->connect->query("DELETE FROM `orders` WHERE `id` = $orderId;")) ? true : false;
    }

    public function get($id) {

        $get_order = $this->connect->query("SELECT * FROM `orders` WHERE `id`=$id");
        if (!$get_order || empty($order_info = $get_order->fetchAll(PDO::FETCH_ASSOC))) return false;
        
        $customer_id = $order_info[0]['customer_id'];
        
        $get_customer = $this->connect->query("SELECT * FROM `customers` WHERE `id`='$customer_id'");
        if (!$get_customer) return false;
        $customer = $get_customer->fetchAll(PDO::FETCH_ASSOC)[0];

        $get_products = $this->connect->query("SELECT * FROM `orders_products` WHERE `order_id`=$id");
        if (!$get_products) return false;
        $products = $get_products->fetchAll(PDO::FETCH_ASSOC);
        $prodModel = new ProductModel();
        
        $products_in_order = [];
        
        foreach ($products as $product) {
            
            $data = $prodModel->get(['id' => $product['product_id']]);
            $products_in_order [] = ['id_product' => $product['product_id'], 'naim_product' => $data['name'], 'price' => $data['prices'][$product['lic']], 'lic' => $product['lic'], 'count' => $product['count']];
        }
        
        $order = [
            'id_order' => $id,
            'shopperName' => $customer['name'],
            'shopperEmail' => $customer['email'],
            'order' => $products_in_order
        ];

        return $order;
    }
    
    /**
    * проверяет принадлежит ли заказ текущему пользователю
    */
    public function isUserOrder($order_id){ 
        if (isset($_COOKIE['ordertoken'])) {
            $user_token = $_COOKIE['ordertoken'];
            $get_customer_id = $this->connect->query("SELECT `customer_id` FROM `orders` WHERE `id`=$order_id");
            $customer_id = $get_customer_id->fetch(PDO::FETCH_ASSOC)['customer_id'];
            $get_order_token = $this->connect->query("SELECT `token` FROM `customers` WHERE `id`=$customer_id");
            if (!$get_order_token) return false;
            $order_token = $get_order_token->fetch(PDO::FETCH_ASSOC)['token'];
            return ($order_token == $user_token);
        } 
        return false;
    }

    // вернуть все заказы пользователя (если есть токен в куках)
    // иначе вернуть все заказы если админ
    public function find($filter = null) {
        $orders = [];
        if (isset($_COOKIE['ordertoken'])) {
            $user_token = $_COOKIE['ordertoken'];
            $get_customer_id = $this->connect->query("SELECT `id` FROM `customers` WHERE `token`='$user_token'");
            if ($get_customer_id) {
                $customer_id = $get_customer_id->fetch(PDO::FETCH_ASSOC)['id'];
                $get_orders = $this->connect->query("SELECT `id` FROM `orders` WHERE `customer_id`=$customer_id");
                if ($get_orders) {
                    $orders_ids = $get_orders->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($orders_ids as $order) {
                        $orders []= $this->get($order['id']);
                    }
                }
            } 
        } elseif($filter['is_admin']) {
            $get_orders = $this->connect->query("SELECT * FROM `orders`");
            if ($get_orders) {
                $orders_ids = $get_orders->fetchAll(PDO::FETCH_ASSOC);
                foreach ($orders_ids as $order) {
                    $orders []= $this->get($order['id']);
                }
            }
        }
        return $orders;
    }
    
}