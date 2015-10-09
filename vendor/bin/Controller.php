<?php
/**
 * Description of Controller
 *
 * @author DAVID
 */
namespace Vendor;

use Exception;

abstract class Controller {
    
    /*
     * A cada clase hija se le obliga a tener un metodo index()
     */
    abstract public function index(); 
    
    final protected function loadController($obj){
        foreach ($obj as $key => $value) {
            $module = $key;
            $c = explode('::',$value);
            $opcion = $c[0];
            $controller = $c[1];
        }
        
        $nameController  = Obj()->Tools->capitalize($controller);

        $url = ROOT . DEFAULT_APP_FOLDER . DS . strtolower($module) . DS . strtolower($opcion) . DS .'controllers' . DS . $nameController.'Controller.php';
        
        if(is_readable($url)){
            require_once $url;
            $class = '\\'.Obj()->Tools->capitalize($module).'\\'.Obj()->Tools->capitalize($opcion).'\\Controllers\\'.$nameController.'Controller';    #clase con namespace
            
            return new $class();    /*retorna instancia del objeto*/
        }else{
            throw new Exception('Error: Controlador <b>'.$url.'</b> no encontrado');
        }
    }

    final protected function redirect($ruta = false){
        if($ruta){
            header('location:' . BASE_URL . $ruta);
        }else{
            header('location:' . BASE_URL);
        }
    }
    
}
