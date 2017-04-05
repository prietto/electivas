<style>
#content_wrapper{
	position:absolute;
	background-color:#fff;
	z-index:50;
	border:1px solid #333;
	padding:0px;
	margin:3px;
	
	

}


.list_result ul { 
	list-style: none; 
	margin: 0px;
	padding: 0px;
}

.list_result li { 
	list-style: none; 
	margin: 0px;
	padding: 6px;
}




.list_result li:hover{
	cursor:pointer;
	opacity: .8;
	-moz-opacity: .8;
	background-color:#CCC;
	
}

</style>

<div id="content_wrapper" class="border_shadow">
	<div class="list_result">
    	<ul>
			<?php 
			
			if($num_registros < 1){
			 ?>
			<li class="texto_resultado" ><span>No se encontraron resultados...</span></li>
            
            <?php
			}
            while($row=$db->sacar_registro($cursor)){
                
                $cod_pk_result		= $row[0];
                $txt_resultado  	= $row[1];
				$txt_descripcion	= $row[2];
				
				if(!$txt_descripcion)$txt_descripcion = $txt_resultado;
                
            
            
            ?>
    		<li class="texto_resultado" 
            	onClick="f_pintar_seleccion(<?=$cod_pk_result?>,'<?=$txt_resultado?>')">
                <span><?=$txt_descripcion?></span></li>
        

		<? } 
		?>

        </ul>
    
    </div>

</div>


<script>
var id_campo 		= '<?=$id_obj?>';
var id_campo_txt	= 'txt_'+id_campo;
var content_result	= 'content_result_<?=$cod_columna_tabla?>';

function f_pintar_seleccion(val_cod_pk,val_txt_cod_pk){
	
	$('#'+id_campo).val(val_cod_pk);
	$('#'+id_campo_txt).val(val_txt_cod_pk);
	$('#'+content_result).empty();
	$('#'+content_result).hide('fast');
	
	$('#'+id_campo).change();
	$('#'+id_campo_txt).change();
	
}

$('body').click(function() {
	$('#'+content_result).empty();
	$('#'+content_result).hide('fast');
});



</script>