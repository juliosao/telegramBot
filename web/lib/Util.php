<?php

// Class autoloader
spl_autoload_register(function ($class) {

    $parts = explode('\\', $class);
    $path=__DIR__."/".implode('/',$parts).'.php';
    if(! include($path))
    {
        throw new Exception("Class not found: $class at $path" );
    }
    
});

require __DIR__."/../setup/cfg.php";

// Include path for clases, etc
set_include_path(
	get_include_path().PATH_SEPARATOR.
	__DIR__.PATH_SEPARATOR);

// Important for a lot of functions	
date_default_timezone_set('UTC');


