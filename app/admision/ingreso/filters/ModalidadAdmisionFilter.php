<?php
/* 
* ---------------------------------------
* --------- CREATED BY GS ----------
* fecha:        24-10-2015 16:10:35 
* Descripcion : ModalidadAdmisionFilter.php
* ---------------------------------------
*/ 

namespace Admision\Ingreso\Filters;

use Vendor\Traits\ValidaForm;

trait ModalidadAdmisionFilter {
    
    use ValidaForm{
        ValidaForm::__construct as private __fvConstruct;
    }
        
    public function __construct() {
        $this->__fvConstruct(MODA);
    }
    
    public function isValidate() {
        $this->valida()
            ->filter(["field"=>"TXT_CAMPO","label"=>MODA_1])
                ->rule(["rule"=>"required"])
                ->rule(["rule"=>"minlength:3"])
            ->filter(["field"=>"txt_alias","label"=>MODA_1])
                ->rule(["rule"=>"required"])
                ->rule(["rule"=>"rangelength:2,5"]);
            
            if($this->valida()->isTrue()){
                return true;
            }
            return false;
    }
    
}