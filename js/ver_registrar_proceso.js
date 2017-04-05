ind_enter_bloqueado = false; //permite bloquear el enter en procesos de carga de informacion en iframe
var error_fecha_inicio = 0;

var f_quita_cero = function($this){
	if($($this).val() == '0')$($this).val('');
	else if($($this).val() == '')$($this).val('0');
}


$(function(){
	
	// ==========================================================================
	// funcion para validar el numero de la cuota
	
	var num_cuota_total 	= $('input[name="num_cuota_total"]:hidden').val();
	var num_cuota			= $('input[name="num_cuota"]:hidden').val();
	
	if(parseInt(num_cuota) > parseInt(num_cuota_total)){
		$('#enter').attr('disabled',true);
		//$('body').unbind('keyup',funcion_teclas); // vuelve a poner en funionamiento la funcion de teclas del body
		
		$.ventana_proceso({
					data : 'Ha llegado al limite de cuotas configuradas para el suscriptor, no se puede continuar',
					font_size: 18
		});
		
		$('#btn_close_vtn_1').on('click',function(){
			$('body').unbind('keyup');				
		});

				
	}
	
	// HASTA AQUI FUNCION PARA VALIDAR CUOTAS
	// ====================================
	
	
	if($('.val_base').length > 0){
		$('.val_base').each(function(index,element){
			if($(this).val() != ''){
				//$(this).change();
				$(this).keyup();
			}
		})
	}
	
	
	
	// debe escuchar si el campo de suscriptor cambio para consultar y cargar la informacion del cliente
	$('body').delegate('#cod_suscriptor','change',function(){

		//var value = $(this).val();
		navegar(1062);		
	})
	
	// modifica la propiedad de alineamiento vertical del td del contenido
	$('.td_contenido').attr('valign','top');
	
	$('input[name="val_base"]').keyup(function(){
		
	})
	
	$('input[name="val_base"]').each(function(index,element){
		var val_input = $(element).val();
		alert(val_input);
	})
	
	
	
	
})

/*          _\\|//_				
;  º       (` o-o ') 			
;  º------ooO-(_)-Ooo-----------a------------->>>>>
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>-->
Objetivo:   Este metodo devuelve un valor limpio del simbolo enviado por parametro
			100,000,000  retorna   1000000000
ENTRADAS:   cadena y simbolor a remplazar
SALIDAS:    cadena
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>--> */        
function replace_string( text, busca, reemplaza ){


  while (text.toString().indexOf(busca) != -1){
	  	  text = text.toString().replace(busca,reemplaza);
	}

  return text;

}

/*===== 2014/08/12 ========================================================>>>>
DESCRIPCION: 	Metodo para pintar o ejecutar funciones despues de respuesta del servidor
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
date			fecha de la cual se realizara la operacion
num_dias		cantidad de dias que se le sumara a la fecha
id_combo		combo en el cual se pondra la nueva fecha retornada
e				evento
===========================================================================*/
function f_sumar_val_base($this,e){

	e.preventDefault();
	var value_obj = $($this).val();	
	if(value_obj == '')value_obj = 0;
	var obj_tr = $($this).parent().parent();
	var value_porcentaje 	= $(obj_tr).find('.val_porcentaje').text();
	

	var obj_val_resultado 	= $(obj_tr).find('.val_resultado');
	
	value_obj = replace_string(value_obj,',','');	

	var value_fila	= (parseInt(value_obj) * value_porcentaje) / 100;

	
	$(obj_val_resultado).val(value_fila);
	$(obj_val_resultado).change();
	
//	alert($(obj_tr).attr('id'));
	
	
	var value_total = 0;
	$('.val_resultado').each(function(index,element) {  
		
		var data = $(element).val();
		if(data == '')data = 0;
		
		while(data.toString().indexOf(',') != -1){
	  	  	data = data.toString().replace(',','');
		}
		
		value_total = parseInt(value_total) + parseInt(data);
	
	});
	
	// SUMA EL SUBTOTAL
	var obj_subtotal = $('#val_subtotal');
	$(obj_subtotal).val(value_total);	
	$(obj_subtotal).change();

	// CALCULA EL IVA
	var val_iva = (value_total * 16) / 100;
	$('#val_iva').val(val_iva);
	$('#val_iva').change();
	
	
	//CALCULA EL VALOR TOTAL DE LA OPERACION
	var val_total_operacion = parseInt(value_total) + parseInt(val_iva);
	$('#val_total').val(val_total_operacion);	
	$('#val_total').change();
	
		
	return false;	
							
	

}

