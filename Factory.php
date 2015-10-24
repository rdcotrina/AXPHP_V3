<?php

class Factory{
    public static function createModulo($ruta){
        if(!file_exists($ruta)){
            mkdir($ruta, 0700);
            return true;
        }else{
            return false;
        }
    }
    public static function createOpcion($ruta) {
        if(!file_exists($ruta)){
            mkdir($ruta, 0700);
            mkdir($ruta.'/controllers', 0700);
            mkdir($ruta.'/models', 0700);
            mkdir($ruta.'/filters', 0700);
            mkdir($ruta.'/views', 0700);
            return true;
        }else{
            return false;
        }
    }
    
    public static function createController($ruta,$control,$alias) {
        self::_setConstantes($alias, $control);
        
        $contenido = self::_contController($ruta,$control);
        $file = $ruta.'/Controllers/'.$control.'Controller.php';
        
        
        if(!file_exists($file)){
            $fp=fopen($file,"x");
            fwrite($fp,$contenido);
            fclose($fp) ;
            self::_createFilter($ruta,$control,$alias);
            self::_createModel($ruta,$control,$alias);
            self::_createDirView($ruta,$control,$alias);
            self::_createIndex($ruta,$control,$alias);
            self::_createFormNew($ruta,$control,$alias);
            self::_createFormEdit($ruta,$control,$alias);
            return true;
        }  else {
            return false;
        }
    }
    
    private static function _setConstantes($pre,$opcion){
        $fp = fopen('config/prefix/PrefixPHP.php', 'a');
        fwrite($fp, chr(13).chr(10).'define("'.$pre.'","'.$pre.'");             /*tab opción '.strtoupper($opcion).'*/');
        fclose($fp);
        
        $fpj = fopen('config/prefix/PrefixJs.php', 'a');
        fwrite($fpj,chr(13).chr(10).'tabs.'.$pre." = '<?php echo ".$pre."; ?>';");
        fclose($fpj);
    }
    
    private static function _createIndex($ruta,$control,$alias){
        $contenido = self::_contIndex($alias);
        $file = $ruta.'/views/'.$control.'/index.phtml';
        
        if(!file_exists($file)){
            $fp=fopen($file,"x");
            fwrite($fp,$contenido);
            fclose($fp) ;
            return true;
        }  else {
            return false;
        }
    }

    private static function _createFormNew($ruta,$control,$alias){
        $contenido = self::_contFormNew($control,$alias);
        $file = $ruta.'/views/'.$control.'/formNew.phtml';
        
        if(!file_exists($file)){
            $fp=fopen($file,"x");
            fwrite($fp,$contenido);
            fclose($fp) ;
            return true;
        }  else {
            return false;
        }
    }
    
    private static function _createFormEdit($ruta,$control,$alias){
        $contenido = self::_contFormEdit($control,$alias);
        $file = $ruta.'/views/'.$control.'/formEdit.phtml';
        
        if(!file_exists($file)){
            $fp=fopen($file,"x");
            fwrite($fp,$contenido);
            fclose($fp) ;
            return true;
        }  else {
            return false;
        }
    }

    private static function _createFilter($ruta,$control,$alias){
        $contenido = self::_contFilter($ruta,$control,$alias);
        $file = $ruta.'/Filters/'.$control.'Filter.php';
        
        
        if(!file_exists($file)){
            $fp=fopen($file,"x");
            fwrite($fp,$contenido);
            fclose($fp) ;
            return true;
        }  else {
            return false;
        }
    }

    private static function _createDirView($ruta,$control,$alias){
        $dir = $ruta.'/views/'.strtolower($control);
        
        if(!file_exists($dir)){
            mkdir($dir, 0700);
            mkdir($dir.'/js', 0700);
            self::_createJs($ruta,$control,$alias);
            return true;
        }else{
            return false;
        }
    }

    public static function _createJs($ruta,$control,$alias) {
        $contenido = self::_contJs($ruta,$control,$alias);
        $file = $ruta.'/views/'.strtolower($control).'/js/'.$control.'View.js';
        
        if(!file_exists($file)){
            $fp=fopen($file,"x");
            fwrite($fp,$contenido);
            fclose($fp) ;
            return true;
        }  else {
            return false;
        }
    }
    
