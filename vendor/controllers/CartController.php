<?php
class CartController extends Controller
{
    public function __construct(){
        $this->cart = new CartModel();
    }
    
    public function addProduct($data) {
        /** @todo
        * если продукт не существует, то throw new exception
        */
        $this->cart->addProduct($data['id'], $data['lic']);
    }
    
    public function get() {
        Response::send(true, $this->cart->getProducts());
    }
    
    public function clear() {
        $this->cart->clearProducts();
    }
    
    public function removeProduct($data) {
        $this->cart->removeProduct($data['id']);
    } 
}