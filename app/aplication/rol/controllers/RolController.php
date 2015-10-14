<?php
/**
 * Description of RolController
 *
 * @author DAVID
 */
namespace Aplication\Rol\Controllers;

use Aplication\Rol\Filters\RolFilter;

class RolController extends \Vendor\Controller{
    
    use RolFilter{
        RolFilter::__construct as __rfConstruct;
    }
    
    private static $rolModel;
    
    public function __construct() {
        $this->__rfConstruct();
        self::$rolModel = Obj()->Model->loadModel();
    }
    
    public function index() {
        Obj()->View->render();
    }
    
    public function getGrid() {
        $data =  self::$rolModel->getGrid();
        foreach ($data as $key=>$value) {
            $data[$key]['idrol'] = AesCtr::en($value["idrol"]);
        }
        echo json_encode($data);
    }
    
}
