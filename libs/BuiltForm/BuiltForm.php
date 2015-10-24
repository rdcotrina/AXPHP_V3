<?php

/**
 * Description of BuiltForm
 *
 * @author DAVID
 */
namespace Libs;

final class BuiltForm{
    
    private $_type;
    private $_titleForm;    
    private $_aliasForm;
    private $_attrForm;
    private $_widthForm;
    private $_ajaxSubmit;
    private $_noSubmit;
    private $_helpRequiredForm = false;
    private $_fields   = array();
    private $_buttons  = array();
    private $_validate = array();

    /*
     *   new BuiltForm([
     *       "title"=>"title",
     *       "alias"=>T2,
     *       "width"=>"100%",
     *       "ajaxSubmit"=>"ajaxjs();",
     *       "attr"=>[
     *           "id"=>"formNuevaAccion",
     *           "name"=>"formNuevaAccion",
     *           "class"=>"modal fade"
     *       ],
     *       "noSubmit"=>$sessionpermiso['permiso']  -- cuando no tiene permiso de grabar, el enter en elementos no funciona
     *   ]);
     */
    public function init($obj) {
        $this->_type       = isset($obj['type'])?$obj['type']:'form';
        $this->_titleForm  = isset($obj['title'])?$obj['title']:'[title]';
        $this->_aliasForm  = isset($obj['alias'])?$obj['alias']:'';
        $this->_ajaxSubmit = isset($obj['ajaxSubmit'])?$obj['ajaxSubmit']:'alert("[ajaxSubmit] no definido");return false;';
        $this->_noSubmit   = (isset($obj['noSubmit']) && !$obj['noSubmit'])?true:false; //se activa noSubmit
        $this->_widthForm  = isset($obj['width'])?'style="width:'.$obj['width'].'"':'';
        $this->_attrForm   = (isset($obj['attr']) && is_array($obj['attr']))?$obj['attr']:'';
        return $this;
    }
    
    /*
     * CARGA LA CONFIGURACION DEL FIELD
     *   $Form->addField([
     *       "label"=>[
     *           "label"=>AXI_6,
     *           "attr"=>["class"=>"label col col-2"]
     *       ],
     *       "field"=>[
     *           "csswidth"=>"col col-8",
     *           "attr"=>[
     *               "type"=>"text",
     *               "id"=>"txt_accion",
     *               "name"=>"txt_accion"
     *           ],
     *           "iconhelp"=>"fa fa-question-circle",
     *           "help"=>AXI_10,
     *           "iconrequired"=>true,
     *           "validate"=>["required:true","minlength:3"] -- parametros para validate.jquery.js
     *       ]
     *   ]);
     */
    public function addField($obj) {
        $this->_fields[] = $obj;
    }
    
    /*
     * CARGA LA CONFIGURACION DE LOS BOTONES
     *   $Form->addButton([
     *       "label"=>$grabar['accion'],
     *       "icon"=>$grabar['icono'],
     *       "attr"=>[
     *           "id"=>"btnGrabaAccion",
     *           "type"=>"submit",
     *           "class"=>$grabar['theme']
     *       ]
     *   ]);
     */
    public function addButton($obj) {
        $this->_buttons[] = $obj;
    }
    
    /*
     * CREA EL FORMULARIO
     */
    public function view() {
        $html  = 
        '<'.$this->_type.' '.$this->getAttr($this->_attrForm).'>'
            . '<div class="modal-dialog" '.$this->_widthForm.'>'
                . '<div class="modal-content">'
                    . '<div class="modal-header">'
                        . '<button type="button" class="close"  aria-hidden="true">&times;</button>'
                        . '<h4 class="modal-title">'.$this->_titleForm.'</h4>'
                    . '</div>'
                    . '<div class="modal-body smart-form">'
                        . $this->getFieldRows()
                    . '</div>'
                    . '<div class="modal-footer">'
                        . (($this->_helpRequiredForm)?'<div class="foot-obligar"></div>':'')
                        . $this->getButtons()
                    . '</div>'
                . '</div>'
            . '</div>'
            . $this->getValidate()
        . '</'.$this->_type.'>';
        
        echo $html;
    }
    
