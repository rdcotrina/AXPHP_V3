<?php
/**
 * Description of AccionController
 *
 * @author DAVID
 */
namespace Aplication\Accion\Controllers;

use Aplication\Accion\Filters\AccionFilter;

class AccionController extends \Vendor\Controller{
    
    use AccionFilter{
            AccionFilter::__construct as private __afConstruct;
        }
        
    private static $accionModel;

    public function __construct() {
        $this->__afConstruct();
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
        if($this->isValidate()){
            $data = self::$accionModel->mantenimientoAccion();
        }else{
            $data = $this->valida()->messages();
        }
            
        echo json_encode($data);
    }
    
    public function postDeleteAccion() {
        echo json_encode(self::$accionModel->mantenimientoAccion());
    }
    
    public function findAccion() {
        return self::$accionModel->findAccion();
    }
    
}
