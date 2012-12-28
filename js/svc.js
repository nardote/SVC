var equalsObj = function( x, y ) {
  if ( x === y ) return true;
    // if both x and y are null or undefined and exactly the same

  if ( ! ( x instanceof Object ) || ! ( y instanceof Object ) ) return false;
    // if they are not strictly equal, they both need to be Objects

  if ( x.constructor !== y.constructor ) return false;
    // they must have the exact same prototype chain, the closest we can do is
    // test there constructor.

  for ( var p in x ) {
    if ( ! x.hasOwnProperty( p ) ) continue;
      // other properties were tested using x.constructor === y.constructor

    if ( ! y.hasOwnProperty( p ) ) return false;
      // allows to compare x[ p ] and y[ p ] when set to undefined

    if ( x[ p ] === y[ p ] ) continue;
      // if they have the same strict value or identity then they are equal

    if ( typeof( x[ p ] ) !== "object" ) return false;
      // Numbers, Strings, Functions, Booleans must be strictly equal

    if ( ! Object.equals( x[ p ],  y[ p ] ) ) return false;
      // Objects and Arrays must be tested recursively
  }

  for ( p in y ) {
    if ( y.hasOwnProperty( p ) && ! x.hasOwnProperty( p ) ) return false;
      // allows x[ p ] to be set to undefined
  }
  return true;
}


//tools
var herramientas = function () {
    
    this.ajax = function  (config) {
        
            //valores por default
            var def = {
                url: '',
                asyc: true,
                method: 'GET',
                callback: function () { }
            };
            //remplazo los valores default por los pasados en el controlador
            var objFinal = this.setOptions(def, config), xmlhttp;
        
        
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    objFinal.callback(xmlhttp.responseText);

                }
            }

            //para re ver si lo pongo asyncronico se me pisan los onready state change
            xmlhttp.open(objFinal.method, objFinal.url, objFinal.asyc);
            xmlhttp.send();
        
        
    }   
    
    //se encarga de compatibilizar con los valores por default
    this.setOptions = function (def, config) {
        for (var key in def) {

            if (config[key] != undefined) {
                def[key] = config[key];
            }

        }

        return def;

    }
    
    //var cache = {};  
    this.tmpl = function (str, data){
    // Figure out if we're getting a template, or if we need to
    // load the template - and be sure to cache the result.
    var fn = 
    
        /*!/\W/.test(str) ?
        cache[str] = cache[str] ||
        tmpl(document.getElementById(str).innerHTML) :*/
      
        // Generate a reusable function that will serve as a template
        // generator (and which will be cached).
        new Function("obj",
        "var p=[],print=function(){p.push.apply(p,arguments);};" +
        
        // Introduce the data as local variables using with(){}
        "with(obj){p.push('" +
        
        // Convert the template into pure JavaScript
        str
            .replace(/[\r\t\n]/g, " ") // formatea el texto para que quede en un linea, seguro es para hacer mas eficiente los siguentes regex
            .split("{{").join("\t")  // quita los tags mustachos de inicio
            .replace(/((^|}})[^\t]*)'/g, "$1\r") // aca extrañamente no hace nada quizas aplica para algo mas complejo dentro de un for???
            .replace(/\t=(.*?)}}/g, "',$1,'") // aca tira magia agarra todas las variables a remplazar incluso las que esten en un for y las envuelve en ',varName,'
            .split("\t").join("');") // le agrega al final de cada "bloque" de html esto "');" para poder identificarlos luego, devualta incluso el bloque que este dentro d ui for, pero no el for!!!
            .split("}}").join("p.push('") // completa el cierre "');" que habia generado antes con la apertura "p.push('"
            .split("\r").join("\\'") // supongo es algo preventivo, porque no deberian quedar mas enters
        + "');}return p.join('');");
    
        // Provide some basic currying to the user
        return data ? fn( data ) : fn;
    };
    
    
    
   
    

}

