<?php
require 'simple_html_dom.php';
error_reporting(E_ALL ^ E_NOTICE);
	
	
$dni = $_POST['dni'];

//OBTENEMOS EL VALOR
//$consulta = file_get_html('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$dni)->plaintext;
//$consulta = file_get_html('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$dni)->plaintext;

$consulta = file_get_html('https://eldni.com/pe/buscar-por-dni?dni='.$dni);

//LA LOGICA DE LA PAGINAS ES APELLIDO PATERNO | APELLIDO MATERNO | NOMBRES

$partes = array();
foreach($consulta->find('td') as $header) {
 $partes[] = $header->plaintext;
}

$datos = array(
		0 => $dni, 
		1 => $partes[0], 
		2 => $partes[1],
		3 => $partes[2],
);

echo json_encode($datos);

?>
