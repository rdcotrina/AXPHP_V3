<?php
/**
 * Description of AccionController
 *
 * @author DAVID
 */
namespace Aplication\Accion\Controllers;

class AccionController extends \Vendor\Controller{
    
    private static $accionModel;

    public function __construct() {
        self::$accionModel = Obj()->Model->loadModel();
    }
    
    public function index() {
        Obj()->View->render();
    }
    
    public function getGridAcciones(){
        $data =  self::$accionModel->getGridAcciones();
        foreach ($data as $key=>$value) {
            $data[$key]['idaccion'] = Obj()->AesCtr->en($value["idaccion"]);
        }
        echo json_encode($data);
    }
    
    public function getAlias(){
        $data =  self::$accionModel->consultasAlias(1);

        $res = array(
            'dataServer'=>$data, 
            'field'=> Obj()->Get->getPost('_field'),
            'opt'=>Obj()->Get->getAll('_options')
        );

        echo json_encode($res);
    }
    
    public function formNewAccion() {
        Obj()->View->render();
    }
    
    public function formEditAccion() {
        Obj()->View->render();
    }
    
    public function postMantenimientoAccion() {
        echo json_encode(self::$accionModel->mantenimientoAccion());
    }
    
//    public function postEditAccion() {
//        echo json_encode(self::$accionModel->mantenimientoAccion());
//    }
    
    public function findAccion() {
        return self::$accionModel->findAccion();
    }
    
}
