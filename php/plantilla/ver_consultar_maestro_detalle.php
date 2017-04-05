<!DOCTYPE HTML>
<html><!-- InstanceBegin template="/Templates/contenido_general.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">-->
<!-- InstanceBeginEditable name="doctitle" -->
<title>Consulta de <?=$alias_tabla_autonoma?></title>
<!--<script type="text/javascript" src="../../js/jquery.js"></script> -->
<!-- <script type="text/javascript" src="../../js/jquery-ui.min.js"></script>-->
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

<script src="<?=$js_navegacion?>"></script>
<script src="<?=$js_extra?>"></script>

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
                    
                    
       <table  style="width:100%; position:relative; " border="0" align="center" id="tabla_filtros" >
                  <tr>
                    <td align="center">
                      <span class="titulo_principal">CONSULTA DE <?=$alias_tabla_autonoma?></span>
                    </td>
                      

        </tr>
        <tr>
          <td width="100%"  >
          <div style="position:relative;">
          <table width="60%" border="0" align="center" cellpadding="5" cellspacing="5">
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
                  <td align="left"><input type="button" class="pure-button" name="esc" value="&lt;&lt; Atrás" onclick="f_esc()"/></td>
                  <td align="center"><span class="combo_solicitud">
                    <? if($ind_tiene_permiso_insert){?>
                    </span>
                    <input name="enter2" class="pure-button" type="button" id="enter2" onclick="f_nuevo_registo()" value="Nuevo Registro" />
                    <span class="combo_solicitud">
                      <? } ?>
                      </span></td>
                  <td align="right" nowrap="nowrap">
                  <input class="pure-button" name="enter"  id="enter" onclick="f_enter()"  type="button" value="Consultar &gt;&gt;" /></td>
                  <? /*  <td align="right" nowrap="nowrap" class="contenido">
                  <input name="ind_consulta_2"  <? if($ind_consulta_2){?>checked="checked" <? } ?> type="checkbox" id="ind_consolidado" value="1" />
                    Rapido</td>  */ ?>
                  </tr>
                <tr>
                  <td colspan="3" align="right">
                    <input name="ind_imprimir_reporte"  style="visibility:hidden" type="checkbox" id="ind_imprimir_reporte" value="1" />
                    <a href="javascript:void(0);" onclick="f_imprimir_reporte();">Imprimir</a>
                    &nbsp;&nbsp;
                    <a href="javascript:void(0)" onclick="f_exportar_excel(<?=$cod_navegacion?>);">Exportar Excel</a>
                    
                    
                    </td>
                  <!-- <td align="right" nowrap="nowrap" class="contenido">&nbsp;</td>-->
                  </tr>
                </table>
                <p><pre><div id="respuesta_servidor"></div></pre></p>
                
                </td>
              </tr>
          </table>
          
         <div style="position:absolute;  right:0; top:0;" id="procesos_adicionales" >
              <table width="10%" border="0" align="left" cellpadding="5" cellspacing="10">
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
                    <img src="../../imagenes/sistema/right.gif" width="11" valign="middle" />
                    </td>
                  
                  <td nowrap="nowrap" valign="middle">
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
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td ><span class="combo_solicitud">  <?=$tabla_resultado?>      </span></td>
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
      <input name="cod_pk" 						type="hidden">
      <input name="ind_buscar" 					type="hidden">
      <input name="num_pagina"					type="hidden" />
      <input name="ord_por" 					type="hidden" 	value="<?=$ord_por?>"/>
      <input name="txt_nombre_columna_iframe"	type="hidden">	  
      <input name="cod_ventana_emergente"		type="hidden">
      <input name="cod_atenciones"				type="hidden">
      <input name="ind_limpiar_ord"				type="hidden">
   	  <input name="cod_autorizacion_pk"				type="hidden">
	  <input name="cod_paciente_pk"				type="hidden">
            <input name="num_procesos_adicionales"	type="hidden"	value="<?php echo $num_procesos_adicionales?>">

      <iframe  name="frame_oculto" marginwidth="0"  width="0" height="0"   frameborder="0" id="frame_oculto" ></iframe>
<script language="javascript">



// MANTIENE LA POSICION DEL SCROLL AL RECARGAR LA PAGINA
window.onload=function(){
	var pos=window.name || 0;
	window.scrollTo(0,pos);
}
window.onunload=function(){
	window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
}

</script>
      
      
<script>
document.getElementById('tabla_filtros').width = screen.width;
function f_seleccionar_todos(chkbox)
{
for (var i=0;i < document.forms[0].elements.length;i++)
{
var elemento = document.forms[0].elements[i];
if (elemento.type == "checkbox")
{
elemento.checked = chkbox.checked
}
}
}
      </script>		
        <script>
function f_imprimir_reporte(){
	f			= document.form1;
	f.ind_buscar.value 	=	1;
	f.ind_imprimir_reporte.checked=true;
	f.target 	= "_blank";
	navegar(41);
	f.submit();
	f.target 	= "_self";
	f.ind_imprimir_reporte.checked=false;	  
}	  
	  </script>

  <!-- InstanceEndEditable -->
                
                </td>
              </tr>
              <tr>
                <td align="center" class="td_footer" >
                </td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="td_footer" >Cardona &amp; Consultores Asociados s.a.s. |  Administrador de contenido CRM |
Desarrollado por: Deck Soluciones | &copy; 2015 Deck Soluciones - Todos los derechos reservados.
              </tr>
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