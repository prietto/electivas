/*=====2010/05/26=======================================================>>>>
DESCRIPCION: 	Recibe un numero sin importar que este separado por miles, millones
				155465.5654 <--bien;   15,333.55<-- bien; 	155465.57 <---  Este es el numero que retorna a 2 decimales
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
cadena			numero
nro_decimales	cantidad de decimales que entregara el numero
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
function redondear_decimales(cadena, nro_decimales) 
{
	cadena = cadena+''; //para cambiar el tipo de dato ya que puede entrar como numerico
	if (cadena.length ==0) {return 0} //el numero encontrado se asume como cero
	var acum_pos		=	0; //acumula cada 3 numeros
	var pos_punto		=	'none';	//no tiene punto
	var cad				=	"";
	var encontro_punto  =   false; //bandera que indica si se encontro o no un punto
	nro_decimales	= Number(nro_decimales);
	
	//--------------- para buscar la posicion del punto ------------------
	pos_cad = 0; //para evitar el valor del i
	for (i=0; i < cadena.length ; i++)	
	{
		letra =  cadena.charAt(i); //obtiene el ascii    	
		if(letra ==',')	{
			i++; //salta el caracter ','
	    	letra =  cadena.charAt(i); //obtiene el ascii    			
		}
		if(letra == '.' && encontro_punto == false)	
		{
			encontro_punto = true;
			pos_punto = pos_cad;
		}
		cad  = cad+letra;			//alert(cadena+"---"+letra+"--"+i);		
		pos_cad++; 
	}
	if(pos_punto==0) 
	{
		pos_punto++;	//mueve el punto una posicion
		cad = '0'+cad; //para casos cd .55 lo coloque a 0.55
	}
	cadena = cad;
	
	//si encontro un punto y la cantidad de decimales amerita formatear 1.1 no formatearia 2 decimales
	if(pos_punto!='none'	&& 	(pos_punto+nro_decimales+1)<=cadena.length ) { 
		pos_redondeo 	= pos_punto+nro_decimales+1;//numero despues de la cantidad de decimales
		vlr_redondeo	=	cadena.charAt(pos_redondeo)
		if( cadena.charAt(pos_redondeo)>=5)			inc = 1	//incremento de ceimales 
		else										inc = 0 // 	
		if( cadena.charAt(pos_redondeo-1)=='.') 	retroceso = 2 ;// si debe dejar cero decimales
		else										retroceso = 1
		if(pos_redondeo-retroceso<0)				cadena= inc; //para un Nro como .4564 con Nro decimales = 0
		else 		//cadena.charAt(pos_redondeo-retroceso) = cadena.charAt(pos_redondeo-retroceso)+inc	
		{
			cad = ''; //almacenara temporalmente el numero
			for(i=0;  i<pos_redondeo; i++) 
			{
				if(i== pos_redondeo-retroceso)
				{
				 vlr = Number(cadena.charAt(pos_redondeo-retroceso))+Number(inc)// Valor de la posicion a redondear 	
				}
				else	vlr =	cadena.charAt(i)
				if(i== pos_punto && nro_decimales == 0)//para evitar numeros como 54646.  <- quita el punto final
				{}
				else
				if(vlr==10 && i<pos_punto){
					cad	= Number(cad)+Number(1);
					cad = cad+'0';
				}else if(vlr==10 && i>pos_punto){
					num_decimales_redondeo 	= i-pos_punto;
					divisor					= 1;
					for(k=1;k<num_decimales_redondeo; k++) divisor = divisor/10;//divide el 1 para que de 0.1 o 0.01 o 0.001 o 0.0001
					cad	= Number(cad)+Number(divisor);
					cad = cad+'0';
				}else
					cad = cad+''+vlr;
			}	
			cadena =  cad;		
		}
	}
	cad = '';	
	return cadena;
}  
/*=====2010/05/26=======================================================>>>>
DESCRIPCION: 	Este metodo recibe un numero 12345.45 y retorna 12,345.45

---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
numero			cadena de caracteres que representa un numero
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
function formato_numero(numero){
	var invertido 	='';	//el numero ingresado por parametro pero invertido para colocar la coma en el proceso cuando se esta inviertiendo
	var num_temp	=''; 	
	i = 0;		//contador que recorre todos los caracteres del numero
	k = 0;		//contantador para voltear los numeros
	
	numero = numero+'';	//para que se tansforme  en cadena
	//busca la posicion donde se encuentra el punto
	while (numero.charAt(i)!= "" && numero.charAt(i) != ".") 	i++;
	acum3 = 0;  //indica cuando  se cumplieron tres numeros y se debe colocar una coma	
	for(j = i-1; j>=0; j--){
		if( acum3 ==3 ){
			invertido =  invertido+","; //se coloca una coma al encontrar tres numeros		
			acum3=0;					//reinicia el contador de tres numeros
		}
		invertido =  invertido+""+numero.charAt(j);		
		acum3++;	
	}
	//recarga los numeros que estan despues del punto (si es que tiene decimales)
	while (numero.charAt(i) != ""){
		num_temp = num_temp+""+numero.charAt(i);
		i++;
	}
	numero = num_temp ;
		
	while (invertido.charAt(k) != ""){
		numero = invertido.charAt(k)+""+numero;
		k++;
	}
	return numero;
}

/*=====2010/05/26=======================================================>>>>
DESCRIPCION: 	Este metodo se encarga de validar si un objeto tiene un valor
            	numerio si lo es retorna true de lo contrario retorna false

---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
Cadena			Cadena de caracteres que deberia contener la representacion de un numero (ejemplo 5465465)
Retorna True    --> si es numero
Retorna False   --> no es numero
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
function es_numero(cadena) 
{
  if (cadena.length ==0)	return true //si no hay nada se asume que si es numero  
  for (esnum_i=0; esnum_i< cadena.length; esnum_i++)	
  { 
	   codigo_retorno = false;  //se asume que cada letra no es numero por eso debe ser validada
	   letra =  cadena.charAt(esnum_i); //obtiene la letra
	   if(letra == 0 || letra == 1 || letra ==  2  || letra == 3 ||letra == 4 || letra == 5 || letra == 6 || letra == 7 || letra == 8 || letra == 9  || letra == '.' ) 
			codigo_retorno = true;
	   else
			return false;
  } 
  return codigo_retorno;
}	
/*=====2010/05/26=======================================================>>>>
DESCRIPCION: 	Valida que en un combo se ingresen valores numericos con la cantidad de decimales deseados 
            	y al mismo tiempo se puede ir dando formato al numero

---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
combo			imput
nmro_dcmles		numero de decimales que se le daran al numero
e				evento
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
function comportamiento_combo_numerico(combo,nmro_dcmles,e){
	e.preventDefault();

	cadena = combo.value;	
	if(combo.value=='') return true; //evalua si el combo esta sin datos para no colocar un cero innecesario

	//======== evaluacion de las teclas ===========>>>>>
	var fin			= 35;
	var inicio		= 36;
	var atras  		= 37;	
	var adelante	= 39;
	var enter		= 13;
	var outFocus	= 0; //cuando se sale de un combo
	var tabulador	= 9;
	var tecla_presionada 	= (window.Event) ? e.which : e.keyCode; //captura la tecla que fue precionada
	if (tecla_presionada == atras 		|| 
		tecla_presionada == adelante	||
		tecla_presionada == inicio		||
		tecla_presionada == outFocus	||	
		tecla_presionada == enter		||			
		tecla_presionada == tabulador	||
		tecla_presionada == fin		)  
			return true;			
	//======== Valida que el numero sea valido ===========>>>>>
	cadena 		= redondear_decimales(cadena, nmro_dcmles) 	//quita comas  que separan cientos, miles, etc
	if(es_numero(cadena) == false){
		alert("caracter no valido");
		var cadena = cadena.substring(0, cadena.length-1);
		cadena = formato_numero(cadena);
		combo.value = cadena;
		combo.focus();//se queda en el combo y no deja continuar 
		return false;
	}
	cadena = formato_numero(cadena);
	combo.value = cadena;
}



/*=====2011/12/31=======================================================>>>>
DESCRIPCION: 	indica si un numero es par o impar

---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
numero			Numero que se quiere evaluar 
===========================================================================*/
function f_es_impar(numero){
	num_con_decimales		= 	numero/2;
	num_redondo				= 	redondear_decimales(num_con_decimales, 0) ;
	if(num_redondo!=num_con_decimales) return true;
	else return false;
}