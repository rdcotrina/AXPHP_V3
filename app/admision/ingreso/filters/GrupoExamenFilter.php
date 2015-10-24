<?php
/* 
* ---------------------------------------
* --------- CREATED BY GS ----------
* fecha:        24-10-2015 16:10:06 
* Descripcion : GrupoExamenFilter.php
* ---------------------------------------
*/ 

namespace Admision\Ingreso\Filters;

use Vendor\Traits\ValidaForm;

trait GrupoExamenFilter {
    
    use ValidaForm{
        ValidaForm::__construct as private __fvConstruct;
    }
        
    public function __construct() {
        $this->__fvConstruct(GREX);
    }
    
    public function isValidate() {
        $this->valida()
            ->filter(["field"=>"TXT_CAMPO","label"=>GREX_1])
                ->rule(["rule"=>"required"])
                ->rule(["rule"=>"minlength:3"])
            ->filter(["field"=>"txt_alias","label"=>GREX_1])
                ->rule(["rule"=>"required"])
                ->rule(["rule"=>"rangelength:2,5"]);
            
            if($this->valida()->isTrue()){
                return true;
            }
            return false;
    }
    
}