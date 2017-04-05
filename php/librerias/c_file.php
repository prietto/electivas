<?
/*=====2008/09/07==================================D E C K===>>>>
DESCRIPCION: 	diferentes funciones de consulta relacionadas con los archivos
PROPIETARIO:	© D E C K
AUTOR:			Cristian arellano
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
class c_file{
	/*=====2008/09/07==================================D E C K===>>>>
	DESCRIPCION: 	Metodo para obtener el tipo de imagen que se esta manejando
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function f_get_tipo_imagen($txt_type){

		if($txt_type == 'image/pjpeg') 					$extension = ".jpg";
		if($txt_type == 'image/jpeg') 					$extension = ".jpg";
		if($txt_type == 'image/x-png') 					$extension = ".png";
		if($txt_type == 'image/gif') 					$extension = ".gif";
		if($txt_type == 'application/octet-stream') 	$extension = ".psd";			
		if($txt_type == 'application/x-shockwave-flash')$extension = ".swf";
		if($txt_type == 'application/pdf')				$extension = ".pdf";
		if($txt_type == 'application/msword')			$extension = ".doc";
		if($txt_type == 'application/rtf')				$extension = ".rtf";
		if($txt_type == 'application/vnd.ms-excel')		$extension = ".xls";
		if($txt_type == 'application/vnd.ms-powerpoint')$extension = ".ppt";

		return $extension;
	}	

	/*=====2008/09/07==================================D E C K===>>>>
	DESCRIPCION: 	Metodo para obtener el tipo de imagen que se esta manejando
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	---------------------------------------------------------------------------					
	HISTORIAL DE MODIFICACIONES
	---------------------------------------------------------------------------					
	FECHA	AUTOR		MODIFICACION
	===========================================================================*/
	function f_valida_extension($var_file){

		if(!$var_file)return false;

		$var_file = current($var_file);

		$file_name = strtolower($var_file['name']);
		
		$whitelist = array('jpg', 'png', 'gif', 'jpeg','pdf'); //example of white list
		$backlist = array('php', 'php3', 'php4', 'phtml','exe','gz'); //example of black list
		/*if(!in_array(end(explode('.', $fileName)), $whitelist)){
		    echo 'Invalid file type';
		    exit(0);
		}*/

		$txt_extension = end(explode('.', $file_name));
		

		// si la extension del archivo se encuentra en la lista negra
		if(in_array($txt_extension, $backlist)){		    
		    return false;
		}else return true;

	}



	// === FUNCION ==== >>>
	function f_get_mimetypes($filename) {

	        $mime_types = array(

	            'txt' => 'text/plain',
	            'htm' => 'text/html',
	            'html' => 'text/html',
	            'php' => 'text/html',
	            'css' => 'text/css',
	            'js' => 'application/javascript',
	            'json' => 'application/json',
	            'xml' => 'application/xml',
	            'swf' => 'application/x-shockwave-flash',
	            'flv' => 'video/x-flv',

	            // images
	            'png' => 'image/png',
	            'jpe' => 'image/jpeg',
	            'jpeg' => 'image/jpeg',
	            'jpg' => 'image/jpeg',
	            'gif' => 'image/gif',
	            'bmp' => 'image/bmp',
	            'ico' => 'image/vnd.microsoft.icon',
	            'tiff' => 'image/tiff',
	            'tif' => 'image/tiff',
	            'svg' => 'image/svg+xml',
	            'svgz' => 'image/svg+xml',

	            // archives
	            'zip' => 'application/zip',
	            'rar' => 'application/x-rar-compressed',
	            'exe' => 'application/x-msdownload',
	            'msi' => 'application/x-msdownload',
	            'cab' => 'application/vnd.ms-cab-compressed',

	            // audio/video
	            'mp3' => 'audio/mpeg',
	            'qt' => 'video/quicktime',
	            'mov' => 'video/quicktime',

	            // adobe
	            'pdf' => 'application/pdf',
	            'psd' => 'image/vnd.adobe.photoshop',
	            'ai' => 'application/postscript',
	            'eps' => 'application/postscript',
	            'ps' => 'application/postscript',

	            // ms office
	            'doc' => 'application/msword',
	            'rtf' => 'application/rtf',
	            'xls' => 'application/vnd.ms-excel',
	            'ppt' => 'application/vnd.ms-powerpoint',

	            // open office
	            'odt' => 'application/vnd.oasis.opendocument.text',
	            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
	        );

	        $ext = strtolower(array_pop(explode('.',$filename)));

	        if (array_key_exists($ext, $mime_types)){
	            return $mime_types[$ext];
	        }else if(function_exists('finfo_open')){
	            $finfo = finfo_open(FILEINFO_MIME);
	            $mimetype = finfo_file($finfo, $filename);
	            finfo_close($finfo);
	            return $mimetype;
	        }else{
	            return 'application/octet-stream';
	        }
	    }





}
?>