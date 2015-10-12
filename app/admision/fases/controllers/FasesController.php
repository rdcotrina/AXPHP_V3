<?php
namespace Admision\Fases\Controllers;

class FasesController extends \Vendor\Controller{
    
    private static $faseModel;

    public function __construct() {
        self::$faseModel = Obj()->Model->loadModel();
    }
    
    public function index() {
        Obj()->View->render();
    }
    
    public function getGridFases() {
        $data =  self::$faseModel->getGrid();
        foreach ($data as $key=>$value) {
            $data[$key]['idfase'] = Obj()->AesCtr->en($value["idfase"]);
        }
        echo json_encode($data);
    }
    
}
