<?php
class CartController extends Controller
{
    public function __construct(){
        $this->cart = new CartModel();
    }
    
    public function addProduct($data) {
        /** @todo
        * если продукт не существует, то throw new exception
        * иначе добавить и вернуть сообщение об успехе
        */
        $this->cart->addProduct($data['id'], $data['lic']);
    }
    
    public function get() {
        Response::send(true, $this->cart->getProducts());
    }
    
    public function clear() {
        $this->cart->clearProducts();
        Response::send(true, 'msg' => 'Очистка корзины прошла успешно');
    }
    
    public function removeProduct($data) {
        /** @todo
        * если продукт не найден в корзине, то throw new exception
        * иначе вернуть сообщение что продукт успешно удален из корзины
        */
        $this->cart->removeProduct($data['id']);
    } 
}