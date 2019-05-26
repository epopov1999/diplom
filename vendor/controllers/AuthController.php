<?php

class AuthController extends Controller 
{
    public function login($data) {
        $user = new UserModel();
        $token = $user->auth($data['login'], $data['password']);
        if ($token) {
            setcookie('admintoken', $token, time()+3600*3+60*15, '/');  
            Response::send(true, ['msg'=>'Успешная авторизация','token'=>$token]);
        } throw new Exception('Ошибка авторизации');
    }
    
    public function logout() {
//        unset($_COOKIE['admintoken']);
        setcookie("admintoken", "", time()-3600*3+60*15, '/');
        Response::send(true, 'Вы успешно деавторизовались');
    }
}