    private static function _createModel($ruta,$control,$alias) {
        $contenido = self::_contModel($ruta,$control,$alias);
        $file = $ruta.'/Models/'.$control.'Model.php';
        
        
        if(!file_exists($file)){
            $fp=fopen($file,"x");
            fwrite($fp,$contenido);
            fclose($fp) ;
            return true;
        }  else {
            return false;
        }
    }

    public static function readDir($dir){
        $l = [];
        $directorio=opendir($dir);
        while ($archivo = readdir($directorio)){
            if($archivo != '.' && $archivo != '..'){
                $l[] =['dir'=>$archivo];
            }
        }
        closedir($directorio);
        
        return $l;
    }
    
    public static function scanSubDir($ruta){
        $lista = [];
        $arrpa = scandir($ruta);
        foreach ($arrpa as $dir){
            if($dir != '.' && $dir != '..'){
                $arr = scandir($ruta.$dir);
                foreach ($arr as $sdir) {
                    if($sdir != '.' && $sdir != '..'){
                        $lista[] = ['dir' => $dir.'/'.$sdir];
                    }
                }
            }
        }
        return $lista;
    }
    
    private static function _contController($ruta,$name) {
        $c = explode('/', $ruta);
        $namespace = array_shift($c);
        $namespace = ucwords(array_shift($c));
        $opcion = ucwords(array_shift($c));
        $opcion2 = strtolower($opcion);
        
        $cont = '<?php
/* 
* ---------------------------------------
* --------- CREATED BY GS ----------
* fecha:        '.date('d-m-Y H:m:s').' 
* Descripcion : '.$name.'Controller.php
* ---------------------------------------
*/ 

namespace '.$namespace.'\\'.$opcion.'\\Controllers;
    
use '.$namespace.'\\'.$opcion.'\\Filters\\'.$name.'Filter;

class '.$name.'Controller extends \Vendor\Controller{

    use '.$name.'Filter{
            '.$name.'Filter::__construct as private __fConstruct;
        }
        
    private static $'.$opcion2.'Model;
       
    public function __construct() {
        $this->__fConstruct();
        self::$'.$opcion2.'Model = Obj()->Model->loadModel();
    }
    
    public function index() {
        Obj()->View->render();
    }
    
    public function getGrid(){
        $data =  self::$'.$opcion2.'Model->getGrid();
        foreach ($data as $key=>$value) {
            $data[$key]["IDCAMPO"] = Obj()->AesCtr->en($value["IDCAMPO"]);
        }
        echo json_encode($data);
    }
    
    public function formNew() {
        Obj()->View->render();
    }
    
    public function formEdit() {
        Obj()->View->render();
    }
    
    public function postMantenimiento() {
        if($this->isValidate()){
            $data = self::$'.$opcion2.'Model->mantenimiento();
        }else{
            $data = $this->valida()->messages();
        }
            
        echo json_encode($data);
    }
    
    public function postDelete() {
        echo json_encode(self::$'.$opcion2.'Model->mantenimiento());
    }
    
    public function find() {
        return self::$'.$opcion2.'Model->find();
    }
    
}
';
        return $cont;
    }
    
