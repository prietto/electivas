<!DOCTYPE HTML>
<html><!-- InstanceBegin template="/Templates/contenido_general.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">-->
<!-- InstanceBeginEditable name="doctitle" -->
<title>Consulta de <?=$alias_tabla_autonoma?></title>
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
<script src="../../js/formato_fecha.js"></script>
<script src="../../js/opera_numeros.js"></script>
<script src="<?=$js_navegacion?>"></script>
<script src="<?=$js_extra?>"></script>
<script src="../../js/jquery_multiselect.js" ></script>
<style>
div .display_div{
    height              : 90px;
    transition-property : height , width;  /* collapse sequence */
    transition-duration : 0.5s   , 0.5s;
    transition-delay    : 0.0s   , 0.5s;   /* delay 2nd transition */
}
</style>
<script>
$(function(){$(".multiple_select").multiselect({});});
$(document).ready(function(){$(".link_display").click(function(){$(".display_div").fadeToggle("fast");});});
</script>

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
                    <div id="msj_respuesta_servidor"></div>
      <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td valign="top">
          
             <table width="100%" align="center" cellpadding="5">
               <tr>
                 <td align="center" >
                 	<span class="titulo_principal">CONSULTA DE  <?=$alias_tabla_autonoma?>   </span>
                    <br>
                </td>
                 
               </tr>
               <tr>
               
             <td align="right" width="100%">
                 <div style="position:relative;">
                 
                   <table width="60%" border="0" align="center" >
					
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
                            
                            $txt_alias			= str_replace("_"," ",$txt_alias);
                            
							$txt_alias2			= 	mb_strtolower($txt_alias2, 'UTF-8');
							$txt_alias2			= ucwords($txt_alias2);
							
                        
                            if(!$txt_alias)		$dos_puntos = "";
                            else				$dos_puntos = ":";
                            if(!$txt_alias2)	$dos_puntos2 = "";
                            else				$dos_puntos2 = ":";
                    ?>
                    
                     <tr>
                       <td nowrap="nowrap" class="combo_solicitud"><?=$txt_alias?></td>
                       <td width="1%" nowrap="nowrap" class="combo_solicitud"><?=$dos_puntos?></td>
                       <td nowrap="nowrap" class="contenido"><?=$input?></td>
                       <td nowrap="nowrap" class="combo_solicitud">&nbsp;</td>
                       <td nowrap="nowrap" class="combo_solicitud"><?=$txt_alias2?></td>
                       <td width="1%" nowrap="nowrap" class="combo_solicitud"><?=$dos_puntos2?></td>
                       <td nowrap="nowrap" class="contenido"><?=$input2?></td>
                       </tr>
                     <? } ?>
                     <tr>
                       <td colspan="7" nowrap="nowrap"><table width="100%" border="0" cellspacing="2" cellpadding="2">
                         <tr>
                           <td width="22%" align="left">
                             <?php if($_REQUEST['ind_pagina_autorizacion'] == 1){ 
                               echo '<input type="button" class="contenido" name="esc" value="&lt;&lt; Atras" onclick="f_esc_autorizacion()"/>'; ?>
                             <?php }else{ ?>
                             
                             <input type="button" class="pure-button" name="esc" value="&lt;&lt; Atrás" onclick="f_esc()"/>
                             <?php } ?>
                             
                             </td>
                           <td width="46%" align="center"><span class="combo_solicitud">
                             <? if($ind_tiene_permiso_insert && $cod_tabla != 13){?>
                             </span>
                             <input name="enter2" class="pure-button" type="button" id="enter2" onclick="f_nuevo_registo()" value="Nuevo Registro" />
                             <span class="combo_solicitud">
                               <? } ?>
                               </span></td>
                           <td align="center" nowrap="nowrap">
                           <input class="pure-button" name="enter"  id="enter" onclick="f_enter()"  type="button" value="Consultar &gt;&gt;" /></td>
                           </tr>
                         
                         <tr>
                           <td align="left">&nbsp;</td>
                           <td align="center">&nbsp;</td>
                           <td align="center" nowrap="nowrap" class="contenido">
                           
                           <input name="ind_imprimir_reporte"  style="visibility:hidden" type="checkbox" id="ind_imprimir_reporte" value="1" />
                    <a href="javascript:void(0);" onclick="f_imprimir_reporte();">Imprimir</a>
                    &nbsp;&nbsp;
                    <a href="javascript:void(0)" onclick="f_exportar_excel(<?=$cod_navegacion?>);">Exportar Excel</a>
                           
                           </td>
                           </tr>
                         </table></td>
                       </tr>
                   </table>
                   
                  <div style="position:absolute;   right:0; top:0;" >
                   <table width="20%" border="0" align="center" cellpadding="0" cellspacing="10">
										   <? 
                        $num_registros 	= 	$db->num_registros($cursor_procesos_adicionales);
                        for($i=0; $i<$num_registros; $i++){
                            $row 					=$db->sacar_registro($cursor_procesos_adicionales,$i);
                            $txt_desc				=$row['txt_descripcion'];
                            if($txt_desc)$attrib = "title='$txt_desc'";
                            $txt_nombre				=$row['txt_nombre'];
                            $txt_js					=$row['txt_js'];
                        ?>
                   <tr>
                     
                     <td nowrap="nowrap" valign="middle">
                       <img src="../../imagenes/sistema/right.gif" width="11" />
                       </td>
                     <td nowrap="nowrap" valign="middle" >
                     	<div style="font-size:.8em; margin:4px;">
    	                    <a href="javascript:<?=$txt_js?>"  <?=$attrib?>>
        	               		<?=$txt_nombre?>
	                       </a>
                          </div>
                     </td>
                     </tr>
                   <? } ?>
                 </table>
                </div>
                   
               </div>    
                   </td>
                 </tr>
             </table>
             <br />
          
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
              <tr bgcolor="#FFFFFF">
                <td><span class="combo_solicitud">
                  <?=$tabla_resultado?>
                  </span></td>
                </tr>
              <tr>
                <td align="center" >
                
                <table width="10%"  border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" nowrap="nowrap"> &nbsp; <?=$tabla_paginas?></td>
                    </tr>
                  </table>
                  
                  
                  </td>
                </tr>
              </table>
            <iframe  name="frame_oculto" marginwidth="0"  width="0" height="0"   frameborder="0" id="frame_oculto" ></iframe></td>
          </tr>
          
          <tr>
          <td>
         
          <table width="40%" border="0" cellspacing="0" cellpadding="0" style="display:none">
            <tr>
              <td><div id="div_procesos_registro"> 
                <table width="14%" border="0" cellspacing="5" cellpadding="0">
                  <tr>
                  
                    <?php 
