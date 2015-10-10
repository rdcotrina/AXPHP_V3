var MenuScript_ = MenuView_.extend(function(){
    
    var _public = {};

    _public.init = function () {
        _public.parent = this; // el padre == MenuView_
    };
    
   _public.sortable = function(){
       //    mover listas nivel 1
        $("."+tabs.MENU+"ul-dominios").sortable({
            update: function () {
                var ordenElementos = $(this).sortable("toArray",{attribute: 'data-doorden'}).toString(); 
                _public.parent.postOrdenar('DOM',ordenElementos);
            }
        });

        //    mover listas nivel 2
        $("."+tabs.MENU+"ul-modulos").sortable({
            update: function () {
                var ordenElementos = $(this).sortable("toArray",{attribute: 'data-moorden'}).toString(); 
                _public.parent.postOrdenar('MOD',ordenElementos);
            }
        });
        
        //    mover listas nivel 3
        $("."+tabs.MENU+"ul-menus").sortable({
            update: function () {
                var ordenElementos = $(this).sortable("toArray",{attribute: 'data-meorden'}).toString(); 
                _public.parent.postOrdenar('MNU',ordenElementos);
            }
        });
        
        //    mover listas nivel 4
        $("."+tabs.MENU+"ul-opciones").sortable({
            update: function () {
                var ordenElementos = $(this).sortable("toArray",{attribute: 'data-opcorden'}).toString(); 
                _public.parent.postOrdenar('OPC',ordenElementos);
            }
        });
        
        //    mover listas nivel 5
        $("."+tabs.MENU+"ul-menu5").sortable({
            update: function () {
                var ordenElementos = $(this).sortable("toArray",{attribute: 'data-opc5orden'}).toString(); 
                _public.parent.postOrdenar('OPC5',ordenElementos);
            }
        });
        
        //    mover listas nivel 6
        $("."+tabs.MENU+"ul-menu6").sortable({
            update: function () {
                var ordenElementos = $(this).sortable("toArray",{attribute: 'data-opc6orden'}).toString(); 
                _public.parent.postOrdenar('OPC6',ordenElementos);
            }
        });
   };
   
   _public.menuRight = function(){
       $(".menuRight").menuRight({
            menu: '#'+tabs.MENU+'myMenuRright',
            callback: function (element, idTarget) {
                var action = $(element).data('href');
                var id = $('#'+idTarget).attr('data-id');;
                var nivel = $('#'+idTarget).attr('data-nivel');
               
                switch(nivel.toString()){
                    /*DOMINIOS*/
                    case 'N1':
                        switch (action) {
                            case 'NEW':
                                                        /*--,nivel,parent*/
                                Exe.MenuView.formNewMenu(null,2,id);
                                break;
                            case 'EDIT':
                                Exe.MenuView.formEditMenu(id,1);
                                break;
                            case 'DELETE':
                                Exe.MenuView.postDeleteMenu(id);
                                break;
                        }
                        break;
                    /*MODULOS*/
                    case 'N2':
                        var idDominio = $('#'+idTarget).attr('data-dominio');
                        switch (action) {
                            case 'NEW':
//                                Menu.getFormNewMenu(id);
                                break;
                            case 'EDIT':
//                                Menu.getFormEditModulo(id,idDominio);
                                break;
                            case 'DELETE':
//                                Menu.postDeleteModulo(id);
                                break;
                        }
                        break;
                    /*MENUS*/
                    case 'N3':
                        var idModulo = $('#'+idTarget).attr('data-modulo');
                        switch (action) {
                            case 'NEW':
//                                Menu.getFormNewOpcion(id);
                                break;
                            case 'EDIT':
//                                Menu.getFormEditMenu(id,idModulo);
                                break;
                            case 'DELETE':
//                                Menu.postDeleteMenu(id);
                                break;
                        }
                        break;
                    /*OPCION*/
                    case 'N4':
                        var idMenu = $('#'+idTarget).attr('data-menu');
                        /*desabilitar opcion Nuevo en menu derecho|*/
                        switch (action) {
                            case 'NEW':
                                /*nada*/
                                break;
                            case 'EDIT':
//                                Menu.getFormEditOpcion(id,idMenu);
                                break;
                            case 'DELETE':
//                                Menu.postDeleteOpcion(id);
                                break;
                        }
                        break;
                }
            }
        });
   };
   
   return _public;
}());