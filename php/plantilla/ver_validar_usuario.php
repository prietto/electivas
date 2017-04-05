<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Electivas - Prieto</title>
<link rel="stylesheet" type="text/css" href="../../estilos/estilo_general.css">
<link rel="stylesheet" type="text/css" href="../../estilos/buttons.css">
<script src="../../js/jquery-1.11.2.min.js"></script>
<script src="../../js/jquery-ui.js" ></script>
<script src="../../js/jquery.simplemodal.js" ></script>
<script src="../../js/opera_numeros.js"></script>
<script src="../../js/opera_cadenas.js"></script>
<script src="../../js/select2.js" ></script>
<script src="../../js/timepicker.js" ></script>
<script src="../../js/jquery.serializefullarray.js" ></script>
<script src="../../js/jquery_multiselect.js" ></script>
<script src="../../js/ajax_navegacion.js" ></script>
<script src="../../js/js_general.js"></script>

<script src="../../js/ver_validar_usuario.js"></script>
<script>var isChrome = window.chrome;if(!isChrome){window.location="download_browser.php";}</script>

</head>

<body>

	<div id="apDiv1">
		
        <table border="0" class="tabla_principal" cellpadding="0" cellspacing="0">
        
          
          <tr >
            <td align="center" class="td_header" >&nbsp;</td>
          </tr>
          
          <tr>
            <td align="center" class="td_contenido" style="height:100% !important;" >
              <p>&nbsp;</p>
              <p><span class="td_header"><img src="../../imagenes/sistema/logo.png" alt="" width="219" ></span></p>
              <form name="form1" id="form1" method="post" action="" > 
              <table width="24%" border="0" cellpadding="5" cellspacing="5">
                  <tr>
                    <td width="48%" align="right">Usuario</td>
                    <td width="5%">:</td>
                    <td width="49%" align="right">
                        <input type="text" id="txt_login" name="txt_login" required value="<?=$txt_login?>" />
                    </td>
                  </tr>
                  <tr>
                    <td align="right">Contraseña</td>
                    <td width="5%">:</td>
                    <td align="right">
                        <input type="password" id="txt_password" name="txt_password" required>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;
                    
                    </td>
                    <td>
                        
                    </td>
                    <td align="right">
                      <button class="button-small pure-button" id="btn_ingresar" >Entrar</button>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;
                    
                    </td>
                    <td>
                        
                    </td>
                    <td align="right">
                      <a href="javascript:void(0);" class="" id="btn_registrar" >Quiero registrarme</a>
                    </td>
                  </tr>
                </table>
                
                <input type="hidden" name="cod_navegacion">
                
                </form>
                       
            </td>
          </tr>
          
          <tr>
            <td align="center" class="td_footer" > 
          </tr>
        </table>

        
    </div>





<script>
/*function  evalua_tecla_body(cuerpo ,evento){
	//======== evaluacion de las teclas ===========>>>>>
	var enter			= 13;
	var tecla_presionada= (window.Event) ? evento.which : evento.keyCode; //captura la tecla que fue precionada
	if(tecla_presionada== enter) navegar(36)
}*/

</script>		
<?php if($ind_inicia_sesion == 1){ ?>
<script>
window.onload = function() {
	navegar(36);
};

</script>	
<?php } ?>


<script>
function navegar(cod_navegacion){
		document.form1.cod_navegacion.value=cod_navegacion;
		document.form1.action="../principal/controlador.php";
		document.form1.submit();
	}	

function navegar_limpiando_variables(cod_navegacion){
		document.form1.target="_self"
		document.form1.ind_limpiar_variables.value = 1; // para que el sistema sepa que debe borrar la posible basura
		navegar(cod_navegacion)
}	

function f_navegar_menu(cod_navegacion,cod_tabla,cod_tabla_detalle){
	f=document.form1;
	f.cod_tabla.value			=	cod_tabla;
	f.cod_tabla_detalle.value	=	cod_tabla_detalle;	
	navegar_limpiando_variables(cod_navegacion);
}
</script>

</body>
</html>