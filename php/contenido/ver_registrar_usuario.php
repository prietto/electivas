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

<h2>Formulario de registro para nuevos estudiantes</h2>



<table width="1%" align="center" id="form_nuevo_usuario" border="0" style="border:1px solid grey;" class="tabla_reporte" cellpadding="3" cellspacing="3" >
  <tr>
    <td align="left"  nowrap="nowrap">Nombre (Completo)</td>
    <td align="center" nowrap="nowrap">:</td>
    <td align="left" nowrap="nowrap">
      <input name="txt_nom_usuario" id="txt_nom_usuario" type="text" value="" required="required" autocomplete="off"   >
    </td>
  </tr>

  <tr>
    <td align="left"  nowrap="nowrap">No. Identificacion</td>
    <td align="center" nowrap="nowrap">:</td>
    <td align="left" nowrap="nowrap">
      <input name="num_identificacion_user" id="num_identificacion_user" type="text" value="" required="required" autocomplete="off"   >
    </td>
  </tr>

  <tr>
    <td align="left" nowrap="nowrap">Password</td>
    <td align="center" nowrap="nowrap">:</td>
    <td align="left" nowrap="nowrap">
      <input name="txt_pass_user" id="txt_pass_user" type="password" value="" required  autocomplete="off"   >
    </td>
  </tr>

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
		$('#enter_confirm').on('click',function(e){		

			e.preventDefault();
      var error = 0;

      
      var form_confirm_login = $('#form_nuevo_usuario');
      var inputs_required = $(form_confirm_login).find(':input[required]',':textarea[required]');

      // valida los campos ingresados
      $(inputs_required).each(function(index,element){
        var val_element = $.trim($(element).val()); 

        //== si el valor es nulo>>
        if(!val_element){
          $(element).css({
            'border-color':'red'
          });
          
          error++;
        }else{
          $(element).css({
            'border-color':''
          });
        }
      
      })// fin each

      if(error == 0){
        navegar_ajax_return(1201,function(a){
          

          // respuesta CALLBACK ==>
          
          var obj_json = $.parseJSON(a);

          var code_error = obj_json.code_error;
          var msj = obj_json.msj_error;

          // la variable a es el numero de registro encontrados 
          if(code_error>=1){
            modal_deck.open({
              data:msj
            });
          }else if(code_error == 0){
            var msj = 'Registrado correctamente, por favor ingrese';
            modal_deck.open({
              data:msj
            });
          }

        });  
        
      } // if error
			

		}) // fin funcion onclick


	}) // fin $(function(){})

$(function(){ 
  $('#txt_password_confirm').focus();
})

</script>