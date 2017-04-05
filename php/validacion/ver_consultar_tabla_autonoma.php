<?php
include("../librerias/tabla_autonoma.php");
include("../librerias/columna_tabla_autonoma.php");
include("../librerias/sis_genericos.php");
include("../librerias/obj_listbox.php");
include("../librerias/tabla_autonoma_personalizado.php");
include("../librerias/proceso_adicional_pantalla.php");
include("../librerias/reporte_tabla.php");


$num_max_registros			=	$_REQUEST['num_max_registros'];
$cod_reporte_tabla			=	$_REQUEST['cod_reporte_tabla'];
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
$tabla_autonoma				=	new tabla_autonoma();
//=== Valida si puede consultar la informacion>>>
$ind_tiene_permiso 			= 	$seg_permiso_tabla_autonoma->f_get_permiso_select_tabla($cod_tabla,$cod_perfil);

// permisos del usuario sobre los modulos a los que puede ingresar
$cursor_permisos_template = $seg_permiso_tabla_autonoma->f_get_permisos_modulos($cod_perfil);

// informacion de la tabla
if($cod_tabla)$row_tabla = $tabla_autonoma->f_get_row($cod_tabla);



if(!$row_usuario){
	array_push($arr_mensajes,'3'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 	//registra el codigo del mensaje que se debe mostrar
	$proceso			= NULL;		//no procesa nada
	$consulta			= "ver_validar_usuario.php"; //lo envia a la pagina anterior
	$salida				= "ver_validar_usuario.php"; //lo envia a la pagina anterior
}else if(!$ind_tiene_permiso){
	array_push($arr_mensajes,'3'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 	//registra el codigo del mensaje que se debe mostrar
	$proceso			= NULL;		//no procesa nada
	$consulta			= "ver_tablas_autonomas.php"; //lo envia a la pagina anterior
	$salida				= "ver_tablas_autonomas.php"; //lo envia a la pagina anterior
}
if(!$cod_tabla){
	array_push($arr_mensajes,'2'); 				//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,'Codigo de la Tabla'); 		//registra el codigo del mensaje que se debe mostrar		
	$proceso			= NULL;							//no procesa nada
	$consulta			= "ver_tablas_autonomas.php";	//Regresa a  la pagina anterior
	$salida				= "ver_tablas_autonomas.php";	//Regresa a  la pagina anterior
}

?>