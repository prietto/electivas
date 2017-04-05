<?
//=== Instancias de las librerias creadas en la validacion >>>
$tabla_autonoma 		= new tabla_autonoma;
$columna_tabla_autonoma = new columna_tabla_autonoma;
$sis_genericos			= new sis_genericos;
$obj_listbox			= new obj_listbox();
$reporte_tabla			= new reporte_tabla();



// limpia la varible de ordenamiento en caso de ser necesario
if($ind_limpiar_ord){$ord_por = NULL;}

//=== Valida si puede mostrar el boton de crear nuevo registro>>>
$ind_tiene_permiso_insert	= 	$seg_permiso_tabla_autonoma->f_get_permiso_insert_tabla($cod_ventana_emergente,$cod_perfil);

//=== Obtiene informacion detallada de la tabla >>>
$row_tabla_autonoma		= $tabla_autonoma->f_get_row($cod_ventana_emergente);

$row_columna_tabla_pk	= $tabla_autonoma->f_get_col_pk($cod_ventana_emergente);
$txt_col_pk				= $row_columna_tabla_pk['txt_nombre'];

$ind_registro = FALSE;
//=== Obtiene los imputs de la consulta >>>

$row_imputs				=$columna_tabla_autonoma->f_get_imput_filtro($cod_ventana_emergente,$ind_registro);

//=== Cantidad maxima por pantallaso >>>
if(!$num_max_registros) $num_max_registros=20;

if(!$ind_buscar) $ind_limpiar_variables=true;
//=== Evalua si debe limpiar las variables >>>
if($ind_limpiar_variables){
	$_REQUEST	= $columna_tabla_autonoma->f_limpiar_variables_post($row_tabla_autonoma, $_REQUEST,$ind_conservar_pk);
}

// valida el reporte que llega por si llega desde otra pantalla o otra tabla
// si el reporte no pertenece a la tabla retorna el reporte por defecto (si tiene permisos)
$cod_reporte_tabla = $reporte_tabla->f_valida_reporte_vs_tabla($cod_reporte_tabla,$cod_ventana_emergente,$cod_usuario);
$_REQUEST['cod_reporte_tabla'] = $cod_reporte_tabla;

//=== Obtiene los valores asignados en los combos >>>
$row_imputs	=$columna_tabla_autonoma->f_remplazar_valor_imput_filtro(
												$row_tabla_autonoma		,
												$row_imputs				, 
												$_REQUEST				,
												$num_max_registros
											); 
	
$num_columnas			=count($row_imputs);
$alias_tabla_autonoma	= strtoupper($row_tabla_autonoma['txt_alias']);
$alias_tabla_autonoma	= str_replace("_"," ",$alias_tabla_autonoma);

$ind_buscar = 1;	
//=== CONSULTA LA INFORMACIÓN>>>
if($ind_buscar){
	$resultado_cursor	= 	$columna_tabla_autonoma->f_consultar_tabla_autonoma(
							$cod_ventana_emergente	,
							$_REQUEST				,
							$ord_por				,
							$num_max_registros		,
							$num_pagina			
							);
							
	$tabla_resultado	= 	$columna_tabla_autonoma->f_generar_tabla_ventana_emergente(
							$resultado_cursor		,
							$cod_ventana_emergente				,
							600					,
							"#212457"				,
							"contenido"
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
?>