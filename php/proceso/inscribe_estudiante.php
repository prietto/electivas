<? 
require('../librerias/electiva.php');
$electiva = new electiva();
$electiva->cod_electiva = $reg_seleccionado[0];
$electiva->cod_usuario = $cod_usuario;


$result = $electiva->p_genera_inscripcion();

echo $result;
exit;




?>