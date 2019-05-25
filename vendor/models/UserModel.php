<?php

/**
* @class UserModel
*/
class UserModel extends Model
{
    public function auth($login, $password) {
        $get_all = $this->connect->query("SELECT * FROM `users`");
        $get_token = $this->connect->query("SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
        $token = $get_token->fetchAll(PDO::FETCH_ASSOC);
        return $token[0]['token'] ?? false;
    }
    
    public function checkToken($token) {
        $data = $this->connect->query("SELECT * FROM `users` WHERE `token` = '$token'");

        $data = $data->fetchAll(PDO::FETCH_ASSOC);
        return $data[0]['token'] ?? false;
    }
}