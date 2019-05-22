<?php
/**
 * 
 */
class CategoryController
{
    public function __construct(){
        
        
    }
    
    public function create($data) {
        $model = new CategoryModel();
        return $model->create($data['name']);
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