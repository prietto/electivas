var cod_peticion=0;

/*=====2015/04/23==========================================================>>>>
DESCRIPCION: 	FUNCION GENERICA DE LA ARQUITECTURA DEL SISTEMA
				FUNCION QUE ENVIA LAS VARIABLES QUE TIENE LA PANTALLA 
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO				DESCRIPCION 
var cod_navegacion		CURSO QUE TOMARA EL SISTEMA PARA NAVEGAR SEGUN EL FLUJO INGRESADO
===========================================================================*/
var navegar_ajax_login_return = function(cod_navegacion,callback){

	var cod_navegacion_old = $('#cod_navegacion').val();
	$('#cod_navegacion').val(cod_navegacion);

	var data = new FormData($("#form1")[0]);	


	// AÑADE EL CODIGO DE NAVEGACION AL OBJETO
	// POR DEFECTO ES LA RUTA PARA MOSTRAR EL FORMULARIO DE CHECKING
	data.append('cod_navegacion', 1097);

	// AÑADE EL CODIGO DE NAVEGACION AL QUE SE DIRIGE DESPUES DE LA CONFIRMACION DE LOGIN
	data.append('cod_navegacion_destino',cod_navegacion);


	// devuelve el valor del codigo de navegacion que tenia anteriormente
	$('#cod_navegacion').val(cod_navegacion_old);
	

	var ajax = $.ajax({
			type	: "post",
            url		: "../../php/principal/controlador_ajax.php",
            data	: data, 
			//necesario para subir archivos via ajax
			mimeType:"multipart/form-data",
            cache: 			false,
            contentType: 	false,
            processData: 	false			
		}).done(function(data){

				modal_deck.open({
					data:data,
					width:'auto',
					height:'auto'
				},function(){
					$('#enter_confirm').on('click',function(e){		

							e.preventDefault();
				      var error = 0;

				      var cod_usuario_pk = $('input[name="cod_usuario_confirm"]').val();
				      var form_confirm_login = $('#form_confirm_login');
				      var inputs_required = $(form_confirm_login).find(':input[required]',':textarea[required]');

				      // valida los campos ingresados
				      $(inputs_required).each(function(index,element){
				        var val_element = $.trim($(element).val()); 

				        //== si el valor es nulo>>
				        if(!val_element){
				          $(element).css({
				            'border-color':'red'
				          });
				          
				          error++;
				        }else{
				          $(element).css({
				            'border-color':''
				          });
				        }
				      
				      })// fin each

				      if(error == 0){
				        // fluoj de navegacion para validar usuarios
				        navegar_ajax_return(1091,function(a){ 
				          //console.log(a);

				          // respuesta CALLBACK ==>          
				          var obj_json = $.parseJSON(a); // se convierte en objeto el dato llegado desde php

				          var result = obj_json.result;
				          var cod_navegacion_destino = obj_json.cod_navegacion_destino;

				          // la variable a es el numero de registro encontrados 
				          if(result>=1){ // si existe el usuario (clave valida)
				          	//alert('clave valida');

				          	navegar_ajax_return(cod_navegacion_destino,function(datax){
				          		if(callback && typeof(callback) == "function"){
									callback(datax);	
								}
				          	});
				          	


				            /*navegar_ajax_return(cod_navegacion_destino,function(data){
				                          

				              modal_deck.close(function(){
				                modal_deck.open({ // funcion que abre ventana
				                  data:data,
				                  width:'auto',
				                  height:'auto'
				                },function(){
				                  // al terminar de abrir la ventana modal
				                });

				              });

				              
				            });*/

				          }else if(result == 0){ // clave invalida
				            var msj = "Acceso Denegado";
				            modal_deck.open({
				              data:msj
				            });
				          }

				        });  
				        
				      } // if error
							

						}) // fin funcion onclick
				});
			
				// llama a la funcion o ejecuta codigo despues de navegar al servidor
				// valida que exista un callback tambien
				/*if(callback && typeof(callback) == "function"){
					callback(data);	
				}*/

		});

	

	return false;

}

