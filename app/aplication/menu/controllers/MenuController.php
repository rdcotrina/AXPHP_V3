<?php
/**
 * Description of MenuController
 *
 * @author DAVID
 */
namespace Aplication\Menu\Controllers;

class MenuController extends \Vendor\Controller{
    
    private static $menuModel;

    public function __construct() {
        self::$menuModel = Obj()->Model->loadModel();
    }
    
    public function index() {
        Obj()->View->render();
    }
    
    public function formNewMenu() {
        Obj()->View->render();
    }
    
    public function listaMenu() {
        Obj()->View->render();
    }
    
    public function postNewMenu() {
        echo json_encode(self::$menuModel->mantenimientoMenu());
    }
    
    public function getMenuN($flag,$criterio='',$criterio2='') {
        return self::$menuModel->consultasMenu($flag,$criterio,$criterio2);
    }
    
}
