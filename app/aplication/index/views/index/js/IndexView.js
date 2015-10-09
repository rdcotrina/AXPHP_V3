var IndexView_ = Ajax.extend(function(){
    
    var _private = {};

    _private.config = {
        controller: 'aplication/menu/Menu/'
    };
    
    _private.nivel = 0;
    
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
    
    _public.formNewMenu = function(btn,nivel){
        _private.nivel = nivel;
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
            },
            fnCallback: function(data) {
                if (parseInt(data.result) === 1) {
                    Tools.notify.ok({
                        content: lang.mensajes.MSG_3,
                        callback: function() {
                            Exe.MenuView.getListaMenu();
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
    
    return _public;
}());