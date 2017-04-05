<!DOCTYPE HTML>
<html><!-- InstanceBegin template="/Templates/contenido_general.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">-->
<!-- InstanceBeginEditable name="doctitle" -->
<title>Registro de <?=$alias_tabla_autonoma?> Nro. <?=$cod_pk?></title>
<link href="../../estilos/estilos_calendario.css" rel="stylesheet" type="text/css" />
<link  href="../../estilos/hipervinculos.css" rel="stylesheet" type="text/css" />

<script src="../../js/formato_fecha.js"></script>
<script src="../../js/dhtml_calendario.js" ></script>
<script src="../../js/opera_numeros.js" ></script>
<script src="../../js/opera_combos.js"></script>
<script src="../../js/opera_cadenas.js"></script>

<script src="<?=$js_navegacion?>"></script>
<!-- InstanceEndEditable --> 
<link rel="stylesheet" type="text/css" href="../../estilos/estilo_general.css" />
<link rel="stylesheet" type="text/css" href="../../estilos/hover_master.css" />
<link rel="stylesheet" type="text/css" href="../../estilos/buttons.css" />
<link  rel="stylesheet" type="text/css" href="../../estilos/select2.css"/>
<link  rel="stylesheet" type="text/css" href="../../estilos/multiselect.css"/>
<link rel="stylesheet" type="text/css"  href="../../estilos/jquery-ui.css" />
<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!--<script src="../js/modernizr-2.0.6.js" ></script>-->
<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">-->
<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
<!--<script src="../js/jquery-1.9.1.js"></script>-->
<script src="../../js/jquery-1.11.2.min.js"></script>
<!--<script src="../js/jquery.ui.core.js"></script>-->
<!--<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>-->
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
<script type="text/javascript">
if(history.forward(1)){location.replace( history.forward(1) );}
</script>
<!-- InstanceBeginEditable name="head" -->
<style type="text/css">
<!--
.titulo_principal1 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 24px;
	font-weight: bold;
}
-->
</style>
<!-- InstanceEndEditable -->
</head>
<body>
  	<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data"> 
	<div id="apDiv1">

            
            <table border="0" class="tabla_principal" cellpadding="0" cellspacing="0">
