<?php
/**
 * главный класс приложения, отвечает за роутинг (загрузку класса-контроллера и его метода)
 */
class Bootstrap
{
    public function __construct() {
        
        Model::initDatabase();
        //api fix
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('/api',$url)[1];
        $parts = explode('/', rtrim($url, '/'));

        if (!isset($parts[1]) || !isset($parts[2]) || !class_exists($controller_name = ucfirst($parts[1]).'Controller') || (!method_exists($controller = new $controller_name, $action = $parts[2]))) {
            echo 'Hello World';
            exit();
        } 
        
        try {
            $controller->$action($_REQUEST);
        } catch(Exception $ex) {
            Response::send(false, ['msg' => $ex->getMessage()]);
        }   

    }
    

}