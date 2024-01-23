<?php 
require_once "../modelos/Catalogo5.php";

$catalogo5=new Catalogo5();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$unece5153=isset($_POST["unece5153"])? limpiarCadena($_POST["unece5153"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id)){
			$rspta=$catalogo5->insertar($codigo, $descripcion, $unece5153 );
			echo $rspta ? "Concepto registrado" : "Concepto no se pudo registrar";
		}
		else {
			$rspta=$catalogo5->editar($id, $codigo, $descripcion, $unece5153);
			echo $rspta ? "Concepto actualizado" : "Concepto no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$catalogo5->desactivar($id);
 		echo $rspta ? "Numeración Desactivada" : "Numeración no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$catalogo5->activar($id);
 		echo $rspta ? "Numeración activada" : "Numeración no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$catalogo5->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$catalogo5->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<i class="fa fa-pencil" onclick="mostrar('.$reg->id.')" style="color:green;"></i>'.
 					' <i class="fa fa-close" onclick="desactivar('.$reg->id.')" style="color:red;"></i>':
 					'<i class="fa fa-pencil" onclick="mostrar('.$reg->id.')"></i>'.
 					' <i class="fa fa-check" onclick="activar('.$reg->id.')" style="color:green;"></i>',
 				"1"=>$reg->codigo,
 				"2"=>$reg->descripcion,
 				"3"=>$reg->unece5153,
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