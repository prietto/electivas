<?
/*=====2008/11/27====================================D E C K===>>>>
AUTOR: 		Cristian Arellano
DESCRIPCION:Proceso para buscar clientees
==========================================================================>>>*/
include ("../librerias/columna_tabla_autonoma.php");
$columna_tabla_autonoma = new columna_tabla_autonoma;
$cod_pk	 							=	$_REQUEST['cod_pk'];
$ind_new_row	 					=	$_REQUEST['ind_new_row'];
$ind_guardar_datos_tabla_autonoma	=	$_REQUEST['ind_guardar_datos_tabla_autonoma'];
$nom_columna_con_foto	 			=	$_REQUEST['nom_columna_con_foto'];
$txt_nombre_columna_iframe 	 		=	$_REQUEST['txt_nombre_columna_iframe']; 
$cod_ventana_emergente	 			=	$_REQUEST['cod_ventana_emergente'];
$cod_usuario	 					=	$_REQUEST['cod_usuario'];
$cod_navegacion	 					=	$_REQUEST['cod_navegacion'];
$ind_limpiar_variables	 			=	$_REQUEST['ind_limpiar_variables'];
$cod_tabla	 						=	$_REQUEST['cod_tabla'];
$cod_tabla_detalle	 				=	$_REQUEST['cod_tabla_detalle'];



$cod_tabla					= 	$_REQUEST['cod_tabla'];
$txt_nombre_columna_iframe 	= 	str_replace("[]","",$txt_nombre_columna_iframe);
if(!$val_campo)					$val_campo 			= $_REQUEST[$txt_nombre_columna_iframe];
if(!$cod_tabla_iframe)			$cod_tabla_iframe	= $cod_tabla;

$row_encontrado				=	$columna_tabla_autonoma->f_get_datos_iframe($txt_nombre_columna_iframe,$cod_tabla_iframe,$val_campo);

//=== Envia los datos encntrados en la consulta, evitando enviar datos duplicados >>>^
$array_retorno			=	array();
$cantidad_encontrada	=	count($row_encontrado);
$cantidad_encontrada	=	$cantidad_encontrada/2;
for($i=0;$i<$cantidad_encontrada; $i++){
	$array_retorno[$i]	=	$row_encontrado[$i];
}
$array_retorno			= implode("','",$array_retorno);
$array_retorno			= "'$array_retorno'";
//=== Quita saltos de linea>>>
$array_retorno			= str_replace( "\n","",$array_retorno);
$array_retorno			= str_replace( "\r","",$array_retorno);
echo "<script> parent.cargar_reg_emergente($array_retorno);</script>";
?>