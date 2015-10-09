var Class = function () {};

Class.extend = function (prop) {
    // Este es el proto de la clase de la que se extiende
    // (es decir, el padre)
    var _super = this.prototype;

    // Hacemos el truco del constructor vacio para mantener
    // la cadena de prototipos pero sin ejecutar el constructor
    // del padre innecesariamente!
    function F() {}
    F.prototype = _super;
    var proto = new F();

    // recorremos el objeto que nos han pasado como parametro...
    for (var name in prop) {
        // Comprobar que existe el super-metodo ::: _super en init() de class
        // si no existe, no tiene sentido inyectar nada!
        
        if (typeof prop[name] == "function" && typeof _super[name] == "function") {
            // Se envuelve en una funcion inmediata para
            // clausurar el valor de name y fn
            proto[name] = (function (name, fn) {
                return function () {
                    // guardamos lo que tuviera _super...
                    var tmp = this._super;
                    // this._super = supermetodo (en proto del padre)
                    this._super = _super[name];
                    // aplicamos el metodo decorado (guardamos el retorno)
                    var ret = fn.apply(this, arguments);
                    // se restaura el valor que tenia this._super
                    this._super = tmp;
                    // devolvemos lo que haya devuelto el metodo decorado
                    return ret;
                };
            })(name, prop[name]);
        } else {
            // Si no hay supermetodo o no es una funcion,
            // nos limitamos a copiar la propiedad
            proto[name] = prop[name];
        }
    }

    function Klass() {
        // Si existe this.init, lo llamamos al construir
        // una nueva instancia
        if (this.init && typeof this.init == "function") {
            return this.init.apply(this, arguments);
        }
    }

    Klass.prototype = proto;
    // Ponemos a mano el nuevo valor del constructor
    Klass.prototype.constructor = Klass;

    // Para que se pueda heredar de las clases generadas,
    // copiamos la funcion .extend
    Klass.extend = this.extend;

    // Devolvemos la nueva clase
    return Klass;
};

////////////////////////////////////////
//          EJEMPLO DE USO            //
////////////////////////////////////////

/*
 
 var Person = Class.extend(function () {

    var _private = {};

    _private.algo = function () {
        return 'metodo privado';
    };

    var _public = {};

    _public.init = function (name) {
        console.log("Bienvenido, " + name);
        this.name = name;
    };
    _public.bailar = function () {
        console.log("tanana nana, nana, nana..." + _private.algo());
    };
    _public.piernas = 2;

    return _public;
    
}());

var Ninja = Person.extend(function () {

    var _public = {};

    _public.init = function () {
        console.log("NINJA EN ACCION!");
        this._super("ninja jitsu");
    };

    return _public;

}());

var n = new Ninja();
n.bailar();
 
 */