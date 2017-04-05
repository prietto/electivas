<?php
/*=====2008/12/13=======================================D E C K===>>>>
DESCRIPCION: 	Contiene diferentes funciones realcionadas la tabla tabla_autonoma
PROPIETARIO:	© D E C K
AUTOR:			Cristian Arellano
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
class seg_perfil{
	
	/*===== 2014/05/06 ========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene informacion de un registro especial
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
   	function f_get_row($cod_perfil_pk){
		global $db;
		
		$query = "select * from seg_perfil where cod_perfil = $cod_perfil_pk";
		
		$row = $db->consultar_registro($query);
		
		return $row;
	}
	
	
	/*===== 2014/05/05 ========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene un registro especifico de la tabla seg_perfil
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
   	function p_get_next_pk($cod_usuario,$row_tabla_autonoma){
		global $db;
		$txt_nombre_tabla		= 	$row_tabla_autonoma['txt_nombre'];
		$txt_nombre_sequencia	= 	$row_tabla_autonoma['txt_nombre_sequencia'];
		$cod_tabla				=	$row_tabla_autonoma['cod_tabla'];
		//=== Obtiene el nombre de la columna pk>>>
		$txt_columna_pk			= 	$row_tabla_autonoma['txt_columna_pk'];
		$query					=	"	select 	txt_nombre 
										from 	columna_tabla_autonoma
										where	ind_pk		= 1
										and		cod_tabla 	= $cod_tabla";
		$row					=	$db->consultar_registro($query);
		$txt_columna_pk			=	'cod_perfil';
		
	

		//=== Obtiene el codigo que tiene reservado temporalmente el usuario (SI ES QUE LO TIENE) >>>
		$query					=	"	select 	$txt_columna_pk 
										from 	$txt_nombre_tabla 
										where 	cod_usuario 	= $cod_usuario 
										and 	ind_bloqueado	= 1 ";

		$row					=	$db->consultar_registro($query);
		$cod_pk					=	$row[0];
		if($cod_pk) 			return $cod_pk;
		//=== Obtiene las columnas que se deben cargar el el registro inicial >>>
		$query					=	"	select 	* 
										from 	columna_tabla_autonoma
										where	(ind_not_null		= 1
										or		txt_default_value is not null
										)
										and		ind_pk				<>1
										and		cod_tabla = $cod_tabla";
		$cursor_columnas		= $db->consultar($query);
		$num_registros 			= $db->num_registros($cursor_columnas);
		
		$query				=	"
		insert 	into $txt_nombre_tabla
				(ind_activo,txt_nombre,fec_registro,cod_usuario,ind_bloqueado)
		values	(1,'',now(),$cod_usuario,1)";
		
		$db->consultar($query);
		$cod_pk	= $GLOBALS['fn_ultimo_registro'];
	
		// actualiza el codigo para el campo pk
		$query2 = "update seg_perfil set cod_perfil_pk = $cod_pk where cod_perfil = $cod_pk";
		$db->consultar($query2);
		
		return $cod_pk;
	}
	
}
	
?>