/*=====2015/04/23==========================================================>>>>
DESCRIPCION: 	Metodo para validar contraseña del usuario conectado antes de proseguir 
				con el flujo de navegacion, esto para evitar que una persona externa genere procesos 
				sin permiso
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO				DESCRIPCION 
var cod_navegacion		CURSO QUE TOMARA EL SISTEMA PARA NAVEGAR SEGUN EL FLUJO INGRESADO
===========================================================================*/
function navegar_ajax_login(cod_navegacion,obj_accionado){

	var cod_navegacion_old = $('#cod_navegacion').val();
	$('#cod_navegacion').val(cod_navegacion);

	// CAPTURA TODOS LOS CAMPOS DEL FORMULARIO EN UN OBJETO
	var data = new FormData($("#form1")[0]);	
	

	// AÑADE EL CODIGO DE NAVEGACION AL OBJETO
	// POR DEFECTO ES LA RUTA PARA MOSTRAR EL FORMULARIO DE CHECKING
	data.append('cod_navegacion', 1090);

	// AÑADE EL CODIGO DE NAVEGACION AL QUE SE DIRIGE DESPUES DE LA CONFIRMACION DE LOGIN
	data.append('cod_navegacion_destino',cod_navegacion);


	// devuelve el valor del codigo de navegacion que tenia anteriormente
	$('#cod_navegacion').val(cod_navegacion_old);


	// muestra ventana para confirmacion de contraseña
	$.ajax({
		method:"post",
		url		: "../../php/principal/controlador_ajax.php",
		data:data,
		mimeType:"multipart/form-data",
        cache: 			false,
        contentType: 	false,
        processData: 	false
	}).done(function(result){
		modal_deck.open({
			data:result
		});
	});
	

	return false;
}


/*=====2015/04/23==========================================================>>>>
DESCRIPCION: 	FUNCION GENERICA DE LA ARQUITECTURA DEL SISTEMA
				FUNCION QUE ENVIA LAS VARIABLES QUE TIENE LA PANTALLA 
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO				DESCRIPCION 
var cod_navegacion		CURSO QUE TOMARA EL SISTEMA PARA NAVEGAR SEGUN EL FLUJO INGRESADO
===========================================================================*/
var navegar_ajax_return = function(cod_navegacion,callback){

	var cod_navegacion_old = $('#cod_navegacion').val();
	$('#cod_navegacion').val(cod_navegacion);

	//var formulario = $('#form1');	
	//var vars = formulario.serializeFullArray(); // captura todas las variables de la pantalla en vector
	//var vars = new FormData($('#form1')[0]);
	var data = new FormData($("#form1")[0]);	
	/*var ajax_data = { // arma array de javascript para enviarlo 
		  	"vars" 				: vars,
		  	"cod_navegacion"	: cod_navegacion,
			"ind_var_ajax"		: 1
	
	};*/
	data.append('cod_navegacion', cod_navegacion);
	
	// devuelve el valor del codigo de navegacion que tenia anteriormente
	$('#cod_navegacion').val(cod_navegacion_old);
	

	var ajax = $.ajax({
			type	: "post",
            url		: "../../php/principal/controlador_ajax.php",
            data	: data, 
			//necesario para subir archivos via ajax
			mimeType:"multipart/form-data",
            cache: 			false,
            contentType: 	false,
            processData: 	false,
			beforeSend: function() {
				// === PINTA EN PANTALLA CARGADOR GIF  == //
				f_crea_loading_pantalla('open');
				
				// $("."+id_pinta).html('<div class="gif_loading"><label><img src="../../imagenes/sistema/loading.gif" alt="" /></label></div>');
				//$('div.gif_loading').find('img').css('vertical-align','middle');
            	//$('.search-background').fadeIn(200);
            },
			success: function(data) { // devuelve la data del servidor

				f_crea_loading_pantalla('close');
				
				
				// llama a la funcion o ejecuta codigo despues de navegar al servidor
				// valida que exista un callback tambien
				if(callback && typeof(callback) == "function"){
					callback(data);	
				}
				
				
			 },
			error: function(objeto, que_paso, otro_obj){
				
				f_crea_loading_pantalla('close');

			  	//f_pinta_error(data,cod_accion,cod_peticion);
				//alert("Lo sentimos ha ocurrido un error en la consulta \n intenta nuevamente");
			}
			/*complete : function(jqXHR, status) {
		    	//alert('Petición realizada');
 			}*/
		});

	return false;

}

