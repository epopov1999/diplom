<?php
/**
* @todo перенести базу данных на sqlite
* изменить конструктор этого класса $this->connect = ... {$db из скрипта /lib/Database.php}
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
//        $this->connect = new mysqli($this->hostName, $this->user, $this->password, $this->db);
//        $this->connect->set_charset('utf8');
//    }
    
    protected $connect;
    private $dbfile = 'C:\OSPanel\domains\popov_exam.ru\database\shop.db';
    
    /**
    * инициализация базы данных sqlite3
    */
    public function __construct() {
        $this->connect = new SQLite3($dbfile);
        if (!file_exists($dbfile)) {
            $sql="CREATE TABLE `categories` (
                `id` INTEGER PRIMARY KEY,
                `name` TEXT NOT NULL
            )";
            $this->connect->query($sql);
            $sql="CREATE TABLE `customers` (
              `id` INTEGER PRIMARY KEY,
              `name` TEXT NOT NULL,
              `email` TEXT NOT NULL,
              `token` TEXT NOT NULL
            )";
            $this->connect->query($sql);
            $sql="CREATE TABLE `orders` (
              `id` INTEGER PRIMARY KEY,
              `customer_id` INTEGER NOT NULL,
              FOREIGN KEY (`customer_id`) REFERENCES customers(id)
            )";
            $this->connect->query($sql);
            $sql="CREATE TABLE `orders_products` (
                `order_id` INTEGER NOT NULL,
                `product_id` INTEGER NOT NULL,
                `lic` TEXT NOT NULL,
                `count` INTEGER NOT NULL,
                FOREIGN KEY (`order_id`) REFERENCES orders(id),
                FOREIGN KEY (`product_id`) REFERENCES products(id)
            )";
            $this->connect->query($sql);
            $sql="CREATE TABLE `prices` (
              `id` INTEGER PRIMARY KEY,
              `product_id` INTEGER NOT NULL,
              `license` TEXT NOT NULL,
              `sum` REAL NOT NULL,
              FOREIGN KEY (`product_id`) REFERENCES products(id)
            )";
            $this->connect->query($sql);
            $sql="CREATE TABLE `products` (
              `id` INTEGER PRIMARY KEY,
              `category_id` INTEGER NOT NULL,
              `name` TEXT NOT NULL,
              FOREIGN KEY (`category_id`) REFERENCES categories(id)
            )";
            $this->connect->query($sql);
            $sql="CREATE TABLE `users` (
              `id` INTEGER PRIMARY KEY,
              `login` TEXT NOT NULL,
              `password` TEXT NOT NULL,
              `token` TEXT NOT NULL
            )";
            $this->connect->query($sql);
            
            $sql = "INSERT INTO `users` (`login`,`password`,`token`) VALUES ('admin','popov','123sobaka123')";
            $this->connect->query($sql);
            $sql = "INSERT INTO `users` (`login`,`password`,`token`) VALUES ('moder','mussa','test')";
            $this->connect->query($sql);
        }
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