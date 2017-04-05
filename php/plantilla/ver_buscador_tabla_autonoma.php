<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/ventana_emergente.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<link href="../../estilos/estilo_general.css" rel="stylesheet" type="text/css" />

<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Buscador de <?=$alias_tabla_autonoma?></title>
<!--<link href="../../estilos/estilos_calendario.css" rel="stylesheet" type="text/css" />-->
<!--<link href="../../estilos/hipervinculos.css" rel="stylesheet" type="text/css" />-->
<link href="../../estilos/multiselect.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../estilos/jquery-ui.css" />
<link  rel="stylesheet" type="text/css" href="../../estilos/select2.css"/>
<script src="../../js/jquery-1.11.2.min.js"></script>
<script src="../../js/jquery-ui.min.js"></script>
<script src="../../js/formato_fecha.js"></script>
<script src="../../js/select2.js" ></script>
<script src="../../js/jquery_multiselect.js" ></script>
<script>
$(function(){$(".multiple_select").multiselect({});});
</script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body  onLoad="activar_ventana()" onUnload="cerrar_venana_emergente()"  onKeyPress="evalua_tecla_body(this,event)">
<form id="form1" name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td><!-- InstanceBeginEditable name="EditRegion3" -->
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td bgcolor="#B4C8F6"><table width="70%" border="0" cellspacing="5" cellpadding="0">
            <tr>
              <td align="center" class="titulo_principal">BUSCADOR DE <?=$alias_tabla_autonoma?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="center"><table width="100%" border="0" align="center">
                <?
for($i=0; $i<$num_columnas; $i++){
	$row_columna		= array_pop($row_imputs);
	$txt_alias			= $row_columna['txt_alias'];
	$input				= $row_columna['input'];	
	$i++;
	$row_columna		= array_pop($row_imputs);
	$txt_alias2			= $row_columna['txt_alias'];
	$input2				= $row_columna['input'];	
	
	
	$txt_alias			= 	mb_strtolower($txt_alias, 'UTF-8');
	$txt_alias			= ucwords($txt_alias);
	
	$txt_alias2			= 	mb_strtolower($txt_alias2, 'UTF-8');
	$txt_alias2			= ucwords($txt_alias2);

	if(!$txt_alias)		$dos_puntos = "";
	else				$dos_puntos = ":";
	if(!$txt_alias2)	$dos_puntos2 = "";
	else				$dos_puntos2 = ":";
	
	
?>
                <tr>
                  <td align="left" nowrap="nowrap" class="contenido"><?=$txt_alias?></td>
                  <td width="1%" align="left" nowrap="nowrap" class="contenido"><?=$dos_puntos?></td>
                  <td align="left" nowrap="nowrap" class="contenido"><?=$input?></td>
                  <td align="left" nowrap="nowrap" class="combo_solicitud">&nbsp;</td>
                  <td align="left" nowrap="nowrap" class="contenido"><?=$txt_alias2?>                  </td>
                  <td width="1%" align="left" nowrap="nowrap" class="contenido"><?=$dos_puntos2?></td>
                  <td align="left" nowrap="nowrap" class="contenido"><?=$input2?>                  </td>
                </tr>
                <? } ?>
                <tr>
                  <td colspan="7" nowrap="nowrap"><table width="100%" border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <td align="left"><input type="button" class="contenido" name="esc" value="&lt;&lt; Atras" onclick="f_esc()"/></td>
                        <td align="center"><span class="combo_solicitud">
                          <? if($ind_tiene_permiso_insert && 1==2){?>
                          </span>
                            <input name="enter2" type="button" id="enter2" class="contenido" onclick="navegar_limpiando_variables(127)" value="Nuevo Registro" />
                            <span class="combo_solicitud">
                            <? } ?>
                          </span></td>
                        <td align="right" nowrap="nowrap"><input name="enter" class="contenido" id="enter" onclick="f_enter()"  type="button" value="Consultar &gt;&gt;" /></td>
                        </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
          </table>
            <table width="100%" border="0" cellpadding="10" cellspacing="0">
              <tr>
                <td bgcolor="#FFFFFF">
                
                <span class="combo_solicitud">
                  <?=$tabla_resultado?>
                  </span> <br />
                  <br />
                  <table width="10%"  border="0" align="center" cellpadding="2" cellspacing="0">
                    <tr class="pieResultado">
                      <td><?=$tabla_paginas?>
                      </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            </td>
        </tr>
      </table>
<script>	
/*=====2008/06/01========================================D E C K===>>>>
	DESCRIPCION: 	Metodo para enviar todo el registro a la pagina principal que llamo
					la ventana emergente
===========================================================================*/
function enviar_datos(id,nombre,empresa){
	//window.opener.cargar_reg_emergente(id,nombre,empresa);
	//window.opener.focus();
	window.opener.cargar_reg_emergente(id,nombre,empresa);

}
</script>	
<script>
function  evalua_tecla_body(cuerpo ,evento){
	//======== evaluacion de las teclas ===========>>>>>
	var enter			= 13;
	var tecla_presionada= (window.Event) ? evento.which : evento.keyCode; //captura la tecla que fue precionada
	if(tecla_presionada== enter) navegar(3)
}
</script>	

<script>
function f_ordenar_por(ord_por){
	f.ord_por.value = ord_por;
	f_enter();
}
</script>		
<script>
f = document.form1;
function f_enter(){
	f.ind_buscar.value =1;
	f.enter.disabled = true;
	navegar(43);
}
function f_esc(){
	window.opener.focus();
}

function seleccionar_pagina(num_pagina){
	f= document.form1;
	f.target				= '_self';
	f.num_pagina.value		= num_pagina;
	f_enter()
}

function ver_registro(cod_pk){
	f= document.form1;
	f.target				= '_self';
	f.cod_pk.value			= cod_pk;
	navegar_limpiando_variables(37);
}
</script>			   
      <input name="cod_pk" 						type="hidden">
      <input name="cod_tabla" 					type="hidden"	value="<?=$cod_ventana_emergente?>" />
      <input name="ind_buscar" 					type="hidden">
      <input name="num_pagina"					type="hidden">
      <input name="ord_por" 					type="hidden" 	value="<?=$ord_por?>"/>
      <input name="txt_nombre_columna_iframe"	type="hidden" value="<?=$txt_nombre_columna_iframe?>"/> 
      <input name="cod_ventana_emergente"		type="hidden" value="<?=$cod_ventana_emergente?>"/>
      <iframe  name="frame_oculto" width="0" marginwidth="0"  height="0"   frameborder="0" id="frame_oculto" ></iframe>
    <!-- InstanceEndEditable --></td>
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
function  evalua_tecla_body(cuerpo ,evento){
	var tecla_presionada= (window.Event) ? evento.which : evento.keyCode; //captura la tecla que fue precionada
	if(tecla_presionada== 13 ) 		f_enter();
	else if(tecla_presionada== 27 ) f_esc();
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
<!-- InstanceEnd --></html>
