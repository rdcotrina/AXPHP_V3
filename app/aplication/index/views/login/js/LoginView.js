//Exe.require({aplication: 'index::LoginScript'});
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
    
    var public = {};

    public.init = function () {
        public.parent = this; // el padre == Ajax
        _private.setAttributes();
    };
    
    public.postLogin = function() {
        _private.setAttributes();
        public.parent.send({
            flag: 1,
            element: '#btnEntrar',
            root: _private.config.controller + public.parent.__method__(this,2),
            fnServerParams: function(sData) {
                sData.push({name: '_user', value: public.parent.stringPost(_private.usuario)});
                sData.push({name: '_clave', value: public.parent.stringPost(_private.pass)});
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
    
    public.postLogout = function() {
        public.parent.send({
            root: _private.config.controller + public.parent.__method__(this,3),
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
    
    public.main = function(){};

    return public;
}());
