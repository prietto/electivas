<? 
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include('../librerias/seg_navegacion.php');
include('../librerias/seg_usuario.php');
include("conecta_db.php");
$db	= new conecta_db;
$seg_usuario = new seg_usuario();

if($_GET){ // si existen variables por get las decodifica
	$sis_genericos->decode_get($_SERVER["REQUEST_URI"]); // decodifica las variables que se envian por url
	//if($_GET['cod_navegacion'])$_REQUEST['cod_navegacion'] = $_GET['cod_navegacion']; // si existe codigo de navegacin por url se lo asigna al request
	//if($_GET['cod_usuario'])$_REQUEST['cod_usuario_url'] = $_GET['cod_usuario']; // si existe codigo de navegacin por url se lo asigna al request
}

//ini_set("display_errors", 1);

// si utiliza el metodo de todas las variables del formulario
$ind_var_ajax 	= NULL;
$ind_mostrar 	= false;


if(isset($_REQUEST['ind_var_ajax']))$ind_var_ajax = $_REQUEST['ind_var_ajax'];
if($ind_var_ajax == 1){
	//==Carga las variables ajax en el request de forma dinamica >>>
	$tmp_num_post = count($_REQUEST); // cuenta la cantidad de posiciones del post
	$keys = array_keys($_REQUEST);

	for($i=0; $i<count($keys);$i++){ // entra por aqui la cantidad de keys que tiene el request
		$nom_key				= $keys[$i];
		if($nom_key == 'vars'){
			$arr_variables_ajax = $_REQUEST['vars'];
		}else{
			$arr_variables_ajax		= $_REQUEST[$nom_key]; // arranca desde la primera posicion sin importar si comienza por 0
		}
		$num_sub_var			= count($arr_variables_ajax); // cuenta para saber si la posicion del post tiene mas subvectores
		if(is_array($arr_variables_ajax)){
			unset($_REQUEST['vars']['cod_navegacion']);
			unset($_POST['vars']['cod_navegacion']);
		}
		
		//$tmp_nom_variable		= key(current($_POST));
		if($num_sub_var > 1){ // si tiene subvectores entra
			$keys_vars			= array_keys($_REQUEST[$nom_key]);
			for($k=0; $k<$num_sub_var;$k++){
				$ind_multiple = NULL;

				$key_nom_tmp		= $keys_vars[$k];
				$val_variable		= $_REQUEST[$nom_key][$key_nom_tmp]; // recorre las posiciones para la variable especial de ajax	
				
				if($val_variable || $val_variable != NULL ){
					$$key_nom_tmp				= $val_variable; //asigna el valor dinamicamente
					if($ind_multiple){ // si es una array la variable esto para la ultima posicion
						$_REQUEST[$key_nom_tmp][] 	= $val_variable; 	// alimenta el request		
					}else{
						$_REQUEST[$key_nom_tmp] 	= $val_variable; 	// alimenta el request	
						
					}
				}
			}
			
			// borra la variables del request ya que es innecesari
			$_REQUEST['vars']	 = NULL; 
			$_POST['vars'] 		= NULL;
			unset($_REQUEST['vars']);
			unset($_POST['vars']);
		}else{
			$tmp_nom_variable		= $nom_key;
			$$tmp_nom_variable		= $_REQUEST[$tmp_nom_variable]; //asigna el valor dinamicamente
		}
		//next($_POST); // sinieguiente posisicon del post
	}
}else{
	//==Carga las variables $request de forma dinamica >>>
	$tmp_num_request = count($_REQUEST);
	for($i=0; $i<$tmp_num_request;$i++){
		$tmp_val_variable 		= current($_REQUEST);
		$tmp_nom_variable		= key($_REQUEST);
		$$tmp_nom_variable		= $tmp_val_variable; //asigna el valor dinamicamente
		 next($_REQUEST);
	}
}



// informacion del usuario conectado
if(!$cod_usuario)$cod_usuario 	= $_REQUEST['cod_usuario'];

// sigue sin existir usuario devuelve error!
/*if(!$cod_usuario && ($cod_navegacion != 1200 || $cod_navegacion != 1201)){
	ob_clean(); // limpia el bufer de salida de cualquier dato o caracter a imprimirse

	echo "error_no_usuario";
	return false;
	exit;
}*/

$row_usuario					= $seg_usuario->f_get_seg_usuario($cod_usuario);


//=== Valida la navegacion >>>
$seg_navegacion 	= new seg_navegacion;
$flujo_navegacion 	= $seg_navegacion->f_ver_navegacion($cod_navegacion);


if(!$flujo_navegacion){
	//ob_end_clean(); // destruye el bufer de salida para evitar otros echos anteriores
	ob_clean(); // limpia el bufer de salida de cualquier dato o caracter a imprimirse

	echo "error_flujo_navegacion";
	return false;
	exit;
}

$validacion			= strtolower($flujo_navegacion["txt_validacion"]);	//mantiene los nombres en minuscula
$proceso			= strtolower($flujo_navegacion["txt_proceso"]);		//mantiene los nombres en minuscula
$consulta			= strtolower($flujo_navegacion["txt_consulta"]);	//mantiene los nombres en minuscula
$salida				= strtolower($flujo_navegacion["txt_salida"]); 		//mantiene los nombres en minuscula
$contenido			= strtolower($flujo_navegacion["txt_contenido"]); 		//mantiene los nombres en minuscula
//if(file_exists("../consulta/ver_ultimos_movimientos_insumo.php"))echo "existe" ? echo "no existe";
//echo file_exists("../consulta/$consulta")? "no existe el archivo $consulta" : "si existe el archivo $consulta";
//echo file_exists("../consulta/$contenido")? "SI existe el archivo $consulta" : "NO existe el archivo $consulta";

//===Registra la estadisitca de visitas >>>
//$seg_navegacion_estadistica->p_registrar_visita($cod_navegacion);
//echo "<pre>";

// indicador para saber si mantiene el chat abierto
//if(isset($_SESSION['ind_chat_abierto']))$ind_chat_abierto = $_SESSION['ind_chat_abierto'];
//print_r($_COOKIE);

//print_r($_REQUEST);die();
//===Salidas del flujo de navegacion >>>

if($validacion) include ("../validacion/".$validacion);
if($proceso)	include ("../proceso/".$proceso);
if($consulta)	include ("../consulta/".$consulta);
if($salida)		include ("../plantilla/".$salida);
if($contenido)	include ("../contenido/".$contenido);
if($arr_mensajes)include ("../plantilla/mensaje.php"); //relacion de mensajes generados 
exit();
?>