/*=====2015/04/23==========================================================>>>>
DESCRIPCION: 	FUNCION GENERICA DE LA ARQUITECTURA DEL SISTEMA
				FUNCION QUE ENVIA LAS VARIABLES QUE TIENE LA PANTALLA 
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO				DESCRIPCION 
var cod_navegacion		CURSO QUE TOMARA EL SISTEMA PARA NAVEGAR SEGUN EL FLUJO INGRESADO
===========================================================================*/
var navegar_ajax_div_return = function(cod_navegacion,id_div,callback){

	var cod_navegacion_old = $('#cod_navegacion').val();
	$('#cod_navegacion').val(cod_navegacion);

	var vars = $("#"+id_div).find("select, textarea, input").serializeFullArray();	

	
	// crea el objeto para insertar los tipo file en el objeto
	var formData = new FormData();
	formData.append('section', 'general');
	formData.append('action', 'previewImg');
	

	// debe recorrer las imagenes que tenga el div contenedor
	var input_archivos = $('#'+id_div).find('input[type=file]');

	// recorre los archivos que conteiene el div
	$(input_archivos).each(function(index,element){
		var name_input = $(element).attr('name');

		formData.append(name_input, $('#'+id_div).find('input[type=file]')[index].files[0]); 		
	})


		

	

	//formData.append('image', $('#'+id_div).find('input[type=file]')[0].files[0]); 

	// == codigo de navegacion hacia donde dirige == //
	formData.append('cod_navegacion', cod_navegacion);

	// == codigo de usuario conectado == //
	formData.append('cod_usuario',$('input[name="cod_usuario"]').val())

	// recorre el objeto vars  
	for(var a in vars){
		formData.append(a, vars[a]);		
	}

	// devuelve el valor del codigo de navegacion que tenia anteriormente
	$('#cod_navegacion').val(cod_navegacion_old);

	var ajax = $.ajax({
			type	: "post",
            url		: "../../php/principal/controlador_ajax.php",
            data	: formData, 
			//necesario para subir archivos via ajax
			//mimeType:"multipart/form-data",
            //cache: 			false,
            contentType: 	false,
            processData: 	false,
			beforeSend: function() {
				// === PINTA EN PANTALLA CARGADOR GIF  == //
				f_crea_loading_pantalla('open');

				//f_pinta_loading(cod_navegacion,obj_accionado);
				
				// $("."+id_pinta).html('<div class="gif_loading"><label><img src="../../imagenes/sistema/loading.gif" alt="" /></label></div>');
				//$('div.gif_loading').find('img').css('vertical-align','middle');
            	//$('.search-background').fadeIn(200);
            },
			success: function(data) { // devuelve la data del servidor

				// === PINTA EN PANTALLA CARGADOR GIF  == //
				f_crea_loading_pantalla('close');				
				
				// llama a la funcion o ejecuta codigo despues de navegar al servidor
				// valida que exista un callback tambien
				if(callback && typeof(callback) == "function"){
					callback(data);	
				}
				
				
			 },
			error: function(objeto, que_paso, otro_obj){

			  	//f_pinta_error(data,cod_accion,cod_peticion);
				//alert("Lo sentimos ha ocurrido un error en la consulta \n intenta nuevamente");
			}
			/*complete : function(jqXHR, status) {
		    	//alert('Petición realizada');
 			}*/
		});

	return false;

}

