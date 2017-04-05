<?
/*=====2009/01/16====================================D E C K===>>>>
DESCRIPCION: 	Contiene diferentes funciones realcionadas la tabla proceso_adicional_pantalla
PROPIETARIO:	© D E C K
AUTOR:			Cristian Arellano
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
class proceso_adicional_pantalla{
	
	
	
	/*===== 2014/05/06 ========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene los accesos a los procesos por perfil
	AUTOR:			Luis prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
  	function f_get_procesos_perfil($cod_perfil= NULL){
		global $db;
		$query ="
		select 		MAX(ppa.cod_proceso) as cod_proceso
		from 		proceso_adicional_pantalla 		pap,
					seg_perfil_proceso_adicional 	ppa
		where		ppa.cod_proceso = pap.cod_proceso
		and			ppa.cod_perfil 		= $cod_perfil
		and			pap.ind_activo		= 1
		group		by pap.txt_nombre
		order by	pap.txt_js";

		$cursor		 = $db->consultar($query);	
		return $cursor;
	}

	
	/*===== 2014/05/07 ========================================D E C K===>>>>
	DESCRIPCION: 	Retorna cursor con registros activos en la db
	AUTOR:			Luis prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
  	function f_get_proceso_activo(){
		global $db;
		
		$query = "select 	MAX(cod_proceso), 
							concat(pap.txt_nombre,' - ',ta.txt_alias) as txt_nombre 
					from 	proceso_adicional_pantalla pap,
							tabla_autonoma ta
					where 	pap.ind_activo = 1 
					and		pap.cod_tabla = ta.cod_tabla
					group 	by pap.txt_nombre
					order 	by pap.txt_js ";

		$cursor = $db->consultar($query);
		return $cursor;
		
		
	}
	
	
	
	/*=====2009/01/16========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene los procesos de una tabla y un codigo de navegacion
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================
  	function f_get_procesos_asociados($cod_tabla, $cod_navegacion){
		global $db;
		$query ="
		select 		* 
		from 		proceso_adicional_pantalla
		where		cod_tabla 		= $cod_tabla
		and			cod_navegacion	= $cod_navegacion
		and			ind_activo		= 1
		order by	txt_nombre";
		$cursor		 = $db->consultar($query);	
		return $cursor;
	}*/

	/*=====2009/01/16========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene los procesos de una tabla y un codigo de navegacion
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	$por_registro	indica si es un proceso por registro
	===========================================================================*/
  	function f_get_procesos_asociados($cod_tabla, $cod_navegacion, $por_registro = NULL, $cod_perfil= NULL){

		if($por_registro===NULL)	$condicion_adicional = NULL;
		else						$condicion_adicional = " and pap.por_registro = $por_registro";
		
		
		
		global $db;
		$query ="
		select 		pap.* 
		from 		proceso_adicional_pantalla 		pap,
					seg_perfil_proceso_adicional 	ppa
		where		ppa.cod_proceso = pap.cod_proceso
		and			ppa.cod_perfil 		= $cod_perfil
		and			pap.cod_navegacion	= $cod_navegacion
		and			pap.ind_activo		= 1
		and			pap.cod_tabla		= $cod_tabla
		$condicion_adicional
		order by	txt_nombre";


		$cursor		 = $db->consultar($query);	
		return $cursor;
	}

	
}
?>