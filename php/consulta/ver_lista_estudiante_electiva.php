<? 
require('../librerias/electiva.php');
require('../librerias/sis_genericos.php');
$sis_genericos = new sis_genericos();
$electiva = new electiva();

$electiva->cod_electiva = $reg_seleccionado[0];
$electiva->cod_usuario = $cod_usuario;

$cursor_estudiantes = $electiva->f_get_cursor_estudiante();
$num_estudiantes = $db->num_registros($cursor_estudiantes);


// ==== INFORMACION DE LA ELECTIVA ==== >>>
$row_electiva = $electiva->f_get_row();

?>