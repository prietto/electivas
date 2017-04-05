<?
/*=====2014-01-25===================================D E C K===>>>>
DESCRIPCION: 	Contiene las noticias contra la tabla booleano
PROPIETARIO:	© D E C K
AUTOR:			Luis Prieto
===========================================================================*/
class booleano{
	/*=====2014/01/25========================================D E C K===>>>>
	DESCRIPCION: 	obtiene todos los registros de la tabla
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
	function f_get_all(){
		global  $db;
		
		$query="select cod_booleano, txt_nombre from booleano";
		$cursor = $db->consultar($query);
		return $cursor;
	
	
	}


}