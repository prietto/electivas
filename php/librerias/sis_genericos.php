<?
/*=====2005/05/23=======================================D E C K===>>>>
DESCRIPCION: 	Contiene funciones genericas usadas en diferentes modulos
PROPIETARIO:	© D E C K
AUTOR:			Cristian Arellano
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
if(class_exists('sis_genericos') != true){
	class sis_genericos{
	
		/*=====2014/11/03=======================================D E C K===>>>>
		DESCRIPCION: 	Retorna la cntidad de dias habiles entre dos fechas
		AUTOR:			Luis Prieto
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$fecha			Fecha a la que se le quiere sumar los dias
		$num_dias		dias que se quieren sumar
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		 function f_get_diferencia_dias_habiles($fec_inicial,$fec_fin){
			$ret 		= array(); // inicializamos variables
			$fec_actual	= date('Y-m-d'); // fec actual
			$fecha_time = strtotime($fec_inicial); // convertimos la fecha inicial en tiempo
			
			$str_fec_inicial 	= strtotime($fec_inicial);
			$str_fec_final		= strtotime($fec_fin);
			
			for($i=1;$str_fec_inicial<$str_fec_final;$i++){
				// retorna el numero del dia
				$date = date('N', mktime(0,0,0,date('n',$fecha_time), date('d',$fecha_time)+$i,date('Y',$fecha_time)));
				// retorna la fecha en formato y-m-d
				$diames = date('Y-m-d', mktime(0,0,0,date('n',$fecha_time), date('d',$fecha_time)+$i,date('Y',$fecha_time)));
				if($date != 6 && $date != 7){ // ME FIJO QUE NO SEA DOMINGO ni sabado
					 // aqui podria verificar si la fecha es feriada
					 if($this->f_get_fecha_festivo($diames) == FALSE){
						$ret[$i] = $diames;
					}				 
				}
				
				$str_fec_inicial = $str_fec_inicial+86400; // le suma un dia a la fecha inicial para ir recorriendo
							
			}
			
			// devuelve ultima fecha habil en formato  2000-01-01
			return count($ret);
		 }
		
		/*=====2014/11/03=======================================D E C K===>>>>
		DESCRIPCION: 	Funcion que consulta si la fecha que llega por parametro es festivo o no
		AUTOR:			Luis Prieto
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$fecha			Fecha que se quiere comprar
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_get_valida_dia_habil($fecha){
			if(!$fecha)return false;
			global $db;
			
			//echo $fecha;
			
			//$fecha = date('Y-m-d',strtotime($fecha));
			
			$query = "select count(*) as num_registros from dia_festivo 
						where fec_festivo = DATE_FORMAT('$fecha','%Y-%m-%d 00:00:00')
						and ind_activo = 1 and ind_bloqueado = 0";
			$row = $db->consultar_registro($query);
			$num_registros = $row['num_registros'];
			
			$fecha_time = strtotime($fecha);	
			$diasemana = date('N',$fecha_time);		
			

			// si no es festivo ni es domingo ni es sabado retorna true
			if($num_registros == 0 && ($diasemana != 7 && $diasemana != 6)){
				return true; // si no es festivo y no es domingo
			}
			else return false;
			
		}
		
		/*=====2014/11/03=======================================D E C K===>>>>
		DESCRIPCION: 	Suma dias habiles a una fecha
		AUTOR:			Luis Prieto
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$fecha			Fecha a la que se le quiere sumar los dias
		$num_dias		dias que se quieren sumar
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function sumasdiasemana($fecha,$dias){
			$datestart= strtotime($fecha);
			//$datesuma = 15 * 86400;
			$diasemana = date('N',$datestart);
			$totaldias = $diasemana+$dias;
			$findesemana = intval( $totaldias/6) * 1;
			$diasabado = $totaldias % 6;
			if ($diasabado==7) $findesemana++;
			if ($diasabado==0) $findesemana=$findesemana-1;
			
			$total = (($dias+$findesemana) * 86400)+$datestart ;
			$fec_final =date('Y-m-d', $total); //fecha final quitando los domingos
			
			// ahora entre la fecha inifial y fecha final veremos si existen festivos 
			// de ser asi se le suma un dia mas 
			//echo $fec_final;
			
			$time_inicial 	= strtotime($fecha);
			$time_final		= strtotime($fec_final);
			
			$arr_fechas = array();
			$contador = 0;
			while($time_inicial<$time_final){
				
				$fec_result = date('Y-m-d H:i:s',$time_inicial); // formtea de tiempo a fecha el tiempo
				$dia_semana = date('N',$time_inicial);
				
				if ($dia_semana!=7){
					$time_inicial=$time_inicial+86400;
					$arr_fechas[$contador] = $fec_result; // almacena la fecha en un vector
					$contador++; 
				}
				
				
				
	
				
				
			}
			
			//print_r($arr_fechas);
			
		}
		
		
		/*=====2014/11/03=======================================D E C K===>>>>
		DESCRIPCION: 	Funcion que consulta si la fecha que llega por parametro es festivo o no
		AUTOR:			Luis Prieto
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$fecha			Fecha que se quiere comprar
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_get_fecha_festivo($fecha){
			if(!$fecha)return false;
			global $db;
			
			//$fecha = date('Y-m-d',strtotime($fecha));
			
			$query = "select count(*) as num_registros from dia_festivo 
						where fec_festivo = DATE_FORMAT('$fecha','%Y-%m-%d 00:00:00')
						and ind_activo = 1 and ind_bloqueado = 0";
			
			$row = $db->consultar_registro($query);
			
			$num_registros = $row['num_registros'];
			
			if($num_registros>0)return true;
			else return false;
			
		}
		
		/*=====2014/11/03=======================================D E C K===>>>>
		DESCRIPCION: 	Suma dias habiles a una fecha
		AUTOR:			Luis Prieto
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$fecha			Fecha a la que se le quiere sumar los dias
		$num_dias		dias que se quieren sumar
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		 function sumar_dias_habiles($fecha,$cantidad = 1){
			if(intval($cantidad) <= 0) return false;
			$habiles = 0;
			$selectDias = "";
			$ret 		= array();
			$fec_actual	= date('Y-m-d');
			$fecha_time = strtotime($fecha);
			for($i=1;$habiles <$cantidad;$i++){
				$date = date('N', mktime(0,0,0,date('n',$fecha_time), date('d',$fecha_time)+$i,date('Y',$fecha_time)));
				
				$diames = date('Y-m-d', mktime(0,0,0,date('n',$fecha_time), date('d',$fecha_time)+$i,date('Y',$fecha_time)));
				if($date != 6 && $date != 7){ // ME FIJO QUE NO SEA DOMINGO
					 
					 // aqui podria verificar si la fecha es feriada
					 if($this->f_get_fecha_festivo($diames) == FALSE){
						$habiles++;
						$ret[$habiles] = $diames;
					}				 
					 
					
				}
							
			}
			// devuelve ultima fecha habil en formato  2000-01-01
			return array_pop($ret);
		}
		
		
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	convierte 2008-10-12 a  2008 Oct 10
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$string			cadena añomes
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_fecha_con_hora_no_semana($fecha){
			if(!$fecha) return false;
			$fecha		= explode("-",$fecha);	
			$year		= $fecha[0];
			$mes 		= number_format($fecha[1]);
			$dia		= $fecha[2];
			$dia		= number_format($dia[0].$dia[1]);	//Elimina los segundos	}
			$minuto 	= $fecha[2][6].$fecha[2][7];
			$dia_semana = date("N",	mktime(0,0,0,$mes,$dia,$year));
			//da formato>>>		
			$dia_semana	= $this->f_nombre_semana_corto($dia_semana);
			$mes 		= $this->f_nombre_mes($mes);
			$hora		= number_format($fecha[2][3].$fecha[2][4]);
			if($hora>12){
				$hora = $hora-12;
				$am_pm = "PM";
			}else 
				$am_pm = "AM";
			if($minuto!="00") 	$minuto = ":$minuto";
			else 				$minuto	= "";
			if($hora<10) $hora = "&nbsp;".$hora;//=== pone un espacio en blanco para alinear bien los datos
			return	"$year $mes $dia ($hora$minuto $am_pm)";
		}	
		
		/*=====2014/01/23=======================================D E C K===>>>>
		DESCRIPCION: 	mantiene en memoria las variables de un pagina anterior
		AUTOR:			Luis Prieto
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$fec			dato
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		
		function is_date($str) {
		global $db;	
			try {
				$dt = new DateTime( trim($str) );
			}
			catch( Exception $e ) {
				return false;
			}
			$month = $dt->format('m');
			$day = $dt->format('d');
			$year = $dt->format('Y');
			if( checkdate($month, $day, $year) ) {
				return true;
			}
			else {
				return false;
			}
		}
		/*=====2013/01/14=======================================D E C K===>>>>
		DESCRIPCION: 	mantiene en memoria las variables de un pagina anterior
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$request		variables request
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_genera_variables_anteriores_v2($request){
			//== obtiene las variables en el reporte para que regrese despues a la misma ubicacion >>>
			$array_request_reporte			=	array(); //variables que venian del reporte anterior
			$tmp_num_request = count($request);
			reset($request); //regresa el puntero a la primera posisicon
			for($i=0; $i<$tmp_num_request;$i++){
				$tmp_val_variable 		= current($request);
				$tmp_nom_variable		= key($request);
				
				if(is_array($tmp_val_variable)){
					$tmp_val_variable = implode(',',$tmp_val_variable);
				}
				$array_request_reporte[$tmp_nom_variable]	= "$tmp_nom_variable=>$tmp_val_variable";
				
				 next($request);
			}
			
			$array_request_reporte = implode(";,;",$array_request_reporte);
			$array_request_reporte = str_replace('\"',"\'",$array_request_reporte);
			return $array_request_reporte;
		}
		
		/*=====2013/01/14=======================================D E C K===>>>>
		DESCRIPCION: 	mantiene en memoria las variables de un pagina anterior
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$request		variables request
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_genera_variables_anteriores($request){
			//== obtiene las variables en el reporte para que regrese despues a la misma ubicacion >>>
			$array_request_reporte			=	array(); //variables que venian del reporte anterior
			$tmp_num_request = count($request);
			reset($request); //regresa el puntero a la primera posisicon
			for($i=0; $i<$tmp_num_request;$i++){
				$tmp_val_variable 		= current($request);
				$tmp_nom_variable		= key($request);
				$array_request_reporte[$tmp_nom_variable]	= "$tmp_nom_variable=>$tmp_val_variable";
				 next($request);
			}
			
			$array_request_reporte = implode(";,;",$array_request_reporte);
			$array_request_reporte = str_replace('\"',"\'",$array_request_reporte);
			return $array_request_reporte;
		}
		
		
		/*=====2013/01/14=======================================D E C K===>>>>
		DESCRIPCION: 	Recupera las variables de un pagina anterior
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$request		variables request
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_get_variables_anteriores($request,$array_request_reporte){
								//print_r($request);
							//	exit;
				//==== Evalua para regrese a la pantalla anterior sin hacer cambios >>>
				if($array_request_reporte){

					$array_request_reporte 	= explode(";,;",$array_request_reporte);
	//				$array_request_reporte	= array_reverse($array_request_reporte);
					
					for($i=0; $i<count($array_request_reporte); $i++){
						$array_request			= explode("=>",$array_request_reporte[$i]);	
//						print_r($array_request);						
						$nom_variable			= $array_request[0];
						$val_variable			= $array_request[1];

						if(	$array_request[1] != "Array" && $array_request[0] != "cod_navegacion"){
							$request[$nom_variable] = $val_variable;
						} // fin if
					} // fin ciclo

					//print_r($request);
					return $request;
				}
				else return $request;
		}
		
		
		/*================================================D E C K====>>>
		DESCRIPCION: 	indica el formato que quiere para el texto
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$txt_cadena		cadena a transformar
		$txt_formato	formtaos "mayuscula_inicial"  "mayuscula"  "minuscula"
		===========================================================================*/
		function p_elimina_coma($var){
			
			$var = str_replace(',','',$var);
			
			return $var;
		}
		
		
		/*================================================D E C K====>>>
		DESCRIPCION: 	indica el formato que quiere para el texto
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$txt_cadena		cadena a transformar
		$txt_formato	formtaos "mayuscula_inicial"  "mayuscula"  "minuscula"
		===========================================================================*/
		function f_formato_texto($txt_cadena,$txt_formato){
			if($txt_formato=="mayuscula_inicial")
				$txt_cadena=utf8_encode(ucwords(strtolower(utf8_decode($txt_cadena))));			
			else if($txt_formato=="mayuscula")
				$txt_cadena=utf8_encode(strtoupper(utf8_decode($txt_cadena))); 
			else if($txt_formato=="minuscula")			
				$txt_cadena=utf8_encode(strtolower(utf8_decode($txt_cadena))); 
			return $txt_cadena;
		}	
		
		
		/*=====20130606=======================================D E C K===>>>>
		DESCRIPCION: 	da formato a una hora
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		txt_hora		10:1:  esto lo dejaria  10:01:00
		===========================================================================*/
		function f_valida_hora($txt_hora){
			if(!$txt_hora) return false;
			$txt_hora 	= explode(":",$txt_hora);
			//=== Acomoda Hora
			if($txt_hora[0]>23) $txt_hora[0] = "23";
			if($txt_hora[0]<10 && $txt_hora[0]>0) $txt_hora[0] = "0".$txt_hora[0];
			//=== Acomoda Mes
			if($txt_hora[1]>59) $txt_hora[1] = "59";
			if($txt_hora[1]<10 && $txt_hora[1]>0) $txt_hora[1] = "0".$txt_hora[1];
			//=== Acomoda Minuto
			if($txt_hora[2]>59) $txt_hora[2] = "59";
			if($txt_hora[2]<10 && $txt_hora[2]>0) $txt_hora[2] = "0".$txt_hora[2];
			$txt_hora = implode (":",$txt_hora);
			return $txt_hora;
		}	
	
	
		/*=====2014/01/21 =======================================D E C K===>>>>
		DESCRIPCION: 	Quita la hora de la fecha y separa la fecha devuelve el year mes dia en vector
		AUTOR:			Luis Prieto
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$string			cadena añomes
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_separa_fecha($string){
			if(!$string) return false;
			
			$arr_fec_larga = explode(' ',$string);
	
			
			$hora		= $arr_fec_larga[1];
			$fec		= $arr_fec_larga[0];
			
			$arr_fec	= explode('-',$fec);
	
			return $arr_fec;
			
		}	
		
		
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	convierte 200810 a Oct 2008 
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$string			cadena añomes
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_nombre_year_mes($string){
			if(!$string) return false;
			$mes 	= $string[4].$string[5];
			$year	= $string[0].$string[1].$string[2].$string[3];
			$mes 	= $this->f_nombre_mes($mes);
			return "$mes $year";
			
		}	
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	convierte 2008-10-12 a  2008 Oct 10
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$string			cadena añomes
		===========================================================================*/
		function f_nombre_fecha_con_hora_sin_year($fecha){
			if(!$fecha) return false;
			$fecha		= explode("-",$fecha);	
			$year		= $fecha[0];
			$mes 		= number_format($fecha[1]);
			$dia		= $fecha[2];
			$dia		= number_format($dia[0].$dia[1]);	//Elimina los segundos	}
			$minuto 	= $fecha[2][6].$fecha[2][7];
			$dia_semana = date("N",	mktime(0,0,0,$mes,$dia,$year));
			//da formato>>>		
			$dia_semana	= $this->f_nombre_semana_corto($dia_semana);
			$mes 		= $this->f_nombre_mes($mes);
			$hora		= number_format($fecha[2][3].$fecha[2][4]);
			if($hora>12){
				$hora = $hora-12;
				$am_pm = "PM";
			}else 
				$am_pm = "AM";
			if($minuto!="00") 	$minuto = ":$minuto";
			else 				$minuto	= "";
			if($hora<10) 	$hora 	= "&nbsp;".$hora;//=== pone un espacio en blanco para alinear bien los datos
			if($dia<10) 	$dia 	= "&nbsp;".$dia;//=== pone un espacio en blanco para alinear bien los datos		
			return	"$mes $dia ($dia_semana $hora$minuto$am_pm)";
		}
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	Muestra una fecha sin año y en formato largo
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$string			cadena añomes
		===========================================================================*/
		function f_fecha_larga_con_hora($fecha){
			if(!$fecha) return false;
			$fecha		= explode("-",$fecha);	
			$year		= $fecha[0];
			$mes 		= number_format($fecha[1]);
			$dia		= $fecha[2];
			$dia		= number_format($dia[0].$dia[1]);	//Elimina los segundos	}
			$minuto 	= $fecha[2][6].$fecha[2][7];
			$dia_semana = date("N",	mktime(0,0,0,$mes,$dia,$year));
			//da formato>>>		
			$dia_semana	= $this->f_nombre_semana_largo($dia_semana);
			//$mes 		= $this->f_nombre_mes_largo($mes);
			$hora		= number_format($fecha[2][3].$fecha[2][4]);
			if($hora>12){
				$hora = $hora-12;
				$am_pm = "PM";
			}else 
				$am_pm = "AM";
			if($minuto!="00") 	$minuto = ":$minuto";
			else 				$minuto	= "";
			if($hora<10) 	$hora 	= "&nbsp;".$hora;//=== pone un espacio en blanco para alinear bien los datos
			if($dia<10) 	$dia 	= "&nbsp;".$dia;//=== pone un espacio en blanco para alinear bien los datos		
			return	"$dia/$mes/$year ($dia_semana $hora$minuto $am_pm)";
		}	
				
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	Muestra una fecha sin año y en formato largo
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$string			cadena añomes
		===========================================================================*/
		function f_fecha_larga_con_hora_sin_year($fecha){
			if(!$fecha) return false;
			$fecha		= explode("-",$fecha);	
			$year		= $fecha[0];
			$mes 		= number_format($fecha[1]);
			$dia		= $fecha[2];
			$dia		= number_format($dia[0].$dia[1]);	//Elimina los segundos	}
			$minuto 	= $fecha[2][6].$fecha[2][7];
			$dia_semana = date("N",	mktime(0,0,0,$mes,$dia,$year));
			//da formato>>>		
			$dia_semana	= $this->f_nombre_semana_largo($dia_semana);
			$mes 		= $this->f_nombre_mes_largo($mes);
			$hora		= number_format($fecha[2][3].$fecha[2][4]);
			if($hora>12){
				$hora = $hora-12;
				$am_pm = "PM";
			}else 
				$am_pm = "AM";
			if($minuto!="00") 	$minuto = ":$minuto";
			else 				$minuto	= "";
			if($hora<10) 	$hora 	= "&nbsp;".$hora;//=== pone un espacio en blanco para alinear bien los datos
			if($dia<10) 	$dia 	= "&nbsp;".$dia;//=== pone un espacio en blanco para alinear bien los datos		
			return	"$mes $dia ($dia_semana $hora$minuto$am_pm)";
		}		
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	convierte 2008-10-12 a  2008 Oct 10
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$string			cadena añomes
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_nombre_fecha_con_hora($fecha){
			if(!$fecha) return false;
			$fecha		= explode("-",$fecha);	
			$year		= $fecha[0];
			$mes 		= number_format($fecha[1]);
			$dia		= $fecha[2];
			$dia		= number_format($dia[0].$dia[1]);	//Elimina los segundos	}
			$minuto 	= $fecha[2][6].$fecha[2][7];
			$dia_semana = date("N",	mktime(0,0,0,$mes,$dia,$year));
			//da formato>>>		
			$dia_semana	= $this->f_nombre_semana_corto($dia_semana);
			$mes 		= $this->f_nombre_mes($mes);
			$hora		= number_format($fecha[2][3].$fecha[2][4]);
			if($hora>12){
				$hora = $hora-12;
				$am_pm = "PM";
			}else 
				$am_pm = "AM";
			if($minuto!="00") 	$minuto = ":$minuto";
			else 				$minuto	= "";
			if($hora<10) $hora = "&nbsp;".$hora;//=== pone un espacio en blanco para alinear bien los datos
			return	"$year $mes $dia ($dia_semana $hora$minuto $am_pm)";
		}	
	
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	convierte 2008-10-12 a  2008 Oct 10
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$string			cadena añomes
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_nombre_fecha_sin_year($fecha){
			if(!$fecha) return false;
			$fecha	= explode("-",$fecha);	
			$mes 	= $fecha[1];
			$mes 	= $this->f_nombre_mes_largo($mes);
			$dia	= $fecha[2];
			$dia	= $dia[0].$dia[1];	//Elimina los minutos y segundos	
			return	" $mes $dia";
		}	
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	convierte 2008-10-12 a  2008 Oct 10
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$string			cadena añomes
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_nombre_fecha($fecha){
			if(!$fecha) return false;
			$fecha	= explode("-",$fecha);	
			$mes 	= $fecha[1];
			$mes 	= $this->f_nombre_mes($mes);
			$dia	= $fecha[2];
			$dia	= $dia[0].$dia[1];	//Elimina los minutos y segundos	
			return	$fecha[0]." $mes $dia";
		}	
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	Obtiene el nombre corto de un mes
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$string			cadena añomes
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_nombre_mes($mes){
			if(!$mes) return false;
			if($mes == "01") $mes = "Ene";
			if($mes == "02") $mes = "Feb";
			if($mes == "03") $mes = "Mar";
			if($mes == "04") $mes = "Abr";
			if($mes == "05") $mes = "May";
			if($mes == "06") $mes = "Jun";
			if($mes == "07") $mes = "Jul";
			if($mes == "08") $mes = "Ago";
			if($mes == "09") $mes = "Sep";
			if($mes == "10") $mes = "Oct";
			if($mes == "11") $mes = "Nov";
			if($mes == "12") $mes = "Dic";
			return $mes;
		}	
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	Nombre largo del mes
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$string			cadena añomes
		===========================================================================*/
		function f_nombre_mes_largo($mes){
			if(!$mes) return false;
			if($mes == "01") $mes = "Enero";
			if($mes == "02") $mes = "Febrero";
			if($mes == "03") $mes = "Marzo";
			if($mes == "04") $mes = "Abril";
			if($mes == "05") $mes = "Mayo";
			if($mes == "06") $mes = "Junio";
			if($mes == "07") $mes = "Julio";
			if($mes == "08") $mes = "Agosto";
			if($mes == "09") $mes = "Septiembre";
			if($mes == "10") $mes = "Octtubre";
			if($mes == "11") $mes = "Noviembre";
			if($mes == "12") $mes = "Diciembre";
			return $mes;
		}	
		/*=====2012/01/04=======================================D E C K===>>>>
		DESCRIPCION: 	Obtiene el nombres cortos  de la semana
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$numero			Numero del 1 al 7
		===========================================================================*/
		function f_nombre_semana_corto($numero){
			if($numero == "01") $dia	= "Lun";
			if($numero == "02") $dia 	= "Mar";
			if($numero == "03") $dia 	= "Mie";
			if($numero == "04") $dia 	= "Jue";
			if($numero == "05") $dia 	= "Vie";
			if($numero == "06") $dia 	= "Sab";
			if($numero == "07") $dia 	= "Dom";
			return $dia;
		}	
		/*=====2012/01/04=======================================D E C K===>>>>
		DESCRIPCION: 	Obtiene el nombre largo de la semana
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$numero			Numero del 1 al 7
		===========================================================================*/
		function f_nombre_semana_largo($numero){
			if($numero == "01") $dia	= "Lunes";
			if($numero == "02") $dia 	= "Martes";
			if($numero == "03") $dia 	= "Mi&eacute;rcoles";
			if($numero == "04") $dia 	= "Jueves";
			if($numero == "05") $dia 	= "Viernes";
			if($numero == "06") $dia 	= "Sabado";
			if($numero == "07") $dia 	= "Domingo";
			return $dia;
		}	
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	Prepara una cadena para guardarla en la base de datos quitando 
						espacios, ñ, tildes y  espacios en blanco					
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_preparar_cadena_para_db($string){
			$string		=	strtoupper(ltrim(rtrim($string)));
			$string		=	str_replace("&","&amp;",$string);
			$string		=	str_replace("Ñ","&Ntilde;",$string);
			$string		=	str_replace("Á","&Aacute;",$string);
			$string		=	str_replace("É","&Eacute;",$string);
			$string		=	str_replace("Í","&Iacute;",$string);
			$string		=	str_replace("Ó","&Oacute;",$string);
			$string		=	str_replace("Ú","&Uacute;",$string);
			$string		=	str_replace('"',"&quot;",$string);
			$string		=	str_replace("'","&quot;",$string);
			return 			$string;
		}
		/*=====2005/05/23=======================================D E C K===>>>>
		DESCRIPCION: 	retorna una cadena para que se armen listBox
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$cursor			variable que contiene los datos
		$cod_select		Codigo para determinar cual elemento esta seleccionado
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function elementos_list_box($cursor, $cod_select=NULL){
			if(!$cursor)  return false;
			global $db;
			$num_registros = $db->num_registros($cursor);
			//=== Ordena los mensajes que se van a mostrar >>>
			for($i=0; $i<$num_registros; $i++){
				$registro=$db->sacar_registro($cursor,$i);
				if($registro[0] == $cod_select) $selected = 'selected';
				else  $selected = '';
				$cadena = "$cadena <option value='$registro[0]' $selected >$registro[1]</option>";
			}
			return $cadena;
		}
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	Recibe una cadena  com 5,3,10-15,8 y retorna  5,3,10,11,12,13,14,15,8
						asumiento el 10 - 15 como un rango que se debe cumplir
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$string			Cadena que contiene la informacion
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function crear_rango_numeros($string)
		{
			if(!$string) return false;
			$vctor_retorno				=	array(); 								//vector que finalmente sera retornado (se pasa un cero por si ocurre algún error)
			$vctor_comas		  		=   explode(",",$string); 			//pasa de una cadena separada por comas a un vector 		
			while($elemento_vctor_comas  = 	array_pop($vctor_comas)){  		//saca cada regitro del vector
				$vector_menos  			=   explode("-",$elemento_vctor_comas); 	//pasa a un vector creyendo que el elemento acum_string es una cadena separada por  el signo -
				$copia_vctor_menos 		= 	$vector_menos;							//mantiene el valor del vector para evitar perdidas al momento de usar la funcion array_pop
				$copia_vctor_menos		=	array_reverse ($copia_vctor_menos);			//voltea el vector para evitar problemas con la funcion array_pop que funciona como pila
				$i						= 	0;										//variable interna para el ciclo 
				while($elemento_vctor_menos	=	array_pop($copia_vctor_menos)){  	//saca 	cada regitro separado por -				
					if($i == 0) array_push($vctor_retorno, $elemento_vctor_menos);	//envia ese valor al vector que finalmente sera retornado
					else 
						for($j = $vector_menos[$i-1]+1; $j <= $vector_menos[$i];   $j++)
							array_push($vctor_retorno, $j);
					$i++;
				}
			}
			$string	= implode(',',$vctor_retorno); //envia de un vector a una cadena separada por comas
			return $string;
		}
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	Este metodo recibe un numero 12345.45 y retorna 12,345.45
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$numero			Cadena que contiene la informacion
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function formato_numero($numero, $decimales =0){
			$i = 0;
			
	
			/*if($numero != 2300000 && $numero != 23000000){ // nmumeros raros
				$numero	=	round($numero,$decimales);		
			}*/
			
			$arr_numero = explode('.',$numero);
			if(count($arr_numero) > 1){
				$numero = ceil($numero);
			}
				
	
			$numero = (string)$numero;
	
			while ($numero[$i] != "" && $numero[$i] != "." && $numero[$i] != "-") 	$i++;
			$acum3 = 0;
			for($j = $i-1; $j>=0; $j--){
				if( $acum3 ==3 ){
					$invertido =  "$invertido,";		$acum3=0;
				}
				$invertido =  "$invertido"."$numero[$j]";		
				$acum3++;	
			}
			while ($numero[$i] != ""){
				$num_temp = $num_temp.$numero[$i];
				$i++;
			}
			
			$numero = $num_temp ;			
			while ($invertido[$k] != ""){
				$numero = "$invertido[$k]"."$numero";
				$k++;
			}
			return $numero;
		}
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	Determinar si una cadena es o no un numero independiente si tiene 
						decimales separados por comas, puntos y demas (las funciones de
						php tienen problemas con las comas que sepàran decimales)
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$string			Cadena que contiene la informacion
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function es_numero($string){
			$ln =  strlen($string);  //longitud de la cadena que contiene el numero
			$string = (string)$string;
	
			//=== Evalua si es un numero con dos puntos de decimales>>
			$cantidad = substr_count($string,".");
			if( $cantidad>1 )  return false; 
	
			//=== Evalua si ingreso letras en el numero>>
			for($i=0;$i< $ln; $i++){
				$cantidad = substr_count( "1234567890.,-",$string[$i]);
				if( !$cantidad )  return false; //encontro algo que no es numero
			}
			return true;  //si es numero
		}
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	Determinar si una cadena es o no un numero pero no acepta signos
						ni puntos ni comas					
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$string			Cadena que contiene la informacion
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function es_numero_sin_signos($string){
			$ln =  strlen($string);  //longitud de la cadena que contiene el numero
			$string = (string)$string;
	
			//=== Evalua si ingreso letras en el numero>>
			for($i=0;$i< $ln; $i++){
				$cantidad = substr_count( "1234567890",$string[$i]);
				if( !$cantidad )  return false; //encontro algo que no es numero
			}
			return true;  //si es numero
		}
		/*=====2005/05/25=======================================D E C K===>>>>
		DESCRIPCION: 	Metodo para armar una secuencia que indica la poagina en la cual
						se encuentra de acuerdo al resultado de una consulta			
						De mayor uso en MYSQL
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$num_pagina		Numero de la pagina actual
		$num_paginas	Cantidad de Paginas que se indicaran
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_crar_paginador_mysql($num_pagina,$num_paginas){
			//==== Arma las columnas que mostrara cada nueva pagina>>>
			if(!$num_pagina) $num_pagina=1;
			for($i=0;$i<$num_paginas;$i++){
				$pagina = $i+1;
				if($pagina == $num_pagina) 
					$tabla_paginas .= "<td class='boton'>$pagina</td>";
				else				
					$tabla_paginas .= "<td> <a  class='Estilo13' href='javascript:seleccionar_pagina($pagina)'> $pagina </a></td>";		
			}
			$tabla_completa= "
			<table width='1%'  border='1' align='right' cellpadding='3' cellspacing='0' bordercolor='#CCCCCC'>
			<tr bgcolor='#FFFFFF' class='pieResultado'>
			<td nowrap class='Estilo13' >Pagina </td>
			$tabla_paginas
			</tr></table>";
			return $tabla_completa;
		}
		/*=====2007/04/07=======================================D E C K===>>>>
		DESCRIPCION: 	Construye una lista de valor a partir de un cursor
		AUTOR:			Juan Fontecha M.
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$cursor			cursor generado a partir de una consulta determinada
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function fn_crear_lista_vector($vector, $cod_select=NULL) 	  
		{
			$cadena1="--";
			$cantidad_elementos = count($vector);
			for($i=0; $i<$cantidad_elementos; $i++){
				if($vector[$i][0] == $cod_select) $selected = 'selected';
				else  $selected = '';
				$row[1]		= ucfirst(strtolower($row[1]));
				$cadena = $cadena."<option value='".$vector[$i][0]."' $selected>".$vector[$i][1]."</option>";
			}
			return $cadena;
		}
		
		/*=====2005/05/25=============================================Arellano Company===>>>>
		DESCRIPCION: 	Paginador que tiene en cuenta la cantidad de registros y la
						cantidad maxima por pagina
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$num_pagina		Numero de la pagina actual
		$num_paginas	Cantidad de Paginas que se indicaran
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		function f_crar_paginador_mysql_con_datos(
				$num_pagina					,
				$num_max_registros			,
				$num_registros 				,
				$txt_estilo_seleccionado	,
				$txt_estilo_normal
				){
			
			$celda_anterior = "<td nowrap style='padding:5px;' align='center'>Pagina &nbsp; </td>";
			
			//=== Evalua cantidad de paginas>>>
			if($num_max_registros <= 0)$num_paginas = 1;
			else if($num_max_registros > 0)		$num_paginas			= $num_registros/$num_max_registros;
			
			$entero_num_paginas 	= round($num_paginas);
			if(($num_paginas - $entero_num_paginas)>0) $num_paginas = $entero_num_paginas+1;
			//==== Arma las columnas que mostrara cada nueva pagina>>>
			if(!$num_pagina) $num_pagina=1;
			
			$num_max_paginas = 20;
			$ind_segundo_grupo = false;
	
			//==== Hace que salgan grupos maximos de 20 paginas>>>
			if(is_int($num_pagina/20)){
				$inicio_i =$num_pagina-1;
				$ind_segundo_grupo = true;
			}else{	
				$divisor	= $num_pagina/20;
				$divisor	= explode(".",$divisor);
				$divisor	= $divisor[0];
				$inicio_i = 20*$divisor;
			}
			$num_ciclos =0;
			
			for($i=$inicio_i;$i<$num_paginas;$i++){
				$num_ciclos ++;
				if($ind_segundo_grupo == true){
					if($num_ciclos >20+1) break;
				}else{
					if($num_ciclos >20) break;
				}			
				//if($num_ciclos >20) break;
				
				$pagina = $i+1;
				if($pagina == $num_pagina){
					$pagina_seleccionada = $pagina;
					$tabla_paginas .= "<td class='$txt_estilo_seleccionado td_paginador_selected' >$pagina</td>";
				}
				else				
					$tabla_paginas .= "<td class=' td_paginador' onclick='seleccionar_pagina($pagina);'>".$pagina."</td>";		
			}
			
			if($num_pagina<$num_paginas){
				$num_siguiente = $num_pagina+1;
				$celda_siguiente= "	<td class='td_paginador' nowrap onclick='seleccionar_pagina($num_siguiente);'>Siguiente &gt;&gt;</td>";
			}
			if($num_pagina>1){
				$num_anterior 	= $num_pagina-1;		
				$celda_anterior	= "	<td nowrap class='td_paginador' onclick='seleccionar_pagina($num_anterior);' >&lt;&lt; Anterior</td>";
				$celda_inicio = "<td class='td_paginador' nowrap onclick='seleccionar_pagina(1);'>Inicio</td>";
			}
			
			if($pagina_seleccionada<$num_paginas){
				$celda_ultima = "<td class='td_paginador' 
									nowrap onclick='seleccionar_pagina(".ceil($num_paginas).");'>Ultima</td>";
			}
			
			$contador_paginas = "<tr>
									<td nowrap style='background-color:transparent' colspan='25' 
										align='center'>Pagina ".$pagina_seleccionada." de ".ceil($num_paginas)."</td>
								</tr>";
			
			if($pagina<$num_paginas){
				$celda_siguiente_grupo = "<td class='td_paginador' nowrap 
											onclick='seleccionar_pagina(".$pagina.");'>&nbsp; ...  &nbsp;</td>";				
			}
			
			if($num_paginas > 1){
				$tabla_completa= " <hr>
				<table width='1%' class='' id='tabla_paginador'  align='center' cellpadding='3' cellspacing='0'  >
					<tr>
						$celda_inicio
		
						$celda_anterior
				
						$tabla_paginas 
						
						$celda_siguiente_grupo
						
						$celda_siguiente
						
						$celda_ultima
					</tr>
					
					$contador_paginas
					
				</table>";
			}else{
				$tabla_completa= " <hr>
				<table width='1%' class='' id='tabla_paginador'  align='center' cellpadding='3' cellspacing='0'  >
					
					$contador_paginas
					
				</table>";	
			}
			
			$tabla_completa .= '<script>
									
								
								</script>';
			return $tabla_completa;
		}	
		
		/*=====2005/05/25=============================================D E C K===>>>>
		DESCRIPCION: 	Paginador que tiene en cuenta la cantidad de registros y la
						cantidad maxima por pagina
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO		DESCRIPCION 
		$num_pagina		Numero de la pagina actual
		$num_paginas	Cantidad de Paginas que se indicaran
		---------------------------------------------------------------------------					
		HISTORIAL DE MODIFICACIONES
		---------------------------------------------------------------------------					
		FECHA	AUTOR		MODIFICACION
		===========================================================================*/
		/*function f_crar_paginador_mysql_con_datos(
				$num_pagina					,
				$num_max_registros			,
				$num_registros 				,
				$txt_estilo_seleccionado	,
				$txt_estilo_normal
				){
			//=== Evalua cantidad de paginas>>>
			$num_paginas			= $num_registros/$num_max_registros;
			$entero_num_paginas 	= round($num_paginas);
			if(($num_paginas - $entero_num_paginas)>0) $num_paginas = $entero_num_paginas+1;
			//==== Arma las columnas que mostrara cada nueva pagina>>>
			if(!$num_pagina) $num_pagina=1;
	
			//==== Hace que salgan grupos maximos de 20 paginas>>>
			if(is_int($num_pagina/20)) $inicio_i =$num_pagina-1;
			else{	
				$divisor	= $num_pagina/20;
				$divisor	= explode(".",$divisor);
				$divisor	= $divisor[0];
				$inicio_i = 20*$divisor;
			}
			$num_ciclos =0;
			for($i=$inicio_i;$i<$num_paginas;$i++){
				$num_ciclos ++;
				if($num_ciclos >20) break;
				$pagina = $i+1;
				if($pagina == $num_pagina) 
					$tabla_paginas .= "<td class='$txt_estilo_seleccionado'>$pagina</td>";
				else				
					$tabla_paginas .= "<td class='$txt_estilo_normal'> <a class='$txt_estilo_normal' href='javascript:seleccionar_pagina($pagina)'> $pagina </a></td>";		
			}
			if($num_pagina<$num_paginas){
				$num_siguiente = $num_pagina+1;
				$celda_siguiente= "	<td >
									<a href='javascript:seleccionar_pagina($num_siguiente)' class='$txt_estilo_normal'> 
									Siguiente&gt;&gt;</a></td>";
			}
			if($num_pagina>1){
				$num_anterior 	= $num_pagina-1;		
				$celda_anterior	= "	<td >
									<a href='javascript:seleccionar_pagina($num_anterior)' class='$txt_estilo_normal'>
									&lt;&lt;Anterior
									</a></td>";
			}
			$tabla_completa= "
			<table width='1%' class='$txt_estilo_normal' border='1'  cellpadding='3' cellspacing='0' bordercolor='#E9E9E9'>
			<tr>
			$celda_anterior
			<td nowrap >Pagina </td>
			$tabla_paginas 
			$celda_siguiente
			</tr></table>";
			return $tabla_completa;
		}	*/
		/*=====2005/05/25=============================================D E C K===>>>>
		DESCRIPCION: 	Metodo para calcular la edad de una persona especifica
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO			DESCRIPCION 
		$fecha_nacimiento	Formato año-mes-dia
		===========================================================================*/
		function f_calcular_edad($fecha_nacimiento) {
			list($y, $m, $d) = explode("-", $fecha_nacimiento);
			$y_dif = date("Y") - $y;
			$m_dif = date("m") - $m;
			$d_dif = date("d") - $d;
			if ((($d_dif < 0) && ($m_dif == 0)) || ($m_dif < 0))
				$y_dif--;
			return $y_dif;
		}	
		/*=====2005/05/25=============================================D E C K===>>>>
		DESCRIPCION: 	Metodo para calcular diferencia en horas frente a la fecha actual
		AUTOR:			Cristian Arellano
		---------------------------------------------------------------------------					
		PARAMETRO			DESCRIPCION 
		$fec_evaluacion		año-mes-dia hora:minuto:segundo
		===========================================================================*/
		function f_diferencia_horas_fecha_actual($fec_evaluacion) {
			date_default_timezone_set("America/Bogota");
			$fec_cortada		=explode(" ",$fec_evaluacion);
			$fec_dia			=explode("-",$fec_cortada[0]);//dia
			$fec_hora			=explode(":",$fec_cortada[1]);//hora
			
			$hora				=$fec_hora[0];
			$minuto				=$fec_hora[1];
			$segundo			=$fec_hora[2];
			$mes				=$fec_dia[1];
			$dia				=$fec_dia[2];
			$year				=$fec_dia[0];
			
			$hora_actual		=date('H'); 
			$minuto_actual		=date('i');
			$segundo_actual		=date('s');
			$mes_actual			=date('m');
			$dia_actual			=date('d');
			$year_actual		=date('Y');
			
			$fecha_comparacion	=mktime($hora,$minuto,$segundo,$mes,$dia,$year);
			$fecha_actual		=mktime($hora_actual,$minuto_actual,$segundo_actual,$mes_actual,$dia_actual,$year_actual);
			$horas_diferencia	=($fecha_actual-$fecha_comparacion)/ (60 * 60);
			return				$horas_diferencia;
		}	
	} // fin clase
} // fin validacion if_exist
?>