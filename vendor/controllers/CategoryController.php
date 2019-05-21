<?php
/**
 * 
 */
class CategoryController
{
    public function __construct(){
        
        
    }
    
    public function create($data){
        //что то в этом духе...
        $model = new CategoryModel();
        $model->create($data);
        
        //... у например продукта эти методы будут больше
        //т.к. будут задействованы разные модели
    }
}