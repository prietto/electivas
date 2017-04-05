<?
include("../librerias/tabla_autonoma.php");

include("../librerias/columna_tabla_autonoma.php");
include("../librerias/sis_genericos.php");
include("../librerias/obj_listbox.php");
include("../librerias/tabla_autonoma_personalizado.php");
include("../librerias/proceso_adicional_pantalla.php");
include("../librerias/reporte_tabla.php");

$seg_permiso_tabla_autonoma	=	new seg_permiso_tabla_autonoma;

//=== Valida si puede consultar la informacion>>>
$ind_tiene_permiso 			= 	$seg_permiso_tabla_autonoma->f_get_permiso_delete_tabla($cod_tabla,$cod_perfil);
	
if(!$row_usuario){
	array_push($arr_mensajes,'1'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 	//registra el codigo del mensaje que se debe mostrar
	$proceso			= NULL;		//no procesa nada
	$consulta			= "ver_menu_usuario.php"; //lo envia a la pagina anterior
	$salida				= "ver_menu_usuario.php"; //lo envia a la pagina anterior
}else if(!$ind_tiene_permiso){
	array_push($arr_mensajes,'1'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 	//registra el codigo del mensaje que se debe mostrar
	$proceso			= NULL;		//no procesa nada
	$consulta			= "ver_registrar_dato_tabla_autonoma.php"; //lo envia a la pagina anterior
	$salida				= "ver_registrar_dato_tabla_autonoma.php"; //lo envia a la pagina anterior
}
if(!$cod_tabla){
	array_push($arr_mensajes,'2'); 				//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,'Codigo de la Tabla'); 		//registra el codigo del mensaje que se debe mostrar		
	$proceso			= NULL;							//no procesa nada
	$consulta			= "ver_registrar_dato_tabla_autonoma.php";	//Regresa a  la pagina anterior
	$salida				= "ver_registrar_dato_tabla_autonoma.php";	//Regresa a  la pagina anterior
}
if(!$cod_pk){
	array_push($arr_mensajes,'2'); 				//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,'Codigo de la Tabla'); 		//registra el codigo del mensaje que se debe mostrar		
	$proceso			= NULL;							//no procesa nada
	$consulta			= "ver_registrar_dato_tabla_autonoma.php";	//Regresa a  la pagina anterior
	$salida				= "ver_registrar_dato_tabla_autonoma.php";	//Regresa a  la pagina anterior
}

?>