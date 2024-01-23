<?php 
require_once "../modelos/Familia.php";

$familia=new Familia();

$idfamilia=isset($_POST["idfamilia"])? limpiarCadena($_POST["idfamilia"]):"";
$idalmacen=isset($_POST["idalmacen"])? limpiarCadena($_POST["idalmacen"]):"";
$nombrea=isset($_POST["nombrea"])? limpiarCadena($_POST["nombrea"]):"";
$nombrec=isset($_POST["nombrec"])? limpiarCadena($_POST["nombrec"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
$direc=isset($_POST["direc"])? limpiarCadena($_POST["direc"]):"";
$idempresa=isset($_POST["idempresa2"])? limpiarCadena($_POST["idempresa2"]):"";


$nombreu=isset($_POST["nombreu"])? limpiarCadena($_POST["nombreu"]):"";
$abre=isset($_POST["abre"])? limpiarCadena($_POST["abre"]):"";
$equivalencia=isset($_POST["equivalencia2"])? limpiarCadena($_POST["equivalencia2"]):"";



switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idfamilia)){
			$rspta=$familia->insertarCategoria($nombrec);
			echo $rspta ? "Categoría registrada" : "Categoría no se pudo registrar";
		}
		else {
			$rspta=$familia->editarVategoria($idfamilia,$nombrec);
			echo $rspta ? "Categoría actualizada" : "Categoría no se pudo actualizar";
		}
	break;


	case 'guardaryeditaralmacen':
		if (empty($idalmacen)){
			$rspta=$familia->insertaralmacen($nombrea, $direc, $idempresa);
			echo $rspta ? "Almacen registrado" : "Almacen no se pudo registrar";
		}
		else {
			$rspta=$familia->editar($idalmacen,$nombrea);
			echo $rspta ? "Familia actualizada" : "Familia no se pudo actualizar";
		}
	break;

	case 'guardaryeditarUmedida':
		if (empty($idfamilia)){
			$rspta=$familia->insertaraunidad($nombreu, $abre, $equivalencia);
			echo $rspta ? "Unidad registrada" : "Unidad no se pudo registrar";
		}
		else {
			$rspta=$familia->editar($idfamilia,$nombre);
			echo $rspta ? "Unidad actualizada" : "Unidad no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$familia->desactivar($idfamilia);
 		echo $rspta ? "Familia Desactivada" : "Familia no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$familia->activar($idfamilia);
 		echo $rspta ? "Familia activada" : "Familia no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$familia->mostrar($idfamilia);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$familia->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idfamilia.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idfamilia.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idfamilia.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idfamilia.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
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