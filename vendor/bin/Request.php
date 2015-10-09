<?php
/**
 * Description of Request
 *
 * @author DAVID
 */
namespace Vendor;

final class Request {
    
    private $_module;
    private $_opcion;
    private $_controller;
    private $_method;
    private $_arguments;
    
    public function __construct() {
        if(isset($_GET['url'])){    #captura la url de .htaccess
            $url = $_GET['url'];
            $url = explode('/',$url);
            $url = array_filter($url);

            $this->_module     = strtolower(array_shift($url));     #el nombre de la carpeta de los modulos deben estar en minusculas
            $this->_opcion     = strtolower(array_shift($url));     #el nombre de la carpeta de las opciones deben estar en minusculas
            $this->_controller = array_shift($url);
            $this->_method     = array_shift($url);
            $this->_arguments  = $url;
            
        }
        
        if(!$this->_module){
            $this->_module = DEFAULT_MODULE;   
        }
        
        if(!$this->_opcion){
            $this->_opcion = DEFAULT_OPCION;   
        }
        
        if(!$this->_controller){
            $this->_controller = DEFAULT_CONTROLLER;   
        }
        
        if(!$this->_method){
            $this->_method = DEFAULT_METHOD;   
        }
        
        if(!$this->_arguments){
            $this->_arguments = [];   
        }        
    }
    
    public function getModule() {
        return $this->_module;
    }
    
    public function getOpcion() {
        return $this->_opcion;
    }
    
    public function getController() {
        return $this->_controller;
    }
    
    public function getMethod() {
        return $this->_method;
    }
    
    public function getArgs() {
        return $this->_arguments;
    }
    
}
