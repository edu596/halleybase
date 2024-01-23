<?php 
require_once "../modelos/Notificaciones.php";

$notificaciones=new Notificaciones();

$idnotificacion=isset($_POST["idnotificacion"])? limpiarCadena($_POST["idnotificacion"]):"";
$idpersona=isset($_POST["cliente"])? limpiarCadena($_POST["cliente"]):"";
$nombrenotificacion=isset($_POST["nombrenotificacion"])? limpiarCadena($_POST["nombrenotificacion"]):"";
$fechacreacion=isset($_POST["fechacreacion"])? limpiarCadena($_POST["fechacreacion"]):"";
$fechaaviso=isset($_POST["fechaaviso"])? limpiarCadena($_POST["fechaaviso"]):"";
$contador=isset($_POST["contador"])? limpiarCadena($_POST["contador"]):"";
$selconti=isset($_POST["selconti"])? limpiarCadena($_POST["selconti"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idnotificacion)){
			$rspta=$notificaciones->insertar($nombrenotificacion, $fechacreacion, $fechaaviso, $contador, $selconti, $idpersona);
			echo $rspta ? "Notificación registrada" : "Notificación no se pudo registrar";
		}
		else {
			$rspta=$notificaciones->editar($idnotificacion, $nombrenotificacion, $fechacreacion, $fechaaviso, $contador, $selconti, $idpersona);
			echo $rspta ? "Notificación actualizada" : "Notificación no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$notificaciones->desactivar($idnotificacion);
 		echo $rspta ? "Notificación Desactivada" : "Notificación no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$notificaciones->activar($idnotificacion);
 		echo $rspta ? "Notificación activada" : "Notificación no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$notificaciones->mostrar($idnotificacion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;


	



	case 'listar':
		$rspta=$notificaciones->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idnotificacion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idnotificacion.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idnotificacion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idnotificacion.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombrenotificacion,
 				"2"=>$reg->fechacreacion,
 				"3"=>$reg->fechaaviso,
 				"4"=>$reg->nombre_comercial,
 				"5"=>($reg->estado=='1')?'<span class="label bg-green">Activado</span>':
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