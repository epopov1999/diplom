<?php

/**
* @class UserModel
*/
class UserModel extends Model
{
    public function auth($login, $password) {
        $get_all = $this->connect->query("SELECT * FROM `users`");
        debug($get_all->fetchArray(SQLITE3_ASSOC));
        $get_token = $this->connect->query("SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
        $token = $get_token->fetchArray(SQLITE3_ASSOC);
        debug($token);
        return $token[0]['token'] ?? false;
    }
    
    public function checkToken($token) {
        $data = $this->connect->query("SELECT * FROM `users` WHERE `token` = '$token'");

        $data = $data->fetch_all(SQLITE3_ASSOC);
        return $data[0]['token'] ?? false;
    }
}