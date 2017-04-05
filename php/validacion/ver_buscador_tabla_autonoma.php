<?
include("../librerias/tabla_autonoma.php");

include("../librerias/columna_tabla_autonoma.php");
include("../librerias/sis_genericos.php");
include("../librerias/obj_listbox.php");
include("../librerias/reporte_tabla.php");

$cod_pk								=$_REQUEST['cod_pk'];
$ind_new_row						=$_REQUEST['ind_new_row'];
$ind_guardar_datos_tabla_autonoma	=$_REQUEST['ind_guardar_datos_tabla_autonoma'];
$txt_nombre_columna_iframe			=$_REQUEST['txt_nombre_columna_iframe'];
$cod_ventana_emergente				=$_REQUEST['cod_ventana_emergente'];
$cod_usuario						=$_REQUEST['cod_usuario'];
$cod_navegacion						=$_REQUEST['cod_navegacion'];
$ind_limpiar_variables				=$_REQUEST['ind_limpiar_variables'];
$cod_tabla							=$_REQUEST['cod_tabla'];
$cod_tabla_detalle					=$_REQUEST['cod_tabla_detalle'];
$ind_buscar							=$_REQUEST['ind_buscar'];
$num_pagina							=$_REQUEST['num_pagina'];


$seg_permiso_tabla_autonoma	=	new seg_permiso_tabla_autonoma;


//=== Valida si puede consultar la informacion>>>
$ind_tiene_permiso 			= 	$seg_permiso_tabla_autonoma->f_get_permiso_select_tabla($cod_ventana_emergente,$cod_perfil);
	
if(!$row_usuario){
	array_push($arr_mensajes,'1'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 	//registra el codigo del mensaje que se debe mostrar
	$proceso			= NULL;		//no procesa nada
	$consulta			= NULL;		//no procesa nada
	$salida				= NULL;		//no procesa nada
}else if(!$ind_tiene_permiso){
	array_push($arr_mensajes,'1'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 	//registra el codigo del mensaje que se debe mostrar
	$proceso			= NULL;		//no procesa nada
	$consulta			= NULL;		//no procesa nada
	$salida				= NULL;		//no procesa nada
}
if(!$cod_ventana_emergente){
	array_push($arr_mensajes,'2'); 				//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,'Codigo de la Tabla'); 		//registra el codigo del mensaje que se debe mostrar		
	$proceso			= NULL;		//no procesa nada
	$consulta			= NULL;		//no procesa nada
	$salida				= NULL;		//no procesa nada
}

?>