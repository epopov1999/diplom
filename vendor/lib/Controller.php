<?php
/**
* родительский класс контроллер
*/
class Controller
{
    public function __construct(){
        
    }
    
    /**
    * проверяет куки браузера по ключу admintoken и сравнивает с админским токеном в базе
    */
    protected function isAdmin() {
        $user = new UserModel();
        if(isset($_COOKIE['admintoken']) && $user->checkToken($_COOKIE['admintoken'])) { 
            return true;
        } 
        return false;
    }

}