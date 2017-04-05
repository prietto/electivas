/*=====2010/03/18====================================Arellano Company===>>>>
DESCRIPCION: 	Metodo para cambiar color de la celda
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
fila			todo el objeto de la fila
num_accion		1=over 2=out 3=click
===========================================================================*/
function f_color_fila(fila,num_accion){
	if(num_accion==3) {
		if(fila.className == "fila_click"){ //si esta seleccionada la quita su seleccion
			fila.className = "contenido"; //realizo otro click osea que quita la seleccion
			elemento_fila = fila.getElementsByTagName('input');	
			//elemento_fila[0].setAttribute('checked',false);		
			elemento_fila[0].checked = false;
		}else{// si no esta seleccionada la selecciona
			fila.className 	= "fila_click";		
			elemento_fila 	= fila.getElementsByTagName('input');				
			//elemento_fila[0].setAttribute('checked',true);		
			elemento_fila[0].checked = true;			
		}
	}
	if(fila.className != "fila_click"){ //si la fila no esta seleccionada
		if(num_accion==1) fila.className = "fila_over";
		if(num_accion==2) fila.className = "fila_out";	
	}
}


/*=====2014/05/07 ==========================================================>>>>
DESCRIPCION: 	Muestra pantalla para relacionar los procesos con los perfiles
AUTOR:			Luis prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_ver_reportes_perfil(){
	f	=	document.form1;	
	navegar(1052);

}

/*=====2014/05/07 ==========================================================>>>>
DESCRIPCION: 	Muestra pantalla para relacionar los procesos con los perfiles
AUTOR:			Luis prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_ver_procesos_adicionales(){
	f	=	document.form1;	
	navegar(1050);

}


/*=====2014/01/16 ==========================================================>>>>
DESCRIPCION: 	Selecciona todos los checkbox
AUTOR:			Luis prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function marcar(combo){
   checkboxes=document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
   for(i=0;i<checkboxes.length;i++){ //recoremos todos los controles
      if(checkboxes[i].type == "checkbox"){ //solo si es un checkbox entramos
       checkboxes[i].checked=combo.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
      }
   }
}

/*=====2013/12/31==========================================================>>>>
DESCRIPCION: 	Muestra pantalla para asociar valores con tipos de atencion
AUTOR:			Luis prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function refresh_page(){
	f.target		= '_self';
	setTimeout("navegar_limpiando_varibales(39)", 2000);
	navegar_refresh(39);

}

/*=====2013/12/30==========================================================>>>>
DESCRIPCION: 	Muestra mensaje de alerta cuando el rango de facturacion ha llegado al tope
AUTOR:			Luis prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_muestra_advertencia(cadena){
	f	=	document.form1;	
	f.ind_limite.value = 1;
	alert(cadena);
	setTimeout("navegar_limpiando_varibales(39)", 2000);
	navegar_refresh(39);
}	

/*=====2013/12/30==========================================================>>>>
DESCRIPCION: 	Muestra pantalla para asociar valores con tipos de atencion
AUTOR:			Luis prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_resolucion_dian(){
	f	=	document.form1;
	f.cod_tabla.value	=	14;
	navegar(39);
}	

/*=====2013/12/27==========================================================>>>>
DESCRIPCION: 	Muestra pantalla para asociar valores con tipos de atencion
AUTOR:			Luis prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_imprime_factura(){
	f				= document.form1;
	f.target = "_blank";
	navegar(1028);
}	

/*=====2013/12/27==========================================================>>>>
DESCRIPCION: 	Muestra pantalla para asociar valores con tipos de atencion
AUTOR:			Luis prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_imprime_factura(){
	f				= document.form1;
	f.target = "_blank";
	navegar(1025);
}	


/*=====2013/12/31==========================================================>>>>
DESCRIPCION: 	Navega
AUTOR:			Luis prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function navegar_refresh(cod_navegacion){
		document.form1.target="_self"
//		document.form1.ind_limpiar_variables.value = 1;
		document.form1.ind_buscar.value = 1; // para que el sistema sepa que debe borrar la posible basura
		navegar(cod_navegacion)
}	


/*=====2013/12/27==========================================================>>>>
DESCRIPCION: 	Muestra pantalla para asociar valores con tipos de atencion
AUTOR:			Luis prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_genera_factura(){
	f				= document.form1;
	f.target 		= 'frame_oculto';
	navegar(1026);	
	f.target		= '_self';
	//setTimeout("navegar_limpiando_varibales(39)", 2000);
	//navegar_refresh(39);

}	

/*=====2013/12/19==========================================================>>>>
DESCRIPCION: 	Muestra pantalla para asociar valores con tipos de atencion
AUTOR:			Luis prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_asignar_valores(){
	f			= document.form1;
	f.cod_tabla_detalle.value = 11;
	f.cod_tabla.value = 1;
	navegar_limpiando_variables(1022);	

}	




/*=====2010/03/18==========================================================>>>>
DESCRIPCION: 	oculta un video especifico
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_close_video(cod_track){
	document.getElementById("video"+cod_track).style.display 				= 'none';	
	document.getElementById("b_ocultar_video_"+cod_track).style.display 	= 'none';	
	document.getElementById("b_ver_video_"+cod_track).style.display 		= 'block';
}

/*=====2010/03/18==========================================================>>>>
DESCRIPCION: 	Muestra un video especifico
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_ver_video(cod_track){
	document.getElementById("video"+cod_track).style.display 				= 'block';	
	document.getElementById("b_ocultar_video_"+cod_track).style.display 	= 'block';	
	document.getElementById("b_ver_video_"+cod_track).style.display 		= 'none';
}
/*=====2010/03/18==========================================================>>>>
DESCRIPCION: 	Metodo para hacer sonar un archivo mp3
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
ind_stop_mp3		= 	0;
id_boton_anterior	=	null;
function f_escuchar_mp3(txt_ruta_mp3, boton_id){
	f							= document.form1;
	boton_sonido				= document.getElementById(boton_id);
	if(boton_id != id_boton_anterior && id_boton_anterior!=null){
		document.getElementById(id_boton_anterior).src = '../../imagenes/sistema/stop_sound.png';
		ind_stop_mp3									= 0;
	}
	if(ind_stop_mp3==1){
		txt_ruta_mp3 			= "";
		ind_stop_mp3			= 0;
		boton_sonido.src		= '../../imagenes/sistema/stop_sound.png';
	}else{
		boton_sonido.src		= '../../imagenes/sistema/sound.png';
		ind_stop_mp3	= 1;
	}

	f.txt_ruta_mp3.value	= txt_ruta_mp3;
	f.target				= 'frame_oculto';
	navegar(77);
	f.target				= '_self';
	id_boton_anterior 		= boton_id;
	//boton_sonido.style.display 	= 'none';
	
//	boton_stop			= document.getElementById("ocultar_boton_mp3");
//	boton_stop.style.display 	= 'block';	
}
/*=====2010/03/18==========================================================>>>>
DESCRIPCION: 	Metodo para mostrar una foto especifica
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function ver_foto(ruta,nom_columna_con_foto){
	f						=	document.form1;
	imagen					= 	document.getElementById("img_registro");
	imagen.src				=	ruta;
	fila					=	document.getElementById('ver_foto');
	fila.style.display 		= 	'block';
	document.form1.eliminar_foto.focus();
	f.nom_columna_con_foto.value=	nom_columna_con_foto;
}
/*=====2010/03/18==========================================================>>>>
DESCRIPCION: 	Metodo para eliminar una foto del sistema
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_eliminar_foto(){
	confirmacion = confirm("Esta foto se eliminara del sistema ¿Desea Continuar?");
	if(confirmacion==true)		navegar(76);
}
/*=====2010/03/18==========================================================>>>>
DESCRIPCION: 	Metodo para ocultar la foto
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_ocultar_foto(ruta){
	fila					=	document.getElementById('ver_foto');
	fila.style.display 		= 	'none';
}

/*=====2010/03/18==========================================================>>>>
DESCRIPCION: 	Metodo para buscar un nombre a partir de un codigo sin listBox
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function ver_valor_iframe(combo){
	f									= document.form1;
	//=== Combos donde se retornara la información >>>
	combo_codigo_emergente			= document.getElementById(combo.name);
	combo_texto_nombre_emergente	= document.getElementById("txt_"+combo.name);
	
	f.txt_nombre_columna_iframe.value	= combo.name;
	f.target							= 'frame_oculto';
	navegar(42);
	f.target							= '_self';
}
/*=====2010/03/18==========================================================>>>>
DESCRIPCION: 	Metodo que se encarga de levantar una lista de valores a partir 
				de un codigo de navegacion
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
ventana_emergente_activa		=0;
combo_codigo_emergente			="";
combo_texto_nombre_emergente	="";
cod_ventana_emergente_anterior	=0;
function ver_lista_valor(cod_ventana_emergente,txt_nombre_combo){
	f	=	document.form1;
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
		f.cod_ventana_emergente.value 	= cod_ventana_emergente;
		add_input('ind_limpiar_ord','hidden',1);
		navegar(43);
		f.target						= '_self';
		ventana_emergente.focus();
		ventana_emergente_activa		=1;
	}else{
		ventana_emergente.focus();
	}

}

/*=====2008/06/01==========================================================>>>>
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
	f									= document.form1;				//alias del formulario	
	combo_codigo_emergente.value		= parametros[0];
	combo_texto_nombre_emergente.value	= parametros[1];	
	window.focus();
	ventana_emergente.close();
}
/*=====2005/05/26========================================================>>>>
DESCRIPCION: 	se encarga de indicar que la ventana emergente sigue abierta
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function cerrar_venana_emergente(){
	ventana_emergente_activa = 0;
}
/*=====2005/05/26========================================================>>>>
DESCRIPCION: 	se encarga de indicar que la ventana emergente sigue abierta
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function activar_ventana_emergente(){
	ventana_emergente_activa = 1;
}
function f_ordenar_por(ord_por){
	f=document.form1;
	f.ord_por.value = ord_por;
	f_enter();
}
f = document.form1;

function f_enter(){

	f					= document.form1;
	f.ind_buscar.value 	=	1;
	if(f.ind_imprimir_reporte.checked == true){
		f.target = "_blank";
		navegar(41);
		f.target = "_self";
	}else{
		f.enter.disabled = true;
		navegar(39);
	}
}
function f_esc(){
	f							= document.form1;
	f.esc.disabled 				= true;
	/*f.cod_tabla.value 			= 1;
	f.cod_tabla_detalle.value	= 3;*/
	f_ver_consultar_maetro_detalle(1,3);
	
