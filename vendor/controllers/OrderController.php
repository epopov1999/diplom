<?php
/*
*
*/
class OrderController extends Controller{

    public function __construct(){
        
        
    }
    
    public function create($data) {
        $cust_name = $data['customer_name'];
        $cust_email = $data['customer_email'];

        if (!is_null($cust_name) && !is_null($cust_email) && $cust_name!="" && $cust_email!="") {
            $cart = new CartModel();
            if (!empty($products = $cart->getProducts())) {
                $order = new OrderModel();
                $data['products'] = $products;
                if ($id = $order->create($data)) {
                    Response::send(true, ['msg' => 'Заказ успешно добавлен', 'id' => $id]);
                } throw new Exception('Ошибка при создании заказа');
            } throw new Exception('Ошибка при создании заказа: корзина пуста');
        } throw new Exception('Ошибка при создании заказа: отсутствуют имя и email клиента');
    }
    
    /**
    * @todo как правильно редактировать заказ? 
    * нужен ли этот метод вообще? если да, то какие конкретно входные данные (клиент, продукты и т.д.)?
    */
    public function edit($data) {
//       $model = new OrderModel();
//       return $model->edit($data);
    }
    
    public function remove($data) {
        
    }
    
    /**
    * @todo как правильно получать заказ? по id или по токену? по токену может быть несколько заказов
    */
    public function get($data) {
//        $token = $_COOKIE['ordertoken'];
        $id = $data['id'];
        $model = new OrderModel();
        Response::send(true, $model->get($id));
    }
    
    public function find($data = null) {
        $model = new OrderModel();
        Response::send(true, $model->find());
    }

}
