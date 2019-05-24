<?php

class CartModel extends Model
{

    public function getProducts() {
        return json_decode($_COOKIE['cart']);
    }
    
    public function addProduct($product_id, $lic) {
        //if isset by lic and product_id, тогда product_count ++
        // else add new product
        $cart = [];
        if (isset($_COOKIE['cart'])) {
            $cart = json_decode($_COOKIE['cart']);
        }
        $is_new_product = true;

        foreach($cart as &$product) {
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
            $cart [] = $product_in_cart;
        }
        
        setcookie('cart', json_encode($cart), time()+3600*3+60*500, '/'); 
    }
    
    public function removeProduct($id) {
        //if count > 1 to --, else unset(product)
        $cart = [];
        if (isset($_COOKIE['cart'])) {
            $cart = json_decode($_COOKIE['cart']);

            foreach($cart as $i => &$product) {

                if ($product->product_id == $id) {
                    if ($product->count > 1) {
                        $product->count = $product->count - 1;
                    } else {
                        array_splice($cart, $i, 1);
                    }
                    
                    setcookie('cart', json_encode($cart), time()+3600*3+60*500, '/'); 
                    /** 
                    * @todo
                    * сделать ответ что товар успешно удален
                    */
                }
            }
            /** 
            * @todo
            * сделать ответ что товар не найден
            */
        } else {
            /** 
            * @todo
            * сделать ответ что корзина пустая
            */
        }
    }
    
    public function clearProducts(){
        setcookie('cart', "", time()-(3600*3+60*500), '/');
    }
}