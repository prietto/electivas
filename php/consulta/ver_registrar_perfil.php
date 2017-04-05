<?
//=== Instancias de las librerias creadas en la validacion >>>
$tabla_autonoma 				= new tabla_autonoma;
$columna_tabla_autonoma 		= new columna_tabla_autonoma;
$sis_genericos					= new sis_genericos;
$obj_listbox					= new obj_listbox();
$tabla_autonoma_personalizado	= new tabla_autonoma_personalizado();
$seg_operacion_tabla			= new seg_operacion_tabla();
$seg_perfil						= new seg_perfil();
$seg_permiso_tabla_autonoma		= new seg_permiso_tabla_autonoma();

$ind_registro = true;

if($ind_guardar_dato == 1){
	// === debe guardar los permisos para los modulos para el perfil creado
	$seg_permiso_tabla_autonoma->p_modifica_registro($_REQUEST);	
}


// conserva las variables para los filtros en caso de que devuelva
$array_request_reporte			= $sis_genericos->f_genera_variables_anteriores($_REQUEST);


//=== Obtiene informacion detallada de la tabla >>>
$row_tabla_autonoma		= $tabla_autonoma->f_get_row($cod_tabla);

//=== Obtiene la llave primaria >>>
if(!$cod_pk){			
	$cod_pk			=	$seg_perfil->p_get_next_pk($cod_usuario,$row_tabla_autonoma);
	$ind_new_row	=	1;
}else {			
	//=== Esto es para casos donde se trabaja tablas uno a uno donde la llave primaria viene desde otra pagina
	$cod_pk			=	$tabla_autonoma->p_verificar_nuevo_pk($cod_pk, $cod_usuario,$row_tabla_autonoma);
}

//=== Obtiene los imputs de la consulta >>>
$row_imputs				=$columna_tabla_autonoma->f_get_imput($cod_tabla,$ind_registro);

//=== Obtiene los valores por defecto, antes de dar click en guardar >>>
if(!$ind_guardar_datos_tabla_autonoma){
	$row_imputs			=$columna_tabla_autonoma->f_get_valor_imput($cod_pk, $row_tabla_autonoma,$row_imputs);
}else{
	// valores obtenidos al refrescar pantalla >>>
	$row_imputs			=$columna_tabla_autonoma->f_replazar_valor_imput($row_tabla_autonoma,$row_imputs, $_POST); 
}



$num_columnas			=count($row_imputs);
$alias_tabla_autonoma	= strtoupper($row_tabla_autonoma['txt_alias']);
$alias_tabla_autonoma	= str_replace("_"," ",$alias_tabla_autonoma);


// retorna cursor con los permisos por perfil
$cursor_permisos 		= $seg_permiso_tabla_autonoma->f_get_permisos($_REQUEST,$cod_pk); 

$array_permisos_vector	= $seg_permiso_tabla_autonoma->f_get_permisos_vector($_REQUEST,$cod_pk); 

$arr_permisos_full		= $seg_permiso_tabla_autonoma->f_get_activo(); /// todos los registros de la tabla permisos



// ==== combo de modulos en el detalle
$cursor_modulo 			= 	$tabla_autonoma->f_get_activo();
$cmb_tablas_autonomas	=	$obj_listbox->f_crear_lista($cursor_modulo, $cod_modulo);

$cursor_operacion		=	$seg_operacion_tabla->f_get_all();
$cmb_operacion_tabla	=	$obj_listbox->f_crear_lista($cursor_operacion, $cod_operacion);

		


//=== Valida si puede mostrar el boton de guardar la modificacion de un registro>>>
$ind_mostrar_boton_guardar		= false;
if($ind_new_row)
	$ind_mostrar_boton_guardar	= 	$seg_permiso_tabla_autonoma->f_get_permiso_insert_tabla($cod_tabla,$cod_perfil);
else
	$ind_mostrar_boton_guardar	= 	$seg_permiso_tabla_autonoma->f_get_permiso_update_tabla($cod_tabla,$cod_perfil);

//=== Valida debe mostrar el boton de eliminar un registro>>>
$ind_mostrar_boton_eliminar = 	$seg_permiso_tabla_autonoma->f_get_permiso_delete_tabla($cod_tabla,$cod_perfil);

//=== Evalua algun java script especifico para esta tabla >>>

$row_js_personalizado	= $tabla_autonoma_personalizado->f_get_row($cod_tabla,$cod_navegacion);
if($row_js_personalizado['txt_js'])		$js_navegacion = "../../js/".$row_js_personalizado['txt_js'];
else									$js_navegacion = "../../js/ver_default_script_tabla_autonoma.js";


?>