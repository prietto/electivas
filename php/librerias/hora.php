<?
/*=====2012/08/08===================================D E C K===>>>>
DESCRIPCION: 	Contiene las horas contra la tabla hora
PROPIETARIO:	© D E C K
AUTOR:			Cristian Arellano
===========================================================================*/
class hora{
	/*=====2012/08/15========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene todos los registros en un cursor
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
   	function f_get_all(){
		global $db;
		
		//=== Quita la asignacion de usuario para evitar problemas con un codigo que se quede eternamente sin usar >>>
		$query	=	"	
		select	*
		from	hora";
		$cursor		=	$db->consultar($query);
		return $cursor;
	}
}
?>