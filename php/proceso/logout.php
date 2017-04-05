<?php 
session_start();
session_destroy();
unset($_SESSION['cod_pk_usuario']);
unset($_SESSION['nom_user']);
//unset($_COOKIE['loginUsuario']);
//setcookie('loginUsuario', null, -1, '/');
$parametros_cookies = session_get_cookie_params(); 
setcookie(session_name(),0,1,$parametros_cookies["path"]);
header('Location: ../../index.php');
exit;
?>