    /*
     * Retorna las filas de elementos
     */
    private function getFieldRows() {
        $row = '';
        foreach ($this->_fields as $el) {
            $label = (isset($el['label']) && is_array($el['label']))?$el['label']:'';
            $field = (isset($el['field']) && is_array($el['field']))?$el['field']:'';
            
            $row .= $this->getRow($label,$field);
        }
        return $row;
    }
    
    /*
     * CREA LA FILA QUE CONTIENE EL LABEL Y EL FIELD
     */
    private function getRow($label,$field) {
        $html = 
          '<section>'
            . '<div class="row">'
                . $this->getLabel($label,$field)
                . $this->getField($label,$field)
            . '</div>'
        . '</section>';
        
        return $html;
    }
    
    /*
     * CREA EL <div> CONTENEDOR DEL FIELD
     */
    private function getField($label,$field) {
        $html = '';
        if(empty($field)){
            $html .= '<p>[field] no definido</p>';
        }else{
            $csswidth     = isset($field['csswidth'])?$field['csswidth']:'col col-8';
            $attr         = (isset($field['attr']) && is_array($field['attr']))?$field['attr']:'';
            $iconhelp     = isset($field['iconhelp'])?$field['iconhelp']:'fa fa-question-circle';
            $help         = isset($field['help'])?$field['help']:'help';
            $iconrequired = isset($field['iconrequired'])?$field['iconrequired']:false;
            
            /*guardando validate js*/
            if(isset($field['validate']) && is_array($field['validate'])){
                $this->setValidate($attr,$field['validate']);
            }
            
            $html .= 
              '<div class="'.$csswidth.'">'
                    . '<label class="'.$this->getCssField($attr).'">';
                    if(empty($attr)){
                        $html .= '[attr] de field no definido';
                    }else{
                        $html .= $this->createField($attr,$iconhelp,$help,$field,$label);
                    }
                    if($iconrequired){
                        $this->_helpRequiredForm = true;
                        $html  .= '<div class="obligar"></div>';
                    }
            $html  .= '</label>'
            . '</div>';
        }
        return $html;
    }
    
    /*
     * Crea elemento
     */
    private function createField($attr,$iconhelp,$help,$field,$label) {
        $type = strtolower($this->_findAttr($attr,'type'));
        
        switch($type) {
            case 'text':
                $field = 
                      '<i class="icon-append '.$iconhelp.'"></i>'
                    . '<input '.$this->getAttr($attr).'>'
                    . '<b class="tooltip tooltip-top-right"><i class="'.$iconhelp.' txt-color-teal"></i> '.$help.'</b>';
                break;
            case 'select':
                $field = $this->_createSelect($field);
                break;
            case 'checkbox':
                $field = '<input '.$this->getAttrOpt($attr).'><i></i>'.$label['label'];
                break;
            case 'radio':
                $field = '<input '.$this->getAttrOpt($attr).'><i></i>'.$label['label'];
                break;
            case 'textarea':
                $field = 
                      '<i class="icon-append '.$iconhelp.'"></i>'
                    . '<textarea '.$this->getAttr($attr).'></textarea>'
                    . '<b class="tooltip tooltip-top-right"><i class="'.$iconhelp.' txt-color-teal"></i> '.$help.'</b>';
                break;
            default:
                $field = '[no existe objeto]';
                break;
        }
        return $field;
    }
    
    
    
