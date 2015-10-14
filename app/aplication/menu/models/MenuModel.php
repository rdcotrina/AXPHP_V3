<?php
/**
 * Description of MenuModel
 *
 * @author DAVID
 */
namespace Aplication\Menu\Models;

class MenuModel extends \Vendor\DataBase{
    
    private $_flag;
    public  $idMenu;
    private $_idSort;
    private $_menu;
    private $_titulo;
    private $_icono;
    private $_alias;
    private $_ajax;
    private $_estado;
    private $_nivel;
    private $_parent;
    private $_usuario;

    public function __construct() {
        parent::__construct();
        $this->_getPost();
    }
    
    private function _getPost(){
        $this->_flag     = Obj()->Get->getPost('_flag');
        $this->idMenu   = Obj()->Aes->de(Obj()->Get->getPost('_idMenu'));
        $this->_menu     = Obj()->Get->getPost(MENU.'txt_menu');
        $this->_titulo   = Obj()->Get->getPost(MENU.'txt_titulo');
        $this->_icono    = Obj()->Get->getPost(MENU.'txt_icono');
        $this->_alias    = Obj()->Get->getPost(MENU.'txt_alias');
        $this->_ajax     = Obj()->Get->getPost(MENU.'txt_ajax');
        $this->_estado   = Obj()->Get->getPost(MENU.'chk_activo');
        $this->_parent   = Obj()->Aes->de(Obj()->Get->getPost('_parent'));
        $this->_idSort   = Obj()->Get->getPost('_ids');
        $this->_nivel    = Obj()->Get->getPost('_nivel');
        $this->_usuario  = Obj()->Session->get('sys_persona');
    }
    
    public function mantenimientoMenu(){
        $query = "EXEC sp_maeMenuMantenimiento :flag,:key,:desc,:titulo,:alias,:ajax,:icono,:parent,:nivel,:estado,:usuario;";
        $parms = array(
            ':flag' => $this->_flag,
            ':key' => $this->idMenu,
            ':desc' => $this->_menu,
            ':titulo' => $this->_titulo,
            ':alias' => $this->_alias,
            ':ajax' => $this->_ajax,
            ':icono' => $this->_icono,
            ':parent' => $this->_parent,
            ':nivel' => $this->_nivel,
            ':estado'=>($this->_estado=='1')?'1':0,
            ':usuario' => $this->_usuario
        );
        return $this->queryOne($query,$parms);
    }
    
    public function consultasMenu($flag,$criterio='',$criterio2='') {
        $query = "EXEC sp_maeMenuConsultas :flag,:criterio,:criterio2;";
        $parms = array(
            ':flag' => $flag,
            ':criterio' => $criterio,
            ':criterio2' => $criterio2
        );
        return $this->queryAll($query,$parms);
    }
    
    public function ordenar(){
        $query = "EXEC sp_maeMenuOrdenar :flag,:ids,:nivel,:usuario;";
        $parms = array(
            ':flag' => $this->_flag,
            ':ids' => $this->_idSort,
            ':nivel' => $this->_nivel,
            ':usuario' => $this->_usuario
        );
        return $this->queryOne($query,$parms);
    }
    
}