<?php
include_once ("../librerias/parametro_sistema.php");
include_once ("../librerias/seg_permiso_tabla_autonoma.php");
include_once ("../librerias/sis_genericos.php");

//=== Instancias requeridas >>>
$tabla_autonoma					=	new tabla_autonoma;
$parametro_sistema				= 	new parametro_sistema;
$seg_permiso_tabla_autonoma		= 	new seg_permiso_tabla_autonoma;



//$factura->p_update_vencimiento();	
$cursor_permisos = $seg_permiso_tabla_autonoma->f_get_permisos_modulos($cod_perfil);

$ind_pantalla_menu = TRUE;





?>