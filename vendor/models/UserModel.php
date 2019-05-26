<?php

/**
* @class UserModel
*/

class UserModel extends Model
{
    public function __construct() {
        parent::__construct();
        $this->table = 'users';
    }
    
    public function auth($login, $password) {
        $get_token = $this->connect->query("SELECT * FROM `$this->table` WHERE `login` = '$login' AND `password` = '$password'");
        return ($get_token) ? $get_token->fetchAll(PDO::FETCH_ASSOC)[0]['token'] : false;
    }
    
    public function checkToken($token) {
        $result = $this->connect->query("SELECT * FROM `$this->table` WHERE `token` = '$token'");
        return ($result) ? $result->fetchAll(PDO::FETCH_ASSOC)[0]['token'] : false;
    }
}