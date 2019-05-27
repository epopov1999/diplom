<?php

/**
* @class ProductModel
*/
class ProductModel extends Model
{

    protected $table;

    public function __construct() {
        parent::__construct();
        $this->table = 'products';
    }

    public function create($data) {
        $categoryId = (is_null($data['categoryId']) || $data['categoryId'] == '') ? 0 : $data['categoryId'];
        $name = $data['name'];
        $image_src = Image::add('img_src');

        $sql = "INSERT INTO `$this->table` (`name`, `category_id`, `img_src`) VALUES ('$name', $categoryId, '$image_src');";

        if(!$this->connect->query($sql)) {
            Image::remove($image_src);
            return false;
        }
      
        $productId = $this->connect->lastInsertId();
        foreach ($data['prices'] as $lic => $price_value) {
            $sql = "INSERT INTO `prices` (`product_id`, `license`, `sum`) VALUES ($productId, '$lic', $price_value)";
            if(!$this->connect->query($sql)) {
                Image::remove($image_src);
                return false;
            }
        }
        return $productId;
    }
    
    /**
    * при редактировании сущности товар, важно следить чтобы случайно не оставить товар без картинки
    * например, удалится старая картинка, но произойдет ошибка и до добавления новой картинки не дойдет...
    */
    public function edit($data) {
        $id = $data['id'];
        $categoryId = (is_null($data['categoryId']) || $data['categoryId'] == '') ? 0 : $data['categoryId'];
        $name = $data['name'];
        
        if (!$this->connect->query("DELETE FROM `prices` WHERE `product_id` = $id")) return false;
        
        foreach ($data['prices'] as $lic => $price_value) {
            $sql = "INSERT INTO `prices` (`product_id`, `license`, `sum`) VALUES ($id, '$lic', $price_value)";
            if(!$this->connect->query($sql)) return false;
        }
        
        if (!$get_img_src = $this->connect->query("SELECT `img_src` from `$this->table` WHERE `id` = $id")) return false;
        $old_img_src = $get_img_src->fetchAll(PDO::FETCH_ASSOC)[0]['img_src'];
        
        $new_image_src = Image::add('img_src');
        
        if(!$this->connect->query("UPDATE `$this->table` SET `name` = '$name', `category_id` = $categoryId, `img_src` = '$new_image_src' WHERE `id`=$id")) {
            Image::remove($new_image_src);
            return false;
        }
        
        Image::remove($old_img_src);
        
        return true;
    }

    /**
    *  при удалении товара нужно удалить его из заказов + удалить цены этого товара + удалить картинку
    */
    public function remove($productId) {

        if ($this->connect->query("DELETE FROM `orders_products` WHERE `product_id`=$productId") && $this->connect->query("DELETE FROM `prices` WHERE `product_id` = $productId") && ($get_img_src = $this->connect->query("SELECT `img_src` from `$this->table` WHERE `id` = $productId")) && $this->connect->query("DELETE FROM `$this->table` WHERE `id` = $productId")) {
            $img_src = $get_img_src->fetchAll(PDO::FETCH_ASSOC)[0]['img_src'];
            Image::remove($img_src);
            return true;
        }
        return false;
    }

    /**
    * если лицензия не указана, то вернуть цены всех лицензий
    */
    public function get($data) {
        $id = $data['id'];
        $lic = (isset($data['lic'])) ? $data['lic'] : null;
        $sql = "SELECT * FROM `$this->table` WHERE `id` = $id";
        $result = $this->connect->query($sql);
        if (!$result) return false;
        if(empty($product = $result->fetchAll(PDO::FETCH_ASSOC))) return false;
        $product = $product[0];
        if (is_null($lic)) {
            $get_prices = $this->connect->query("SELECT license, sum from `prices` WHERE `product_id`=$id");
            if (!$get_prices) return false;
            $product['prices'] = array_column($get_prices->fetchAll(PDO::FETCH_ASSOC), 'sum' , 'license');
        } else {
            $get_price = $this->connect->query("SELECT sum from `prices` WHERE `product_id`=$id AND `license`='$lic'");
            if (!$get_price || !$get_price->fetch()) return false;
            $product['price'] = $get_price->fetch()[0];
            $product['lic'] = $lic;
        }
        return $product;
    }

    public function find($filter = null) {
        $sql = "SELECT * FROM `$this->table`";

        $result = $this->connect->query($sql);
        $products = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach($products as &$product) {
            $id = $product['id'];
            $get_prices = $this->connect->query("SELECT license, sum from `prices` WHERE `product_id`=$id");
            $product['prices'] = array_column($get_prices->fetchAll(PDO::FETCH_ASSOC), 'sum' , 'license');
        }
        return $products ?? [];
    }
    
}