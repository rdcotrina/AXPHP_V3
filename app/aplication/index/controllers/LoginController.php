<?php
/**
 * Description of LoginController
 *
 * @author DAVID
 */
namespace Aplication\Index\Controllers;

class LoginController extends \Vendor\Controller{
    
    private static $modelLogin;

    public function __construct() {
        self::$modelLogin = Obj()->Model->loadModel();
    }
    
    public function index() {
        Obj()->View->render('index',false);
    }
    
    public function postLogin() {
        $data = self::$modelLogin->loginUser();
        
        if(isset($data['rowCount']) && abs($data['rowCount']) > 0){
            $data = $data['data'];
            Obj()->Session->set('sys_idUsuario', $data['idusuario']);
            Obj()->Session->set('sys_persona', $data['persona']);
            Obj()->Session->set('sys_usuario', $data['usuario']);
            Obj()->Session->set('sys_nombreUsuario', 'usuario cambiar'); #$data['nombre_completo']
            self::$modelLogin->postLastLogin();
            /*los roles*/
            Obj()->Session->set('sys_roles', self::$modelLogin->getRoles());
            /*asignando rol por defecto*/
            $rol = Obj()->Session->get('sys_roles');
            Obj()->Session->set('sys_defaultRol',$rol[0]['idrol']);
            Obj()->Session->set('sys_defaultNameRol',$rol[0]['rol']);
        }else{
            $data = $data['data'];
        }

        echo json_encode($data);
    }
    
    public function postLogout(){
        Obj()->Session->destroy();
        $result = ['result' =>1];
        echo json_encode($result);
    }
    
}