    private static function _contModel($ruta,$name,$alias) {
        $c = explode('/', $ruta);
        $namespace = array_shift($c);
        $namespace = ucwords(array_shift($c));
        $model = ucwords(array_shift($c));
        $model2 = strtolower($model);
        
        $cont = '<?php
/* 
* ---------------------------------------
* --------- CREATED BY GS ----------
* fecha:        '.date('d-m-Y H:m:s').' 
* Descripcion : '.$name.'Model.php
* ---------------------------------------
*/ 

namespace '.$namespace.'\\'.$model.'\\Models;
    
class '.$name.'Model extends \Vendor\DataBase{

    private $_flag;
    private $_primaryKey;
    private $_usuario;

    /*para el grid*/
    private $_pDisplayStart;
    private $_pDisplayLength;
    private $_pSortingCols;
    private $_sExport;
    private $_pOrder;
    private $_pFilterCols;
    
    public function __construct() {
        parent::__construct();
        $this->_getPost();
    }
    
    private function _getPost(){
        $this->_flag        = Obj()->Get->getPost("_flag");
        $this->_primaryKey  = Obj()->Aes->de(Obj()->Get->getPost("_primaryKey"));
        $this->_CAMPO       = Obj()->Get->getPost('.$alias.'."TXT_CAMPO");
        $this->_usuario     = Obj()->Session->get("sys_persona");
        
        $this->_pDisplayStart  =   Obj()->Get->getPost("pDisplayStart"); 
        $this->_pDisplayLength =   Obj()->Get->getPost("pDisplayLength"); 
        $this->_pSortingCols   =   Obj()->Get->getPost("pSortingCols");
        $this->_pOrder         =   Obj()->Get->getPost("pOrder");
        $this->_sExport        =   Obj()->Get->getPost("_sExport");
        $this->_pFilterCols    =   htmlspecialchars(trim(Obj()->AesCtr->de(Obj()->Get->getPost("pFilterCols"))),ENT_QUOTES);
    }
    
    public function getGrid(){
        $query = "EXEC sp_PROCEDIMIENTOGrid :iDisplayStart,:iDisplayLength,:pOrder,:pFilterCols,:sExport ;";
        $parms = array(
            ":iDisplayStart" => $this->_pDisplayStart,
            ":iDisplayLength" => $this->_pDisplayLength,
            ":pOrder" => $this->_pOrder,
            ":pFilterCols" => $this->_pFilterCols,
            ":sExport" => $this->_sExport
        );
        $data = $this->queryAll($query,$parms);
       
        return $data;
    }
    
    public function mantenimiento() {
        $query = "EXEC sp_PROCEDIMIENTOMantenimiento :flag,:primaryKey,:usuario ;";
        
        $parms = array(
            ":flag" => $this->_flag,
            ":primaryKey" => $this->_primaryKey,
            ":usuario" => $this->_usuario
        );
        $data = $this->queryOne($query,$parms);
       
        return $data;
    }
    
}';
        
        return $cont;
    }
    
