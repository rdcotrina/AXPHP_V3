var MediosCalificacionView_ = Ajax.extend(function(){
    
    var _private = {};

    _private.config = {
        controller: 'admision/medioscalificacion/MediosCalificacion/'
    };
    
    var public = {};
    
    public.init = function () {
        public.parent = this; // el padre == Ajax
    };
    
    public.main = function(){
        Tools.addTab({
            id: tabs.MECA,
            label: Exe.getTitle(),
            fnCallback: function() {
//                public.index(Exe.getTitle());
            }
        });
    };
    
    return public;
    
}());
