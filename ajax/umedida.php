<?php 
require_once "../modelos/Umedida.php";

$umedida=new Umedida();

$idunidadme=isset($_POST["idunidadm"])? limpiarCadena($_POST["idunidadm"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$abre=isset($_POST["abre"])? limpiarCadena($_POST["abre"]):"";
$equivalencia=isset($_POST["equivalencia"])? limpiarCadena($_POST["equivalencia"]):"";



switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idunidadme)){
			$rspta=$umedida->insertar($nombre, $abre, $equivalencia);
			echo $rspta ? "Unidad de medida registrada" : "Unidad de medida no se pudo registrar";
		}
		else {
			$rspta=$umedida->editar($idunidadme, $nombre, $abre, $equivalencia);
			echo $rspta ? "Unidad de medida actualizada" : "Unidad de medida no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$umedida->desactivar($idunidadme);
 		echo $rspta ? "Unidad de medida Desactivada" : "Unidad de medida no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$umedida->activar($idunidadme);
 		echo $rspta ? "Unidad de medida activada" : "Unidad de medida no se puede activar";
 		break;
	break;


	case 'eliminar':
		$rspta=$umedida->eliminar($idunidadme);
 		echo $rspta ? "Unidad de medida eliminada" : "Unidad de medida no se puede eliminar";
 		break;
	break;

	case 'mostrar':
		//$idum=$_GET['idumedida'];
		$rspta=$umedida->mostrar($idunidadme);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$umedida->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idunidad.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idunidad.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idunidad.')"><i class="fa fa-pencil"></i></button>'.
 					'<button class="btn btn-primary btn-sm" onclick="activar('.$reg->idunidad.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombreum,
 				"2"=>$reg->abre,
 				"3"=>$reg->equivalencia,
 				"4"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
 				"5"=>'<button class="btn btn-danger btn-sm" onclick="eliminar('.$reg->idunidad.')">ELIMINAR</button>'
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