<?
/*=====2006/06/01==============================D E C K========>>>>
DESCRIPCION: 	Contiene las consultas contra la tabla seg_usuario
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
class seg_perfil_usuario{
	/*===== 2014/05/06 ======================================================>>>>
	DESCRIPCION: 	Retorna cadena de nombre de usuarios pertenecientes a un perfil
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function f_get_usuarios($cod_perfil){
		global $db;
		
		$query = "
			select  GROUP_CONCAT(trim(ifnull(su.txt_nombre, su.txt_login))) as txt_nombre
			from    seg_perfil_usuario spu,
			        seg_usuario         su
			where   spu.cod_perfil = $cod_perfil
			and     spu.cod_usuario_pk = su.cod_usuario_pk
			order 	by su.txt_nombre asc";
		
		$row = $db->consultar_registro($query);
		
		$arr_usuarios = explode(',',$row['txt_nombre']);
		
		$cadena = implode(', ',$arr_usuarios);

		
		return $cadena;
		
		

	}
	
	
	/*=====20080817======================================================>>>>
	DESCRIPCION: 	crea un registro de perfil usuario sin crear nada duplicado
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function p_crear_registro(
			$cod_usuario	,
			$cod_perfil
	){
		global $db;
		//=== primero evalua que el registro no este creado >>>
		$query ="
		select 	*
		from	seg_perfil_usuario
		where	cod_usuario_pk 	= $cod_usuario
		and		cod_perfil		= $cod_perfil";
		$row	= $db->consultar_registro($query);
		//=== Si el registro no esta creado lo crea >>>>
		if(!$row[0]){
			$query = "insert into seg_perfil_usuario (cod_usuario_pk, cod_perfil) values ($cod_usuario, $cod_perfil) ";
			$db->consultar($query);
		}
	}
	
	/*=====20080817======================================================>>>>
	DESCRIPCION: 	Obtiene inforamcion de los usuarios
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
	function f_get_perfiles($cod_usuario){
		global $db;
		$query ="
		select	*
		from	seg_perfil_usuario
		where	cod_usuario_pk		='$cod_usuario'";

		$cursor	=	$db->consultar($query);	

		//=== Saca la informacion de los perfiles del usuario >>>
		$num_registros 	= 	$db->num_registros($cursor);
		$arr_perfil		=	array();
		for($i=0; $i<$num_registros; $i++){
			$row  =$db->sacar_registro($cursor,$i);
			array_push($arr_perfil,$row['cod_perfil']);
		}		
		$arr_perfil		=	implode(",",$arr_perfil);
		return $arr_perfil;
	}
}
?>