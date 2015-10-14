var MenuScript_ = MenuView_.extend(function(){
    
    var public = {};

    public.init = function () {
        public.parent = this; // el padre == MenuView_
    };
    
   public.sortable = function(){
       //    mover listas nivel 1
        $("."+tabs.MENU+"ul-dominios").sortable({
            update: function () {
                var ordenElementos = $(this).sortable("toArray",{attribute: 'data-doorden'}).toString(); 
                public.parent.postOrdenar(1,ordenElementos);
            }
        });

        //    mover listas nivel 2
        $("."+tabs.MENU+"ul-modulos").sortable({
            update: function () {
                var ordenElementos = $(this).sortable("toArray",{attribute: 'data-moorden'}).toString(); 
                public.parent.postOrdenar(2,ordenElementos);
            }
        });
        
        //    mover listas nivel 3
        $("."+tabs.MENU+"ul-menus").sortable({
            update: function () {
                var ordenElementos = $(this).sortable("toArray",{attribute: 'data-meorden'}).toString(); 
                public.parent.postOrdenar(3,ordenElementos);
            }
        });
        
        //    mover listas nivel 4
        $("."+tabs.MENU+"ul-opciones").sortable({
            update: function () {
                var ordenElementos = $(this).sortable("toArray",{attribute: 'data-opcorden'}).toString(); 
                public.parent.postOrdenar(4,ordenElementos);
            }
        });
        
        //    mover listas nivel 5
        $("."+tabs.MENU+"ul-menu5").sortable({
            update: function () {
                var ordenElementos = $(this).sortable("toArray",{attribute: 'data-opc5orden'}).toString(); 
                public.parent.postOrdenar(5,ordenElementos);
            }
        });
        
        //    mover listas nivel 6
        $("."+tabs.MENU+"ul-menu6").sortable({
            update: function () {
                var ordenElementos = $(this).sortable("toArray",{attribute: 'data-opc6orden'}).toString(); 
                public.parent.postOrdenar(6,ordenElementos);
            }
        });
   };
   
   public.menuRight = function(){
       $(".menuRight").menuRight({
            menu: '#'+tabs.MENU+'myMenuRright',
            callback: function (element, idTarget) {
                var action = $(element).data('href');
                var id = $('#'+idTarget).attr('data-id');;
                var nivel = parseInt($('#'+idTarget).attr('data-nivel'));
               
               
                switch (action) {
                    case 'NEW':
                        /*para el ultimo nivel aplica boton nuevo*/
                        if(nivel < 6){
                                                     /*--,   nivel,  parent*/
                            Exe.MenuView.formNewMenu(null,(nivel + 1),id);
                        }
                        break;
                    case 'EDIT':
                        Exe.MenuView.formEditMenu(id,nivel);
                        break;
                    case 'DELETE':
                        Exe.MenuView.postDeleteMenu(id);
                        break;
                }
            }
        });
   };
   
   return public;
}());