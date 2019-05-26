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
    
    1. Продукт :
        - как правильно редактировать? (вопрос описал выше)
        - и нужно сделать чтобы при удалении продукта он удалялся из заказов
        - кста, а что делать если продукт удалился, а он в чьей-то корзине ))))))00000)000 
    2. Заказ с ним разобраться полностью, что там да как.
        2.1 сделать защиту от дурака. в каждом action приходит параметром $_request ($data). и там надо проверять нужные ключи, например $data['id'] 
        2.2 проверить формат всех ответов (структура отдаваемых массивов должна быть по тз) 
        2.3 провести краш тест каждого api метода 
    3. Составить документацию + заполнить базу тестовыми значениями по дефолту
    */

