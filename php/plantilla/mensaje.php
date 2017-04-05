<script>
$(function(){
	var height_screen = $(window).height();
	$('#layer_mensaje').css('max-height',height_screen-200);
	

})

</script>

<?
include("../librerias/mensaje.php");

//=== se encarga de cargar los datos relacionados a los mensajes a mostrar >>>
$mensaje 		= new mensaje;
$cursor 		= $mensaje->f_get_mensajes($arr_mensajes);
$num_registros 	= $db->num_registros($cursor);
$num_mensajes	= count($arr_mensajes);
//=== Ordena los mensajes que se van a mostrar >>>
/*
for($i=0; $i<$num_registros; $i++){
	$aray_registros = $db->sacar_registro($cursor,$i);
	for($j=0; $j<$num_mensajes; $j++){
		if($arr_mensajes[$j] == $aray_registros['cod_mensaje']){
			$mensaje 		= $aray_registros['txt_mensaje'];
			$mensaje		= str_replace('$parametro', $arr_parametro[$j], $mensaje); //remplaza el posible parametro que tiene el mensaje
			$motivo  		= $aray_registros['txt_motivo'];
			$solucion		= $aray_registros['txt_solucion'];
			$cadena_mensaje 				=  "$cadena_mensaje <tr><td><b>MENSAJE:</b></td> <td>$mensaje</td></tr>";			
			if($motivo) 	$cadena_mensaje =  "$cadena_mensaje <tr><td><b>MOTIVO:</b></td> <td>$motivo</td></tr>";		
			if($solucion) 	$cadena_mensaje =  "$cadena_mensaje <tr><td><b>SOLUCION:</b></td> <td>$solucion</td></tr>";									
			$cadena_mensaje = str_replace('$parametro', $arr_parametro[$j], "$cadena_mensaje");
		}
	}
}*/

?>
<style type="text/css">
<!--
#Layer1 {
	position:fixed;
	left: 50%;
	margin-left:-20%;
	top:51px;
	width:40%;
	height:291px;
	z-index:10000;
}
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 18px;
	color: #FFFFFF;
}
.Estilo2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Estilo8 {font-size: 12px}
.Estilo10 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #990000; }
-->
</style>
<div id="Layer1" >
  <table width="100%" border="2" cellpadding="0" cellspacing="0" bordercolor="#000066">
    <tr>
      <td>
      
      <table width="100%" border="0" cellpadding="3" cellspacing="3" bgcolor="#000066">
        <tr>
          <td align="center">
          <div style=" position:relative;">
	          <span class="Estilo1" style="font-size:20px;">ALERTA</span>
          	<div style=" position: absolute; right:0; top:0;">
            	<input type="button" name="Submit" value="x" onclick="f_cerrar_ventana_mensaje()" />
            </div>
          </div>
          
          	</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><span class="Estilo2"> </span>
              <table width="100%" border="0" cellspacing="10" cellpadding="0">
                <tr>
                  <td>
                  
              <div style=" overflow:auto; " id="layer_mensaje">    
              <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" >
                      <?
//=== Ordena los mensajes que se van a mostrar >>>
for($i=0; $i<$num_registros; $i++){
	$aray_registros = $db->sacar_registro($cursor,$i);

	for($j=0; $j<$num_mensajes; $j++){
		if($arr_mensajes[$j] == $aray_registros['cod_mensaje']){
			
			$cod_mensaje	= $aray_registros['cod_mensaje'];
			
			$mensaje 		= $aray_registros['txt_mensaje'];
			$mensaje		= str_replace('$parametro', "<b>".$arr_parametro[$j]."</b>", $mensaje); //remplaza el posible parametro que tiene el mensaje
			$motivo  		= $aray_registros['txt_motivo'];
			$motivo			= str_replace('$parametro', "<b>".$arr_parametro[$j]."</b>", $motivo); //remplaza el posible parametro que tiene el mensaje			
			$solucion		= $aray_registros['txt_solucion'];
			$solucion		= str_replace('$parametro', $arr_parametro[$j], $solucion); //remplaza el posible parametro que tiene el mensaje			
		
?>
                      <tr>
                        <td width="21%" valign="top"><span class="Estilo10">Mensaje:</span></td>
                        <td width="79%"><span class="Estilo2">
                          <?=$mensaje?>
                        </span></td>
                      </tr>
                      <? if($motivo){ ?>
                      <tr>
                        <td valign="top"><span class="Estilo10">Motivo:</span></td>
                        <td><span class="Estilo2">
                          <?=$motivo?>
                        </span></td>
                      </tr>
                      <? } ?>
                      
                      <? if($solucion){ ?>
                      <tr>
                        <td valign="top"><span class="Estilo10">Soluci&oacute;n:</span></td>
                        <td><span class="Estilo2">
                          <?=$solucion?>
                        </span></td>
                      </tr>
                      <? } ?>
                      
                       <tr>
                        <td valign="top" nowrap="nowrap"><span class="Estilo10">Cod. Error:</span></td>
                        <td><span class="Estilo2">
                          <?=$cod_mensaje?>
                        </span></td>
                      </tr>
                      
                      <tr>
                        <td colspan="2"><hr /></td>
                        </tr>
                      <?
		}
	}
}

?>
                  </table>
                  </div>
                  
                  </td>
                </tr>
                <tr>
                  <td align="center"><input type="button" name="Submit2" value="Aceptar" onclick="f_cerrar_ventana_mensaje()" /></td>
                </tr>
              </table>
            <span class="Estilo2"> </span></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <script>
function f_cerrar_ventana_mensaje(){
  // document.getElementById('Layer1').style.display = 'none';
   $('#Layer1').remove();
   $('#overlay_mensaje').remove();
}

$(function(){
	var html = "<div id='overlay_mensaje' class='overlay'></div>";
	$('body').append(html);
})

</script>
</div>
