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
    protected $connect;

    function __construct(){
        $this->connect = new mysqli($this->hostName, $this->user, $this->password, $this->db);
        $this->connect->set_charset('utf8');
    }
    
    public function create($data){
        
    }
    
    public function edit($id, $data){
        
    }
    
    public function remove($id){
        
    }
    
    public function get($id){
        
    }
    
    public function find(){
        
    }


    
}