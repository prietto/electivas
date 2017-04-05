<?php 
$obj_listbox					=	new obj_listbox;
$sis_genericos					=	new sis_genericos;
$tabla_autonoma_personalizado	=	new tabla_autonoma_personalizado;
$proceso_adicional_pantalla		= 	new proceso_adicional_pantalla;
$seg_perfil						=	new seg_perfil;
$seg_perfil_usuario				= 	new seg_perfil_usuario;


// conserva las variables para los filtros en caso de que devuelva
$array_request_reporte		= $sis_genericos->f_genera_variables_anteriores($_REQUEST);


$cod_perfil_pk 				= $reg_seleccionado[0];


// === informacion del perfil
$row_perfil 	= $seg_perfil->f_get_row($cod_perfil_pk);
$txt_perfil		= $row_perfil['txt_nombre'];

$cadena_usuarios 		= $seg_perfil_usuario->f_get_usuarios($cod_perfil_pk);


// cursor para saber a que procesos tiene permiso el perfil
$cursor_procesos_perfil = $proceso_adicional_pantalla->f_get_procesos_perfil($cod_perfil_pk);


// === COMBO PARA LOS PROCESOS
$cursor_procesos			= $proceso_adicional_pantalla->f_get_proceso_activo();
$cmb_procesos				= $obj_listbox->f_crear_lista($cursor_procesos, $cod_proceso_adicional);


//=== Evalua algun java script especifico para esta tabla >>>
$row_js_personalizado	= $tabla_autonoma_personalizado->f_get_row($cod_tabla,$cod_navegacion);
if($row_js_personalizado['txt_js'])		$js_navegacion = "../../js/".$row_js_personalizado['txt_js'];
else									$js_navegacion = "../../js/ver_default_script_tabla_autonoma.js";

?>