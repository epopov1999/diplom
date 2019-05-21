<?php
/**
 * класс взаимодействия с БД, с методами функционала API
 */
class Model
{
    private $db = 'shop';
    private $user = 'root';
    private $password = '';
    private $hostName = 'localhost';
    private $connect;

    function __construct(){
        $this->connect = new mysqli($this->hostName, $this->user, $this->password, $this->db);
        $this->connect->set_charset('utf8');
    }
    
    public function create($data){
        
    }
    
    public function edit($id){
        
    }
    
    public function remove($id){
        
    }
    
    public function get($id){
        
    }
    
    public function find(){
        
    }

//    function authorization($login, $password){
//        $data = $this->connect->query("SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
//        
//        $data = $data->fetch_all(MYSQLI_ASSOC);
//
//        return $data[0]['token'] ?? false;
//    }
//
//    function checkToken($accessToken) {
//        $result = $this->connect->query("SELECT * FROM `users` WHERE `token` = '$accessToken'");
//        $token = $result->fetch_all(MYSQLI_ASSOC);
//        return $token ?? false;
//    }
//    
//    function createPost($title, $anons, $text, $image){
//        //database time format
//        $date = date("Y-m-d H:i:s");
//        $result = $this->connect->query("
//            INSERT INTO `posts`(`title`, `anons`, `text`, `image`,`date`) VALUES ('$title','$anons','$text','$image','$date')
//        ");
//
//        $post_id = $this->connect->insert_id;
//        if(!$post_id) {
//            throw new Exception($this->connect->error);
//            return false;
//        }
//
//        return $post_id;
//    }
    
}