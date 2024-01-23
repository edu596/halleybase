<?php 
require_once "../modelos/Articulo.php";

$articulo=new Articulo();

$codigoInterno=isset($_POST["codigoInterno"])? limpiarCadena($_POST["codigoInterno"]):"";
$opcion1=isset($_POST["opcion1"])? limpiarCadena($_POST["opcion1"]):"";
$mes=isset($_POST["mes"])? limpiarCadena($_POST["mes"]):"";

switch ($_GET["op"]){
	
	
	case 'kardexarticulo1':
		$rspta=$articulo->kardexArticulo($codigoInterno,$opcion1,$mes);
 		//Vamos a declarar un array
 		
	break;

	
}


?>