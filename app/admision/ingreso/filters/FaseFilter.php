<?php
/* 
* ---------------------------------------
* --------- CREATED BY GS ----------
* fecha:        24-10-2015 16:10:26 
* Descripcion : FaseFilter.php
* ---------------------------------------
*/ 

namespace Admision\Ingreso\Filters;

use Vendor\Traits\ValidaForm;

trait FaseFilter {
    
    use ValidaForm{
        ValidaForm::__construct as private __fvConstruct;
    }
        
    public function __construct() {
        $this->__fvConstruct(FASE);
    }
    
    public function isValidate() {
        $this->valida()
            ->filter(["field"=>"txt_descripcion","label"=>LBL_DESCRIPCION])
                ->rule(["rule"=>"required"])
                ->rule(["rule"=>"minlength:3"]);
            
            if($this->valida()->isTrue()){
                return true;
            }
            return false;
    }
    
}