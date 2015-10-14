var FasesView_ = Ajax.extend(function(){
    
    var _private = {};
    
    _private.config = {
        controller: 'admision/fases/Fases/'
    };
    
    var public = {};
    
    public.init = function () {
        public.parent = this; // el padre == Ajax
    };
    
    public.main = function(){
        Tools.addTab({
            id: tabs.FASE,
            label: Exe.getTitle(),
            fnCallback: function() {
                public.index(Exe.getTitle());
            }
        });
    };
    
    public.index = function(title){
        public.parent.send({
            dataType: 'html',
            root: _private.config.controller + 'index',
            fnServerParams: function(sData) {
                sData.push({name: '_rootTitle', value: title});
            },
            fnCallback: function(data) {
                $('#' + tabs.FASE + '_CONTAINER').html(data);
                public.getGridFases();
            }
        });
    };
    
    public.getGridFases = function (){
        var pNew    = Tools.getPermiso("FASENEW");
        var pEdit   = Tools.getPermiso("FASEED");
        var pDelete = Tools.getPermiso("FASEDE");

        $("#"+tabs.FASE+"gridFases").dataGrid({
            tScrollY: "200px",
            pDisplayLength: 25,
            tShowHideColumn: true,
            pOrderField: 'descripcion asc',
            tColumns: [
                {title: lang.generic.DESC,field: "descripcion",width: "300",sortable: true,filter: {type: 'text'}},
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
                ajax: "Exe.FasesView.formNewFase(this);"
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
                        fn: "Exe.FaseView.formEditFase",
                        serverParams: "idfase"
                    }
                }, {
                    access: pDelete.permiso,
                    icono: pDelete.icono,
                    titulo: pDelete.accion,
                    class: pDelete.theme,
                    ajax: {
                        fn: "Exe.FaseView.postDeleteFase",
                        serverParams: "idfase"
                    }
                }]
            },
            tScroll:{
                cRowsInVerticalScroll: 10 /*activa el scrool, se visualizara de 10 en 10*/
//                cColsInHorizontalScroll: 2
            },
            ajaxSource: _private.config.controller+'getGridFases',
            fnCallback: function(oSettings) {
                _private.idGrid = oSettings.tObjectTable;
            }
        });
    };
    
    
    return public;
    
}());