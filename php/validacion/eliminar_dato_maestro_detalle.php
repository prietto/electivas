<?
include("../librerias/tabla_autonoma.php");

include("../librerias/columna_tabla_autonoma.php");
include("../librerias/sis_genericos.php");
include("../librerias/obj_listbox.php");
include("../librerias/proceso_adicional_pantalla.php");
include("../librerias/tabla_autonoma_personalizado.php");
include("../librerias/reporte_tabla.php");
$cod_pk  							=$_REQUEST['cod_pk'];
$ind_new_row  						=$_REQUEST['ind_new_row'];
$cod_tabla_iframe  					=$_REQUEST['cod_tabla_iframe'];
$ind_guardar_datos_tabla_autonoma  	=$_REQUEST['ind_guardar_datos_tabla_autonoma'];
$txt_nombre_columna_iframe  		=$_REQUEST['txt_nombre_columna_iframe'];
$nom_columna_con_foto  				=$_REQUEST['nom_columna_con_foto'];
$cod_ventana_emergente  			=$_REQUEST['cod_ventana_emergente'];
$val_campo  						=$_REQUEST['val_campo'];
$cod_usuario  						=$_REQUEST['cod_usuario'];
$cod_navegacion  					=$_REQUEST['cod_navegacion'];
$ind_limpiar_variables  			=$_REQUEST['ind_limpiar_variables'];
$cod_tabla  						=$_REQUEST['cod_tabla'];
$cod_tabla_detalle  				=$_REQUEST['cod_tabla_detalle'];



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
	$consulta			= "ver_registrar_maestro_detalle_autonomo.php"; //lo envia a la pagina anterior
	$salida				= "ver_registrar_maestro_detalle_autonomo.php"; //lo envia a la pagina anterior
}
if(!$cod_tabla){
	array_push($arr_mensajes,'2'); 				//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,'Codigo de la Tabla'); 		//registra el codigo del mensaje que se debe mostrar		
	$proceso			= NULL;							//no procesa nada
	$consulta			= "ver_registrar_maestro_detalle_autonomo.php";	//Regresa a  la pagina anterior
	$salida				= "ver_registrar_maestro_detalle_autonomo.php";	//Regresa a  la pagina anterior
}
if(!$cod_pk){
	array_push($arr_mensajes,'2'); 				//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,'Codigo de la Tabla'); 		//registra el codigo del mensaje que se debe mostrar		
	$proceso			= NULL;							//no procesa nada
	$consulta			= "ver_registrar_maestro_detalle_autonomo.php";	//Regresa a  la pagina anterior
	$salida				= "ver_registrar_maestro_detalle_autonomo.php";	//Regresa a  la pagina anterior
}
if(!$cod_tabla_detalle){
	array_push($arr_mensajes,'2'); 				//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,'Codigo de la Tabla Detalle'); 		//registra el codigo del mensaje que se debe mostrar		
	$proceso			= NULL;							//no procesa nada
	$consulta			= "ver_registrar_maestro_detalle_autonomo.php";	//Regresa a  la pagina anterior
	$salida				= "ver_registrar_maestro_detalle_autonomo.php";	//Regresa a  la pagina anterior
}

?>