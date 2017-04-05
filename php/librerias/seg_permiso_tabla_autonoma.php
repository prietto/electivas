<?
/*=====2008/12/16=====================================D E C K===>>>>
DESCRIPCION: 	contiene las consultas necesarias navegar entre tablas autonomas
PROPIETARIO:	© D E C K
AUTOR:			Cristian Arellano
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
class seg_permiso_tabla_autonoma{
	
	/*===== 2014/05/31 =====================================D E C K===>>>>
	DESCRIPCION: 	Retorna codigos de operaciones en un vector
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	$var_request	variables que llegan por post desde el form
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function f_get_activo(){
		global $db;
		
		$query = "select 	*							
					from 	seg_operacion_tabla 
					where ind_activo = 1";
					
				
		
		$cursor = $db->consultar($query);		
		

		while($row=$db->sacar_registro($cursor)){
			


			$txt_operacion		= $row['txt_alias'];			
			$cod_operacion 		= $row['cod_operacion'];
			
			
			$arr_permiso[$cod_operacion][0] = $cod_operacion;
			$arr_permiso[$cod_operacion][1] = $txt_operacion;
			
		}


		
		return $arr_permiso;
			
	}

	/*===== 2014/05/31 =====================================D E C K===>>>>
	DESCRIPCION: 	Retorna codigos de operaciones en un vector
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	$var_request	variables que llegan por post desde el form
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function f_get_permisos_vector($var_request,$cod_perfil_pk){
		global $db;
		
		$query = "select 	spta.* ,
							sot.txt_alias as txt_operacion
					from 	seg_permiso_tabla_autonoma spta,
							seg_operacion_tabla sot
					where 	cod_perfil = $cod_perfil_pk
					and		spta.cod_operacion = sot.cod_operacion";
		
		
		$cursor = $db->consultar($query);		
		

		while($row=$db->sacar_registro($cursor)){
			
			
			$cod_modulo 		= $row['cod_tabla'];
			$txt_operacion		= $row['txt_operacion'];			
			$cod_operacion 		= $row['cod_operacion'];
			
			
			$arr_permiso[$cod_modulo][$cod_operacion][0] = $cod_operacion;
			$arr_permiso[$cod_modulo][$cod_operacion][1] = $txt_operacion;
			
		}

		
		return $arr_permiso;
			
	}
	
	/*===== 2014/05/06 =====================================D E C K===>>>>
	DESCRIPCION: 	Retorna cursor de tablas y permisos sobre la tabla
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	$var_request	variables que llegan por post desde el form
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function f_get_permisos_modulos($cod_perfil_pk){
		global $db;
		
		$query = "select * from seg_permiso_tabla_autonoma where cod_perfil = $cod_perfil_pk group by cod_tabla";

		$cursor = $db->consultar($query);		
		return $cursor;
			
	}
	
	/*===== 2014/05/06 =====================================D E C K===>>>>
	DESCRIPCION: 	Retorna cursor de tablas y permisos sobre la tabla
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	$var_request	variables que llegan por post desde el form
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function f_get_permisos($var_request,$cod_perfil_pk){
		global $db;
		
		$query = "select spta.* 
					from 	seg_permiso_tabla_autonoma spta ,
							tabla_autonoma ta
					where 	spta.cod_perfil = $cod_perfil_pk
					and		spta.cod_tabla = ta.cod_tabla
					and 	ta.cod_estado_tabla = 2					
					group by spta.cod_tabla,spta.cod_operacion				";
	
		$cursor = $db->consultar($query);		
		return $cursor;
			
	}
	
	
	
	/*===== 2014/05/06 =====================================D E C K===>>>>
	DESCRIPCION: 	Crea el registro para dar permiso al perfil creado 
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	$var_request	variables que llegan por post desde el form
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function p_modifica_registro($var_request){
		global $db;
		
		
		$arr_tabla	 	= $var_request['cod_modulo'];
		$arr_permisos	= $var_request['cod_operacion_tabla'];
		$cod_perfil_pk	= $var_request['cod_perfil_pk'];
		$cod_usuario	= $var_request['cod_usuario'];
		
		// primero se eliminan los registros y se ingresa lo seleccionado
		$query	=	"delete from seg_permiso_tabla_autonoma where cod_perfil = $cod_perfil_pk";
		$db->consultar($query);
		

		
		if($arr_tabla[0]){
			
			// elimina para ingresar nuevamente
			$query = "delete from 	seg_perfil_navegacion 	
							where 	cod_perfil = $cod_perfil_pk 
							and 	cod_navegacion in (39,78,38,43,44,45,36,37,1013,1014)";
			$db->consultar($query);
			
			if($cod_perfil_pk == 1)$insert = ",($cod_perfil_pk,1045)";
		
			// da permiso para los flujos de navegacion basicos (autonomos)	
			$query = "insert into 	seg_perfil_navegacion 
									(cod_perfil,cod_navegacion) 
									VALUES 
									($cod_perfil_pk,39),
									($cod_perfil_pk,78),
									($cod_perfil_pk,38),
									($cod_perfil_pk,43),
									($cod_perfil_pk,44),
									($cod_perfil_pk,45),
									($cod_perfil_pk,36),
									($cod_perfil_pk,37),
									($cod_perfil_pk,1013),
									($cod_perfil_pk,1014)
									$insert";
									
			$db->consultar($query);	
			
		}else{
			$query = "delete 	from 	seg_perfil_navegacion 	
						where 			cod_perfil = $cod_perfil_pk";
			$db->consultar($query);
		}
		
		for($i=0;$i<count($arr_permisos);$i++){

			$cod_tabla		= $arr_tabla[$i];
			$arr_tabla_permiso	= $arr_permisos[$cod_tabla];
			
			for($k=0;$k<count($arr_tabla_permiso);$k++){
				$cod_permiso = $arr_permisos[$cod_tabla][$k];
				if($cod_tabla != -1 && $cod_permiso != -1){
					$query="	insert into seg_permiso_tabla_autonoma
								(
								cod_tabla		,
								cod_operacion	,
								cod_perfil		,
								fec_registro	,
								cod_usuario		
								)values(
								$cod_tabla		,
								$cod_permiso	,
								$cod_perfil_pk	,
								now()			,
								$cod_usuario	
								);";

					

					$db->consultar($query);
				
				}
			
			}
			
		}
		
		
	
	
	}
	
	
	/*=====2008/12/16=====================================D E C K===>>>>
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
	function f_get_permiso_insert_tabla($cod_tabla,$cod_perfil){
		if(!$cod_tabla || !$cod_perfil) return false;
		global $db;
		$query ="
		select 	* 
		from 	seg_permiso_tabla_autonoma
		where	cod_tabla 		= 	$cod_tabla
		and		cod_operacion	=	1
		and		cod_perfil		in($cod_perfil)";
		$registro = $db->consultar_registro($query);	
		if($registro[0]) return true;
		else			 return false;
	}
	/*=====2008/12/16=====================================D E C K===>>>>
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
	function f_get_permiso_select_tabla($cod_tabla,$cod_perfil){
		if(!$cod_tabla || !$cod_perfil) return false;
		global $db;
		$query ="
		select 	* 
		from 	seg_permiso_tabla_autonoma
		where	cod_tabla 		= 	$cod_tabla
		and		cod_operacion	=	2
		and		cod_perfil		in(	$cod_perfil)";
		$registro = $db->consultar_registro($query);	
		if($registro[0]) return true;
		else			 return false;
	}
	/*=====2008/12/16=====================================D E C K===>>>>
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
	function f_get_permiso_update_tabla($cod_tabla,$cod_perfil){
		if(!$cod_tabla || !$cod_perfil) return false;
		global $db;
		$query ="
		select 	* 
		from 	seg_permiso_tabla_autonoma
		where	cod_tabla 		= 	$cod_tabla
		and		cod_operacion	=	3
		and		cod_perfil		in($cod_perfil)";
		$registro = $db->consultar_registro($query);	
		if($registro[0]) return true;
		else			 return false;
	}
	/*=====2008/12/16=====================================D E C K===>>>>
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
	function f_get_permiso_delete_tabla($cod_tabla,$cod_perfil){
		if(!$cod_tabla || !$cod_perfil) return false;
		global $db;
		$query ="
		select 	* 
		from 	seg_permiso_tabla_autonoma
		where	cod_tabla 		= 	$cod_tabla
		and		cod_operacion	=	4
		and		cod_perfil		in($cod_perfil)";
		$registro = $db->consultar_registro($query);	
		if($registro[0]) return true;
		else			 return false;
	}
}
?>