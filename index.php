<?php

    define('SEP',DIRECTORY_SEPARATOR);
    define('ROOT',__DIR__.SEP);
    define('VENDOR',ROOT.'vendor'.SEP);
    define('MODELS',VENDOR.'models'.SEP);
    define('LIB',VENDOR.'lib'.SEP);
    define('CONTROLLERS',VENDOR.'controllers'.SEP);
    
    require_once('vendor/lib/Functions.php');

    require_once('vendor/lib/Autoloader.php');

    new Bootstrap();

    /**
    
    @todo
    
    1. В корзине (в моделе или в контроллере) есть todo, посмотри там нужно обработать пару сценариев.
    2. Разобраться с заказом. Как его получать, по id, по токену, или что там.
    3. Проверить все контроллеры и все модели (кроме категории) 
        3.1 сделать защиту от дурака. в каждом action приходит параметром $_request ($data). и там надо проверять нужные ключи, например $data['id'] 
        3.2 проверить формат всех ответов (структура отдаваемых массивов должна быть по тз) 
        3.3 провести краш тест каждого api метода 
    4. сделать документацию по api
    
    */

