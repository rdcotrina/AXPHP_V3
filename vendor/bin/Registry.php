<?php
/**
 * Description of Registry
 *
 * @author DAVID
 */
namespace Vendor;

use Exception;

final class Registry {
    
    public static $get;
    
    private static $_instancias = array();
    
    /** 
     * Registra variables y objetos         
     */ 
    static private $registry = array();  
   
    /*
     * No se puede instanciar
     */
    private function __construct() {}

    /*
     * Inicia el singleton
     */
    public static function init() {
        if(!self::$get){
            self::$get = Singleton::getInstancia();
        }
    }
    
    /*
     * Para el registro de nuestras clases
     */
    public static function addClass($class,$namespace){
        self::init();
        if(!self::$get->$class){
            /*el objeto se instancia solo una vez*/
            self::$get->$class = new $namespace;
        }else {  
            throw new Exception('Error: Clase <b>'.$class.'</b> ya se registro. Acceda con <b>Obj::run()->NAMECLASS</b>');
        }  
    }
    
    public static function singleton($class=''){
        if(!empty($class)){
            if(in_array($class, self::$_instancias)){
                 throw new Exception('Error: objeto <b>'.$class.'</b> ya se instancio, para acceder hacerlo es a travez de su Controlador.');
            }else{
                self::$_instancias[$class] = $class;
            }
        }
    }
    
    /** 
     * Método que añade objetos
     * Recibe el objeto (por referencia) y la clave
     * Devuelve un booleano para confirmar si se ha insertado
     * o si en cambio estaba duplicado.
     */ 
    public static function add($key, $elemento){  
        if (!self::exists($key)) {  
            self::$registry[$key] = $elemento;  
            return true;  
        } else {  
            throw new Exception('Error: <b>'.$key.'</b> ya se registro.');
        }  
    }  
   
    /** 
     * Función que comprueba la existencia de una clave.
     * Devuelve un booleano confirmando si existe o no.
     */ 
    public static function exists($key){  
        return array_key_exists($key, self::$registry);  
    }  
   
    /** 
     * Función que devuelve un item dada la clave          
     */ 
    public static function get($key){  
        if (self::exists($key)) {  echo self::$registry[$key];
            return self::$registry[$key];  
        } else {  
            throw new Exception('Error: Clase <b>'.$key.'</b> no existe.');
        }  
    }  
   
    /** 
     * Elimina una entrada recibiendo su clave y devuelve confirmación.
     * Si la clave no existe devuelve false.
     */ 
    public static function remove($name){  
        if (self::exists($name)) {  
            unset(self::$registry[$name]);
            return true;  
        } else {
            throw new Exception('Error: Clase <b>'.$name.'</b> no existe.');
        }  
    }  
   
    /** 
     * Limpia el registro totalmente.         
     */ 
    public static function clear(){  
        self::$registry = array();  
    }  
    
}  