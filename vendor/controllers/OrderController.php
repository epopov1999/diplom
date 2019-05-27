<?php
/*
*
*/
class OrderController extends Controller{

    public function __construct(){
        
        
    }
    
    /**
    * создание заказа
    * ожидает параметры: customer_name, customer_email
    * корзина (куки) должна иметь минимум один товар
    */
    public function create($data) {
        $cust_name = $data['customer_name'];
        $cust_email = $data['customer_email'];

        if (!is_null($cust_name) && !is_null($cust_email) && $cust_name!="" && $cust_email!="") {
            $cart = new CartModel();
            if (!empty($products = $cart->getProducts())) {
                $order = new OrderModel();
                $data['products'] = $products;
                if ($id = $order->create($data)) {
                    $cart->clearProducts(); //очистить корзину после создания заказа
                    Response::send(true, ['msg' => 'Заказ успешно добавлен', 'id' => $id]);
                } throw new Exception('Ошибка при создании заказа');
            } throw new Exception('Ошибка при создании заказа: корзина пуста');
        } throw new Exception('Ошибка при создании заказа: отсутствуют имя или email клиента');
    }
    
    /**
    @todo 
    1. понять какие параметры принимаются. нужно ли редактировать клиента, или передается его id и т.д. и т.п.
    2. если customer (есть токен по заказу в браузере), тогда отредактировать заказ товарами из корзины. а если админ тогда принимать массив с заказами или что-то в этом роде
    */
    public function edit($data) {
        return null;
    }
    
    /**
    * удаление заказа, ожидает параметр id
    * требуется авторизация
    */
    public function remove($data) {
        $order_id = $data['id'];
        $order = new OrderModel();
        if (!is_null($order_id) && $order_id!="" && $order->get($order_id)) {
            if ($this->isAdmin()) {
                if ($order->remove($order_id)) {
                    Response::send(true, 'Заказ успешно удален');
                } throw new Exception('Ошибка при удалении заказа');
            } throw new Exception('403 Ошибка авторизации');
        } throw new Exception('Заказа не существует');
    }
    
    /**
    * получение заказа, ожидает параметр id
    * необходимо быть либо авторизованым, либо заказ должен принадлежать пользователю, исполняющему запрос
    */
    public function get($data) {
        $order_id = $data['id'];
        $model = new OrderModel();
        if (!is_null($order_id) && $order_id!="" && $order = $model->get($order_id)) {
            if ($this->isAdmin() || $model->isUserOrder($order_id)) {
                Response::send(true, $order);
            } throw new Exception('403 нет доступа к заказу');
        } throw new Exception('Заказа не существует');
    }
    
    /**
    * получение всех заказов
    * если авторизован, то все заказы из базы
    * если есть токен в куках, то все заказы пользователя
    * иначе пустой массив
    */
    public function find($data = null) {
        $model = new OrderModel();
        Response::send(true, $model->find(['is_admin' =>$this->isAdmin()]));
    }

}
