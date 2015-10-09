<?php
/**
 * Description of MenuModel
 *
 * @author DAVID
 */
namespace Aplication\Menu\Models;

class MenuModel extends \Vendor\DataBase{
    
    private $_flag;
    private $_idMenu;
    private $_menu;
    private $_titulo;
    private $_icono;
    private $_alias;
    private $_ajax;
    private $_activo;
    private $_nivel;
    private $_parent;
    private $_usuario;

    public function __construct() {
        parent::__construct();
        $this->_getPost();
    }
    
    private function _getPost(){
        $this->_flag     = Obj()->Get->getPost('_flag');
        $this->_idMenu   = Obj()->Aes->de(Obj()->Get->getPost('_idMenu'));
        $this->_menu     = Obj()->Get->getPost(MENU.'txt_menu');
        $this->_titulo   = Obj()->Get->getPost(MENU.'txt_titulo');
        $this->_icono    = Obj()->Get->getPost(MENU.'txt_icono');
        $this->_alias    = Obj()->Get->getPost(MENU.'txt_alias');
        $this->_ajax     = Obj()->Get->getPost(MENU.'txt_ajax');
        $this->_activo   = Obj()->Get->getPost(MENU.'chk_activo');
        $this->_parent   = Obj()->Aes->de(Obj()->Get->getPost('_parent'));
        $this->_nivel    = Obj()->Get->getPost('_nivel');
        $this->_usuario  = Obj()->Session->get('sys_persona');
    }
    
    public function mantenimientoMenu(){
        $query = "EXEC sp_maeMenuMantenimiento :flag,:key,:desc,:titulo,:alias,:ajax,:icono,:parent,:nivel,:usuario;";
        $parms = array(
            ':flag' => $this->_flag,
            ':key' => $this->_idMenu,
            ':desc' => $this->_menu,
            ':titulo' => $this->_titulo,
            ':alias' => $this->_alias,
            ':ajax' => $this->_ajax,
            ':icono' => $this->_icono,
            ':parent' => $this->_parent,
            ':nivel' => $this->_nivel,
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
//                print_r($parms);
        return $this->queryAll($query,$parms);
    }
    
}
