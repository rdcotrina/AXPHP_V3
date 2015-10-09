<?php
/**
 * Description of IndexController
 *
 * @author DAVID
 */

namespace Aplication\Index\Controllers;

class IndexController extends \Vendor\Controller{
    
    private static $modelIndex;
    
    private static $login;

    public function __construct() {
        self::$modelIndex = Obj()->Model->loadModel();
        self::$login = $this->loadController(['aplication' => 'index::Login']);
//        $rr = $this->loadController(['logistica' => 'almacen::Almacenero']);#llamando controller externo
    }

    public function index() {
//        Obj()->Session->destroy();
        if(Obj()->Session->get('sys_idUsuario')){  
            Obj()->Session->set('sys_menu', $this->getMenu());
            Obj()->View->render('index',false);
        }else{
            self::$login->index();
        }
    }
    
    public function getMenu() {
        return self::$modelIndex->consultas(1,Obj()->Session->get('sys_defaultRol'));
    }
    
    public function menu() {
        Obj()->View->render();
    }
    
    public function getAccionesOpcion($opcion) {
        return self::$modelIndex->consultas(2,$opcion);
    }
    
}
