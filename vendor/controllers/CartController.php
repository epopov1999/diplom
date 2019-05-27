<?php
/**
* класс работы с корзиной
* авторизация для методов не требуется
*/
class CartController extends Controller
{
    public function __construct(){
        $this->cart = new CartModel();
    }
    
    /**
    * добавить товар в корзину
    * ожидает параметры: id, lic
    */
    public function addProduct($data) {
        $product_id = $data['id'];
        $product_lic = $data['lic'];
        if (!is_null($product_id) && !is_null($product_lic) && $product_id!="" && $product_lic!="") {
            $product = new ProductModel();
            if ($product->get($data)) {
                $this->cart->addProduct($product_id, $product_lic);
                Response::send(true, 'Товар ID'.$product_id.' успешно добавлен в корзину');
            } throw new Exception('Товар не существует');
        } throw new Exception('Укажите id товара и тип цены');
    }
    
    /**
    * вернуть корзину пользователя 
    */
    public function get() {
        Response::send(true, $this->cart->getProducts());
    }
    
    /**
    * очистка корзины пользователя 
    */
    public function clear() {
        $this->cart->clearProducts();
        Response::send(true, 'Очистка корзины прошла успешно');
    }
    
    /**
    * удаление товара из корзины
    * ожидает параметры: id, lic
    */
    public function removeProduct($data) {
        $product_id = $data['id'];
        $product_lic = $data['lic'];
        if (!is_null($product_id) && !is_null($product_lic) && $product_id!="" && $product_lic!="") {
            if ($this->cart->removeProduct($product_id, $product_lic)) {
                Response::send(true, 'Товар успешно удален из корзины');
            } throw new Exception('Товар не найден в корзине');
        } throw new Exception('Укажите id товара и тип цены');
    } 
}