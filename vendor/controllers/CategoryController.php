<?php
/**
 * 
 */
class CategoryController extends Controller
{
    public function __construct(){
        
        
    }
    
    public function create($data) {
        debug('test');
        if ($this->isAdmin()) {
            $model = new CategoryModel();
            $model->create($data['name']);
            Response::send(true, 'Категория успешно добавлена');
        } Response::send(false, '403. Ошибка авторизации.');
    }
    
    public function edit($data) {
        $model = new CategoryModel();
        return $model->edit($data['id'], $data['name']);
    }
    
    public function remove($data) {
        $model = new CategoryModel();
        return $model->remove($data['id']);
    }
    
    public function get($data) {
        $model = new CategoryModel();
        Response::send($model->get($data['id']));
    }
    
    public function find($data = null) {
        $model = new CategoryModel();
        Response::send($model->find());
    }
}