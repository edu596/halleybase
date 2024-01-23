<?php 
require_once "../modelos/Numeracion.php";

$numeracion=new Numeracion();

$idnumeracion=isset($_POST["idnumeracion"])? limpiarCadena($_POST["idnumeracion"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$serie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";
$numero=isset($_POST["numero"])? limpiarCadena($_POST["numero"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idnumeracion)){
			$rspta=$numeracion->insertar($tipo_documento, $serie, $numero );
			echo $rspta ? "Numeración registrada" : "Numeración no se pudo registrar";
		}
		else {
			$rspta=$numeracion->editar($idnumeracion,$tipo_documento, $serie, $numero);
			echo $rspta ? "Numeración actualizada" : "Numeración no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$numeracion->desactivar($idnumeracion);
 		echo $rspta ? "Numeración Desactivada" : "Numeración no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$numeracion->activar($idnumeracion);
 		echo $rspta ? "Numeración activada" : "Numeración no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$numeracion->mostrar($idnumeracion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$numeracion->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idnumeracion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idnumeracion.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idnumeracion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idnumeracion.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->serie,
 				"3"=>$reg->numero,
 				"4"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
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