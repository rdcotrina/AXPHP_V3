<?php
/**
 * Description of IndexModel
 *
 * @author DAVID
 */
namespace Aplication\Index\Models;

class IndexModel extends \Vendor\DataBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function consultas($flag,$criterio='') {
        $query = "EXEC sp_maeIndexMenuConsultas :flag,:criterio ;";
        $parms = array(
            ':flag' => $flag,
            ':criterio' => $criterio
        );
        $data = $this->queryAll($query, $parms);
        return $data;
    }
    
}
