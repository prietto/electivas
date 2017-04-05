<?
/*=====2010/04/19===================================D E C K===>>>>
DESCRIPCION: 	Contiene las consultas contra la tabla seg_usuario
PROPIETARIO:	© D E C K
AUTOR:			Cristian Arellano
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
class seg_navegacion_estadistica{
	/*=====2010/04/19===================================D E C K===>>>>
	DESCRIPCION: 	Registra una visita a una pantalla especifica
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
	function p_registrar_visita(
			$cod_navegacion
	){
		global $db;
		$query ="insert into seg_navegacion_estadistica(cod_navegacion) values ($cod_navegacion)";
		$db->consultar($query);	
	}
	/*=====2010/04/19===================================D E C K===>>>>
	DESCRIPCION: 	Registra una visita a una pantalla especifica
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	===========================================================================*/
	function f_get_estadisticas(){
		global $db;
		$query ="
		select 	ne.cod_navegacion , 
				n.txt_descripcion ,
				count(ne.cod_navegacion) as num_visitas
		from 	seg_navegacion_estadistica ne,
				seg_navegacion n
		where	ne.cod_navegacion = n.cod_navegacion
		group by cod_navegacion
		order by num_visitas desc";
		$cursor	= $db->consultar($query);	
		return $cursor;
	}
	/*=====20140104===================================D E C K===>>>>
	DESCRIPCION: 	Genera estadistivas para una serie de codigos especificos
	AUTOR:			Cristian Arellano
	---------------------------------------------------------------------------					
	PARAMETRO		DESCRIPCION 
	cod_navegacion	Codigo de navegacion que se quiere para las estadisticas
	===========================================================================*/
	function f_get_by_cod_navegacion($cod_navegacion){
		global $db;
		$query ="
		select 	ne.cod_navegacion , 
				n.txt_descripcion ,
				count(ne.cod_navegacion) as num_visitas
		from 	seg_navegacion_estadistica ne,
				seg_navegacion n
		where	ne.cod_navegacion = n.cod_navegacion
		and		n.cod_navegacion in ($cod_navegacion)
		group by cod_navegacion
		order by num_visitas desc";
		$cursor	= $db->consultar($query);	
		return $cursor;
	}

}
?>