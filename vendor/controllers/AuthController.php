<?php

class AuthController extends Controller 
{
    public function auth($data) {
        $user = new UserModel();
        $token = $user->auth($data['login'], $data['password']);
        if ($token) {
            if(!isset($_COOKIE['admintoken'])) {
                setcookie('admintoken', $token);  
            }
            Response::send(true, 'Успешная авторизация');
        } Response::send(false, 'Ошибка авторизации');
    }
    
//    public function logout() {
//        unset($_COOKIE['admintoken']);
//        setcookie("admintoken", null);
//        Response::send(true, 'Вы успешно деавторизовались');
//    }
}