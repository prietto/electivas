<?php 
session_start();
$_SESSION['usuario'] = array();
session_destroy();
header('Location: ../plantilla/ver_validar_usuario.php');
?>