<?php

define('DS',DIRECTORY_SEPARATOR);
define('ROOT',  realpath(dirname(__FILE__)) . DS);

require_once (ROOT . 'config' . DS . 'Config.php');

try{
    /*registro de clases*/
    \Vendor\Registry::addClass('Registry','\\Vendor\\Registry');
    \Vendor\Registry::addClass('Model','\\Vendor\\Model');
    \Vendor\Registry::addClass('View','\\Vendor\\View');    
    \Vendor\Registry::addClass('Session','\\Vendor\\Session');
    \Vendor\Registry::addClass('Request','\\Vendor\\Request');
    \Vendor\Registry::addClass('Bootstrap','\\Vendor\\Bootstrap');
    \Vendor\Registry::addClass('Tools','\\Vendor\\Tools');
    \Vendor\Registry::addClass('Get','\\Vendor\\Get');
    \Vendor\Registry::addClass('Aes','\\Libs\\Aes');
    \Vendor\Registry::addClass('AesCtr','\\Libs\\AesCtr');
    \Vendor\Registry::addClass('BuiltForm','\\Libs\\BuiltForm');
    
    Obj()->Session->init();
    
    Obj()->Bootstrap->run(); 
}catch (Exception $e){
    echo $e->getMessage();
}