$num_imagen_adicional		=	0;
$num_procesos_adicionales 	= 	$db->num_registros($cursor_procesos_por_registro);
for($i=0; $i<$num_procesos_adicionales; $i++){
	$row 					=$db->sacar_registro($cursor_procesos_por_registro,$i);
	$txt_nombre				=$row['txt_nombre'];
	$txt_js					=$row['txt_js'];
	$num_imagen_adicional++;
	if($num_imagen_adicional>6)$num_imagen_adicional=1; //imagen_estandar de los botones
?>
                    <td nowrap="nowrap">
                    
                    <table width="100%" border="0" cellspacing="2" cellpadding="0">
                      <tr>
                        <td align="center">
                        <a href="javascript:<?php echo $txt_js?>">
                        <img src="../../imagenes/sistema/p_<?php echo $num_imagen_adicional?>.png" alt="" border="0" /></a>
                        </td>
                        <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="center" nowrap="nowrap">
                        	<a href="javascript:<?php echo $txt_js?>"> <?php echo $txt_nombre?> </a></td>
                        <td align="center" nowrap="nowrap">&nbsp;</td>
                      </tr>
                    </table></td>
                    <?php } ?>
                  </tr>
                </table>
              </div></td>
            </tr>
          </table></td>
          </tr>
          
    </table>
      <input name="cod_pk" 						type="hidden">
      <input name="ind_buscar" 					type="hidden">
      <input name="num_pagina"					type="hidden">
      <input name="ord_por" 					type="hidden" 	value="<?=$ord_por?>"/>
      <input name="txt_nombre_columna_iframe"	type="hidden">	  
      <input name="cod_ventana_emergente"		type="hidden">
      <input name="ind_limite"					type="hidden">
      <input name="num_procesos_adicionales"	type="hidden"	value="<?php echo $num_procesos_adicionales?>">
      
      		
      
	<iframe  name="frame_oculto" marginwidth="0"  width="0" height="0"   frameborder="0" id="frame_oculto" ></iframe>
      <script>
function f_seleccionar_todos(chkbox){

	for (var i=0;i < document.forms[0].elements.length;i++){
		var elemento = document.forms[0].elements[i];
		if (elemento.type == "checkbox"){
			elemento.checked = chkbox.checked
		}
	}
}
      </script>
          <!-- InstanceEndEditable -->
                
                </td>
              </tr>
              <tr>
                <td align="center" class="td_footer" ></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="td_footer" > | Prueba Backend | Desarrollado por: Luis Prieto | &copy; 2017</tr>
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