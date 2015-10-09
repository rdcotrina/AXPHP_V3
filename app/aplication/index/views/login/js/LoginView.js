Exe.require({aplication: 'index::LoginScript'});
var LoginView_ = Ajax.extend(function(){
    
    var _private = {};

    _private.config = {
        controller: 'aplication/index/Login/'
    };
    
    _private.usuario = '';
    
    _private.pass = '';
    
    _private.setAttributes = function(){
        _private.usuario = $('#txtUser').val();
        _private.pass    = $('#txtClave').val();
    };
    
    var _public = {};

    _public.init = function () {
        _public.parent = this; // el padre == Ajax
        _private.setAttributes();
    };
    
    _public.postLogin = function() {
        _private.setAttributes();
        _public.parent.send({
            flag: 1,
            element: '#btnEntrar',
            root: _private.config.controller + _public.parent.__method__(this,2),
            fnServerParams: function(sData) {
                sData.push({name: '_user', value: _public.parent.stringPost(_private.usuario)});
                sData.push({name: '_clave', value: _public.parent.stringPost(_private.pass)});
            },
            fnCallback: function(data) {
                if (data.idusuario > 0 && localStorage.getItem('mainBodyHtml') === 'null') {
                    Tools.notify.ok({
                        content: lang.mensajes.MSG_2,
                        callback: function() {
                            Tools.reload();
                        }
                    });
                }else if (data.idusuario > 0 && localStorage.getItem('mainBodyHtml') !== 'null') {
                    Tools.notify.ok({
                        content: lang.mensajes.MSG_2
                    });
                    /*se debloquea el sistema*/
                    IndexScript.unLockApp();
                }else {
                    Tools.notify.error({
                        content: lang.mensajes.MSG_1
                    });
                }
            }
        });
    };
    
    _public.postLogout = function() {
        _public.parent.send({
            root: _private.config.controller + _public.parent.__method__(this,3),
            fnCallback: function(data) {
                if (parseInt(data.result) === 1) {
                    Tools.notify.ok({
                        content: lang.mensajes.MSG_11
                    });
                    Tools.reload();
                }
            }
        });
    };
    
    _public.main = function(){};

    return _public;
}());
