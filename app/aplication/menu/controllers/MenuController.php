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
    
    public function formEditMenu() {
        Obj()->View->render();
    }
    
    public function listaMenu() {
        Obj()->View->render();
    }
    
    public function postNewMenu() {
        echo json_encode(self::$menuModel->mantenimientoMenu());
    }
    
    public function postEditMenu() {
        echo json_encode(self::$menuModel->mantenimientoMenu());
    }
    
    public function postDeleteMenu() {
        echo json_encode(self::$menuModel->mantenimientoMenu());
    }
    
    public function postOrdenar() {
        echo json_encode(self::$menuModel->ordenar());
    }
    
    public function getMenuN($flag,$criterio='',$criterio2='') {
        return self::$menuModel->consultasMenu($flag,$criterio,$criterio2);
    }
    
    public function findMenu() {
        return self::$menuModel->consultasMenu(3,self::$menuModel->idMenu)[0];
    }
    
}
