<?php
/**
 * Description of RolFilter
 *
 * @author DAVID
 */
namespace Aplication\Rol\Filters;

use Vendor\Traits\ValidaForm;

trait RolFilter {
    
    use ValidaForm{
        ValidaForm::__construct as private __fvConstruct;
    }
    
    public function __construct() {
        $this->__fvConstruct(ROL);
    }
    
}
