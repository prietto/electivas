<?php

//=== Instancias de las librerias creadas en la validacion >>>
$tabla_autonoma 				= new tabla_autonoma;
$columna_tabla_autonoma 		= new columna_tabla_autonoma;
$sis_genericos					= new sis_genericos;
$obj_listbox					= new obj_listbox;
$tabla_autonoma_personalizado	= new tabla_autonoma_personalizado;
$proceso_adicional_pantalla		= new proceso_adicional_pantalla;
$reporte_tabla					= new reporte_tabla();

//=== Evalua algun java script especifico para esta tabla >>>
$row_js_personalizado	= $tabla_autonoma_personalizado->f_get_row($cod_tabla,78);

if($row_js_personalizado['txt_proceso_php']){
	$txt_proceso_php = $row_js_personalizado['txt_proceso_php'];
	$ruta_proceso = '../proceso/'.$txt_proceso_php;

	if(is_file($ruta_proceso)){
		include('../proceso/'.$txt_proceso_php);
	}
}



$ind_registro = FALSE; // indicador de que esta en la pantalla de consulta

//=== Valida si puede mostrar el boton de crear nuevo registro>>>
$ind_tiene_permiso_insert	= 	$seg_permiso_tabla_autonoma->f_get_permiso_insert_tabla($cod_tabla,$cod_perfil);

//=== Obtiene informacion detallada de la tabla >>>
$row_tabla_autonoma		= $tabla_autonoma->f_get_row($cod_tabla);


//=== Obtiene los imputs de la consulta >>>
$row_imputs			=$columna_tabla_autonoma->f_get_imput_filtro_maestro_detalle($cod_tabla, $cod_tabla_detalle,$ind_registro);


//=== Evalua si debe limpiar las variables >>>
if($ind_limpiar_variables == 1){
	$_REQUEST				= $columna_tabla_autonoma->f_limpiar_variables_post($row_tabla_autonoma, $_REQUEST,$ind_conservar_pk);
	$_REQUEST['ord_por']			=NULL;
	$_REQUEST['ind_buscar']			=NULL;
	$ord_por						=NULL;
	$ind_mostrar_todo				= 	NULL;
	$_REQUEST['ind_mostrar_todo']	=	NULL;
	$num_max_registros				=	NULL;
	$reg_seleccionado 				= 	NULL;
	//$ind_buscar					=	NULL;
	$reg_seleccionado				=	NULL;
	$_REQUEST['reg_seleccionado']	=	NULL;	
	$num_max_registros=20;
	$num_pagina						=	NULL;
}



//==== Evalua para regrese a la pantalla anterior sin hacer cambios >>>
if($array_request_reporte){	
	$_REQUEST						= $sis_genericos->f_get_variables_anteriores($_REQUEST,$array_request_reporte);
	if(!$cod_reporte_tabla)			$cod_reporte_tabla = $_REQUEST['cod_reporte_tabla'];
	if(!$ind_limpiar_variables || $ind_limpiar_variables == 0)$num_max_registros = 	$_REQUEST['num_max_registros'];
	$ind_limpiar_variables			= 	0;
	$ind_buscar						=	1;
	$num_pagina						= 	$_REQUEST['num_pagina'];
	$num_registros					= 	$_REQUEST['num_registros'];
	$ord_por						= 	$_REQUEST['ord_por'];
}


//=== Cantidad maxima por pantallaso >>>
if(!$num_max_registros) $num_max_registros=20;

//=== Obtiene los valores asignados en los combos >>>
$row_imputs	=$columna_tabla_autonoma->f_remplazar_valor_imput_filtro(
											$row_tabla_autonoma,$row_imputs	,
											$_REQUEST						,
											$num_max_registros				, 
											$cod_tabla_detalle				,
											NULL
											); 
											



// valida el reporte que llega por si llega desde otra pantalla o otra tabla
// si el reporte no pertenece a la tabla retorna el reporte por defecto (si tiene permisos)
$cod_reporte_tabla = $reporte_tabla->f_valida_reporte_vs_tabla($cod_reporte_tabla,$cod_tabla,$cod_usuario);
$_REQUEST['cod_reporte_tabla'] = $cod_reporte_tabla;


	
$num_columnas			= count($row_imputs);
$alias_tabla_autonoma	= strtoupper($row_tabla_autonoma['txt_alias']);
$alias_tabla_autonoma	= str_replace("_"," ",$alias_tabla_autonoma);




// pasos para exportar a excel si llego el indicador para exportar
if($ind_exportar_excel == 1){

	if($cod_reporte_tabla){
		
		// saca el nombre del reporte_tabla
		//$row_reporte_tabla 	= $reporte_tabla->f_get_row($cod_reporte_tabla);
		//$txt_reporte_tabla	= $row_reporte_tabla['txt_nombre'];
		$txt_reporte_tabla	= $alias_tabla_autonoma;
		
		$resultado_cursor	= 	$columna_tabla_autonoma->f_consultar_maestro_detalle(
								$cod_tabla				,
								$cod_tabla_detalle		,
								$_REQUEST				,
								$ord_por				,
								$num_max_registros		,
								$num_pagina				,
								$ind_consulta_2
								);
		 include("../proceso/exportar_excel.php"); exit(); 
	}
}





//=== CONSULTA LA INFORMACIÓN>>>
if($ind_buscar){
	$resultado_cursor	= 	$columna_tabla_autonoma->f_consultar_maestro_detalle(
								$cod_tabla				,
								$cod_tabla_detalle		,
								$_REQUEST				,
								$ord_por				,
								$num_max_registros		,
								$num_pagina				,
								$ind_mostrar_todo		,
								$cod_usuario			,
								$reg_seleccionado	
							);
							

	$num_registros		=	$resultado_cursor['NUM_REGISTROS'];	
	//if($num_registros<$num_max_registros)$num_max_registros = $num_registros;
	if($ind_mostrar_todo == 1)$num_max_registros = $num_registros;

	$tabla_resultado	= 	$columna_tabla_autonoma->f_generar_tabla_datos_cursor(
							$resultado_cursor			,
								"$cod_tabla"				,
								"98%"						,
								"#212457"					,
								"contenido"					,
								$cod_tabla_detalle			,
								$estado_ord					,
								$ord_por					,
								$num_max_registros
							);
	$num_registros		= 	$resultado_cursor['NUM_REGISTROS'];
	$tabla_paginas		= 	$sis_genericos->f_crar_paginador_mysql_con_datos(
							$num_pagina					,
							$num_max_registros			,
							$num_registros				,
							'menu_boton'				,
							'menu_navegacion_paginas'						
							);
}


if($row_js_personalizado['txt_js'])		$js_navegacion = "../../js/".$row_js_personalizado['txt_js'];
else									$js_navegacion = "../../js/ver_default_script_consulta_maestro_detalle.js";
if($row_js_personalizado['txt_js_adicional'])		$js_extra	= "../../js/".$row_js_personalizado['txt_js_adicional'];

// archivo de consulta php adicional
if($row_js_personalizado['txt_consulta_php']){
	$txt_consulta_php = $row_js_personalizado['txt_consulta_php'];

	$ruta_consulta = '../consulta/'.$txt_consulta_php;
	if(is_file($ruta_consulta))include('../consulta/'.$txt_consulta_php);
}



//=== Evalua algun java script especifico para esta tabla >>>
$cursor_procesos_adicionales	= $proceso_adicional_pantalla->f_get_procesos_asociados($cod_tabla,78,NULL,$cod_perfil);

?>