    /*
     * Crea el label de elemento de formulario
     */
    private function getLabel($label,$field){
        $html = '';
        if(empty($label)){
            $html .= '<p>[label] no definido</p>';
        }else{
            $lb   = isset($label['label'])?$label['label']:'[label] de elemento no definido';
            $attr = (isset($label['attr']) && is_array($label['attr']))?$label['attr']:'';
            
            if($this->_findAttr($field['attr'], 'type') == 'radio' || $this->_findAttr($field['attr'], 'type') == 'checkbox'){ $lb = ''; }
            $html .= '<label '.$this->getAttr($attr).'>'.$lb.'</label>';
        }
        return $html;
    }

    /*
     * Devuelve los botones
     */
    private function getButtons() {
        $buttons = '';
        foreach ($this->_buttons as $btn) {
            $label = isset($btn['label'])?$btn['label']:'[label]';
            $icon  = isset($btn['icon'])?$btn['icon']:'';
            $attr  = (isset($btn['attr']) && is_array($btn['attr']))?$btn['attr']:'';
            
            $buttons .= '<button '.$this->getAttr($attr).'>';
                        if(!empty($icon)){
                            $buttons .= '<i class="'.$icon.'"></i> ';
                        }
            $buttons .= $label;
            $buttons .= '</button>';
        }
        return $buttons;
    }
    
    /*
     * Devuelve los atributos de un elemento
     */
    private function getAttr($obj) {
        $attr = '';
        if(is_array($obj)){
            foreach ($obj as $key => $value) {
                if($key == 'id' || $key == 'name'){
                    $value = $this->_aliasForm.$value;
                }
                $attr .= $key.'="'.$value.'" ';
            }
        }
        return $attr;
    }
    
    /*
     * Devuelve un atributo
     */
    private function _findAttr($obj,$f) {
        if(is_array($obj)){
            foreach ($obj as $key => $value) {
                if($key == $f){
                    return $value;
                }
            }
        }
    }
    
    /*
     * Devuelve los atributos de un elemento checkbox o radio
     */
    private function getAttrOpt($obj) {
        $attr = '';
        $chk = '';
        if(is_array($obj)){
            foreach ($obj as $key => $value) {
                if($key == 'id' || $key == 'name'){
                    $value = $this->_aliasForm.$value;
                }
                if($key != 'checked'){
                    $attr .= $key.'="'.$value.'" ';
                }else{
                    $chk = $value;
                }
            }
            if($chk){
                $attr .= 'checked="checked"';
            }
        }
        return $attr;
    }
    
    /*
     * Guarda todas las validaciones js
     */
    private function setValidate($attr,$valida) {
        if(!empty($attr)){
            $this->_validate[$this->getIdField($attr)] = $valida;
        }
    }
    
    /*
     * Retorna ID de elemento
     */
    private function getIdField($obj) {
        if(is_array($obj)){
            foreach ($obj as $key => $value) {
                if($key == 'id'){
                    return $this->_aliasForm.$value;
                }
            }
        }
        return false;
    }
    
    /*
     * Retorna el ID  del formulario
     */
    private function getIdForm() {
        if(is_array($this->_attrForm)){
            foreach ($this->_attrForm as $key => $value) {
                if($key == 'id'){
                    return $this->_aliasForm.$value;
                }
            }
        }
        return false;
    }
    
    /*
     * Retorna css para diseño de field
     */
    private function getCssField($attr) {
        $type = strtolower($this->_findAttr($attr,'type'));
        switch($type) {
            case 'text':
                $css = 'input';
                break;
            case 'select':
                $css = $type;
                break;
            case 'checkbox':
                $css = $type;
                break;
            case 'radio':
                $css = $type;
                break;
            case 'textarea':
                $css = 'input';
                break;
            default:
                $css = '';
                break;
        }
        return $css;
    }
    
