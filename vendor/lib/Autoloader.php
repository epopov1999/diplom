<?php
    /**
    * autoloder function
    * перебирает все допустимые папки, полученные из пользовательских констант (описаны в файле index.php)
    * и подключает классы, которые находятся в них
    */
    spl_autoload_register(function($className) {
        $constants = get_defined_constants(true);
	    foreach ($constants['user'] as $module) {
	        $file = $module.$className.'.php';
            if (file_exists($file)) {
                include_once($file);
                return true;
            }
	    }
    });     
?>