    private static function _contJs($ruta,$name,$alias) {
        $c = explode('/', $ruta);
        $namespace = array_shift($c);
        $namespace = ucwords(array_shift($c));
        $model = ucwords(array_shift($c));
        $model2 = strtolower($model);
        
        $cont = '/* 
* ---------------------------------------
* --------- CREATED BY GS ----------
* fecha:        '.date('d-m-Y H:m:s').' 
* Descripcion : '.$name.'View.js
* ---------------------------------------
*/ 

var '.$name.'View_ = Ajax.extend(function(){
    var _private = {};

    _private.config = {
        controller: "'.  strtolower($namespace).'/'.$model2.'/'.$name.'/"
    };
    
    _private.primaryKey = 0;
    
    var public = {};

    public.init = function () {
        public.parent = this; // el padre == Ajax
    };
    
    public.main = function(){
        Tools.addTab({
            id: tabs.'.$alias.',
            label: Exe.getTitle(),
            fnCallback: function() {
                public.index(Exe.getTitle());
            }
        });
    };
    
    public.index = function(title){
        public.parent.send({
            dataType: "html",
            root: _private.config.controller + "index",
            fnServerParams: function(sData) {
                sData.push({name: "_rootTitle", value: title});
            },
            fnCallback: function(data) {
                $("#" + tabs.'.$alias.' + "_CONTAINER").html(data);
                public.getGrid();
            }
        });
    };
    
    public.getGrid = function (){
        var pNew    = Tools.getPermiso("'.$alias.'NEW");
        var pEdit   = Tools.getPermiso("'.$alias.'ED");
        var pDelete = Tools.getPermiso("'.$alias.'DE");
        
        $("#"+tabs.'.$alias.'+"grid").dataGrid({
            tScrollY: "200px",
            pDisplayLength: 25,
            tShowHideColumn: true,
            pOrderField: "[DB_CAMPO] ASC",
            tColumns: [
                {title: lang.'.$name.'.[FIELD],field: "[DB_CAMPO]",width: "200",sortable: true,filter: {type: "text"}},
                {
                    title: lang.generic.EST, 
                    width: "220", 
                    field: "[DB_CAMPO]", 
                    sortable: true, 
                    class: "center",
                    filter:{
                        type:"select",
                        dataClient:[{etiqueta:"Activo",value:"1"},{etiqueta:"Inactivo",value:"0"}],
                        options:{label:"etiqueta",value:"value"}
                    },
                    fnCallback:function(fila,row){
                        return Tools.labelState(row.[DB_CAMPO]);
                    }
                }
            ],
            tButtons:[{
                access: pNew.permiso,
                icono: pNew.icono,
                titulo: pNew.accion,
                class: pNew.theme,
                ajax: "Exe.'.$name.'View.formNew(this);"
            }],
            sExport:{
                buttons:{excel:true,pdf:true},
                nameFile: "axs",
                orientation: "landscape",
                caption: lang.Acciones.TITLEEXPORT,
                columns:[
                    {title:lang.'.$name.'.[FIELD] ,field:"accion",type: "string"},
                    {title:lang.'.$name.'.[FIELD] ,field:"alias"}
                ]
            },
            pPaginate: true,
            sAxions: {
                width: "90", //ancho de columna acciones
                /*se genera group buttons*/
                group: [{
                    titulo: "<i class=\"fa fa-gear fa-lg\"></i>",
                    tooltip: "Acciones",
                    class: "btn btn-primary",
                    buttons:[{
                        access: pEdit.permiso,
                        icono: pEdit.icono,
                        titulo: pEdit.accion,
                        class: pEdit.theme,
                        ajax: {
                            fn: "Exe.'.$name.'View.formEdit",
                            serverParams: "[DB_CAMPO]"
                        }
                    },{
                        access: pDelete.permiso,
                        icono: pDelete.icono,
                        titulo: pDelete.accion,
                        class: pDelete.theme,
                        ajax: {
                            fn: "Exe.'.$name.'View.postDelete",
                            serverParams: "[DB_CAMPO]"
                        }
                    }]
                }]
            },
            tScroll:{
                cRowsInVerticalScroll: 10 /*activa el scrool, se visualizara de 10 en 10*/
            },
            ajaxSource: _private.config.controller + "getGrid",
            fnCallback: function(oSettings) {
                _private.idGrid = oSettings.tObjectTable;
            }
        });
    };
    
    public.formNew = function(btn){
        public.parent.send({
            element: btn,
            dataType: "html",
            root: _private.config.controller + "formNew",
            fnCallback: function(data) {
                $("#cont-modal").append(data);  /*los formularios con append*/
                $("#" + tabs.'.$alias.' + "formNew").modal("show");
            }
        });
    };
    
    public.formEdit = function(btn,id){
        _private.primaryKey = id;
        public.parent.send({
            element: btn,
            dataType: "html",
            root: _private.config.controller + "formEdit",
            fnServerParams: function(sData) {
                sData.push({name: "_primaryKey", value: _private.primaryKey});
            },
            fnCallback: function(data) {
                $("#cont-modal").append(data);  /*los formularios con append*/
                $("#" + tabs.'.$alias.' + "formEdit").modal("show");
            }
        });
    };
    
    public.postNew = function(){
        public.parent.send({
            flag: 1,
            element: "#"+tabs.'.$alias.'+"btnSave",
            root: _private.config.controller + "postMantenimiento",
            form: "#"+tabs.'.$alias.'+"formNew",
            fnCallback: function(data) {
                if (parseInt(data.result) === 1) {
                    Tools.notify.ok({
                        content: lang.mensajes.MSG_3,
                        callback: function() {
                            Tools.closeModal("#" + tabs.'.$alias.' + "formNew");
                            Tools.refreshGrid(_private.idGrid);
                        }
                    });
                }else if (parseInt(data.result) === 2) {//ya existe
                    Tools.notify.error({
                        content: lang.mensajes.MSG_4
                    });
                }
            }
        });
    };
    
    public.postEdit = function(){
        public.parent.send({
            flag: 2,
            element: "#"+tabs.'.$alias.'+"btnEdit",
            root: _private.config.controller + "postMantenimiento",
            form: "#"+tabs.'.$alias.'+"formEdit",
            fnServerParams: function(sData) {
                sData.push({name: "_primaryKey", value: _private.primaryKey});
            },
            fnCallback: function(data) {
                if (parseInt(data.result) === 1) {
                    Tools.notify.ok({
                        content: lang.mensajes.MSG_10,
                        callback: function() {
                            Tools.closeModal("#" + tabs.'.$alias.' + "formEdit");
                            Tools.refreshGrid(_private.idGrid);
                            _private.primaryKey = 0;
                        }
                    });
                }else if (parseInt(data.result) === 2) {//ya existe
                    Tools.notify.error({
                        content: lang.mensajes.MSG_4
                    });
                }
            }
        });
    };
    
    public.postDelete = function(btn,id){
        Tools.notify.confirm({
            content: lang.mensajes.MSG_11,
            callbackSI: function() {
                public.parent.send({
                    flag: 3,
                    element: btn,
                    root: _private.config.controller + "postDelete",
                    fnServerParams: function(sData) {
                        sData.push({name: "_primaryKey", value: id});
                    },
                    fnCallback: function(data) {
                        if (!isNaN(data.result) && parseInt(data.result) === 1) {
                            Tools.notify.ok({
                                content: lang.mensajes.MSG_6,
                                callback: function() {
                                    Tools.refreshGrid(_private.idGrid);
                                }
                            });
                        }
                    }
                });
            }
        });
    };
    
    return public;
    
}()); ';
        return $cont;
    }
    