var onHashChange = function (iniDisparador) {

    this.lastHash = '';
    this.lastVars = '';
    var iniDisparador = iniDisparador;

    var getHash = function () {
        var arr = window.location.hash.split("#!");

        var hasValue = arr[1];
        //sets default
        if (typeof hasValue == "undefined") {
            // return false;
            hasValue = iniDisparador;
        } else {

            var variables = getUrlVars();

            var hashLen = hasValue.indexOf("$");
            if (hashLen > 0) {
                hasValue = hasValue.substring(0, hashLen);
            }
        }


        return { hash: hasValue, vars: variables };
    }

    //listener de hash
    var watchHash = function (callback) {


        var gets = getHash();


        if (gets.hash !== this.lastHash || !equalsObj(gets.vars,this.lastVars)) {
            // event();
            this.lastHash = gets.hash;
            this.lastVars = gets.vars

            callback(gets);

            if (typeof _gaq != "undefined") {
                _gaq.push(['_trackPageview', document.location.href]);
            }
        }

    }

    var getUrlVars = function () {
        var vars = {};
        var parts = window.location.href.replace(/[$&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
            vars[key] = value;
        });
        return vars;
    }

    this.init = function (callback) {

        if ("onhashchange" in window) {

            window.onhashchange = function () {

                watchHash(callback);
            }
            watchHash(callback);
        } else {
            setInterval(function () {

                watchHash(callback);

            }, 100);
        }

    }

}

//cross Object key e ie no tiene este metodo
Object.keys = Object.keys || function(o) {
    var result = [];
    for(var name in o) {
        if (o.hasOwnProperty(name))
          result.push(name);
    }
    return result;
};

