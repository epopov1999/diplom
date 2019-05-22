<?php
/**
 * класс загрузчик
 */
class Bootstrap
{
    public function __construct() {
        debug($_COOKIE['admintoken']);
        $parts = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
        $controller_name = ucfirst($parts[1]).'Controller';
        $action = $parts[2];
        $data = $parts[3];
        $controller = new $controller_name;
        if ($controller_name == 'AuthController') {
//            if ($action == 'logout') $controller->logout();
            $controller->auth($_REQUEST);
        } else {
            $controller->$action($_REQUEST);
        }
    }
}