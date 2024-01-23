<?php 
require_once "../modelos/Mesa.php";

$mesa=new Mesa();

$idmesa=isset($_POST["idmesa"])? limpiarCadena($_POST["idmesa"]):"";
$nromesa=isset($_POST["nromesa"])? limpiarCadena($_POST["nromesa"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idmesa)){
			$rspta=$mesa->insertar($nromesa);
			echo $rspta ? "Mesa registrada" : "Mesa no se pudo registrar";
		}
		else {
			$rspta=$mesa->editar($idmesa,$nromesa);
			echo $rspta ? "Mesa actualizada" : "Mesa no se pudo actualizar";
		}
	break;


	case 'desactivar':
		$rspta=$mesa->desactivar($idmesa);
 		echo $rspta ? "Mesa Desactivada" : "Mesa no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$mesa->activar($idmesa);
 		echo $rspta ? "Mesa activada" : "Mesa no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$mesa->mostrar($idmesa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$mesa->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idmesa.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idmesa.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idmesa.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idmesa.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nromesa,
 				"2"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
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