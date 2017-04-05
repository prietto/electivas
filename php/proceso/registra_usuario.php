<? 


$result = $seg_usuario->p_crea_registro($_REQUEST);
if($result == true){
	$arr_result['code_error'] = 0;
	$arr_result['msj_error'] = 'Creado Exitosamente!';

	echo json_encode($arr_result);
	exit;
}


?>