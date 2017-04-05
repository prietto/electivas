<?php
/*=====2012/08/13=======================================D E C K===>>>>
DESCRIPCION: 	Contiene diferentes funciones realcionadas la tabla seg_perfil_reporte
PROPIETARIO:	© D E C K
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
class seg_perfil_reporte{
	
	/*	===== 2014/05/07 =============================================================>>>
	DESCRIPCION: 	Guarda los permisos relacionados con los reportes del sistema
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
	function p_modificar_registro($var_request){
		global $db;
	

		$arr_cod_reporte 	= $var_request['cod_reporte'];
		$cod_perfil			= $var_request['cod_perfil_pk'];
		
		$num_registros 		= count($arr_cod_reporte);
		
		$arr_reporte_perfil = array();
		for($i=0;$i<$num_registros;$i++){
			
			$cod_reporte_pk = $arr_cod_reporte[$i];
			if($cod_reporte_pk != -1){
				$cadena			= "(".$cod_reporte_pk.",".$cod_perfil.")";
			
				array_push($arr_reporte_perfil,$cadena);		
			}
		
		}	
		
		$cadena_value = implode(',',$arr_reporte_perfil);
		
		// se debe borrar para ingresar solo lo seleccionado
		$query = "delete from seg_perfil_reporte where cod_perfil = $cod_perfil";
		$db->consultar($query);
		
		$query = "
			insert into seg_perfil_reporte (
			   cod_reporte_tabla
			  ,cod_perfil
			) VALUES 
			$cadena_value ";
		$db->consultar($query);
	
	}

}
	
	
?>