/*===== 2014/08/12 ========================================================>>>>
DESCRIPCION: 	Metodo para validar si la fecha seleccionda es habil contra la db
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
date			fecha de la cual se realizara la operacion
e				evento
===========================================================================*/
function f_valida_fec_habil($this,date,e){
	e.preventDefault();
	
	error_fecha_inicio = 0;
	var old_date = $($this).data('dato_inicial');

	
		
	// primero debe validar que la fecha seleccionada sea valida
	$.ajax({
		type: 	"post",
		url:	"../consulta/consulta_dia_habil.php",
		data:	{fec_query:date}		
	}).done(function(data){
		
		

		if(data == 0){ // la fecha no es habil

			$($this).val(old_date);				
			$($this).css('border-color','red');
			
			error_fecha_inicio++;
			if(error_fecha_inicio == 1){
				// no es un dia habil
				$.ventana_proceso({
					data : 'La fecha seleccionada no es habil, por favor seleccione una fecha habil'
				});
			}
			return false;
			
		}else if(data == 1){
			$($this).css('border-color','');
			error_fecha_inicio = 0;
			f_get_fecha_fin(date,'fec_fin',event);
			
			
			
		}				
	})
	

}

/*===== 2014/08/12 ========================================================>>>>
DESCRIPCION: 	Metodo para pintar o ejecutar funciones despues de respuesta del servidor
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
date			fecha de la cual se realizara la operacion
num_dias		cantidad de dias que se le sumara a la fecha
id_combo		combo en el cual se pondra la nueva fecha retornada
e				evento
===========================================================================*/
function f_get_fecha_fin(date,id_combo,e){
	e.preventDefault();
	
	// el numero de dias se consultara en el archivo 
	// cosultando el estado
	
	// saca el dato de que estado tiene seleccionado el usuario
	var cod_estado_proceso = $('#cod_estado_proceso').val();
	
	$.ajax({
		type: 	"post",
		url:	"../consulta/consulta_retorna_fec_habil.php",
		data:	{fecha_inicio:date,cod_estado_proceso:cod_estado_proceso}		
	}).done(function (data){
		data = JSON.parse(data);
		
		var fec_fin 			= data[0];
		var fec_notificacion	= data[1];
		
		$('#fec_fin').val(fec_fin);
		$('#fec_notificacion').val(fec_notificacion);
	})
	
	return false;
	
	
}


/*===== 2014/08/12 ========================================================>>>>
DESCRIPCION: 	Metodo para pintar o ejecutar funciones despues de respuesta del servidor
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_pinta_datos_salida(data,cod_navegacion,obj_accionado){
	
}

/*=====2009/01/08========================================================>>>>
DESCRIPCION: 	Metodo para buscar un nombre a partir de un codigo sin listBox
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_consultar_suscriptor(this_obj,e){
	e.preventDefault();
	
	//ver_valor_iframe(this_obj);
	var value_obj 			= 	$(this_obj).val();
	
	var cod_columna_tabla = $(this_obj).data('cod_columna');
	var content_result = $('#content_result_'+cod_columna_tabla);
	
	if(value_obj == ''){ // si el valor del obj es vacio
		
		$(content_result).html('');
		$(content_result).empty();
		$(content_result).hide('fast');
		return false;
	}
	
	var cod_columna_tabla	=	$(this_obj).data('cod_columna');
	var id_obj				= 	$(this_obj).attr('id');
	
//	console.log(cod_columna_tabla+" -- "+value_obj+" --- "+id_obj);
	navegar_ajax_variables(	1061				,
							this_obj			,
							'cod_columna_tabla'	,
							cod_columna_tabla	,
							'val_campo'			,
							value_obj			,
							'id_obj'			,
							id_obj
							
						);
	
}



/*=====2009/01/08========================================================>>>>
DESCRIPCION: 	Metodo que se encarga de levantar una lista de valores a partir 
				de un codigo de navegacion
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO						DESCRIPCION 
cod_ventana_emergente			Codigo de la tabla que debe abrir
txt_nombre_combo				nombre del combo que tiene el codigo principal
boton							boton desde el cual se hace click
ind_registro_maestro_detalle	Indica si la lista esta en un listado de maestro de detalle
===========================================================================*/
ventana_emergente_activa		=0;
combo_codigo_emergente			="";
combo_texto_nombre_emergente	="";
combo_ubicacion_tr				=""; //id de la fila a la que debe retornar lainformacion
cod_ventana_emergente_anterior	=0;
id_tabla_detalle				="";
function ver_lista_valor(cod_ventana_emergente,txt_nombre_combo, boton, ind_registro_maestro_detalle){
	f	=	document.form1;
	//=== Si la lista de valor es llamada desde un detalle debe guardar el codigo de la fila>>>
	if(ind_registro_maestro_detalle==1) {
		tr 						= boton.parentNode.parentNode; 	//captura la fila en la que esta el combo
		combo_ubicacion_tr		= tr.id;
	}

	//=== Combos donde se retornara la información >>>
	combo_codigo_emergente			= document.getElementById(txt_nombre_combo);
	combo_texto_nombre_emergente	= document.getElementById("txt_"+txt_nombre_combo);
	
	//=== hace que se refresque la ventana emergente >>>
	if(cod_ventana_emergente_anterior != cod_ventana_emergente){
		ventana_emergente_activa 		= 0; 	
		cod_ventana_emergente_anterior 	= cod_ventana_emergente;	
	}
	//=== hace que se refresque la ventana emergente >>>
	if(ventana_emergente_activa == 0){
		ventana_emergente 	= window.open ('',	'SubWind','statusbar,scrollbars,resizable,height=600,width=780, top=100,Left=200');			
		f.target						= 'SubWind';
		add_input('cod_ventana_emergente','hidden',cod_ventana_emergente);
//		f.cod_ventana_emergente.value 	= cod_ventana_emergente;
		navegar(43);
		f.target						= '_self';
		ventana_emergente.focus();
		ventana_emergente_activa		=1;
	}else{
		ventana_emergente.focus();
	}

}

