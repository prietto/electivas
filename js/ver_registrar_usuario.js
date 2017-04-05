ind_enter_bloqueado = false; //permite bloquear el enter en procesos de carga de informacion en iframe



/*=====2009/01/08========================================================>>>>
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

/*=====2009/01/08========================================================>>>>
DESCRIPCION: 	Metodo para eliminar una foto del sistema
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_eliminar_foto(){
	confirmacion = confirm("Esta foto se eliminara del sistema ¿Desea Continuar?");
	if(confirmacion==true)		navegar(76);
}
/*=====2009/01/08========================================================>>>>
DESCRIPCION: 	Metodo para ocultar la foto
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_ocultar_foto(ruta){
	fila					=	document.getElementById('ver_foto');
	fila.style.display 		= 	'none';
}

/*=====2009/01/08========================================================>>>>
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

/*=====2010/06/02========================================================>>>>
DESCRIPCION: 	Si la ultima fila esta limpia la borra para no tener que hacer
				validaciones en php
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
node			boton seleccionado
id_tabla		id de la tabla 
===========================================================================*/
function eliminar_ultima_fila(){
	f				= document.form1;
	var t 			= document.getElementById('tabla_detalle_'+f.cod_tabla_detalle.value);
	var ultimo_tr	= t.rows[t.rows.length-1];
	var tb 			= t.getElementsByTagName('tbody')[0];

	//== Evalua si el codigo del producto es invalido>>>
	arr_imputs 					= ultimo_tr.getElementsByTagName('input');	
	if(		arr_imputs[1].value == ''	&&
		  	arr_imputs[2].value == ''	&&
		  	(arr_imputs[4].value == '' || arr_imputs[4].value == 0)){
		tb.removeChild(ultimo_tr);		
	}	
}
/*=====2010/06/01========================================================>>>>
DESCRIPCION: 	Metodo que se encarga de eliminar las filas seleccionadas por el chekbox
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
node			boton seleccionado
id_tabla		id de la tabla 
===========================================================================*/
function eliminar_fila(node,id_tabla) {
	confirmacion = confirm("Se eliminara el registro seleccionados\n\n ¿Desea Continuar?");
	if(confirmacion==false) return false;
	var t 			= document.getElementById(id_tabla);
	var tr 			= node.parentNode.parentNode;
	var arr_imputs 	= tr.getElementsByTagName('input');			
	var tb 			= t.getElementsByTagName('tbody')[0];

	// Evita que se quede sin filas la tabla....
	if (t.rows.length==1){
		arr_imputs[0].value = '';	
		arr_imputs[1].value = '';	
	}else{
		tb.removeChild(tr);	
	}
	//== Renumera los IDS de cada fila>>>	
	for(val_pos_i=0; val_pos_i<t.rows.length; val_pos_i++){
		tr		= t.rows[val_pos_i];
		tr.id	= id_tabla+"_row_"+val_pos_i;
	}
	tr			= t.rows[t.rows.length-1];	
	arr_imputs 	= tr.getElementsByTagName('input');			
	arr_imputs[1].focus();
	calcular_precio_orden();
}

/*=====2010/06/01========================================================>>>>
DESCRIPCION: 	Clona una fila 
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
node			boton seleccionado
id_tabla		id de la tabla 
===========================================================================*/
function addRow(node,id_tabla) {
	var t 			= document.getElementById(id_tabla);
	var tb 			= t.getElementsByTagName('tbody')[0];
	var tr 			= node.parentNode.parentNode;
	var ultimo_tr	= t.rows[t.rows.length-1];
	//== Evalua si es la ultima fila>>>
	if(tr!=ultimo_tr)return false;
	
	//== Evalua si el codigo del producto es invalido>>>
	var elementos_fila 			= ultimo_tr.getElementsByTagName('input');	
	
	if(elementos_fila[1].value=='') return false;
	var myClone = ultimo_tr.cloneNode(true);	

	tb.appendChild(myClone);
	nuevo_id_fila		= t.rows.length-1
	nuevo_id_fila		= id_tabla+"_row_"+nuevo_id_fila;
	myClone.setAttribute('id',nuevo_id_fila); //pone id a la fila
	var newInpt 	= myClone.getElementsByTagName('input');	
	var newSel 		= myClone.getElementsByTagName('select');
	var newTa 		= myClone.getElementsByTagName('textarea');

	//=== Evalua Imputs>>>
	for (i=0; i < newInpt.length; i++){
		if (newInpt[i].type == 'text' || newInpt[i].type == 'hidden') newInpt[i].value = '';
		if (newInpt[i].type == 'checkbox' || newInpt[i].type == 'radio') {
			if (tr.getElementsByTagName('input')[i].checked == true)
			newInpt[i].setAttribute('checked',true);
		}
	}
	//=== Evalua Text Areas>>>
	for (i=0; i < newTa.length; i++){
		newTa[i].setAttribute('value','');
	}
	//=== Evalua Selects >>> 
	for (i=0; i < newSel.length; i++){
		var newName = newSel[i].name.substring(0,newSel[i].name.search(/\d/)) + nameNum;
		newSel[i].setAttribute('name',newName);
		newSel[i].setAttribute('value','');  
		newSel[i].selectedIndex = 0;
	}
	newInpt[1].focus();
	//nameNum++;
}