/*=====2015/04/23==========================================================>>>>
DESCRIPCION: 	FUNCION GENERICA DE LA ARQUITECTURA DEL SISTEMA
				FUNCION QUE ENVIA LAS VARIABLES QUE TIENE LA PANTALLA 
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO				DESCRIPCION 
var cod_navegacion		CURSO QUE TOMARA EL SISTEMA PARA NAVEGAR SEGUN EL FLUJO INGRESADO
===========================================================================*/
function navegar_ajax_simple(cod_navegacion,obj_accionado){

	var cod_navegacion_old = $('#cod_navegacion').val();
	$('#cod_navegacion').val(cod_navegacion);

	//var formulario = $('#form1');	
	//var vars = formulario.serializeFullArray(); // captura todas las variables de la pantalla en vector
	//var vars = new FormData($('#form1')[0]);
	var data = new FormData($("#form1")[0]);	
	/*var ajax_data = { // arma array de javascript para enviarlo 
		  	"vars" 				: vars,
		  	"cod_navegacion"	: cod_navegacion,
			"ind_var_ajax"		: 1
	
	};*/
	data.append('cod_navegacion', cod_navegacion);
	
	// devuelve el valor del codigo de navegacion que tenia anteriormente
	$('#cod_navegacion').val(cod_navegacion_old);
	

	var ajax = $.ajax({
			type	: "post",
            url		: "../../php/principal/controlador_ajax.php",
            data	: data, 
			//necesario para subir archivos via ajax
			mimeType:"multipart/form-data",
            cache: 			false,
            contentType: 	false,
            processData: 	false,
			beforeSend: function() {
				f_pinta_loading(cod_navegacion,obj_accionado);
				
				// $("."+id_pinta).html('<div class="gif_loading"><label><img src="../../imagenes/sistema/loading.gif" alt="" /></label></div>');
				//$('div.gif_loading').find('img').css('vertical-align','middle');
            	//$('.search-background').fadeIn(200);
            },
			success: function(data) { // devuelve la data del servidor
				if (data != null || data != ''){
					
					 f_pinta_datos(data,cod_navegacion,obj_accionado);
					 return false;
				}
				
			 },
			error: function(objeto, que_paso, otro_obj){

			  	//f_pinta_error(data,cod_accion,cod_peticion);
				//alert("Lo sentimos ha ocurrido un error en la consulta \n intenta nuevamente");
			}
			/*complete : function(jqXHR, status) {
		    	//alert('Petición realizada');
 			}*/
		});

}


