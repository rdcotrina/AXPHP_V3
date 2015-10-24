<?php
/* 
* ---------------------------------------
* --------- CREATED BY GS ----------
* fecha:        24-10-2015 16:10:35 
* Descripcion : ModalidadAdmisionController.php
* ---------------------------------------
*/ 
namespace Admision\Ingreso\Controllers;
    
use Admision\Ingreso\Filters\ModalidadAdmisionFilter;

class ModalidadAdmisionController extends \Vendor\Controller{

    use ModalidadAdmisionFilter{
            ModalidadAdmisionFilter::__construct as private __fConstruct;
        }
        
    private static $ingresoModel;
       
    public function __construct() {
        $this->__fConstruct();
        self::$ingresoModel = Obj()->Model->loadModel();
    }
    
    public function index() {
        Obj()->View->render();
    }
    
    public function getGrid(){
        $data =  self::$ingresoModel->getGrid();
        foreach ($data as $key=>$value) {
            $data[$key]["IDCAMPO"] = Obj()->AesCtr->en($value["IDCAMPO"]);
        }
        echo json_encode($data);
    }
    
    public function formNew() {
        Obj()->View->render();
    }
    
    public function formEdit() {
        Obj()->View->render();
    }
    
    public function postMantenimiento() {
        if($this->isValidate()){
            $data = self::$ingresoModel->mantenimiento();
        }else{
            $data = $this->valida()->messages();
        }
            
        echo json_encode($data);
    }
    
    public function postDelete() {
        echo json_encode(self::$ingresoModel->mantenimiento());
    }
    
    public function find() {
        return self::$ingresoModel->find();
    }
    
}