    private static function _contFilter($ruta,$name,$alias){
        $c = explode('/', $ruta);
        $namespace = array_shift($c);
        $namespace = ucwords(array_shift($c));
        $filter = ucwords(array_shift($c));
        $filter2 = strtolower($filter);
        
        $cont = '<?php
/* 
* ---------------------------------------
* --------- CREATED BY GS ----------
* fecha:        '.date('d-m-Y H:m:s').' 
* Descripcion : '.$name.'Filter.php
* ---------------------------------------
*/ 

namespace '.$namespace.'\\'.$filter.'\\Filters;

use Vendor\Traits\ValidaForm;

trait '.$name.'Filter {
    
    use ValidaForm{
        ValidaForm::__construct as private __fvConstruct;
    }
        
    public function __construct() {
        $this->__fvConstruct('.$alias.');
    }
    
    public function isValidate() {
        $this->valida()
            ->filter(["field"=>"TXT_CAMPO","label"=>'.$alias.'_1])
                ->rule(["rule"=>"required"])
                ->rule(["rule"=>"minlength:3"])
            ->filter(["field"=>"txt_alias","label"=>'.$alias.'_1])
                ->rule(["rule"=>"required"])
                ->rule(["rule"=>"rangelength:2,5"]);
            
            if($this->valida()->isTrue()){
                return true;
            }
            return false;
    }
    
}';
        
        return $cont;
    }
    
    private static function _contIndex($alias){
        $cont = '<?php
Vendor\Tools::widgetOpen(array(
        "id"=>'.$alias.',
        "title"=>'.$alias.'_1
    )); 
?>

<div id="<?php echo '.$alias.'; ?>grid"></div>

<?php 
    Vendor\Tools::widgetClose(); 
        ';
        return $cont;
    }

    private static function _contFormNew($name,$alias){
        $cont = '<?php
/* 
* ---------------------------------------
* --------- CREATED BY GS ----------
* fecha:        '.date('d-m-Y H:m:s').' 
* Descripcion : formNew.php
* ---------------------------------------
*/ 

$grabar = Obj()->Session->getPermiso("'.$alias.'GR");

$Form = Obj()->BuiltForm->init([
    "title" => '.$alias.'_4,
    "alias" => '.$alias.',
    "ajaxSubmit" => "Exe.'.$name.'View.postNew();",
    "attr" => [
        "id" => "formNew",
        "name" => "formNew",
        "class" => "modal fade"
    ],
    "noSubmit" => $grabar["permiso"] //cuando no tiene permiso de grabar, el enter en elementos no funciona
        ]);

$Form->addField([
    "label" => [
        "label" => '.$alias.'_6,
        "attr" => ["class" => "label col col-2"]
    ],
    "field" => [
        "attr" => [
            "type" => "text",
            "id" => "TXT_CAMPO",
            "name" => "TXT_CAMPO"
        ],
        "help" => '.$alias.'_10,
        "iconrequired" => true,
        "validate" => ["required:true", "minlength:3"]
    ]
]);

/*demo*/
$data = [
    ["info"=>"Info 1","valor"=>1],
    ["info"=>"Info 2","valor"=>2],
    ["info"=>"Info 3","valor"=>3],
    ["info"=>"Info 4","valor"=>4],
    ["info"=>"Info 5","valor"=>5],
];

$Form->addField([
    "label" => [
        "label" => '.$alias.'_7,
        "attr" => ["class" => "label col col-2"]
    ],
    "field" => [
        "csswidth" => "col col-8",
        "attr" => [
            "type" => "select",
            "id" => "LST_CAMPO",
            "name" => "LST_CAMPO"
        ],
        "data"=>$data,
        "etiquet" => "info",
        "value" => "valor",
        "defaultEtiquet" => "",
        "labelSelect" => true,
        "labelAll" => true
    ]
]);

$Form->addField([
    "label" => [
        "label" => LBL_ACTIVO,
        "attr" => ["class" => "label col col-2"]
    ],
    "field" => [
        "csswidth" => "col col-3",
        "attr" => [
            "type" => "checkbox",
            "id" => "chk_activo",
            "name" => "chk_activo",
            "value" => "1",
            "checked" => true
        ]
    ]
]);

if ($grabar["permiso"]) {
    $Form->addButton([
        "label" => $grabar["accion"],
        "icon" => $grabar["icono"],
        "attr" => [
            "id" => "btnSave",
            "type" => "submit",
            "class" => $grabar["theme"]
        ]
    ]);
}

$Form->addButton([
    "label" => LBL_CLOSE,
    "icon" => ICON_CLOSE,
    "attr" => [
        "type" => "button",
        "class" => THEME_CLOSE
    ]
]);

$Form->view();
        ';
        return $cont;
    }
    
