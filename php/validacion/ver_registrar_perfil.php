<?php
include("../librerias/tabla_autonoma.php");

include("../librerias/columna_tabla_autonoma.php");
include("../librerias/sis_genericos.php");
include("../librerias/obj_listbox.php");
include("../librerias/tabla_autonoma_personalizado.php");
include("../librerias/seg_operacion_tabla.php");
include("../librerias/seg_perfil.php");



$num_max_registros			=		$_REQUEST['num_max_registros'];
$cod_usuario_pk				= 		$_REQUEST['cod_usuario_pk']; 
$txt_login					=		$_REQUEST['txt_login'];
$cod_pk						=		$_REQUEST['cod_pk'];
$ind_buscar					=		$_REQUEST['ind_buscar'];
$num_pagina					=		$_REQUEST['num_pagina'];
$ord_por					= 		$_REQUEST['ord_por']; 
$txt_nombre_columna_iframe	=		$_REQUEST['txt_nombre_columna_iframe'];
$cod_ventana_emergente		=		$_REQUEST['cod_ventana_emergente'];
$cod_usuario				=		$_REQUEST['cod_usuario'];
$cod_navegacion				=		$_REQUEST['cod_navegacion'];
$ind_limpiar_variables		=		$_REQUEST['ind_limpiar_variables'];
$cod_tabla					=		$_REQUEST['cod_tabla'];
$cod_tabla_detalle			=		$_REQUEST['cod_tabla_detalle'];
$seg_permiso_tabla_autonoma	=	new seg_permiso_tabla_autonoma;
//=== Valida si puede crear nuevos registros >>>
if(!$cod_pk) 
	$ind_tiene_permiso = $seg_permiso_tabla_autonoma->f_get_permiso_insert_tabla($cod_tabla,$cod_perfil);
//=== Valida si puede consultar el  registros >>>
else if($cod_pk) 
	$ind_tiene_permiso = $seg_permiso_tabla_autonoma->f_get_permiso_select_tabla($cod_tabla,$cod_perfil);
	
if(!$row_usuario){
	array_push($arr_mensajes,'1'); 					//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 					//registra el codigo del mensaje que se debe mostrar
	$proceso			= NULL;						//no procesa nada
	$consulta			= "ver_menu_usuario.php"; 	//lo envia a la pagina anterior
	$salida				= "ver_menu_usuario.php"; 	//lo envia a la pagina anterior
}else if(!$ind_tiene_permiso){
	array_push($arr_mensajes,'1'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 	//registra el codigo del mensaje que se debe mostrar
	$proceso			= NULL;		//no procesa nada
	$consulta			= "ver_menu_usuario.php"; //lo envia a la pagina anterior
	$salida				= "ver_menu_usuario.php"; //lo envia a la pagina anterior
}
if(!$cod_tabla){
	array_push($arr_mensajes,'2'); 				//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,'Codigo de la Tabla'); 		//registra el codigo del mensaje que se debe mostrar		
	$proceso			= NULL;							//no procesa nada
	$consulta			= "ver_menu_usuario.php";	//Regresa a  la pagina anterior
	$salida				= "ver_menu_usuario.php";	//Regresa a  la pagina anterior

}
?>