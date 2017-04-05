<?php 
/*require_once('../librerias/parametro_sistema.php');
require_once('../librerias/estado_factura.php');
require_once('../librerias/estado_pedido.php');
require_once('../librerias/seg_permiso_tabla_autonoma.php');

$parametro_sistema 				= new parametro_sistema(); 
$estado_factura					= new estado_factura();
$estado_pedido					= new estado_pedido();
$seg_permiso_tabla_autonoma 	= new seg_permiso_tabla_autonoma();


//retornar cusror con los registros de la tabla parametros y que sean visibles para el usuario
$cursor_parametros = $parametro_sistema->f_get_visibles();

// retorna todos los registros activos de la tabla estado_factura
$cursor_estado_factura = $estado_factura->f_get_all();


// RETORNA TODOS LOS REGISTROS ACTIVOS DE LA TABLA ESTADO PEDIDO
$cursor_estado_pedido	= $estado_pedido->f_get_all();*/



//=== Valida si puede mostrar el boton de guardar la modificacion de un registro>>>
$ind_mostrar_boton_guardar		= false;


$ind_mostrar_boton_guardar	= 	$seg_permiso_tabla_autonoma->f_get_permiso_update_tabla($cod_tabla,$cod_perfil);

//=== Valida debe mostrar el boton de eliminar un registro>>>
$ind_mostrar_boton_eliminar = 	$seg_permiso_tabla_autonoma->f_get_permiso_delete_tabla($cod_tabla,$cod_perfil);




?>