<?php
/**
 * 
 */
class CategoryController extends Controller
{
    public function __construct(){
        
        
    }
    
    public function create($data) {
        if ($this->isAdmin()) {
            $model = new CategoryModel();
            if (!is_null($data['name'])) {
                $model->create($data['name']);
                Response::send(true, 'Категория успешно добавлена');
            } Response::send(false, 'Ошибка при создании категории');
            
        } Response::send(false, '403. Ошибка авторизации.');
    }
    
    public function edit($data) {
        if ($this->isAdmin()) {
            $model = new CategoryModel();
            if (!is_null($data['id']) && !is_null($data['name'])) {
                $model->edit($data['id'], $data['name']);
                Response::send(true, 'Категория успешно изменена');
            }
        } Response::send(false, '403. Ошибка авторизации.');
    }
    
    public function remove($data) {
        if ($this->isAdmin()) {
            $model = new CategoryModel();
            if (!is_null($data['id'])) {
                $model->remove($data['id']);
                Response::send(true, 'Категория успешно удалена');
            }
        } Response::send(false, '403. Ошибка авторизации.');
    }
    
    public function get($data) {
        $model = new CategoryModel();
        Response::send(true, $model->get($data['id']));
    }
    
    public function find($data = null) {
        $model = new CategoryModel();
        Response::send(true, $model->find());
    }
}