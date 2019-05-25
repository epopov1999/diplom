<?php
/*
* @todo добавить новое свойство товара - картинка
*/
class ProductController extends Controller
{

    public function __construct(){ 
        
    }
    
    public function create($data) {
        if ($this->isAdmin()) {
            $model = new ProductModel();
            if (!is_null($data['name']) && !is_null($data['categoryId']) && !empty($data['prices'])) {
                
                $model->create($data);
                Response::send(true, 'Продукт успешно добавлен');
            } Response::send(false, 'Ошибка при создании продукта');
            
        } Response::send(false, '403. Ошибка авторизации.');
    }
    
    public function edit($data) {
        if ($this->isAdmin()) {
            $model = new ProductModel();
            if (!is_null($data['id']) && !is_null($data['name']) && !is_null($data['categoryId']) && !empty($data['prices'])) {
                
                $model->edit($data);
                Response::send(true, 'Продукт успешно изменен');
            } Response::send(false, 'Ошибка при изменении продукта');
            
        } Response::send(false, '403. Ошибка авторизации.');
    }
    
    public function remove($data) {
        if ($this->isAdmin()) {
            $model = new ProductModel();
            if (!is_null($data['id'])) {
                $model->remove($data['id']);
                Response::send(true, 'Продукт успешно удален');
            } Response::send(false, 'Ошибка при удалении продукта');
        } Response::send(false, '403. Ошибка авторизации.');
    }
    
    public function get($data) {
        $model = new ProductModel();
        Response::send(true, $model->get($data));
    }
    
    public function find($data = null) {
        $model = new ProductModel();
        Response::send(true, $model->find());
    }

}
