// ===== function para registrar un usuario por medio de ajax y ventana modal ==== >>>
$(function(){



	$('#btn_registrar').on('click',function(e){
		e.preventDefault();

		navegar_ajax_return(1200,function(a){
			
			modal_deck.open({
				data:a,
				width:'auto',
				height:'auto',
				afterClose: function(result){
					// aqui codigo despues de cerrar la ventana
					result();
				}
			},function(){
				// ejecuta codigo despues de abierta la ventana				
			})

		});

	});


	// funcion submit jquery
	$('#form1').submit(function(e){
		e.preventDefault();
		navegar(36);
		return false;

	});



})