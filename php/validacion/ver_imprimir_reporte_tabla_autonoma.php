<?
include("../librerias/tabla_autonoma.php");

include("../librerias/columna_tabla_autonoma.php");
include("../librerias/sis_genericos.php");
include("../librerias/obj_listbox.php");
include("../librerias/reporte_tabla.php");
 
if(!$cod_tabla) 	$cod_tabla = $_REQUEST['cod_tabla'];
if(!$cod_perfil) 	$cod_perfil = $_REQUEST['cod_perfil'];



$seg_permiso_tabla_autonoma	=	new seg_permiso_tabla_autonoma;

//=== Valida si puede consultar la informacion>>>
$ind_tiene_permiso 			= 	$seg_permiso_tabla_autonoma->f_get_permiso_select_tabla($cod_tabla,$cod_perfil);
	
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
if(!$cod_tabla){
	array_push($arr_mensajes,'2'); 				//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,'Codigo de la Tabla'); 		//registra el codigo del mensaje que se debe mostrar		
	$proceso			= NULL;		//no procesa nada
	$consulta			= NULL;		//no procesa nada
	$salida				= NULL;		//no procesa nada
}

?>