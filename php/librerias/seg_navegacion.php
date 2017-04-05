<?
/*=====2005/05/22=====================================D E C K===>>>>
DESCRIPCION: 	Contiene las consultas necesarias navegar entre paginas
PROPIETARIO:	© D E C K
AUTOR:			Cristian Arellano
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
class seg_navegacion{
	
	/*=====2005/05/22=====================================D E C K===>>>>
	DESCRIPCION: 	Retorna informacion del regitro de flujo de navegacion
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	$cod_navegacion	Codigo asignado a la navegacion que se esta evaluando
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA		AUTOR			MODIFICACION
	2014/10/23	Luis Prieto		Creacion de la funcion
	===========================================================================*/
	function f_get_row($cod_navegacion){
		if(!$cod_navegacion)return false;
		global $db;
		
		$query = "select * from seg_navegacion where cod_navegacion = $cod_navegacion";
		
		$row = $db->consultar_registro($query);
		return $row;
		
	}
	
	/*=====2005/05/22=====================================D E C K===>>>>
	DESCRIPCION: 	funcion que retorna el flujo de navegacion para un codigo  
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	$cod_navegacion	Codigo asignado a la navegacion que se esta evaluando
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function f_ver_navegacion($cod_navegacion){
		if(!$cod_navegacion) return false;
		global $db;
		$query ="
		select 	* 
		from 	seg_navegacion
		where	cod_navegacion = $cod_navegacion";
		$registro = $db->consultar_registro($query);	
		return $registro;
	}
	/*=====2005/05/22=====================================D E C K===>>>>
	DESCRIPCION: 	indica si un perfil tiene permisos para ejecutar una navegacion
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	$cod_navegacion	Codigo asignado a la navegacion que se esta evaluando.
	$cod_perfil		Codigo del perfil que se esta evaluando.
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function f_permiso_navegacion($cod_navegacion,$cod_perfil){
		if(!$cod_navegacion|| !$cod_perfil) return false;
		global $db;
		$query ="
		select 	* 
		from 	seg_perfil_navegacion
		where	cod_navegacion = $cod_navegacion
		and		cod_perfil		in($cod_perfil)";

		$registro = $db->consultar_registro($query);	
		return $registro;
	}
}
?>