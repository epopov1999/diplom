<?php
    define('SEP',DIRECTORY_SEPARATOR);
    define('ROOT',__DIR__.SEP);
    define('VENDOR',ROOT.'vendor'.SEP);
    define('MODELS',VENDOR.'models'.SEP);
    define('LIB',VENDOR.'lib'.SEP);
    define('CONTROLLERS',VENDOR.'controllers'.SEP);


    function debug($data){
        echo '<pre>'; print_r($data); exit();
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    require_once('vendor/lib/Autoloader.php');
    new Bootstrap();
