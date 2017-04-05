<?php 

$reporte_tabla 					= new reporte_tabla;
$obj_listbox					= new obj_listbox();
$seg_perfil						= new seg_perfil();
$seg_perfil_usuario				= new seg_perfil_usuario();
$tabla_autonoma_personalizado	= new tabla_autonoma_personalizado();

$cod_perfil_pk = $reg_seleccionado[0];

// === informacion del perfil
$row_perfil 	= $seg_perfil->f_get_row($cod_perfil_pk);
$txt_perfil		= $row_perfil['txt_nombre'];



$cadena_usuarios 		= $seg_perfil_usuario->f_get_usuarios($cod_perfil_pk);


// === combo de reportes del sistema
$cursor_reporte 	= $reporte_tabla->f_get_activos_all();
$cmb_reporte_tabla	= $obj_listbox->f_crear_lista($cursor_reporte, $cod_reporte);


// == consulta los reportes asociados al perfil de la db
$cursor_permisos_reporte = $reporte_tabla->f_get_by_perfil($reg_seleccionado[0]);



//=== Evalua algun java script especifico para esta tabla >>>
$row_js_personalizado	= $tabla_autonoma_personalizado->f_get_row($cod_tabla,$cod_navegacion);
if($row_js_personalizado['txt_js'])		$js_navegacion = "../../js/".$row_js_personalizado['txt_js'];
else									$js_navegacion = "../../js/ver_default_script_tabla_autonoma.js";






?>