/*=====2014/07/26==========================================================>>>>
DESCRIPCION: 	FUNCION GENERICA DE LA ARQUITECTURA DEL SISTEMA
				FUNCION QUE ENVIA LAS VARIABLES QUE TIENE LA PANTALLA 
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO				DESCRIPCION 
var cod_navegacion		CURSO QUE TOMARA EL SISTEMA PARA NAVEGAR SEGUN EL FLUJO INGRESADO
var cod_accion			ACCION QUE LLEVARA A CABO SEGUN LO QUE EL SERVIDOR DEVUELVA 
var cod_peticion		
var obj_accionado		ELEMENTO DEL DOM DESDE DONDE FUE ACCIONADO EL EVENTO
===========================================================================*/
function navegar_ajax_autonomo(cod_navegacion,obj_accionado){
	
	var cod_navegacion_old = $('#cod_navegacion').val();
	$('#cod_navegacion').val(cod_navegacion);

	//var formulario = $('#form1');	

	//var vars = formulario.serializeFullArray(); // captura todas las variables de la pantalla en vector

	//var vars = new FormData($('#form1')[0]);
	var datas = new FormData($("#form1")[0]);
	
	
	datas.append('cod_navegacion', cod_navegacion);
	datas.append('ind_navegacion_ajax', 1);
	
	// devuelve el valor del codigo de navegacion que tenia anteriormente
	$('#cod_navegacion').val(cod_navegacion_old);
	
	var ajax = $.ajax({
			type	: "post",
            url		: "controlador.php",
            data	: datas, 
			//necesario para subir archivos via ajax
			mimeType:"multipart/form-data",
            cache: 			false,
            contentType: 	false,
            processData: 	false,
			beforeSend: function() {
				f_pinta_loading(cod_navegacion,obj_accionado);
				
				// $("."+id_pinta).html('<div class="gif_loading"><label><img src="../../imagenes/sistema/loading.gif" alt="" /></label></div>');
				//$('div.gif_loading').find('img').css('vertical-align','middle');
            	//$('.search-background').fadeIn(200);
            },
			success: function(data) { // devuelve la data del servidor
				
				if (data != null || data != ''){
					 f_pinta_datos(data,cod_navegacion,obj_accionado);
					 return false;
				}
				
			 },
			error: function(objeto, que_paso, otro_obj){

			  	//f_pinta_error(data,cod_accion,cod_peticion);
				//alert("Lo sentimos ha ocurrido un error en la consulta \n intenta nuevamente");
			}
			/*complete : function(jqXHR, status) {
		    	//alert('Petición realizada');
 			}*/
		});

}

/*=====2014/07/26==========================================================>>>>
DESCRIPCION: 	FUNCION GENERICA DE LA ARQUITECTURA DEL SISTEMA
				QUE ENVIA VALORES POST DE LOS INPUTS SELECT O TEXT AREAS QUE ESTAN DENTRO DEL DIV 
				PASADO POR PARAMETRO
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO				DESCRIPCION 
var cod_navegacion		CURSO QUE TOMARA EL SISTEMA PARA NAVEGAR SEGUN EL FLUJO INGRESADO
var obj_accionado		ELEMENTO DEL DOM DESDE DONDE FUE ACCIONADO EL EVENTO
var div_contenedor		ELEMENTO QUE ENCIERRA LOS INPUTS QUE SE DESEAN ENVIAR

ESPECIALMENTE PARA LAS VENTANA MODALES BUSCADORAS QUE SOLO SE QUIEREN ENVIAR LOS INPUTS DE LOS FILTROS Y NO
TODO LO QUE ESTA EN PANTALLA
===========================================================================*/
function navegar_ajax_div(cod_navegacion,obj_accionado,id_div){

//	var vars = $("#"+id_div).find("select, textarea, input").serializeArray();	
	var vars = $("#"+id_div).find("select, textarea, input").serializeFullArray();	

	//var vars = new FormData($('#form1')[0]);
	var ajax_data = { // arma array de javascript para enviarlo 
		  	"vars" 				: vars,
		  	"cod_navegacion"	: cod_navegacion,
			"ind_var_ajax"		: 1
	
	};
	
	var ajax = $.ajax({
            type	: "post",
            url		: "controlador.php",
            data	: ajax_data,
			async	: true,			
			beforeSend: function() {
				//f_pinta_loading(cod_navegacion,obj_accionado);
				// $("."+id_pinta).html('<div class="gif_loading"><label><img src="../../imagenes/sistema/loading.gif" alt="" /></label></div>');
				//$('div.gif_loading').find('img').css('vertical-align','middle');
            	//$('.search-background').fadeIn(200);
            },
			success: function(data) { // devuelve la data del servidor

				if (data != null || data != ''){
					 f_pinta_datos(data,cod_navegacion,obj_accionado);
				}
				
			 },
			error: function(objeto, que_paso, otro_obj){
			  	//f_pinta_error(data,cod_accion,cod_peticion);
				alert("Lo sentimos ha ocurrido un error en la consulta \n intenta nuevamente");
			}
			/*complete : function(jqXHR, status) {
		    	//alert('Petición realizada');
 			}*/
		});

}


