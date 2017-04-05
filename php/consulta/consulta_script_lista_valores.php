<? 

require('../librerias/columna_tabla_autonoma.php');
$columna_tabla_autonoma = new columna_tabla_autonoma();


//$row_info_columna = $columna_tabla_autonoma->f_get_row($cod_columna_tabla);
//$txt_nom_campo = $row_info_columna['txt_nombre'];

$cursor = $columna_tabla_autonoma->f_get_datos_ajax($cod_columna_tabla,$val_campo);
$num_registros = $db->num_registros($cursor);

$row_columna_tabla = $columna_tabla_autonoma->f_get_row($cod_columna_tabla);
$id_obj = $row_columna_tabla['txt_nombre'];

if($val_campo == NULL || $val_campo == ''){
	
	return false;
	exit();
}




?>