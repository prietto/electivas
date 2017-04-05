<?php
include("../librerias/tabla_autonoma.php");
include("../librerias/columna_tabla_autonoma.php");
include("../librerias/sis_genericos.php");
include("../librerias/obj_listbox.php");
include("../librerias/tabla_autonoma_personalizado.php");
include("../librerias/seg_perfil.php");
include("../librerias/seg_operacion_tabla.php");
include("../librerias/proceso_adicional_pantalla.php");
include("../librerias/reporte_tabla.php");
include("../librerias/seg_perfil_proceso_adicional.php");
include("../librerias/seg_perfil_reporte.php");

$seg_permiso_tabla_autonoma	=	new seg_permiso_tabla_autonoma;

if(!$row_usuario){
	array_push($arr_mensajes,'1'); 					//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 					//registra el codigo del mensaje que se debe mostrar
	$proceso			= NULL;						//no procesa nada
	$consulta			= "ver_menu_usuario.php"; 	//lo envia a la pagina anterior
	$salida				= "ver_menu_usuario.php"; 	//lo envia a la pagina anterior
}

?>