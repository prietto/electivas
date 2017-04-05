<?
/*=====2011/12/27==============================D E C K========>>>>
DESCRIPCION: 	Contiene las consultas contra la tabla evento
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
if(class_exists('parametro_sistema') != true){
	class parametro_sistema{

		/*=====2017/03/10======== illili_d[^.^]b_ililli ==D E C K========>>>>
		DESCRIPCION: 	Devuelve true si ya se ejecuto la actualizacion del dia de hoy
		---------------------------------------------------------------------------					
		AUTOR:			Luis Prieto
		===========================================================================*/
		function f_get_actualizacion_alarma(){
			global $db;
			
			$query ="select * from parametro_sistema where cod_parametro = 8";
			$row	=	$db->consultar_registro($query);	
			// fecha de la ultima actualizacion
			$fec_last_update 	= $row['val_parametro'];
			$fec_last_update = date("Y/m/d", strtotime("$fec_last_update"));
			$date				= date("Y/m/d");
			if($fec_last_update != $date) return true;
		}
		
		/*===== 2014/10/30 =======	illili_d[^.^]b_ililli =============>>>>
		DESCRIPCION: 	Metodo para guardar varios registros que vienen en vector
						donde el subindice del vector es el codigo de parametro
		AUTOR:			Luis Prieto
		---------------------------------------------------------------------------					
		PARAMETRO			DESCRIPCION 
		$var_request		Vector con datos que llegan por post
		===========================================================================*/
		function p_update_registro_vector($var_request){
			global $db;
			
			$error = 0;
			$arr_parametros = $var_request['val_parametro'];
			
			if(count($arr_parametros)<1)return false; // si esta vacio el vector frena
			
			$arr_keys_parametros = array_keys($arr_parametros);
			for($i=0;$i<count($arr_keys_parametros);$i++){
				
				$cod_parametro 	= 	$arr_keys_parametros[$i];
				$val_parametro	=	$arr_parametros[$cod_parametro];

				
				
				$query = "update parametro_sistema set 
							val_parametro = '$val_parametro'
							where cod_parametro = $cod_parametro	";
							
				
				if(!$db->consultar($query))$error++;
				
			}		
			
			if($error==0)return true;
		
		}	
		
		
		/*===== 2014/10/30 =======	illili_d[^.^]b_ililli =============>>>>
		DESCRIPCION: 	Retorna cursor con los registros de los parametros del sistema que son visibles		
		AUTOR:			Luis Prieto
		---------------------------------------------------------------------------					
		PARAMETRO			DESCRIPCION 
		$array_pedidos		vector de codigos de pedidos 
		===========================================================================*/
		function f_get_visibles(){
			global $db;
			
			
			$query = "select * from parametro_sistema where ind_visible = 1 ";
			$cursor = $db->consultar($query);
			
			return $cursor;
			
		}
		
		/*=====2014/01/08======== illili_d[^.^]b_ililli ==D E C K========>>>>
		DESCRIPCION: 	Actualiza la fecha de actualizacion del sistema
		---------------------------------------------------------------------------					
		AUTOR:			Luis Prieto
		===========================================================================*/
		function p_update_fec_actual(){
			global $db;
			$query ="update parametro_sistema set val_parametro = now() where cod_parametro = 3";
			$db->consultar($query);
		}
		
		
		/*=====2014/01/03======== illili_d[^.^]b_ililli ==D E C K========>>>>
		DESCRIPCION: 	Devuelve true si ya se ejecuto la actualizacion del dia de hoy
		---------------------------------------------------------------------------					
		AUTOR:			Luis Prieto
		===========================================================================*/
		function f_get_actualizacion_facturas(){
			global $db;
			
			$query ="select * from parametro_sistema where cod_parametro = 3";
			$row	=	$db->consultar_registro($query);	
			// fecha de la ultima actualizacion
			$fec_last_update 	= $row['val_parametro'];
			$fec_last_update = date("Y/m/d", strtotime("$fec_last_update"));
			$date				= date("Y/m/d");
			if($fec_last_update != $date) return true;
		}
		
		/*=====2011/12/27==============================D E C K========>>>>
		DESCRIPCION: 	Obtiene datos codificados para un combo de seleccion multiple
		---------------------------------------------------------------------------					
				DESCRIPCION 
		===========================================================================*/
		function f_get_parametros_combo($cod_parametro){
			global $db;
			$query ="
			select	val_parametro,
					txt_nombre
			from	parametro_sistema
			where	cod_parametro	in($cod_parametro)";
			$row	=	$db->consultar($query);	
			return $row;
		}
		/*=====2011/12/27==============================D E C K========>>>>
		DESCRIPCION: 	Obtiene la informacion de un evento especifico con textos 
						referentes a lo que esta en la integridad referencial
		---------------------------------------------------------------------------					
				DESCRIPCION 
		===========================================================================*/
		function f_get_row($cod_parametro){
			global $db;
			$query ="
			select	*
			from	parametro_sistema
			where	cod_parametro	=	$cod_parametro";
			$row	=	$db->consultar_registro($query);	
			return $row;
		}
		/*=====2011/12/27==============================D E C K========>>>>
		DESCRIPCION: 	Actualiza el paramtro de la ultima sincronizacion que se ralizo
		---------------------------------------------------------------------------					
				DESCRIPCION 
		===========================================================================*/
		function p_update_ultima_sincronizacion(){
			global $db;
			$query ="
			update 	parametro_sistema 
			set 	val_parametro = now() 
			where 	cod_parametro = 3;";
			$db->consultar($query);	
	
		}
		/*=====2011/12/27==============================D E C K========>>>>
		DESCRIPCION: 	Actualiza el valor de un parametro
		---------------------------------------------------------------------------					
		DESCRIPCION 
		===========================================================================*/
		function p_update_valor($cod_parametro,$val_parametro){
			global $db;
			$query ="
			update 	parametro_sistema 
			set 	val_parametro = $val_parametro
			where 	cod_parametro = $cod_parametro";
			$db->consultar($query);	
		}
	}
}
?>