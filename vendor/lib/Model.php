<?php
/**
* @todo перенести базу данных на sqlite
* база работает, но надо понять где этот ебучий файл сука лежит
* + переделать все моменты где вызывается $query->fetch_all на foreach($row = $query->fetchArray()) {...}
*/
/**
 * класс взаимодействия с БД, с методами функционала API
 */
class Model
{
/**
* fix: no mysql no
*/
//    private $db = 'shop';
//    private $user = 'root';
//    private $password = '';
//    private $hostName = 'localhost';
//    protected $connect;

//    function __construct(){
//        self::$database = new mysqli($this->hostName, $this->user, $this->password, $this->db);
//        self::$database->set_charset('utf8');
//    }

    private static $dbfile = 'shop.db';
    
    protected $connect;
    
    /**
    * инициализация базы данных sqlite3
    */
    public function __construct() {
        if (file_exists(self::$dbfile)) {
            $this->connect = new PDO('sqlite:'.self::$dbfile);
        }
    }

    public static function initDatabase() { 
        $database = new SQLite3(self::$dbfile);
        $sql="CREATE TABLE `categories` (
            `id` INTEGER PRIMARY KEY,
            `name` TEXT NOT NULL
        )";
        $database->query($sql);
        $sql="CREATE TABLE `customers` (
          `id` INTEGER PRIMARY KEY,
          `name` TEXT NOT NULL,
          `email` TEXT NOT NULL,
          `token` TEXT NOT NULL
        )";
        $database->query($sql);
        $sql="CREATE TABLE `orders` (
          `id` INTEGER PRIMARY KEY,
          `customer_id` INTEGER NOT NULL,
          FOREIGN KEY (`customer_id`) REFERENCES customers(id)
        )";
        $database->query($sql);
        $sql="CREATE TABLE `orders_products` (
            `order_id` INTEGER NOT NULL,
            `product_id` INTEGER NOT NULL,
            `lic` TEXT NOT NULL,
            `count` INTEGER NOT NULL,
            FOREIGN KEY (`order_id`) REFERENCES orders(id),
            FOREIGN KEY (`product_id`) REFERENCES products(id)
        )";
        $database->query($sql);
        $sql="CREATE TABLE `prices` (
          `id` INTEGER PRIMARY KEY,
          `product_id` INTEGER NOT NULL,
          `license` TEXT NOT NULL,
          `sum` REAL NOT NULL,
          FOREIGN KEY (`product_id`) REFERENCES products(id)
        )";
        $database->query($sql);
        $sql="CREATE TABLE `products` (
          `id` INTEGER PRIMARY KEY,
          `category_id` INTEGER NOT NULL,
          `name` TEXT NOT NULL,
          FOREIGN KEY (`category_id`) REFERENCES categories(id)
        )";
        $database->query($sql);
        $sql="CREATE TABLE `users` (
          `id` INTEGER PRIMARY KEY,
          `login` TEXT NOT NULL,
          `password` TEXT NOT NULL,
          `token` TEXT NOT NULL
        )";
        $database->query($sql);

        $sql = "INSERT INTO `users` (`login`,`password`,`token`) VALUES ('admin','popov','123sobaka123')";
        $database->query($sql);
        $sql = "INSERT INTO `users` (`login`,`password`,`token`) VALUES ('moder','test','test')";
        $database->query($sql);
    }
    
    public function create($data){
        
    }
    
    public function edit($data){
        
    }
    
    public function remove($id){
        
    }
    
    public function get($id){
        
    }
    
    public function find($filter = null){
        
    }

}