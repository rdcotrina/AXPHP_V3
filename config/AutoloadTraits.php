<?php

/*autolod para bin*/
function autoloadTrait($class){
    $cad = explode('\\', $class);
    if(isset($cad[2])){
        $file = ROOT . 'vendor'. DS .'trait' . DS . $cad[2].'.php';
        if(file_exists($file)){
            require_once ($file);
        }
    }
}

/*se registra la funcion autoload*/
spl_autoload_register('autoloadTrait'); 