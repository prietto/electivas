<style>
#form_salida_insumo{
	 /*border-collapse: collapse;*/
   padding: 20px;
   border-radius: 5px;
}
#form_salida_insumo input[type='text']{
  width: 100%;

}

.nota_salida{
  font-size: 16px;
}

.nota_salida span{
  font-weight: bold;
}



</style>

<h2>Es necesario la confirmacion de su Password para continuar</h2>



<table width="1%" align="center" id="form_confirm_login" 
    border="0" style="border:1px solid grey;" class="tabla_reporte" cellpadding="3" cellspacing="3" >
  <tr>
    <td align="left"  nowrap="nowrap">Login</td>
    <td align="center" nowrap="nowrap">:</td>
    <td align="left" nowrap="nowrap">
      <input name="txt_login_confirm" id="txt_login_confirm" type="text" value="<?=$row_usuario['txt_login']?>" required="required" autocomplete="off"   >
    </td>
  </tr>

  <tr>
    <td align="left" nowrap="nowrap">Password</td>
    <td align="center" nowrap="nowrap">:</td>
    <td align="left" nowrap="nowrap">
      <input name="txt_password_confirm" id="txt_password_confirm" type="password" value="" required  autocomplete="off"   >
    </td>
  </tr>

  <input type="hidden" name="cod_usuario_confirm" id="cod_usuario_confirm" value="<?=$row_usuario['cod_usuario_pk']?>">
  <input type="hidden" name="cod_navegacion_destino" id="cod_navegacion_destino" value="<?=$cod_navegacion_destino?>">

  
  
</table>

<div style="display: block; text-align: center; margin: 10px 0px;">	

	<input type="button"  
        		class="pure-button"  
                value="Enviar" 
                name="enter_confirm" 
                id="enter_confirm" 
                style="background-color:#0C3"
                
            />


</div>




<script>
	$(function(){
		


	}) // fin $(function(){})

$(function(){ 
  $('#txt_password_confirm').focus();
})

</script>