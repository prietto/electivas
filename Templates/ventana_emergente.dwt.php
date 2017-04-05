<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../estilos/estilo_general.css" rel="stylesheet" type="text/css" />

<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- TemplateBeginEditable name="doctitle" -->
<title>Ventana Emergente</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
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
    <td><!-- TemplateBeginEditable name="EditRegion3" -->EditRegion3<!-- TemplateEndEditable --></td>
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
</html>
