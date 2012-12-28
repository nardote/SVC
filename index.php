<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
    <title>Ndway</title>
    <meta name="fragment" content="!">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="Ndway" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="http://tiomario.testing.ndwcdn.com.ar/web/img/logo.png" />
    <meta property="og:site_name" content="Jugueterías Tío Mario" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" href="css/ie7.css">
    <![endif]-->
    <!--[if lt IE 9]>
    <script>
        document.createElement('header');
        document.createElement('nav');
        document.createElement('section');
        document.createElement('article');
        document.createElement('aside');
        document.createElement('footer');
        document.createElement('hgroup');
    </script>    
    <![endif]-->    
    <script type="text/javascript" src="js/json2.js"></script>
	<script type="text/javascript" src="js/svc.js"></script>
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.9.1.custom.min.js"></script>
    <script type="text/javascript" src="js/slider.js"></script>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36392263-1']);
        
        //_gaq.push(['_trackPageview']); // siempre dispara el metodo: "watchHash"

        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
    <script>
        var serverUrl = "";

        window.onload = function () {
            
          
            //inicio mvc
            var mvc = new SVC();

            mvc.preEjecutar({
                controlador: function (t) {
                    
                              this._constructor = function () {
                                  
                                t.despachador({ hash: 'menu', vars: '' }, false);
                                t.despachador({ hash: 'footer', vars: '' }, false);

                                    /* parche para tonglear el menu */
                                    $('.btn-navbar').click(function(){

                                      $('.nav-480').toggleClass('active');
                                      $('.navbar-inner').toggleClass('collapse-menu');
                                      $(this).toggleClass('active');
                                        return false;
                                    });

                                var state = 0;
                               $(window).scroll(function () {

                                    var value = $(this).scrollTop();
                                    if ( value < 50 && state != 1 ) {
                                        state = 1;
                                        $(".navbar-inner").stop(true, true).animate ({
                                                        height:74
                                                        },600,'easeOutExpo');

                                        $(".nav li a").stop(true, true).animate ({
                                                        'margin-top':0
                                                        },600,'easeOutExpo');
                                        $(".contacto").stop(true, true).animate ({
                                                        'margin-top':27
                                                         },600,'easeOutExpo');
                                        $(".logo").stop(true, true).animate ({
                                                        'height':43,
                                                        'width':142
                                                         },600,'easeOutExpo');
                                        $(".dropdown").stop(true, true).animate({
                                                        'top':18
                                                        },600,'easeOutExpo');


                                    } else if ( value >= 50 && state == 1 ) {

                                        state = 0;
                                        $(".navbar-inner").stop(true, true).animate ({
                                                        height:40
                                                        },600,'easeOutExpo');
                                        $(".nav li a").stop(true, true).animate ({
                                                        'margin-top':6
                                                        },600,'easeOutExpo');
                                        $(".contacto").stop(true, true).animate ({
                                                        'margin-top':32
                                                         },600,'easeOutExpo');
                                        $(".logo").stop(true, true).animate ({
                                                        'height':27,
                                                        'width':89
                                                         },600,'easeOutExpo');
                                        $(".dropdown").stop(true, true).animate({
                                                        'top':15
                                                        },600,'easeOutExpo');
                                    }
                               })
                            }

                            this._destructor= function () {

                               

                            }
                     
                }
            });

            mvc.preEjecutarVista({
                controlador: function (t) {
                                 this._constructor = function () {
                                     
                                    $("#" + t.getObjActual().destino).hide();
                                    
                                 } 
                                 this._destructor= function () {
                                     
                                 }
                    
                }
            });

            mvc.postEjecutarVista({
                controlador: function (t) {
                    
                            this._constructor = function () {
                                
                                $("#" + t.getObjActual().destino).fadeIn(1000);
                                //menu
                                $(".arrow-s").addClass("hidden");
                                $("#"+t.getObjActual().disparador).next().removeClass("hidden");

                            }

                            this._destructor= function () {

                            }
                    
                   
                }
            });


             mvc.constructor({
                disparador: 'home',
                urlPlantilla: serverUrl + 'tpl/home.ndw',
                urlAlimentacion: serverUrl + 'json/home.json',
                destino: 'contenido',
                relevancia: 1,
                controlador: function (t) {
                                this.a = new slider(".banner");

                                this._constructor = function () {
                                    

                                    this.a.init();

                                }

                                this._destructor= function () {

                                    this.a.destroy();

                                }
                }
            });


            mvc.constructor({
                disparador: 'clientes',
                urlPlantilla: serverUrl + 'tpl/clientes.ndw',
                urlAlimentacion: serverUrl + 'json/clientes.json',
                destino: 'contenido',
                relevancia: 1,
                alimentacionCacheable: true,
                controlador: function (t) { 

                    
                        
                        
                        
                            this._constructor = function () {
                                
                                $(".cudriculado .client-retainer .client a").hover(function () {
                                    $(this).children("span").stop(true, true).animate ({
                                                    height:"50px"
                                                },600,'easeOutExpo');
                                }, function () {
                                    $(this).children("span").stop(true, true).animate ({
                                                   height:"0px"

                                                },300,'easeOutExpo');
                                });

                            }

                            this._destructor= function () {                               
                                $(".cudriculado .client-retainer .client a").unbind('hover');
                            }

                }
            });


            mvc.constructor({
                disparador: 'quienes-somos',
                urlPlantilla: serverUrl + 'tpl/quienes-somos.ndw',
                urlAlimentacion: serverUrl + 'json/quienes-somos.json',
                destino: 'contenido',
                relevancia: 1,
                controlador: function (t) { 
                    
                            this._constructor = function () {
                                
                                $(".cudriculado div img.foto1").css({"position":"absolute"});


                                $(".cudriculado div").hover(function () {

                                        $(this).children("img.foto1").stop(true, true).animate ({
                                                        top:-195
                                                    },600,'easeOutExpo');
                                        $(this).children("span").stop(true, true).animate ({
                                                        height:"40px"
                                                    },150,'easeOutExpo');


                                    }, function () {
                                        $(this).children("img.foto1").animate ({
                                                        top:0
                                                    },600,'easeOutBounce');
                                         $(this).children("span").animate ({
                                                       height:"0px"
                                                    },150,'easeOutExpo');

                                    });

                            }

                            this._destructor= function () {
                                $(".cudriculado div").unbind('hover');
                            }
                    
                    

                }
            });

            
            mvc.constructor({
                disparador: 'productos',
                urlPlantilla: serverUrl + 'tpl/productos.ndw',
                urlAlimentacion: serverUrl + 'json/productos.json',
                destino: 'contenido',
                relevancia: 1,
                controlador: function (t) {
                    
                            this._constructor = function () {
                               
                              
                                
                                $(".boton-amarillo").first().addClass("seleccionado");
                                $(".producto").first().show();

                                $(".boton-amarillo").click(function () {
                                    $(".producto").hide();
                                    $(".boton-amarillo").removeClass("seleccionado");
                                    $("."+$(this).attr("ref")).show();
                                    $(this).addClass("seleccionado");
                                    return false;
                                });

                                $(".menu-casos-exito a").first().addClass("seleccionado");
                                $(".sec").first().show();

                                $(".menu-casos-exito a").click(function () {
                                    $(".sec").hide();
                                    $(".menu-casos-exito a").removeClass("seleccionado");
                                    $("."+$(this).attr("ref")).show();
                                    $(this).addClass("seleccionado");
                                    return false;
                                });

                                $('.desplegar-productos').click(function(){

                                      $('.lista-productos').toggleClass('active');
                                        return false;
                                });  
                                
                                var objActual = t.getObjActual();
                               
                                
                                if(objActual.disparadorObj.vars['producto'] != undefined) {
                                    
                                     
                                     $(".boton-amarillo").each(function () {
                                         if($(this).text() == objActual.disparadorObj.vars['producto']) {
                                             $(this).trigger('click', function (){
                                                 $(".producto").hide();
                                                 $(".boton-amarillo").removeClass("seleccionado");
                                                 $("."+$(this).attr("ref")).show();
                                                 $(this).addClass("seleccionado");
                                                 return false;
                                             })
                                         }                                         
                                     });
                                     
                                     
                                }
                               
                                

                            }

                            this._destructor= function () {
                                $('.desplegar-productos').unbind('click');
                                $(".menu-casos-exito a").unbind('click');
                            }

                    

                }

            });

            mvc.constructor({
                disparador: 'servicios',
                urlPlantilla: serverUrl + 'tpl/servicios.ndw',
                urlAlimentacion: serverUrl + 'json/servicios.json',
                destino: 'contenido',
                relevancia: 1,
                controlador: function (t) {
                    
                                this._constructor = function () {
                                    
                                    $(".boton-amarillo").first().addClass("seleccionado");
                                    $(".producto").first().show();

                                    $(".boton-amarillo").click(function () {
                                        $(".producto").hide();
                                        $(".boton-amarillo").removeClass("seleccionado");
                                        $("."+$(this).attr("ref")).show();
                                        $(this).addClass("seleccionado");
                                        return false;
                                    });

                                    $('.desplegar-productos').click(function(){

                                          $('.lista-productos').toggleClass('active');
                                            return false;
                                    });


                                    $(".menu-casos-exito a").hover(function () {

                                            $(this).children("img.logo1").stop(true, true).animate ({
                                                            opacity: 0
                                                        },800,'easeOutExpo');



                                        }, function () {
                                            $(this).children("img.logo1").stop(true, true).animate ({
                                                            opacity: 1
                                                        },800,'easeOutExpo');

                                    });

                                    $(".menu-casos-exito a").first().addClass("seleccionado");
                                    $(".sec").first().show();

                                    $(".menu-casos-exito a").click(function () {
                                        $(".sec").hide();
                                        $(".menu-casos-exito a").removeClass("seleccionado");
                                        $("."+$(this).attr("ref")).show();
                                        $(this).addClass("seleccionado");
                                        return false;
                                    });
                                    
                                        var objActual = t.getObjActual();
                               
                                
                                        if(objActual.disparadorObj.vars['servicio'] != undefined) {

                                             $(".boton-amarillo").each(function () {
                                                 if($(this).text() == objActual.disparadorObj.vars['servicio']) {
                                                     $(this).trigger('click', function (){
                                                         $(".producto").hide();
                                                         $(".boton-amarillo").removeClass("seleccionado");
                                                         $("."+$(this).attr("ref")).show();
                                                         $(this).addClass("seleccionado");
                                                         return false;
                                                     })
                                                 }                                         
                                             });


                                        }

                                }

                                this._destructor= function () {
                                    $(".boton-amarillo").unbind('click');
                                    $(".menu-casos-exito a").unbind('click');
                                    $('.desplegar-productos').unbind('click');
                                }

                    

                }

            });

            mvc.constructor({
                disparador: 'error404',
                urlPlantilla: serverUrl + 'tpl/error404.ndw',
                destino: 'contenido',
                relevancia: 1,
                controlador: function (t) {
                    
                            this._constructor = function () {

                            }

                            this._destructor= function () {

                            }

                }
            });

             mvc.constructor({
                disparador: 'menu',
                urlPlantilla: serverUrl + 'tpl/menu2.ndw',
                destino: 'menu',
                relevancia: 1,
                controlador: function (t) {
                    
                            this._constructor = function () {
                                
                                $(".nav-480").click(function () {
                                    
                                    $(this).removeClass("active");
                                    $(".btn-navbar").removeClass("active");
                                    $(".navbar-inner").removeClass("collapse-menu");

                                })

                            }

                            this._destructor= function () {

                            }

                }
            });

            mvc.constructor({
                disparador: 'labs',
                urlPlantilla: serverUrl + 'tpl/labs.ndw',
                urlAlimentacion: serverUrl + 'json/labs.json',
                destino: 'contenido',
                relevancia: 1,
                controlador: function (t) {
                    
                            this._constructor = function () {

                            }

                            this._destructor= function () {

                            }

                }
            });

            mvc.constructor({
                disparador: 'contacto',
                urlPlantilla: serverUrl + 'tpl/contacto.ndw',
                destino: 'contenido',
                relevancia: 1,
                controlador: function (t) {
                    
                            this._constructor = function () {
                                
                                $(document).ready(function(){
                                    var form = $("#formulario");
                                    var name = $("#nombre");
                                    var nameAlert = $("#nameError");
                                    var email = $("#mail");
                                    var emailAlert = $("#mailError");
                                    var btnsubmit = $("#btn-submit");

                                    //On blur
                                    name.blur(validateName);
                                    email.blur(validateEmail);
                                   
                                    //On Submitting
                                    form.submit(function(event){
                                        event.preventDefault(); 
                                        btnsubmit.val("Aguarde ...");
                                        btnsubmit.attr("disabled","disabled");
                                        if(validateName() & validateEmail()) {
                                            
                                            var info = $(this).serialize();
                                       
                                            $.ajax({
                                                type: "POST",
                                                url: '<?php echo url_for("@contacto_in"); ?>',
                                                data: info,
                                                success: function (data) {
                                                  
                                                  btnsubmit.val("Su mensaje a sido enviado, Gracias!");
                                                  window.location.hash = '#!contacto-gracias'
                                                }
                                             });
                                                
                                            
                                        } else {
                                            btnsubmit.val("›› Enviar mensaje");
                                            btnsubmit.removeAttr("disabled");
                                        
                                        
                                        }
                                        
                                        return false;
                                    });

                                    //validation functions
                                    function validateEmail(){
                                        //testing regular expression
                                        var a = $("#mail").val();
                                        var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
                                        //if it's valid email
                                        if(filter.test(a)){
                                            emailAlert.css("display", "none");
                                            return true;
                                        }
                                        //if it's NOT valid
                                        else{
                                            emailAlert.css("display", "block");
                                            return false;
                                        }
                                    }
                                    function validateName(){
                                        //if it's NOT valid
                                        if(name.val().length < 2){
                                            nameAlert.css("display", "block");
                                            return false;
                                        }
                                        //if it's valid
                                        else{
                                            nameAlert.css("display", "none");
                                            return true;
                                        }
                                    }
                                });

                            }

                            this._destructor= function () {

                            }
                    
                    
                    
                }
            });

            mvc.constructor({
                disparador: 'contacto-gracias',
                urlPlantilla: serverUrl + 'tpl/contacto-gracias.ndw',
                destino: 'contenido',
                relevancia: 1,
                controlador: function (t) {
                    
                            this._constructor = function () {
                                
                                $(document).ready(function(){
                                    var form = $("#newsletter2");
                                    var email = $("#email2");
                                    var emailAlert = $(".emailAlert");

                                    //On Submitting
                                    form.submit(function(){
                                        if(validateEmail()) {
                                            var info = $(this).serialize();
                                            $.ajax({
                                                type: "POST",
                                                url: '<?php echo url_for("@newsletter_in"); ?>',
                                                data: info,
                                                success: function (data) {
                                                  
                                                  $('.thanks2').toggleClass('active');
                                                  $('#newsletter2').hide();
                                                  
                                                }
                                             });
                                            
                                        }
                                        return false;
                                    });

                                    //validation functions
                                    function validateEmail(){
                                        //testing regular expression
                                        var a = $("#email2").val();
                                        var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
                                        //if it's valid email
                                        if(filter.test(a)){
                                            emailAlert.removeClass("fail");
                                            return true;
                                        }
                                        //if it's NOT valid
                                        else{
                                            emailAlert.addClass("fail");
                                            return false;
                                        }
                                    }
                                });

                            }

                            this._destructor= function () {

                            }

                    
                }
            });

            mvc.constructor({
                disparador: 'footer',
                urlPlantilla: serverUrl + 'tpl/footer.ndw',
                destino: 'footer',
                relevancia: 1,
                controlador: function (t) {
                    
                            this._constructor = function () {
                                
                                $('.novedades').click(function(){
                          
                                        $('#newsletter').toggleClass('active');
                                        $('.novedades').toggleClass('arrw');
                                          return false;
                                  });

                                  $(document).ready(function(){
                                      var form = $("#newsletter");
                                      var email = $("#email");
                                      var emailAlert = $(".emailAlert");

                                      //On Submitting
                                      form.submit(function(){
                                          if(validateEmail()) {
                                              
                                              var info = $(this).serialize();
                                              
                                              $.ajax({
                                                type: "POST",
                                                url: '<?php echo url_for("@newsletter_in"); ?>',
                                                data: info,
                                                success: function (data) {
                                                  
                                                  $('.thanks').toggleClass('active');
                                                  $('.novedades').hide();
                                                  $('#newsletter').hide();
                                                  
                                                }
                                             });
                                              
                                          }
                                          return false;
                                      });

                                      //validation functions
                                      function validateEmail(){
                                          //testing regular expression
                                          var a = $("#email").val();
                                          var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
                                          //if it's valid email
                                          if(filter.test(a)){
                                              emailAlert.removeClass("fail");
                                              return true;
                                          }
                                          //if it's NOT valid
                                          else{
                                              emailAlert.addClass("fail");
                                              return false;
                                          }
                                      }
                                  });

                            }

                            this._destructor= function () {

                            }
                    
                    

                }
            });






            mvc.init('home');
        }
</script>
</head>
<body>
    <div class="row-fluid header" id="menu"></div>
    <div id="contenido"></div>
    <a class="back-to-top" href="#" onclick="window.scrollTo(0,0); return false">Volver arriba</a>
    <footer id="footer" class="navbar-fixed-bottom"></footer>
</body>
</html>