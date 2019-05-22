<?php
/**
 * класс загрузчик, который определяет, 
 * какой route нужно создать для обработки запроса
 */
class Bootstrap
{
    public function __construct() {
        $parts = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
        $controller_name = ucfirst($parts[1]).'Controller';
        $action = $parts[2];
        $data = $parts[3];
        $controller = new $controller_name;
        $controller->$action($data);
    }
}