    private static function _contFormEdit($name,$alias){
        $cont = '<?php
/* 
* ---------------------------------------
* --------- CREATED BY GS ----------
* fecha:        '.date('d-m-Y H:m:s').' 
* Descripcion : formEdit.phtml
* ---------------------------------------
*/ 

$editar = Obj()->Session->getPermiso("'.$alias.'ACT");

$data = Obj()->'.$name.'Controller->find();

$Form = Obj()->BuiltForm->init([
            "title"=>'.$alias.'_5,
            "alias"=>'.$alias.',
            "ajaxSubmit"=>"Exe.'.$name.'View.postEdit();",
            "attr"=>[
                "id"=>"formEdit",
                "name"=>"formEdit",
                "class"=>"modal fade"
            ],
            "noSubmit"=>$editar["permiso"] 
        ]);

$Form->addField([
    "label"=>[
        "label"=>'.$alias.'_6,
        "attr"=>["class"=>"label col col-2"]
    ],
    "field"=>[
        "attr"=>[
            "type"=>"text",
            "id"=>"TXT_CAMPO",
            "name"=>"TXT_CAMPO",
            "value"=>$data["DB_CAMPO"]
        ],
        "help"=>'.$alias.'_10,
        "iconrequired"=>true,
        "validate"=>["required:true","minlength:3"]
    ]
]);

/*demo*/
$data = [
    ["info"=>"Info 1","valor"=>1],
    ["info"=>"Info 2","valor"=>2],
    ["info"=>"Info 3","valor"=>3],
    ["info"=>"Info 4","valor"=>4],
    ["info"=>"Info 5","valor"=>5],
];

$Form->addField([
    "label" => [
        "label" => '.$alias.'_7,
        "attr" => ["class" => "label col col-2"]
    ],
    "field" => [
        "csswidth" => "col col-8",
        "attr" => [
            "type" => "select",
            "id" => "LST_CAMPO",
            "name" => "LST_CAMPO"
        ],
        "data"=>$data,
        "etiquet" => "info",
        "value" => "valor",
        "defaultEtiquet" => $data["DB_CAMPO"],
        "labelSelect" => true,
        "labelAll" => true
    ]
]);

$Form->addField([
    "label"=>[
        "label"=>LBL_ACTIVO,
        "attr"=>["class"=>"label col col-2"]
    ],
    "field"=>[
        "csswidth"=>"col col-3",
        "attr"=>[
            "type"=>"checkbox",
            "id"=>"chk_activo",
            "name"=>"chk_activo",
            "value"=>"1",
            "checked"=>($data["DB_CAMPO"] == "1")?true:false
        ]
    ]
]);

if($editar["permiso"]){
    $Form->addButton([
        "label"=>$editar["accion"],
        "icon"=>$editar["icono"],
        "attr"=>[
            "id"=>"btnEdit",
            "type"=>"submit",
            "class"=>$editar["theme"]
        ]
    ]);
}

$Form->addButton([
    "label"=>LBL_CLOSE,
    "icon"=>ICON_CLOSE,
    "attr"=>[
        "type"=>"button",
        "class"=>THEME_CLOSE
    ]
]);

$Form->view(); 
        ';
        return $cont;
    }
    
}