    /*
     * Crea el validate jquery
     */
    private function getValidate() {
        $msnAttr = ''; $msnAlias = '';
        
        if(empty($this->_attrForm)){
            $msnAttr  = 'alert("[attr] no definido en el constructor del formulario")';
        }
        if(empty($this->_aliasForm)){
            $msnAlias = 'alert("[alias] no definido en el constructor del formulario")';
        }
        
        $idForm = $this->getIdForm();
        
        if($this->_noSubmit){ //se desactiva enter en formulario, porque no tiene permiso para enviar
            $script = '<script>axScript.noSubmit("#'.$idForm.'");</script>';
        }else{
            $script = 
            '<script>'
              . $msnAttr
              . $msnAlias
              . '$("#'.$idForm.'").validate({'
                  . $this->getRulesValidate()
                  . 'errorPlacement : function(error, element) {'
                      . 'error.insertAfter(element.parent());'
                  . '},'
                  . 'submitHandler: function(){'
                      . $this->_ajaxSubmit
                  . '}'
              . '});'
          . '</script>';
        }
        
        
        return $script;
    }
    
    /*
     * Crea las reglas del validate jquery
     */
    private function getRulesValidate() {
        $rules = '';
        
        if(count($this->_validate)){
            $rules  = 'rules : {';
            foreach ($this->_validate as $key => $value) {
                $rules .= $key.':{'.$this->getRules($value).'},';
            }
            $rules = substr_replace($rules, "", -1);
            $rules .= '},';
        }
        
        
        return $rules;
    }
    
    /*
     * Crea cada regla de los elementos a validar
     */
    private function getRules($obj) {
        $rl = '';
        foreach ($obj as $rule) {
            $rl .= $rule.',';
        }
        
        return substr_replace($rl, "", -1);
    }
    
    private function _createSelect($obj) {
        $data = isset($obj['data'])?$obj['data']:array();
        $attr = isset($obj['attr'])?$obj['attr']:array();
        $all  = isset($obj['labelAll'])?$obj['labelAll']:false;
        $sel  = isset($obj['labelSelect'])?$obj['labelSelect']:true;
        $etiq = isset($obj['etiquet'])?$obj['etiquet']:'';
        $valo = isset($obj['value'])?$obj['value']:'';
        $etid = isset($obj['defaultEtiquet'])?$obj['defaultEtiquet']:'';
        $chosen  = isset($obj['chosen'])?$obj['chosen']:true;
        
        $id = '';
        
        $html = '<select ';
        foreach ($attr as $key => $value) {
            if($key == 'id'){ $id = $value;} /*para el chosen*/
            $html .= $key . '="' . $value . '" ';
        }
        $html .= '>';
        
        if (count($data) > 0) {
            if ($sel){
                $html .= '<option value="">Seleccionar</option>';
            }
            if ($all){
                $html .= '<option value="ALL">Todo(s)</option>';
            }


            foreach ($data as $item) {
                
                /*las etiquetas*/
                if(is_array($etiq)){
                    $desc = '';
                    foreach ($etiq as $val) {
                        $desc .= $item[$val].' - ';
                    }
                    $desc = substr_replace($desc, "", -2);
                }else{
                    $desc = $item[$etiq];
                }
                
                /*los valores*/
                if(is_array($valo)){
                    $key = '';
                    foreach ($valo as $vall) {
                        $key .= $item[$vall].'-';
                    }
                    $key = substr_replace($key, "", -1);
                }else{
                    $key = $item[$valo];
                }
                
                $selected = "";
                if ($key == $etid) {
                    $selected = '  selected="selected"';
                }

                $html .= '<option title="' . $desc . '" value="' . $key . '" ' . $selected . '>' . $desc . '</option>';
            }

            $html .= '</select>';
        }
        else{
            $html .= '<option value=""> - Sin datos - </option></select>';
        }
        if($chosen){
            $html .= '<script>$("#'.$id.'").chosen();$("#'.$id.'_chosen").css("width","100%");</script>';
            if(!empty($etid)){
                $html .= '<script>$("#'.$id.'").val("'.$etid.'").trigger("chosen:updated");</script>';
            }
        }
        
        return $html;
    }
    
}
