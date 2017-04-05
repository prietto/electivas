<? 
header('Content-type: text/html; charset=iso-8859-1'); 
header("Content-type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=".$txt_reporte_tabla.".csv");
header("Content-Type: application/force-download"); 
header("Content-Type: application/octet-stream"); 
header("Content-Type: application/download"); 
header("Content-Description: File Transfer"); 

$cursor_excel = $resultado_cursor['DATOS']; 
$numero_columnas = $db->num_columnas($cursor_excel); 
$array_nombres = array(); $array_datos = array(); 

for($i=0;$i<$numero_columnas;$i++) { 
	$nom_columna = $db->nom_columna($cursor_excel,$i); 
	array_push($array_nombres,$nom_columna); 
} 

$nom_columna = implode(";",$array_nombres); 
echo $nom_columna;
while($row = $db->sacar_registro($cursor_excel) ) { 
	for($i=0;$i<$numero_columnas;$i++) { 
		$dato = $row[$i]; 
		$dato = strtoupper(utf8_decode($dato)); array_push($array_datos,$dato); 
	} 
	$reg = implode("--,--",$array_datos); 
	$reg = str_ireplace(";",",",$reg);
	$reg = str_ireplace("--,--",";",$reg); 
	$reg = str_ireplace("\n","",$reg); 
	$reg = str_ireplace("\r","",$reg); 
	$reg = str_ireplace("","",$reg); 
	echo "\r$reg"; $array_datos = array(); 
}
?>