/*=====2009/01/08========================================================>>>>
DESCRIPCION: 	Metodo para buscar un nombre a partir de un codigo sin listBox
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function ver_valor_iframe(combo,ind_registro_maestro_detalle){
	
	f							=	document.form1;
	//f.cod_tabla_iframe.value	= f.cod_tabla.value;//la tabla que tiene el script contra la base de datos
	//f.val_campo.value			= combo.value;
	
	if(combo.value == ''){
		combo_texto_nombre_emergente.value = '';
		return false;
	}
	
	//=== Si la lista de valor es llamada desde un detalle debe guardar el codigo de la fila>>>
	/*if(ind_registro_maestro_detalle==1) {
		tr 						= combo.parentNode.parentNode; 	//captura la fila en la que esta el combo
		combo_ubicacion_tr		= tr.id;
		f.cod_tabla_iframe.value= f.cod_tabla_detalle.value;
	}	
	
	//=== Combos donde se retornara la información >>>
	combo_codigo_emergente			= document.getElementById(combo.name);
	combo_texto_nombre_emergente	= document.getElementById("txt_"+combo.name);
	
	f.txt_nombre_columna_iframe.value	= combo.name;
	f.target							= 'frame_oculto';//Para ejecutar la consulta en el iframe
	navegar(42);
	f.target							= '_self';//Para la siguiente consulta hacerlo normal
	*/
}


/*=====2010/06/01========================================================>>>>
DESCRIPCION: 	Metodo que sera llamado desde una lista de valores para vajar
				el registro seleccionado
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
valor			cadena separada por comas que contiene todo un registro resultado
				de una consulta
===========================================================================*/
function cargar_reg_emergente(){

	parametros							= cargar_reg_emergente.arguments;
	//alert(combo_ubicacion_tr);
	f									= document.form1;				//alias del formulario	
	window.focus();
	if(combo_ubicacion_tr != ""){
		tr				= document.getElementById(combo_ubicacion_tr);
		arr_imputs 		= tr.getElementsByTagName('input');	 //obtiene todos los imput contenidos en la fila
		num_imputs		= arr_imputs.length;
		for(j=0; j<num_imputs; j++){
			if(arr_imputs[j].name == combo_codigo_emergente.name &&	parametros[0]){
				arr_imputs[j].value = parametros[0];
				
			}else if(arr_imputs[j].name == combo_texto_nombre_emergente.name && parametros[1]){
				arr_imputs[j].value = parametros[1];
			}
		} 
		addRow(arr_imputs[j-1],'tabla_detalle_'+f.cod_tabla_detalle.value);//evalua si debe añadir un nuevo registro
		combo_ubicacion_tr ="";
	}else{
		combo_codigo_emergente.value		= parametros[0];
		combo_texto_nombre_emergente.value	= parametros[1];
		$(combo_codigo_emergente).change();
			
	}
	ventana_emergente.close();
}
/*=====2005/05/26================================================>>>>
DESCRIPCION: 	se encarga de indicar que la ventana emergente sigue abierta
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function cerrar_venana_emergente(){
	ventana_emergente_activa = 0;
}
/*=====2005/05/26================================================>>>>
DESCRIPCION: 	se encarga de indicar que la ventana emergente sigue abierta
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function activar_ventana_emergente(){
	ventana_emergente_activa = 1;
}
function f_ordenar_por(ord_por){
	f.ord_por.value = ord_por;
	f_enter();
}
f = document.form1;

function f_enter(){

	if(ind_enter_bloqueado==false){
		//eliminar_ultima_fila();
		f					= document.form1;
		f.enter.disabled = true;
		f.ind_guardar_datos_tabla_autonoma.value = 1;
		navegar(1063);
	}

}
function f_esc(){
	f				= document.form1;
	f.esc.disabled 	= true;
	navegar_limpiando_variables(78);
}
/*=====2010/06/02==================================================>>>>
DESCRIPCION: 	cambia a la pagina seleccionada
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function seleccionar_pagina(num_pagina){
	f= document.form1;
	f.target				= '_self';
	f.num_pagina.value		= num_pagina;
	f_enter();
}

function  evalua_tecla_body(cuerpo ,evento){
	//======== evaluacion de las teclas ===========>>>>>
	var enter			= 13;
	var tecla_presionada= (window.Event) ? evento.which : evento.keyCode; //captura la tecla que fue precionada
	if(tecla_presionada == enter) navegar(13);
}




