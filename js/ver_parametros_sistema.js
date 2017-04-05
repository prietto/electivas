function f_enter(){
	f = document.form1;
	f.enter.disabled = true;
	f.ind_guardar_datos_tabla_autonoma.value = 1;

	navegar(1063);
}



/*===== 2014/08/27 ==========================================================>>>>
DESCRIPCION: 	Metodo para generar un backup ejecutando un archivo .bat
AUTOR:			Luis Prieto
---------------------------------------------------------------------------					
PARAMETRO		DESCRIPCION 
===========================================================================*/	
function f_genera_backup($this){
	$("html, body").animate({ scrollTop: $('#frame_oculto').height() }, 1000);
	
	var myIframe = document.getElementById('frame_oculto');
	myIframe.onload = function(){
	    myIframe.contentWindow.scrollTo(0,100000);
		$.ventana_proceso({
			data:'Backup Terminado, por favor dirijase a la ruta: "D:/BACKUP/CARDONA/" y guarde la carpeta generada'
		});
		return false;
	};
	
	// carga la funcion una vez es cargada una conversacion
	//setInterval("mover_scroll_iframe()",800);
	$('#frame_oculto').show('slow');
	$('#frame_oculto').attr('src','../proceso/genera_backup.php');
	
	return false;
	f = document.form1;
	f.target = "frame_oculto";
	navegar(1073)	
	//navegar_ajax_variables(1073,$this);
	f.target = "_self";

}