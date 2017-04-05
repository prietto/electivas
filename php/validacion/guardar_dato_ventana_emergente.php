<?
include("../librerias/tabla_autonoma.php");

include("../librerias/columna_tabla_autonoma.php");
include("../librerias/tabla_autonoma_personalizado.php");
include("../librerias/sis_genericos.php");
include("../librerias/obj_listbox.php");
include("../librerias/proceso_adicional_pantalla.php");
include("../librerias/c_file.php");
include("../librerias/reporte_tabla.php");

$num_max_registros			=	$_REQUEST['num_max_registros'];
$cod_pk						=	$_REQUEST['cod_pk'];
$ind_buscar					=	$_REQUEST['ind_buscar'];
$num_pagina					=	$_REQUEST['num_pagina'];
$ord_por					=	$_REQUEST['ord_por'];
$txt_nombre_columna_iframe	=	$_REQUEST['txt_nombre_columna_iframe'];
$cod_ventana_emergente		=	$_REQUEST['cod_ventana_emergente'];
$cod_usuario				=	$_REQUEST['cod_usuario'];
$cod_navegacion				=	$_REQUEST['cod_navegacion'];
$ind_limpiar_variables		=	$_REQUEST['ind_limpiar_variables'];
$cod_tabla					=	$_REQUEST['cod_tabla'];
$cod_tabla_detalle			=	$_REQUEST['cod_tabla_detalle'];

$seg_permiso_tabla_autonoma	=	new seg_permiso_tabla_autonoma;
$columna_tabla_autonoma		=	new columna_tabla_autonoma;
if($ind_new_row)	
	$ind_tiene_permiso = $seg_permiso_tabla_autonoma->f_get_permiso_insert_tabla($cod_tabla,$cod_perfil);
else
	$ind_tiene_permiso = $seg_permiso_tabla_autonoma->f_get_permiso_update_tabla($cod_tabla,$cod_perfil);
