<?php
/*=====2005/05/23=======================================D E C K===>>>>
DESCRIPCION: 	Contiene funciones contra la tabla parametro_x_usuario
PROPIETARIO:	© Luis Prieto
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
class parametro_x_usuario{
	

	/*==== 2014/07/15 ======================================================>>>>
	DESCRIPCION: 	Modifica el parametro de mantener sesion iniciada
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function p_modificar_parametro($cod_usuario,$cod_parametro,$val_parametro){
		if(!$cod_usuario)return false;
		global $db;
		
		if(!$val_parametro)$val_parametro = 0;
		else $val_parametro = 1;

		// primero consulta si existe
		$query = "select count(*) as num_registros	
							from 	parametro_x_usuario 
							where 	cod_usuario = $cod_usuario
							and		cod_parametro = $cod_parametro";
		$row = $db->consultar_registro($query);
		$num_registros = $row['num_registros'];
		
		// si existe algun dato lo actualiza
		if($num_registros > 0){
			$query = "update parametro_x_usuario 
						set val_parametro = $val_parametro 	
						where cod_usuario = $cod_usuario	 
						and cod_parametro = $cod_parametro";

			$db->consultar($query);		
		}else{
			$query="insert into parametro_x_usuario 
					(cod_usuario,cod_parametro,val_parametro)
					VALUES
					($cod_usuario,$cod_parametro,$val_parametro)";
			$db->consultar($query);		
		}
	
		// primero consulta si existe
		$query = "select *
					from 	parametro_x_usuario 
					where 	cod_usuario = $cod_usuario
					and		cod_parametro = $cod_parametro";
		$row = $db->consultar_registro($query);
		$val_parametro = $row['val_parametro'];

		return $val_parametro;


	}


}

?>