<?php

define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/AXPHP_V3/');            #raiz del proyecto
define('DEFAULT_APP_FOLDER', 'app');                                         #carpeta de la aplicacion
define('DEFAULT_MODULE', 'aplication');                                      #modulo por defecto, actua como NAMESPACE
define('DEFAULT_OPCION', 'index');                                           #opcion por defecto, esta dentro de un NAMESPACE (modulo)
define('DEFAULT_CONTROLLER', 'index');                                       #controlador por defecto
define('DEFAULT_METHOD', 'index');                                           #metodo por defecto
define('DEFAULT_LAYOUT', 'smartadmin');                                      #nombre de template html

define('APP_NAME', 'AXPHP FW V3');
define('APP_COMPANY', 'www.axphp.com');
define('APP_KEY', 'adABKCDLZEFXGHIJ');                                       #llave para AES
define('APP_PASS_KEY', '99}dF7EZbnbXOkojf&dzvxd5q#guPbPK1spU75Jm|N79Ii7PK'); #llave para concatenar al md5
define('APP_COPY', 'ERP SOLUTION');
define('APP_LANG', 'ES');                                                    #idioma del sistema

define('DB_ENTORNO', 'D');                                                   #D=DESARROLLO, P=PRODUCCION
define('DB_MOTOR', 'sql');
define('DB_HOST', 'WIN-UUF8TPB3RS5');
define('DB_USER', 'sa');
define('DB_PASS', '123');
define('DB_NAME', 'erpsolution');

define('DB_PORT', '3306');
define('DB_CHARSET', 'utf8');
define('DB_COLLATION', 'utf8_unicode_ci');


require_once ROOT . 'config' . DS . 'AutoloadVendor.php';
require_once ROOT . 'config' . DS . 'AutoloadLibraries.php';
require_once ROOT . 'config' . DS . 'lang' . DS . 'php' . DS . 'lang_' . APP_LANG . '.php';
require_once ROOT . 'config' . DS . 'prefix' . DS . 'PrefixPHP.php';

use Vendor\Obj;

/*
 * Funcion que retorna objeto con el cual permite acceder a todas las clases registradas
 * Es de ambito general, funciona en todo el sistema
 */

function Obj() {
    return Obj::run();
}
