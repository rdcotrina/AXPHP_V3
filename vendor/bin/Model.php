<?php
/**
 * Description of Model
 *
 * @author DAVID
 */
namespace Vendor;

use Exception;

class Model {
    
    final public static function loadModel() {
        $e = new Exception();
        $trace = $e->getTrace();
        $last_call = $trace[1]; /*trae datos de clase donde se ejecuta View->render()*/
        
        $clase = explode('\\',$last_call['class']);
        
        $module     = strtolower(array_shift($clase));
        $opcion     = strtolower(array_shift($clase));
        $controller = array_shift($clase);
        $controller = array_shift($clase);
      
        $model = substr($controller, 0, -10); #obtiene el nombre de la clase sin: Controller, para la carpeta del modulo
        $nameModel  = Obj()->Tools->capitalize($model);

        $urlModel = ROOT . DEFAULT_APP_FOLDER . DS . $module . DS . $opcion . DS .'models' . DS . $nameModel.'Model.php';
        
        if(is_readable($urlModel)){
            require_once $urlModel;
            $class = '\\'.Obj()->Tools->capitalize($module).'\\'.Obj()->Tools->capitalize($opcion).'\\Models\\'.$nameModel.'Model';    #clase con namespace
            
            return new $class();    /*retorna instancia del objeto*/
        }else{
            throw new Exception('Error: Modelo <b>'.$urlModel.'</b> no encontrado');
        }
    }
    
}
