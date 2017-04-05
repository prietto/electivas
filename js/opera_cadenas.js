/*          _\\|//_				
;  º       (` o-o ') 			
;  º------ooO-(_)-Ooo-----------a------------->>>>>
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>-->
Objetivo:   Este metodo se encarga retornar un vector de n posiciones que 
            usando una cadena separada por algun caracter  por ejemplo
			10,20 retorna un array    variable_vector[0] = 10  ---- variable_vector[1] = 20
ENTRADAS:   Cadena de caracteres separada por el caracter especificao
SALIDAS:    Array 
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>--> */          
function string_to_array(separador , elem) {
	var cadena				= elem;		//almacena la cadena para recorrerla evitando problemas por perdida de informacion
	var longitud			= cadena.length;	//logitud de la cadena
	var vector_parametros 	= new Array();		//al	macenara en un vector cada parametro encontrado
	var j					= 0;				// el j indica la posiion dentro del vector parametros
	acum_cadena 		= '';				//acumula temporalmente las cadenas requeridas
	for(i= 0; i< longitud; i++){
		caracter = cadena.charAt(i);
		if(caracter != separador)
			acum_cadena 		= acum_cadena+caracter
		else{ 
			vector_parametros[j] 	= acum_cadena;
			j++;
			acum_cadena = ''; 				// limpia la informacion que tenga la cadena
		}
	}
	vector_parametros[j] 	= acum_cadena;	
	return vector_parametros;
}


/*          _\\|//_				
;  º       (` o-o ') 			
;  º------ooO-(_)-Ooo-----------a------------->>>>>
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>-->
Objetivo:   Este metodo devuelve un valor limpio del simbolo enviado por parametro
			100,000,000  retorna   1000000000
ENTRADAS:   cadena y simbolor a remplazar
SALIDAS:    cadena
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>--> */        
function replaceAll( text, busca, reemplaza ){


  while (text.toString().indexOf(busca) != -1){
	  	  text = text.toString().replace(busca,reemplaza);
	}

  return text;

}


