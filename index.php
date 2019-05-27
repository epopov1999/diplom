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


