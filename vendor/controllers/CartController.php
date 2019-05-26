<?php
class CartController extends Controller
{
    public function __construct(){
        $this->cart = new CartModel();
    }
    
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
    
    public function get() {
        Response::send(true, $this->cart->getProducts());
    }
    
    public function clear() {
        $this->cart->clearProducts();
        Response::send(true, 'Очистка корзины прошла успешно');
    }
    
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