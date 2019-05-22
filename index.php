<?php
    define('SEP',DIRECTORY_SEPARATOR);
    define('ROOT',__DIR__.SEP);
    define('VENDOR',ROOT.'vendor'.SEP);
    define('MODELS',VENDOR.'models'.SEP);
    define('LIB',VENDOR.'lib'.SEP);
    define('CONTROLLERS',VENDOR.'controllers'.SEP);

    define('ROOT_SITE',$_SERVER['DOCUMENT_ROOT'].SEP.'front'.SEP);

    function debug($data){
        echo '<pre>'; print_r($data); exit();
    }

    require_once('vendor/lib/Autoloader.php');
    new Bootstrap();
