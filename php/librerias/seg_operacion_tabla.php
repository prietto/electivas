<?php
/*=====2014/05/05 =======================================D E C K===>>>>
DESCRIPCION: 	Contiene diferentes funciones realcionadas la tabla seg_operacion_tabla
PROPIETARIO:	© D E C K
AUTOR:			Luis prieto
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
class seg_operacion_tabla{
	
	
	/*===== 2014/05/05 ========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene todos los registros activos de la tabla 
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function f_get_all(){
		global $db;
		
		$query = "select cod_operacion,txt_alias as txt_nombre from seg_operacion_tabla ";
		
		$cursor = $db->consultar($query);
		
		return $cursor;
			
	
	}
}

?>