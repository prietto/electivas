<?
class conecta_db
{
	var $datos;
	var $num_registros;
	var $num_registros_afectados;
	public $fn_ultimo_registro;
	public $nom_db_pk;
	
	
//==2005/03/12====================================================================>>>
	//CONEXION EN EL SERVIDOR LOCAL
	function fn_conectarse(){
		global $nom_db_pk;
		global $dbhost;
		global $dbuser;
		global $dbpass;


		$nom_db_pk 	= 	'electivas_db_prieto';
		$dbhost 	= 	'localhost';
		$dbuser		=	'root';
		$dbpass		=	'mysql';

		//$this->va_resultado = 	mysql_pconnect('localhost','root','mysql');

		$this->va_resultado = 	@mysql_pconnect($dbhost,$dbuser,$dbpass);
		
		if (!$this->va_resultado)
		die("Fallo la conexion a MySQL: " . mysql_error());
		
		mysql_select_db($nom_db_pk)
		or die("Seleccion de base de datos fallida " . mysql_error());	

		mysql_set_charset("utf8");		
		mysql_query('SET NAMES "utf8"',$this->va_resultado);
			
	}

//==2014/10/28====================================================================>>>
	function real_escape_string($string){
		
		$mysqli = new mysqli("localhost", "root", "mysql", $nom_db_pk);
		$datos = $mysqli->real_escape_string($string);
		
		mysqli_close($mysqli);
		return $datos;
	}

// === 2015/01/04 ================================= //
	function consulta_multiple($query){
		// divide el query por punto y coma
		$arr_query = explode(';',$query);
		$this->fn_conectarse();
		for($i=0;$i<count($arr_query);$i++){
			$query = $arr_query[$i];
			$this->datos 	= mysql_query($query);  	
		}
		mysql_close($this->va_resultado);
		return $this->datos;
	}
	
	// === 2015/02/03 ==================== //
	function close_mysql(){
		mysql_close($this->va_resultado);
	}

//==2005/03/12====================================================================>>>
	function consultar($query){
		global $fn_ultimo_registro;		
		$this->fn_conectarse();	
		
		$this->datos 					= mysql_query($query); 
		$fn_ultimo_registro				= mysql_insert_id();
		//$this->datos 					= mysqli_query($query); 		

		$this->num_registros 			= @mysql_num_rows();
		$this->num_registros_afectados	= mysql_affected_rows();

		mysql_close($this->va_resultado);
	

		return $this->datos;
	}
//==2005/03/12====================================================================>>>
	function consultar_registro($query){
		$this->fn_conectarse();
		$this->datos 					= mysql_query($query);  

		$row = mysql_fetch_array($this->datos);		
		mysql_close($this->va_resultado);
		return $row;
		
		/*$this->consultar($query);
		$row = mysql_fetch_array($this->datos);
		
		return $row;*/
	}
//==2005/03/12====================================================================>>>
	function sacar_registro($cursor,$pos=NULL) //$POS=NULL es para compativilidad con postgres
	{
	
		$row = @mysql_fetch_array($cursor);
		
		if($this->va_resultado)mysql_close($this->va_resultado);
		
		return $row;
	}

//==2005/03/12====================================================================>>>
	function ultima_transaccion($cursor)
	{
		$row = @mysql_info($cursor);
		return $row;
	}
//==2005/03/12====================================================================>>>
     function num_registros($cursor)
	 {
	 	if(!$cursor) return false;
		$row = mysql_num_rows($cursor);
		return $row;
	 }
//==2005/04/12====================================================================>>>
   function fn_ultimo_registro()
    {
	   $ultimo = mysql_insert_id();
	   return $ultimo;
	}
	

	/*=====2008/12/23=======================================D E C K===>>>>
	DESCRIPCION: 	Retorna el numero de columnas de una consulta
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	$cursor			Contiene los resultados de una consulta
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function num_columnas($cursor){
		if(!$cursor) return -1;  //datos incompletos
		 $cantidad  = mysql_num_fields($cursor);
		 return $cantidad;
 	}	
	/*=====2005/05/23=======================================D E C K===>>>>
	DESCRIPCION: 	Retorna el nombre de una columna en una posicion especifica
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	$cursor			grupo de registros
	$num_registro	numero de registros
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function nom_columna($cursor,$num_registro){
		if(!$cursor) return -1;  //datos incompletos
		$columna = mysql_field_name($cursor,$num_registro);

		return $columna;
	}		
}
?>