<?
/*=====2006/06/01============================================>>>>
DESCRIPCION: 	Contiene las consultas contra la tabla seg_usuario
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
if(class_exists('seg_usuario') != true){
	class seg_usuario{
		/*=====20080817======================================================>>>>
		DESCRIPCION: 	Metodo para crear un registro
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function p_crea_registro($var_request){
			global $db;

			$txt_nombre = $var_request['txt_nom_usuario'];
			$txt_login = $var_request['num_identificacion_user'];
			$txt_pass = $var_request['txt_pass_user'];

			$query = "insert into seg_usuario (
												txt_nombre			,
												num_identificacion 	,
												cod_estado_seg_usuario,
												txt_login 			,
												txt_password 		,
												cod_usuario 		,
												fec_registro 		,
												ind_bloqueado
											) values (
												'".$txt_nombre."'				,
												'".$txt_login."'				,
												1 								,
												'".$txt_login."'				,
												password(SHA('".$txt_pass."'))	,
												1 								,
												now() 							,
												0
											)";
			$db->consultar($query);
			$cod_pk	= $GLOBALS['fn_ultimo_registro'];

			// ingresa el nuevo usuario al perfil de estudiante
			$query = "insert into seg_perfil_usuario (cod_perfil,cod_usuario_pk,txt_nota,cod_usuario,ind_bloqueado)
														values (2,".$cod_pk.",'',".$cod_pk.",0)";
			if($db->consultar($query))return true;
		}
	
		/*=====20080817======================================================>>>>
		DESCRIPCION: 	Modifica el txt_password de un seg_usuario
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_valida_password($cod_usuario,$str_pass){
			if(!$cod_usuario)return false;
			global $db;

			// limpia la cadena para evitar inyeccion sql
			$str_pass = $db->real_escape_string($str_pass);		
			
			$query = "select 	count(*) num_registros 
						from 	seg_usuario 
						where	cod_usuario_pk = ".$cod_usuario."
						and		txt_password = password(SHA('".$str_pass."'))";
				

			$row = $db->consultar_registro($query);		
			$num_registros = $row['num_registros'];		
			return $num_registros;

		}

		/*===== 2014/11/27 ======================================================>>>>
		DESCRIPCION: 	metodo para validar si el usuario existe en la base de datos
						y de ser true crea la session y devuleve informacion del usuario
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$txt_login		cadena de login
		$txt_password	cadena con el password ingresado por el usuario
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_get_row($cod_usuario){
			if(!$cod_usuario)return false;
			global $db;
			
			$query = "select * from seg_usuario where cod_usuario_pk = $cod_usuario";
			$row = $db->consultar_registro($query);
			
			return $row;
		}


		/*===== 2014/11/27 ======================================================>>>>
		DESCRIPCION: 	metodo para validar si el usuario existe en la base de datos
						y de ser true crea la session y devuleve informacion del usuario
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$txt_login		cadena de login
		$txt_password	cadena con el password ingresado por el usuario
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_valida_existencia($txt_login,$txt_password){
			if(!$txt_login || !$txt_password)return false;
			global $db;
			
			// limpia los datos ingresados para evitar inyecciones sql
			$login			= mysql_real_escape_string($txt_login); 
			$password       = mysql_real_escape_string($txt_password);
			
			$query = "select  	cod_usuario_pk,
								txt_login	
						from 	seg_usuario 
						where 	txt_login = '$txt_login' 
						and 	txt_password = password(SHA('$txt_password'))";

			$row = $db->consultar_registro($query);
			
			
			if(!empty($row)){
				// creamos las sessiones
				session_start();
				session_set_cookie_params(0, "/", $HTTP_SERVER_VARS["HTTP_HOST"], 0); 
				$_SESSION['cod_pk_usuario'] = $row['cod_usuario_pk'];
				$_SESSION['nom_user'] 		= $row['txt_login'];		
				//$ind_existe = 1;
				return $row;
			}
		}


		/*=====20080817======================================================>>>>
		DESCRIPCION: 	Modifica el txt_password de un seg_usuario
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function p_modificar_txt_password(
				$txt_password					,
				$cod_usuario				
		){
			global $db;
			$query ="
			update	seg_usuario
			set		txt_password  		= password(SHA('$txt_password'))
			where	cod_usuario_pk		='$cod_usuario'";
			$db->consultar($query);	
		}
		/*=====20080601======================================================>>>>
		DESCRIPCION: 	Obtiene todos los clientes de acuerdo a un filtro
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_get_seg_usuario(
				$cod_usuario
		){
			global $db;
			$query ="
			select 	*
			from	seg_usuario
			where	cod_usuario_pk='$cod_usuario'";
			$row = $db->consultar_registro($query);	
			return $row;
		}
		/*=====20080601======================================================>>>>
		DESCRIPCION: 	Valida los datos del seg_usuario
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_get_seg_usuario_password(
				$txt_login,
				$txt_password		
		){
			global $db;
			$query ="
			select 	*
			from	seg_usuario
			where	txt_password	=	'$txt_password'
			and		txt_login		=	'$txt_login'";

			$row = $db->consultar_registro($query);	
			return $row;
		}
		/*=====20080601======================================================>>>>
		DESCRIPCION: 	Valida los datos del seg_usuario
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function p_crear_usuario(
				$cod_usuario					,
				$txt_login						,
				$txt_password
		){
			global $db;
			$query ="
			insert into	seg_usuario(
			txt_login		,
			cod_usuario		,
			ind_bloqueado	,
			txt_password
			)values(
			'$txt_login'	,
			'$cod_usuario'	,
			0				,
			'$txt_password'
			)";
			$db->consultar($query);	
			$cod_pk	= $GLOBALS['fn_ultimo_registro'];
			return $cod_pk;
		}
		/*=====20100606========================================================>>>>
		DESCRIPCION: 	Valida los datos del seg_usuario
		---------------------------------------------------------------------------					
		PARAMETRO			DESCRIPCION 
		$cod_usuario_pk		Codigo principal del usuario
		$cod_usuario		Usuario que registra el dato
		$txt_login			Login que normalmente es un email
		$txt_password		password
		===========================================================================*/
		function p_update_row(
				$cod_usuario_pk	,
				$cod_usuario	,
				$txt_login		,
				$txt_password
		){
			global $db;
			$query ="
			update 	seg_usuario set
					txt_login		= '$txt_login'		,
					txt_password	= '$txt_password'	,
					cod_usuario		= '$cod_usuario'
			where	cod_usuario_pk	= $cod_usuario_pk";
			$db->consultar($query);	
		}

	}


}
?>