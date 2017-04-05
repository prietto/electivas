<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> - Reporte de <?=$alias_tabla_autonoma?></title>
<link href="../../estilos/estilo_impresion.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>

<body  onLoad="activar_ventana()" onUnload="cerrar_venana_emergente()"  onKeyPress="evalua_tecla_body(this,event)">
<form id="form1" name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td><table width="100" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td align="center"><table width="100" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="90%" align="left" valign="bottom"><span class="Titulo_principal"><a href="javascript:f_print_reporte()" class="combo_solicitud">Imprimir</a> <br />
                  REPORTE DE
  <?=$alias_tabla_autonoma?>
                  </span></td>
                <td align="right" nowrap="nowrap" class="titulo_ventana_emergente">&nbsp;</td>
                </tr>
              </table>                  </td>
            </tr>
          <tr>
            <td align="left"><span class="combo_solicitud">
              <?=$tabla_resultado?>
              </span></td>
            </tr>
          <tr>
            <td align="center" nowrap="nowrap"><span class="texto_informativo">Software desarrollado por Luis Prieto - DECK Systems<strong></strong></span></td>
            </tr>
          </table>
          <input name="cod_pk" 		type="hidden" />
          <input name="cod_tabla" 	type="hidden"	value="<?=$cod_tabla?>" />
          <input name="ind_buscar" 	type="hidden"	value="1"/>
          <input name="num_pagina"	type="hidden" />
          <input name="num_max_registros"	type="hidden" value="<?=$num_max_registros?>" />
          <input name="ord_por" 		type="hidden" 	value="<?=$ord_por?>"/>
          <script>		
/*=====2008/06/02================================Arellano_Company===>>>>
DESCRIPCION: 	cambia a la pagina seleccionada
AUTOR:			Cristian Arellano
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
---------------------------------------------------------------------------					
HISTORIAL DE MODIFICACIONES
---------------------------------------------------------------------------					
FECHA	AUTOR		MODIFICACION
===========================================================================*/
function seleccionar_pagina(num_pagina){
	f= document.form1;
	f.target				= '_self';
	f.num_pagina.value		= num_pagina;
	navegar(69)
}
            </script>
          <script>		
function f_print_reporte(){
	window.print();
}
f_print_reporte();
            </script></td>
        </tr>
    </table></td>
  </tr>
</table>
<input type="hidden" name="cod_navegacion">
<input type="hidden" name="cod_usuario" value="<?=$cod_usuario?>">
<input type="hidden" name="ind_limpiar_variables" />
</form>
<script>
function navegar(cod_navegacion){
		document.form1.cod_navegacion.value=cod_navegacion;
		document.form1.action="../principal/controlador.php";
		document.form1.submit();
	}	
</script>
<script>
function cerrar_venana_emergente(){ //le indica a la ventana padre que todavia esta activa
	window.opener.cerrar_venana_emergente();
}
</script>	
<script>
function activar_ventana(){ //le indica a la ventana padre que todavia esta activa
	window.opener.activar_ventana_emergente();
}
</script>	
<script>
function navegar_limpiando_variables(cod_navegacion){
		document.form1.target="_self"
		document.form1.ind_limpiar_variables.value = 1; // para que el sistema sepa que debe borrar la posible basura
		navegar(cod_navegacion)
}	
</script>
</body>
</html>
