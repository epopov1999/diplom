<?php

/**
* @class UserModel
*/
class UserModel extends Model
{
    public function auth($login, $password) {
        $data = $this->connect->query("SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");

        $data = $data->fetch_all(MYSQLI_ASSOC);
        return $data[0]['token'] ?? false;
    }
    
    public function checkToken($token) {
        $data = $this->connect->query("SELECT * FROM `users` WHERE `token` = '$token'");

        $data = $data->fetch_all(MYSQLI_ASSOC);
        return $data[0]['token'] ?? false;
    }
}