/*=====2014/07/26==========================================================>>>>
DESCRIPCION: 		FUNCION GENERICA DE LA ARQUITECTURA DEL SISTEMA, 
					CAPTURA ARCHIVOS O CAMPOS "FILES" PARA ENVIARLO AL SERVIDOR
AUTOR:				Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO				DESCRIPCION 
var cod_navegacion		CURSO QUE TOMARA EL SISTEMA PARA NAVEGAR SEGUN EL FLUJO INGRESADO
var cod_accion			ACCION QUE LLEVARA A CABO SEGUN LO QUE EL SERVIDOR DEVUELVA 
var cod_peticion		
var obj_accionado		ELEMENTO DEL DOM DESDE DONDE FUE ACCIONADO EL EVENTO
===========================================================================*/
function navegar_ajax_files(cod_navegacion,obj_accionado){

	var cod_navegacion_old = $('#cod_navegacion').val();
	$('#cod_navegacion').val(cod_navegacion);
	var formulario = $('#form1');	
//	var vars = formulario.serializeArray();
	//var vars = formulario.serializeFullArray();

	//información del formulario
    var formData = new FormData($("#form1")[0]);
	
	
	
	

	// devuelve el valor del codigo de navegacion que tenia anteriormente
	$('#cod_navegacion').val(cod_navegacion_old);

	var ajax = $.ajax({
            type	: "post",
            url		: "controlador.php",
            data	: formData, 
			//necesario para subir archivos via ajax
			mimeType:"multipart/form-data",
            cache: 			false,
            contentType: 	false,
            processData: 	false,
			beforeSend: function() {
				//f_pinta_gif_cargador(cod_navegacion,cod_peticion);
				// $("."+id_pinta).html('<div class="gif_loading"><label><img src="../../imagenes/sistema/loading.gif" alt="" /></label></div>');
				//$('div.gif_loading').find('img').css('vertical-align','middle');
            	//$('.search-background').fadeIn(200);
            },
			success: function(data) { // devuelve la data del servidor
				
				if (data != null || data != ''){
					 f_pinta_datos(data,cod_navegacion,obj_accionado);
				}
				
			 },
			error: function(objeto, que_paso, otro_obj){
			  	//f_pinta_error(data,cod_accion,cod_peticion);
				alert("Lo sentimos ha ocurrido un error en la consulta \n intenta nuevamente");
			}
			/*complete : function(jqXHR, status) {
		    	//alert('Petición realizada');
 			}*/
		});
	
}

/*=====2014/07/26==========================================================>>>>
DESCRIPCION: 	FUNCION GENERICA DE LA ARQUITECTURA DEL SISTEMA
				FUNCION QUE ENVIA LAS VARIABLES QUE TIENE LA PANTALLA 
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO				DESCRIPCION 
var cod_navegacion		CURSO QUE TOMARA EL SISTEMA PARA NAVEGAR SEGUN EL FLUJO INGRESADO
var cod_accion			ACCION QUE LLEVARA A CABO SEGUN LO QUE EL SERVIDOR DEVUELVA 
var cod_peticion		
var obj_accionado		ELEMENTO DEL DOM DESDE DONDE FUE ACCIONADO EL EVENTO
===========================================================================*/
function navegar_ajax(cod_navegacion,obj_accionado){


	var formulario = $('#form1');	

	var vars = formulario.serializeFullArray(); // captura todas las variables de la pantalla en vector

	//var vars = new FormData($('#form1')[0]);
	var ajax_data = { // arma array de javascript para enviarlo 
		  	"vars" 				: vars,
		  	"cod_navegacion"	: cod_navegacion,
			"ind_var_ajax"		: 1
	
	};

	var ajax = $.ajax({
            type	: "post",
            url		: "controlador.php",
            data	: ajax_data,
			async	: true,			
			beforeSend: function() {
				f_pinta_loading(cod_navegacion,obj_accionado);
				// $("."+id_pinta).html('<div class="gif_loading"><label><img src="../../imagenes/sistema/loading.gif" alt="" /></label></div>');
				//$('div.gif_loading').find('img').css('vertical-align','middle');
            	//$('.search-background').fadeIn(200);
            },
			success: function(data) { // devuelve la data del servidor

				if (data != null || data != ''){
					 f_pinta_datos(data,cod_navegacion,obj_accionado);
				}
				
			 },
			error: function(objeto, que_paso, otro_obj){

			  	//f_pinta_error(data,cod_accion,cod_peticion);
				alert("Lo sentimos ha ocurrido un error en la consulta \n intenta nuevamente");
			}
			/*complete : function(jqXHR, status) {
		    	//alert('Petición realizada');
 			}*/
		});

}

