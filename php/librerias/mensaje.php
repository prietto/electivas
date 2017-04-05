<?
/*=====2005/05/23=============================================Global W===>>>>
DESCRIPCION: 	Contiene las consultas necesarias mostrar los mensajes del sistema
PROPIETARIO:	© Global W
AUTOR:			Cristian Arellano
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
class mensaje{
	/*=====2005/05/23=============================================Global W===>>>>
	DESCRIPCION: 	funcion que retorna en un cursor todos los mensajes solicitados
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	$arr_mensajes	vector con los codigos de los mensajes que se deben mostrar
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function f_get_mensajes($arr_mensajes){
		if(!$arr_mensajes) return false;
		global $db;
		$cod_mensajes = implode(",",$arr_mensajes);
		$query ="
		select 	*
		from 	mensaje
		where	cod_mensaje in($cod_mensajes)";
		$query = $db->consultar($query);	
		return $query;
	}
}
?>