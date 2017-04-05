<?
/*=====2008/12/13=======================================D E C K===>>>>
DESCRIPCION: 	Contiene diferentes funciones realcionadas la tabla tabla_autonoma
PROPIETARIO:	© D E C K
AUTOR:			Cristian Arellano
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
class tabla_autonoma{
	
	/*===== 2014/12/05 ===========================================>>>>
	DESCRIPCION: 	Retornar cursor con las tablas por su tipo (primarias, secundarias)
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA			AUTOR			MODIFICACION
	2014/12/05		Luis prieto		Creacion de la funcion
	===========================================================================*/
  	function f_get_by_tipo_tabla($cod_tipo_tabla){
		if(!$cod_tipo_tabla)return false;
		global $db;
		
		$query = "select * from tabla_autonoma where cod_tipo_tabla_autonoma = $cod_tipo_tabla";
		$cursor = $db->consultar($query);
		
		return $cursor;
		
	
	}
	
	
	/*===== 2014/11/11 ===========================================>>>>
	DESCRIPCION: 	Obtiene informacion de un registro a partir de un codigo de tabla y su codigo pk
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA			AUTOR			MODIFICACION
	2014/11/11		Luis prieto		Creacion de la funcion
	===========================================================================*/
  	function f_get_row_autonomo($cod_tabla,$cod_pk){
		if(!$cod_pk || !$cod_tabla)return false;
		global $db;
		
		$row_tabla 	= $this->f_get_row($cod_tabla);
		$row_col_pk	= $this->f_get_col_pk($cod_tabla);
		
		$txt_tabla 		= $row_tabla['txt_nombre'];
		$txt_col_pk		= $row_col_pk['txt_nombre'];
		
		$query = "select * from $txt_tabla where $txt_col_pk = $cod_pk";
		$row = $db->consultar_registro($query);
		
		return $row;

	
	}

	/*===== 2014/10/12 ===========================================>>>>
	DESCRIPCION: 	Obtiene informacion de la columna pk de una tabla
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA			AUTOR			MODIFICACION
	2014/10/12		Luis prieto		Creacion de la funcion
	===========================================================================*/
  	function f_get_col_pk($cod_tabla){
		if(!$cod_tabla)return false;
		global $db;
		
		$query = "select * from columna_tabla_autonoma where cod_tabla = $cod_tabla and ind_pk = 1";

		$row = $db->consultar_registro($query);
		return $row;
		
	}
	
	/*===== 2014/05/05 ========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene todos los registros activos de la tabla tabla_autonoma
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function f_get_activo(){
		global $db;
		$query ="
		select 		cod_tabla,
					txt_alias as txt_nombre 
		from 		tabla_autonoma
		where		cod_estado_tabla = 2
		order by	txt_nombre";

		$cursor		 = $db->consultar($query);	
		return $cursor;
	}
	
	/*=====2008/12/13========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene todos los registros activos de la tabla tabla_autonoma
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function f_get_tablas_activas(){
		global $db;
		$query ="
		select 		* 
		from 		tabla_autonoma
		where		cod_estado_tabla = 2
		order by	txt_nombre";

		$cursor		 = $db->consultar($query);	
		return $cursor;
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene un registro especifico de la tabla autonoma
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function f_get_row($cod_tabla){
		global $db;
		$query ="
		select 		* 
		from 		tabla_autonoma
		where		cod_tabla in($cod_tabla)";
		$row		 = $db->consultar_registro($query);	
		return $row;
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene un registro especifico de la tabla autonoma
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
   	function p_verificar_nuevo_pk($cod_pk, $cod_usuario,$row_tabla_autonoma){
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
		$txt_columna_pk			=	$row[0];

		//=== Evalua si el codigo ya fue creado >>>
		$query					=	"	select 	$txt_columna_pk 
										from 	$txt_nombre_tabla 
										where 	$txt_columna_pk = $cod_pk";
		$row					=	$db->consultar_registro($query);
		if($row[0]) 				return $row[0];
		
		//=== Obtiene las columnas que se deben cargar en el registro inicial >>>
		$query					=	"	select 	* 
										from 	columna_tabla_autonoma
										where	(ind_not_null		= 1
										or		txt_default_value is not null
										)
										and		ind_pk				<>1
										and		cod_tabla = $cod_tabla";
		$cursor_columnas		= $db->consultar($query);
		$num_registros 			= $db->num_registros($cursor_columnas);
		$arr_nom_columna		= array();
		$arr_val_columna		= array();
		array_push($arr_nom_columna, $txt_columna_pk );
		array_push($arr_val_columna,$cod_pk);
		for($i=0; $i<$num_registros; $i++){
			$row_info_columna	= $db->sacar_registro($cursor_columnas,$i);
			$default_value 		= $row_info_columna['txt_default_value'];
			array_push($arr_nom_columna,$row_info_columna['txt_nombre']);
			if($row_info_columna['cod_tipo_dato_columna']==1) 	array_push($arr_val_columna,"'$default_value'");//varchar
			else 												array_push($arr_val_columna,$default_value);	//date
		}
		$arr_nom_columna	=	implode(",",$arr_nom_columna);//Nombre de las columnas insert
		$arr_val_columna	=	implode(",",$arr_val_columna);//Valor de las columnas insert
		$query				=	"
		insert 	into $txt_nombre_tabla
				($arr_nom_columna,cod_usuario,ind_bloqueado)
		values	($arr_val_columna,$cod_usuario,1)";
		$db->consultar($query);
		//$cod_pk	= $db->fn_ultimo_registro();
		$cod_pk	= $GLOBALS['fn_ultimo_registro'];
		return $cod_pk;
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene un registro especifico de la tabla autonoma
	AUTOR:			Cristian Arellano
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

		$txt_columna_pk			=	$row[0];

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
		$arr_nom_columna		= array();
		$arr_val_columna		= array();
		for($i=0; $i<$num_registros; $i++){
			$row_info_columna	= $db->sacar_registro($cursor_columnas,$i);
			$default_value 		= $row_info_columna['txt_default_value'];
			array_push($arr_nom_columna,$row_info_columna['txt_nombre']);
			if($row_info_columna['ind_pk']==1)						
					array_push($arr_val_columna,$cod_pk);
			else if($row_info_columna['cod_tipo_dato_columna']==1 || $row_info_columna['cod_tipo_dato_columna']==15) 	
					array_push($arr_val_columna,"'$default_value'");//varchar con o sin numeros
			else if($default_value==='0') {	
					array_push($arr_val_columna,"0");//varchar con o sin numeros
			}		
			else if(!$default_value){ 	
					array_push($arr_val_columna,"NULL");//varchar con o sin numeros
			}	
			else 													
					array_push($arr_val_columna,$default_value);	//date
		}
		$arr_nom_columna	=	implode(",",$arr_nom_columna);//Nombre de las columnas insert
		$arr_val_columna	=	implode(",",$arr_val_columna);//Valor de las columnas insert
		$query				=	"
		insert 	into $txt_nombre_tabla
				($arr_nom_columna,cod_usuario,ind_bloqueado)
		values	($arr_val_columna,$cod_usuario,1)";

		$db->consultar($query);
		//$cod_pk	= $db->fn_ultimo_registro();
		$cod_pk = $GLOBALS['fn_ultimo_registro'];
		return $cod_pk;
	}
}
?>