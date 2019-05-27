<?php

class AuthController extends Controller 
{
    /**
    * метод авторизации, ожидает параметры login, password, 
    * получает по ним токен и устанавливает его в куки
    */
    public function login($data) {
        $user = new UserModel();
        $token = $user->auth($data['login'], $data['password']);
        if ($token) {
            setcookie('admintoken', $token, time()+3600*3+60*15, '/');  
            Response::send(true, ['msg' => 'Успешная авторизация','token' => $token]);
        } throw new Exception('Ошибка авторизации');
    }
    
    /**
    * метод деавторизации, очищает куки по ключу
    */
    public function logout() {
//        unset($_COOKIE['admintoken']);
        setcookie("admintoken", "", time()-3600*3+60*15, '/');
        Response::send(true, 'Вы успешно деавторизовались');
    }
}