<? 
include('../librerias/electiva.php');

$electiva = new electiva();
$electiva->cod_electiva = $reg_seleccionado[0]; // electiva seleccionada en la pantalla
$electiva->cod_usuario = $cod_usuario;

$result = $electiva->f_valida_inscripcion();
echo $result;
exit;


?>