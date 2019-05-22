<?php
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