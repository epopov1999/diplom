<?php
/**
 * класс загрузчик
 */
class Bootstrap
{
    /**
    * @todo отладить роутинг (проверять action)
    */
    public function __construct() {
        $parts = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
        
        if (!isset($parts[1]) || !class_exists($controller_name = ucfirst($parts[1]).'Controller')){
            echo 'Hello World';
        } else {
            $action = $parts[2];
            $data = $parts[3];
            $controller = new $controller_name;
            if ($controller_name == 'AuthController') {
                if ($action == 'logout') $controller->logout();
                $controller->auth($_REQUEST);
            } else {
                $controller->$action($_REQUEST);
            }
        }
    }
}