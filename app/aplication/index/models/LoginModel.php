<?php
/**
 * Description of LoginModel
 *
 * @author DAVID
 */
namespace Aplication\Index\Models;

class LoginModel extends \Vendor\DataBase{
    
    private $_flag;
    private $_user;
    private $_pass;
    
    public function __construct() {
        parent::__construct();
        $this->_getPost();
    }
    
    private function _getPost(){
        $this->_flag = Obj()->Get->getPost('_flag');
        $this->_user = Obj()->Aes->de(Obj()->Get->getPost('_user'));
        $this->_pass = Obj()->Aes->de(Obj()->Get->getPost('_clave'));
    }
    
    public function loginUser(){
        $query = "EXEC sp_maeIndexLoginUser :flag,:user,:pass;";
        $parms = array(
            ':flag' => $this->_flag,
            ':user' => $this->_user,
            ':pass' => $this->_pass.APP_PASS_KEY
        );
        $data = $this->queryOne($query,$parms);
     
        return array('data'=>$data,'rowCount'=>$this->rowCount);
    }
    
    public function postLastLogin(){
        $query = "EXEC sp_maeIndexLoginUser :flag,:user,:pass; ";
        $parms = array(
            ':flag'=> 2,
            ':user' => Obj()->Session->get('sys_idUsuario'),
            ':pass' => ''
        );
        $this->execute($query, $parms);
    }
    
    public function getRoles() {
        $query = "EXEC sp_maeIndexLoginUser :flag,:c1,:c2;";
        $parms = array(
            ':flag' => 3,
            ':c1' => Obj()->Session->get('sys_idUsuario'),
            ':c2' => ''
        );
        return $this->queryAll($query,$parms);
    }
    
}
