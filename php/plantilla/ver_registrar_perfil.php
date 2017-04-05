<!DOCTYPE HTML>
<html><!-- InstanceBegin template="/Templates/contenido_general.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">-->
<!-- InstanceBeginEditable name="doctitle" -->
<title>Cardona -  Registro de <?=$alias_tabla_autonoma?> Nro. <?=$cod_pk?></title>




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
<script src="../../js/ver_registrar_perfil.js"></script>

<script>
$(function(){
	$(".multiple_select").multiselect({
		selectedList: 4 // 0-based index
	});
	
	$('body').delegate('.modulo','change', function() {
	//$('.modulo').on('change', function() {
  		var value_this = this.value ;
  		var $this = $(this);
  		var parent = $this.parent().parent();
  	 	id = parent.attr('id');
		$("#"+id+" td.operaciones > select").attr("name", "cod_operacion_tabla["+value_this+"][]");
		//alert( this.value ); // or $(this).val()
	});
});

</script>
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
                            <img src="../../imagenes/sistema/logo.png" style="margin-left:10px;"  width="170" alt="logo">
                            </a>
                            </td>
                        <td width="60%" align="right">
                            
                      <? if($cod_navegacion != 36 && $ind_pantalla_menu == FALSE){ ?>
                            <table width="90%" border="0">
                              <tr>
                                <td align="center" width="14%" valign="middle">
                                    <a class="float" href="javascript:void(0);" onClick="f_ver_consultar_maetro_detalle(9,10);">
                                        <img src="../../imagenes/sistema/3a.png">
                                    </a>
                                </td>
                                
                                <td align="center" width="14%" valign="middle">
                                    <a class="float" href="javascript:void(0);" onClick="f_ver_consultar_tabla(4);">
                                        <img src="../../imagenes/sistema/4.png">
                                    </a>
                                </td>
                                
                                <td align="center" width="14%" valign="middle">
                                    <a class="float" href="javascript:void(0);" onClick="f_ver_consultar_maetro_detalle(7,8);">
                                        <img src="../../imagenes/sistema/9.png" >
                                    </a>
                                </td>
                                    
                                <td align="center" width="14%" valign="middle">
                                    <a class="float" href="javascript:void(0);" onClick="f_ver_consultar_tabla(13);">
                                        <img src="../../imagenes/sistema/5.png">
                                    </a>
                                </td>
                                
                                <td align="center" width="14%" valign="middle">
                                    <a class="float" href="javascript:void(0);" onClick="f_ver_consultar_tabla(5);">
                                        <img src="../../imagenes/sistema/7.png">
                                    </a>
                                </td>
                                
                                <td align="center" width="14%" valign="middle">
                                    <a class="float" href="javascript:void(0);" onClick="f_ver_consultar_maetro_detalle(1,3);">
                                        <img src="../../imagenes/sistema/6.png" border="0" alt="" >
                                    </a>
                                </td>
                                
                               <!-- <td align="center" width="16%" valign="middle">
                                    <a class="float" href="javascript:void(0);" onClick="f_ver_consultar_maetro_detalle(1,2);">
                                        <img src="../imagenes/sistema/2.png">
                                    </a>
                                </td>-->
                                 <td align="center" width="16%" valign="middle">
                                    <a class="float" href="javascript:void(0);" onClick="navegar(200);">
                                        <img src="../../imagenes/sistema/3b.png">
                                    </a>
                                </td>
                              </tr>
                         </table>
                    <? } ?>
            
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
          <td align="center" class="titulo_principal">REGISTRO DE
            <?=$alias_tabla_autonoma?>
            Nro.
            <?=$cod_pk?>          </td>
        </tr>
      </table>
          <br />
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="33%" rowspan="2">&nbsp;</td>
          <td width="33%" rowspan="2"><table width="10%"  border="0" align="center" cellpadding="0" cellspacing="0">
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
                <td nowrap="nowrap" class="combo_solicitud"><?=$txt_alias?>                </td>
                  <td class="combo_solicitud"><?=$dos_puntos?>                </td>
                  <td nowrap="nowrap"><?=$input?>                </td>
                </tr>
              <? } ?>
              <tr>
                <td colspan="3" nowrap="nowrap"><table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td align="left"><input type="button" name="esc" class="contenido" value="&lt;&lt; Atras" onclick="f_esc()"/></td>
                        <td align="center">&nbsp;</td>
                        <td align="right"><? if($ind_mostrar_boton_guardar && $cod_pk){?>
                          <input name="enter" class="contenido" type="button" id="enter" onclick="f_enter()" value="Guardar&gt;&gt;" />
                          <? } ?>                      </td>
                      </tr>
                  </table></td>
                </tr>
            </table>
            <br />
            


            
          <table  id='tabla_detalle_16' width='100%' border='0' cellspacing='5' cellpadding='5'>
            <tr class='titulo_tabla_detalle'>
              <td nowrap='nowrap' >MODULO</td>
              <td nowrap='nowrap' >PERMISO</td>
              <td></td>
            </tr>
           
         
           
          
          <?php 
		  
 $num_permisos = $db->num_registros($cursor_permisos);
		  
 $contador = 0;
 while($row = $db->sacar_registro($cursor_permisos)){ 
      
			$cod_modulo				= $row['cod_tabla'];
			$cod_operacion			= $row['cod_operacion'];
            
			$arr_permisos = $array_permisos_vector[$cod_modulo]; // extrae del array los permisos por tabla / modulo
      
		if($cod_modulo != $cod_modulo_anterior){
			$cod_modulo_anterior = $cod_modulo;

			// ==== combo de modulos en el detalle
			$cursor_modulo_ciclo			    = 	$tabla_autonoma->f_get_activo();
			$cmb_tablas_autonomas_ciclo		=	$obj_listbox->f_crear_lista($cursor_modulo_ciclo, $cod_modulo);


			$cursor_operacion_ciclo			=	$seg_operacion_tabla->f_get_all();
			$cmb_operacion_tabla_ciclo		=	$obj_listbox->f_crear_lista_vector_multiple($arr_permisos, $arr_permisos_full);

			

		?>
           	
           
            <tr valign='top'   id='tabla_16_row_<?php echo $contador; ?>'>
              <td valign="bottom" nowrap='nowrap'>                            
                <select class="combo modulo" name='cod_modulo[]'  id="cod_modulo_<?=$contador?>">
                  <option value='-1' selected='selected'></option>
                <?php echo $cmb_tablas_autonomas_ciclo; ?>                
                </select>
                
                </td>
              <td valign="middle" nowrap='nowrap'>
              
              <select name='cod_operacion_tabla[<?=$cod_modulo?>][]' id="cod_operacion_tabla_<?=$contador?>"  
              	multiple='multiple' class='multiple_select' style="width:300px" >
               <?php echo $cmb_operacion_tabla_ciclo; ?>
              </select>
              
              </td>
              <td align='right' valign="middle" nowrap='nowrap'>
              <input class='contenido' name='mas'  type='button' onclick="addRow(this,'tabla_detalle_16')" value='+' />
                <input class='contenido' name='menos' type='button' onclick="eliminar_fila(this,'tabla_detalle_16')" value='-' /></td>
            </tr>
            
          <?php 
		  	$cod_modulo 		= NULL;
		  	$cod_operacion 	= NULL; 
			
					$contador++;
		  
		}
		

		  
 }   
		  
		  ?>       
          
          
          <?php $new_contador = $contador; ?>
          
          <tr valign='top'   id='tabla_16_row_<?php echo $new_contador; ?>' >
              <td valign="middle" nowrap='nowrap'  >                            
                <select class="combo modulo" name='cod_modulo[]' id="cod_modulo_<?=$new_contador?>" 
                	onchange="javascript:f_validar_repetido(this)" data-name='cod_modulo' >
                  <option value='-1' selected='selected'></option>
                <?php echo $cmb_tablas_autonomas; ?>                
                </select>
            </td>
                
           <td valign="middle" nowrap='nowrap' class='operaciones'>
              <select class="multiple_select"  multiple="multiple" id="cod_operacion_tabla_<?=$new_contador?>"	
              	name='cod_operacion_tabla[][]' style="width:300px" data-name='cod_operacion_tabla' >
                 <?php echo $cmb_operacion_tabla; ?>
              </select>
          </td>
              <td align='right' valign="middle" nowrap='nowrap'>
              <input class='contenido' name='mas'  type='button' id="prueba" onclick="addRow(this,'tabla_detalle_16')" value='+' />
                <input class='contenido' name='menos' type='button' onclick="eliminar_fila(this,'tabla_detalle_16')" value='-' /></td>
            </tr>
          
          
          
          
          
          </table>
          
          <table width="100%">
          
          <tr>
                    <td align="left"><input type="button" name="esc" class="contenido" value="&lt;&lt; Atras" onclick="f_esc()"/></td>
                        <td align="center">&nbsp;</td>
                        <td align="right"><? if($ind_mostrar_boton_guardar && $cod_pk){?>
                          <input name="enter" class="contenido" type="button" id="enter" onclick="f_enter()" value="Guardar&gt;&gt;" />
                          <? } ?>                      </td>
                      </tr>
          
          </table>
          <p>&nbsp;</p></td>
          <td width="33%" align="right" valign="top"><a href="javascript:f_eliminar_registro()">
            </a>
            <table width="50%" border="0" align="center">
              <tr class="contenido_azul" >
                <td align="right" valign="middle"><a href="javascript:f_condicion_especial()" >
                	 <img src="../../imagenes/sistema/sound.png" width="10"  /> &nbsp; Condiciones Especiales </a></td>
              </tr>
            </table>
            <a href="javascript:f_eliminar_registro()">            </a></td>
        </tr>
        <tr>
          <td align="right" valign="bottom"><table width="100%" border="0">
            <tr>
              <td align="right"><a href="javascript:f_eliminar_registro()">
                <? if($ind_mostrar_boton_eliminar){?>
                </a>
                <table width="10%" border="1" cellpadding="2" cellspacing="2" bordercolor="#999999">
                  <tr>
                    <td align="center" nowrap="nowrap" bgcolor="#E2F1FE"><a href="javascript:f_eliminar_registro()">Eliminar Registro</a></td>
                  </tr>
                </table>
                <a href="javascript:f_eliminar_registro()">
                  <? } ?>
                </a></td>
            </tr>
          </table></td>
        </tr>
            </table>
      <input name="cod_pk" 								type="hidden" 		value="<?=$cod_pk?>" />
      <input name="ind_new_row" 						type="hidden" 		value="<?=$ind_new_row?>" />
      <input name="ind_guardar_datos_tabla_autonoma" 	type="hidden"/>
      <input name="nom_columna_con_foto" 			type="hidden"/>
      <input name="txt_nombre_columna_iframe"		type="hidden">	  
      <input name="txt_ruta_mp3"					type="hidden">	  	  
      <input name="cod_ventana_emergente"			type="hidden">	 
      <input name="ind_guardar_dato"			type="hidden">	 
      <input name="ind_buscar"			type="hidden">	 
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
                <td align="center" class="td_footer" ><table width="60%" border="0">
                  <tr>
                    <td><img src="../../imagenes/sistema/logos/soluciones.png" alt="" width="99" height="30"></td>
                    <td><img src="../../imagenes/sistema/logos/empresas.png" alt="" width="100" height="30"></td>
                    <td><img src="../../imagenes/sistema/logos/protecto.png" alt="" width="90" height="30"></td>
                    <td><img src="../../imagenes/sistema/logos/juridicas.png" alt="" width="88" height="28"></td>
                    <td><img src="../../imagenes/sistema/logos/perdure.png" alt="" width="94" height="30"></td>
                    <td><img src="../../imagenes/sistema/logos/fiduprot.png" alt="" width="44" height="41"></td>
                  </tr>
                </table></td>
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