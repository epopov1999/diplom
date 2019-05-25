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
        $image_src = Image::add();

        $sql = "INSERT INTO `$this->table` (`name`, `category_id`, `image_src`) VALUES ('$name', $categoryId, '$image_src');";
        $res = [];
        $res[] = $this->connect->query($sql);
      
        $productId = $this->connect->insert_id; 
        $sql = '';
        foreach ($data['prices'] as $lic => $price_value) {
            $sql = "INSERT INTO `prices` (`product_id`, `license`, `sum`) VALUES ($productId, '$lic', $price_value);";
            $res[] = $this->connect->query($sql);
        }
        return !empty($res);
    }

    public function edit($data) {
        $id = $data['id'];
        $categoryId = $data['categoryId'];
        $name = $data['name'];
        $sql = "UPDATE `$this->table` SET `name`='$name', `category_id`=$categoryId WHERE `id` = $id;";
        $res = [];
        $res[] = $this->connect->query($sql);

        $res[] = $this->connect->query("DELETE FROM `prices` WHERE `product_id`=$id");
        foreach ($data['prices'] as $lic => $price_value) {
            $sql = "INSERT INTO `prices` (`product_id`, `license`, `sum`) VALUES ($id, '$lic', $price_value);";
            $res[] = $this->connect->query($sql);
        }

        return !empty($res);
    }

    public function remove($productId) {
        /**
        * @todo
        * продукт должен удаляться еще из заказов где он есть
        */
        $this->table = 'prices';
        $sql = "DELETE FROM `$this->table` WHERE `product_id` = $productId;";
        $res = [];
        $res[] = $this->connect->query($sql);
        
        $this->table = 'products';
        $get_img_src = $this->connect->query("SELECT `image_src` from `$this->table` WHERE `id` = $productId;");
        $img_src = $get_img_src->fetchAll(PDO::FETCH_ASSOC)[0];
        Image::remove($img_src);
        
        $sql = "DELETE FROM `$this->table` WHERE `id` = $productId;";
        $res[] = $this->connect->query($sql);

        return !empty($res);
    }

    public function get($data) {
        $id = $data['id'];
        $lic = (isset($data['lic'])) ? $data['lic'] : null;
        $sql = "SELECT * FROM `$this->table` WHERE `id` = $id";
        $result = $this->connect->query($sql);
        $product = $result->fetchAll(PDO::FETCH_ASSOC)[0];
        if (is_null($lic)) {
            $get_prices = $this->connect->query("SELECT license, sum from `prices` WHERE `product_id`=$id");
            $product['prices'] = array_column($get_prices->fetchAll(PDO::FETCH_ASSOC), 'sum' , 'license');
        } else {
            $get_price = $this->connect->query("SELECT sum from `prices` WHERE `product_id`=$id AND `license`='$lic'");
            $product['price'] = $get_price->fetch_row()[0];
            $product['lic'] = $lic;
        }
        return $product ?? false;
    }

    public function find() {
        $sql = "SELECT * FROM `$this->table`";
        $result = $this->connect->query($sql);
        $products = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach($products as &$product) {
            $id = $product['id'];
            $get_prices = $this->connect->query("SELECT license, sum from `prices` WHERE `product_id`=$id");
            $product['prices'] = array_column($get_prices->fetchAll(PDO::FETCH_ASSOC), 'sum' , 'license');
        }
        return $products ?? false;
    }
    
}