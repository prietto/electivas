<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/ventana_emergente.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<link href="../../estilos/estilo_general.css" rel="stylesheet" type="text/css" />

<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Ventana Emergente</title>
<script src="../../js/formato_fecha.js"></script>
<script src="../../js/dhtml_calendario.js" ></script>
<script src="../../js/opera_numeros.js" ></script>
<script src="../../js/opera_combos.js"></script>
<script src="../../js/opera_cadenas.js"></script>
<script src="<?=$js_navegacion?>"></script>
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
      <p>&nbsp;</p>
      <table width="100%" border="0" align="center" cellpadding="0">
        <tr>
          <td align="center" class="titulo_negro">REGISTRO DE
            <?php echo $alias_tabla_autonoma?>
            Nro.
            <?php echo $cod_pk?></td>
        </tr>
      </table>
      <br />
      <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="100%" align="left" bgcolor="#FFFFFF">
          
          <table width="10%"  border="0" align="center" cellpadding="0" cellspacing="0">
            <tr id="ver_foto" style="display:none" >
              <td align="center"><table width="100%" border="0" cellpadding="0" cellspacing="3" bgcolor="#1B2965">
                <tr>
                  <td align="right"><span class="sub_titulo"><a href="javascript:f_ocultar_foto()" class="sub_titulo"> <img src="../../imagenes/sistema/close_over.gif" width="16" height="16" border="0" /></a></span></td>
                </tr>
                <tr>
                  <td align="center"><a href="javascript:f_ocultar_foto()"><img src="" name="img_registro" border="0"  id="img_registro" /></a></td>
                </tr>
              </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><input type="button" name="eliminar_foto" value="Eliminar Foto"  class="contenido" onclick="f_eliminar_foto()" /></td>
                    <td align="right">&nbsp;</td>
                  </tr>
                </table></td>
            </tr>
          </table>
            <table border="0" align="center">
              <?php
for($i=0; $i<$num_columnas; $i++){
	$row_columna		= array_pop($row_imputs);
	$txt_alias			= $row_columna['txt_alias'];
	$input				= $row_columna['input'];
	$txt_alias			= ucwords(strtolower($txt_alias));
	$txt_alias			= str_replace("_"," ",$txt_alias);
	if(!$txt_alias)		$dos_puntos = "";
	else				$dos_puntos = ":";
?>
              <tr>
                <td valign="top" nowrap="nowrap" class="combo_solicitud"><?php echo $txt_alias?></td>
                <td valign="top" class="combo_solicitud"><?php echo $dos_puntos?></td>
                <td valign="top" nowrap="nowrap"><?php echo $input?></td>
              </tr>
              <?php } ?>
              <tr>
                <td colspan="3" nowrap="nowrap"><table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td align="left"><input type="button" name="esc" class="contenido" value="&lt;&lt; Cancelar" onclick="f_esc()"/></td>
                    <td align="center">&nbsp;</td>
                    <td align="right"><?php if($ind_mostrar_boton_guardar && $cod_pk){?>
                      <input name="enter" class="contenido" type="button" id="enter" onclick="f_enter()" value="Guardar&gt;&gt;" />
                      <?php } ?></td>
                  </tr>
                </table></td>
              </tr>
            </table>
            <br /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="15%">&nbsp;</td>
          <td>&nbsp;</td>
          <td width="15%" align="right" valign="bottom">&nbsp;</td>
        </tr>
      </table>
      <input name="cod_pk" 								type="hidden" 		value="<?php echo $cod_pk?>" />
      <input name="ind_new_row" 						type="hidden" 		value="<?php echo $ind_new_row?>" />
      <input name="ind_guardar_datos_tabla_autonoma" 	type="hidden"/>
      <input name="nom_columna_con_foto" 			type="hidden"/>
      <input name="txt_nombre_columna_iframe"		type="hidden"  value="<?=$txt_nombre_columna_iframe?>" />
      <input name="txt_ruta_mp3"					type="hidden" />
      <input name="ind_nuevo_registro"				type="hidden" value="1" />      
      
      <input name="cod_ventana_emergente"			type="hidden"  value="<?php echo $cod_ventana_emergente?>"/>
      <iframe  name="frame_oculto" width="1" marginwidth="0"  height="1"   frameborder="0" id="frame_oculto" ></iframe>
      <p>
        <script>
function f_eliminar_registro(){
	confirmacion = confirm ("El registro sera eliminado completamente del sistema \n\n &iquest;Desea Continuar?");
	if(confirmacion==true)	navegar(40)
}
function f_esc(){
	navegar(43);
}

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}


function f_enter(){
	
	// debe validar los campos requeridos antes de dar guardar
	
	f				=	document.form1;
	f.ind_guardar_datos_tabla_autonoma.value = 1 
	f.target		= '_self';
	navegar(47);
	/*f.target			= '_self';
	cod_pk				= f.cod_pk.value;
	nom_elemento_dom	= f.txt_nombre_columna_iframe.value;
	setTimeout(function() { send_data(cod_pk,nom_elemento_dom);}, 1000);
//	sleep(1000);*/
}






      </script>
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