var SVC = function () {

    this.mvcObj = {},
    t = this,
    this.conexiones = [],
    this.instanciaControlador = null;
    
    this.constructor = function (config) {

        var obj = config; //Object.create(config);
        if (obj.disparador == 'undefined') {
            alert("Debe definir el disparador");
        }
        //valores por default
        var def = {
            disparador: '',
            urlPlantilla: 'none',
            urlAlimentacion: 'none',
            alimentacionCacheable: false,
            destino: 'body',
            relevancia: 10,

            controlador: function () { }
        }
        //remplazo los valores default por los pasados en el controlador
        var herra = new herramientas();
        var objFinal = herra.setOptions(def, obj);


        this.mvcObj[objFinal.disparador] = new Object();        
        this.mvcObj[objFinal.disparador].controlador = objFinal.controlador;
        this.mvcObj[objFinal.disparador].urlPlantilla = objFinal.urlPlantilla;
        this.mvcObj[objFinal.disparador].plantilla = 'none';

        this.mvcObj[objFinal.disparador].disparador = objFinal.disparador;
        this.mvcObj[objFinal.disparador].destino = objFinal.destino;
        this.mvcObj[objFinal.disparador].relevancia = objFinal.relevancia;

        
        this.mvcObj[objFinal.disparador].urlAlimentacion = objFinal.urlAlimentacion;
        this.mvcObj[objFinal.disparador].alimentacionInfo = 'none';
        this.mvcObj[objFinal.disparador].alimentacionInfoCacheable = objFinal.alimentacionCacheable;
        //ver estos nombbres
        this.mvcObj[objFinal.disparador].disparadorObj = 'none';

    }

    this.init = function (iniDisparador) {

        new this.callPreEjecutar(t)._constructor();

        var lishash = new onHashChange(iniDisparador);
      
        lishash.init(function (disparador) {
            t.mvcObj[disparador.hash].disparadorObj = disparador;
            t.disparadorActual = disparador.hash;
            t.despachador(disparador);
            t.leoTemplates();
        });

    }

    this.despachador = function (disparador, preEjecucion) {
        var t = this;
        
        if (disparador.hash != false) {

            //si la plantilla no existe
            if (this.mvcObj[disparador.hash].plantilla == 'none') {

                //la descargo
                this.descargarPlantilla(disparador, false, function (disparador) {

                    t.alimentador({
                        url: t.mvcObj[disparador.hash].urlAlimentacion,
                        vars: disparador.vars,
                        hash: disparador.hash,
                        callback: function (alimentacion) {
                            if(preEjecucion != false){
                                new t.callPreEjecutarVista(t)._constructor();
                            }
                            t.acoplador(t.mvcObj[disparador.hash], alimentacion);
                            if(preEjecucion != false){
                                new t.callPostEjecutarVista(t)._constructor();
                            }
                        }
                    });
                    
                   
                    if(t.instanciaControlador  !=  null) {
                        t.instanciaControlador._destructor();
                    }

                    t.instanciaControlador = new t.mvcObj[disparador.hash].controlador(t);

                    t.instanciaControlador._constructor();
               
                });

            } else if (this.mvcObj[disparador.hash].plantilla == 'onDownload') {

                setTimeout(function () {
                    this.despachador(disparador);
                }, 100);

            } else {

                
                this.alimentador({
                    url: this.mvcObj[disparador.hash].urlAlimentacion,
                    vars: disparador.vars,
                    hash: disparador.hash,
                    callback: function (alimentacion) {
                        t.callPreEjecutarVista(t);
                        t.acoplador(t.mvcObj[disparador.hash], alimentacion);
                        t.callPostEjecutarVista(t);
                    }
                });


                if(t.instanciaControlador !=  null) {
                    t.instanciaControlador._destructor();
                }

                t.instanciaControlador = new t.mvcObj[disparador.hash].controlador(t);

                t.instanciaControlador._constructor();
                    
               
              

            }
        } else {

        }
    }

  

    this.descargarPlantilla = function (disparador, asyc, callback) {


        if (this.mvcObj[disparador.hash].urlPlantilla != 'none' && this.mvcObj[disparador.hash].plantilla == 'none') {

            this.mvcObj[disparador.hash].plantilla = 'onDownload';

            var url = this.mvcObj[disparador.hash].urlPlantilla;

            var herra = new herramientas();
            herra.ajax({
                url: url,
                asyc: asyc,
                method: 'GET',
                callback: function (data) {
                    var obj = t.mvcObj[disparador.hash];
                    obj.plantilla = data;
                    callback(disparador);


                }
            });



        } else if (this.mvcObj[disparador].plantilla == 'onDownload') {
        }

    }

    //el alimentador es el encargado e traer la infomacion del servidor para popular la plantilla     
    this.alimentador = function (config) {

        if (config.url != 'none') {

            var stringVars = '?';
            for (var key in config.vars) {

                stringVars += key + '=' + config.vars[key] + '&';

            }

            //traigo contenido json

            if(t.mvcObj[config.hash].alimentacionInfo == 'none') {

                var herra = new herramientas();
                herra.ajax({
                    url: config.url + stringVars,
                    asyc: false,
                    method: 'GET',
                    callback: function (data) {
                        t.mvcObj[config.hash].alimentacionInfo = JSON.parse(data);

                        config.callback(t.mvcObj[config.hash].alimentacionInfo);

                    }
                });

            } else {
                //si no se debe cachear lo vuelvo a traer
                if(t.mvcObj[config.hash].alimentacionInfoCacheable == false) {
                     var herra = new herramientas();
                        herra.ajax({
                            url: config.url + stringVars,
                            asyc: false,
                            method: 'GET',
                            callback: function (data) {
                                t.mvcObj[config.hash].alimentacionInfo = JSON.parse(data);

                                config.callback(t.mvcObj[config.hash].alimentacionInfo);

                            }
                        });



                } else {
                    //si no lo leo del objeto general
                    config.callback(t.mvcObj[config.hash].alimentacionInfo);

                }   
                
            }

        } else {

            config.callback(false);

        }

    }
    //el acoplador se encarga de inyectar la informacion del alminetador en la plantilla
    this.acoplador = function (plantilla, alimentacion) {

        if (alimentacion != false) {
            var jsons = alimentacion;
       

            if (typeof jsons['_head'] !== 'undefined') {

                //remuevo los metas
                var head = document.getElementsByTagName("head")[0];
                var metas = document.getElementsByTagName("meta");

                for (var rep in metas) {
                    try {
                        if(metas[rep].name!="fragment") {
                            head.removeChild(metas[rep]);
                        }
                    } catch (e) { }
                }


                //agrego metas
                for (var rep in jsons['_head']['metas']) {
                    var oScript = document.createElement("meta");
                    for (var rep2 in jsons['_head']['metas'][rep]) {

                        oScript.setAttribute(rep2, jsons['_head']['metas'][rep][rep2]);

                    }
                    head.appendChild(oScript);
                }

            }

            var herra = new herramientas();
            plantilla.plantilla = herra.tmpl(plantilla.plantilla, jsons);

        }
        this.imprimir(plantilla.plantilla, plantilla.destino);

    }
    //se enacarga de ponerlo en el body
    this.imprimir = function (html, destino) {

        document.getElementById(destino).innerHTML = html;
       

    }

    this.leoTemplates = function () {

        var relevancias = this.ordenarCarga(this.mvcObj);



        for (var i in relevancias) {
            for (var k in relevancias[i]) {
                var key = relevancias[i][k];

                if (this.mvcObj[key].urlPlantilla != 'none' && this.mvcObj[key].plantilla == 'none') {

                    t.descargarPlantilla({ hash: key, vars: '' }, true, function () { });

                }
            }

        }
    }
    //segun la relevancia ordena la carga de plantillas
    this.ordenarCarga = function (mvcObj) {

        var relevancias = [];


        for (var key in mvcObj) {

            if (Object.prototype.toString.call(relevancias[mvcObj[key].relevancia]) !== '[object Array]') {
                relevancias[mvcObj[key].relevancia] = [];
            }
            relevancias[mvcObj[key].relevancia].push(mvcObj[key].disparador);


        }

        return relevancias;
    }

    //codigo que se ejecuta simpre que se inicia la pagina
    this.preEjecutar = function (callback) {

        this.callPreEjecutar = callback.controlador;

    }
    //codigo que se ejecuta simpre que se ejecuta un contructor
    //TODO: tiene que frenar la ejecucion de alguna manera para que se termine de ejecutar este callback
    //y luego remplaze todo
    this.preEjecutarVista = function (callback) {

        this.callPreEjecutarVista = callback.controlador;

    }
    //codigo que se ejecuta simpre que se finaliza contructor
    this.postEjecutarVista = function (callback) {

        this.callPostEjecutarVista = callback.controlador;

    }

    this.getDebug = function () {
        this.clearDebug();
        var a = '<div style="position:absolute; top:0; left:100px; width:200px; z-index:99999999999999; " id="debuger-svc"><table border="1" style="font-size:10px;background:#fff; color:#333;">';

        for (var key in this.mvcObj) {

            a += '<tr>';
            a += '<td colspan="2">' + key + '</td>';
            a += '</tr>';
            for (var key2 in this.mvcObj[key]) {

                a += '<tr>';
                if (key2 == 'plantilla' && this.mvcObj[key][key2] != 'none') {
                    a += '<td>' + key2 + '</td><td>Ya tiene contenido</td>';
                } else {
                    a += '<td>' + key2 + '</td><td>' + this.mvcObj[key][key2] + '</td>';
                }
                a += '</tr>';

            }

        }

        a += '</table></div>';
        document.body.innerHTML += a;

    }
    this.clearDebug = function () {
        var elem=document.getElementById('debuger-svc');
        if(elem != null) {
            return (elem).parentNode.removeChild(elem);
        }
    }

    //trae la infomacion para el objeto del disparador actual
    this.getObjActual = function () {

        return this.mvcObj[this.disparadorActual];

    }

}   
