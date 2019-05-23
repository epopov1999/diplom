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
            if (!is_null($data['id'])) {
                $model->create($data);
                Response::send(true, 'Заказ успешно добавлен');
            } Response::send(false, 'Ошибка при создании заказа');
            
        } Response::send(false, '403. Ошибка авторизации.');
    }
    
    public function edit($data) {
        $model = new OrderModel();
        return $model->edit($data);
    }
    
    public function remove($data) {
        $model = new OrderModel();
        return $model->remove($data['id']);
    }
    
    public function get($data) {
        $model = new OrderModel();
        Response::send(json_encode($model->get($data['id'])));
    }
    
    public function find($data = null) {
        $model = new OrderModel();
        Response::send(json_encode($model->find()));
    }

}
