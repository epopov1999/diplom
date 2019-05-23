<?php
/*
*
*/
class ProductController extends Controller{

    public function __construct(){
        
        
    }
    
    public function create($data) {
        if ($this->isAdmin()) {
            $model = new ProductModel();
            if (!is_null($data['name'])) {
                $model->create($data);
                Response::send(true, 'Продукт успешно добавлен');
            } Response::send(false, 'Ошибка при создании продукта');
            
        } Response::send(false, '403. Ошибка авторизации.');
    }
    
    public function edit($data) {
        $model = new ProductModel();
        return $model->edit($data);
    }
    
    public function remove($data) {
        $model = new ProductModel();
        return $model->remove($data['id']);
    }
    
    public function get($data) {
        $model = new ProductModel();
        Response::send(json_encode($model->get($data['id'])));
    }
    
    public function find($data = null) {
        $model = new ProductModel();
        Response::send(json_encode($model->find()));
    }

}
