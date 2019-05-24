<?php
/*
*
*/
class OrderController extends Controller{

    public function __construct(){
        
        
    }
    
    public function create($data) {
        if ($this->isAdmin()) {
            $model = new OrderModel();
            //data[products] могут быть пустые
            if (!is_null($data['customer_name']) && !is_null($data['customer_email'])) {
                $model->create($data);
                Response::send(true, 'Заказ успешно добавлен');
            } Response::send(false, 'Ошибка при создании заказа');
            
        } Response::send(false, '403. Ошибка авторизации.');
    }
    
    public function edit($data) {
//        $model = new OrderModel();
//        return $model->edit($data);
    }
    
    public function remove($data) {
        if ($this->isAdmin()) {
            $model = new OrderModel();
            if (!is_null($data['id'])) {
                $model->remove($data);
                Response::send(true, 'Заказ успешно добавлен');
            } Response::send(false, 'Ошибка при создании заказа');
            
        } Response::send(false, '403. Ошибка авторизации.');
    }
    
    public function get($data) {
        $model = new OrderModel();
        Response::send($model->get($data['id']));
    }
    
    public function find($data = null) {
//        $model = new OrderModel();
//        Response::send($model->find());
    }

}
