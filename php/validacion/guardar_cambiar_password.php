<?
include ("../librerias/tabla_autonoma.php");

//=== Valida si el perfil puede ejecutar la accion >>>
$ind_tiene_permiso = $seg_navegacion->f_permiso_navegacion($cod_navegacion,$cod_perfil);

//=== crea  dinamicamente todas las variables que vienen por $_REQUEST >>>
/*$array_variables = array_keys($_REQUEST);
foreach($array_variables as $variable) 	${$variable} = $_REQUEST[$variable];*/

if(!$row_usuario){
	array_push($arr_mensajes,'3'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 	//registra el codigo del mensaje que se debe mostrar
	$proceso			= NULL;		//no procesa nada
	$consulta			= NULL;		//no procesa nada
	$salida				= "ver_validar_usuario.php"; //lo envia a la pagina anterior
}else if(!$ind_tiene_permiso){
	array_push($arr_mensajes,'3'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 	//registra el codigo del mensaje que se debe mostrar
	$proceso			= NULL;		//no procesa nada
	$consulta			= NULL;		//no procesa nada
	$salida				= "ver_validar_usuario.php"; //lo envia a la pagina anterior
}

$num_rows = $seg_usuario->f_valida_password($cod_usuario,$txt_password_actual);
if($num_rows == 0){
	
	array_push($arr_mensajes,'4'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 	//registra el codigo del mensaje que se debe mostrar
	$proceso			= NULL;		//no procesa nada
	$consulta			= NULL;		//no procesa nada
	$salida				= "ver_cambiar_password.php"; //lo envia a la pagina anterior
}
if($txt_confirma_password != $txt_nuevo_password){
	array_push($arr_mensajes,'5'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 	//registra el codigo del mensaje que se debe mostrar
	$proceso			= NULL;		//no procesa nada
	$consulta			= NULL;		//no procesa nada
	$salida				= "ver_cambiar_password.php"; //lo envia a la pagina anterior
}
if(!$txt_nuevo_password){
	array_push($arr_mensajes,'1'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,'Nuevo Password'); 	//registra el codigo del mensaje que se debe mostrar
	$proceso			= NULL;		//no procesa nada
	$consulta			= NULL;		//no procesa nada
	$salida				= "ver_cambiar_password.php"; //lo evia a la pagina anterior
}

?>