//	navegar_limpiando_variables(78);
}
/*=====2008/06/02==================================================>>>>
DESCRIPCION: 	cambia a la pagina seleccionada
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function seleccionar_pagina(num_pagina){
	f= document.form1;
	f.target				= '_self';
	f.num_pagina.value		= num_pagina;
	f_enter()
}
/*=====2008/06/02==================================================>>>>
DESCRIPCION: 	permite modificar un registro especifico
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
/*function f_ver_menu_registro(cod_pk){
	f= document.form1;
	f.target				= '_self';
	f.cod_pk.value			= cod_pk;
	navegar_limpiando_variables(1046);
}*/


/*=====2010/03/18====================================Arellano Company===>>>>
DESCRIPCION: 	Metodo para cambiar color de la celda
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
fila			todo el objeto de la fila
num_accion		1=over 2=out 3=click
===========================================================================*/
var cod_registro_anterior = "";
function f_ver_menu_registro(cod_registro){
	f = document.form1;
	if(f.num_procesos_adicionales.value==0){
		cod_registro_anterior	= cod_registro;	
		ver_registro(cod_registro_anterior);
	}else{
	
		//==== Obtiene los botones autorizados >>>
		obj_contenedor			= 	document.getElementById("div_procesos_registro");
		html_contenido_actual	= 	obj_contenedor.innerHTML; //guarda los botones en memoria
		obj_contenedor			= 	document.getElementById("div_reg_"+cod_registro); //obtiene el div del registro seleccionado
		obj_contenedor.innerHTML= 	html_contenido_actual;//coloca la informacion almacenada temporalmente
	
	
		//=== Muestra el menu>>>
		tr_menu_nuevo 			= cod_registro;
		tr_menu					= document.getElementById("tr_menu_reg_"+cod_registro);
		tr_menu.style.display	= "table-row";
	
		
		//== Oculta el menu anterior>>>
		if(cod_registro_anterior!="" ){
			tr_menu					= document.getElementById("tr_menu_reg_"+cod_registro_anterior);
			tr_menu.style.display	= "none";
		}
		if(cod_registro_anterior == cod_registro)	cod_registro_anterior	= "";
		else										cod_registro_anterior	= cod_registro;	
	
	
		//=== Espera un momento para quitar la seleccion del registro	
		setTimeout(function(){
			tr_link					= document.getElementById("tr_reg_"+cod_registro);	
			tr_link.className = "contenido"; //realizo otro click osea que quita la seleccion
			elemento_fila = tr_link.getElementsByTagName('input');	
			elemento_fila[0].checked = false;
			},10);
	}
}


/*=====2008/06/02==================================================>>>>
DESCRIPCION: 	permite modificar un registro especifico
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function ver_registro(cod_pk){
	f= document.form1;
	f.target				= '_self';
	f.cod_pk.value			= cod_pk;
	navegar_limpiando_variables(1046);
}

/*
function  evalua_tecla_body(cuerpo ,evento){
	alert();
	//======== evaluacion de las teclas ===========>>>>>
	var enter			= 13;
	var tecla_presionada= (window.Event) ? evento.which : evento.keyCode; //captura la tecla que fue precionada
	if(tecla_presionada== enter) navegar(13)
}
*/
/*=====2008/06/02==================================================>>>>
DESCRIPCION: 	Salta a la pagina para la creacion de un nuevo registro
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_nuevo_registo(){
	navegar_limpiando_variables(1046);
}