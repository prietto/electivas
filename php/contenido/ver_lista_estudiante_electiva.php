<style>
#box_orden_facturacion{
   border-collapse: collapse;
}

#box_carga_archivo{
  margin:10px auto;
  border: 1px solid rgba(0, 0, 0, 0.44);
}

.pure-button{
  color: white;
}

#msj_error{
  display: none; 
  text-align: center; 
  margin: 10px 0px;  
  color: red;
  font-size:14px;
}

.msj_error{
  
  text-align: center; 
  margin: 10px 0px;  
  color: red;
  font-size:13px;
}
.btn_factura{
  cursor: pointer;
}

.btn_anula_orden{
  float:right;
}
</style>

<table width="100%" id="box_orden_facturacion" border="1" style="border:0px solid grey;" class="tabla_reporte" cellpadding="5" cellspacing="5" >
	
	<tr class="titulo_tabla" >   
        <td colspan="5" ><?=$row_electiva['txt_nombre']?></td>
  	</tr>	

    <tr class="titulo_tabla" >   
    	<td colspan="5" >Listado estudiantes</td>
    </tr>

    <? 
    if($num_estudiantes==0){
    ?>	

    <tr class="" >   
    	<td colspan="5" ><p>No existen estudiantes registrados para la electiva</p></td>
    </tr>
    
    <? 
    }else{ // fin if
    ?>


	    <tr class="" >   
	    	<td align="center" nowrap="nowrap">Estudiante</td>            
	    	<td align="center" nowrap="nowrap">Fecha Registro</td> 
	    </tr>

	    <? 
	    while($row=$db->sacar_registro($cursor_estudiantes)){

	    	$txt_estudiante 	= $row['txt_estudiante'];
	    	$fec_registro		= $sis_genericos->f_fecha_con_hora_no_semana($row['fec_registro']);
	    	$txt_usuario_login 	= $row['txt_usuario_login'];
	    ?>
		<tr class="" >   
	    	<td align="center" nowrap="nowrap"><?=$txt_estudiante?></td>            
	    	<td align="center" nowrap="nowrap"><?=$fec_registro?></td> 
	    </tr>

	    <?
	    }// fin while 
    }// fin else
    ?>



</table>

