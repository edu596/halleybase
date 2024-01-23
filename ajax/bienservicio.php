<?php 

if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Bienservicio.php";

$bienservicio=new Bienes_inmuebles();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$valor=isset($_POST["valor"])? limpiarCadena($_POST["valor"]):"";
$idempresa=isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$ccontable=isset($_POST["ccontable"])? limpiarCadena($_POST["ccontable"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id)){
			$rspta=$bienservicio->insertar(html_entity_decode($descripcion , ENT_QUOTES | ENT_HTML401, 'UTF-8'), $codigo, $valor, $idempresa, $tipo, $ccontable );
			echo $rspta ? "Bien o servicio registrado" : "Bien o servicio no se pudo registrar";
		}
		else {
			$rspta=$bienservicio->editar($id, html_entity_decode($descripcion , ENT_QUOTES | ENT_HTML401, 'UTF-8'), $codigo, $valor, $idempresa , $tipo, $ccontable);
			echo $rspta ? "Bien o servicio actualizada" : "Bien o servicio no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$bienservicio->desactivar($id);
 		echo $rspta ? "Bien o servicio Desactivada" : "Bien o servicio no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$bienservicio->activar($id);
 		echo $rspta ? "Bien o servicio activada" : "Bien o servicio no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$bienservicio->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$idempresa=$_GET['idempresa'];
		$rspta=$bienservicio->listar($_SESSION['idempresa']);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<i class="fa fa-pencil" onclick="mostrar('.$reg->id.')"  style="color:orange;" ></i>'.
 					' <i class="fa fa-close" onclick="desactivar('.$reg->id.')" style="color:red;"></i>':
 					'<i class="fa fa-pencil" onclick="mostrar('.$reg->id.')" style="color:orange;"></i>'.
 					' <i class="fa fa-check" onclick="activar('.$reg->id.')" style="color:green;"></i>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->codigo,
 				"3"=>number_format($reg->valor,2),
 				"4"=>$reg->tipo,
 				"5"=>$reg->ccontable,
 				"6"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
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