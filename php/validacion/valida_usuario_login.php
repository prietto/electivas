<? 
require('../librerias/seg_usuario.php');
$seg_usuario = new seg_usuario();


$result = $seg_usuario->f_valida_password($cod_usuario_confirm,$txt_password_confirm);

$arr_result = array();

$arr_result['result'] = $result;
$arr_result['cod_navegacion_destino'] = $cod_navegacion_destino;


echo json_encode($arr_result);


?>