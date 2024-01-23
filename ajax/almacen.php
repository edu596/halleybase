<?php
require_once "../modelos/Almacen.php";

$almacen=new Almacen();

$idalmacen=isset($_POST["idalmacen"])? limpiarCadena($_POST["idalmacen"]):"";

$nombrea=isset($_POST["nombrea"])? limpiarCadena($_POST["nombrea"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";


switch ($_GET["op"]){


	case 'guardaryeditar':
		if (empty($idalmacen)){
			$rspta=$almacen->insertaralmacen($nombrea, $direccion, '1');
			echo $rspta ? "Almacen registrado" : "Almacen no se pudo registrar";
		}
		else {
			$rspta=$almacen->editar($idalmacen,$nombrea, $direccion);
			echo $rspta ? "almacen actualizada" : "almacen no se pudo actualizar";
		}
	break;


	case 'desactivar':
		$rspta=$almacen->desactivar($idalmacen);
 		echo $rspta ? "almacen Desactivada" : "almacen no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$almacen->activar($idalmacen);
 		echo $rspta ? "almacen activada" : "almacen no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$almacen->mostrar($idalmacen);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$almacen->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idalmacen.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idalmacen.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idalmacen.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idalmacen.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->direccion,
 				"3"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
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