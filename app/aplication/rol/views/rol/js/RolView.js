var RolView_ = Ajax.extend(function(){
    
    var _private = {};

    _private.config = {
        controller: 'aplication/rol/Rol/'
    };
    
    var public = {};
    
    public.init = function () {
        public.parent = this; // el padre == Ajax
    };
    
    public.main = function(){
        Tools.addTab({
            id: tabs.ROL,
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
                $('#' + tabs.ROL + '_CONTAINER').html(data);
                public.getGrid();
            }
        });
    };
    
    public.getGrid = function(){
        var pNew    = Tools.getPermiso("ROLNEW");
        var pEdit   = Tools.getPermiso("ROLED");
        var pDelete = Tools.getPermiso("ROLDE");
        var pAcc    = Tools.getPermiso("ROLAC");
        var pDup    = Tools.getPermiso("ROLDUP");

        $("#"+tabs.ROL+"gridRol").dataGrid({
            tScrollY: "200px",
            pDisplayLength: 25,
            pOrderField: 'rol asc',
            tButtons:[{
                access: pNew.permiso,
                icono: pNew.icono,
                titulo: pNew.accion,
                class: pNew.theme,
                ajax: "Exe.RolView.formNewRol(this);"
            }],
            tColumns: [
                {title: lang.Rol.ROL,field: "rol",width: "400",sortable: true,filter: {type: 'text'}},
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
        sExport:{
                buttons:{excel:true,pdf:true},
                nameFile: 'roles',
                orientation: 'landscape',
                caption: 'RELACIÓN DE ROLES',
                columns:[
                    {title:lang.Rol.ROL ,field:'rol',type: 'string'},
                    {title:lang.generic.EST ,field:'estado'}
                ]
            },
            pPaginate: true,
            sAxions: {
                width: '170', //ancho de columna acciones
                /*se genera group buttons*/
                group: [{
                    titulo: '<i class="fa fa-gear fa-lg"></i>',
                    tooltip: 'Gestión',
                    class: 'btn bg-color-yellow txt-color-white',
                    buttons:[{
                        access: pAcc.permiso,
                        icono: pAcc.icono,
                        titulo: pAcc.accion,
                        class: pAcc.theme,
                        ajax: {
                            fn: "Exe.RolView.getFormAccesos",
                            serverParams: ["idrol","rol"]
                        }
                    },{
                        access: pDup.permiso,
                        icono: pDup.icono,
                        titulo: pDup.accion,
                        class: pDup.theme,
                        ajax: {
                            fn: "Acciones.getEditAccion",
                            serverParams: "idrol"
                        }
                    }]
                },{
                    titulo: '<i class="fa fa-wrench fa-lg"></i>',
                    tooltip: 'Mantenimiento',
                    class: 'btn bg-color-blueDark txt-color-white',
                    buttons: [{
                        access: pEdit.permiso,
                        icono: pEdit.icono,
                        titulo: pEdit.accion,
                        class: pEdit.theme,
                        ajax: {
                            fn: "Exe.RolView.getEditRol",
                            serverParams: "idrol"
                        }
                    }, {
                        access: pDelete.permiso,
                        icono: pDelete.icono,
                        titulo: pDelete.accion,
                        class: pDelete.theme,
                        ajax: {
                            fn: "Exe.RolView.postDeleteRol",
                            serverParams: "idrol"
                        }
                    }]
                }]
            },
            tScroll:{
//                cFixedColsLeft: 2,
//                cFixedColsRight: 1,
//                cColsInHorizontalScroll: 2,
                cRowsInVerticalScroll: 10
            },
            ajaxSource: _private.config.modulo+"getGrid",
            fnCallback: function(oSettings) {
                _private.idGrid = oSettings.tObjectTable;
            }
        });
    };
    
    return public;
    
}());