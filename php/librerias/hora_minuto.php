<?
/*=====2012/08/08===================================D E C K===>>>>
DESCRIPCION: 	Contiene las hora_minutos contra la tabla hora_minuto
PROPIETARIO:	© D E C K
AUTOR:			Cristian Arellano
===========================================================================*/
class hora_minuto{
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
		select	txt_hora_minuto,
				concat(num_hora,':',txt_minuto,' ',txt_horario) 
		from	hora_minuto
		order by txt_hora_minuto";
		$cursor		=	$db->consultar($query);
		return $cursor;
	}
}
?>