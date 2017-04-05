<?
$cod_navegacion					= 44;
//=== Instancias de las librerias creadas en la validacion >>>
$tabla_autonoma 				= new tabla_autonoma;
$columna_tabla_autonoma 		= new columna_tabla_autonoma;
$tabla_autonoma_personalizado	= new tabla_autonoma_personalizado;
$sis_genericos					= new sis_genericos;
$obj_listbox					= new obj_listbox();

$ind_registro = true;

// conserva las variables para los filtros en caso de que devuelva
$array_request_reporte	= $sis_genericos->f_genera_variables_anteriores($_REQUEST);

//======================================================>>>
//						MAESTRO 
//======================================================>>>
//=== Obtiene informacion detallada de la tabla >>>
$row_tabla_autonoma		= 	$tabla_autonoma->f_get_row($cod_tabla);
$alias_tabla_autonoma	= 	strtoupper($row_tabla_autonoma['txt_alias']);
$alias_tabla_autonoma	= 	str_replace("_"," ",$alias_tabla_autonoma);

//=== Obtiene el nombre de la tabla detalle >>>
$row_tabla_detalle		= 	$tabla_autonoma->f_get_row($cod_tabla_detalle);
$alias_tabla_detalle	= 	strtoupper($row_tabla_detalle['txt_alias']);
$alias_tabla_detalle	= 	str_replace("_"," ",$alias_tabla_detalle);



//=== Obtiene la llave primaria >>>
if(!$cod_pk){			
	$cod_pk			=	$tabla_autonoma->p_get_next_pk($cod_usuario,$row_tabla_autonoma);
	$ind_new_row	=	1;
}
//=== Obtiene los imputs de la consulta >>>
$row_imputs				=$columna_tabla_autonoma->f_get_imputs_formulario($cod_tabla,$cod_tabla_detalle,$cod_navegacion,$ind_registro);



//=== Obtiene los valores por defecto, antes de dar click en guardar >>>
if(!$ind_guardar_datos_tabla_autonoma){
	$row_imputs			=$columna_tabla_autonoma->f_get_valor_imput($cod_pk, $row_tabla_autonoma,$row_imputs);
}else{
	// valores obtenidos al refrescar pantalla >>>
	$row_imputs			=	$columna_tabla_autonoma->f_replazar_valor_imput($row_tabla_autonoma,$row_imputs, $_REQUEST); 
}

$num_columnas			=	count($row_imputs);

//=== Valida si puede mostrar el boton de guardar la modificacion de un registro>>>
$ind_mostrar_boton_guardar		= false;
if($ind_new_row)
	$ind_mostrar_boton_guardar	= 	$seg_permiso_tabla_autonoma->f_get_permiso_insert_tabla($cod_tabla,$cod_perfil);
else
	$ind_mostrar_boton_guardar	= 	$seg_permiso_tabla_autonoma->f_get_permiso_update_tabla($cod_tabla,$cod_perfil);

//=== Valida debe mostrar el boton de eliminar un registro>>>
$ind_mostrar_boton_eliminar = 	$seg_permiso_tabla_autonoma->f_get_permiso_delete_tabla($cod_tabla,$cod_perfil);

//======================================================>>>
//					DETALLE
//======================================================>>>
$tabla_imputs_detalle	=	$columna_tabla_autonoma->f_dar_formato_imputs_tabla_detalle(
							$cod_pk				,
							$cod_tabla			,
							$cod_tabla_detalle	,
							$cod_navegacion		,
							$_REQUEST				,
							$ind_guardar_datos_tabla_autonoma
							);

//=== Evalua algun java script especifico para esta tabla >>>

$row_js_personalizado	= $tabla_autonoma_personalizado->f_get_row($cod_tabla_detalle,$cod_navegacion);
if($row_js_personalizado['txt_js'])		$js_navegacion 	= "../../js/".$row_js_personalizado['txt_js'];
else									$js_navegacion 	= "../../js/ver_default_script_maestro_detalle.js";
if($row_js_personalizado['txt_js_adicional'])		$js_extra	= "../../js/".$row_js_personalizado['txt_js_adicional'];

?>