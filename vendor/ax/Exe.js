var Exe_ = Class.extend(function() {

    var _private = {};

    _private.root = function(m) {
        var l = 4; // View
        /*verificar si es view o script*/
        if(m.search('Script') > 0){
            l = 6; //Script
        }
        var c = m.split('::');
        var module  = c[0];
        var opcion  = c[1];
        var control = c[2];
        var view    = control.substr(0,control.length-l);
        return 'app/' + module + '/' + opcion + '/views/'+view+'/js/'+control;
    };

    _private.title = '';
    
    _private.breadcrumb = '';

    _private.jsArray = {};

    _private.jsArrayId = {};
    
    _private.createScript = function(scriptName, callback) {
        var scriptId = scriptName.replace(/\//g, ""); 
        var myRand   = parseInt(Math.random()*999999999999999);
        /*verificar si archivo existe*/
        var body = document.getElementsByTagName('body')[0];
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.id = 'script_' + scriptId;
        //script.async= true;
        script.src = scriptName + '.js?'+myRand;

        var onCallback = function(){
            if(callback !== undefined){
                callback();
            }
            
            var pos = scriptName.lastIndexOf('/') + 1;
            var m   = scriptName.substr(pos);
            if(m.search('View') > 0){
                _private.builtPrototipe(m,function(){ _private.executeMain(m); });
            }
            if(m.search('Script') > 0){
                _private.builtPrototipe(m);
            }
        };
        // then bind the event to the callback function
        // there are several events for cross browser compatibility
        //script.onreadystatechange = callback;
        script.onload = onCallback;

        body.appendChild(script);
        /*DESCOMENTAR CUANDO ESTE EN PRODUCCION*/
        $('#script_' + scriptId).remove();
        
        
    };

    _private.builtPrototipe = function(scriptId,callback){
        /*agrego scriptId como prototipo a Exe*/
        var sc = 'Exe_.prototype.'+scriptId+' = new '+scriptId+'_();';
        eval(sc);
        if(callback !== undefined){
            callback();
        }
    };
    
    _private.executeMain = function(scriptId) {
        /*agrego scriptId como prototipo a Exe*/
        var sc = 'Exe.'+scriptId+'.main();';
        eval(sc);
    };

    var _public = {};

    /*devuelve la raiz absoluta de la opcion*/
    _public.getRoot = function() {
        return _private.breadcrumb;
    };
    
    _public.getTitle = function() {
        return _private.title;
    };
    /*se ejecuta desde DB*/
    _public.run = function(scriptName, tthis) {
//        var parent0 = $(tthis).parent().parent().parent().parent().parent().parent().parent().parent().parent().find('a').find('span').html();
//        var parent1 = $(tthis).parent().parent().parent().parent().parent().parent().find('a').html();
//        var parent2 = $(tthis).parent().parent().parent().find('a').html();
//
//        _private.breadcrumb = parent0 + ' / ' + parent1+' / '+parent2+' / '+$(tthis).attr('title');
        _private.title = $(tthis).attr('title');

        var llamada = scriptName;               //aplication::MenuView
        var c = llamada.split('::');
        var l1 = c[0];                          //namespace
        var l2 = c[1];                          //opcion
        var l3 = c[2];                          //controller view
        
        llamada = l1+'::'+l2.toLowerCase()+'::'+l3;
        
        if (!_private.jsArray[llamada]) {
            _private.preBuilt(llamada,function(){ _private.builtPrototipe(l3,function(){ _private.executeMain(l3); }); });
        } else{
            _private.executeMain(l3);
        }
    };

    /*para incluir archivos
     * Un solo require
     * Exe.require({ aplication: 'index::IndexView' });
     * Varios requires
     * Exe.require({
            aplication: [
                'index::IndexView',
                'index::LoginView'
            ]
        });
     */
    _private.preBuilt = function(llamada,callback){
        if (!_private.jsArray[llamada]) {
            _private.jsArray[llamada] = true;
            var scriptName = _private.root(llamada);
            _private.createScript(scriptName,callback);
        }
    };
    
    _public.require = function(requires,callback){
        if(requires instanceof Object === true){
            for(var i in requires){
                /*verificar si es un array*/
                if($.isArray(requires[i])){     /*cuando se requiere varios js de una opcion de APP*/
                    for(var x in requires[i]){
                        var llamada = i+'::'+requires[i][x];
                        _private.preBuilt(llamada,callback);
                    }
                }else{                          /*cuando se requiere un js de una opcion de APP*/
                    var llamada = i+'::'+requires[i];
                    _private.preBuilt(llamada,callback); 
                }
            }
        }else{  /*se envia la ruta*/
            if (!_private.jsArray[requires]) { 
                _private.jsArray[requires] = true;
                var scriptName = requires; 

                _private.createScript(scriptName,callback);
            }
        }
        
    };
    
    return _public;
    
}());
var Exe = new Exe_();