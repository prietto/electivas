/*=====2010/09/21========================================================>>>>
DESCRIPCION: 	se encarga de seleccionar o desceleccionar todos los chekcbox

---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
node			chekbox principal
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
function select_all(node, id_tabla){
	f			= document.form1;						//alias del formulario
	t 			= document.getElementById(id_tabla);	//adquiere el objeto tabla
	new_estado	= node.checked;					//Guarda informacion de si el boton esta seleccionado o no
	for(pos_i=1; pos_i<t.rows.length; pos_i++){
		tr			= t.rows[pos_i];	//obtiene la fila
		arr_imputs 	= tr.getElementsByTagName('input');	//obtiene los imputs de la fila
		arr_imputs[0].checked = new_estado; //cambia el estado del chekbox
	}
}

/*=====2010/05/25========================================================>>>>
DESCRIPCION: 	selecciona en un listBox el item que tenga un valor = valor
				pasado por parametro  y deja seleccionado ese elemento de lista especifico.

---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
combo			ruta del combo
valor			valor a seleccionar
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
	===========================================================================*/
function buscar_seleccionado(combo,valor)
{
 for(i= 0; i<combo.length; i++)
 {
   combo.selectedIndex = i; //selecciona el registro de la pos i
   if(combo.value == valor)
   {
    var encontro = true;
    break; //sale del ciclo
   }
 }
 if(!encontro)
	combo.selectedIndex = 0;
}
/*))))))))))))))))))))))))))))))))))))))))))))))--->
OBjETIVO: 	Enviar un registro seleccionado del combo origen al combo destino	
ENTRADAS:	cmb1 <-- ruta del combo origen
			cmb2 <-- ruta del combo destino
SALIDAS:	mueve los datos
))))))))))))))))))))))))))))))))))))))))))))))--->	*/ 
function cmb1_to_cmb2(cmb1,cmb2)
{
	var cod_elim = new Array(); //grupo de registro que contiene los codigos de los registros a eliminar de cmb1
	var y = 0;	//para recorrer el vector cod_elim
	//<<---------   Quita la etiqueta que inicializa el combo2  -------->>\\	
	cmb2.selectedIndex = 0;
	if(cmb2.value == -1) elim_registro_combo(cmb2);						
	if(cmb1.value == -1) return false; // no se permite colocar en el combo del otro lado porque el codigo -1 no existe

	//<<---------   envia registros seleccionados al  cuadro2  -------->>\\	
	for(i=0; i<cmb1.options.length; i++){
		if(cmb1.options[i].selected == true){
			//<<---------   buscar si ya existe el valor en el cuadro2  -------->>\\
			registro_ingresado = false;		//indica que el registro [i] no se a ingresado al combo 2
			for(x=0; x<cmb2.options.length; x++)	{
				cmb2.selectedIndex = x; //selecciona el registro de la pos i
				if(cmb2.value == cmb1.options[i].value)	
				registro_ingresado = true;	//indica que el registro [i] ya esta ingresado en el combo 2
			}
			if(registro_ingresado == false) { //si ese registro especifico no se encuentra en el combo 2
				pos 	= cmb2.options.length;		//ultima posicion en el combo2
				texto 	= cmb1.options[i].text;	
				cmb2.options[pos] =  new Option(texto,cmb1.options[i].value);
				//elimina de comb1 el registro para  verlo al otro lado
				cod_elim[y]=i; y++; //codigos a eliminar
				cmb2.selectedIndex = pos;
			}
		}
	}
	for(i = y-1; i>=0; i--){ //recorrido de los registros a eliminar
		if(navigator.appName == "Netscape") 	cmb1.options[cod_elim[i]] = null;		
		else  									cmb1.remove(cod_elim[i]);
	}
	cmb1.selectedIndex = cmb1.selectedIndex+1
}
/*=====2010/09/21========================================================>>>>
DESCRIPCION: 	Envia los datos de un combo grande a un imput normalmente oculto

---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
cmb_origen		Nombre del combo grande
vrble_dstno		Nombre del combo oculto
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
function combo_a_vrble(cmb_origen, vrble_dstno){
	form			= cmb_origen.form;			
	nmro_elmntos 	= cmb_origen.length;			
	acum_elem		= new Array;					
	for(i=0; i<nmro_elmntos; i++){
		cmb_origen.selectedIndex=i;					
		acum_elem[i] = cmb_origen.value;			
	}
	vrble_dstno.value = acum_elem;		
}
/*=====2010/09/21========================================================>>>>
DESCRIPCION: 	Se encarga de cargar nuevamente los datos de un combo grande despues de refrescar pantalla

---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
cmb_origen		Nombre del combo grande
vrble_dstno		Nombre del combo oculto
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
function carga_clmnas(cadena,cmb1,cmb2){
	form		= document.form1;		
	array_tmp	= new Array(); 	//vector que almacenara temporalmente la informacion de los elementos seleccionados
	array_tmp	= string_to_array(",",cadena);
	//recorre el vector temporal >>>
	for(k=0; k< array_tmp.length; k++){ 	
		//recorre todo el combo1 >>>
		for(j=0; j<cmb1.length; j++){
			cmb1.selectedIndex = j; //selecciona el registro de la pos j
			if(cmb1.value == array_tmp[k]){
				cmb1_to_cmb2(cmb1, cmb2);//envia el valor de combo1 a combo 2
				break;
			}
		}
	}	
}
/*=====2010/09/21========================================================>>>>
DESCRIPCION: 	Se encarga de cargar nuevamente los datos de un combo grande despues de refrescar pantalla

---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
cmb_origen		Nombre del combo grande
vrble_dstno		Nombre del combo oculto
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
function carga_clmnas_sin_eliminar_datos(cadena,cmb1,cmb2){
	form		= document.form1;		
	array_tmp	= new Array(); 	//vector que almacenara temporalmente la informacion de los elementos seleccionados
	array_tmp	= string_to_array(",",cadena);
	//recorre el vector temporal >>>
	for(k=0; k< array_tmp.length; k++){ 	
		//recorre todo el combo1 >>>
		for(j=0; j<cmb1.length; j++){
			cmb1.selectedIndex = j; //selecciona el registro de la pos j
			if(cmb1.value == array_tmp[k]){
				cmb1_to_cmb2_sin_eliminar_datos(cmb1,cmb2);//envia el valor de combo1 a combo 2
				break;
			}
		}
	}	
}
/*=====2010/09/21========================================================>>>>
DESCRIPCION: 	Se encarga de moverlos elementos de un combo hacia abajo

---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
cmb				ruta del combo
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
function baja_elem_combo(cmb)
{
	maximo_nivel = cmb.options.length
	seleccionado = cmb.selectedIndex; //almacena el numero de registro seleccionado 
	if(seleccionado == maximo_nivel-1){
		alert("el registro seleccionado no puede bajar mas");
	}	
	else{
		acum_cod_seleccionado 				= cmb.value;		//almacena el valor del registro seleccionado
		acum_txt_seleccionado 				= cmb.options[seleccionado].text;//almacena el texto del registro seleccionado
		cmb.options[seleccionado].text 		= cmb.options[seleccionado+1].text;
		cmb.options[seleccionado].value 	= cmb.options[seleccionado+1].value;
		cmb.options[seleccionado+1].text 	= acum_txt_seleccionado;
		cmb.options[seleccionado+1].value 	= acum_cod_seleccionado;
		cmb.selectedIndex = seleccionado+1
	}
}
/*=====2010/09/21========================================================>>>>
DESCRIPCION: 	Se encarga de moverlos elementos de un combo hacia arriba

---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
cmb				ruta del combo
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
function sube_elem_combo(cmb)
{
	seleccionado = cmb.selectedIndex; //almacena el numero de registro seleccionado
	if(seleccionado==0){
		alert("el registro seleccionado no puede subir mas");
	}	
	else{
		acum_cod_seleccionado 	= cmb.value;		//almacena el valor del registro seleccionado
		acum_txt_seleccionado 	= cmb.options[seleccionado].text;//almacena el texto del registro seleccionado
		cmb.options[seleccionado].text 		= cmb.options[seleccionado-1].text;
		cmb.options[seleccionado].value 	= cmb.options[seleccionado-1].value;
		cmb.options[seleccionado-1].text 	= acum_txt_seleccionado;
		cmb.options[seleccionado-1].value 	= acum_cod_seleccionado;
		cmb.selectedIndex = seleccionado-1
	}
}
/*))))))))))))))))))))))))))))))))))))))))))))))--->
OBJETIVO: 	Enviar un registro seleccionado del combo origen al combo destino	
ENTRADAS:	cmb1 <-- ruta del combo origen
			cmb2 <-- ruta del combo destino
SALIDAS:	mueve los datos
))))))))))))))))))))))))))))))))))))))))))))))--->	*/ 
function cmb1_to_cmb2_sin_eliminar_datos(cmb1,cmb2)
{
	var cod_elim = new Array(); //grupo de registro que contiene los codigos de los registros a eliminar de cmb1
	var k = 0;	//para recorrer el vector cod_elim
	//<<---------   Quita la etiqueta que inicializa el combo2  -------->>\\	
	cmb2.selectedIndex = 0;
	if(cmb2.value == -1) elim_registro_combo(cmb2);						
	if(cmb1.value == -1) return false; // no se permite colocar en el combo del otro lado porque el codigo -1 no existe

	//<<---------   envia registros seleccionados al  cuadro2  -------->>\\	
	for(i=0; i<cmb1.options.length; i++){
		if(cmb1.options[i].selected == true){
			//<<---------   buscar si ya existe el valor en el cuadro2  -------->>\\
			registro_ingresado = false;		//indica que el registro [i] no se a ingresado al combo 2
			if(registro_ingresado == false) { //si ese registro especifico no se encuentra en el combo 2
				pos 	= cmb2.options.length;		//ultima posicion en el combo2
				texto 	= cmb1.options[i].text;	
				cmb2.options[pos] =  new Option(texto,cmb1.options[i].value);
				//elimina de comb1 el registro para  verlo al otro lado
				cod_elim[k]=i; k++; //codigos a eliminar
				cmb2.selectedIndex = pos;
			}
		}
	}
}
/*))))))))))))))))))))))))))))))))))))))))))))))--->
OBJETIVO: 	Elimina los registros seleccionados
ENTRADAS:	cmb1 <-- ruta del combo origen
			cmb2 <-- ruta del combo destino
SALIDAS:	mueve los datos
))))))))))))))))))))))))))))))))))))))))))))))--->	*/ 
function elim_seleccionados(cmb1)
{
	var k = 0;	//para recorrer el vector cod_elim
	//<<---------   envia registros seleccionados al  cuadro2  -------->>\\	
	for(i=cmb1.options.length-1; i>=0; i--){
		if(cmb1.options[i].selected == true){
			if(navigator.appName == "Netscape") 	cmb1.options[i] = null;		
			else  									cmb1.remove(i);
		}
	}
	cmb1.selectedIndex = 0;
}
/*))))))))))))))))))))))))))))))))))))))))))))))--->
OBJETIVO: 	Elimina todos los registros de un combo
ENTRADAS:	cmb1 <-- ruta del combo origen
SALIDAS:	mueve los datos
))))))))))))))))))))))))))))))))))))))))))))))--->	*/ 
function elim_info_combo(cmb1)
{
	var k = 0;	//para recorrer el vector cod_elim
	//<<---------   envia registros seleccionados al  cuadro2  -------->>\\	
	for(i=cmb1.options.length-1; i>=0; i--){
		if(navigator.appName == "Netscape") 	cmb1.options[i] = null;		
		else  									cmb1.remove(i);
	}
	cmb1.selectedIndex = 0;
}
/*=============================================--->
OBJETIVO: 	Carga datos en un cobo especifico
ENTRADAS:	combo <-- Combo donde se guardarano los datos
			txt_arr_texto <-- textos separados por comas deben tener las mismas posiciones del valor
			txt_arr_texto <-- textos separados por comas deben tener las mismas posiciones del valor
SALIDAS:	deja el combo con los datos cargados
REQUIERE:	Libreria opera cadena
/*=============================================--->	*/ 
function cargar_datos_combo(combo, txt_arr_texto, txt_arr_valor){
	elem_cmb_texto	= string_to_array(";" , txt_arr_texto);
	elem_cmb_valor	= string_to_array(";" , txt_arr_valor);
	elim_info_combo(combo);// Limpia los datos del combo
	num_elementos	= elem_cmb_valor.length;
	combo.options[0]	= new Option ('Seleccione una Opción', '-1');
	for(i=1;i<=num_elementos; i++)
		combo.options[i]	= new Option (elem_cmb_texto[i-1], elem_cmb_valor[i-1]);
}