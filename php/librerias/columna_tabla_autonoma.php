<?php
/*=====2008/12/15=======================================D E C K===>>>>
DESCRIPCION: 	Contiene diferentes funciones realcionadas la tabla columna_tabla_autonoma
PROPIETARIO:	© D E C K
AUTOR:			Cristian Arellano
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
class columna_tabla_autonoma{
	
	/*=====2014/10/26========================================D E C K===>>>>
	DESCRIPCION: 		De acuerdo a las caracteristicas de la columna entrega el imput requerido
	AUTOR:				Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$cod_columna_tabla	Codigo pk del registro en la tabla columna_tabla_autonoma
	$val_campo			valor que el usuario ingreso en el campo
	===========================================================================*/
  	function f_get_script_cursor($cod_columna_tabla){
		if(!$cod_columna_tabla)return false;
		global $db;
		
		$query = "select txt_script_cursor from columna_tabla_autonoma where cod_columna_tabla = $cod_columna_tabla";
		$row = $db->consultar_registro($row);
		
		return $row['txt_script_cursor'];
		
	}
	
	
	/*=====2014/10/26========================================D E C K===>>>>
	DESCRIPCION: 		De acuerdo a las caracteristicas de la columna entrega el imput requerido
	AUTOR:				Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$cod_columna_tabla	Codigo pk del registro en la tabla columna_tabla_autonoma
	$val_campo			valor que el usuario ingreso en el campo
	===========================================================================*/
  	function f_get_row($cod_columna_tabla){
		if(!$cod_columna_tabla)return false;
		global $db;
		
		$query = "select * from columna_tabla_autonoma where cod_columna_tabla = $cod_columna_tabla";
		$row = $db->consultar_registro($query);
		
		return $row;
		
	}
	
	
	/*=====2014/10/26========================================D E C K===>>>>
	DESCRIPCION: 		De acuerdo a las caracteristicas de la columna entrega el imput requerido
	AUTOR:				Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$cod_columna_tabla	Codigo pk del registro en la tabla columna_tabla_autonoma
	$val_campo			valor que el usuario ingreso en el campo
	===========================================================================*/
  	function f_get_datos_ajax($cod_columna_tabla, $val_campo){
		if(!$cod_columna_tabla)return false;
		
		global $db;
		
		$val_campo = trim($val_campo);
		
		if($val_campo == NULL)return false;
		


		
		//=== Consulta la columna donde esta el script >>>
		$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		cod_columna_tabla	= 	$cod_columna_tabla		";

		$row_info_columna		= $db->consultar_registro($query);
		$txt_nombre_columna		= $row_info_columna['txt_nombre'];

		//== busca el quiery que trae el nombre >>>
		$query		= $row_info_columna['txt_script_lista_valor'];

		if($query == NULL)return false;

		// cuando la consulta tiene like
		$query		= str_replace("'%value_columna%'","'%$val_campo%'",$query);
		$query		= str_replace("value_columna","'$val_campo'",$query);
		



	  	/*$query		= str_replace("value_columna",$val_campo,$query);*/

		$cursor	= $db->consultar($query);
		// devuelve siempre la segunda posicion del vector
		return 	$cursor;
	}
	
	/*=====2009/01/08========================================D E C K===>>>>
	DESCRIPCION: 		Metodo para eliminar la foto de un registro de una tabla autonoma
	AUTOR:				Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO				DESCRIPCION 
	$cod_tabla				codigo de la tabla
	$arr_post				valores de las variables posta
	$cod_pk					codigo del registro primario
	$nom_columna_con_foto	nombre de la columna con foto
	===========================================================================*/
  	function f_eliminar_foto(
			$cod_tabla				,
			$arr_post				,
			$cod_pk					,
			$nom_columna_con_foto
	){
		global $db;
		$tabla_autonoma	= new tabla_autonoma;
		//=== Borra el archivo fisico
		$ruta_archivo 		= $arr_post[$nom_columna_con_foto];
		@unlink($ruta_archivo); 	//Si ya existe elimina el archivo para modificarlo >>>

		//=== Encuentra nombre de la tabla >>>
		$row_tabla			= $tabla_autonoma->f_get_row($cod_tabla);
		$nom_tabla			= $row_tabla['txt_nombre'];

		//=== Nombre llave primaria>>>
		$row_pk				= $this->f_get_row_pk($cod_tabla);
		$nom_pk				= $row_pk['txt_nombre'];
		
		//=== Actualiza el campo donde estaba almacenado el nombre del archivo>>>
		$query				= "update $nom_tabla set $nom_columna_con_foto='' where $nom_pk=$cod_pk";
		$db->consultar($query);
	}

	/*=====2008/12/15====================================D E C K===>>>>
	DESCRIPCION: 	Elimina todos los registros asociados a una llave foranea
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function 	p_eliminar_detalle(
				$cod_tabla_detalle	,
				$cod_tabla_maestro	,
				$cod_pk_maestro
	){
		global $db;
		$tabla_autonoma		= 	new tabla_autonoma;
		//===Obtiene nombre de la llave primaria de la tabla maestro>>>
		$row_pk_maestro		= 	$this->f_get_row_pk($cod_tabla_maestro);
		$nom_pk_maestro		= 	$row_pk_maestro['txt_nombre'];
		
		//===Obtiene nombre de la tabla detalle >>>
		$row_tabla_detalle	=	$tabla_autonoma->f_get_row($cod_tabla_detalle);
		$nom_tabla_detalle	=	$row_tabla_detalle['txt_nombre'];
		
		//===Ejecuta la consulta >>>
		$query ="
		delete		from	$nom_tabla_detalle
		where		$nom_pk_maestro = $cod_pk_maestro";
		$db->consultar($query);
	}	

	/*=====2008/12/15====================================D E C K===>>>>
	DESCRIPCION: 	Obtiene los datos de las columnas registradas
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function p_eliminar_registro(
			$cod_tabla			,
			$cod_pk
	){
		global $db;
		//Obtiene las columnas de la tabla >>>
		$query ="
		select 		ta.txt_nombre		as	txt_nombre_tabla	,
					cta.txt_nombre		as	txt_nombre_columna_pk
		from 		columna_tabla_autonoma	cta,
					tabla_autonoma			ta
		where		cta.ind_pk				= 1
		and			ta.cod_tabla			= $cod_tabla
		and			cta.cod_tabla			= ta.cod_tabla";
		$row					= $db->consultar_registro($query);
		$txt_nombre_tabla		= $row['txt_nombre_tabla'];
		$txt_nombre_columna_pk	= $row['txt_nombre_columna_pk'];

		$query ="
		delete 		from 	$txt_nombre_tabla
		where		$txt_nombre_columna_pk	= $cod_pk";
		$db->consultar($query);
	}	
	/*=====2008/12/15====================================D E C K===>>>>
	DESCRIPCION: 	Obtiene los datos de las columnas registradas
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function f_get_info_columnas(
			$cod_tabla			
	){
		global $db;
		//Obtiene las columnas de la tabla >>>
		$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		cod_tabla	= $cod_tabla
		and			ind_visible_form = 1
		order by 	num_orden_insert";
		$cursor		= $db->consultar($query);
		return $cursor;
	}	
	/*=====2008/12/15====================================D E C K===>>>>
	DESCRIPCION: 	Metodo para determinar el registro con el cual esta restringida
					una condicion unique
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$cod_pk				Llave primaria del registro seleccionado
	$row_info_columna	Informacion de la columna con restriccion unique nombre y cod_tabla es lo importante
	$value_columna		valor que se le pretende asignar a la columna
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function f_get_row_restriccion_unique(
			$cod_pk				,
			$row_info_columna	,
			$value_columna				
	){
		global $db;
		$sis_genericos			= new sis_genericos;
		
		//=== Obtiene el nombre de la columna que tiene la llave primaria para no validar contra el mismo registro >>>
		$cod_tabla				= $row_info_columna['cod_tabla'];
		$query ="
		select 		cta.txt_nombre	as txt_pk	,
					ta.txt_nombre	as txt_nombre_tabla
		from 		columna_tabla_autonoma	cta,
					tabla_autonoma			ta
		where		cta.cod_tabla	= $cod_tabla
		and			cta.cod_tabla 	= ta.cod_tabla
		and			cta.ind_pk		= 1";
		$row					= 	$db->consultar_registro($query);
		$txt_pk					= 	$row['txt_pk'];
		$txt_nombre_tabla		= 	$row['txt_nombre_tabla'];
		
		//Obtiene las columnas de la tabla >>>
		$txt_nombre_campo		= 	$row_info_columna['txt_nombre'];
		$value_columna			 = 	$sis_genericos->f_preparar_cadena_para_db($value_columna);//evita espacios y demas basura

		if($row_info_columna['cod_tipo_dato_columna']==2){ //tipo numerico con formato
			$value_columna	= str_replace(",","",$value_columna);	
		}
		if(!$cod_pk)				$cod_pk = 0;
		$query ="
		select 		* 
		from 		$txt_nombre_tabla
		where		$txt_pk <> $cod_pk
		and			$txt_nombre_campo = '$value_columna'";

		$row		= $db->consultar_registro($query);
		return $row;
	}	
	/*=====2008/12/15====================================D E C K===>>>>
	DESCRIPCION: 	Modifica los datos de un registro especifico
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function p_modificar_registro(
			$cod_tabla			,
			$val_post			,
			$cod_pk				,
			$cod_tabla_detalle 			= NULL,
			$cod_navegacion_formulario	= NULL,
			$arr_info_archivo			= NULL
			
	){
		global $db;
		$sis_genericos			= new sis_genericos;
		$arr_columna_and_value	= array();
	
		
		//Evalua si es una tabla maestro de detalle >>>
		if($cod_tabla_detalle && $cod_navegacion_formulario)
			$cursor_columnas 	= $this->f_get_columnas_formulario($cod_tabla,$cod_navegacion_formulario,$cod_tabla_detalle);
		//Si no es una tabla normal>>>
		else
			$cursor_columnas 	= $this->f_get_info_columnas($cod_tabla	);
		
		$num_registros 			= $db->num_registros($cursor_columnas);
		for($i=0; $i<$num_registros; $i++){
			$row_info_columna			= 	$db->sacar_registro($cursor_columnas,$i);
			$txt_nombre_columna			= 	$row_info_columna['txt_nombre'];
			$cod_tipo_dato_columna		= 	$row_info_columna['cod_tipo_dato_columna'];
			//=== Evalua los tipos de dato celular >>>
			if($cod_tipo_dato_columna==10)	{	
				$value 	= 	$val_post["1".$txt_nombre_columna].$val_post[$txt_nombre_columna];
			//=== Evalua un dato tipo archivo >>>
			}else if($cod_tipo_dato_columna==9){	
				$value	= 	$this->p_guardar_archivo($arr_info_archivo,$cod_pk,$row_info_columna);
			}else if($cod_tipo_dato_columna==13){	
				$value	= 	$this->p_guardar_archivo_mp3($arr_info_archivo,$cod_pk,$row_info_columna);
			}else							
				$value	= 	$val_post[$txt_nombre_columna];
			
			//=== Acomoda la informacion para guardarla bien en la base de datos >>>
			$value						= 	$this->f_prepara_dato_para_database(
											$cod_tipo_dato_columna	,
											$value 					
											);
			array_push($arr_columna_and_value,"$txt_nombre_columna=$value");
			
		}
		

		//=== Separa todo por comas >>>
		$arr_columna_and_value	= implode(",",$arr_columna_and_value);
		
		//=== Obtiene el nombre de la tabla >>>
		$query="
		select 		* 
		from 		tabla_autonoma
		where		cod_tabla	= $cod_tabla";
		$row_tabla					= $db->consultar_registro($query);	
		$txt_nombre_tabla_autonoma	= $row_tabla['txt_nombre'];

		//=== Obtiene el nombre de la llave primaria de la tabla>>>
		$row			=$this->f_get_row_pk($cod_tabla);
		$txt_nombre_pk 	= $row['txt_nombre'];

		//=== Actualiza los datos de la tabla>>>
		$query="
		update $txt_nombre_tabla_autonoma  set
				$arr_columna_and_value,
				ind_bloqueado = 0
		where 	$txt_nombre_pk	=$cod_pk";

		$db->consultar($query);	
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Remplaza los valores del imput al refrescar pantalla
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
	function p_guardar_archivo($arr_info_archivo,$cod_pk,$row_info_columna){
		global $db;

		$tabla_autonoma		= new tabla_autonoma;
		$c_file				= new c_file;
		$cod_tabla			= $row_info_columna['cod_tabla'];
		$row_tabla			= $tabla_autonoma->f_get_row($cod_tabla);
		$nom_tabla			= $row_tabla['txt_nombre'];
		$nom_columna		= $row_info_columna['txt_nombre'];
		$arr_archivo_actual	= $arr_info_archivo["file_$nom_columna"];
		
		
		//=== Obtiene el archivo guardado en la base de datos >>>
		$row_pk	= 	$this->f_get_row_pk($cod_tabla);		
		$nom_pk	= 	$row_pk['txt_nombre'];
		$query	= 	"select $nom_columna from $nom_tabla where $nom_pk = ".$cod_pk;
		$row	= 	$db->consultar_registro($query);
		$nom_archivo_en_db =$row[0];

		//=== Si ingreso un nuevo archivo
		if($arr_archivo_actual['size']){
			$extension 				= $c_file->f_get_tipo_imagen($arr_archivo_actual['type']);
			$num_carpeta_interna	= (round($cod_pk/100))+1;
			$nom_archivo			= "$nom_columna$cod_pk$extension";
			$ruta_carpeta			= "../../imagenes/$nom_tabla";
			mkdir($ruta_carpeta,0777); 	//para las tablas nuevas crea una carpeta 
			$ruta_carpeta			= "../../imagenes/$nom_tabla/carpeta_$num_carpeta_interna";
			mkdir($ruta_carpeta,0777); 	//para los usuarios nuevos crea la carpeta
			unlink($nom_archivo_en_db); 	//Si ya existe elimina el archivo para modificarlo >>>
			
			//=== Copia los datos en el lugar requerido >>>
			$origen					= $arr_archivo_actual['tmp_name'];
			$destino				= "$ruta_carpeta/$nom_archivo";
			@copy($origen ,$destino);
			return $destino;//$nom_archivo;
		}else {
			return 		$nom_archivo_en_db;
		}	
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Metodo para guardar un archivo de audio
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
	function p_guardar_archivo_mp3($arr_info_archivo,$cod_pk,$row_info_columna){
		global $db;
		$tabla_autonoma		= new tabla_autonoma;
		$c_file				= new c_file;
		$cod_tabla			= $row_info_columna['cod_tabla'];
		$row_tabla			= $tabla_autonoma->f_get_row($cod_tabla);
		$nom_tabla			= $row_tabla['txt_nombre'];
		$nom_columna		= $row_info_columna['txt_nombre'];
		$arr_archivo_actual	= $arr_info_archivo["file_$nom_columna"];
		//=== Obtiene el archivo guardado en la base de datos >>>
		$row_pk	= 	$this->f_get_row_pk($cod_tabla);
		$nom_pk	= 	$row_pk['txt_nombre'];
		$query	= 	"select $nom_columna from $nom_tabla where $nom_pk = $cod_pk";
		$row	= 	$db->consultar_registro($query);
		$nom_archivo_en_db =$row[0];
		//=== Si ingreso un nuevo archivo
		if($arr_archivo_actual['name']){
			$extension 				= ".mp3";
			$num_carpeta_interna	= (round($cod_pk/100))+1;
			$nom_archivo			= "$nom_columna$cod_pk$extension";
			$ruta_carpeta			= "../../audio/$nom_tabla";
			@mkdir($ruta_carpeta); 	//para las tablas nuevas crea una carpeta 
			$ruta_carpeta			= "../../audio/$nom_tabla/carpeta_$num_carpeta_interna";
			@mkdir($ruta_carpeta); 	//para los usuarios nuevos crea la carpeta
			@unlink("$ruta_carpeta/$nom_archivo_en_db"); 	//Si ya existe elimina el archivo para modificarlo >>>
			
			//=== Copia los datos en el lugar requerido >>>
			$origen					= $arr_archivo_actual['tmp_name'];
			$destino				= "$ruta_carpeta/$nom_archivo";
			@copy($origen ,$destino);
			return $nom_archivo;
		}else {
			return 		$nom_archivo_en_db;
		}	
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Metodo para guardar un archivo de audio
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
	function p_guardar_archivo_maestro_detalle($arr_info_archivo,$cod_pk,$row_info_columna,$num_registro){
		global $db;
		$tabla_autonoma		= new tabla_autonoma;
		$c_file				= new c_file;
		$cod_tabla			= $row_info_columna['cod_tabla'];
		$row_tabla			= $tabla_autonoma->f_get_row($cod_tabla);
		$nom_tabla			= $row_tabla['txt_nombre'];
		$nom_columna		= $row_info_columna['txt_nombre'];
		$arr_archivo_actual	= $arr_info_archivo["file_$nom_columna"];
		//=== Obtiene el archivo guardado en la base de datos >>>
		$row_pk	= 	$this->f_get_row_pk($cod_tabla);
		$nom_pk	= 	$row_pk['txt_nombre'];
		$query	= 	"select $nom_columna from $nom_tabla where $nom_pk = $cod_pk";
		$row	= 	$db->consultar_registro($query);
		$nom_archivo_en_db =$row[0];
		//=== Si ingreso un nuevo archivo
		if($arr_archivo_actual['name'][$num_registro]){
			$extension 				= $c_file->f_get_tipo_imagen($arr_archivo_actual['type'][$num_registro]);
			//".mp3";
			$num_carpeta_interna	= (round($cod_pk/100))+1;
			$nom_archivo			= "$nom_columna$cod_pk$extension";

			//=== Evalua si son imagenes o archivos de audio >>>
			if($extension == ".mp3")	$ruta_carpeta	= "../../audio/$nom_tabla";
			else 						$ruta_carpeta	= "../../imagenes/$nom_tabla";
			
			@mkdir($ruta_carpeta); 	//para las tablas nuevas crea una carpeta 
			$ruta_carpeta			.= "/carpeta_$num_carpeta_interna";
			@mkdir($ruta_carpeta); 	//para los usuarios nuevos crea la carpeta
			@unlink("$ruta_carpeta/$nom_archivo_en_db"); 	//Si ya existe elimina el archivo para modificarlo >>>
			
			//=== Copia los datos en el lugar requerido >>>
			$origen					= $arr_archivo_actual['tmp_name'][$num_registro];
			$destino				= "$ruta_carpeta/$nom_archivo";
			copy($origen ,$destino);
			return $nom_archivo;
		}else {
			return 		$nom_archivo_en_db;
		}	
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Remplaza los valores del imput al refrescar pantalla
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	$row_imputs		Vector con los imputs que se mostraran en pantalla
	$val_post		Valores que quedaron en el post
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function f_replazar_valor_imput($row_tabla_autonoma, $row_imputs, $val_post){
		global $db;
		$obj_listbox			= new obj_listbox; 
		$sis_genericos			= new sis_genericos;
		$txt_nombre_tabla		= $row_tabla_autonoma['txt_nombre'];
		$cod_tabla				= $row_tabla_autonoma['cod_tabla'];

		//=== Consulta para recorrer cada columna >>>
		$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		cod_tabla	=	$cod_tabla
		and			ind_visible_form = 1
		order by 	num_orden_insert";
		$cursor_columnas		= $db->consultar($query);
		$num_registros 			= $db->num_registros($cursor_columnas);
		for($i=0; $i<$num_registros; $i++){
			$row_info_columna						= $db->sacar_registro($cursor_columnas,$i);
			$txt_nombre_columna						= $row_info_columna['txt_nombre'];
			

			// === Evalua las listas de valores >>>
			$value									= $val_post["txt_".$txt_nombre_columna];
			
			//== si un combo tipo CELULAR >>>
			if($row_info_columna['cod_tipo_dato_columna']==10){
				//== busca el quiery que trae el nombre >>>
				$value_operador	= $val_post["1".$txt_nombre_columna];
				$row_imputs[$txt_nombre_columna]['input']= 				
				str_replace("adicional",$value_operador,$row_imputs[$txt_nombre_columna]['input']);
			}
			//== si es un archivo de fotos genera enlace para ver la foto >>>
			else if($row_info_columna['cod_tipo_dato_columna']==9 && $value){
			  	$row_imputs[$txt_nombre_columna]['input'] .= 
				"<a href=".'"'."javascript:ver_foto('$value','$txt_nombre_columna')".'"'."> Ver Foto</a>";
			}

			
			$row_imputs[$txt_nombre_columna]['input']= 
			str_replace("txt_value_columna",$value,$row_imputs[$txt_nombre_columna]['input']);	
			$value									= $val_post[$txt_nombre_columna];
		
			if($row_imputs[$txt_nombre_columna]['cursor']){
				$max_length = $row_info_columna['max_length']; // numero maximo de caracteres permitidos
				$value=$obj_listbox->f_crear_lista_limite_caracteres($row_imputs[$txt_nombre_columna]['cursor'], $value, $max_length);
			}
			$row_imputs[$txt_nombre_columna]['input']= 
			str_replace("value_columna",$value,$row_imputs[$txt_nombre_columna]['input']);	
				
		}	

		return $row_imputs;
	}
	
	

	/*=====2009/01/08========================================D E C K===>>>>
	DESCRIPCION: 		De acuerdo a las caracteristicas de la columna entrega el imput requerido
	AUTOR:				Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$row_info_columna	Informacion de la columna
	===========================================================================*/
  	function f_get_datos_iframe($txt_nombre_columna_iframe,$cod_tabla, $val_campo){
		global $db;
		//=== Consulta la columna donde esta el script >>>
		$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		txt_nombre	= 	'$txt_nombre_columna_iframe'
		and			cod_tabla	=	$cod_tabla";

		$row_info_columna		= $db->consultar_registro($query);
		$txt_nombre_columna		= $row_info_columna['txt_nombre'];
		//== busca el quiery que trae el nombre >>>
	  	$query		= $row_info_columna['txt_script_lista_valor']; 
		$query		= str_replace("value_columna",$val_campo,$query);

		$row_nmbre	= $db->consultar_registro($query);
		return 	$row_nmbre;
	}
	/*=====2009/01/08========================================D E C K===>>>>
	DESCRIPCION: 		De acuerdo a las caracteristicas de la columna entrega el imput requerido
	AUTOR:				Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$row_info_columna	Informacion de la columna
	===========================================================================*/
  	function f_convertir_tipo_imput($row_info_columna,$ind_registro=NULL){
		if(!$row_info_columna) return false;
		global $db;		
		$txt_nombre_columna		= $row_info_columna['txt_nombre'];
		$max_length				= $row_info_columna['max_length'];
		$txt_script_cursor		= $row_info_columna['txt_script_cursor'];
		$cod_ventana_emergente	= $row_info_columna['cod_ventana_emergente'];
		$cod_tabla				= $row_info_columna['cod_tabla'];
		$txt_js_onblur			= $row_info_columna['txt_js_onblur'];
		$ind_not_null			= $row_info_columna['ind_not_null'];
		$txt_placeholder		= $row_info_columna['txt_placeholder'];
		$acum_txt_js_onblur		= 'onblur		="'.$txt_js_onblur.'"';
		$ind_multiple = false;
		

		// para los combo box de seleccion multiple
		$ind_input_multiple		= $row_info_columna['ind_input_multiple'];
		if($ind_input_multiple == 1 && $ind_registro ==FALSE){ 
			$ind_multiple = true;
			$multiple = "multiple='multiple' ";
		}else{ 
			$multiple = NULL;
			$ind_multiple = FALSE;
		}
		


		
		// si el indicardor de not null esta en 1 añade atribute require
		if($ind_not_null == 1)	$required = "required='required'";
		else					$required = "";
		
		//=== Para poner alias para varias tablas >>>
		if($row_info_columna['txt_tabla']){
			$txt_nombre_columna	= $row_info_columna['txt_tabla']."-".$row_info_columna['txt_nombre'];

		}else{
			$txt_nombre_columna	= $row_info_columna['txt_nombre'];
		}
		

		
		$row_imput	= array();
		//=== Evalua si el campo debe quedar bloqueado>>>
		if($row_info_columna['ind_bloqueado'] == 1 || $row_info_columna['ind_readonly']==1){

			$readonly = "readonly=true";
		}else{
			$readonly = FALSE;
		}
		
		// si es pantalla de consulta no bloquea los filtros
		if($readonly && $ind_registro == FALSE)$readonly = FALSE;		
				
		//=== Evalua campo oculto PK>>>
		if($row_info_columna['ind_pk'] == 1){
			$row_imput['input']	= 
				"<input 	name		='$txt_nombre_columna' 
				
							type		='hidden' 
							value		='value_columna'/>";
			$row_imput['txt_alias']= NULL;
		}
		//=== Evalua datos tipo ARCHIVO MP3 >>>
		else if($row_info_columna['cod_tipo_dato_columna'] == 13){
			$row_imput['input']	= 	"
			<input  type='hidden' name='$txt_nombre_columna' value='value_columna' />
			<input name='file_$txt_nombre_columna' $acum_txt_js_onblur type='file' class='combo' />";
		}
		//=== Evalua datos tipo ARCHIVO >>>
		else if($row_info_columna['cod_tipo_dato_columna'] == 9){
			$row_imput['input']	= 	"
			<input  type='hidden' name='$txt_nombre_columna' value='value_columna' />
			<input name='file_$txt_nombre_columna' $acum_txt_js_onblur type='file' class='combo' />";
		}
		//=== Evalua datos tipo CELULAR >>>
		else if($row_info_columna['cod_tipo_dato_columna'] == 10){
			$row_imput['input']	= 
			"<input 	name		='1$txt_nombre_columna' 
						type		='text' 
						$readonly
						$acum_txt_js_onblur
						class		='combo' 
						value		='adicional' 
						size		='3'
						maxlength	='3'/>
			<input 		name		='$txt_nombre_columna' 
						type		='text' 
						$readonly
						$acum_txt_js_onblur
						class		='combo' 
						value		='value_columna' 
						size		='7'
						maxlength	='$max_length'/>						
						";
		}
		//=== Evalua datos tipo DATETIME CON FORMATO >>>
		else if($row_info_columna['cod_tipo_dato_columna'] == 8){
			

			
			if($readonly){

				$row_imput['input']	= 
				"<input 	name		='$txt_nombre_columna' 
							$required 
							type		='text' class='combo'  
							value		='value_columna' 
							$readonly
							$acum_txt_js_onblur
							size		='15' />";
				
			}else{

							
				$row_imput['input']	= 
				"<input 	name		='$txt_nombre_columna'  
							$required
							type		='text' class='combo'  
							id			='$txt_nombre_columna'
							value		='value_columna' 
							$readonly
							size		='20' />
							
				<script>
				$(function(){
					$('#$txt_nombre_columna').datetimepicker({
						changeMonth: true, // Muestra comobobox para seleccionar el mes
						//changeYear:  true, // Muestra comobobox para seleccionar el año
						yearRange: 'c-100:c+10',
						//hourGrid: 4,
						//secondGrid: 10, 
						//minuteGrid: 10,
						//timeFormat: 'H:mm:ss',
						timeFormat: 'hh:mm tt',
						controlType: 'select'
					
					});
					
				})
				
				</script>			
				";
			}
		}
		//=== Evalua datos combos con VENTANA EMERGENTE >>>
		else if($row_info_columna['cod_tipo_dato_columna'] == 7){
			
			//=== Divide el nombre por si acaso viene con algun alias
			$array_nombre = explode("-",$txt_nombre_columna);
			if($array_nombre[1])  {
				
				$tmp_tabla 		= $array_nombre[0]."-";
				$tmp_columna 	= $array_nombre[1];
			}
			else{
				$tmp_tabla 		= NULL;
				$tmp_columna 	= $array_nombre[0];
			}
			
			/*if($readonly)
				$row_imput['input']	= 
				"<input type		='text' 
						class		='combo' 
						$readonly
						id			='$txt_nombre_columna' 
						name		='$txt_nombre_columna' 
						value		='value_columna' 
						size		='3' /><input 	
						class		='combo' 
						name		='txt_$txt_nombre_columna' 
						id			='txt_$txt_nombre_columna' 
						type		='text' 
						value		='txt_value_columna' 
						size		='30' 
						readonly	='true' />";
			else 			
				$row_imput['input']	= 
				"<input type		='text' 
						class		='combo' 
						$readonly
						name		='$txt_nombre_columna' 
						id			='$txt_nombre_columna' 
						onBlur		='ver_valor_iframe(this)'
						value		='value_columna' 
						size		='3' /><input 	
						class		='combo' 
						name		='txt_$txt_nombre_columna' 
						id			='txt_$txt_nombre_columna' 
						type		='text' 
						value		='txt_value_columna' 
						size		='30' 
						readonly	='true' /><input 	class		='contenido'  
						name		='button2' 
						type		='button' 
						onclick		=".'"ver_lista_valor('.$cod_ventana_emergente.','."'$txt_nombre_columna')".'"'." value='Call' />";*/
						
			if($readonly){
				$row_imput['input']	= 
				"<input type		='text' 
						class		='combo' 
						$readonly
						$required
						id			='$txt_nombre_columna' 
						name		='$txt_nombre_columna' 
						value		='value_columna' 
						size		='3' 
				/>
						
						<input 	
						class		='combo' 
						name		='$tmp_tabla"."txt_$tmp_columna' 
						id			='$tmp_tabla"."txt_$tmp_columna' 
						type		='text' 
						value		='txt_value_columna' 
						size		='30' 
						readonly	='true' />";
		
			}else{

				$row_imput['input']	= 
				"<input type				='text' 
						class				='combo' 
						$required
						$readonly
						name				='$txt_nombre_columna' 
						id					='$txt_nombre_columna' 
						onBlur				=''
						autocomplete 		= 'off'
						value				='value_columna'
						data-cod_columna 	= '".$row_info_columna['cod_columna_tabla']."' 
						onKeyUp		=\"ver_valor_script_columna(this,event);\"
						size		='9' 
				 	/> 
						
					<input 	
						class		='combo' 
						name		='txt_$txt_nombre_columna' 
						id			='txt_$txt_nombre_columna' 
						type		='text' 
						value		='txt_value_columna' 
						size		='18' 
						readonly	='true' />
						
						<input 	class		='contenido'  
						name		='button2' 
						type		='button' 
						onclick		=".'"ver_lista_valor('.$cod_ventana_emergente.','."'$tmp_tabla"."$tmp_columna')".'"'." value='Buscar' />
						
						<div id=\"content_result_".$row_info_columna['cod_columna_tabla']."\" style='display:none;'></div>
						
						";
			}
		}
		//=== Evalua datos tipo TEXT >>>
		else if($row_info_columna['cod_tipo_dato_columna'] == 6){
			$row_imput['input']	= 
			"<textarea 	class	='combo'
						name	='$txt_nombre_columna' 
						$required
						id		='$txt_nombre_columna' 
						cols	='30' 
						size		='30'
						$readonly		
						$acum_txt_js_onblur					
						>value_columna</textarea>
			<script> CKEDITOR.replace( '$txt_nombre_columna',{skin : 'office2003'});</script>												
						";
		}
		//=== Evalua datos tipo NUMERIC SIN FORMATO >>>
		else if($row_info_columna['cod_tipo_dato_columna'] == 5){
			$row_imput['input']	= 
			"<input 	type		='text' 
						class		='combo' 
						autocomplete='off'
						$required
						size		='22'
						name		='$txt_nombre_columna'  
						placeholder	= 'Campo Num&eacute;rico'
						value		='value_columna'
						$readonly
						$acum_txt_js_onblur
						maxlength	='$max_length'/>
						
				<script>			
					$('input[name=\"$txt_nombre_columna\"]').keyup(function(){

						this.value = (this.value + '').replace(/[^0-9+\-Ee.]/g, '');
					})
				</script>
						
			";
		}
		//=== Evalua datos tipo LISTBOX >>>
		else if($row_info_columna['cod_tipo_dato_columna'] == 4){
			$id 					= "id='".$txt_nombre_columna."'";
			$class					= "class='combo'";
			$opcion_blanco			= "<option value='-1' selected='selected'></option>";
			if($txt_js_onblur){ 	$on_change = "onchange=$txt_js_onblur";}
			else{				$on_change = "";}		
			if($readonly){
				$div_abre		= '<div style="position:relative; width:; height:;">';
				$div_cierra		= '</div>';
				$div_bloquea	= '<div style="z-index:0;  position:absolute; width:300px; height:26px;  opacity:.6;"></div>';
				$on_change 		= "onClick=\"alert('Acceso Denegado')\"";
				$style			= 'style="color: #933;  background-color: #ffc;"';
			}			
			
			if($ind_multiple == true){	
				$id 				= NULL;
				$sym_multiple 		= "[]";
				$class				= "class='multiple_select'";
				$opcion_blanco		= "";
			}else{
				$sym_multiple 	= "";
				$multiple		= NULL;
			}
				
			$row_imput['cursor']	= $db->consultar($txt_script_cursor);
			$row_imput['input']	= 	$div_abre.$div_bloquea.'
				<select '.$class.' '.$required.' '.$on_change.' '.$style.' '.$multiple.' '.$readonly.'
							name="'.$txt_nombre_columna.$sym_multiple.'" '.$id.'  id="'.$txt_nombre_columna.'" >
							'.$opcion_blanco.'
							value_columna
				</select>
			
				'.$div_cierra.'
			';
		
			if($ind_multiple == true){
				$row_imput['input']	.=	' 
					<input type="hidden" name="'.$txt_nombre_columna.$sym_multiple.'" value="" />
				
					<script>
					$(function(){
						$(\'#'.$txt_nombre_columna.'\').multiselect({
							click: function(event, ui){
								//alert("presiono");
								//$callback.text(ui.value + \' \' + (ui.checked ? \'checked\' : \'unchecked\') );
							}
						});
					});
				</script>			';
			}
			
		
			
		}
		//=== Evalua datos tipo DATE CON FORMATO >>>
		else if($row_info_columna['cod_tipo_dato_columna'] == 3){

			if($readonly){

				$row_imput['input']	= 
				"<input 	name		='$txt_nombre_columna'  
							$required
							type		='text' class='combo'  
							$acum_txt_js_onblur
							value		='value_columna' 
							$readonly
							size		='10' />";
			}else {
				$row_imput['input']	= 
				"<input 	name		='$txt_nombre_columna'
							$required  
							type		='text' 
							class		= 'datepicker'
							id			='$txt_nombre_columna'
							value		='value_columna' 
							$readonly
							size		='10' />
				
				<script>
					$(function(){
						$('#$txt_nombre_columna').datepicker({
							changeMonth: true, // Muestra comobobox para seleccionar el mes
							changeYear:  true, // Muestra comobobox para seleccionar el aÃ±o
							yearRange: 'c-100:c+10',
							//minDate: new Date(2010, 11, 20, 8, 30), // para poner un minimo de fecha
							//minDate: 0,
							dateFormat: 'yy-mm-dd'
						
						});
					})
				
				</script>
				
				";
			}
		}
		//=== Evalua datos tipo NUMERIC CON FORMATO >>>
		else if($row_info_columna['cod_tipo_dato_columna'] == 2){
			$row_imput['input']	= 
			"<input 	type		='text' 
						class		='combo' 
						$required
						autocomplete='off'
						name		='$txt_nombre_columna'  
						placeholder = 'Campo Num&eacute;rico'
						value		='value_columna'
						size		='22'
						$readonly
						maxlength	='$max_length'
						onkeyup		='comportamiento_combo_numerico(this,2,event)' 
						onblur		='comportamiento_combo_numerico(this,2,event);$txt_js_onblur'
						onfocus		='comportamiento_combo_numerico(this,2,event)' />";
		}
		//=== Evalua datos tipo VARCHAR >>>
		else if($row_info_columna['cod_tipo_dato_columna'] == 1){
			$row_imput['input']	= 
			"<input 	name		='$txt_nombre_columna' 
						type		='text' 
						$required
						$readonly
						$acum_txt_js_onblur
						
						class		='combo' 
						value		='value_columna' 
						size		='22'
						maxlength	='$max_length'/>";
		}
		//=== Evalua datos tipo VARCHAR SIN NUMEROS >>>
		else if($row_info_columna['cod_tipo_dato_columna'] == 15){
			$row_imput['input']	= 
			"<input 	name		='$txt_nombre_columna' 
						type		='text' 
						$readonly
						$required
						$acum_txt_js_onblur
						class		='combo' 
						value		='value_columna' 
						size		='22'
						maxlength	='$max_length'/>";
		}
		//=== Evalua datos tipo PASSWORD >>>
		else if($row_info_columna['cod_tipo_dato_columna'] == 16){
			$row_imput['input']	= 
			"<input 	name		='$txt_nombre_columna' 
						type		='password'
						$readonly
						$required
						$acum_txt_js_onblur
						class		='combo' 
						value		='value_columna' 
						size		='22'
						maxlength	='$max_length'/>";
		}
		
		//=== Evalua datos tipo AUTOCOMLETE (utilizando ajax) >>>
		else if($row_info_columna['cod_tipo_dato_columna'] == 17){
			
			if($ind_hidden == true)	$type = 'hidden';
			else 					$type='text';
			
			$row_imput['input']	= 
			"<input 	name		='$txt_nombre_columna' 
						id			='$txt_nombre_columna' 
						type		='$type'
						$txt_placeholder
						$txt_js_onkeyup
						
						$readonly
						$acum_txt_js_onblur
						class		='$estilo_input' 
						value		='value_columna' 
						size		='22'
						$max_length/>
						
			<div id='autocomplete_$txt_nombre_columna'></div>
			
			";

		}
		
		//=== Evalua datos tipo SELECT  CON BUSCADOR >>>
		else if($row_info_columna['cod_tipo_dato_columna'] == 19){
			
			
			if($txt_js_onblur) 	$on_change = "onchange=$txt_js_onblur";
			else				$on_change = "";
			if($readonly) 	$on_change = "onClick=\"alert('Acceso Denegado')\"";
			if($multiple){	$ind_multiple = "[]";}else{$ind_multiple = "";}
			
			$cod_columna_tabla = $row_info_columna['cod_columna_tabla'];
			
			$row_imput['cursor']	= $db->consultar($txt_script_cursor);
			/*$row_imput['input']	= 
			"<select class='' $required $on_change $multiple name='$txt_nombre_columna$ind_multiple' id='$txt_nombre_columna' >
			 <option value=''></option>
			value_columna
			</select>
			
			<script>
			$(function(){
				$('#$txt_nombre_columna').select2({
					placeholder: '$txt_placeholder',
				    allowClear: true,
					dropdownAutoWidth: true
				});	
			
			
			
					
			})
			
			</script>
			
			";*/
			
			if(!$num_zise_input || $num_zise_input == 0){
				$num_zise_input = '\'element\'';
				 
			}
			
			
			$row_imput['input']	= 
			"
			
			<input 	type='hidden' 
					id='$txt_nombre_columna' name='$txt_nombre_columna' 
					class='' 
					value='value_columna' 
					$required
					data-placeholder='$txt_placeholder'
			>			
 
			
			<script>
			$(function(){
				
				
				$('#".$txt_nombre_columna."').select2({
						minimumInputLength : 0,
						allowClear: true,
						addSelectedTitle: true,
						width: ".$num_zise_input.",
						/*formatSelection: function(item) {
					        // Debugging -- open the developer console to see what you can access from the item object
							//alert(item.text);
							var text_this = item.text;
							alert($(this).find('.select2-chose').length);
							$(this).find('.select2-chose').attr('title',text_this);

					       return item.text;
					       // return '<strong>' + item.id + '</strong>';
					    },*/
						
												
						ajax: {
						  url: '../consulta/consulta_script_columna.php',
						  dataType: 'json',
						  data: function (term, page) {
							return {
							  term: term,
							  cod_columna_tabla: ".$cod_columna_tabla."
							};
						  },
						  results: function (data, page) {
							
							return { results: data.results };
						  }
						},
						initSelection: function(element, callback) {
							// revisa si el elemento tiene un valor inicial o por default y lo carga despues de cargar el plugin
							// element es el elemento del dom al que se le aplico el plugin select2 y callback la funcion a llamar despues de buscar el valor

							return $.getJSON('../consulta/consulta_script_columna.php?cod_columna_tabla=$cod_columna_tabla&id=' + (element.val()), null, function(data) {
				
									return callback(data);
				
							});
						}
					}).on('select2-open', function() {
					    	//alert('open');
							$('body').unbind('keyup',funcion_teclas); // frena el funcionamiento de teclas del body
							var a = $('#s2id_".$txt_nombre_columna."').find('.select2-chosen');
							$(a).tooltip().tooltip('close');

				     }).on('select2-selecting', function(e) {
				         //alert('selecting val=e.val choice=e.object.text');
						 //$(this).blur();
					});
					
					
				});
			
			</script>	";		
			
			

		}
		

		
		return $row_imput;
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene todos los registros activos de la tabla columna_tabla_autonoma
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function f_get_imput($cod_tabla,$ind_registro=NULL){
		global $db;
		//Obtiene las columnas de la tabla >>>
		$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		cod_tabla			= $cod_tabla
		and			ind_visible_form = 1
		order by 	num_orden_insert desc";

		$cursor_columnas		= $db->consultar($query);
		$num_registros 			= $db->num_registros($cursor_columnas);
		$row_imput				= array();
		for($i=0; $i<$num_registros; $i++){
			$row_info_columna								= $db->sacar_registro($cursor_columnas,$i);
			$txt_nombre_columna								= $row_info_columna['txt_nombre'];
			$row_imput[$txt_nombre_columna] 				= array();
			$row_imput[$txt_nombre_columna]					= $this->f_convertir_tipo_imput($row_info_columna,$ind_registro);
			// Alias que debe retornar
			$txt_alias = $row_info_columna['txt_alias'];

			//$txt_alias = utf8_encode($txt_alias);
			//$txt_alias = utf8_decode($txt_alias);
			
			
			if($row_info_columna['ind_pk'] == 0){
				if($row_info_columna['ind_not_null']){
					$row_imput[$txt_nombre_columna]['txt_alias']= $txt_alias." (&#8226;)"; 
				}else{

					$row_imput[$txt_nombre_columna]['txt_alias']= $txt_alias;
				}
			}
			if(!$row_imput[$txt_nombre_columna]['cursor'])
				$row_imput[$txt_nombre_columna]['cursor']		= NULL;// Para borrar basura
		}	


		return $row_imput;
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene todos los registros activos de la tabla columna_tabla_autonoma
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
  	function f_get_imputs_formulario($cod_tabla_maestro, $cod_tabla_detalle, $cod_navegacion,$ind_registro=NULL){
		global $db;
		//Obtiene las columnas de la tabla >>>
		$cursor_columnas		= $this->f_get_columnas_formulario($cod_tabla_maestro,$cod_navegacion,$cod_tabla_detalle,$ind_registro);
		$num_registros 			= $db->num_registros($cursor_columnas);
		$row_imput				= array();

		for($i=0; $i<$num_registros; $i++){
			$row_info_columna								= $db->sacar_registro($cursor_columnas,$i);
			$txt_nombre_columna								= $row_info_columna['txt_nombre'];
			$row_imput[$txt_nombre_columna] 				= array();
			$row_imput[$txt_nombre_columna]					= $this->f_convertir_tipo_imput($row_info_columna,$ind_registro);
			// Alias que debe retornar
			if($row_info_columna['ind_pk'] == 0){
				if($row_info_columna['ind_not_null']) 
					$row_imput[$txt_nombre_columna]['txt_alias']= $row_info_columna['txt_alias']." &#8226;"; 
				else
					$row_imput[$txt_nombre_columna]['txt_alias']= $row_info_columna['txt_alias']; 
			}
			if(!$row_imput[$txt_nombre_columna]['cursor'])
				$row_imput[$txt_nombre_columna]['cursor']		= NULL;// Para borrar basura
		}	
		return $row_imput;
	}



	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene los campos que se usan como filtro de un grupo de datos
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function f_get_imput_filtro($cod_tabla,$ind_registro = NULL,$cod_reporte_tabla = NULL){
		global $db;
		
		
		//Obtiene las columnas de la tabla >>>
		/*$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		ind_filtro	= 1
		and			cod_tabla	= $cod_tabla
		order by 	num_orden_insert desc";
		$cursor_columnas		= $db->consultar($query);
		$num_registros 			= $db->num_registros($cursor_columnas);
		$row_imput				= array();*/
		
		if($cod_reporte_tabla){
			$query ="
			select 		cta.* ,
						ta.txt_nombre as txt_tabla
			from 		filtro_reporte fr,
						columna_tabla_autonoma cta,
						tabla_autonoma ta
			where		ind_activo	= 1
			and			cta.cod_columna_tabla 	= fr.cod_columna_tabla
			and			cta.cod_tabla			= ta.cod_tabla
			and			cod_reporte_tabla		= $cod_reporte_tabla
			order 		by fr.num_orden desc";
			
			$cursor_columnas		= $db->consultar($query);
			$num_registros			= $db->num_registros($cursor_columnas);
		}
		//==== usado para cuando los filtros son de una sola tabla >>>		
		if($num_registros==0){
			$query ="
			select 		* 
			from 		columna_tabla_autonoma
			where		ind_filtro	= 1
			and			cod_tabla	= $cod_tabla
			order by 	num_orden_insert desc";
			$cursor_columnas		= $db->consultar($query);
			$num_registros			= $db->num_registros($cursor_columnas);
		}


		for($i=0; $i<$num_registros; $i++){
			$row_info_columna								= $db->sacar_registro($cursor_columnas,$i);
	
			//=== Para poner alias para varias tablas >>>
			if($row_info_columna['txt_tabla']){
				$txt_name_imput	= $row_info_columna['txt_tabla']."-".$row_info_columna['txt_nombre'];
			}else{
				$txt_name_imput	= $row_info_columna['txt_nombre'];
			}

			$txt_nombre_columna								= $row_info_columna['txt_nombre'];
			$row_imput[$txt_nombre_columna] 				= array();
			$row_imput[$txt_nombre_columna]					= $this->f_convertir_tipo_imput($row_info_columna,$ind_registro);
			// Muestra el campo de pk
			if($row_info_columna['ind_pk'] == 1){
				$row_imput[$txt_nombre_columna]['input']	= 
				"<input 	type		='text' 
							class		='combo' 
							name		='$txt_name_imput'  
							value		='value_columna'/>";
			}					
			//=== Evalua datos tipo DATE CON FORMATO, como es un filtro lo evalua desde la fehca inicial hasta la final >>>
			else if($row_info_columna['cod_tipo_dato_columna'] == 3 || $row_info_columna['cod_tipo_dato_columna'] == 8){
				$row_imput[$txt_nombre_columna]['input']	= 
				'<input 	name		="'.$txt_name_imput.'_inicial"  
							id ="'.$txt_name_imput.'_inicial"
							type		="text"
							class		="input_4"  
							style		="width: 25% !important;"
							value		="value_inicial_columna" 
							size		="7" /> a 
							
							
							<input 	name="'.$txt_name_imput.'_final" 
							 		id ="'.$txt_name_imput.'_final"
									type		="text" 
									style		="width: 25% !important;"
									class		="input_4"  
									value		="value_final_columna" 
									size		="7" 
									
						/> a&ntilde;o-mes-d&iacute;a  
								<img src="../../imagenes/sistema/clean.png" width="15px"  style="cursor:pointer;" 
										id="clear_'.$txt_name_imput.'" >
							
							
							<script>
							$(function () {
							
								/*$("#'.$txt_name_imput.'_inicial").datepicker({
									onClose: function (selectedDate) {
										$("#'.$txt_name_imput.'_final").datepicker("option", "minDate", selectedDate);
									}
								});
	
								$("#'.$txt_name_imput.'_final").datepicker({
									onClose: function (selectedDate) {
										$("#'.$txt_name_imput.'_inicial").datepicker("option", "maxDate", selectedDate);
									}
								});*/
								
								var dates = $("input[id$=\''.$txt_name_imput.'_inicial\'], input[id$=\''.$txt_name_imput.'_final\']").datepicker({
								onSelect: function(selectedDate) {
									var option = this.id == $("input[id$=\''.$txt_name_imput.'_inicial\']")[0].id ? "minDate" : "maxDate",
										instance = $(this).data("datepicker"),
										date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
									dates.not(this).datepicker("option", option, date);
								}
							});
							
							$("#clear_'.$txt_name_imput.'").on("click", function(){
								dates.val(\'\');
								dates.datepicker( "option" , {
									minDate: null,
									maxDate: null} );
							});
								
								
							});
							
							
							
							
							
							</script>
							
							
							';
			}
			
			
			$row_imput[$txt_nombre_columna]['txt_alias']= $row_info_columna['txt_alias'];
			

			 
			if(!$row_imput[$txt_nombre_columna]['cursor'])
				$row_imput[$txt_nombre_columna]['cursor']		= NULL;// Para borrar basura
		}	
		return $row_imput;
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene los campos que se usan como filtro de un grupo de datos
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function f_get_imput_filtro_maestro_detalle($cod_tabla, $cod_tabla_detalle,$ind_registro=NULL){
		global $db;
		//Obtiene las columnas de la tabla >>>
		$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		ind_filtro	= 1
		and			cod_tabla	in($cod_tabla,$cod_tabla_detalle)
		order by 	num_orden_insert desc";

		$cursor_columnas		= $db->consultar($query);
		$num_registros 			= $db->num_registros($cursor_columnas);
		$row_imput				= array();


		for($i=0; $i<$num_registros; $i++){
			$row_info_columna								= $db->sacar_registro($cursor_columnas,$i);
			$txt_nombre_columna								= $row_info_columna['txt_nombre'];
			$txt_name_imput									= $txt_nombre_columna;
			$row_imput[$txt_nombre_columna] 				= array();
			$row_imput[$txt_nombre_columna]					= $this->f_convertir_tipo_imput($row_info_columna,$ind_registro);
			// Muestra el campo de pk
			if($row_info_columna['ind_pk'] == 1){
				if($row_info_columna['cod_tipo_dato_columna'] == 7){
					$cod_ventana_emergente = $row_info_columna['cod_ventana_emergente'];
					$row_imput[$txt_nombre_columna]['input']	= 
					"<input type		='text' 
							class		='combo' 
							$readonly
							name		='$txt_nombre_columna' 
							id			='$txt_nombre_columna' 
							onBlur		='ver_valor_iframe(this)'
							value		='value_columna' 
							size		='3' /><input 	
							class		='combo' 
							name		='txt_$txt_nombre_columna' 
							id			='txt_$txt_nombre_columna' 
							type		='text' 
							value		='txt_value_columna' 
							size		='30' 
							readonly	='true' /><input 	class		='contenido'  
							name		='button2' 
							type		='button' 
							onclick		=".'"ver_lista_valor('.$cod_ventana_emergente.','."'$txt_nombre_columna')".'"'." value='Call' />";
				}else{
					$row_imput[$txt_nombre_columna]['input']	= 
					"<input 	type		='text' 
								class		='combo' 
								size		='22'
								name		='$txt_nombre_columna'  
								value		='value_columna'/>";
				}
							
			}					
			//=== Evalua datos tipo DATE CON FORMATO, como es un filtro lo evalua desde la fehca inicial hasta la final >>>
			else if($row_info_columna['cod_tipo_dato_columna'] == 3 || $row_info_columna['cod_tipo_dato_columna'] == 8){
				$row_imput[$txt_nombre_columna]['input']	= 
				'<input 	name		="'.$txt_name_imput.'_inicial"  
							id ="'.$txt_name_imput.'_inicial"
							type		="text"
							class		="input_4"  
							style		="width: 25% !important;"
							value		="value_inicial_columna" 
							size		="7" /> a 
							
							
							<input 	name="'.$txt_name_imput.'_final" 
							 		id ="'.$txt_name_imput.'_final"
									type		="text" 
									style		="width: 25% !important;"
									class		="input_4"  
									value		="value_final_columna" 
									size		="7" 
									
						/> a&ntilde;o-mes-d&iacute;a  
								<img src="../../imagenes/sistema/clean.png" width="12px"  style="cursor:pointer;" 
										id="clear_'.$txt_name_imput.'" >
							
							
							<script>
							$(function () {
							
								/*$("#'.$txt_name_imput.'_inicial").datepicker({
									onClose: function (selectedDate) {
										$("#'.$txt_name_imput.'_final").datepicker("option", "minDate", selectedDate);
									}
								});
	
								$("#'.$txt_name_imput.'_final").datepicker({
									onClose: function (selectedDate) {
										$("#'.$txt_name_imput.'_inicial").datepicker("option", "maxDate", selectedDate);
									}
								});*/
								
								var dates = $("input[id$=\''.$txt_name_imput.'_inicial\'], input[id$=\''.$txt_name_imput.'_final\']").datepicker({
								onSelect: function(selectedDate) {
									var option = this.id == $("input[id$=\''.$txt_name_imput.'_inicial\']")[0].id ? "minDate" : "maxDate",
										instance = $(this).data("datepicker"),
										date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
									dates.not(this).datepicker("option", option, date);
								}
							});
							
							$("#clear_'.$txt_name_imput.'").on("click", function(){
								dates.val(\'\');
																
								dates.datepicker( "option" , {
									minDate: null,
									maxDate: null} );
							});
								
								
							});
							
							
							
							
							
							</script>
							
							
							';
			}
			$row_imput[$txt_nombre_columna]['txt_alias']= $row_info_columna['txt_alias']; 
			if(!$row_imput[$txt_nombre_columna]['cursor'])
				$row_imput[$txt_nombre_columna]['cursor']		= NULL;// Para borrar basura
		}	
		return $row_imput;
		
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Remplaza los valores del imput al refrescar pantalla
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	$row_imputs		Vector con los imputs que se mostraran en pantalla
	$val_post		Valores que quedaron en el post
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function f_remplazar_valor_imput_filtro(	
							$row_tabla_autonoma		, 
							$row_imputs				, 
							$val_post				,
							$num_max_registros		, 
							$cod_tabla_detalle=NULL	,
							$cod_reporte_tabla=NULL
							){
		global $db;
		$obj_listbox			= new obj_listbox;
		$reporte_tabla			= new reporte_tabla;		
		$txt_nombre_tabla		= $row_tabla_autonoma['txt_nombre'];
		$cod_tabla				= $row_tabla_autonoma['cod_tabla'];
		if($cod_tabla_detalle)	$cod_tabla="$cod_tabla,$cod_tabla_detalle";


		//=== Consulta para recorrer cada columna >>>
		if($cod_reporte_tabla){
			
			$query ="
			select 		cta.*,
						ta.txt_nombre as txt_tabla 
			from 		filtro_reporte fr,
						columna_tabla_autonoma cta,
						tabla_autonoma ta
			where		ind_activo	= 1
			and			cta.cod_columna_tabla 	= fr.cod_columna_tabla
			and			cta.cod_tabla			= ta.cod_tabla
			and			cod_reporte_tabla		= $cod_reporte_tabla
			order 		by fr.num_orden asc";
			$cursor_columnas		= $db->consultar($query);
			$num_registros			= $db->num_registros($cursor_columnas);
		}
		if($num_registros==0){
			
			$query ="
			select 		* 
			from 		columna_tabla_autonoma
			where		ind_filtro	= 1
			and			cod_tabla	in ( $cod_tabla)
			order by 	num_orden_insert desc";
			
			$cursor_columnas		= $db->consultar($query);
			$num_registros 			= $db->num_registros($cursor_columnas);
		}		
		
		

		//=== Consulta para recorrer cada columna >>>
		/*$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		ind_filtro			= 	1
		and			cod_tabla	in($cod_tabla)
		order by 	num_orden_insert";
		$cursor_columnas		= $db->consultar($query);
		$num_registros 			= $db->num_registros($cursor_columnas);*/
		

		for($i=0; $i<$num_registros; $i++){
			$row_info_columna						= $db->sacar_registro($cursor_columnas,$i);
			//=== Para poner alias para varias tablas >>>
			if($row_info_columna['txt_tabla']){
				$txt_name_imput	= $row_info_columna['txt_tabla']."-".$row_info_columna['txt_nombre'];
			}else{
				$txt_name_imput	= $row_info_columna['txt_nombre'];
			}
			
			$txt_nombre_columna						= $row_info_columna['txt_nombre'];
			$cod_tipo_dato_columna					= $row_info_columna['cod_tipo_dato_columna'];
			$value									= $val_post[$txt_name_imput];
			
			if( $row_info_columna['ind_pk']==1 && isset($val_post['reg_seleccionado']) && $cant_pk==0){
				if(is_array($val_post['reg_seleccionado']))$value		= implode(",",$val_post['reg_seleccionado']);
				$cant_pk++;
			}
			
			//== Tipo de dato list box  MULTIPLE >>>
			if($row_imputs[$txt_nombre_columna]['cursor'] && $row_info_columna['ind_input_multiple'] == 1){
				if(!is_array($value))$value = explode(',',$value);
				$value=$obj_listbox->f_crear_lista_multiple($row_imputs[$txt_nombre_columna]['cursor'], $value, 35);
			
			}//== Tipo de dato list box ESTANDAR >>> 
			else if($row_imputs[$txt_nombre_columna]['cursor']){ 
				$value=$obj_listbox->f_crear_lista_limite_caracteres($row_imputs[$txt_nombre_columna]['cursor'], $value, 35);
			}
			


			//== si una LISTA DE VALOR actualiza el campo de texto>>>
			if($row_info_columna['cod_tipo_dato_columna']==7 ){
				//== busca el quiery que trae el nombre >>>
				if($value){

					$query		= $row_info_columna['txt_script_lista_valor']; 
					$query		= str_replace("'%value_columna%'","'%$value%'",$query);
					$query		= str_replace("value_columna","'$value'",$query);

					/*$query		= str_replace("like '%'","like '%",$query);
					$query		= str_replace("'%'","%'",$query);*/
					$row_nmbre	= $db->consultar_registro($query);
				
					$info_nmbre	= $row_nmbre['txt_nombre']; 
		
					
				}else $info_nmbre = NULL;
				
				
				
				//== Remplaza el campo de nombre >>>				
				$row_imputs[$txt_nombre_columna]['input']=
				str_replace("txt_value_columna",$info_nmbre,$row_imputs[$txt_nombre_columna]['input']);
				
				
				
				
				
			  	

			}

			//== Evalua el tipo DATE para tener fecha inicial y final >>>
			if($cod_tipo_dato_columna == 3 || $row_info_columna['cod_tipo_dato_columna']==8){
				$value_inicial		= $val_post[$txt_name_imput."_inicial"];
				$value_final		= $val_post[$txt_name_imput."_final"];
				$row_imputs[$txt_nombre_columna]['input']= 
				str_replace("value_inicial_columna",$value_inicial,$row_imputs[$txt_nombre_columna]['input']);	
				$row_imputs[$txt_nombre_columna]['input']= 
				str_replace("value_final_columna",$value_final,$row_imputs[$txt_nombre_columna]['input']);	
			}
			//== Tipo de dato estandar >>>
			$row_imputs[$txt_nombre_columna]['input']= 
			str_replace("value_columna",$value,$row_imputs[$txt_nombre_columna]['input']);	
			
		}	

		//== Imput final que indicara la cantidad maxima de registros por pantallaso>>>
		/*$row_imputs['num_max_registros']['txt_alias'] 	= "NUM_REGISTROS";
		$row_imputs['num_max_registros']['cursor'] 		= NULL;
		$row_imputs['num_max_registros']['input'] 		= 
		"<input name='num_max_registros' type='text' class='combo' size=22 value='$num_max_registros' />";*/

		//== Imput para traer la consulta que generara el tipo de reporte o>>>
		$cursor_reporte_tabla		= 	$reporte_tabla->f_get_activos($cod_tabla,$val_post['cod_usuario']);		
		$datos_reporte_tabla		=	$obj_listbox->f_crear_lista_limite_caracteres($cursor_reporte_tabla, $val_post['cod_reporte_tabla'], 35);
		if($datos_reporte_tabla){
			$row_imputs['cod_reporte_tabla']['txt_alias'] 	= 	"REPORTE";
			$row_imputs['cod_reporte_tabla']['cursor'] 		= 	NULL;
			$row_imputs['cod_reporte_tabla']['input'] 		= 
			"<select class=combo  id='cod_reporte_tabla' name='cod_reporte_tabla'>$datos_reporte_tabla</select>";
			
			//print_r($row_imputs['cod_reporte_tabla']['input']);
			/*$row_imputs['cod_reporte_tabla']['input'] 		= 
			"<select class=combo  name='cod_reporte_tabla'><option value='-1' selected='selected'></option>$datos_reporte_tabla</select>";*/
			
		}
		return $row_imputs;
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Metodo para limpiar las variables $_POST asociadas a las columnas de una tabla
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$row_tabla_autonoma	nombre de la tabla, codigo y demas datos
	$val_post			vector $_POST
	$ind_conservar_pk	indica si la variable pk no la debe limpiar
	$row_imputs		Vector con los imputs que se mostraran en pantalla
	$val_post		Valores que quedaron en el post
	
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function f_limpiar_variables_post($row_tabla_autonoma, $val_post,$ind_conservar_pk,$cod_tabla_detalle = NULL){
		global $db;
		$obj_listbox			= new obj_listbox;
		$txt_nombre_tabla		= $row_tabla_autonoma['txt_nombre'];
		$cod_tabla				= $row_tabla_autonoma['cod_tabla'];
		
		if($cod_tabla_detalle) $cod_tabla = "$cod_tabla,$cod_tabla_detalle";//evalua si esta limpiando un maestro de detalle

		//=== Consulta para recorrer cada columna >>>
		$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		ind_filtro			= 	1
		and			cod_tabla	in($cod_tabla)
		order by 	num_orden_insert";
		$cursor_columnas		= $db->consultar($query);
		$num_registros 			= $db->num_registros($cursor_columnas);
		for($i=0; $i<$num_registros; $i++){
			$row_info_columna				= $db->sacar_registro($cursor_columnas,$i);
			$txt_nombre_columna				= $row_info_columna['txt_nombre'];
			$ind_pk							= $row_info_columna['ind_pk'];
			//=== Limpia el campo escepto el PK si a sido restringido
			if($ind_pk && $ind_conservar_pk) NULL;
			else 
			$val_post[$txt_nombre_columna] = NULL;

		}	
		return $val_post;
	}
	
	
	/*===== 20140110 ====================================D E C K===>>>>
	DESCRIPCION: 	Metodo para consultar los reportes para pasar la consulta al 
					proceso que genera el excel
	AUTOR:			Luis Prieto
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function f_consultar_reportes(
			$cod_tabla				,
			$arr_post				,
			$ord_por				,
			$num_max_registros	= 20,
			$num_pagina			= 0
	){
		global $db;
		
		$condicion 					= 	array();
		$sis_genericos				= 	new sis_genericos;
		$reporte_tabla				=	new reporte_tabla;
		//=== Indica la paginacion para que no se muestren todos los registros en un solo pantallaso>>>
		if($num_pagina>0)	$num_pagina 	= $num_pagina-1;
		if(!$num_pagina) 	$limite_inicial = 0;
		else				$limite_inicial = $num_pagina*$num_max_registros;
		$limite_final 		= $limite_inicial+ $num_max_registros;
		
		//Obtiene las columnas de la tabla >>>
		$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		ind_filtro			= 1
		and			cod_tabla			= $cod_tabla
		order by 	num_orden_insert";

		$cursor_columnas		= $db->consultar($query);
		$num_registros 			= $db->num_registros($cursor_columnas);
		$row_imput				= array();
		for($i=0; $i<$num_registros; $i++){
			$row_info_columna								= $db->sacar_registro($cursor_columnas,$i);
			$txt_nombre_columna								= $row_info_columna['txt_nombre'];
			$txt_script_cursor								= $row_info_columna['txt_script_cursor'];
			$value											= $arr_post[$txt_nombre_columna];

			//=== Evita confusion entre el NULL y el cero>>>
			if($value===0) $value="0";
			//=== Evalua datos tipo NUMERIC SIN FORMATO >>>
			if(($row_info_columna['cod_tipo_dato_columna'] == 5 || $row_info_columna['cod_tipo_dato_columna'] == 7) && $value != NULL)
					array_push($condicion,"t.$txt_nombre_columna in($value)");
			//=== Evalua datos tipo LISTBOX >>>
			else if($row_info_columna['cod_tipo_dato_columna'] == 4 && $value !=-1 && $value !== NULL){
				if($value==0) $value ="0";
				array_push($condicion,"t.$txt_nombre_columna =$value");
			}			
			//=== Evalua datos tipo DATE CON FORMATO, como es un filtro lo evalua desde la fehca inicial hasta la final >>>
			else if($row_info_columna['cod_tipo_dato_columna'] == 3 || $row_info_columna['cod_tipo_dato_columna'] == 8){
				$value1	= $arr_post[$txt_nombre_columna."_inicial"];
				$value2	= $arr_post[$txt_nombre_columna."_final"];
				if($value1){
					array_push($condicion,"t.$txt_nombre_columna >='$value1 00:00:00'");
				}
				if($value2){
					array_push($condicion,"t.$txt_nombre_columna <='$value2 23:59:59'");
				}
			}
			//=== Evalua datos tipo VARCHAR CON O SIN NUMEROS >>>
			else if(($row_info_columna['cod_tipo_dato_columna'] == 1 || 
					$row_info_columna['cod_tipo_dato_columna'] == 15)  && $value != NULL){
				//=== Evita con caracteres especiales como ñ, espacios, etc >>>
				$value = $sis_genericos->f_preparar_cadena_para_db($value);
				array_push($condicion,"t.$txt_nombre_columna like '%$value%'");
				
			}
		}
		
		$condiciones 				= implode(" AND ", $condicion);
		if ($condiciones) 			$condiciones = " and  $condiciones";
		//Obtiene informacion del pk y de la tabla >>>
		$query ="
		select 		cta.txt_nombre			as	txt_nombre_columna_pk
		from 		columna_tabla_autonoma	cta,
					tabla_autonoma			ta
		where		cta.ind_pk				= 1
		and			ta.cod_tabla			= $cod_tabla
		and			cta.cod_tabla			= ta.cod_tabla";
		$row					= $db->consultar_registro($query);
		$nom_pk		 			= $row['txt_nombre_columna_pk'];
		//==== Obtiene el script de la consulta de acuerdo al reporte seleccionado>>>>		
//		$txt_script_consulta	= 	$reporte_tabla->f_get_consulta( $arr_post['cod_reporte_tabla'], $cod_tabla);

		$txt_script_consulta	=	$reporte_tabla->f_get_script_reportes($arr_post['cod_pk_reporte'],$cod_tabla,$arr_post['cod_usuario']);		

		
		$row_imput				= array();
		//=== Ordenamiento >>>
		if($ord_por==-1 ||$ord_por==NULL)	$ord_por = "t.$nom_pk  desc";
		
		
		
		$txt_script_consulta	= str_replace("condiciones_script_consulta",$condiciones,$txt_script_consulta);
		
		
		
		/*$cod_periodo_facturacion 	= $arr_post['cod_pk_periodo'];
		// $cod_entidad				= $arr_post['cod_entidad_cmb'];
		//$cod_entidad_multiple		= $arr_post['cod_entidad_multiple'];
		//$cod_entidad_multiple		= implode(',',$cod_entidad_multiple);

		$arr_cod_archivos			= $arr_post['cod_archivo'];
		$cadena_cod_archivos		= implode(',',$arr_cod_archivos);
		$cod_pk_reporte_tabla		= $arr_post['cod_pk_reporte'];*/
		 
		
		
		// rango de codigos de facturas que el usuario eligio separado por coma
		//$cods_factura				= $arr_post['cod_facturas'];
		

			
		// valida si el codigo de periodo llega vacio o con dato
		/*if($cadena_cod_archivos){
			$cod_periodo_facturacion	= "and t.cod_nombre_archivos in ($cadena_cod_archivos)";
		}else{$cod_periodo_facturacion = '';}
		
		//busca la condicion del periodo de factura desntro del script del reporte
		if($cod_periodo_facturacion){
			$txt_script_consulta	= str_replace("condicion_periodo_facturacion", $cod_periodo_facturacion,$txt_script_consulta);
		}else{
			$txt_script_consulta	= str_replace("condicion_periodo_facturacion",'',$txt_script_consulta);
		}*/
				
			
		// valida si el codigo de entidad tiene dato o no
		/*if($cod_entidad && $cod_entidad != -1){
			$cod_entidad = "and t.cod_entidad in ($cod_entidad)";		
		}else{$cod_entidad = '';}
		// busca la condicion de entidad en el script y remplaza 
		if($cod_entidad){
			$txt_script_consulta	= str_replace("condicion_reporte_entidad",$cod_entidad,$txt_script_consulta);
		}else{
			$txt_script_consulta	= str_replace("condicion_reporte_entidad",'',$txt_script_consulta);		
		}*/
		
		
		
		
		if($cod_entidad_multiple && $cod_entidad_multiple != -1){
				$cond_ntdad_multiple = "and t.cod_entidad in ($cod_entidad_multiple)";				
		}else{
				$cond_ntdad_multiple = '';
		}
		
		
		if($cond_ntdad_multiple){
			$txt_script_consulta	= str_replace("condicion_reporte_entidad",$cond_ntdad_multiple,$txt_script_consulta);
		}else{
			$txt_script_consulta	= str_replace("condicion_reporte_entidad",'',$txt_script_consulta);		
		}
		
		
		//=== Genera consulta para resolver el numero de registros a encontrar (esto se hace para mejorar el rendimiento) >>>
		$txt_script_consulta		= strtolower($txt_script_consulta); 
		$txt_script_num_registros	= explode("from",$txt_script_consulta);
		$txt_script_num_registros[0]= ""; //quita el escript
		$txt_script_num_registros	= implode("from",$txt_script_num_registros);
		
		$ind_group_by				= explode("group by",$txt_script_num_registros);
		if($ind_group_by[1]) 		$ind_group_by = true;
		else						$ind_group_by = false;

		$txt_script_num_registros	= "select count(*) $txt_script_num_registros";

		
		if($ind_group_by){
			
				$cursor_num_registros		= $db->consultar($txt_script_num_registros);
				$num_reigstros				= $db->num_registros($cursor_num_registros); //por si viene con un group by 
				$resultado['NUM_REGISTROS'] +=  $num_reigstros; //la cantidad de datos que tiene el cursor
		}else{
				

				$row = $db->consultar_registro($txt_script_num_registros);
				$resultado['NUM_REGISTROS']		+= $row[0];
		}
		
		
		//=== Obtiene los datos>>>
		if($resultado['NUM_REGISTROS']){
			$query					= "$txt_script_consulta";
		
			$cursor 				= $db->consultar($query);
			$resultado['NUM_REGISTROS']		= $db->num_registros($cursor);		
			$resultado['DATOS']				= $cursor;		
		}		
		return $resultado;
	}
	
	
	
	/*=====20080601====================================D E C K===>>>>
	DESCRIPCION: 	Metodo para consultar los datos de una tabla especifica
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function f_consultar_tabla_autonoma(
			$cod_tabla					,
			$arr_post					,
			$ord_por					,
			$num_max_registros	= 20	,
			$num_pagina			= 0		,
			$array_seleccionados = NULL	,
			$cod_reporte_tabla	= NULL	,
			$ind_mostrar_todo = NULL
	){
		global $db;
		$condicion 					= 	array();
		$sis_genericos				= 	new sis_genericos;
		$reporte_tabla				=	new reporte_tabla;
		//=== Indica la paginacion para que no se muestren todos los registros en un solo pantallaso>>>
		if($num_pagina>0)	$num_pagina 	= $num_pagina-1;
		if(!$num_pagina) 	$limite_inicial = 0;
		else				$limite_inicial = $num_pagina*$num_max_registros;
		$limite_final 		= $limite_inicial+ $num_max_registros;
		
		
		//=== si encuentra algo en varias tablas asume que el reporte es para varias tablas		
		if($cod_reporte_tabla){
			$query ="
			select 		cta.* ,
						ta.txt_nombre as txt_tabla
			from 		filtro_reporte fr,
						columna_tabla_autonoma cta,
						tabla_autonoma ta
			where		ind_activo	= 1
			and			cta.cod_columna_tabla 	= fr.cod_columna_tabla
			and			cta.cod_tabla			= ta.cod_tabla
			and			cod_reporte_tabla		= $cod_reporte_tabla
			order 		by fr.num_orden desc";

			$cursor_columnas		= $db->consultar($query);
			$num_registros			= $db->num_registros($cursor_columnas);
		}
		//==== usado para cuando los filtros son de una sola pagina >>>		
		if($num_registros==0){
			
			$query ="
			select 		* 
			from 		columna_tabla_autonoma
			where		ind_filtro	= 1
			and			cod_tabla	= $cod_tabla
			order by 	num_orden_insert desc";
			$cursor_columnas		= $db->consultar($query);
		}
		

		
		//Obtiene las columnas de la tabla >>>
		/*$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		ind_filtro			= 1
		and			cod_tabla			= $cod_tabla
		order by 	num_orden_insert";*/

		$cursor_columnas		= $db->consultar($query);
		$num_registros 			= $db->num_registros($cursor_columnas);
		$row_imput				= array();
		for($i=0; $i<$num_registros; $i++){
			$row_info_columna								= $db->sacar_registro($cursor_columnas,$i);
			if($row_info_columna['txt_tabla']){
				$txt_tabla	= $row_info_columna['txt_tabla']."-";
				$t 			= "$txt_tabla";
				$txt_name_imput	= $row_info_columna['txt_tabla']."-".$row_info_columna['txt_nombre'];
			}else{										
				$txt_tabla	= "";
				$t 			= "t";
				$txt_name_imput	= $row_info_columna['txt_nombre'];
			}
			
			$txt_nombre_columna								= $txt_tabla.$row_info_columna['txt_nombre'];
			$txt_script_cursor								= $row_info_columna['txt_script_cursor'];
			$value											= $arr_post[$txt_nombre_columna];

			$tmp_arr_tabla_col 	= explode("-",$txt_nombre_columna);
			if($tmp_arr_tabla_col[1])	$txt_nombre_columna = $tmp_arr_tabla_col[1];
			$t 							= trim($t,"-");
			
			//$txt_nombre_columna								= $row_info_columna['txt_nombre'];
			//$txt_script_cursor								= $row_info_columna['txt_script_cursor'];
			//$value											= $arr_post[$txt_nombre_columna];

			//=== Evita confusion entre el NULL y el cero>>>
			if($value===0) $value="0";
			//=== Evalua datos tipo NUMERIC SIN FORMATO >>>
			if(($row_info_columna['cod_tipo_dato_columna'] == 5 || $row_info_columna['cod_tipo_dato_columna'] == 7) && $value != NULL){
				$value_array	= explode("-",$value);
				if($value_array[1]){
					$acum_codigos	= array();
					for($i=$value_array[0];$i<=$value_array[1];$i++){
						array_push($acum_codigos,$i);
					}
					$value =  implode(",", $acum_codigos);
				}
				array_push($condicion,"$t.$txt_nombre_columna in($value)");
			
			}
			//=== Evalua datos tipo LISTBOX >>>
			else if($row_info_columna['cod_tipo_dato_columna'] == 4 && $value !=-1 && $value !== NULL){
				if($row_info_columna['ind_input_multiple']==1){
					$a = strpos($value,',');  // verifica si encuntra comas en la cadena
									
					if($value != NULL){
						if(is_array($value)){
							 $value = array_filter($value);
							 $value  = implode(",",$value);
						}else{
							if($a > 0){ // si la cadena tiene una o mas comas
								$value = explode(',',$value);
								$value = array_filter($value);
								$value  = implode(",",$value);
							}							
						}
					}
				}
				
				if($value==0 && $value != NULL) $value ="0";
				if($value != '')array_push($condicion,"$t.$txt_nombre_columna in ($value)");
			}			
			//=== Evalua datos tipo DATE CON FORMATO, como es un filtro lo evalua desde la fehca inicial hasta la final >>>
			else if($row_info_columna['cod_tipo_dato_columna'] == 3 || $row_info_columna['cod_tipo_dato_columna'] == 8){
				$value1	= $arr_post[$txt_nombre_columna."_inicial"];
				$value2	= $arr_post[$txt_nombre_columna."_final"];
				if($value1){
					array_push($condicion,"$t.$txt_nombre_columna >='$value1 00:00:00'");
				}
				if($value2){
					array_push($condicion,"$t.$txt_nombre_columna <='$value2 23:59:59'");
				}
			}
			//=== Evalua datos tipo VARCHAR CON O SIN NUMEROS >>>
			else if(($row_info_columna['cod_tipo_dato_columna'] == 1 || 
					$row_info_columna['cod_tipo_dato_columna'] == 15)  && $value != NULL){
				//=== Evita con caracteres especiales como ñ, espacios, etc >>>
				$value = $sis_genericos->f_preparar_cadena_para_db($value);
				array_push($condicion,"$t.$txt_nombre_columna like '%$value%'");
				
			}
		}	
		
		//Obtiene informacion del pk y de la tabla >>>
		$query ="
		select 		cta.txt_nombre			as	txt_nombre_columna_pk
		from 		columna_tabla_autonoma	cta
		where		cta.ind_pk				= 1
		and			cta.cod_tabla			= $cod_tabla";
		$row					= $db->consultar_registro($query);
		$nom_pk		 			= $row['txt_nombre_columna_pk'];

		//=== Ordenamiento >>>
		if($array_seleccionados ){
			$array_seleccionados = implode(",",$array_seleccionados);
			array_push($condicion,"t.$nom_pk in($array_seleccionados)");
			$limite_inicial="0"; //para que ubique los datos en la primera pagina
		}
		
		
		$condiciones 				= implode(" AND ", $condicion);
		if ($condiciones) 			$condiciones = " and  $condiciones";
		//Obtiene informacion del pk y de la tabla >>>
		$query ="
		select 		cta.txt_nombre			as	txt_nombre_columna_pk
		from 		columna_tabla_autonoma	cta,
					tabla_autonoma			ta
		where		cta.ind_pk				= 1
		and			ta.cod_tabla			= $cod_tabla
		and			cta.cod_tabla			= ta.cod_tabla";
		$row					= $db->consultar_registro($query);
		$nom_pk		 			= $row['txt_nombre_columna_pk'];
		//==== Obtiene el script de la consulta de acuerdo al reporte seleccionado>>>>		
//		$txt_script_consulta	= 	$reporte_tabla->f_get_consulta( $arr_post['cod_reporte_tabla'], $cod_tabla);


		$txt_script_consulta	=	$reporte_tabla->f_get_script(
														$arr_post['cod_reporte_tabla']	,
														$cod_tabla,$arr_post['cod_usuario']);		



		$row_imput				= array();
		//=== Ordenamiento >>>
		//if($ord_por==-1 ||$ord_por==NULL)	$ord_por = "$t.$nom_pk  desc";
		
		$txt_script_consulta	= str_replace("condiciones_script_consulta", $condiciones,$txt_script_consulta);
		$cod_usuario			= $arr_post['cod_usuario'];
		$txt_script_consulta	= str_replace('$cod_usuario', $cod_usuario,$txt_script_consulta);

		//=== Genera consulta para resolver el numero de registros a encontrar (esto se hace para mejorar el rendimiento) >>>
		$txt_script_consulta		= strtolower($txt_script_consulta); 
		$txt_script_num_registros	= explode("from",$txt_script_consulta);
		$txt_script_num_registros[0]= ""; //quieta el escript
		$txt_script_num_registros	= implode("from",$txt_script_num_registros);

		$ind_group_by				= explode("group by",$txt_script_num_registros);
			if($ind_group_by[1]) 			$ind_group_by = true;
			else							$ind_group_by = false;
		

		$txt_script_num_registros	= "select count(*) $txt_script_num_registros";

		//=== Genera consulta para resolver el numero de registros a encontrar (esto se hace para mejorar el rendimiento) >>>
		$txt_script_union_registros	= explode("union all",$txt_script_consulta);
		$resultado['NUM_REGISTROS'] = 0;
		$num_uniones = count($txt_script_union_registros);
		

		if($num_uniones>1){
			for($i = 0; $i <$num_uniones ; $i++){
				$txt_script_num_registros	= $txt_script_union_registros[$i];
				$txt_script_num_registros	= strtolower($txt_script_num_registros);
				$txt_script_num_registros	= explode("from",$txt_script_num_registros);
				$txt_script_num_registros[0]= ""; //quieta el escript
				
				$txt_script_num_registros	= implode("from",$txt_script_num_registros);

				
				$txt_script_num_registros	= explode("order by",$txt_script_num_registros);
				$txt_script_num_registros	= $txt_script_num_registros[0];

				$num_strlen = strlen(trim($txt_script_num_registros));
				$last_pos_str = substr(trim($txt_script_num_registros), -1);
				if($last_pos_str == ')')$txt_script_num_registros = substr(trim($txt_script_num_registros), 0,-1);

				//print_r($txt_script_num_registros);
				
				$ind_group_by				= explode("group by",$txt_script_num_registros);
				if($ind_group_by[1]) 			$ind_group_by = true;
				else							$ind_group_by = false;
				

				$txt_script_num_registros	= "select count(*) $txt_script_num_registros";
				

	//			$txt_script_num_registros	= explode("group by",$txt_script_num_registros);
				//$txt_script_num_registros	= $txt_script_num_registros[0];

				if($ind_group_by){
					$cursor_num_registros		= $db->consultar($txt_script_num_registros);
					$num_reigstros				= $db->num_registros($cursor_num_registros); //por si viene con un group by 
					$resultado['NUM_REGISTROS'] +=  $num_reigstros; //la cantidad de datos que tiene el cursor
				}else {
					$row = $db->consultar_registro($txt_script_num_registros);
					$resultado['NUM_REGISTROS']		+= $row[0];
				}
			}// fin for
		}else{ // fin if num_uniones

			if($ind_group_by){

				$cursor_num_registros	= $db->consultar($txt_script_num_registros);
				$num_reigstros				= $db->num_registros($cursor_num_registros); //por si viene con un group by 
				$resultado['NUM_REGISTROS'] +=  $num_reigstros; //la cantidad de datos que tiene el cursor
			}else {
				$row = $db->consultar_registro($txt_script_num_registros);

				$resultado['NUM_REGISTROS']		+= $row[0];
			}


		} // fin else



		//=== Obtiene los datos>>>
		/*if($resultado['NUM_REGISTROS']){


			if(!$ind_mostrar_todo || $ind_mostrar_todo == 0){
				$limite = "limit $num_max_registros offset $limite_inicial";
			}
			
			$query					= "$txt_script_consulta order by $ord_por ".$limite;

			$cursor 				= $db->consultar($query);
			$resultado['DATOS']		= $cursor;		
		}		*/

		//=== Obtiene los datos>>>

		if($resultado['NUM_REGISTROS']){
			
			//=== Obtiene el ordenamiento bien sea porque venga ya configurado en el query o por defecto en el pk o porque fue seleccionada una columna en particular
			$txt_script_consulta	= explode("order by",$txt_script_consulta);

			if(!$ind_mostrar_todo || $ind_mostrar_todo == 0){
				$limite = "limit $num_max_registros offset $limite_inicial";
			}

			$query_order_by			= $txt_script_consulta[1]; //posicion del ordenamiento
			$txt_script_consulta	= $txt_script_consulta[0]; //posicion de la consulta
			if($ord_por==-1 ||$ord_por==NULL){	//si no ha seleccionado ningun ordenamiento
				if($query_order_by)		$ord_por = $query_order_by; //si hay un ordenamiento ya parametrizado			
				else					$ord_por = "$t.$nom_pk desc"; //si no pone por defecto la llave primaria			
			}else {
				if($num_uniones>0 && $ord_por=="$t.$nom_pk asc")	$ord_por = "$nom_pk asc"; //si no pone por defecto la llave primaria							
				else if($num_uniones>0 && $ord_por=="$t.$nom_pk desc")	$ord_por = "$nom_pk desc"; //si no pone por defecto la llave primaria							
			}
			$ord_por			= strtolower($ord_por);
			$query				= "$txt_script_consulta order by $ord_por ".$limite;

			$cursor 				= $db->consultar($query);
						
			$resultado['DATOS']		= $cursor;		
		}	
		return $resultado;
	}
	/*=====20080601====================================D E C K===>>>>
	DESCRIPCION: 	Metodo para consultar los datos de un maestro de detalle
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	$ind_consulta_2	Indica que debe ejecutar la consulta 2 registrada en la tabla tabla_autonoma
	===========================================================================*/
	function f_consultar_maestro_detalle(
			$cod_tabla				,
			$cod_tabla_detalle		,			
			$arr_post				,
			$ord_por				,
			$num_max_registros	= 20,
			$num_pagina			= 0	,
			$ind_mostrar_todo	= NULL	,
			$cod_usuario		= NULL	,
			$array_seleccionados = NULL
	){
		global $db;
		$condicion 					= 	array();
		$sis_genericos				= 	new sis_genericos;
		//=== Indica la paginacion para que no se muestren todos los registros en un solo pantallaso>>>
		if($num_pagina>0)	$num_pagina 	= $num_pagina-1;
		if(!$num_pagina) 	$limite_inicial = 0;
		else				$limite_inicial = $num_pagina*$num_max_registros;
		$limite_final 		= $limite_inicial+ $num_max_registros;
		
		//=======================================================================================>>>>
		// Obtiene las columnas de la tabla principal esto se ejecuta igual dos veces teniendo en cuenta la tabla de detalle
		//=======================================================================================>>>>
		$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		ind_filtro			= 1
		and			cod_tabla			= $cod_tabla
		order by 	num_orden_insert";

		$cursor_columnas		= $db->consultar($query);
		$num_registros 			= $db->num_registros($cursor_columnas);
		$row_imput				= array();
		for($i=0; $i<$num_registros; $i++){
			$row_info_columna								= $db->sacar_registro($cursor_columnas,$i);
			$txt_nombre_columna								= $row_info_columna['txt_nombre'];
			$txt_script_cursor								= $row_info_columna['txt_script_cursor'];
			$ind_pk											= $row_info_columna['ind_pk'];
			if($ind_pk)				$txt_nombre_pk_maestro	= $row_info_columna['txt_nombre'];
			if($ind_consulta_2)		$txt_script_cursor		= $row_info_columna['txt_script_cursor_2'];
			else					$txt_script_cursor		= $row_info_columna['txt_script_cursor_1'];
			$value											= $arr_post[$txt_nombre_columna];
			//=== Evita confusion entre el NULL y el cero>>>
			if($value===0) $value="0";
			//=== Evalua datos tipo NUMERIC SIN FORMATO >>>
			if(($row_info_columna['cod_tipo_dato_columna'] == 5 || $row_info_columna['cod_tipo_dato_columna'] == 7) && $value != NULL){
					array_push($condicion,"t.$txt_nombre_columna in($value)");
		
			//=== Evalua datos tipo LISTBOX >>>
			}else if($row_info_columna['cod_tipo_dato_columna'] == 4 ){
				if($row_info_columna['ind_input_multiple']==1){
					$a = strpos($value,',');  // verifica si encuntra comas en la cadena
					
					if($value){
						if(is_array($value)){
							 $value = array_filter($value);
							 $value  = implode(",",$value);
						}else{
							if($a > 0){ // si la cadena tiene una o mas comas
								$value = explode(',',$value);
								$value = array_filter($value);
								$value  = implode(",",$value);
							}							
						}
					}
				}
				
				
				if($value != '-1' && $value != NULL){
					if($value==0) $value ="0";
					//if(is_array($value)){ $value = implode(",",$value);}	
					if($value != '')array_push($condicion,"t.$txt_nombre_columna in ($value)");
				}
				

			}			
			//=== Evalua datos tipo DATE CON FORMATO, como es un filtro lo evalua desde la fehca inicial hasta la final >>>
			else if($row_info_columna['cod_tipo_dato_columna'] == 3 || $row_info_columna['cod_tipo_dato_columna'] == 8){
				$value1	= $arr_post[$txt_nombre_columna."_inicial"];
				$value2	= $arr_post[$txt_nombre_columna."_final"];
				if($value1){
					array_push($condicion,"t.$txt_nombre_columna >='$value1 00:00:00'");
				}
				if($value2){
					array_push($condicion,"t.$txt_nombre_columna <='$value2 23:59:59'");
				}
			}
			//=== Evalua datos tipo VARCHAR CON O SIN NUMEROS >>>
			else if(($row_info_columna['cod_tipo_dato_columna'] == 1 || 
					$row_info_columna['cod_tipo_dato_columna'] == 15)  && $value != NULL){
				//=== Evita con caracteres especiales como ñ, espacios, etc >>>
				$value = $sis_genericos->f_preparar_cadena_para_db($value);
				array_push($condicion,"UPPER(t.$txt_nombre_columna) like '%$value%'");
				
			}
		}	
		//=======================================================================================>>>>
		// Obtiene las columnas de la tabla detalle esto se ejecuta igual dos veces teniendo en cuenta la tabla de detalle 
		// En el futuro hay que unificar este codigo con el de arriba
		//=======================================================================================>>>>
		$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		ind_filtro			= 1
		and			cod_tabla			= $cod_tabla_detalle
		order by 	num_orden_insert";


		$cursor_columnas		= $db->consultar($query);
		$num_registros 			= $db->num_registros($cursor_columnas);
		$row_imput				= array();
		for($i=0; $i<$num_registros; $i++){
			$row_info_columna								= $db->sacar_registro($cursor_columnas,$i);
			$txt_nombre_columna								= $row_info_columna['txt_nombre'];
			$txt_script_cursor								= $row_info_columna['txt_script_cursor'];
			$value											= $arr_post[$txt_nombre_columna];

			//=== Evita confusion entre el NULL y el cero>>>
			if($value===0) $value="0";
			//=== Evalua datos tipo NUMERIC SIN FORMATO >>>
			if(($row_info_columna['cod_tipo_dato_columna'] == 5 || $row_info_columna['cod_tipo_dato_columna'] == 7) && $value != NULL){
					if($txt_nombre_pk_maestro != $txt_nombre_columna) //=== Para que no repita el mismo campo en el maestro y en el detalle
						array_push($condicion,"t2.$txt_nombre_columna in($value)");
		
			//=== Evalua datos tipo LISTBOX >>>
			//=== Evalua datos tipo LISTBOX >>>
			}else if($row_info_columna['cod_tipo_dato_columna'] == 4 ){
				if($row_info_columna['ind_input_multiple']==1){
					$a = strpos($value,',');  // verifica si encuntra comas en la cadena
									
					if($value){
						if(is_array($value)){
							 $value = array_filter($value);
							 $value  = implode(",",$value);
						}else{
							if($a > 0){ // si la cadena tiene una o mas comas
								$value = explode(',',$value);
								$value = array_filter($value);
								$value  = implode(",",$value);
							}							
						}
					}
				}
				
				
				if($value != '-1' && $value != NULL){
					if($value==0) $value ="0";
					//if(is_array($value)){ $value = implode(",",$value);}	
					if($value != '')array_push($condicion,"t2.$txt_nombre_columna in ($value)");
				}
			}		
			//=== Evalua datos tipo DATE CON FORMATO, como es un filtro lo evalua desde la fehca inicial hasta la final >>>
			else if($row_info_columna['cod_tipo_dato_columna'] == 3 || $row_info_columna['cod_tipo_dato_columna'] == 8){
				$value1	= $arr_post[$txt_nombre_columna."_inicial"];
				$value2	= $arr_post[$txt_nombre_columna."_final"];
				if($value1){
					array_push($condicion,"t2.$txt_nombre_columna >='$value1 00:00:00'");
				}
				if($value2){
					array_push($condicion,"t2.$txt_nombre_columna <='$value2 23:59:59'");
				}
			}
			//=== Evalua datos tipo VARCHAR CON O SIN NUMEROS >>>
			else if(($row_info_columna['cod_tipo_dato_columna'] == 1 || $row_info_columna['cod_tipo_dato_columna'] == 15)  && $value != NULL){
				//=== Evita con caracteres especiales como ñ, espacios, etc >>>
				$value = $sis_genericos->f_preparar_cadena_para_db($value);
				array_push($condicion,"UPPER(t2.$txt_nombre_columna) like '%$value%'");
				
			}//=== Evalua datos tipo buscador con pllugin select2 >>>
			 else if($row_info_columna['cod_tipo_dato_columna'] == 19 ){
			
				if($value != '-1' && $value != NULL){
					
					if($value==0) $value ="0";
					if(is_array($value)){ $value = implode(",",$value);}	
					array_push($condicion,"t2.$txt_nombre_columna in ($value)");
				}
				
			}	
		}	
		
		
		//Obtiene informacion del pk y de la tabla >>>
		$query ="
		select 		cta.txt_nombre			as	txt_nombre_columna_pk
		from 		columna_tabla_autonoma	cta
		where		cta.ind_pk				= 1
		and			cta.cod_tabla			= $cod_tabla";
		$row					= $db->consultar_registro($query);
		$nom_pk		 			= $row['txt_nombre_columna_pk'];

		//=== Ordenamiento >>>
		if($array_seleccionados ){
			$array_seleccionados = implode(",",$array_seleccionados);
			array_push($condicion,"t.$nom_pk in($array_seleccionados)");
			$limite_inicial="0"; //para que ubique los datos en la primera pagina
		}

		
		$condiciones 				= implode(" AND ", $condicion);

		if ($condiciones) 			$condiciones = " and  $condiciones";
		//Obtiene informacion del pk y de la tabla >>>
		/*$query ="
		select 		ta.txt_script_consulta		as	txt_script_consulta		,
					ta.txt_script_consulta_2	as	txt_script_consulta_2	,
					cta.txt_nombre				as	txt_nombre_columna_pk
		from 		columna_tabla_autonoma	cta,
					tabla_autonoma			ta
		where		cta.ind_pk				= 1
		and			ta.cod_tabla			= $cod_tabla
		and			cta.cod_tabla			= ta.cod_tabla";*/
		$cod_usuario = $_REQUEST['cod_usuario'];
		$query 	="
		select 	rt.*  
		from 	seg_perfil_reporte  pr,
				seg_perfil_usuario  pu,
				reporte_tabla	rt
		where	pu.cod_perfil = pr.cod_perfil
		and		pr.cod_reporte_tabla = rt.cod_reporte_tabla
		and		pu.cod_usuario_pk		=$cod_usuario
		and		rt.cod_tabla 		=$cod_tabla
		order by rt.ind_default desc, rt.txt_nombre	";

		$row					= $db->consultar_registro($query);

		
		//=== Nombre llave primaria>>>
		$row_pk				= $this->f_get_row_pk($cod_tabla);
		$nom_pk				= $row_pk['txt_nombre'];
		
		if($ind_consulta_2)		$txt_script_consulta	= $row['txt_script_consulta_2'];
		else					$txt_script_consulta	= $row['txt_script'];
		$row_imput				= array();
		
		//=== Ordenamiento >>>
		if($ord_por==-1 ||$ord_por==NULL)	$ord_por = "t.$nom_pk  desc";
		$txt_script_consulta	= str_replace("condiciones_script_consulta", $condiciones,$txt_script_consulta);
		$txt_script_consulta	= str_replace('$cod_usuario', $cod_usuario,$txt_script_consulta);


		$txt_script_consulta	= "$txt_script_consulta order by $ord_por";
		

		$cursor 				= $db->consultar($txt_script_consulta);
		$resultado['NUM_REGISTROS']		= $db->num_registros($cursor);
		//=== Obtiene los datos>>>
		if($resultado['NUM_REGISTROS']){
			if(!$ind_mostrar_todo || $ind_mostrar_todo == 0){
				$limite = "limit $num_max_registros offset $limite_inicial";
			}

			$query					= "$txt_script_consulta ".$limite;

			$cursor 				= $db->consultar($query);
			$resultado['DATOS']		= $cursor;		
		}		
		
		return $resultado;
	}
	/*=====2008-12-17====================================D E C K===>>>>
	DESCRIPCION: 	Este metodo muestra un estandar para mostrar los datos en un reporte
					fechas formateadas, alineadas correctametne, numero con formato, textos en mayuscula inicial
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO				DESCRIPCION 
	$cod_tipo_dato_columna	Tipo de dato de la columna
	$valor					Valor que se pretende colocar en la columna
	===========================================================================*/
	function f_estandar_campo_reporte(
			$cod_tipo_dato_columna	,
			$value					
	){

		$sis_genericos	= new sis_genericos;
		$arr_retorno	= array();

		//=== Tipo de dato CELULAR>>>
		if($cod_tipo_dato_columna		== 10){
			$align	="left";
			$nowrap="nowrap='nowrap'";
			$value = $value[0].$value[1].$value[2].'-'.$value[3].$value[4].$value[5].$value[6].$value[7].$value[8].$value[9];
		//=== Evalua datos tipo NUMERIC SIN FORMATO >>>
		}else if($cod_tipo_dato_columna		== 5){
			$align	="center";
			$nowrap="nowrap='nowrap'";
		//=== Evalua datos tipo LISTBOX >>>
		}else if($cod_tipo_dato_columna	== 4){

			$value	=ucwords(strtolower($value));
			if(is_numeric($value))  $value	=	$sis_genericos->formato_numero($value,2);			
			$align	="right";
			$nowrap="nowrap='nowrap'";			
		//=== Evalua datos tipo DATE CON FORMATO, como es un filtro lo evalua desde la fehca inicial hasta la final >>>
		}else if($cod_tipo_dato_columna 	== 8){
			$value	=$sis_genericos->f_nombre_fecha_con_hora($value);
			$align	="left";
			$nowrap="nowrap='nowrap'";			
		//=== Evalua datos tipo DATE CON FORMATO, como es un filtro lo evalua desde la fehca inicial hasta la final >>>
		}else if($cod_tipo_dato_columna 	== 3){
			$value	=$sis_genericos->f_nombre_fecha($value);
			$align	="center";
			$nowrap="nowrap='nowrap'";			
		//=== Evalua datos tipo INT CON FORMATO, como es un filtro lo evalua desde la fehca inicial hasta la final >>>
		}else if($cod_tipo_dato_columna 	== 2){
			$value	=	$sis_genericos->formato_numero($value,2);
			$align	=	"right";
			$nowrap	="nowrap='nowrap'";			
		//=== Evalua datos tipo VARCHAR o LISTA DE VALOR>>>
		}else if($cod_tipo_dato_columna 	== 1 ||cod_tipo_dato_columna == 7){
			$value = $sis_genericos->f_preparar_cadena_para_db($value);
			
			//$value	= ucwords(strtolower($value));
			$value	= utf8_encode(ucwords(strtolower(utf8_decode($value))));
			
			$align	="left";
			//$nowrap	="nowrap='nowrap'";			
		}
		if(!$value) $value = "&nbsp;"; // para evitar que se vean vacios en la tabla
		$arr_retorno['VALUE']	= $value;
		$arr_retorno['ALIGN']	= $align;
		$arr_retorno['NOWRAP']	= $nowrap;		
		return $arr_retorno;
	}
	/*=====2008-12-17====================================D E C K===>>>>
	DESCRIPCION: 	Metodo para contruir la tabla donde se muestran los resultados
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$resultado_cursor	 vector con los siguientes datos [NUM_REGISTROS] ,    [DATOS] => contine el cursor
	$cod_tabla			Codigo de la tabla autonoma con la que se esta trabajando
	$ancho_tabla		ancho en pixeles de la tabla html
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function f_generar_tabla_datos_cursor(
			$resultado_cursor			,
			$cod_tabla					,
			$ancho_tabla				,
			$bordercolor				,
			$class_datos_tabla			,
			$cod_tabla_detalle	= NULL	,
			$estado_ord 		= NULL	,
			$ord_por			= NULL	,
			$num_max_registros	= NULL
	){
		global $db;
		$sis_genericos 	= new sis_genericos;
		$cursor_datos	= $resultado_cursor['DATOS'];
		$total_registros= $resultado_cursor['NUM_REGISTROS'];
		// indica que al final del reporte no hay sumatorias (si hay variables tipo Numeric con formato cambia a true)
		$ind_sumatoria	= false; 
		$row_sumatoria	= array();
		$num_columnas	= $db->num_columnas($cursor_datos);
		//Obtiene las columnas de la tabla en forma de vector >>>
		$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		cod_tabla in($cod_tabla)
		order by 	num_orden_insert";
		$cursor_columnas		= $db->consultar($query);
		$num_registros 			= $db->num_registros($cursor_columnas);
		$array_info_columna		= array();
		for($i=0; $i<$num_registros; $i++){
			$row				= $db->sacar_registro($cursor_columnas,$i);
			$array_info_columna[$row['txt_nombre']] = $row;
		}

		//Evalua si es un maestro de detalle e incluye tambien las columnas de detalle>>>
		if($cod_tabla_detalle){
			$query ="
			select 		* 
			from 		columna_tabla_autonoma
			where		cod_tabla in($cod_tabla_detalle)
			and			ind_pk = 0
			and			txt_nombre not in (select txt_nombre from columna_tabla_autonoma where cod_tabla=$cod_tabla)
			order by 	num_orden_insert";

			$cursor_columnas		= $db->consultar($query);
			$num_registros 			= $db->num_registros($cursor_columnas);
			//$array_info_columna		= array();
			for($i=0; $i<$num_registros; $i++){
				$row				= $db->sacar_registro($cursor_columnas,$i);
				$array_info_columna[$row['txt_nombre']] = $row;
			}
		}

		// Genera el titulo de la tabla >>>	
/*		$titulo_tabla	=	"<tr class='titulo_tabla'><td><input type='checkbox' name='check_all' onclick='f_seleccionar_todos(this)'/></td>";*/
		
				// Genera el titulo de la tabla >>>	
		$titulo_tabla	=	"<tr class='titulo_tabla' ><td width='1%'>
								<input type='checkbox' name='check_all' style='margin:5px;' onclick='f_seleccionar_todos(this)'/>
								</td>";		

		for($i=0; $i<$num_columnas; $i++){

			$nom_columna	= $db->nom_columna($cursor_datos,$i);
			if($nom_columna!='privado_color'){	
				$txt_alias		= $array_info_columna[$nom_columna]['txt_alias_corto'];
				if(!$txt_alias)		
					$txt_alias	= $array_info_columna[$nom_columna]['txt_alias'];
				if(!$txt_alias){
					$longitud	= strlen($nom_columna);
					$txt_alias	= substr($nom_columna,2,$longitud-2);
				}
				
				//==== Organiza el alias de la tabla para el ordenamiento diferenciando entre t y t2
				if($array_info_columna[$nom_columna]['cod_tabla'] == $cod_tabla)  	$t="t.";
				else																$t="";
				
				$txt_alias		= strtoupper($txt_alias);
				$txt_alias		= str_replace("_"," ",$txt_alias);
				$txt_alias		= str_replace("ACUTE;","acute;",$txt_alias);
				/*$titulo_tabla	.= "<td align='center'  >
				
				<table  class='titulo_tabla'>
				<tr>
					<td align='center' valign='top' >$txt_alias</td>
					
					<td>
					<table>
						<tr>
							<td><a  title='Click para ordenar por $txt_alias' href=\"javascript:f_ordenar_por('$t$nom_columna asc')\">
							<img src=\"../../imagenes/sistema/flecha_tabla2.jpg\" border=0 /></a></td>
						</tr>
						<tr>
							<td><a  title='Click para ordenar por $txt_alias' href=\"javascript:f_ordenar_por('$t$nom_columna desc')\">
							<img src=\"../../imagenes/sistema/flecha_tabla.jpg\" border=0 /></a></td>
						</tr>
						</table>
					</td>
				</tr></table>
				</td>";*/
				$ord_img = NULL;
			
				if(!$ord_por){
					if($array_info_columna[$nom_columna]['ind_pk'] == 1){
						$nowrap = "nowrap";
						if(!$estado_ord)$estado_ord = "desc";
						$ord_por = $t.$nom_columna." ".$estado_ord;
					}

				}

				if($ord_por == $t.$nom_columna." ".$estado_ord){
					if($estado_ord == 'asc'){
						$ord_img = "<img src='../../imagenes/sistema/flecha_tabla.jpg' title='$estado_ord' />";
					}else if($estado_ord == 'desc'){
						$ord_img = "<img src='../../imagenes/sistema/flecha_tabla2.jpg' title='$estado_ord' />";
					}
						
					$tmp_estado_ord = $estado_ord;
						
				}else{
					$tmp_estado_ord = NULL;
				}
					$titulo_tabla	.= "<td align='center' $nowrap >
					
					<table>
						
						<tr>
							<td align='center' 
								title='Click para ordenar por $txt_alias' onclick='f_ordenar_por_V2(this,\"$t$nom_columna\");'
								class='titulo_tabla' 
								style='font-size:10px; cursor:pointer;' data-estado='$tmp_estado_ord'  valign='top' $nowrap>
								$txt_alias &nbsp; $ord_img
							</td>
						</tr>
					
					</table>
			    </td>";
	
			}

		}
		$titulo_tabla	=	"$titulo_tabla</tr>";
					
		// Genera datos de la tabla>>>		
		$num_registros 			= $db->num_registros($cursor_datos);
		$arr_estandar_celda		= array();
		for($i=0; $i<$num_registros; $i++){
			$row_dato	= $db->sacar_registro($cursor_datos,$i);
		
			if($row_dato['val_saldo']>0  && $cod_tabla==4){
				$estilo_especial = "class='fila_roja'";
			}else 
				$estilo_especial = NULL;

//			$txt_datos_tabla .=  "<tr $estilo_especial class='$class_datos_tabla'>";
			$txt_datos_tabla .=  "
		  <tr  style='display:none' class='display_div' id='tr_menu_reg_$row_dato[0]' >
		  	<td colspan='".($num_columnas+1)."'>
			
			<div id='div_reg_$row_dato[0]' ></div>
			
			</td>
		</tr>
		
			<tr  id='tr_reg_$row_dato[0]' class='$class_datos_tabla' 
				style='background-color:".$row_dato['privado_color']."' 
				onmouseover='f_color_fila(this,1)' onmouseout='f_color_fila(this,2)' onclick='f_color_fila(this,3)'>";
			

			for($j=0; $j<$num_columnas; $j++){
				$nom_columna		= 	$db->nom_columna($cursor_datos,$j);

				$row_info_columna	= 	$array_info_columna[$nom_columna];
				$txt_nombre_columna	= 	$row_info_columna['txt_nombre'];
				$value				= 	$row_dato[$txt_nombre_columna];
				
				if($nom_columna!='privado_color'){
					$row_info_columna	= 	$array_info_columna[$nom_columna];
					$txt_nombre_columna	= 	$row_info_columna['txt_nombre'];
					$value				= 	$row_dato[$txt_nombre_columna];

					//=== Evalua situaciones con campos que no estan registrados y que vienen 
					//en la consulta con el codigo del tipo en el nombre de la columna
					if(!$row_info_columna['cod_tipo_dato_columna']){
						$cod_tipo_dato	 	= substr($nom_columna,0,2);
						$cod_tipo_dato		=  round($cod_tipo_dato,0);
						$row_info_columna['cod_tipo_dato_columna'] = $cod_tipo_dato;
					}
	
					if(!$value)				$value	= $row_dato[$j];	
					//=== Evalua sumatoria al final de la consulta >>>
					if($row_info_columna['cod_tipo_dato_columna'] 	== 2 || (is_numeric($value) && 
						$row_info_columna['cod_tipo_dato_columna'] 	== 4  )){
							
						$row_sumatoria[$nom_columna] 	+= 	$value;
						$ind_sumatoria					= 	true;				
					}
					
					//=== Alineacion y formato de la informacion a mostar en la celda >>>
					$arr_estandar_celda	= $this->f_estandar_campo_reporte($row_info_columna['cod_tipo_dato_columna'] , $value);
	
					$value				= $arr_estandar_celda['VALUE'];
					$align				= $arr_estandar_celda['ALIGN'];
					$nowrap				= $arr_estandar_celda['NOWRAP'];
					
	
					
							
					//=== Evalua el enlace con el PK >>>
					$width_pk=NULL;
					
					if($row_info_columna['ind_pk']){

						$tmp_pk	=	$value;// para que sea usado en un hipervinculo tambien en la columna siguiente
//						$value	= "<a href='javascript:ver_menu_registro($value)' class='link_display' >$value</a>";
						$value	= "<a href='javascript:ver_menu_registro($value)' >$value</a>";
						$width_pk=" width='1%'  onclick='javascript:f_ver_menu_registro($tmp_pk)'";
						//=== Añade radio buton para manipular el registro >>>
						$txt_datos_tabla .= "<td><input type='checkbox' name='reg_seleccionado[]' value='$tmp_pk' /></td>";
					}
					//=== Evalua el enlace con el PK en la siguiente columna >>>				
//					if($j==1) $value	= "<a href='javascript:f_ver_menu_registro($tmp_pk)' class='link_display'>$value</a>";
					if($j==1) $value	= "<a href='javascript:f_ver_menu_registro($tmp_pk)' >$value</a>";
					$txt_datos_tabla .=  "<td $width_pk  align='$align' class='contenido'  $nowrap>$value</td>";
				}
			}
			$txt_datos_tabla .=  "</tr>";
		}
		//=== Evalua si debe mosrar al final alguna sumatoria >>>
		if($ind_sumatoria){
			$txt_datos_tabla .=  "<tr class='$class_datos_tabla' style='background-color: #FFFF99; '  title='Total Columna'><td ></td>";
			for($j=0; $j<$num_columnas; $j++){
				$nom_columna		= $db->nom_columna($cursor_datos,$j);
				if($nom_columna!='privado_color'){
					$value				= $row_sumatoria[$nom_columna];
					if($value)			$value	=$sis_genericos->formato_numero($value,2);
	
					$txt_datos_tabla .=  "<td align='right' nowrap='nowrap' ><b>$value</b></td>";
				}
			}
			$txt_datos_tabla .=  "</tr>";
		}
		/*$tabla = "<div style='width:95%; margin:0px auto;'>$total_registros registros encontrados </div>
				<table align='center' id='reporte_tabla_$cod_tabla' bordercolor='$bordercolor' 
						width='$ancho_tabla' border='1' cellpadding='2' cellspacing='0' >
						$titulo_tabla$txt_datos_tabla</table>";*/
						
		if($total_registros == 1){
			$total_registros = $total_registros." Registro encontrado";
		}else{
			$total_registros = $total_registros." Registros encontrados";
		}
		
		$tabla = "
				<div style=' width:".$ancho_tabla."; text-align:left; margin:0px auto;'>
					<span class='combo_solicitud' >
						$total_registros &nbsp; - &nbsp;
						Registros por pagina 
						<input size='3' name='num_max_registros' value='".$num_max_registros."' 
								id='num_max_registros' type='text'> 
					</span> 
					
					<input type='button' value='Mostrar todo' name='' id='mostrar_todo' onclick='f_mostrar_todo(this);' />
				</div>
					
				<table class='tabla_reporte' align='center' id='reporte_tabla_$cod_tabla' bordercolor='$bordercolor' 
						width='".$ancho_tabla."' border='1' cellpadding='2' cellspacing='0' >
						
						<thead>$titulo_tabla</thead>
						
						<tbody>$txt_datos_tabla</tbody>
				</table>";
		return $tabla; 
	}	
	/*=====2008-12-17====================================D E C K===>>>>
	DESCRIPCION: 	Metodo para contruir la tabla desde una ventana emergente
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$resultado_cursor	 vector con los siguientes datos [NUM_REGISTROS] ,    [DATOS] => contine el cursor
	$cod_tabla			Codigo de la tabla autonoma con la que se esta trabajando
	$ancho_tabla		ancho en pixeles de la tabla html
	===========================================================================*/
	function f_generar_tabla_ventana_emergente(
			$resultado_cursor	,
			$cod_tabla			,
			$ancho_tabla		,
			$bordercolor		,
			$class_datos_tabla	
	){
		global $db;
		$sis_genericos 	= new sis_genericos;
		$cursor_datos	= $resultado_cursor['DATOS'];
		$total_registros= $resultado_cursor['NUM_REGISTROS'];
		// indica que al final del reporte no hay sumatorias (si hay variables tipo Numeric con formato cambia a true)
		$ind_sumatoria	= false; 
		$row_sumatoria	= array();
		$num_columnas	= $db->num_columnas($cursor_datos);
		//Obtiene las columnas de la tabla en forma de vector >>>
		$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		cod_tabla		= $cod_tabla
		order by 	num_orden_insert";
		$cursor_columnas		= $db->consultar($query);
		$num_registros 			= $db->num_registros($cursor_columnas);
		$array_info_columna		= array();
		for($i=0; $i<$num_registros; $i++){
			$row				= $db->sacar_registro($cursor_columnas,$i);
			$array_info_columna[$row['txt_nombre']] = $row;
		}

		$titulo_tabla	=	"<tr class='titulo_tabla'>";
		for($i=0; $i<$num_columnas; $i++){
			$nom_columna	= $db->nom_columna($cursor_datos,$i);
			$txt_alias		= $array_info_columna[$nom_columna]['txt_alias_corto'];
			if(!$txt_alias)		
				$txt_alias	= $array_info_columna[$nom_columna]['txt_alias'];
			if(!$txt_alias){
				$longitud	= strlen($nom_columna);
				$txt_alias	= substr($nom_columna,2,$longitud-2);
			}
			//==== Organiza el alias de la tabla para el ordenamiento diferenciando entre t y t2
			if($array_info_columna[$nom_columna]['cod_tabla'] == $cod_tabla)  	$t="t.";
			else																$t="";
			
			$txt_alias		= strtoupper($txt_alias);
			$txt_alias		= str_replace("_"," ",$txt_alias);
			$txt_alias		= str_replace("ACUTE;","acute;",$txt_alias);
			$titulo_tabla	.= "<td align='center'  >
			<table  class='titulo_tabla'>
			<tr>
				<td align='center' valign='top' >$txt_alias</td>
				
				<td><table>
					<tr>
						<td><a  title='Click para ordenar por $txt_alias' href=\"javascript:f_ordenar_por('$t$nom_columna asc')\">
						<img src=\"../../imagenes/sistema/flecha_tabla2.jpg\" border=0 /></a></td>
					</tr>
					<tr>
						<td><a  title='Click para ordenar por $txt_alias' href=\"javascript:f_ordenar_por('$t$nom_columna desc')\">
						<img src=\"../../imagenes/sistema/flecha_tabla.jpg\" border=0 /></a></td>
					</tr>
					</table>
				</td>
			</tr></table>
			</td>";
		}
		$titulo_tabla	=	"$titulo_tabla</tr>";
		
		// Genera datos de la tabla>>>		
		$num_registros 			= $db->num_registros($cursor_datos);
		$arr_estandar_celda		= array();
		for($i=0; $i<$num_registros; $i++){
			$row_dato	= $db->sacar_registro($cursor_datos,$i);
			$txt_datos_tabla .=  "<tr class='$class_datos_tabla'>";
			for($j=0; $j<$num_columnas; $j++){
				$nom_columna		= $db->nom_columna($cursor_datos,$j);
				$row_info_columna	= $array_info_columna[$nom_columna];
				$txt_nombre_columna	= $row_info_columna['txt_nombre'];
				$value				= $row_dato[$txt_nombre_columna];
				//=== Evalua situaciones con campos que no estan registrados y que vienen en la consulta con el codigo del tipo en el nombre de la columna
				if(!$row_info_columna['cod_tipo_dato_columna']){
					$cod_tipo_dato	 	= substr($nom_columna,0,2);
					$cod_tipo_dato		=  round($cod_tipo_dato,0);
					$row_info_columna['cod_tipo_dato_columna'] = $cod_tipo_dato;
				}
				if(!$value)				$value	= $row_dato[$j];	
				//=== Evalua sumatoria al final de la consulta >>>
				if($row_info_columna['cod_tipo_dato_columna'] 	== 2 || (is_numeric($value) && $row_info_columna['cod_tipo_dato_columna'] 	== 4  )){
					$row_sumatoria[$nom_columna] 	+= 	$value;
					$ind_sumatoria					= 	true;				
				}
								
				//=== Alineacion y formato de la informacion a mostar en la celda >>>
				$arr_estandar_celda	= $this->f_estandar_campo_reporte($row_info_columna['cod_tipo_dato_columna'] , $value);
				$value				= $arr_estandar_celda['VALUE'];
				$align				= $arr_estandar_celda['ALIGN'];
				$nowrap				= $arr_estandar_celda['NOWRAP'];
				//=== Evalua el enlace con el PK >>>
				if($row_info_columna['ind_pk'] ){
					//== Tiene que recorrer el vector que lleva los datos porque hay un campo numerico y otro con texto entonces se repite la informacion >>>
					$tmp_pk	= array();
					for($k=0; $k<$num_columnas; $k++) {
						$tmp_pk[$k] = str_replace("'"," ",  $row_dato[$k]);// tambien evita problemas con comillas simples
						$tmp_pk[$k] = ucwords(strtolower($tmp_pk[$k]));//deja todo en mayuscula inicial 
					}
					$tmp_pk	=  	implode("','",$tmp_pk);
					$tmp_pk	=	"'$tmp_pk'";
					$value	= '<a href="javascript:enviar_datos('.$tmp_pk.')">'.$value.'</a>';
				}
				//=== Evalua el enlace con el PK en la siguiente columna >>>				
				if($j==1) $value	= '<a href="javascript:enviar_datos('.$tmp_pk.')">'.$value.'</a>';
				$txt_datos_tabla .=  "<td align='$align' $nowrap>$value</td>";
			}
			$txt_datos_tabla .=  "</tr>";
		}
		$tabla = "$total_registros registros encontrados <br />
				<table bordercolor='$bordercolor' width='$ancho_tabla' border='1' cellpadding='5' cellspacing='0'>					$titulo_tabla$txt_datos_tabla</table>";
		return $tabla; 
	}	
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene los valores asociados a un registro especifico
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
  	function f_get_valor_imput($cod_pk, $row_tabla_autonoma,$row_imputs){
		global $db;
		$obj_listbox			= new obj_listbox;
		$sis_genericos			= new sis_genericos;
		$txt_nombre_tabla		= $row_tabla_autonoma['txt_nombre'];
		$cod_tabla		= $row_tabla_autonoma['cod_tabla'];
		//=== Obtiene el nombre de la llave primaria de la tabla>>>
		$query 			="
		select 			* 
		from 			columna_tabla_autonoma
		where			ind_pk = 1
		and				cod_tabla	=	$cod_tabla";
		
		$row			= $db->consultar_registro($query);
		$txt_nombre_pk 	= $row['txt_nombre'];

		//=== Obtiene el valor actual del registro>>>
		$query 			="
		select 			* 
		from 			$txt_nombre_tabla
		where			$txt_nombre_pk	=	$cod_pk";
		$row_datos_registro		= $db->consultar_registro($query);

		//=== Consulta para recorrer cada columna >>>
		$query ="
		select 		* 
		from 		columna_tabla_autonoma
		where		cod_tabla	=	$cod_tabla
		and			ind_visible_form = 1
		order by 	num_orden_insert";

		$cursor_columnas		= $db->consultar($query);
		$num_registros 			= $db->num_registros($cursor_columnas);
		for($i=0; $i<$num_registros; $i++){

			$row_info_columna						= $db->sacar_registro($cursor_columnas,$i);
			$txt_nombre_columna						= $row_info_columna['txt_nombre'];
			$value									= $row_datos_registro[$txt_nombre_columna];
			//== si es INT le da formato al numero >>>
			if($row_info_columna['cod_tipo_dato_columna']==2 ){ 

				$value = $sis_genericos->formato_numero($value,2);


			
			}
			//== si una LISTA DE VALOR actualiza el campo de texto>>>
			if($row_info_columna['cod_tipo_dato_columna']==7){
				//== busca el quiery que trae el nombre >>>
			  	$query		= $row_info_columna['txt_script_lista_valor'];
				$query		= str_replace("value_columna",$value,$query);
				
				// solo si existe valor
				if($value)$row_nmbre = $db->consultar_registro($query);

				$info_nmbre	= $row_nmbre['txt_nombre']; 
				//== Remplaza el campo de nombre >>>				
				$row_imputs[$txt_nombre_columna]['input']=
				str_replace("txt_value_columna",$info_nmbre,$row_imputs[$txt_nombre_columna]['input']);


			}
			//== si es un archivo de fotos genera enlace para ver la foto >>>
			if($row_info_columna['cod_tipo_dato_columna']==9 && $value){
				//== busca el quiery que trae el nombre >>>
				$num_carpeta_interna	= (round($cod_pk/100))+1;
			  	$row_imputs[$txt_nombre_columna]['input'] .= 
				"<a href=".'"'."javascript:ver_foto('$value','$txt_nombre_columna')".'"'."> Ver Foto</a>";
				//== Remplaza el campo de nombre >>>				
				$row_imputs[$txt_nombre_columna]['input']=
				str_replace("txt_value_columna",$info_nmbre,$row_imputs[$txt_nombre_columna]['input']);

			}
			//== si es un archivo de fotos genera enlace para ver la foto >>>
			if($row_info_columna['cod_tipo_dato_columna']==13 && $value){
				//== busca el quiery que trae el nombre >>>
				$num_carpeta_interna	= (round($cod_pk/100))+1;
				$value					="../../audio/$txt_nombre_tabla/carpeta_$num_carpeta_interna/$value";
			  	$row_imputs[$txt_nombre_columna]['input'] .= 
				" <a href='javascript:f_escuchar_mp3(".'"'.$value.'","'.$txt_nombre_columna.$cod_pk.'"'.")'>
				  <img id='$txt_nombre_columna$cod_pk' src='../../imagenes/sistema/stop_sound.png' border='0' /></a>";
				//== Remplaza el campo de nombre >>>				
				$row_imputs[$txt_nombre_columna]['input']=
				str_replace("txt_value_columna",$info_nmbre,$row_imputs[$txt_nombre_columna]['input']);

			}
			//== si un combo tipo CELULAR >>>
			if($row_info_columna['cod_tipo_dato_columna']==10){
				//== busca el quiery que trae el nombre >>>
				$value_operador	= $value[0].$value[1].$value[2];
				$value 			= $value[3].$value[4].$value[5].$value[6].$value[7].$value[8].$value[9];
				$row_imputs[$txt_nombre_columna]['input']= 
				str_replace("adicional",  $value_operador,  $row_imputs[$txt_nombre_columna]['input']);

			}

			if($row_imputs[$txt_nombre_columna]['cursor']){
				$max_length = $row_info_columna['max_length']; // numero maximo de caracteres permitidos
				$value=$obj_listbox->f_crear_lista_limite_caracteres($row_imputs[$txt_nombre_columna]['cursor'], $value, $max_length);
			}
			
			$row_imputs[$txt_nombre_columna]['input']= 
			str_replace("value_columna",$value,$row_imputs[$txt_nombre_columna]['input']);	
			
		}	
		


		return $row_imputs;
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Metodo que retorna todos los imputs en forma de detalle
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO					DESCRIPCION 
	$cod_pk_maestro				Codigo del primary key masestro
	$cod_tabla_maestro			codigo de la tabla maestro que debe tener el pk
	$cod_navegacion				codigo de la navegacion donde se mostraran los imput
	$post						variables en el formato post que debe tener la informacion	
								funciona para variables cargadas dede la base de datos o
								al refrescar pantalla
	$ind_pantalla_refrescada 	indica si la pantalla fue refrescada para que use los valores del vector $_POST	
	===========================================================================*/
  	function 	f_dar_formato_imputs_tabla_detalle(
				$cod_pk_maestro		,
				$cod_tabla_maestro	,
				$cod_tabla_detalle	,
				$cod_navegacion		,
				$post				,
				$ind_pantalla_refrescada
	){
		global $db;
		

		
		$tabla_autonoma			= new tabla_autonoma;
		//== Nombre columna PK del maestro >>>
		$row_pk_maestro				= $this->f_get_row_pk($cod_tabla_maestro);
		$nom_pk_maestro				= $row_pk_maestro['txt_nombre'];

		//== Info TABLA DETALLE >>>
		$row_tabla_detalle			= $tabla_autonoma->f_get_row($cod_tabla_detalle);
		$nom_tabla_detalle			= $row_tabla_detalle['txt_nombre'];

		
		//== Obtiene VALORES DEL DETALLE >>>
		$cursor_valores_detalle		= $this->f_get_valores_detalle($nom_tabla_detalle, $nom_pk_maestro, $cod_pk_maestro);
		$num_registros_detalle		= $db->num_registros($cursor_valores_detalle);

		//=== Si no refrescaron la pantalla consigue información de la base de datos >>>
		if(!$ind_pantalla_refrescada){ 	
			$post	= 	$this->f_get_valor_imput_detalle(
						$cod_pk_maestro		,
						$cod_tabla_maestro	,
						$cod_tabla_detalle	
						);
		}		

		$row_imputs_detalle	=	$this->f_get_imputs_tabla_detalle(
								$cod_tabla_maestro	,
								$cod_tabla_detalle	,
								$cod_navegacion		,
								$post				,
								$num_registros_detalle
								);
		//=== Tabla con los imputs listos para ingresar y consultar informacion
		$tabla			= $this->f_generar_tabla_detalle($row_imputs_detalle,$cod_tabla_detalle);
		return $tabla; 
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Remplaza los valores de cada detalle en el campo imput
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$cod_tabla_maestro	codigo de la tabla maestro que debe tener el pk
	$cod_navegacion		codigo de la navegacion donde se mostraran los imput
	$post				variables en el formato post que debe tener la informacion	
						funciona para variables cargadas dede la base de datos o
						al refrescar pantalla
	===========================================================================*/
  	function 	f_get_imputs_tabla_detalle(
				$cod_tabla_maestro	,
				$cod_tabla_detalle	,
				$cod_navegacion		,
				$post				,
				$num_registros_detalle = NULL
	){
		

		global $db;
		$obj_listbox		= new obj_listbox;
		$sis_genericos		= new sis_genericos;
		$tabla_autonoma		= new tabla_autonoma;
		$array_retorno		= array(); //vector donde se regresara toda la informacion >>>
		$row_imput			= array(); //Vector con los imput modificados >>>
		$row_alias			= array(); //vector con los alias de cada campo >>>
		$ros_codigo_columna	= array(); //usado para darle un indice a cada columna y luego poder remplazar en un ciclo el imput y el alias

		//== Nombre columna PK del Maestro >>>
		$row_pk_maestro				= $this->f_get_row_pk($cod_tabla_maestro);
		$nom_pk_maestro				= $row_pk_maestro['txt_nombre'];

		//== Nombre de la tabla detalle>>>
		$tabla_autonoma				= new tabla_autonoma;
		$row_info_tabla_detalle		= $tabla_autonoma->f_get_row($cod_tabla_detalle);
		$txt_tabla_detalle			= $row_info_tabla_detalle['txt_nombre'];

		//== Obtiene las colummas a mostrar en la pantalla >>>		
		$cursor_columnas	= $this->f_get_columnas_formulario($cod_tabla_detalle,$cod_navegacion);
		//=== Recorre cada Registro >>>
		$num_registros 		= $db->num_registros($cursor_columnas);
		
			

			$pos_registro_detalle = 0;			
			for($i=0; $i<$num_registros; $i++){

				//== Obtiene las variables a usar mas adelante >>>
				$row_info_columna		= $db->sacar_registro($cursor_columnas,$i);
				$nom_columna			= $row_info_columna['txt_nombre'];
				
				
				//=== No tiene en cuenta el campo PK de la tabla maestro >>>	
				if($row_info_columna['txt_nombre'] != $nom_pk_maestro){
					
					array_push($ros_codigo_columna,$nom_columna);
						
					//== Recorre todos los valores sobre cada columna >>>
					$num_registros_columna	= count($post[$nom_columna]);
					if($num_registros_columna==0) $num_registros_columna=1;

					// reinicia el contador para las posicionces
					if($pos_registro_detalle == $num_registros_columna)$pos_registro_detalle = 0;	
					
					
					for($j=0; $j<$num_registros_columna; $j++){
		
						//=== No le coloca alias a los campos ocultos >>>	
						if($row_info_columna['ind_pk'])	{
							$ind_imput_oculto	= 1;
							$cod_pk_detalle[$j]	= $post[$row_info_columna['txt_nombre']][$j];
						}else{
							$ind_imput_oculto=0;
							$row_alias[$nom_columna]= $row_info_columna['txt_alias'];
						}	

						// valor sacado del vector post y de indice el nombre de la columna
						// por cada registro del detalle que haya			
						$value							= 	$post[$nom_columna][$j];
	
						$row_imput[$nom_columna][$j] 	= 	$this->f_generar_imput_con_valor(
																	$row_info_columna		, 
																	$value					, 
																	$ind_imput_oculto		, 
																	1						,
																	$cod_pk_detalle[$j]		,
																	$txt_tabla_detalle		,
																	$pos_registro_detalle								
																	
																	);

						//=== Hace que la variable se convierta en un vector >>>
						$info_combo		= $row_imput[$nom_columna][$j];
						$pos_registro_detalle++;
					}
					
	
					
			}
				

		}
		

		//=== Recorre cada imput con codigo y nombre  >>>
		$array_retorno['imput']	= $row_imput;
		$array_retorno['alias']	= $row_alias;		
		$array_retorno['codigo']= $ros_codigo_columna;

		return $array_retorno;
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene los valores asociados a un detalle y los retorna como lo
					tendria una variable post
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
  	function 	f_get_valor_imput_detalle(
				$cod_pk_maestro		,
				$cod_tabla_maestro	,
				$cod_tabla_detalle	
	){
		

		global $db;
		$tabla_autonoma			= new tabla_autonoma;
		//== Nombre columna PK del maestro >>>
		$row_pk_maestro				= $this->f_get_row_pk($cod_tabla_maestro);
		$nom_pk_maestro				= $row_pk_maestro['txt_nombre'];

		//== Info TABLA DETALLE >>>
		$row_tabla_detalle			= $tabla_autonoma->f_get_row($cod_tabla_detalle);
		$nom_tabla_detalle			= $row_tabla_detalle['txt_nombre'];
		

		//== Obtiene VALORES DEL DETALLE >>>
		$cursor_valores_detalle		= $this->f_get_valores_detalle($nom_tabla_detalle, $nom_pk_maestro, $cod_pk_maestro);
		
		//=== Recorre cada Registro >>>
		$num_registros 			= $db->num_registros($cursor_valores_detalle);
		$num_columnas 			= $db->num_columnas($cursor_valores_detalle);
		$array_datos			= array();
		if($num_registros==0){ 	
			$num_registros = 1;
			$ind_registro_en_blanco = true;			
		}
		for($i=0; $i<$num_registros; $i++){
			if(!$ind_registro_en_blanco) $row_detalle	= $db->sacar_registro($cursor_valores_detalle,$i);
			//=== Recorre cada columna >>>
			for($j=0; $j<$num_columnas; $j++){
				$nom_columna	= $db->nom_columna($cursor_valores_detalle,$j);

				$array_datos[$nom_columna][$i] = $row_detalle[$nom_columna];
			}
		}	

		return $array_datos;
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene el campo primari key de una tabla
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
	function f_get_row_pk($cod_tabla){
		global 					$db;
		$obj_listbox			= new obj_listbox;
		$sis_genericos			= new sis_genericos;

		//=== Obtiene el nombre de la llave primaria de la tabla>>>
		$query 			="
		select 			* 
		from 			columna_tabla_autonoma
		where			ind_pk = 1
		and				cod_tabla	=	$cod_tabla";
		
		$row			= $db->consultar_registro($query);
		return $row;
	}
	/*=====2008/12/15========================================D E C K===>>>>
	DESCRIPCION: 	Metodo para obtener los registros de una tabla especifica
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
  	function f_get_valores_detalle($nom_tabla_detalle, $nom_pk_maestro, $cod_pk_maestro){
		global $db;

		//=== Evalua cualquier condiciona adicional>>>
		$cod_tabla_detalle 	= $_REQUEST['cod_tabla_detalle'];
		$cod_navegacion		= $_REQUEST['cod_navegacion'];	
		
				
		$query ="
		select 		* 
		from 		$nom_tabla_detalle
		where		$nom_pk_maestro = $cod_pk_maestro";

		
		$cursor	 = $db->consultar($query);	
		return $cursor;
	}	
	/*=====2009/01/11========================================D E C K===>>>>
	DESCRIPCION: 	Obtiene las columnas que se deben mostrar en un formulario especifico
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$cod_tabla			Codigo de la tabla a la cual pertenecen las columnas
	$cod_navegacion		pantalla en la que se esta trabajando
	$cod_tabla_detalle	Tabla de detalle que se va a mostrar en la forma por defecto es el codigo 
						de la misma tabla que indica que no tiene relacionado un detalle
	===========================================================================*/
  	function f_get_columnas_formulario($cod_tabla,$cod_navegacion, $cod_tabla_detalle=NULL,$ind_registro=NULL){
		if(!$cod_tabla_detalle) $cod_tabla_detalle = $cod_tabla;
		global $db;
		
		if($ind_registro == TRUE){$condicion = "and cta.ind_visible_form = 1";}
		
		$query ="
		select 		* 
		from 		columna_tabla_autonoma	cta,
					columna_por_navegacion	cpn
		where		cpn.cod_columna_tabla	= cta.cod_columna_tabla
		and			cpn.cod_navegacion		= $cod_navegacion
		and			cpn.cod_tabla_detalle	= $cod_tabla_detalle
		and			cta.cod_tabla			= $cod_tabla
		$condicion
		and			cpn.ind_activo			= 1
		order by 	cpn.num_orden";
		$cursor	 = $db->consultar($query);	
		return $cursor;
	}	
	/*=====2009/01/08========================================D E C K===>>>>
	DESCRIPCION: 		De acuerdo a las caracteristicas de la columna entrega el imput requerido con su valor asociado
	AUTOR:				Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$row_info_columna	Informacion de la columna
	$value				Valor que debe asociar al imput
	$ind_imput_oculto	indica si debe retornar un imput oculto
	$ind_vector			Indica si la variable debe ser retornada en forma de vector
	===========================================================================*/
  	function f_generar_imput_con_valor(
						$row_info_columna				, 
						$value							,		 
						$ind_imput_oculto				,
						$ind_vector						,
						$cod_pk_detalle=NULL			,		 
						$txt_tabla_detalle=NULL			,
						$pos_registro_detalle = NULL 	
						
						){
		if(!$row_info_columna) return false;
		global $db;		
		$obj_listbox			= new obj_listbox;
		$sis_genericos			= new sis_genericos;
		$txt_nombre_columna		= $row_info_columna['txt_nombre'];
		$max_length				= $row_info_columna['max_length'];
		$txt_script_cursor		= $row_info_columna['txt_script_cursor'];
		$cod_ventana_emergente	= $row_info_columna['cod_ventana_emergente'];
		$cod_tabla				= $row_info_columna['cod_tabla'];
		$txt_js_onblur			= $row_info_columna['txt_js_onblur'];
		$cod_tipo_dato_columna	= $row_info_columna['cod_tipo_dato_columna'];
		$ind_bloqueado			= $row_info_columna['ind_bloqueado'];
		$txt_script_lista_valor	= $row_info_columna['txt_script_lista_valor']; 
		$txt_script_cursor		= $row_info_columna['txt_script_cursor']; 
		$ind_readonly			= $row_info_columna['ind_readonly']; 
		$ind_not_null			= $row_info_columna['ind_not_null']; 
		$txt_placeholder		= $row_info_columna['txt_placeholder'];
		$ind_unique				= $row_info_columna['ind_unique'];
		$num_size_input			= $row_info_columna['num_size_input'];
		
		if($ind_not_null == 1)	$required = "required='required'";
		else					$required = "";
		
		// id del input
		$txt_attr_id	= $txt_nombre_columna;
		
		//=== Evalua si el campo debe quedar bloqueado>>>
		if($ind_bloqueado == 1 || $ind_readonly)	$readonly = "readonly=true";
		else													$readonly = FALSE;
		//=== Evalua si debe poner cuadro en forma de vector>>>
		$info_nombre_columna	= $txt_nombre_columna; //para eliminacion de la foto
		if($ind_vector == 1){

			$txt_attr_id		= $txt_nombre_columna."_".$pos_registro_detalle;
			$txt_class			= $txt_nombre_columna;
			$txt_nombre_columna = $txt_nombre_columna."[]";

		}
		else	$ind_vector			= 0;//por si esta en nulo
		//=== Evalua comportamiento JavaScript personalizaddo por campo>>>		
		if($txt_js_onblur)	$onBlur_txt_js = "onBlur = '$txt_js_onblur'";
		//=== Evalua campo oculto PK>>>
		if($ind_imput_oculto == 1){
			$input	= 
				"<input 	name		='$txt_nombre_columna' 
							type		='hidden' 
							value		='$value'/>";
		}
		//=== Evalua datos tipo HORA>>>
		else if($cod_tipo_dato_columna == 14){
			$input		= 
			"<input 	type		='text' 
						class		='combo' 
						$required
						name		='$txt_nombre_columna'  
						id			='$txt_nombre_columna'  
						value		='$value'
						$onBlur_txt_js
						$readonly
						maxlength	='$max_length'
						onKeyUp		=\"mi_mascara(this, '00:00:00');\" 
						onKeyDown	=\"mi_mascara(this, '00:00:00');\"						
						/>";
						
		}
		//=== Evalua datos tipo ARCHIVO MP3 >>>
		else if($cod_tipo_dato_columna == 13){
			$num_carpeta_interna	= (round($cod_pk_detalle/100))+1;
			$ruta_completa			="../../audio/$txt_tabla_detalle/carpeta_$num_carpeta_interna/$value";
			$input					="
			<input  type='hidden' name='$txt_nombre_columna' value='$value' />
			<input name='file_$txt_nombre_columna' $acum_txt_js_onblur type='file' class='combo' />";
			if($value)
			$input					.="
			<a href='javascript:f_escuchar_mp3(".'"'.$ruta_completa.'","'.$txt_nombre_columna.$cod_pk_detalle.'"'.")'>
			<img id='$txt_nombre_columna$cod_pk_detalle' src='../../imagenes/sistema/stop_sound.png' border='0' /></a>";
		}
		//=== Evalua datos tipo ARCHIVO >>>
		else if($cod_tipo_dato_columna == 9){
			$input					.= 	"
			<input  type='hidden' name='$txt_nombre_columna' value='$value' />
			<input name='file_$txt_nombre_columna' $acum_txt_js_onblur type='file' class='combo' />";
			if($value){
				//== busca el quiery que trae el nombre >>>
				$num_carpeta_interna	= 	(round($cod_pk_detalle/100))+1;
				$value					=	"../../imagenes/$txt_tabla_detalle/carpeta_$num_carpeta_interna/$value";
			  	$input 					.=	"<a href=".'"'."javascript:ver_foto('$value','$info_nombre_columna','$cod_pk_detalle')".'"'."> 
									<img src='../../imagenes/sistema/lupa.png' border='0' />
				</a>";
			}			
		}
		//=== Evalua datos tipo DATETIME CON FORMATO >>>
		else if($cod_tipo_dato_columna == 8){
			if(!$readonly)
			$boton	= "<input 		$readonly class='contenido' 
						name		='boton_fecha' 
						$required
						type		='button' 
						onclick		=\"displayCalendar(document.form1.$txt_nombre_columna,'yyyy-mm-dd hh:ii:00',this,true)\" 
						value		='Call' />";
			//== on Blur genrico y el que se pasa desde la base de datos >>>
			if($onBlur_txt_js)		  $onBlur_txt_js ="onBlur	='comportamiento_combo_numerico(this,2,event); $txt_js_onblur; ";						
			$input	= 
			"<input 	name		='$txt_nombre_columna'  
						type		='text' class='combo'  
						$required
						onfocus		=\"javascript:vDateType=3;closeCalendar();displayCalendar(this,'yyyy-mm-dd hh:ii:00',this,true)\"						
						onblur		='DateFormat(this,this.value,event,true,2)' 
						value		='$value' 
						$readonly
						size		='12' />";
		}
		//=== Evalua datos combos con VENTANA EMERGENTE >>>
		else if($cod_tipo_dato_columna == 7){
			$query				= str_replace("value_columna",$value,$txt_script_lista_valor);
			$row_nmbre			= $db->consultar_registro($query);
			$txt_value_columna	= $row_nmbre['txt_nombre']; 
			if(!$onBlur_txt_js)		  $onBlur_txt_js ="onBlur		='ver_valor_iframe(this,$ind_vector)'";
			$input	= 
			"<input type		='text' 
					class		='combo' 
					$readonly
					$required
					id			='$txt_nombre_columna' 
					name		='$txt_nombre_columna' 
					$onBlur_txt_js
					value		='$value' 
					size		='3' /><input 	
					class		='combo' 
					name		='txt_$txt_nombre_columna' 
					id			='txt_$txt_nombre_columna' 
					type		='text' 
					value		='$txt_value_columna' 
					size		='30' 
					readonly	='true' /><input 	class		='contenido'  
					name		='button2' 
					type		='button' 
					onclick		=".'"ver_lista_valor('.$cod_ventana_emergente.','."'$txt_nombre_columna',this,$ind_vector)".'"'." value='Call' />";
		}
		//=== Evalua datos tipo TEXT >>>
		else if($cod_tipo_dato_columna == 6){
			$input	= 
			"<textarea 	class	='combo'
						$required
						name	='$txt_nombre_columna' 
						id		='$txt_nombre_columna' 
						cols	='30' 
						$onBlur_txt_js
						$readonly							
						>$value</textarea>
			<script> CKEDITOR.replace( '$txt_nombre_columna',{skin : 'office2003'});</script>						
			";
		}
		//=== Evalua datos tipo NUMERIC SIN FORMATO >>>
		else if($cod_tipo_dato_columna == 5){
			
			if(!$txt_placeholder)$txt_placeholder = "Campo Numerico";
			$input		= 
			"<input 	type			='text' 
						class			='combo' 
						$required
						name			='$txt_nombre_columna' 
						autocomplete	='off'
						placeholder		= '".$txt_placeholder."'
						id				= '$txt_attr_id' 
						value			='$value'
						$onBlur_txt_js
						$readonly
						maxlength	='$max_length'/>
				
				<script>
					$(function(){
						$('#".$txt_attr_id."').keyup(function(){
							

							var value	= $(this).val();

							// expresion para aceptar decimales (separado por punto) y enteros
							var expreg = /^\d+\.?\d*$/;
						  	
						 	if(value != ''){
						  		if(expreg.test(value) ){
									//alert('Correcto');
								}else{
									
									ind_coma 	= value.indexOf(',');    
									ind_punto	= value.indexOf('.');

									if(ind_coma > 0){
										alert('Error: Solo es permitido separar los decimales con punto (.)');
									}else if(ind_punto >= 1){
										alert('Error: Solo es permitido un punto (.)');
									}else{
										alert('Error: Caracter no valido');
									}
									this.value = value.substring(0,value.length-1);
								}
							}
							


						})
					})
				</script>
			
			";
		}
		//=== Evalua datos tipo LISTBOX >>>
		else if($cod_tipo_dato_columna == 4){

			$cursor_listbox		= 	$db->consultar($txt_script_cursor);
			$max_length			= $row_info_columna['max_length']; // numero maximo de caracteres permitidos
			$value_listbox		=	$obj_listbox->f_crear_lista_limite_caracteres($cursor_listbox, $value, $max_length);
			

			$input				= 
			"<select $required class='combo $txt_class' name='$txt_nombre_columna' id='$txt_attr_id' $onBlur_txt_js>
			 <option value='-1' selected='selected'></option>
			$value_listbox</select>	";
			
			if($ind_unique == 1){
				$input .= '
					
			<script>
				$(function(){
				
					var trs_tabla_detalle = $("#tabla_detalle_'.$cod_tabla.' tbody > tr:not(\'.titulo_tabla_detalle\')");

					var combo_select = $("select[name=\''.$txt_nombre_columna.'\']");
					
					$("#tabla_detalle_'.$cod_tabla.'").delegate("select[name=\''.$txt_nombre_columna.'\']","change",function(){

						var value = $(this).val();
						var error = 0
						
						$("select[name=\''.$txt_nombre_columna.'\']").each(function(index,element){
							//alert($(element).attr("id"));						
							var a = $(element).val();					
							//alert(a+" -- "+value);
							if(a == value){
								error++
							}
						});
						
						if(error > 1){
							alert("El registro ya fue seleccionado");
							$(this).val("");
						}
					
					});
												
				})
							
			</script>	';
			}
			
			
			
			
			
		}
		//=== Evalua datos tipo DATE CON FORMATO >>>
		else if($cod_tipo_dato_columna == 3){
			if(!$readonly)
			/*
			$boton	= "<input 		$readonly class='contenido' 
						name		='boton_fecha' 
						type		='button' 
						onclick		=\"displayCalendar(document.form1.$txt_nombre_columna,'yyyy-mm-dd',this,false)\" 
						value		='Call' />";*/
			//== on Blur genrico y el que se pasa desde la base de datos >>>
			if($onBlur_txt_js)		  $onBlur_txt_js ="onBlur	='comportamiento_combo_numerico(this,2,event); $txt_js_onblur; ";						
			$input	= 
			"<input 	name		='$txt_nombre_columna'  
						type		='text' class='combo'  
						$required
						onfocus		=\"javascript:vDateType=3;closeCalendar();displayCalendar(this,'yyyy-mm-dd',this,false)\"
						onblur		='DateFormat(this,this.value,event,true,2)' 
						onkeyup		='DateFormat(this,this.value,event,false,2)' 
						value		='$value' 
						$readonly
						size		='10' />";
		}
		//=== Evalua datos tipo NUMERIC CON FORMATO >>>
		else if($cod_tipo_dato_columna == 2){
			$value	= str_replace(",","",$value);// quita las comas por si esta refrescando pantalla y luego le da nuevamente formato	
			//=== evalua con is_numeric para evitar que le ponga cero a un valor nulo >>>
			if(is_numeric($value))	$value	= $sis_genericos->formato_numero($value,2);
			$input	= 
			"<input 	type		='text' 
						class		='combo' 
						name		='$txt_nombre_columna'  
						$required
						placerholde = 'Campo Numerio'
						id			= '$txt_attr_id'
						value		='$value'
						$readonly
						maxlength	='$max_length'
						onkeyup		='comportamiento_combo_numerico(this,2,event)' 
						$onBlur_txt_js
						onfocus		='comportamiento_combo_numerico(this,2,event)' />";
		}
		//=== Evalua datos tipo VARCHAR >>>
		else if($cod_tipo_dato_columna == 1){
			$input	= 
			"<input 	name		='$txt_nombre_columna' 
						type		='text' 
						id			= '$txt_attr_id' 
						$required
						$readonly
						$onBlur_txt_js
						class		='combo' 
						value		='$value' 
						maxlength	='$max_length'/>";
		}//=== Evalua datos tipo AUTOCOMLETE (utilizando ajax) >>>
		else if($cod_tipo_dato_columna == 17){
			
			if($ind_hidden == true)	$type = 'hidden';
			else 					$type='text';
			
			$row_imput['input']	= 
			"<input 	name		='$txt_nombre_columna' 
						id			='$txt_nombre_columna' 
						type		='$type'
						$txt_placeholder
						$txt_js_onkeyup
						
						$readonly
						$acum_txt_js_onblur
						class		='$estilo_input' 
						value		='value_columna' 
						size		='22'
						$max_length/>
						
			<div id='autocomplete_$txt_nombre_columna'></div>
			
			";

		}
		
		//=== Evalua datos tipo SELECT  CON BUSCADOR >>>
		else if($cod_tipo_dato_columna == 19){
			
			$cod_columna_tabla = $row_info_columna['cod_columna_tabla'];
			if($txt_js_onblur) 	$on_change = "onchange=$txt_js_onblur";
			else				$on_change = "";
			if($readonly) 		$on_change = "onClick=\"alert('Acceso Denegado')\"";
			if($multiple){	
				$ind_multiple = "[]";}else{$ind_multiple = "";
			}
			
			$txt_nom_col		= str_replace('[]','',$txt_nombre_columna);
			if(!$txt_placeholder){
				$txt_placeholder = "Escriba su busqueda...";
			}
			//$cursor_listbox		= 	$db->consultar($txt_script_cursor);
			//$max_length			= $row_info_columna['max_length']; // numero maximo de caracteres permitidos
			//$value_listbox		=	$obj_listbox->f_crear_lista_limite_caracteres($cursor_listbox, $value, $max_length);
			
			//$row_imput['cursor']	= $db->consultar($txt_script_cursor);
			/*$input	= 
			"
			
			
			<select class='select2_$txt_nom_col $txt_nom_col' 		
					$required 
					$on_change 
					data-plugin='select2'
					name='$txt_nombre_columna' 
					placeholder='$txt_placeholder'
					id='$txt_attr_id' 
			>
			 <option value=''></option>
			$value_listbox
			</select>
			
			
			
			";*/
			
			
			if(!$num_size_input || $num_size_input == 0){
				$num_size_input = '\'element\'';
			}


			/// ==== CONDICION ESPECIAL PARA DESARROLLO DE CARDONA CONDICION DE UNIDAD DE NEGOCIO PARA FILTRAR MAYOR INFORMACION
			if(isset($_REQUEST['cod_unidad_negocio'])){
				$cod_unidad_negocio = $_REQUEST['cod_unidad_negocio'];
				$cod_unidad_negocio = ", cod_unidad_negocio: ".$cod_unidad_negocio;
			}

			

			
					
			
			$input = 
			"
			
			<input type='hidden' 
			name='$txt_nombre_columna' 
			 class='select2_$txt_nom_col $txt_nom_col select2' 
			id='$txt_attr_id' 
			value='$value' 
			data-plugin='select2'
			$required
			data-cod_columna_tabla='$cod_columna_tabla'
			
			data-placeholder='$txt_placeholder'>			
 
			
			<script>
			$(function(){
				
				
				$('#$txt_attr_id').select2({
						minimumInputLength : 0,
						allowClear: true,
						addSelectedTitle: true,
						//width: ".$num_size_input.",
						width: 340,
						/*formatSelection: function(item) {
					        // Debugging -- open the developer console to see what you can access from the item object
							
							var text_this = item.text;
							alert($(this).find('.select2-chose').length);
							$(this).find('.select2-chose').attr('title',text_this);

					       return item.text;
					       // return '<strong>' + item.id + '</strong>';
					    },*/
												
						ajax: {
						  url: '../consulta/consulta_script_columna.php',
						  dataType: 'json',
						  data: function (term, page) {
								
							return {
							  term: term,
							  cod_columna_tabla: ".$cod_columna_tabla."
							  ".$cod_unidad_negocio."
							};
						  },
						  results: function (data, page) {
						  	
						  	
						  	/*if(data.id == 0){ // si existe error no no hay registros
						  		return { results: '' };
						  		return false;
						  	}*/
							
							return { results: data.results };
						  }
						},
						initSelection: function(element, callback) {
							//console.log('../consulta/consulta_script_columna.php?cod_columna_tabla=$cod_columna_tabla&id=' + (element.val()));
							return $.getJSON('../consulta/consulta_script_columna.php?cod_columna_tabla=$cod_columna_tabla&id=' + (element.val()), null, function(data) {
									return callback(data);
				
							});
						}
					}).on('select2-open', function() {
					    	//alert('open');
							$('body').unbind('keyup',funcion_teclas); // frena el funcionamiento de teclas del body
							var a = $('#s2id_".$txt_nombre_columna."').find('.select2-chosen');
							$(a).tooltip().tooltip('close');
				     }).on('select2-close', function(e) {
							e.stopPropagation();
				          	setTimeout(function(){
								$('body').bind('keyup',funcion_teclas); // activa el funcionamiento de teclas del body 
								// $('.select2-container-active').removeClass('select2-container-active');
						        //$(':focus').blur();
							},1000);

						  
			        }).on('select2-selecting', function(e) {
				        // alert('selecting val=e.val choice=e.object.text');
						 //$(this).blur();
						

        			});
					
					
				});
			
			</script>";	

			

		}
		
		return $input;
	}
	/*=====2009/01/08========================================D E C K===>>>>
	DESCRIPCION: 		Recibe imputs de detalle con sus codigos y alias y los convierte 
						en una tabla para mostrarse en pantalla
	AUTOR:				Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$row_imputs_detalle	vector que debe venir con  [imput]  ,   [alias]   ,  [codigo]
	$cod_tabla_detalle	para que el id salga con el codigo de la tabla por si se usan varias tablas
	===========================================================================*/
  	function f_generar_tabla_detalle($row_imputs_detalle,$cod_tabla_detalle){
		global $db;		
		$num_columnas_detalle	= count($row_imputs_detalle['codigo']);
		$num_registros_detalle	= count($row_imputs_detalle['imput'][$row_imputs_detalle['codigo'][0]]);
		$arr_codigos			= $row_imputs_detalle['codigo'];
		$arr_imput				= $row_imputs_detalle['imput'];		
		$arr_alias				= $row_imputs_detalle['alias'];		
		$tabla					= "";

		//=== Genera el TITULO DE LA TABLA >>>
		$tabla .= "<tr class='titulo_tabla_detalle'>";
		for($i=0; $i<$num_columnas_detalle; $i++){
			$nom_campo	= $arr_codigos[$i];
			if($arr_alias[$nom_campo]) $tabla .= "<td nowrap='nowrap' >".$arr_alias[$nom_campo]."</td>";
		}
		$tabla .= "<td></td></tr>";		
		//=== Genera el CONTENIDO DE LA TABLA >>>
		for($j=0; $j<$num_registros_detalle; $j++){
			$tabla .= "<tr valign='top'   id='tabla_detalle_$cod_tabla_detalle"."_row_$j'>";
			for($i=0; $i<$num_columnas_detalle; $i++){
				$nom_campo	= $arr_codigos[$i];
				//=== Si no tiene titulo es un campo oculto>>>
				if(!$arr_alias[$nom_campo]) {
					$tabla .= "<td nowrap='nowrap' valign='middle'>".$arr_imput[$nom_campo][$j];	
					$i++;
					$nom_campo	= $arr_codigos[$i];
					$tabla 		.= $arr_imput[$nom_campo][$j]."</td>";	
				}else{
					$tabla .= "<td nowrap='nowrap' valign='middle'>".$arr_imput[$nom_campo][$j]."</td>";
				}	
			}
			//=== Botones para aumentar y quitar detalles
			$tabla .= "<td nowrap='nowrap' align='right'>
			<input class='contenido' name='mas'  type='button' onclick=".'"'."addRow(this,'tabla_detalle_$cod_tabla_detalle')".'"'." value='+' />
			<input class='contenido' name='menos' type='button' onclick=".'"'."eliminar_fila(this,'tabla_detalle_$cod_tabla_detalle')".'"'." value='-' />
			</td></tr>";
		}
		$tabla = "<table  id='tabla_detalle_$cod_tabla_detalle' class='tabla_detalle' width='100%' border='0' cellspacing='0' cellpadding='5'>$tabla</table>";
		return $tabla; 
	}	

	/*=====2009/01/08========================================D E C K===>>>>
	DESCRIPCION: 		Metodo para validar el una tabla detalle de un maestro especifico
	AUTOR:				Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO					DESCRIPCION 
	$cod_navegacion_formulario	Codigo de navegacion donde se diligencio el formulario
	$cod_tabla_detalle			Codigo de la tabla detalle
	$post						variables enviadas en $_POST
	$arr_mensajes				vector que tiene los mensajes actuales y almacena los nuvos mensajes
	$arr_parametro				vector que tiene los parametros de los mensajes actuales y almacena los nuvos parametros
	===========================================================================*/
  	function 	f_valida_tabla_detalle(
				$cod_navegacion_formulario	,
				$cod_tabla_detalle			,
				$post						,
				$arr_mensajes				,
				$arr_parametro		
	){
		global $db;		
		//=== Valida todas las columnas >>>
		$cursor_info_columnas	= $this->f_get_columnas_formulario($cod_tabla_detalle,$cod_navegacion_formulario);
		$num_registros 			= $db->num_registros($cursor_info_columnas);
		for($i=0; $i<$num_registros; $i++){
			$row_info_columna		= $db->sacar_registro($cursor_info_columnas,$i);

			$txt_nombre_columna		= $row_info_columna['txt_nombre'];
			$txt_alias_sin_vector	= str_replace("_"," ", $row_info_columna['txt_alias']);
			$ind_not_null			= $row_info_columna['ind_not_null'];
			$ind_pk					= $row_info_columna['ind_pk'];
			$ind_unique				= $row_info_columna['ind_unique'];
			$cod_tipo_dato_columna	= $row_info_columna['cod_tipo_dato_columna'];
			$num_detalles			= count($post[$txt_nombre_columna]);
			for($j=0; $j<$num_detalles; $j++){
				if($ind_pk) break; // pasa por alto la llave primaria porque esta puede ser nula y se generara al guardar el dato
				$value_columna			= $post[$txt_nombre_columna][$j];
				$txt_alias				= $txt_alias_sin_vector." ". ($j+1); //le pone un indice al alias ...
				if($value_columna===0) 	$value_columna = " 0";
				//=== Valida campos NULL >>>
				if($ind_not_null && $value_columna == NULL ){
					array_push($arr_mensajes,'1'); 						//Registra el codigo del mensaje que se debe mostrar
					array_push($arr_parametro,$txt_alias); 				//Nombre del campo not null
				}
				//=== Valida campos LISTBOX que no pueden ser NULL >>>
				else if($ind_not_null && $value_columna == -1 && $cod_tipo_dato_columna == 4){
					array_push($arr_mensajes,'1'); 				//Registra el codigo del mensaje que se debe mostrar
					array_push($arr_parametro,$txt_alias); 		//Nombre del campo not null
				}
		
				//=== Valida campos de TIPO NUMERICO CON Y SIN FORMATO >>>
				else if($cod_tipo_dato_columna == 2 || $cod_tipo_dato_columna == 5){
					$value_columna				= str_replace(",","",$value_columna);
					$value_columna				= ltrim(rtrim($value_columna));
					if(!is_numeric($value_columna) && $value_columna!=NULL){
						array_push($arr_mensajes,'6'); 						//MENSAJE ERROR CAMPO NUMERICO
						array_push($arr_parametro,$txt_alias); 				//Nombre del campo not null
					}
				}
				//=== Valida restriccion UNIQUE >>>
				else if( $ind_unique && $row_restringe_unique[0] ){
					array_push($arr_mensajes,'7'); 									//Registra el codigo del mensaje que se debe mostrar
					array_push($arr_parametro,$txt_alias); 							//Nombre del campo not null
				}	
			}	
		}
		$array_retorno = array();
		$array_retorno['arr_mensajes'] 	= 	$arr_mensajes;
		$array_retorno['arr_parametro'] = 	$arr_parametro;			
		return $array_retorno;
	}	
	/*=====2009/01/08========================================D E C K===>>>>
	DESCRIPCION: 		Valida los datos que se van a guardar en una tabla
	AUTOR:				Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO			DESCRIPCION 
	$cod_tabla			Codigo de la tabla  que se esta evaluando
	$post				variable que tiene toda la informacion
	$cod_pk				codigo de la llave primaria de la tabla 
	$arr_mensajes		Vector que trae errores de la forma y donde se incluiran los nuevos mensajes
	$arr_parametro		Parametros asociados a los errores de la forma
	===========================================================================*/
  	function 	f_valida_tabla(
				$cod_tabla			,
				$cod_tabla_detalle	,
				$post				,
				$cod_pk				,
				$arr_mensajes		,
				$arr_parametro		,
				$cod_navegacion_formulario
	){
		global $db;		
		//=== Valida todas las columnas >>>
		$cursor_info_columnas	= $this->f_get_columnas_formulario($cod_tabla,$cod_navegacion_formulario,$cod_tabla_detalle);
		$num_registros 			= $db->num_registros($cursor_info_columnas);
		for($i=0; $i<$num_registros; $i++){
			$row_info_columna		= $db->sacar_registro($cursor_info_columnas,$i);
			$txt_nombre_columna		= $row_info_columna['txt_nombre'];
			$txt_alias				= str_replace("_"," ", $row_info_columna['txt_alias']);
			$ind_not_null			= $row_info_columna['ind_not_null'];
			$ind_unique				= $row_info_columna['ind_unique'];
			$cod_tipo_dato_columna	= $row_info_columna['cod_tipo_dato_columna'];
			$value_columna			= $post[$txt_nombre_columna];
			if($value_columna===0) 	$value_columna == " 0";
	
			//=== Obtiene el registro que viola la restriccion UNIQUE >>>
			if($ind_unique){

				$row_restringe_unique	= 	$this->f_get_row_restriccion_unique(
											$cod_pk				,
											$row_info_columna	,
											$value_columna				
											);
			}

			//=== Valida campos NULL >>>
			if($ind_not_null && $value_columna == NULL ){
				array_push($arr_mensajes,'1'); 									//Registra el codigo del mensaje que se debe mostrar
				array_push($arr_parametro,$txt_alias); 							//Nombre del campo not null
			}
			//=== Valida campos LISTBOX que no pueden ser NULL >>>
			else if($ind_not_null && $value_columna == -1 && $cod_tipo_dato_columna == 4){
				array_push($arr_mensajes,'1'); 									//Registra el codigo del mensaje que se debe mostrar
				array_push($arr_parametro,$txt_alias); 							//Nombre del campo not null
			}
			//=== Valida campos de TIPO NUMERICO CON Y SIN FORMATO ADICIONALMENTE EVALUA CELULARES >>>
			else if($cod_tipo_dato_columna == 2 || $cod_tipo_dato_columna == 5 || $cod_tipo_dato_columna == 10){
				$value_columna				= str_replace(",","",$value_columna);
				$value_columna				= ltrim(rtrim($value_columna));
				if(!is_numeric($value_columna) && $value_columna!=NULL){
					array_push($arr_mensajes,'6'); 						//MENSAJE ERROR CAMPO NUMERICO
					array_push($arr_parametro,$txt_alias); 				//Nombre del campo not null
				}
			}
			//=== Valida restriccion UNIQUE >>>
			else if( $ind_unique && $row_restringe_unique[0] ){
				array_push($arr_mensajes,'7'); 									//Registra el codigo del mensaje que se debe mostrar
				array_push($arr_parametro,$txt_alias); 							//Nombre del campo not null
			}	
			//=== Evalua varchar sin numeros>>>
			if(	$cod_tipo_dato_columna == 15){
				$vr	= str_split($value_columna);
				if(	in_array("0",$vr)  	|| 	in_array("1",$vr) || in_array("2",$vr) ||in_array("3",$vr) 	|| 
					in_array("4",$vr) 	|| 	in_array("5",$vr) || in_array("6",$vr)  || in_array("7",$vr) || 
					in_array("8",$vr) 	||	in_array("9",$vr) 
				){
					array_push($arr_mensajes,'11'); 									//Registra el codigo del mensaje que se debe mostrar
					array_push($arr_parametro,$txt_alias); 							//Nombre del campo not null
				}
			}
		}
		$array_retorno = array();
		$array_retorno['arr_mensajes'] 	= 	$arr_mensajes;
		$array_retorno['arr_parametro'] = 	$arr_parametro;			
		return $array_retorno;
	}	
	/*=====2009/01/14====================================D E C K===>>>>
	DESCRIPCION: 	Recibe un tipo de dato y de acuerdo al valor recibido deja la cadena
					con el formato necesario para que se haga un updat o un insert
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO				DESCRIPCION 
	$cod_tipo_dato_columna	Tipo de dato a guardar
	$value 					Valor a guardar
	===========================================================================*/
  	function 	f_prepara_dato_para_database(
				$cod_tipo_dato_columna	,
				$value 					
	){
		$sis_genericos	= new sis_genericos;
		//=== Evalua tipo celular >>>
		if($cod_tipo_dato_columna == 10){
			if(!$value) 		$value = "NULL";
		}
		//=== Evalua IMPUTS (normalmente traen codigos) >>>
		if($cod_tipo_dato_columna == 4){
			if($value == -1) 		$value = "NULL";
		}
		//=== Evalua datos DATE >>>
		else if($cod_tipo_dato_columna == 3 || $cod_tipo_dato_columna == 8){
			if(!$value)		 		$value = "NULL";
			else					$value = "'$value 00:00:00'";
		}
		//=== Evalua datos NUMERICOS >>>
		else if($cod_tipo_dato_columna == 2 || $cod_tipo_dato_columna == 5){
			
			$value	= str_replace(",","",$value); // quita el separador de miles
			$value	= trim($value);
			if(!is_numeric($value))	$value = "NULL";
		}
		
		else if($cod_tipo_dato_columna == 7){
			if($value===NULL || $value==='')	$value = "NULL";
			else 				$value = "'$value'";	
		}
		
		
		//=== Evalua datos VARCHAR o TEXT o PASSWORD>>>
		else if(	$cod_tipo_dato_columna == 1 ||  
					$cod_tipo_dato_columna == 6 ||  
					$cod_tipo_dato_columna == 15
					
		 ){
			//=== Evita con caracteres especiales como ñ, espacios, etc >>>
			if(!$value){ 	
				$value = "NULL";
			}else{
				$value = trim($value); // limpia espacios al final y al principio de la cadena
				$value = "'$value'";
			}
		}
		//=== Evalua datos ARCHIVO>>>
		else if($cod_tipo_dato_columna == 9){
			//=== PENDIENTE POR EVALUAR ESTE TIPO DE DATO>>>
			if(!$value) 	$value = "NULL";
			else			$value = "'$value'";
		}
		//=== Evalua datos ARCHIVO MP3>>>
		else if($cod_tipo_dato_columna == 13){
			//=== PENDIENTE POR EVALUAR ESTE TIPO DE DATO>>>
			if(!$value) 	$value = "NULL";
			else			$value = "'$value'";
		}
		
		//=== Evalua datos PASSWORD>>>
		else if($cod_tipo_dato_columna == 16){
			
			//=== PENDIENTE POR EVALUAR ESTE TIPO DE DATO>>>
			if(!$value) 			$value = "NULL";
			else if($value[0]=='*')	$value = "'$value'"; //ya esta codificado
			else					$value = "password(SHA('$value'))";
		}
		
		else if($cod_tipo_dato_columna == 19){
			if(!$value) 			$value = "NULL";
			else					$value = "'$value'";
			
		}else{
			if(!$value) 			$value = "NULL";
			else					$value = "'$value'";
		}
		return $value;
	}
	
	
	/*=====2009/01/14====================================D E C K===>>>>
	DESCRIPCION: 	Modifica los datos del detalle de un formulario maestro de detalle
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
  	function p_guardar_detalle(
			$cod_tabla_maestro				,
			$cod_tabla_detalle				,
			$post							,
			$cod_pk_maestro					,
			$cod_navegacion_formulario		,
			$cod_usuario					,
			$arr_info_archivo
			
	){
		global $db;
		$sis_genericos			= new sis_genericos;
		$arr_columna_and_value	= array();
		$arr_query				= array();
		$arr_pk_detalle			= array();
		$arr_pk_modificados		= array(); // usado para eliminar los detalles que no fueron modificados
		$arr_info_columna		= array(); // Mete la informacion de las columnas en un vector para poder usarlo en varios ciclos
		$tabla_autonoma			= new tabla_autonoma;
		
		//Obtiene el nombre de la llave primaria de la tabla madre que seria llave foranea en el detalle>>>
		$row_pk				= 	$this->f_get_row_pk($cod_tabla_maestro);
		$nom_pk_maestro		=	$row_pk['txt_nombre'];

		//Obtiene las columnas de la tabla detalle >>>
		$cursor_columnas	= 	$this->f_get_columnas_formulario($cod_tabla_detalle,$cod_navegacion_formulario);
		$num_columnas 			= $db->num_registros($cursor_columnas);
		
		//Obtiene el nombre de la tabla detalle>>>
		$row_tabla_autonoma	=	$tabla_autonoma->f_get_row($cod_tabla_detalle);
		$nom_tabla_detalle	=	$row_tabla_autonoma['txt_nombre'];

		//convierte en vector la informacion de los campos de la tabla>>>
		for($i=0; $i<$num_columnas; $i++){
			$row_info_columna		= $db->sacar_registro($cursor_columnas,$i);
			$arr_info_columna[$i]	= $row_info_columna;
			//Obtiene la cantidad de detalles que debera guardar >>>
			if(!$num_detalles){
				$txt_nombre_columna		= $row_info_columna['txt_nombre'];
				$num_detalles			= count($post[$txt_nombre_columna]);

			}
		}
		//=== Recorre todos los registros del detalle >>>
		for($j=0; $j<$num_detalles; $j++){
			$ind_insert = 0; 	//para indicar si el registro se va a actualizar o se va a hacer un insert
			$arr_col_insert	= array();
			$arr_val_insert	= array();
			$arr_update		= array();
			$nom_pk_detalle	= "";
			$val_pk_detalle	= "";
			for($i=0; $i<$num_columnas; $i++){
				$row_info_columna		= 	$arr_info_columna[$i];
				$ind_pk					= 	$row_info_columna['ind_pk'];
				$cod_tipo_dato_columna	= 	$row_info_columna['cod_tipo_dato_columna'];
				$txt_nombre_columna		=	$row_info_columna['txt_nombre'];
				
				//== valor del campo del registro seleccionado >>>
				$value					= 	$post[$txt_nombre_columna][$j];
				$value					= 	$this->	f_prepara_dato_para_database(
											$cod_tipo_dato_columna	,
											$value 					
											);
				
				//== Evalua si va a modificar o a ingresar un  nuevo registro >>>
				if($ind_pk){
					$nom_pk_detalle	= 	$txt_nombre_columna;
					$val_pk_detalle	= 	$value;
					if(!$value || $value=='NULL')	$ind_insert = 1; // si no hay valor en pk es porque es un insert
					else							array_push($arr_pk_detalle,$value);  // variables que no eliminara del detalle
				}
				//== prepara datos en caso de ser insert >>>
				if($ind_insert && !$ind_pk){
					array_push($arr_col_insert,$txt_nombre_columna);
					array_push($arr_val_insert,$value);
				//== prepara datos en caso de update>>>
				}else{
					array_push($arr_update,"$txt_nombre_columna=$value");
				}
			}
			//=== Evalua el insert >>>
			if($ind_insert){
				//== Inserte el nombre de la llave primaria de la tabla maestro>>>
				array_push($arr_col_insert,$nom_pk_maestro);
				array_push($arr_val_insert,$cod_pk_maestro);	
				$arr_col_insert	= implode(",",$arr_col_insert);
				$arr_val_insert	= implode(",",$arr_val_insert);
				$query			= "insert into $nom_tabla_detalle($arr_col_insert,cod_usuario,ind_bloqueado)
									values($arr_val_insert,$cod_usuario,	0)";

				$db->consultar($query);
				//$cod_pk_transaccion	=$db->fn_ultimo_registro();
				$cod_pk_transaccion	=$GLOBALS['fn_ultimo_registro'];

				
				array_push($arr_pk_detalle,$cod_pk_transaccion);
				if($cod_tipo_dato_columna==13 || $cod_tipo_dato_columna==9){
					$nom_url_mp3			=	$this->p_guardar_archivo_maestro_detalle(
												$arr_info_archivo,
												$cod_pk_transaccion,
												$row_info_columna,
												$j
												);				
					$txt_nombre_columna_mp3 = 	$row_info_columna['txt_nombre'];
					if($nom_url_mp3){
						$query					= "update $nom_tabla_detalle set $txt_nombre_columna_mp3 = '$nom_url_mp3' where $nom_pk_detalle=$cod_pk_transaccion";
						$db->consultar($query);				
					}
				}
			}else{
				$arr_update		= implode(",",$arr_update);
				$query			= "update $nom_tabla_detalle set $arr_update where $nom_pk_detalle=$val_pk_detalle";
				$db->consultar($query);				
				if($cod_tipo_dato_columna==13  || $cod_tipo_dato_columna==9 ){
					$nom_url_mp3			=	$this->p_guardar_archivo_maestro_detalle(
												$arr_info_archivo,
												$val_pk_detalle,
												$row_info_columna,
												$j
												);				
					$txt_nombre_columna_mp3 = $row_info_columna['txt_nombre'];
					if($nom_url_mp3){
						$query					= "update $nom_tabla_detalle set $txt_nombre_columna_mp3 = '$nom_url_mp3' where $nom_pk_detalle=$val_pk_detalle";
						$db->consultar($query);				
					}
				}
			}
			array_push($arr_query,$query);
		}		
		//=== Borra los registros que no estan en la forma >>>
		$codigos_bloqueados	= implode(",",$arr_pk_detalle);
		$query				= "delete from 	$nom_tabla_detalle 
								where $nom_pk_detalle not in($codigos_bloqueados) 
								and   $nom_pk_maestro = $cod_pk_maestro";
		$db->consultar($query);
		//=== Ejecuta una por una las consultas de insert y update para no bloquear el sistema >>>
/*		$num_consultas = count($arr_query);
		for($i=0;$i<$num_consultas;$i++){
			$query	=	$arr_query[$i];
			$db->consultar($query);
		}	*/
	}
}
?>