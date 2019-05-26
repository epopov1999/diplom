<?php

class CartModel extends Model
{
    public function __construct() {
        parent::__construct();
        $this->cart = (isset($_COOKIE['cart'])) ? json_decode($_COOKIE['cart']) : [];
    }
    
    public function getProducts() {
        $products = [];
        foreach ($this->cart as $product) {
            $id = $product->product_id;
            $lic = $product->lic;
            $count = $product->count;

            $get_name = $this->connect->query("SELECT name from `products` WHERE id=$id");
            $name = $get_name->fetchAll(PDO::FETCH_ASSOC)[0]['name'];

            $get_price = $this->connect->query("SELECT `sum` from `prices` WHERE product_id=$id AND `license`='$lic'");
            $price = $get_price->fetchAll(PDO::FETCH_ASSOC)[0]['sum'];

            $products [] = ['id_product' => $id, 'count' => $count, 'naim_product' => $name, "price" => $price, 'lic' => $lic];
        }
        return $products;
    }
    
    public function addProduct($product_id, $lic) {
        //if isset by lic and product_id, тогда product_count ++
        // else add new product
        $is_new_product = true;

        foreach($this->cart as &$product) {
            if ($product->lic == $lic && $product->product_id == $product_id) {
                $product->count++;
                $is_new_product = false;
            }
        }
        if ($is_new_product) {
            $product_in_cart = [
                'count' => 1,
                'product_id' => $product_id,
                'lic' => $lic
            ];
            $this->cart [] = $product_in_cart;
        }
        $this->saveCart();
    }
    
    public function removeProduct($product_id, $lic) {
        //if count > 1 to --, else unset(product)

        foreach($this->cart as $i => &$product) {

            if ($product->lic == $lic && $product->product_id == $product_id) {
                
                if ($product->count > 1) {
                    $product->count = $product->count - 1;
                } else {
                    array_splice($this->cart, $i, 1);
                }
                $this->saveCart();
                return true;
            } 
        } return false;
    }
    
    public function clearProducts(){
        setcookie('cart', "", time()-(3600*3+60*500), '/');
    } 
    
    private function saveCart() {
        setcookie('cart', json_encode($this->cart), time()+3600*3+60*500, '/');
    }

}