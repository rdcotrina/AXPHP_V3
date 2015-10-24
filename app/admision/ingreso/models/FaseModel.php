<?php
/* 
* ---------------------------------------
* --------- CREATED BY GS ----------
* fecha:        24-10-2015 16:10:26 
* Descripcion : FaseModel.php
* ---------------------------------------
*/ 

namespace Admision\Ingreso\Models;
    
class FaseModel extends \Vendor\DataBase{

    private $_flag;
    private $_primaryKey;
    private $_descripcion;
    private $_estado;
    private $_usuario;

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
        $this->_flag        = Obj()->Get->getPost("_flag");
        $this->_primaryKey  = Obj()->Aes->de(Obj()->Get->getPost("_primaryKey"));
        $this->_descripcion = Obj()->Get->getPost(FASE."txt_descripcion");
        $this->_estado      = Obj()->Get->getPost(FASE."chk_activo");
        $this->_usuario     = Obj()->Session->get("sys_persona");
        
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
    
    public function mantenimiento() {
        $query = "EXEC sp_crmFaseMantenimiento :flag,:primaryKey,:descripcion,:estado,:usuario ;";
        
        $parms = array(
            ":flag" => $this->_flag,
            ":primaryKey" => $this->_primaryKey,
            ":descripcion" => $this->_descripcion,
            ":estado" => ($this->_estado == 1)?$this->_estado:'0',
            ":usuario" => $this->_usuario
        );
        $data = $this->queryOne($query,$parms);
       
        return $data;
    }
    
    public function find() {
        $query = "EXEC sp_sisConsultas :flag,:primaryKey ;";
        
        $parms = array(
            ":flag" => 1,
            ":primaryKey" => $this->_primaryKey
        );
        $data = $this->queryOne($query,$parms);
       
        return $data;
    }
    
}