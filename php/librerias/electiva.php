<?
/*===== 2017/04/04 =======================================D E C K===>>>>
DESCRIPCION: 	Contiene diferentes funciones realcionadas la tabla electiva
PROPIETARIO:	© Luis Prieto
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
if(class_exists('electiva') != true){
	class electiva{
		var $cod_electiva;
		var $cod_usuario;
		var $cod_usuario_modificacion;

		function __construct(){
			$this->cod_usuario 				= $GLOBALS['cod_usuario'];
	  		$this->cod_usuario_modificacion = $GLOBALS['cod_usuario'];
		}

		/*===== 2017/04/04  ===lıllı ((((̲̅̅●̲̲̅̅̅̅=̲̲̅̅̅̅●̲̅̅)))) ıllı================== DECK ====>>>>
		DESCRIPCION: 		Proceso para eliminar una electiva y su relacion con los estudiantes
		AUTOR:				Luis Prieto
		---------------------------------------------------------------------------					
		PARAMETRO			DESCRIPCION 
		-----------------------------------------------------------------------------
		HISTORIAL DE MODIFICACIONES
		AUTOR				DESCRIPCION					FECHA
		Luis Prieto			Creacion de la funcion		2017/04/04
		===========================================================================*/
		function p_delete_electiva(){
			global $db;

			if(!$this->cod_usuario)return false;
			if(!$this->cod_electiva)return false;

			// debe eliminar primero los registros de la tabla electiva_estudiante
			$query = "delete from electiva_estudiante where cod_electiva = ".$this->cod_electiva;
			
			if($db->consultar($query)){
				$query = "delete from electiva where cod_electiva = ".$this->cod_electiva;
				if($db->consultar($query))return true;
				else return false;

			}else return false;

		}

		/*===== 2017/04/04  ===lıllı ((((̲̅̅●̲̲̅̅̅̅=̲̲̅̅̅̅●̲̅̅)))) ıllı================== DECK ====>>>>
		DESCRIPCION: 		Proceso para validar si la electiva tiene estudiantes inscritos
		AUTOR:				Luis Prieto
		---------------------------------------------------------------------------					
		PARAMETRO			DESCRIPCION 
		-----------------------------------------------------------------------------
		HISTORIAL DE MODIFICACIONES
		AUTOR				DESCRIPCION					FECHA
		Luis Prieto			Creacion de la funcion		2017/04/04
		===========================================================================*/
		function f_valida_delete(){
			global $db;

			$query = "select count(*) as num from electiva_estudiante where cod_electiva = ".$this->cod_electiva;
			$row = $db->consultar_registro($query);
			$num = $row['num'];
			return $num;


		}

		/*===== 2017/04/04  ===lıllı ((((̲̅̅●̲̲̅̅̅̅=̲̲̅̅̅̅●̲̅̅)))) ıllı================== DECK ====>>>>
		DESCRIPCION: 		Proceso para retornar cursor con el listado de estudiantes por lectiva
		AUTOR:				Luis Prieto
		---------------------------------------------------------------------------					
		PARAMETRO			DESCRIPCION 
		-----------------------------------------------------------------------------
		HISTORIAL DE MODIFICACIONES
		AUTOR				DESCRIPCION					FECHA
		Luis Prieto			Creacion de la funcion		2017/04/04
		===========================================================================*/
		function f_get_cursor_estudiante(){
			global $db;

			if(!$this->cod_electiva)return false;
			if(!$this->cod_usuario)return false;

			$query = "	select 	ee.cod_electiva						,
								ee.fec_registro						,
								su.txt_nombre as txt_estudiante		,
								su.txt_login as txt_usuario_login 
						from 	electiva_estudiante ee,
								seg_usuario su 
						where  	ee.cod_usuario_pk = su.cod_usuario_pk
						and 	ee.cod_electiva = ".$this->cod_electiva;
			$cursor = $db->consultar($query);
			return $cursor;

		}

		/*===== 2017/04/04  ===lıllı ((((̲̅̅●̲̲̅̅̅̅=̲̲̅̅̅̅●̲̅̅)))) ıllı================== DECK ====>>>>
		DESCRIPCION: 		Proceso para registrar el usuario/estudiante a la electiva seleccionada
		AUTOR:				Luis Prieto
		---------------------------------------------------------------------------					
		PARAMETRO			DESCRIPCION 
		-----------------------------------------------------------------------------
		HISTORIAL DE MODIFICACIONES
		AUTOR				DESCRIPCION					FECHA
		Luis Prieto			Creacion de la funcion		2017/04/04
		===========================================================================*/
		function p_genera_inscripcion(){
			global $db;

			if(!$this->cod_usuario)return false;
			if(!$this->cod_electiva)return false;

			// ==== INFORMACION DE LA ELECTIVA ===>>
			$row_electiva = $this->f_get_row();
			$num_cupo = $row_electiva['num_cupo'];

			//=== debe validar cupos
			$query = "select 	cod_electiva, 
								count(*) as cupo_utilizado 
						from 	electiva_estudiante 
						where 	cod_electiva = ".$this->cod_electiva." 
						group 	by cod_electiva";
			$row_cupo = $db->consultar_registro($query);
			$num_cupo_utilizado = $row_cupo['cupo_utilizado'];

			if($num_cupo_utilizado==$num_cupo)return false; // esta lleno el cupo y no permite mas registros


			$query = "insert into electiva_estudiante 
								(cod_electiva,cod_usuario_pk,fec_registro)
								values 
								(".$this->cod_electiva.",".$this->cod_usuario.",now())";
			
			if($db->consultar($query))return true;
			else return false;

		}


		/*===== 2017/04/04  ===lıllı ((((̲̅̅●̲̲̅̅̅̅=̲̲̅̅̅̅●̲̅̅)))) ıllı================== DECK ====>>>>
		DESCRIPCION: 		Proceso para validar si el usuario/estudiante puede 
							inscribirse en la electiva seleccionada
							retorna true si puede inscribirse
							false impide inscripcion
		AUTOR:				Luis Prieto
		---------------------------------------------------------------------------					
		PARAMETRO			DESCRIPCION 
		-----------------------------------------------------------------------------
		HISTORIAL DE MODIFICACIONES
		AUTOR				DESCRIPCION					FECHA
		Luis Prieto			Creacion de la funcion		2017/04/04
		===========================================================================*/
		function f_valida_inscripcion(){
			global $db;

			if(!$this->cod_usuario)return false;
			if(!$this->cod_electiva)return false;

			$error = NULL;

			// ==== INFORMACION DE LA ELECTIVA ===>>
			$row_electiva = $this->f_get_row();
			$num_cupo = $row_electiva['num_cupo'];

			//=== debe validar cupos
			$query = "select 	cod_electiva, 
								count(*) as cupo_utilizado 
						from 	electiva_estudiante 
						where 	cod_electiva = ".$this->cod_electiva." 
						group 	by cod_electiva";
			$row_cupo = $db->consultar_registro($query);
			$num_cupo_utilizado = $row_cupo['cupo_utilizado'];

			if($num_cupo_utilizado==$num_cupo){
				$error = "Lo sentimos el cupo esta lleno";
				return $error; // esta lleno el cupo y no permite mas registros
			}


			$query = "select 	count(*) as num
						from 	electiva_estudiante 
						where 	cod_usuario_pk = ".$this->cod_usuario."
						and 	cod_electiva = ".$this->cod_electiva;

			$row = $db->consultar_registro($query);
			$num = $row['num'];

			if($num==0)return true;
			else if($num>0){
				$error = "Ya estas inscrito en la Electiva";
				return $error;
			}
		}

		/*===== 2017/04/04  ===lıllı ((((̲̅̅●̲̲̅̅̅̅=̲̲̅̅̅̅●̲̅̅)))) ıllı================== DECK ====>>>>
		DESCRIPCION: 		Proceso para retornar informacion de un registro
		AUTOR:				Luis Prieto
		---------------------------------------------------------------------------					
		PARAMETRO			DESCRIPCION 
		-----------------------------------------------------------------------------
		HISTORIAL DE MODIFICACIONES
		AUTOR				DESCRIPCION					FECHA
		Luis Prieto			Creacion de la funcion		2017/04/04
		===========================================================================*/
		function f_get_row(){
			global $db;

			if(!$this->cod_electiva)return false;

			$query = "select * from electiva where cod_electiva = ".$this->cod_electiva;
			$row = $db->consultar_registro($query);
			return $row;

		}


	} // fin class
} // fin if