if(!$row_usuario){
	array_push($arr_mensajes,'3'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 	//registra el codigo del mensaje que se debe mostrar
	$proceso				= NULL;		//no procesa nada
	$consulta				= "ver_registrar_dato_tabla_autonoma.php";	//Regresa a  la pagina anterior
	$salida					= "ver_registrar_dato_ventana_emergente.php";	 //Regresa a  la pagina anterior
}else if(!$ind_tiene_permiso){
	array_push($arr_mensajes,'3'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 	//registra el codigo del mensaje que se debe mostrar
	$proceso				= NULL;		//no procesa nada
	$consulta				= "ver_registrar_dato_tabla_autonoma.php";	//Regresa a  la pagina anterior
	$salida					= "ver_registrar_dato_ventana_emergente.php";	 //Regresa a  la pagina anterior
}else{
	//=== Valida todas las columnas >>>
	$cursor_info_columnas	= $columna_tabla_autonoma->f_get_info_columnas($cod_tabla);
	$num_registros 			= $db->num_registros($cursor_info_columnas);
	for($i=0; $i<$num_registros; $i++){
		$row_info_columna		= $db->sacar_registro($cursor_info_columnas,$i);
		$txt_nombre_columna		= $row_info_columna['txt_nombre'];
		$txt_alias				= str_replace("_"," ", $row_info_columna['txt_alias']);
		$ind_not_null			= $row_info_columna['ind_not_null'];
		$ind_unique				= $row_info_columna['ind_unique'];
		$cod_tipo_dato_columna	= $row_info_columna['cod_tipo_dato_columna'];
		$value_columna			= trim($_POST[$txt_nombre_columna]); //eliminando espacios en blanco al inicio y al final 
		
		
		if($row_info_columna['txt_script_cursor'])	$ind_list_box = true; 
		else 										$ind_list_box = false; // para saber que los datos vienen de un listbox
		if($value_columna===0) 	$value_columna == " 0";

		//=== Obtiene el registro que viola la restriccion UNIQUE >>>
		if($ind_unique){
			$row_restringe_unique	= 	$columna_tabla_autonoma->f_get_row_restriccion_unique(
										$cod_pk				,
										$row_info_columna	,
										$value_columna				
										);
		}
		
		//=== Valida campos NULL >>>
		if($ind_not_null && ($value_columna == NULL  || $value_columna == '0') ){
			array_push($arr_mensajes,'1'); 									//Registra el codigo del mensaje que se debe mostrar
			array_push($arr_parametro,$txt_alias); 							//Nombre del campo not null
			$proceso			= NULL;										//No procesa 
			$consulta			= "ver_registrar_dato_tabla_autonoma.php";	//Regresa a  la pagina anterior
			$salida				= "ver_registrar_dato_ventana_emergente.php";	//Regresa a  la pagina anterior
		}
		//=== Valida campos LISTBOX que no pueden ser NULL >>>
		else if($ind_not_null && $value_columna == -1 && $ind_list_box== true){
			array_push($arr_mensajes,'1'); 									//Registra el codigo del mensaje que se debe mostrar
			array_push($arr_parametro,$txt_alias); 							//Nombre del campo not null
			$proceso			= NULL;										//No procesa 
			$consulta			= "ver_registrar_dato_tabla_autonoma.php";	//Regresa a  la pagina anterior
			$salida				= "ver_registrar_dato_ventana_emergente.php";	//Regresa a  la pagina anterior
		}

		//=== Valida campos de TIPO NUMERICO CON Y SIN FORMATO >>>
		else if($cod_tipo_dato_columna == 2 || $cod_tipo_dato_columna == 5 || $cod_tipo_dato_columna == 10){
			$_POST[$txt_nombre_columna]	= str_replace(",","",$_POST[$txt_nombre_columna]);
			$value_columna				= str_replace(",","",$value_columna);
			$value_columna				= ltrim(rtrim($value_columna));
			if(!is_numeric($value_columna) && $value_columna!=NULL){
				array_push($arr_mensajes,'6'); 						//MENSAJE ERROR CAMPO NUMERICO
				array_push($arr_parametro,$txt_alias); 				//Nombre del campo not null
				$proceso			= NULL;							//no procesa nada
				$consulta			= "ver_registrar_dato_tabla_autonoma.php";	//Regresa a  la pagina anterior
				$salida				= "ver_registrar_dato_ventana_emergente.php";	//Regresa a  la pagina anterior
			}
		}
		//=== Valida restriccion UNIQUE >>>
		else if( $ind_unique && $row_restringe_unique[0] ){
			array_push($arr_mensajes,'7'); 									//Registra el codigo del mensaje que se debe mostrar
			array_push($arr_parametro,$txt_alias); 							//Nombre del campo not null
			$proceso			= NULL;										//No procesa 
			$consulta			= "ver_registrar_dato_tabla_autonoma.php";	//Regresa a  la pagina anterior
			$salida				= "ver_registrar_dato_ventana_emergente.php";	//Regresa a  la pagina anterior
		}	
		//=== VARCHAR SIN NUMEROS
		if(	$cod_tipo_dato_columna == 15){
			$tmp_vr	= $vr;
			$vr	= str_split($value_columna);//convierte la cadena en vector
			if(	in_array("0",$vr)  	|| 	in_array("1",$vr) || in_array("2",$vr) ||in_array("3",$vr) 	|| 
				in_array("4",$vr) 	|| 	in_array("5",$vr) || in_array("6",$vr)  || in_array("7",$vr) || 
				in_array("8",$vr) 	||	in_array("9",$vr) 
			){
				array_push($arr_mensajes,'11'); 									//Registra el codigo del mensaje que se debe mostrar
				array_push($arr_parametro,$txt_alias); 							//Nombre del campo not null
				$proceso			= NULL;										//No procesa 
				$consulta			= "ver_registrar_dato_tabla_autonoma.php";	//Regresa a  la pagina anterior
				$salida				= "ver_registrar_dato_ventana_emergente.php";	//Regresa a  la pagina anterior

			}
			$vr	=	$tmp_vr;			
		}		
	}
}
?>