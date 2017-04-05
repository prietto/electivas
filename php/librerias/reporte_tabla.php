<?
/*=====2012/08/13=======================================D E C K===>>>>
DESCRIPCION: 	Contiene diferentes funciones realcionadas la tabla reporte_tabla
PROPIETARIO:	© D E C K
AUTOR:			Cristian Arellano
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
class reporte_tabla{
	
	

	/*	======= 2014/12/05 ===================================================>>>
	DESCRIPCION: 		Metodo para validar el codigo de reporte tabla que llega
	AUTOR:				Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$cod_reporte_tabla	
	===========================================================================*/
	function f_valida_reporte_vs_tabla($cod_reporte_tabla,$cod_tabla,$cod_usuario){
		if(!$cod_usuario)return false;
		global $db;

		if($cod_reporte_tabla < 0){
			$query = "select  	cod_reporte_tabla
						from 	reporte_tabla 
						where 	cod_reporte_tabla = $cod_reporte_tabla
						and		cod_tabla = $cod_tabla";
			$row = $db->consultar_registro($query);
			$cod_reporte_tabla = $row['cod_reporte_tabla'];
		}
		
		if(!$cod_reporte_tabla){ // no hay reporte retorna el reporte por defecto
			$cod_reporte_tabla = $this->f_get_reporte_default($cod_reporte_tabla,$cod_tabla,$cod_usuario);
			return $cod_reporte_tabla;
		}else{ // devolvio reporte ahora debe validar los permisos 
		
		
			$query 	="
			select  rt.cod_reporte_tabla
			from    seg_perfil_reporte sr,
					reporte_tabla rt,
					seg_perfil_usuario spu
			where   sr.cod_perfil 			= spu.cod_perfil  
			and     spu.cod_usuario_pk 		= $cod_usuario
			and     rt.cod_tabla 			= $cod_tabla
			and     rt.cod_reporte_tabla 	= sr.cod_reporte_tabla
			and rt.cod_reporte_tabla = $cod_reporte_tabla
			order by rt.txt_nombre	desc";
			
			$row = $db->consultar_registro($query);
			$cod_reporte_tabla = $row['cod_reporte_tabla'];

			return $cod_reporte_tabla;
		}

		
		
			
	
	}

	/*	======= 2014/06/30 ===================================================>>>
	DESCRIPCION: 	Obtiene un registro de default o por un codigo especifico
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$cod_reporte_tabla	
	===========================================================================*/
	function f_get_reporte_default($cod_reporte_tabla, $cod_tabla,$cod_usuario){
		global $db;		
		
		if($cod_reporte_tabla>0) 	$condicion_reporte = "and rt.cod_reporte_tabla = $cod_reporte_tabla";
		else						$condicion_reporte = "and rt.ind_default = 1";

		$query 	="
		select  rt.* 
		from    seg_perfil_reporte sr,
				reporte_tabla rt,
				seg_perfil_usuario spu
		where   sr.cod_perfil 			= spu.cod_perfil  
		and     spu.cod_usuario_pk 		= $cod_usuario
		and     rt.cod_tabla 			= $cod_tabla
		and     rt.cod_reporte_tabla 	= sr.cod_reporte_tabla
		$condicion_reporte
		order by rt.txt_nombre	desc";


		$row		= $db->consultar_registro($query);

		return  $row['cod_reporte_tabla'];
	}	
	
	/*	======================================================================>>>
	DESCRIPCION: 	Obtiene los permisos sobre los reportes a partir del codigo de perfil
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
	function f_get_by_perfil($cod_perfil){
		global $db;		
		$query 	="select 	spr.cod_reporte_tabla
					from 	seg_perfil_reporte spr,
							reporte_tabla rt 
					where 	spr.cod_perfil = $cod_perfil
					and		spr.cod_reporte_tabla = rt.cod_reporte_tabla
					and		rt.ind_activo
					group 	by rt.cod_reporte_tabla";
		$cursor	= 	$db->consultar($query);	
		return $cursor;
	}
	
	
	/*	======================================================================>>>
	DESCRIPCION: 	Obtiene todos los articulos publicados
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
	function f_get_activos_all(){
		global $db;		
		$query 	="
		select 		rt.cod_reporte_tabla	,
					concat(rt.txt_nombre,' - ',ta.txt_nombre) as txt_nombre					  
		FROM		reporte_tabla			rt,
					tabla_autonoma			ta
		where 		ta.cod_tabla = rt.cod_tabla
		and			rt.ind_activo = 1
		group 		by rt.cod_reporte_tabla
		order by 	rt.txt_nombre	";

		$cursor	= 	$db->consultar($query);	
		return $cursor;
	}
	
	/*=====2014/01/10 ========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene un registro a partir un primary key
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
  	function f_get_row($cod_reporte_tabla){
		global $db;

		//===Evalua si coloca un reporte especifico o el reporte por defecto >>>
		//if($cod_reporte_tabla>0) 	$condicion_adicional = "cod_reporte_tabla 	= $cod_reporte_tabla";
		//else					$condicion_adicional = "ind_default 		= 1";
		
		$query ="
		select 		*
		from 		reporte_tabla
		where 		cod_reporte_tabla = $cod_reporte_tabla";
		$row		 = $db->consultar_registro($query);	
		return $row;

	}	
	
	/*	======================================================================>>>
	DESCRIPCION: 	Obtiene un registro de default o por un codigo especifico
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
	function f_get_script_reportes($cod_reporte_tabla, $cod_tabla,$cod_usuario){
		global $db;		
		


		if($cod_reporte_tabla>0) 	$condicion_reporte = "and rt.cod_reporte_tabla = $cod_reporte_tabla";
		else						$condicion_reporte = "and rt.ind_default = 1";
		
		$query 	="
		select 	rt.*  
		from 	seg_perfil_usuario  pu,
				reporte_tabla	rt
		where	pu.cod_usuario	 		=	$cod_usuario
		and		rt.cod_tabla 			=	$cod_tabla
		$condicion_reporte
		order by rt.txt_nombre	desc";

		$row		= $db->consultar_registro($query);
		return  $row['txt_script'];
	}	
	
	
	/*	======================================================================>>>
	DESCRIPCION: 	Obtiene un registro de default o por un codigo especifico
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
	function f_get_script($cod_reporte_tabla, $cod_tabla,$cod_usuario){
		global $db;		

		if($cod_reporte_tabla>0) 	$condicion_reporte = "and rt.cod_reporte_tabla = $cod_reporte_tabla";
		else						$condicion_reporte = "and rt.ind_default = 1";
		
		$query 	="
		select 	rt.*  
		from 	seg_perfil_reporte  pr,
				seg_perfil_usuario  pu,
				reporte_tabla	rt
		where	pu.cod_perfil = pr.cod_perfil
		and		pr.cod_reporte_tabla 	= 	rt.cod_reporte_tabla
		and		pu.cod_usuario_pk	 		=	$cod_usuario
		and		rt.cod_tabla 			=	$cod_tabla
		$condicion_reporte
		order by rt.txt_nombre	desc";

		$row		= $db->consultar_registro($query);
		return  $row['txt_script'];
	}	


	/*	======================================================================>>>
	DESCRIPCION: 	Obtiene todos los articulos publicados
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
	function f_get_activos($cod_tabla,$cod_usuario){
		global $db;		
		$query 	="
		select 		rt.*  
		from 		seg_perfil_reporte  	pr,
					seg_perfil_usuario  	pu,
					reporte_tabla			rt
		where		pu.cod_perfil 			= 	pr.cod_perfil
		and			pr.cod_reporte_tabla 	= 	rt.cod_reporte_tabla
		and			pu.cod_usuario_pk	 		=	$cod_usuario
		and			rt.cod_tabla 			in	($cod_tabla)
		order by 	rt.ind_default desc, 
					rt.txt_nombre	";

		$cursor	= 	$db->consultar($query);	
		return $cursor;
	}	
	
	/*=====2012/08/13========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene todos los registros activos de la tabla reporte_tabla
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function f_get_reportes_tabla($cod_tabla){
		global $db;
		$query ="
		select 		cod_reporte_tabla,
					txt_nombre 
		from 		reporte_tabla
		where		ind_activo 	= 1
		and			cod_tabla 	= $cod_tabla
		order by	txt_nombre";
		$cursor		 = $db->consultar($query);	
		return $cursor;
	}
	/*=====2012/08/13========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene el script para generar el reporte solicitado
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
  	function f_get_consulta( $cod_reporte_tabla, $cod_tabla){
		global $db;

		//===Evalua si coloca un reporte especifico o el reporte por defecto >>>
		if($cod_reporte_tabla>0) 	$condicion_adicional = "cod_reporte_tabla 	= $cod_reporte_tabla";
		else					$condicion_adicional = "ind_default 		= 1";
		
		$query ="
		select 		txt_script
		from 		reporte_tabla
		where		cod_tabla = $cod_tabla
		and			$condicion_adicional";

		$row		 = $db->consultar_registro($query);	
		return $row['txt_script'];

	}	
}
?>