/*=====2014/07/26==========================================================>>>>
DESCRIPCION: 	FUNCION GENERICA DE LA ARQUITECTURA DEL SISTEMA
				Envia al servidor solo las varibales que el programador ingrese como parametro				
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO									DESCRIPCION 
var cod_navegacion 	=	PARAMETRO[0] -->	CURSO QUE TOMARA EL SISTEMA PARA NAVEGAR SEGUN EL FLUJO INGRESADO
var cod_accion		=	PARAMETRO[1] -->	ACCION QUE LLEVARA A CABO SEGUN LO QUE EL SERVIDOR DEVUELVA 
var obj_accionado	= 	PARAMETRO[2] -->	ELEMENTO DEL DOM DESDE DONDE FUE ACCIONADO EL EVENTO

PARAMETROS ---->>		DESPUES DE ESTOS PARAMETROS SE PUEDEN AÑADIR CUALQUIER VARIABLES CON SU VALOR
						EJ.  navegar_ajax_variables(2000,1,obj_accionado,var1,valor_var1,var2,valor_var2,var3,valor_var3);
						
						y podemos seguir añadiendo las deseadas
===========================================================================*/
function navegar_ajax_variables(){
	// las variables llegaran separadas por ":" ej.  "cod_navegacion:10","cod_tabla:10"
	// ==== PARAMETROS POR DEFECTO DE LA FUNCION
	parametros				= navegar_ajax_variables.arguments;
	var cod_navegacion			= parametros[0];	
	var obj_accionado			= parametros[1];
	// === FIN PARAMETROS DEFAULT == //


	// INICIALIZA VARIABLES PARA AJAX
	var ajax_data = {};	 

	var separador			= ',';
	var num_parametros		= parametros.length;
	for(var i=2;i<num_parametros;i++){

		var nom_variable 	= parametros[i];
		var val_variable 	= parametros[i+1];		
		i++; // avanza una posicion
		//alert(nom_variable+" --- "+val_variable);
		ajax_data[nom_variable] = val_variable;
	}

	ajax_data['cod_navegacion'] = cod_navegacion;
	var ajax = $.ajax({
            type	: "post",
            url		: "controlador.php",
            data	: ajax_data,
			async	: true,			
			beforeSend: function() {
				//f_pinta_gif_cargador(cod_navegacion,obj_accionado);
				//$("."+id_pinta).html('<div class="gif_loading"><label><img src="../../imagenes/sistema/loading.gif" alt="" /></label></div>');
				//$('div.gif_loading').find('img').css('vertical-align','middle');
            	//$('.search-background').fadeIn(200);
            },
			success: function(data) { // devuelve la data del servidor

				if (data != null || data != ''){

					 f_pinta_datos(data,cod_navegacion,obj_accionado);
				}				
				//$('.gif_loading').fadeOut(300);
			 },
			error: function(objeto, quepaso, otroobj){
			  	//f_pinta_error(data,cod_accion,cod_peticion);
				//alert('Disculpe, existió un problema');
	            alert("Lo sentimos ha ocurrido un error en la consulta \n intenta nuevamente");

        	}
			/*complete : function(jqXHR, status) {
		    	//alert('Petición realizada');
 			}*/
		});

}




