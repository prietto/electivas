x<?
include ("../librerias/tabla_autonoma.php");
//=== Valida si el perfil puede ejecutar la accion >>>
$ind_tiene_permiso = $seg_navegacion->f_permiso_navegacion($cod_navegacion,$cod_perfil);

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
?>