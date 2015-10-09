<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlmaceneroController
 *
 * @author DAVID
 */
namespace Logistica\Almacen\Controllers;
class AlmaceneroController extends \Vendor\Controller{
    
    private static $modelLogin;

    public function __construct() {
        self::$modelLogin = Obj()->Model->loadModel(__FILE__);
    }
    
    //put your code here
    public function index() {
        ;
    }
}
