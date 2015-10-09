<?php

namespace Aplication\Accion\Models;

class AccionModel extends \Vendor\DataBase{
    
    private $_flag;
    private $_keyAccion;
    private $_accion;
    private $_alias;
    private $_icono;
    private $_theme;
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
        $this->_flag        = Obj()->Get->getPost('_flag');
        $this->_keyAccion   = Obj()->Aes->de(Obj()->Get->getPost('_idAccion'));
        $this->_accion      = Obj()->Get->getPost(AXI.'txt_accion');
        $this->_alias       = Obj()->Get->getPost(AXI.'txt_alias');
        $this->_icono       = Obj()->Get->getPost(AXI.'txt_icono');
        $this->_theme       = Obj()->Get->getPost(AXI.'txt_theme');
        $this->_estado      = Obj()->Get->getPost(AXI.'chk_activo');
        $this->_usuario     = Obj()->Session->get('sys_persona');
        
        $this->_pDisplayStart  =   Obj()->Get->getPost("pDisplayStart"); 
        $this->_pDisplayLength =   Obj()->Get->getPost("pDisplayLength"); 
        $this->_pSortingCols   =   Obj()->Get->getPost("pSortingCols");
        $this->_pOrder         =   Obj()->Get->getPost("pOrder");
        $this->_sExport        =   Obj()->Get->getPost("_sExport");
        $this->_pFilterCols    =   htmlspecialchars(trim(Obj()->AesCtr->de(Obj()->Get->getPost("pFilterCols"))),ENT_QUOTES);
    }
    
    public function getGridAcciones(){
        $query = "EXEC sp_sisAccionesGrid :iDisplayStart,:iDisplayLength,:pOrder,:pFilterCols,:sExport ;";
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
    
    public function consultasAlias($flag,$criterio=''){
        $query = "EXEC sp_sisAccionesConsultas :flag,:criterio ;";
        
        $parms = array(
            ":flag" => $flag,
            ":criterio" => $criterio
        );
        $data = $this->queryAll($query,$parms);
       
        return $data;
    }
    
    public function findAccion(){
        $query = "EXEC sp_sisAccionesConsultas :flag,:criterio ;";
        
        $parms = array(
            ":flag" => 2,
            ":criterio" => $this->_keyAccion
        );
        $data = $this->queryOne($query,$parms);
       
        return $data;
    }
    
    public function mantenimientoAccion() {
        $query = "EXEC sp_sisAccionesMantenimiento :flag,:key,:desc,:alias,:icono,:theme,:estado,:usuario ;";
        
        $parms = array(
            ":flag" => $this->_flag,
            ":key" => $this->_keyAccion,
            ":desc" => $this->_accion,
            ":alias" => $this->_alias,
            ":icono" => $this->_icono,
            ":theme" => $this->_theme,
            ":estado" => ($this->_estado == '1')?$this->_estado:'0',
            ":usuario" => $this->_usuario
        );
        $data = $this->queryOne($query,$parms);
       
        return $data;
    }
    
}