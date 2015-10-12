<?php

/**
 * Description of AccionFilter
 *
 * @author DAVID
 */
namespace Aplication\Accion\Filters;

use Vendor\Traits\ValidaForm;

trait AccionFilter {
    
    use ValidaForm{
        ValidaForm::__construct as private __fvConstruct;
    }
        
    public function __construct() {
        $this->__fvConstruct(AXI);
    }
    
    public function isValidate() {
        $this->valida()
            ->filter(['field'=>'txt_accion','label'=>AXI_6])
                ->rule(['rule'=>'required'])
                ->rule(['rule'=>'minlength:3'])
            ->filter(['field'=>'txt_alias','label'=>AXI_7])
                ->rule(['rule'=>'required'])
                ->rule(['rule'=>'rangelength:2,5'])
            ->filter(['field'=>'txt_icono','label'=>AXI_8])
                ->rule(['rule'=>'required'])
                ->rule(['rule'=>'minlength:3'])
            ->filter(['field'=>'txt_theme','label'=>AXI_9])
                ->rule(['rule'=>'required'])
                ->rule(['rule'=>'minlength:3']);
            
            if($this->valida()->isTrue()){
                return true;
            }
            return false;
    }
    
}
