<? 
include('../librerias/seg_usuario.php');
$seg_usuario = new seg_usuario();

$row = $seg_usuario->f_valida_existencia($num_identificacion_user,$txt_pass_user);

$arr_result = array();

if(count($row)>0){
	$arr_result['code_error'] = 1;
	$arr_result['msj_error'] = 'Ya existe un usuario registrado con los datos ingresados';

	echo json_encode($arr_result);
	exit;
}


?>