<?php
/**
 * Description of Form
 *
 * @author DAVID
 */
namespace Vendor;

final class Get{
    
    private static $_instancias = array();
    
    public function __construct() {
        self::$_instancias[] = $this;
        if(count(self::$_instancias) > 1){
            throw new Exception('Error: class Get ya se instancio; para acceder a la instancia ejecutar: Obj::run()->NOMBRE_REGISTRO');
        }
    }
    
    public static function getPost($parametro){
                
        if(isset($_POST[$parametro]) && !empty($_POST[$parametro])){
            if(is_array($_POST[$parametro])){
                $p = array();
                foreach ($_POST[$parametro] as $value) {
                    $p[] = htmlspecialchars(trim($value),ENT_QUOTES);
                }
                $_POST[$parametro] = $p;
                return $_POST[$parametro];
            }else{
                return htmlspecialchars(trim($_POST[$parametro]),ENT_QUOTES);
            }
        }else{
            return false;
        }
    }
    
    public static function getRequest($parametro){
                
        if(isset($_REQUEST[$parametro]) && !empty($_REQUEST[$parametro])){
            if(is_array($_REQUEST[$parametro])){
                $p = array();
                foreach ($_REQUEST[$parametro] as $value) {
                    $p[] = htmlspecialchars(trim($value),ENT_QUOTES);
                }
                $_REQUEST[$parametro] = $p;
                return $_REQUEST[$parametro];
            }else{
                return htmlspecialchars(trim($_REQUEST[$parametro]),ENT_QUOTES);
            }
        }else{
            return false;
        }
    }
    
    public static function getAll($parametro){
                
        if(isset($_REQUEST[$parametro]) && !empty($_REQUEST[$parametro])){
            return $_REQUEST[$parametro];
        }else{
            return false;
        }
    }
    
}
