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
        $categoryId = $data['categoryId'];
        $name = $data['name'];
        $image_src = Image::add('img_src');
        
        if (is_null($categoryId) || $categoryId == '') $categoryId = 0;
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
    * @todo как правильно редактировать (вопрос см. в контроллере)
    */
    public function edit($data) {
        return null;
//        $id = $data['id'];
//        $categoryId = $data['categoryId'];
//        $name = $data['name'];
//        $sql = "UPDATE `$this->table` SET `name`='$name', `category_id`=$categoryId WHERE `id` = $id;";
//        $res = [];
//        $res[] = $this->connect->query($sql);
//
//        $res[] = $this->connect->query("DELETE FROM `prices` WHERE `product_id`=$id");
//        foreach ($data['prices'] as $lic => $price_value) {
//            $sql = "INSERT INTO `prices` (`product_id`, `license`, `sum`) VALUES ($id, '$lic', $price_value);";
//            $res[] = $this->connect->query($sql);
//        }
//
//        return !empty($res);
    }

    public function remove($productId) {
        /**
        * @todo
        * продукт должен удаляться еще из заказов где он есть
        */
        if (!$this->connect->query("DELETE FROM `prices` WHERE `product_id` = $productId;")) return false;

        if (!$get_img_src = $this->connect->query("SELECT `img_src` from `$this->table` WHERE `id` = $productId;")) return false;
        
        $img_src = $get_img_src->fetchAll(PDO::FETCH_ASSOC)[0]['img_src'];
        Image::remove($img_src);
        
        if (!$this->connect->query("DELETE FROM `$this->table` WHERE `id` = $productId;")) return false;

        return true;
    }

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
            if (!$get_price) return false;
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