/*=====2009/01/08========================================================>>>>
DESCRIPCION: 	Metodo para buscar un nombre a partir de un codigo sin listBox
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function ver_valor_iframe(combo,ind_registro_maestro_detalle){
	f							=	document.form1;
	f.cod_tabla_iframe.value	= f.cod_tabla.value;//la tabla que tiene el script contra la base de datos
	f.val_campo.value			= combo.value;
	//=== Si la lista de valor es llamada desde un detalle debe guardar el codigo de la fila>>>
	if(ind_registro_maestro_detalle==1) {
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
		f.cod_ventana_emergente.value 	= cod_ventana_emergente;
		navegar(43);
		f.target						= '_self';
		ventana_emergente.focus();
		ventana_emergente_activa		=1;
	}else{
		ventana_emergente.focus();
	}

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
			if		(arr_imputs[j].name == combo_codigo_emergente.name		 &&	parametros[0])		arr_imputs[j].value = parametros[0];
			else if	(arr_imputs[j].name == combo_texto_nombre_emergente.name && parametros[1])		arr_imputs[j].value = parametros[1];
		} 
		addRow(arr_imputs[j-1],'tabla_detalle_'+f.cod_tabla_detalle.value);//evalua si debe añadir un nuevo registro
		combo_ubicacion_tr ="";
	}else{
		combo_codigo_emergente.value		= parametros[0];
		combo_texto_nombre_emergente.value	= parametros[1];	
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
		eliminar_ultima_fila();
		f					= document.form1;
		f.enter.disabled = true;
		f.ind_guardar_datos_tabla_autonoma.value = 1;
		navegar(81);
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
	f_enter()
}
/*=====2010/06/02==================================================>>>>
DESCRIPCION: 	permite modificar un registro especifico
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function ver_registro(cod_pk){
	f= document.form1;
	f.target				= '_self';
	f.cod_pk.value			= cod_pk;
	navegar_limpiando_variables(37);
}


function  evalua_tecla_body(cuerpo ,evento){
	//======== evaluacion de las teclas ===========>>>>>
	var enter			= 13;
	var tecla_presionada= (window.Event) ? evento.which : evento.keyCode; //captura la tecla que fue precionada
	if(tecla_presionada== enter) navegar(13)
}

/*=====2010/06/02==================================================>>>>
DESCRIPCION: 	Salta a la pagina para la creacion de un nuevo registro
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_nuevo_registo(){
	navegar_limpiando_variables(37);
}

/*=====2010/06/02==================================================>>>>
DESCRIPCION: 	Elimina un registro especifico
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_eliminar_registro(){
	confirmacion = confirm ("El registro sera eliminado completamente del sistema \n\n ¿Desea Continuar?");
	if(confirmacion==true)	navegar(46)
}




/*=====2010/06/02====================================================>>>>
DESCRIPCION: 	Mascara para formato hora
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function mi_mascara(obj, masque) {
	var ch = obj.value
	var tmp = ""
	var j = 0
	ch.toString()
	if ((window.event.type == "keydown" || window.event.type == "keyup" ) && window.event.keyCode != 8) {
		for (i=0; i<ch.length; i++) {
			if (!isNaN(ch.charAt(i)) && ch.charAt(i) != " ") { tmp += ch.charAt(i) }
		}
		ch = ""
		for (i=0; i<masque.length; i++) {
			if (masque.charAt(i) == "0") { 
				if (tmp.charAt(j) != "" ) {
					ch += tmp.charAt(j)
					j++
				}
				else { ch += " " }
			}
			else { ch += masque.charAt(i) }
		}
	}
	obj.value = ch
}
/*=====2010/06/02====================================================>>>>
DESCRIPCION: 	Mascara para formato hora
AUTOR:			
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function mi_mascara2(obj, masque) {
	var ch = obj.value
	var tmp = ""
	var j = 0
	ch.toString()
	if (window.event.keyCode != 37 && window.event.keyCode != 39 && window.event.type != "keydown" && window.event.keyCode != 8 && window.event.keyCode != 46) {
		if (window.event.type == "keyup") {
			for (i=0; i<ch.length; i++) {
				if (!isNaN(ch.charAt(i)) && ch.charAt(i) != " ") { tmp += ch.charAt(i) }
			}
			ch = ""
			for (i=0; i<masque.length; i++) {
				if (masque.charAt(i) == "0") { 
					if (tmp.charAt(j) != "" ) {
						ch += tmp.charAt(j)
						j++
					}
					else { ch += " " }
				}
				else { ch += masque.charAt(i) }
			}
		}
		obj.value = ch
	}
}


