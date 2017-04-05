/*===== 2017/04/04========================================================>>>>
DESCRIPCION: 	Metodo para eliminar una electiva
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_elimina_electiva($this){
	var obj_checked = $("input[name='reg_seleccionado[]']:checked");
	var val_registro = $("input[name='reg_seleccionado[]']:checked").val();
	var id_registro = "tr_reg_"+val_registro;
	var val_nom = $("#tr_reg_"+val_registro+" td:nth-child(3) > a").html();


	// cuenta cuantos checkbox han sido seleccionados	
	var num_check = $("input[name='reg_seleccionado[]']:checked").length;
	
	if(num_check < 1){
		var msj = 'Debe seleccionar una Electiva';
		modal_deck.open({
			data:msj,
			width:'auto',
			height:'auto'
		});
		return false;

	}else if(num_check > 1){
		var msj = 'Seleccione solamente un registro';
		modal_deck.open({
			data:msj,
			width:'auto',
			height:'auto'
		});
		return false;
	}


	navegar_ajax_return(1205,function(data){
		if(data>0)var msj = '!Alerta¡ Existen estudiantes inscritos, ¿Desea Continuar?';  // existen estudiantes inscritos
		else if(data==0)var msj = '¿Desea Continuar?';  
		confirm(msj,function(a){
				if(a=='si'){
					navegar_ajax_return(1206,function(data){
						if(data == true){ // proceso ok!
							modal_deck.open({
								data:'La Electiva fue eliminada correctamente',
								width:'auto'	,
								height:'auto'
							},function(){
								$(obj_checked).removeAttr('checked',false); // deselecciona el registro
							});

							setTimeout(function(){								
								f_enter();
							},2000);

						}else{
							alert('Ha ocurrido un error en la consulta');
						}
					});

				}

			}); // fin confirm

	});

}

/*===== 2017/04/04========================================================>>>>
DESCRIPCION: 	Metodo para incribir un estudiante/usuario a una electiva
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_inscribirme($this){

	var obj_checked = $("input[name='reg_seleccionado[]']:checked");
	var val_registro = $("input[name='reg_seleccionado[]']:checked").val();
	var id_registro = "tr_reg_"+val_registro;
	var val_nom = $("#tr_reg_"+val_registro+" td:nth-child(3) > a").html();


	// cuenta cuantos checkbox han sido seleccionados	
	var num_check = $("input[name='reg_seleccionado[]']:checked").length;
	
	if(num_check < 1){
		var msj = 'Debe seleccionar una Electiva';
		modal_deck.open({
			data:msj,
			width:'auto',
			height:'auto'
		});
		return false;

	}else if(num_check > 1){
		var msj = 'Seleccione solamente un registro';
		modal_deck.open({
			data:msj,
			width:'auto',
			height:'auto'
		});
		return false;
	}


	navegar_ajax_return(1202,function(a){
		console.log(a);

		if(a==true){ // puede proseguir con la inscripcion

			confirm('Esta seguro que desea inscribirse en << '+val_nom+' >> ?',function(res){
				if(res=='si'){ // si el usuario presiona si 
					navegar_ajax_return(1203,function(data){
						if(data == true){ // proceso ok
							var msj ="Se ha inscrito correctamente en la electiva << "+val_nom+" >>";
							modal_deck.open({
								data:msj,
								width:'auto',
								height:'auto'
							},function(){
								$(obj_checked).removeAttr('checked',false); // deselecciona el registro
							});

							setTimeout(function(){								
								f_enter();
							},2000)

						}else{
							console.log(data);
							alert('Ha ocurrido un problema en el proceso o el cupo esta lleno');

						}
					});

				}else return false

			});

		}else{ // ya se encuentra inscrito
			var msj = a;
			modal_deck.open({
				data:msj,
				width:'auto',
				height:'auto'
			});
			return false;


		}

	});

}


/*===== 2017/04/04========================================================>>>>
DESCRIPCION: 	Metodo para mostrar listado de estudiantes inscritos en una electiva
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/
function f_ver_estudiantes($this){
	var obj_checked = $("input[name='reg_seleccionado[]']:checked");
	var val_registro = $("input[name='reg_seleccionado[]']:checked").val();
	var id_registro = "tr_reg_"+val_registro;
	var val_nom = $("#tr_reg_"+val_registro+" td:nth-child(3) > a").html();


	// cuenta cuantos checkbox han sido seleccionados	
	var num_check = $("input[name='reg_seleccionado[]']:checked").length;
	
	if(num_check < 1){
		var msj = 'Debe seleccionar una Electiva';
		modal_deck.open({
			data:msj,
			width:'auto',
			height:'auto'
		});
		return false;

	}else if(num_check > 1){
		var msj = 'Seleccione solamente un registro';
		modal_deck.open({
			data:msj,
			width:'auto',
			height:'auto'
		});
		return false;
	}



	navegar_ajax_return(1204,function(data){ // retorna data despues de ir por el flujo de navegacion
		console.log(data);
		modal_deck.open({
			data:data,
			width:'auto',
			height:'auto'
		});

	});

}