/*=====2014/07/26==========================================================>>>>
DESCRIPCION: 	FUNCION GENERICA DE LA ARQUITECTURA DEL SISTEMA
				Envia todas las variables de la pantalla ademas las varibles que el programador 
				pase por parametro
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO									DESCRIPCION 
var cod_navegacion 	=	PARAMETRO[0] -->	CURSO QUE TOMARA EL SISTEMA PARA NAVEGAR SEGUN EL FLUJO INGRESADO
var cod_accion		=	PARAMETRO[1] -->	ACCION QUE LLEVARA A CABO SEGUN LO QUE EL SERVIDOR DEVUELVA 
var obj_accionado	= 	PARAMETRO[2] -->	ELEMENTO DEL DOM DESDE DONDE FUE ACCIONADO EL EVENTO

PARAMETROS ---->>		DESPUES DE ESTOS PARAMETROS SE PUEDEN AÑADIR CUALQUIER VARIABLES CON SU VALOR
						EJ.  navegar_ajax_variables(2000,1,obj_accionado,var1,valor_var1,var2,valor_var2,var3,valor_var3);
						
						y podemos seguir añadiendo las deseadas
===========================================================================*/
function navegar_ajax_all_variables(){

	// las variables llegaran separadas por ":" ej.  "cod_navegacion:10","cod_tabla:10"
	// ==== PARAMETROS POR DEFECTO DE LA FUNCION
	parametros				= navegar_ajax_all_variables.arguments;
	var cod_navegacion			= parametros[0];	
	var obj_accionado			= parametros[1];
	// === FIN PARAMETROS DEFAULT == //

	var formulario = $('#form1');	

	//var vars = formulario.serializeArray();
	//var vars = $('#form1').serializeArray();
	var vars = formulario.serializeFullArray(); // captura todas las variables de la pantalla en vector

	
	// INICIALIZA VARIABLES PARA AJAX
	var ajax_data = {};	

	var separador			= ',';
	var num_parametros		= parametros.length;
	for(var i=2;i<num_parametros;i++){

		var nom_variable 	= parametros[i];
		var val_variable 	= parametros[i+1];		
		i++; // avanza una posicion
		
		ajax_data[nom_variable] = val_variable;
	}
	
	// remplaza el codigo de navegacion
	ajax_data['cod_navegacion'] = cod_navegacion;
	ajax_data['ind_var_ajax'] 	= 1;	
	ajax_data['vars'] 			= vars;

	var ajax = $.ajax({
            type	: "post",
            url		: "controlador.php",
            data	: ajax_data,
			async	: true,			
			beforeSend: function() {
				f_pinta_loading(cod_navegacion,obj_accionado);
				//$("."+id_pinta).html('<div class="gif_loading"><label><img src="../../imagenes/sistema/loading.gif" alt="" /></label></div>');
				//$('div.gif_loading').find('img').css('vertical-align','middle');
            	//$('.search-background').fadeIn(200);
            },
			success: function(data) { // devuelve la data del servidor

				if (data != null || data != ''){
					 f_pinta_datos(data,cod_navegacion,obj_accionado);
				}				
				//$('.gif_loading').fadeOut(300);
			 },
			error: function(objeto, quepaso, otroobj){
			  	//f_pinta_error(data,cod_accion,cod_peticion);
				//alert('Disculpe, existió un problema');
	            alert("Lo sentimos ha ocurrido un error en la consulta \n intenta nuevamente");

        	}
			/*complete : function(jqXHR, status) {
		    	//alert('Petición realizada');
 			}*/
		});

	
	
	
}