<!--            <tr>
            <td bgcolor="#FF0000" style="font-weight:bold; color:#FFF;">
            <marquee>APLICACION EN PRUEBAS &nbsp; - &nbsp; APLICACION EN PRUEBAS &nbsp; - &nbsp;  APLICACION EN PRUEBAS  &nbsp; - &nbsp;  APLICACION EN PRUEBAS </marquee>
            </td>
            </tr>-->
              
              <tr >
                <td colspan="2" class="td_header" >
                <table width="100%" border="0" >
                      <tr>
                        <td width="15%" align="right">
                        <a href="javascript:void(0);" class="push" onClick="navegar(36);">
                            <img src="../../imagenes/sistema/logo.png" style="margin-left:10px;"  width="170" height="75" alt="logo">
                            </a>
                            </td>
                        <td width="60%" align="right">
                            
                 
            
           </td>
           <td width="15%" nowrap>
                <div class="info_header">
                    <!--<p>Bienvenido</p>-->
                    <p style="font-weight:800;"><?=$row_usuario['txt_nombre']?></p>
                    
                    <p>
                    	<a href="javascript:navegar_limpiando_variables(1013)" 
                        class="contenido" style="text-decoration:none; font-size:1vw !important;">Cambiar Password</a>
                    </p>
                    <p><?=$txt_nom_sistema?></p>
    
                
                    <button type="button" class="button-small pure-button" style="font-size:13px !important;" 
                    	onClick="window.location='../proceso/logout.php';return false;">Cerrar sesi&oacute;n</button>   
                        
                        </div>
                   
                   </td>
                </tr>
            </table>
    
                
                
                </td>
              </tr>
              
              <tr>
                <td colspan="2" class="td_contenido" >
                
                    <!-- InstanceBeginEditable name="contenido" -->
          <p>&nbsp;</p>
          <table width="100%" border="0" align="center" cellpadding="0">
        <tr>
          <td align="center" class="titulo_principal">RELACION DE PROCESOS ADICIONALES - PERFIL</td>
        </tr>
      </table>
          <br />
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="25%">&nbsp;</td>
          <td width="33%"><table width="100%" border="0">
            <tr class="combo_solicitud">
              <td width="22%">Perfil (Nombre)</td>
              <td width="2%">:</td>
              <td width="76%"><?php echo $txt_perfil; ?></td>
            </tr>
            <tr class="combo_solicitud">
              <td>Usuarios </td>
              <td>:</td>
              <td><?php echo $cadena_usuarios ?></td>
            </tr>
          </table>
            <br />
            <table  id='tabla_detalle_16' width='100%' border='0' cellspacing='0' cellpadding='0'>
              <tr class='titulo_tabla_detalle'>
                <td nowrap='nowrap' >PROCESO PANTALLA</td>
                
                <td></td>
              </tr>
              <?php 
		  
		  $num_permisos = $db->num_registros($cursor_procesos_perfil);
		  
		  $contador = 0;
		  while($row = $db->sacar_registro($cursor_procesos_perfil)){ 

			$cod_proceso_adicional			= $row['cod_proceso'];
		

			// ==== combo de modulos en el detalle
			$cursor_procesos_ciclo		= $proceso_adicional_pantalla->f_get_proceso_activo();
			$cmb_procesos_ciclo			= $obj_listbox->f_crear_lista($cursor_procesos_ciclo, $cod_proceso_adicional);

		?>
              <tr valign='top'   id='tabla_16_row_<?php echo $contador; ?>'>
                <td nowrap='nowrap'><select class="combo" name='cod_procesos_adicionales[]' >
                  <option value='-1' selected='selected'></option>
                  <?php echo $cmb_procesos_ciclo; ?>
                </select></td>
               
                
                <td nowrap='nowrap' align='right'><input class='contenido' name='mas'  type='button' onclick="addRow(this,'tabla_detalle_16')" value='+' />
                  <input class='contenido' name='menos' type='button' onclick="eliminar_fila(this,'tabla_detalle_16')" value='-' /></td>
              </tr>
              <?php 
		  	
		  
		  
		  }   
		  
		  ?>
              <?php $new_contador = $contador + 1; ?>
              <tr valign='top'   id='tabla_16_row_<?php echo $new_contador; ?>'>
                <td nowrap='nowrap'><select class="combo" name='cod_procesos_adicionales[]' >
                  <option value='-1' selected='selected'></option>
                  <?php echo $cmb_procesos; ?>
                </select></td>
               
                <td nowrap='nowrap' align='right'><input class='contenido' name='mas'  type='button' onclick="addRow(this,'tabla_detalle_16')" value='+' />
                  <input class='contenido' name='menos' type='button' onclick="eliminar_fila(this,'tabla_detalle_16')" value='-' /></td>
              </tr>
            </table>
            <table width="100%" border="0" align="center">
              <?
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
                <td nowrap="nowrap" class="combo_solicitud"><?=$txt_alias?></td>
                <td class="combo_solicitud"><?=$dos_puntos?></td>
                <td nowrap="nowrap"><?=$input?></td>
              </tr>
              <? } ?>
              <tr>
                <td colspan="3" nowrap="nowrap"><table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td align="left"><input type="button" name="esc" class="contenido" value="&lt;&lt; Atras" onclick="f_esc()"/></td>
                    <td align="center">&nbsp;</td>
                    <td align="right"><input name="enter" class="contenido" type="button" id="enter" onclick="f_enter()" value="Guardar&gt;&gt;" /></td>
                  </tr>
                </table></td>
              </tr>
            </table>
            <p>&nbsp;</p></td>
          <td width="25%" align="right" valign="bottom"><a href="javascript:f_eliminar_registro()">
            <? if($ind_mostrar_boton_eliminar){?>
            </a>
            <table width="10%" border="1" cellpadding="2" cellspacing="2" bordercolor="#999999">
              <tr>
                <td align="center" nowrap="nowrap" bgcolor="#E2F1FE"><a href="javascript:f_eliminar_registro()">Eliminar Registro</a></td>
              </tr>
            </table>
            <a href="javascript:f_eliminar_registro()"><? } ?>
            </a></td>
        </tr>
      </table>
      <input name="cod_pk" 								type="hidden" 		value="<?=$cod_pk?>" />
      <input name="cod_perfil_pk" 								type="hidden" 		value="<?=$cod_perfil_pk?>" />
      <input name="ind_new_row" 						type="hidden" 		value="<?=$ind_new_row?>" />
      <input name="ind_guardar_datos_tabla_autonoma" 	type="hidden"/>
      <input name="nom_columna_con_foto" 			type="hidden"/>
      <input name="txt_nombre_columna_iframe"		type="hidden">	  
      <input name="txt_ruta_mp3"					type="hidden">	  	  
      <input name="cod_ventana_emergente"			type="hidden">	 
      <input name="array_request_reporte"					type="hidden" 		value="<?=$array_request_reporte?>">   	  
      <iframe  name="frame_oculto" width="1" marginwidth="0"  height="1"   frameborder="0" id="frame_oculto" ></iframe>
	  
      <p>
        <script>
function f_eliminar_registro(){
	confirmacion = confirm ("El registro sera eliminado completamente del sistema \n\n ?Desea Continuar?");
	if(confirmacion==true)	navegar(40)
}
      </script>
        <script>
f = document.form1;
function f_enter(){
	f.enter.disabled = true;
	f.ind_guardar_datos_tabla_autonoma.value = 1;
	navegar(1051);
}
function f_esc(){
	f.esc.disabled = true;
	navegar(39);
}
      </script>
        
        </p>
          <p>&nbsp;</p>
          <!-- InstanceEndEditable -->
                
                </td>
              </tr>
              <tr>
                <td align="center" class="td_footer" ></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="td_footer" >| Prueba Backend | Desarrollado por: Luis Prieto | &copy; 2017</tr>
            </table>
            
            
            
              <!-- modal content -->
      <div id='click_confirm'></div>
                <div id='confirm'>
                    <div class='header'><span>Mensaje de confirmacion</span></div>
                    <div class='message'></div>
                    <div class='buttons'>
                        <div class='no simplemodal-close'>No</div><div class='yes'>Si</div>
                    </div>
                </div>
       
          <input type="hidden" 						name="cod_usuario" value="<?=$cod_usuario?>" />
          <input name="cod_navegacion" 				type="hidden" id="cod_navegacion" />
          <input type="hidden" 						name="ind_limpiar_variables" />
          <input name="cod_tabla" 					type="hidden"	value="<?=$cod_tabla?>" />
          <input name="cod_tabla_detalle"			value="<?=$cod_tabla_detalle?>" type="hidden" />
          <input name="ind_cierre_sesion"			type="hidden" />

       
    </div>
 </form>
<script>


</script>
</body>
<!-- InstanceEnd --></html>