Exe.require({aplication: 'menu::MenuScript'});
var MenuView_ = Ajax.extend(function(){
    
    var _private = {};

    _private.config = {
        controller: 'aplication/menu/Menu/'
    };
    
    _private.nivel = '';
    
    _private.parent = '';
    
    var _public = {};

    _public.init = function () {
        _public.parent = this; // el padre == Ajax
    };
    
    _public.main = function(){
        Tools.addTab({
            id: tabs.MENU,
            label: Exe.getTitle(),
            fnCallback: function() {
                Exe.MenuView.index(Exe.getTitle());
            }
        });
    };
    
    _public.index = function(title){
        _public.parent.send({
            dataType: 'html',
            root: _private.config.controller + _public.parent.__method__(this,3),
            fnServerParams: function(sData) {
                sData.push({name: '_rootTitle', value: title});
            },
            fnCallback: function(data) {
                $('#' + tabs.MENU + '_CONTAINER').html(data);
            }
        });
    };
    
    _public.formNewMenu = function(btn,nivel,parent){
        _private.nivel = nivel;
        _private.parent= parent;
        
        _public.parent.send({
            element: btn,
            dataType: 'html',
            root: _private.config.controller + _public.parent.__method__(this,4),
            fnCallback: function(data) {
                $('#cont-modal').append(data);  /*los formularios con append*/
                $('#' + tabs.MENU + 'formNewMenu').modal('show');
            }
        });
    };
    
    _public.postNewMenu = function(){
        _public.parent.send({
            flag: 1,
            element: '#'+tabs.MENU+'btnGrabaMnu',
            root: _private.config.controller + _public.parent.__method__(this,5),
            form: '#'+tabs.MENU+'formNewMenu',
            fnServerParams: function(sData) {
                sData.push({name: '_nivel', value: _private.nivel});
                sData.push({name: '_parent', value: _private.parent});
            },
            fnCallback: function(data) {
                if (parseInt(data.result) === 1) {
                    Tools.notify.ok({
                        content: lang.mensajes.MSG_3,
                        callback: function() {
                            _public.listaMenu();
                            _private.nivel = '';
                            _private.parent = '';
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
    
    _public.listaMenu = function(){
        _public.parent.send({
            dataType: 'html',
            gifProcess: true,
            root: _private.config.controller + _public.parent.__method__(this,6),
            fnCallback: function(data) {
                $('.cont-listadominios').html(data);
            }
        });
    };
    
    _public.postOrdenar = function() {
        var tipo = Tools.getParam(arguments[0]);
        var ids = Tools.getParam(arguments[1]);

        switch (tipo) {
            case 'DOM': /*ordenear modulos*/
                _public.postSortDominios(ids);
                break;
            case 'MOD': /*ordenear modulos*/
                _public.postSortModulos(ids);
                break;
            case 'MNU': /*ordenear menu principal*/
                _public.postSortMenu(ids);
                break;
            case 'OPC': /*ordenear opciones*/
                _public.postSortOpciones(ids);
                break;
            case 'OPC5': /*ordenear opciones*/
                _public.postSortOpciones5(ids);
                break;
            case 'OPC6': /*ordenear opciones*/
                _public.postSortOpciones6(ids);
                break;
        }
    };
    
    _public.postSortDominios = function(ids){
        alert(ids)
    };
    
    return _public;
}());