<?php
/**
 * Description of View
 *
 * @author DAVID
 */
namespace Vendor;

use Exception;

final class View {
    
    public static function render($vista='',$ajax = true){       
        $rutaLayout = array(
            'img' => BASE_URL .'public/theme/' . DEFAULT_LAYOUT . '/img/',
            'css' => BASE_URL .'public/theme/' . DEFAULT_LAYOUT . '/css/',
            'js' => BASE_URL .'public/theme/' . DEFAULT_LAYOUT . '/js/'
        );
        
        
        /*detectar en que metodo se ejecuta render();*/
        $e = new Exception();
        $trace = $e->getTrace();
        $last_call = $trace[1]; /*trae datos de clase donde se ejecuta View->render()*/
        
        $clase = explode('\\',$last_call['class']);
        
        $module     = strtolower(array_shift($clase));
        $opcion     = strtolower(array_shift($clase));
        $controller = array_shift($clase);
        $controller = array_shift($clase);
      
        $controller = strtolower(substr($controller, 0, -10)); #obtiene el nombre de la clase sin: Controller, para la carpeta del modulo
        
        if(empty($vista)){
            $vista = $last_call['function']; #la vista debera tener el mismo nombre que la funcion donde se ejecuta View::render()
        }
     
        $urlVista = ROOT . DEFAULT_APP_FOLDER . DS . $module . DS . $opcion . DS . 'views' . DS . $controller . DS . $vista . '.phtml';
        
        if(is_readable($urlVista)){
            if($ajax){
                /*cuando peticion es via ajax no se necesita el header y el footer*/
                require_once ($urlVista);
            }else{
                require_once (ROOT . 'public'. DS .'theme' . DS . DEFAULT_LAYOUT . DS . 'header.php');
                require_once ($urlVista);
                require_once (ROOT . 'public'. DS .'theme' . DS . DEFAULT_LAYOUT . DS . 'footer.php');
            }
        }else{
            throw new Exception('Error: Vista <b>'.$urlVista.'</b> no encontrada .');
        }    
    }
    
}