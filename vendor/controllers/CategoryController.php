<?php
/**
 * 
 */
class CategoryController extends Controller
{
    public function __construct(){
  
    }
    
    public function create($data) {
        $name = $data['name'];
        if ($this->isAdmin()) {
            $model = new CategoryModel();
            if (!is_null($name)) {
                if ($id = $model->create($name)) {
                    Response::send(true, ['msg' => 'Категория успешно добавлена', 'id' => $id]);
                } throw new Exception('Ошибка при создании категории');
            } throw new Exception('Укажите имя категории');
        } throw new Exception('403 Ошибка авторизации');
    }
    
    public function edit($data) {
        $id = $data['id'];
        $name = $data['name'];
        if ($this->isAdmin()) {
            $model = new CategoryModel();
            if (!is_null($id) && !is_null($name)) {
                if ($model->get($id) && $model->edit($data)) {
                    Response::send(true, ['msg' => 'Категория успешно изменена', 'id' => $id]);
                } throw new Exception('Ошибка при редактировании категории');
            } throw new Exception('Укажите id категории и имя');
        } throw new Exception('403 Ошибка авторизации');
    }
    
    public function remove($data) {
        $id = $data['id'];
        if ($this->isAdmin()) {
            $model = new CategoryModel();
            if (!is_null($id)) {
                if ($model->get($id) && $model->remove($id)) {
                    Response::send(true, 'Категория успешно удалена');
                } throw new Exception('Ошибка при удалении категории');
            } throw new Exception('Категория отсутствует');
        } throw new Exception('403 Ошибка авторизации');
    }
    
    public function get($data) {
        $id = $data['id'];
        $model = new CategoryModel();
        if ($category = $model->get($id)) {
            Response::send(true, $category);
        } throw new Exception('Категория отсутствует');
    }
    
    public function find($data = null) {
        $model = new CategoryModel();
        $categories = $model->find();
        Response::send(true, $categories);
    }
}