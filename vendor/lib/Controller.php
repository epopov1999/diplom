<?php
/**
* @todo сделать защиту от дурака
* в каждом action приходит параметром $_request ($data)
* и там надо проверять нужные ключи, например $data['id']
*/
/**
* @todo проверить формат всех ответов (структура отдаваемых массивов должна быть по тз)
*/
/**
* @todo сделать документацию по api
*/
class Controller
{
    public function __construct(){
        
    }
    
    protected function isAdmin() {
        $user = new UserModel();
        if(isset($_COOKIE['admintoken']) && $user->checkToken($_COOKIE['admintoken'])) { 
            return true;
        } 
        return false;
    }
}