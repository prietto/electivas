<?php
/*===== 2014/05/07 ===================================D E C K===>>>>
DESCRIPCION: 	Contiene las consultas contra la tabla seg_perfil_proceso_adicional
PROPIETARIO:	© D E C K
AUTOR:			Luis prieto
===========================================================================*/
class seg_perfil_proceso_adicional{
	/*===== 2014/05/07 ===================================D E C K===>>>>
	DESCRIPCION: 	Ingresa los permisos para los diferentes procesos adicionales en el sitema
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO					DESCRIPCION 
	===========================================================================*/
	function p_modificar_registro($var_request){
		global $db;
		
		//$proceso_navegacion 	= new proceso_navegacion();
		
		$arr_procesos 	= $var_request['cod_procesos_adicionales'];
		$cod_perfil 	= $var_request['cod_perfil_pk'];
		
		// PRIMERO SE DA PERMISO SOBRE LOS PROCESOS 
		
		for($i=0;$i<count($arr_procesos);$i++){

			$cod_proceso_pk = $arr_procesos[$i];

			if($cod_proceso_pk != -1){
				// SE DEBE SABER EL CODIGO DE LA TABLA PARA SACAR TODOS LOS CODIGOS DE LOS PROCESOS
				$query = "select cod_tabla, txt_js from proceso_adicional_pantalla where cod_proceso = $cod_proceso_pk";
				
				
				$row = $db->consultar_registro($query);
				
				$txt_js		= $row['txt_js'];
				$cod_tabla 	= $row['cod_tabla'];
				
				// se consulta los codigos de procesos relacionados a la tabla
				$query = "select GROUP_CONCAT(concat(cod_proceso)) as codigos, 
							count(*) as num_registros 
							from proceso_adicional_pantalla 
							where 	cod_tabla 	= $cod_tabla
							and		txt_js		= '$txt_js'    ";
				$row = $db->consultar_registro($query);
				
				$cod_procesos 	= $row['codigos'];	
				$num_registros	= $row['num_registros'];	
				
	
				for($k=0;$k<$num_registros;$k++){						
	
					$arr_cod_procesos 		= explode(',',$cod_procesos);			
					$cod_proceso_adicional	= $arr_cod_procesos[$k];
					
					
					if(($value != NULL || $i == 0)&& $i < (count($arr_procesos) + 1))$coma = ',';
					else  $coma		= "";
					
					
					$value				.= "(".$cod_proceso_adicional.",".$cod_perfil.")".$coma;
					$cadena_procesos	.= $cod_proceso_adicional."".$coma;
				}
				
			
			}
			
		
		}

		$value 				= substr($value,0 ,strlen($value) - 1);
		$cadena_procesos 	= substr($cadena_procesos,0 ,strlen($cadena_procesos) - 1);

		
		
		// eliminar primero lo registros para volver a ingresarlos
		$query = "delete from seg_perfil_proceso_adicional where cod_perfil = $cod_perfil";	
		$db->consultar($query);
			
		// teniendo los codigos se la de permiso sobre los procesos
		$query = "
			insert into seg_perfil_proceso_adicional (
			   cod_proceso
			  ,cod_perfil
			) VALUES 
			$value
			";
		$db->consultar($query);
		
		
		// se da permisos a los flujos de navegacion asociados a los procesos
		/*$arr_navegacion = $proceso_navegacion->f_get_by_codigos($cadena_procesos,$cod_perfil);
		$num_navegacion = count($arr_navegacion);
		
		$arr_cadena = array();
		for($l=0;$l<$num_navegacion;$l++){
			
			$cod_navegacion 	= $arr_navegacion[$l];
			$cadena_value		= "(".$cod_navegacion.",".$cod_perfil.")";
			array_push($arr_cadena,$cadena_value);					
		}
		
		$cadena_value = implode(',',$arr_cadena);

		$query = "
			insert into seg_perfil_navegacion (
			   cod_navegacion
			  ,cod_perfil
			) VALUES 
				$cadena_value
			";
		
		$db->consultar($query);
			*/
		
	
	}

}