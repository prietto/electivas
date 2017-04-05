<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Cargando...</title>
<link rel="stylesheet" type="text/css" href="estilos/estilo_general.css">
<link rel="stylesheet" type="text/css" href="estilos/hover_master.css">
<link rel="stylesheet" type="text/css" href="estilos/buttons.css">

</head>

<body>

	<form name="form1" method="post" action="">
		<table width="100%"  border="0" cellspacing="0" cellpadding="10">
        	<tr>
	          <td align="center"><p class="Estilo15">&nbsp;</p>
    	        <p class="Estilo15">&nbsp;</p>
        	    <p class="Estilo15">&nbsp;</p>
            	<p class="Estilo18"><span class="Estilo17">
                <img src="imagenes/sistema/preloader_0.gif" title="Cargando" alt="Cargando" /> </span></p></td>
	        </tr>
    	</table>
        
        <input type="hidden" name="cod_navegacion">
	</form>
<script>
cargar()
function cargar(){
		f						=	document.form1;
		f.action				=	"php/plantilla/ver_validar_usuario.php";
		f.submit();
}	
</script>






</body>
</html>