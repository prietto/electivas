<?
$tabla_autonoma					=	new tabla_autonoma;
$columna_tabla_autonoma			=	new columna_tabla_autonoma;
$tabla_autonoma_personalizado	=	new tabla_autonoma_personalizado;
$arr_info_archivo				= 	$_FILES;



//=== Guarda los datos de la orden de Servicio>>>
$columna_tabla_autonoma->p_modificar_registro(
$cod_tabla			,
$_REQUEST				,
$cod_pk				,
NULL				,
NULL				,
$arr_info_archivo
);


// === debe guardar los permisos para los modulos para el perfil creado
$seg_permiso_tabla_autonoma->p_modifica_registro($_REQUEST);


//=== Evalua si al guardar los datos debe ejecutar algun tipo de proceso adicional>>>
$row_autonoma_personalizado	=	$tabla_autonoma_personalizado->f_get_row($cod_tabla,38);
$txt_proceso_php			=	$row_autonoma_personalizado['txt_proceso_php'];
if($txt_proceso_php)	include ("../proceso/$txt_proceso_php");

$ind_limpiar_variables	= 1;
$ind_conservar_pk		= 0;
$ind_buscar				= 1;

?>