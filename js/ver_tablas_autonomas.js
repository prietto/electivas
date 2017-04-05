// ==== function para eliminar y/o desactivar alarma ===>>>
$(function(){
	$('.btn_delete_alarm').on('click',function(e){
		e.preventDefault();
		var $this = $(this);
		var tr_row = $(this).parent().parent();
		confirm('Eliminara la alarma, este proceso no tiene reversa ¿Desea Continuar?',function(a){
			if(a=='si'){
				var cod_pk_alarma = $($this).data('cod_pk');


				add_input_callback('cod_pk_alarma','hidden',cod_pk_alarma,function(){
					navegar_ajax_login_return(1089,function(data){
						modal_deck.open({
							data:data,
							height:'auto',
							width:'auto'
						},function(){
							$(tr_row).remove();
						});
					});

				});

			} // fin if

		}); // fin confirm
	}) // fin funcion btn_delete_alarm

}) // fin jjquery