<?php
namespace Admision\Fases\Models;

class FasesModel extends \Vendor\DataBase{
 
    /*para el grid*/
    private $_pDisplayStart;
    private $_pDisplayLength;
    private $_pSortingCols;
    private $_sExport;
    private $_pOrder;
    private $_pFilterCols;
    
    public function __construct() {
        parent::__construct();
        $this->_getPost();
    }
    
    
    private function _getPost(){
        
        $this->_pDisplayStart  =   Obj()->Get->getPost("pDisplayStart"); 
        $this->_pDisplayLength =   Obj()->Get->getPost("pDisplayLength"); 
        $this->_pSortingCols   =   Obj()->Get->getPost("pSortingCols");
        $this->_pOrder         =   Obj()->Get->getPost("pOrder");
        $this->_sExport        =   Obj()->Get->getPost("_sExport");
        $this->_pFilterCols    =   htmlspecialchars(trim(Obj()->AesCtr->de(Obj()->Get->getPost("pFilterCols"))),ENT_QUOTES);
    }
    
    public function getGrid(){
        $query = "EXEC sp_crmFasesGrid :iDisplayStart,:iDisplayLength,:pOrder,:pFilterCols,:sExport ;";
        $parms = array(
            ":iDisplayStart" => $this->_pDisplayStart,
            ":iDisplayLength" => $this->_pDisplayLength,
            ":pOrder" => $this->_pOrder,
            ":pFilterCols" => $this->_pFilterCols,
            ":sExport" => $this->_sExport
        );
        $data = $this->queryAll($query,$parms);
       
        return $data;
    }
    
}
