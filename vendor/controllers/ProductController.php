<?php

class ProductController extends Controller
{

    public function __construct(){ 
        
    }
    
    /**
    * добавление товара
    * ожидает параметры: name, prices = [single, site, team], categoryid
    * требует загрузки картинки из формы
    * требуется авторизация
    */
    public function create($data) {
        $name = $data['name'];
        $prices = $data['prices'];
        $category_id = $data['categoryId'];
        if ($this->isAdmin()) {
            if (!is_null($name) && $name!="" && !empty($prices) && $prices['single']!="" && $prices['team']!="" && $prices['site']!="") {
                $category = new CategoryModel();
                if ($category->get($category_id)) {
                    $product = new ProductModel();
                    if ($id = $product->create($data)) {
                        Response::send(true, ['msg' => 'Товар успешно добавлен', 'id' => $id]);
                    } throw new Exception('Ошибка при создании товара');
                } throw new Exception('Такой категории нет');
            } throw new Exception('Укажите название товара и его цены (массив)');
        } throw new Exception('403 Ошибка авторизации');
    }
    
    /**
    * редактирование товара
    * ожидает параметры: id, name, prices = [single, site, team], categoryid
    * требует загрузки картинки из формы
    * требуется авторизация
    */
    public function edit($data) {
        if ($this->isAdmin()) {
            $id = $data['id'];
            $name = $data['name'];
            $prices = $data['prices'];
            $category_id = $data['categoryId'];
            if (!is_null($id) && $id!="" && !is_null($name) && $name!="" && !empty($prices) && $prices['single']!="" && $prices['team']!="" && $prices['site']!="")  {
                $product = new ProductModel();
                if ($product->get(['id'=>$id])) {
                    $category = new CategoryModel();
                    if ($category->get($category_id)) {
                        if ($product->edit($data)) {
                            Response::send(true, ['msg' => 'Товар успешно изменен','id' => $id]);
                        } throw new Exception('Ошибка при редактировании товара');
                    } throw new Exception('Такой категории нет');
                } throw new Exception('Товар отсутствует');
            } throw new Exception('Укажите id, название товара и его цены (массив)');
        } throw new Exception('403 Ошибка авторизации');
    }
    
    /**
    * удаление товара, требует параметр id и необходима авторизация
    */
    public function remove($data) {
        if ($this->isAdmin()) {
            $model = new ProductModel();
            if (!is_null($data['id']) && $model->get($data)) {
                if ($model->remove($data['id'])) {
                    Response::send(true, 'Товар успешно удален');
                } throw new Exception('Ошибка при удалении товара');
            } throw new Exception('Товар отсутствует');
        } throw new Exception('403 Ошибка авторизации');
    }
    
    /**
    * получение товара, требует параметры: id, lic (лицензия, строка)
    * авторизация НЕ требуется
    */
    public function get($data) {
        $id = $data['id'];
        $lic = $data['lic'];
        $model = new ProductModel();
        if ($product = $model->get($data)) {
            Response::send(true, $product);
        } throw new Exception('Товар отсутствует');
    }
    
    /**
    * получение всех товаров
    * авторизация НЕ требуется
    */
    public function find($filter = null) {
        $model = new ProductModel();
        $products = $model->find($filter);
        Response::send(true, $products);
    }

}
