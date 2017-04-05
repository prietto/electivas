<?
//=== Instancias de las librerias creadas en la validacion >>>
$tabla_autonoma 		= new tabla_autonoma;
$columna_tabla_autonoma = new columna_tabla_autonoma;
$sis_genericos			= new sis_genericos;
$obj_listbox			= new obj_listbox();

$num_max_registros 		=$_REQUEST['num_max_registros'];
$cod_funcion 			=$_REQUEST['cod_funcion'];
$txt_cod_funcion 		=$_REQUEST['txt_cod_funcion'];
$cod_comprador 			=$_REQUEST['cod_comprador'];
$txt_cod_comprador 		=$_REQUEST['txt_cod_comprador'];
$cod_ubicacion 			=$_REQUEST['cod_ubicacion'];
$txt_cod_ubicacion 		=$_REQUEST['txt_cod_ubicacion'];
$cod_estado_pedido 		=$_REQUEST['cod_estado_pedido'];
$cod_pedido 			=$_REQUEST['cod_pedido'];
$fec_registro_inicial 	=$_REQUEST['fec_registro_inicial'];
$fec_registro_final 	=$_REQUEST['fec_registro_final'];
$ind_imprimir_reporte 	=$_REQUEST['ind_imprimir_reporte'];
$cod_pk 				=$_REQUEST['cod_pk'];
$ind_buscar 			=$_REQUEST['ind_buscar'];
$num_pagina 			=$_REQUEST['num_pagina'];
$ord_por 				=$_REQUEST['ord_por'];
$txt_nombre_columna_iframe =$_REQUEST['txt_nombre_columna_iframe'];
$cod_ventana_emergente 	=$_REQUEST['cod_ventana_emergente'];
$cod_usuario 			=$_REQUEST['cod_usuario'];
$cod_navegacion 		=$_REQUEST['cod_navegacion'];
$ind_limpiar_variables 	=$_REQUEST['ind_limpiar_variables'];
$cod_tabla 				=$_REQUEST['cod_tabla'];
$cod_tabla_detalle 		=$_REQUEST['cod_tabla_detalle'];


//=== Obtiene informacion detallada de la tabla >>>
$row_tabla_autonoma		= $tabla_autonoma->f_get_row($cod_tabla);
$alias_tabla_autonoma	= strtoupper($row_tabla_autonoma['txt_alias']);
$alias_tabla_autonoma	= str_replace("_"," ",$alias_tabla_autonoma);

//=== Cantidad maxima por pantallaso >>>
if(!$num_max_registros) $num_max_registros=20;

//=== CONSULTA LA INFORMACIÓN>>>
if($ind_buscar){
	$resultado_cursor	= 	$columna_tabla_autonoma->f_consultar_tabla_autonoma(
							$cod_tabla			,
							$_POST				,
							$ord_por			,
							$num_max_registros	,
							$num_pagina			
							);
	$tabla_resultado	= 	$columna_tabla_autonoma->f_generar_tabla_datos_cursor(
							$resultado_cursor		,
							$cod_tabla				,
							700						,
							"#000000"				,
							"combo"
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