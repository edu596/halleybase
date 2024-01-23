<?php 
require_once "../modelos/Rutas.php";

$rutas = new Rutas();

$idruta=isset($_POST["idruta"])? limpiarCadena($_POST["idruta"]):"";
$rutadata=isset($_POST["rutadata"])? limpiarCadena($_POST["rutadata"]):"";
$rutadatalt=isset($_POST["rutadatalt"])? limpiarCadena($_POST["rutadatalt"]):"";
$rutafirma=isset($_POST["rutafirma"])? limpiarCadena($_POST["rutafirma"]):"";
$rutaenvio=isset($_POST["rutaenvio"])? limpiarCadena($_POST["rutaenvio"]):"";
$rutarpta=isset($_POST["rutarpta"])? limpiarCadena($_POST["rutarpta"]):"";
$rutabaja=isset($_POST["rutabaja"])? limpiarCadena($_POST["rutabaja"]):"";
$rutaresumen=isset($_POST["rutaresumen"])? limpiarCadena($_POST["rutaresumen"]):"";
$rutadescargas=isset($_POST["rutadescargas"])? limpiarCadena($_POST["rutadescargas"]):"";
$rutaple=isset($_POST["rutaple"])? limpiarCadena($_POST["rutaple"]):"";
$unziprpta=isset($_POST["unziprpta"])? limpiarCadena($_POST["unziprpta"]):"";
$idempresa=isset($_POST["empresa"])? limpiarCadena($_POST["empresa"]):"";


$rutaarticulos=isset($_POST["rutaarticulos"])? limpiarCadena($_POST["rutaarticulos"]):"";
$rutalogo=isset($_POST["rutalogo"])? limpiarCadena($_POST["rutalogo"]):"";
$rutausuarios=isset($_POST["rutausuarios"])? limpiarCadena($_POST["rutausuarios"]):"";

$salidafacturas=isset($_POST["salidafacturas"])? limpiarCadena($_POST["salidafacturas"]):"";
$salidaboletas=isset($_POST["salidaboletas"])? limpiarCadena($_POST["salidaboletas"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (empty($idruta)){
			$rspta=$rutas->insertar(
				$rutadata,
				$rutafirma,
				$rutaenvio,
				$rutarpta,
				$rutadatalt,
				$rutabaja,
				$rutaresumen,
				$rutadescargas,
				$rutaple,
				$idempresa,
				$unziprpta,
				$rutaarticulos,
				$rutalogo,
				$rutausuarios,
				$salidafacturas,
				$salidaboletas

				);
			echo $rspta ? "Ruta creada" : "No se pudo crear.";
		}
		else
		{
			$rspta=$rutas->editar(
				$idruta,
				$rutadata,
				$rutafirma,
				$rutaenvio,
				$rutarpta,
				$rutadatalt,
				$rutabaja,
				$rutaresumen,
				$rutadescargas,
				$rutaple,
				$idempresa,
				$unziprpta,
				$rutaarticulos,
				$rutalogo,
				$rutausuarios,
				$salidafacturas,
				$salidaboletas
				
				);
			echo $rspta ? "Rutas actualizada" : "No se pudo actualizar.";
		}
	break;

	case 'mostrar':
		$rspta=$rutas->mostrar($idruta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 	break;

 	case 'listar':
 	$idempresa=$_GET['idempresa'];
		$rspta=$rutas->listar($idempresa);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idruta.')"><i class="fa fa-pencil"></i></button>',
 				"1"=>$reg->rutadata,
 				"2"=>$reg->rutafirma,
 				"3"=>$reg->rutaenvio,
 				"4"=>$reg->rutarpta,
 				"5"=>$reg->unziprpta
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	
}
?>