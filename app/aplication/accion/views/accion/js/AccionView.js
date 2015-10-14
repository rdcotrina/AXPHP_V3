var AccionView_ = Ajax.extend(function(){
    
    var _private = {};

    _private.config = {
        controller: 'aplication/accion/Accion/'
    };
    
    _private.idAccion = 0;
    
    var public = {};

    public.init = function () {
        public.parent = this; // el padre == Ajax
    };
    
    public.main = function(){
        Tools.addTab({
            id: tabs.AXI,
            label: Exe.getTitle(),
            fnCallback: function() {
                public.index(Exe.getTitle());
            }
        });
    };
    
    public.index = function(title){
        public.parent.send({
            dataType: 'html',
            root: _private.config.controller + public.parent.__method__(this,3),
            fnServerParams: function(sData) {
                sData.push({name: '_rootTitle', value: title});
            },
            fnCallback: function(data) {
                $('#' + tabs.AXI + '_CONTAINER').html(data);
                public.getGridAcciones();
            }
        });
    };
    
    public.getGridAcciones = function (){
        var pNew    = Tools.getPermiso("AXINEW");
        var pEdit   = Tools.getPermiso("AXIED");
        var pDelete = Tools.getPermiso("AXIDE");

        $("#"+tabs.AXI+"gridAcciones").dataGrid({
            tScrollY: "200px",
            pDisplayLength: 25,
            tShowHideColumn: true,
            pOrderField: 'descripcion asc',
            tColumns: [
                {title: lang.Acciones.AXION,field: "descripcion",width: "200",sortable: true,filter: {type: 'text'}},
                {
                    title: lang.Acciones.DISEN, 
                    width: "220", 
                    field: "accion", 
                    class: "center",
                    fnCallback:function(fila,row){
                        return '<button type="button" class="'+row.theme+'"><i class="'+row.icono+'"></i></button>';
                    }
                },
                {
                    title: lang.Acciones.ALIAS, 
                    field: "alias", 
                    width: "150", 
                    sortable: true,
                    filter:{
                        type:"select",
                        ajaxData: _private.config.controller+'getAlias',
                        options:{label:'alias',value:'alias'}
                    }
                },
                {
                    title: lang.generic.EST, 
                    width: "220", 
                    field: "estado", 
                    sortable: true, 
                    class: "center",
                    filter:{
                        type:"select",
                        dataClient:[{etiqueta:'Activo',value:'1'},{etiqueta:'Inactivo',value:'0'}],
                        options:{label:'etiqueta',value:'value'}
                    },
                    fnCallback:function(fila,row){
                        return Tools.labelState(row.estado);
                    }
                }
            ],
            tButtons:[{
                access: pNew.permiso,
                icono: pNew.icono,
                titulo: pNew.accion,
                class: pNew.theme,
                ajax: "Exe.AccionView.formNewAccion(this);"
            }],
        sExport:{
                buttons:{excel:true,pdf:true},
                nameFile: 'axs',
                orientation: 'landscape',
                caption: lang.Acciones.TITLEEXPORT,
                columns:[
                    {title:lang.Acciones.AXION ,field:'accion',type: 'string'},
                    {title:lang.Acciones.ALAIS ,field:'alias'},
                    {title:lang.generic.EST ,field:'estado'}
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
                        fn: "Exe.AccionView.formEditAccion",
                        serverParams: "idaccion"
                    }
                }, {
                    access: pDelete.permiso,
                    icono: pDelete.icono,
                    titulo: pDelete.accion,
                    class: pDelete.theme,
                    ajax: {
                        fn: "Exe.AccionView.postDeleteAccion",
                        serverParams: "idaccion"
                    }
                }]
            },
            tScroll:{
                cRowsInVerticalScroll: 10 /*activa el scrool, se visualizara de 10 en 10*/
//                cColsInHorizontalScroll: 2
            },
            ajaxSource: _private.config.controller+public.parent.__method__(this,4),
            fnCallback: function(oSettings) {
                _private.idGrid = oSettings.tObjectTable;
            }
        });
    };
    
    public.formNewAccion = function(btn){
        public.parent.send({
            element: btn,
            dataType: 'html',
            root: _private.config.controller + public.parent.__method__(this,5),
            fnCallback: function(data) {
                $('#cont-modal').append(data);  /*los formularios con append*/
                $('#' + tabs.AXI + 'formNewAccion').modal('show');
            }
        });
    };
    
    public.formEditAccion = function(btn,id){
        _private.idAccion = id;
        public.parent.send({
            element: btn,
            dataType: 'html',
            root: _private.config.controller + public.parent.__method__(this,6),
            fnServerParams: function(sData) {
                sData.push({name: '_idAccion', value: _private.idAccion});
            },
            fnCallback: function(data) {
                $('#cont-modal').append(data);  /*los formularios con append*/
                $('#' + tabs.AXI + 'formEditAccion').modal('show');
            }
        });
    };
    
    public.postNewAccion = function(){
        public.parent.send({
            flag: 1,
            element: '#'+tabs.AXI+'btnGrabaAccion',
            root: _private.config.controller + 'postMantenimientoAccion',
            form: '#'+tabs.AXI+'formNewAccion',
            fnCallback: function(data) {
                if (parseInt(data.result) === 1) {
                    Tools.notify.ok({
                        content: lang.mensajes.MSG_3,
                        callback: function() {
                            public.getGridAcciones();
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
    
    public.postEditAccion = function(){
        public.parent.send({
            flag: 2,
            element: '#'+tabs.AXI+'btnSbAccion',
            root: _private.config.controller + 'postMantenimientoAccion',
            form: '#'+tabs.AXI+'formEditAccion',
            fnServerParams: function(sData) {
                sData.push({name: '_idAccion', value: _private.idAccion});
            },
            fnCallback: function(data) {
                if (parseInt(data.result) === 1) {
                    Tools.notify.ok({
                        content: lang.mensajes.MSG_10,
                        callback: function() {
                            Tools.closeModal('#' + tabs.AXI + 'formEditAccion');
                            Tools.refreshGrid(_private.idGrid);
                            _private.idAccion = 0;
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
    
    public.postDeleteAccion = function(btn,id){
        Tools.notify.confirm({
            content: lang.mensajes.MSG_11,
            callbackSI: function() {
                public.parent.send({
                    flag: 3,
                    element: btn,
                    root: _private.config.controller + 'postDeleteAccion',
                    fnServerParams: function(sData) {
                        sData.push({name: '_idAccion', value: id});
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