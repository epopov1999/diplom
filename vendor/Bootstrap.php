<?php
/**
 * главный класс приложения, отвечает за роутинг (загрузку класса-контроллера и его метода)
 */
class Bootstrap
{
    public function __construct() {
        
        Model::initDatabase();
        
        $parts = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));

        if (!isset($parts[1]) || !isset($parts[2]) || !class_exists($controller_name = ucfirst($parts[1]).'Controller') || (!method_exists($controller = new $controller_name, $action = $parts[2]))) {
            echo 'Hello World';
            exit();
        } else {
            $controller->$action($_REQUEST);
        }
    }
    

}