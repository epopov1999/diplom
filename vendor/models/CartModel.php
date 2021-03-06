<?php

class CartModel extends Model
{
    /**
    * при инициализации объекта получить доступ к корзине, которая хранится в куках
    */
    public function __construct() {
        parent::__construct();
        $this->cart = (isset($_COOKIE['cart'])) ? json_decode($_COOKIE['cart']) : [];
    }
    
    /**
    * подтянуть информацию о товарах из базы по id, которые получены из куки
    */
    public function getProducts() {
        $products = [];
        foreach ($this->cart as $product) {
            $id = $product->product_id;
            $lic = $product->lic;
            $count = $product->count;

            $product_model = new ProductModel();
            $product_info = $product_model->get(['id'=>$id]);

            $name = $product_info['name'];
            $image = $product_info['img_src'];
            $price = $product_info['prices'][$lic];

            $products [] = ['id_product' => $id, 'count' => $count, 'naim_product' => $name, "price" => $price, 'lic' => $lic, 'image'=>$image];
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