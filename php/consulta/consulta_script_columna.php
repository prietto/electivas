<? 
require('../principal/conecta_db.php');

$db = new conecta_db();
global $db;

$cod_columna_tabla = $_GET['cod_columna_tabla'];
$cod_unidad_negocio = $_GET['cod_unidad_negocio'];

// inicializamos variables
$row = array();
$return_arr = array();
$row_array = array();



if((isset($_GET['term']) && strlen($_GET['term']) > 0) || (isset($_GET['id']) && is_numeric($_GET['id']))){
	
	// consulta la columna tabla autonoma para retornar el script
	$query 			= "select txt_nombre,txt_script_cursor from columna_tabla_autonoma where cod_columna_tabla = $cod_columna_tabla";
	$row_col 		= $db->consultar_registro($query);
	$txt_script 	= $row_col['txt_script_cursor'];
	
	$nom_columna 	= $row_col['txt_nombre'];
	
	if(!$txt_script){
		// no se encontraron resultados
		$row_array['id'] 	= '0';
		$row_array['text'] 	= 'Error en la consulta';
		// metemos en un array la respuesta de la consulta
		array_push($return_arr,$row_array);
	}else{
		if(isset($_GET['term'])){ // si lo que envio fus busqueda con texto
			$filtro = $_GET['term'];
			$condicion = "and t.txt_nombre like '%".$filtro."%' ";
			
		}else if(isset($_GET['id'])){ // si llego fue un id
			$cod_pk 	= $_GET['id'];
			$condicion 	= "and t.".$nom_columna." = ".$cod_pk."";
		}
		
		// === reeemplaza las condiciones en el script
		$txt_script = str_replace('condiciones_script_consulta',$condicion,$txt_script);


		// CONDICION ESPECIAL PARA LAS UNIDADES DE NEGOCIOS PARA EL SISTEMA CARDONA_APP
		if($cod_unidad_negocio){
			$txt_condicion_unidad = "and  	t.cod_unidad_negocio = ".$cod_unidad_negocio;
			//$query = str_replace('$cod_unidad_negocio',$cod_unidad_negocio,$txt_script);
			$query = str_replace('condicion_unidad_negocio',$txt_condicion_unidad,$txt_script);
		}else{
			$query = str_replace('condicion_unidad_negocio','',$txt_script);
		}

		



		$cursor = $db->consultar($query);
		
		$num_registros = $db->num_registros($cursor);
		
		if($num_registros > 0){
			while($row=$db->sacar_registro($cursor)){
				$row_array['id'] = $row[0];
				//$row_array['text'] = utf8_encode($row['txt_nombre']);
				$row_array['text'] = utf8_decode(utf8_encode($row['txt_nombre']));
				// metemos en un array la respuesta de la consulta
				array_push($return_arr,$row_array);
				//$result[] = array("id"=>$row[0],"text"=>$row['txt_nombre']); 
				
			}
		}else{
			// no se encontraron resultados
			$row_array['id'] 	= '0';
			$row_array['text'] 	= 'No se encontraron coincidencias...';
			// metemos en un array la respuesta de la consulta
			array_push($return_arr,$row_array);
			//$result[] = array("id"=>"0","text"=>"No se encontraron coincidencias...");
		}
	
	} // fin else
	
	

}else{
    $row_array['id'] = 0;
    $row_array['text'] = utf8_encode('Escribe tu busqueda...');
    array_push($return_arr,$row_array);
}

$ret = array();
/* este retorna solo un dato necesario para la funcion initselection */
if(isset($_GET['id'])){
    $ret = $row_array;
}else{
    $ret['results'] = $return_arr;
}


// retornamos la informacion en contrada en vector json de javascript
echo json_encode($ret);
	



?>