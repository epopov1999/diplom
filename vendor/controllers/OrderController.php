<?php
/*
*
*/
class OrderController extends Controller{

    public function __construct(){
        
        
    }
    
    public function create($data) {
        $model = new OrderModel();

        if (!is_null($data['customer_name']) && !is_null($data['customer_email'])) {
            $model->create($data);
            Response::send(true, 'Заказ успешно добавлен');
        } Response::send(false, 'Ошибка при создании заказа');
    }
    
    public function edit($data) {
//       $model = new OrderModel();
//       return $model->edit($data);
    }
    
    public function remove($data) {
        
    }
    
    public function get($data = null) {
        $token = $_COOKIE['ordertoken'];
        $model = new OrderModel();
        Response::send(true, $model->get($token));
    }
    
    public function find($data = null) {

    }

}
