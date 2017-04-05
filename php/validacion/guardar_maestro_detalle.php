<?
include("../librerias/tabla_autonoma.php");
include("../librerias/columna_tabla_autonoma.php");
include("../librerias/sis_genericos.php");
include("../librerias/obj_listbox.php");
include("../librerias/tabla_autonoma_personalizado.php");
include("../librerias/proceso_adicional_pantalla.php");
include("../librerias/c_file.php");
include("../librerias/reporte_tabla.php");



$cod_pk	 							=	$_REQUEST['cod_pk'] ;
$txt_ruta_mp3	 					=	$_REQUEST['txt_ruta_mp3'] ;
$ind_new_row	 					=	$_REQUEST['ind_new_row'] ;
$cod_tabla_iframe	 				=	$_REQUEST['cod_tabla_iframe'] ;
$ind_guardar_datos_tabla_autonoma	=	$_REQUEST['ind_guardar_datos_tabla_autonoma'] ;
$txt_nombre_columna_iframe	 		=	$_REQUEST['txt_nombre_columna_iframe'] ;
$nom_columna_con_foto	 			=	$_REQUEST['nom_columna_con_foto'] ;
$cod_ventana_emergente	 			=	$_REQUEST['cod_ventana_emergente'] ;
$val_campo	 						=	$_REQUEST['val_campo'] ;
$cod_usuario	 					=	$_REQUEST['cod_usuario'] ;
$cod_navegacion	 					=	$_REQUEST['cod_navegacion'] ;
$ind_limpiar_variables	 			=	$_REQUEST['ind_limpiar_variables'] ;
$cod_tabla	 						=	$_REQUEST['cod_tabla'] ;
$cod_tabla_detalle	 				=	$_REQUEST['cod_tabla_detalle'] ;



$cod_navegacion_formulario	= 	44; 
$seg_permiso_tabla_autonoma	=	new seg_permiso_tabla_autonoma;
$columna_tabla_autonoma		=	new columna_tabla_autonoma;

// permisos del usuario sobre los modulos a los que puede ingresar
$cursor_permisos_template = $seg_permiso_tabla_autonoma->f_get_permisos_modulos($cod_perfil);

if($ind_new_row)	
	$ind_tiene_permiso = $seg_permiso_tabla_autonoma->f_get_permiso_insert_tabla($cod_tabla,$cod_perfil);
else
	$ind_tiene_permiso = $seg_permiso_tabla_autonoma->f_get_permiso_update_tabla($cod_tabla,$cod_perfil);

if(!$row_usuario){
	array_push($arr_mensajes,'3'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 	//registra el codigo del mensaje que se debe mostrar
	$proceso				= NULL;		//no procesa nada
	$consulta				= "ver_registrar_maestro_detalle_autonomo.php";	//Regresa a  la pagina anterior
	$salida					= "ver_registrar_maestro_detalle_autonomo.php";	 //Regresa a  la pagina anterior
}else if(!$ind_tiene_permiso){
	array_push($arr_mensajes,'3'); 	//registra el codigo del mensaje que se debe mostrar
	array_push($arr_parametro,''); 	//registra el codigo del mensaje que se debe mostrar
	$proceso				= NULL;		//no procesa nada
	$consulta				= "ver_registrar_maestro_detalle_autonomo.php";	//Regresa a  la pagina anterior
	$salida					= "ver_registrar_maestro_detalle_autonomo.php";	 //Regresa a  la pagina anterior
}else{
	//=== Valida los datos de la tabla primaria >>>		
	$array_retorno			= 	$columna_tabla_autonoma->f_valida_tabla(
								$cod_tabla			,
								$cod_tabla_detalle	,
								$_POST				,
								$cod_pk				,
								$arr_mensajes		,
								$arr_parametro		,
								$cod_navegacion_formulario
								);
	$arr_mensajes			=	$array_retorno['arr_mensajes'];
	$arr_parametro			=	$array_retorno['arr_parametro'];
	//=== Valida los datos de la tabla detalle >>>		

	$array_retorno			= 	$columna_tabla_autonoma->f_valida_tabla_detalle(
								$cod_navegacion_formulario	,
								$cod_tabla_detalle			,
								$_POST						,
								$arr_mensajes				,
								$arr_parametro		
								);
	$arr_mensajes			=	$array_retorno['arr_mensajes'];
	$arr_parametro			=	$array_retorno['arr_parametro'];

	//=== En caso de error indica a que pantalla debe regresar>>>		
	if ($arr_mensajes[0] ){
		$proceso			= NULL;										//No procesa 
		$consulta			= "ver_registrar_maestro_detalle_autonomo.php";	//Regresa a  la pagina anterior
		$salida				= "ver_registrar_maestro_detalle_autonomo.php";	//Regresa a  la pagina anterior
	}
}



?>