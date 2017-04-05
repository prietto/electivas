<?
/*=====2008/12/13=======================================D E C K===>>>>
DESCRIPCION: 	Contiene diferentes funciones realcionadas la tabla tabla_autonoma_personalizado
PROPIETARIO:	© D E C K
AUTOR:			Cristian Arellano
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
class tabla_autonoma_personalizado{
	/*=====2009/01/11==================================D E C K===>>>>
	DESCRIPCION: 	Obtiene todos los registros activos de la tabla tabla_autonoma_personalizado
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function f_get_row($cod_tabla,$cod_navegacion){
		global $db;
		$query ="
		select 		* 
		from 		tabla_autonoma_personalizado
		where		cod_tabla		= $cod_tabla
		and			cod_navegacion	= $cod_navegacion";
		$row		 = $db->consultar_registro($query);	

		return $row;

	}
}
?>