<?php
/**
 * класс загрузчик, который определяет, 
 * какой route нужно создать для обработки запроса
 */
class Bootstrap
{
//    private $routingTable = [
//        'POST' => 'PostRoute',
//        'GET' => 'GetRoute',
//        'DELETE' => 'DeleteRoute'
//    ];

    public function __construct(){
//        $route = new $this->routingTable[$_SERVER['REQUEST_METHOD']];
        /**
        * @todo
        * здесь парсим url по сегментам (функция php - explode()), где / - разделитель
        * первый сегмент - $controller_name, второй - $action_name, все остальные - в $data_array
        * и делаем new $controller_name->$action_name($data_array);
        */
    }
}