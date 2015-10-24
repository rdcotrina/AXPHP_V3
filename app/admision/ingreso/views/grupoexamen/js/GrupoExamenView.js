/* 
* ---------------------------------------
* --------- CREATED BY GS ----------
* fecha:        24-10-2015 16:10:06 
* Descripcion : GrupoExamenView.js
* ---------------------------------------
*/ 

var GrupoExamenView_ = Ajax.extend(function(){
    var _private = {};

    _private.config = {
        controller: "admision/ingreso/GrupoExamen/"
    };
    
    _private.primaryKey = 0;
    
    var public = {};

    public.init = function () {
        public.parent = this; // el padre == Ajax
    };
    
    public.main = function(){
        Tools.addTab({
            id: tabs.GREX,
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
                $("#" + tabs.GREX + "_CONTAINER").html(data);
                public.getGrid();
            }
        });
    };
    
    public.getGrid = function (){
        var pNew    = Tools.getPermiso("GREXNEW");
        var pEdit   = Tools.getPermiso("GREXED");
        var pDelete = Tools.getPermiso("GREXDE");
        
        $("#"+tabs.GREX+"grid").dataGrid({
            tScrollY: "200px",
            pDisplayLength: 25,
            tShowHideColumn: true,
            pOrderField: "[DB_CAMPO] ASC",
            tColumns: [
                {title: lang.$name.[FIELD],field: "[DB_CAMPO]",width: "200",sortable: true,filter: {type: "text"}},
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
                ajax: "Exe.GrupoExamenView.formNew(this);"
            }],
            sExport:{
                buttons:{excel:true,pdf:true},
                nameFile: "axs",
                orientation: "landscape",
                caption: lang.Acciones.TITLEEXPORT,
                columns:[
                    {title:lang.GrupoExamen.[FIELD] ,field:"accion",type: "string"},
                    {title:lang.GrupoExamen.[FIELD] ,field:"alias"}
                ]
            },
            pPaginate: true,
            sAxions: {
                buttons:[{
                    access: pEdit.permiso,
                    icono: pEdit.icono,
                    titulo: pEdit.accion,
                    class: pEdit.theme,
                    ajax: {
                        fn: "Exe.GrupoExamenView.formEdit",
                        serverParams: "[DB_CAMPO]"
                    }
                }, {
                    access: pDelete.permiso,
                    icono: pDelete.icono,
                    titulo: pDelete.accion,
                    class: pDelete.theme,
                    ajax: {
                        fn: "Exe.GrupoExamenView.postDelete",
                        serverParams: "[DB_CAMPO]"
                    }
                }]
            },
            tScroll:{
                cRowsInVerticalScroll: 10 /*activa el scrool, se visualizara de 10 en 10*/
            },
            ajaxSource: _private.config.controller + "grid",
            fnCallback: function(oSettings) {
                _private.idGrid = oSettings.tObjectTable;
            }
        });
    }
    
    public.formNew = function(btn){
        public.parent.send({
            element: btn,
            dataType: "html",
            root: _private.config.controller + "formNew",
            fnCallback: function(data) {
                $("#cont-modal").append(data);  /*los formularios con append*/
                $("#" + tabs.GREX + "formNew").modal("show");
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
                $("#" + tabs.GREX + "formEdit").modal("show");
            }
        });
    };
    
    public.postNew = function(){
        public.parent.send({
            flag: 1,
            element: "#"+tabs.GREX+"btnSave",
            root: _private.config.controller + "postMantenimiento",
            form: "#"+tabs.GREX+"formNew",
            fnCallback: function(data) {
                if (parseInt(data.result) === 1) {
                    Tools.notify.ok({
                        content: lang.mensajes.MSG_3,
                        callback: function() {
                            Tools.closeModal("#" + tabs.GREX + "formNew");
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
            element: "#"+tabs.GREX+"btnEdit",
            root: _private.config.controller + "postMantenimiento",
            form: "#"+tabs.GREX+"formEdit",
            fnServerParams: function(sData) {
                sData.push({name: "_primaryKey", value: _private.primaryKey});
            },
            fnCallback: function(data) {
                if (parseInt(data.result) === 1) {
                    Tools.notify.ok({
                        content: lang.mensajes.MSG_10,
                        callback: function() {
                            Tools.closeModal("#" + tabs.GREX + "formEdit");
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
    
}()); 