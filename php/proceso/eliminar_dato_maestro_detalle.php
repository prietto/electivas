<?
$columna_tabla_autonoma	 		=	new columna_tabla_autonoma;
$tabla_autonoma_personalizado	=	new tabla_autonoma_personalizado;

//=== Elimina el detalle de la tabla >>>
$columna_tabla_autonoma->p_eliminar_detalle($cod_tabla_detalle,$cod_tabla,$cod_pk);
$columna_tabla_autonoma->p_eliminar_registro($cod_tabla,$cod_pk);
$ind_limpiar_variables	= 1;

//=== Evalua si al guardar los datos debe ejecutar algun tipo de proceso adicional>>>
$row_autonoma_personalizado	=	$tabla_autonoma_personalizado->f_get_row($cod_tabla_detalle,46);
$txt_proceso_php			=	$row_autonoma_personalizado['txt_proceso_php'];
if($txt_proceso_php)			include ("../proceso/$txt_proceso_php");

?>	