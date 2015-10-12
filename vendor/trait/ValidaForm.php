<?php
/**
 * Description of ValidaForm
 *
 * @author DAVID
 */
namespace Vendor\Traits;

use Libs\Validate;

trait ValidaForm {
    
    private $_obj;

    public function __construct($alias=''){
        $this->_obj = new Validate($alias);
    }
    
    public function valida() {
        return $this->_obj;
    }
    
}
