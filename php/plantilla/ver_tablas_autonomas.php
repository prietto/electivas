<!DOCTYPE HTML>
<html><!-- InstanceBegin template="/Templates/contenido_general.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">-->
<!-- InstanceBeginEditable name="doctitle" -->
<title>CRM</title>
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
<script src="../../js/ver_tablas_autonomas.js"></script>
<link rel="stylesheet" type="text/css"  href="../../estilos/ver_tablas_autonomas.css" />
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
                            <img src="../../imagenes/sistema/logo.png" style="margin-left:10px;"  width="170"  alt="logo">
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

                  <div class="box_item_tabla">
                    


                    <div class="item_tabla">
                      <a class="float-shadow" href="javascript:void(0);" onClick="f_ver_consultar_maetro_detalle(4,6);"><img src="../../imagenes/sistema/iconos_grandes/1.png" alt="" border="0" ></a>
                    </div>


                    <div class="item_tabla">
                      <a class="float-shadow" href="javascript:void(0);" onClick="f_ver_consultar_tabla(5);"><img src="../../imagenes/sistema/iconos_grandes/2.png" alt="" border="0" ></a>
                    </div>

                    <div class="item_tabla">
                      <a class="float-shadow" href="javascript:void(0);" onClick="f_ver_consultar_maetro_detalle(1,3);"><img src="../../imagenes/sistema/iconos_grandes/3.png" alt="" border="0" ></a>  
                    </div>

                    
                  </div>
            	
            	<!-- InstanceEndEditable -->
                </td>
              </tr>
              <tr>
                <td align="center" class="td_footer" ></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="td_footer" > | Prueba Backend |
Desarrollado por: Luis Prieto | &copy; 2017 
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