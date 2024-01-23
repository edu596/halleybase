<?php 
require_once "../modelos/Conceptois.php";

$concepto=new Conceptois();

$idconcepto=isset($_POST["idconcepto"])? limpiarCadena($_POST["idconcepto"]):"";
$nombreconcepto=isset($_POST["nombreconcepto"])? limpiarCadena($_POST["nombreconcepto"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idconcepto)){
			$rspta=$concepto->insertarConcepto($nombreconcepto);
			echo $rspta ? "Concepto registrado" : "Concepto no se pudo registrar";
		}
		else {
			$rspta=$concepto->editar($idconcepto,$nombreconcepto);
			echo $rspta ? "Concepto actualizada" : "Concepto no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$concepto->desactivar($idconcepto);
 		echo $rspta ? "Concepto Desactivada" : "Concepto no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$concepto->activar($idconcepto);
 		echo $rspta ? "Concepto activada" : "Concepto no se puede activar";
 		break;
	break;


	case 'eliminar':
		$rspta=$concepto->eliminar($idconcepto);
 		echo $rspta ? "Concepto eliminado" : "Concepto no se puede eliminar";
 		break;
	break;

	case 'mostrar':
		$rspta=$concepto->mostrar($idconcepto);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$concepto->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idconcepto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idconcepto.')"><i class="fa fa-close"></i></button>'.
 					' <button class="btn btn-warning btn-sm" onclick="eliminar('.$reg->idconcepto.')"><i class="fa fa-trash"></i></button>':
 					'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idconcepto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idconcepto.')"><i class="fa fa-check"></i></button>'
 					,
 				"1"=>$reg->TipoConcepto,
 				"2"=>$reg->nombreconcepto,
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


	case "selectconcepto":
		
		$rspta = $concepto->select();
		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idconcepto . '>' . $reg->nombreconcepto . '</option>';
				}

	break;



	case 'estado':
        $rspta=$concepto->estado();
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idconcepto . '>' . $reg->estado . '</option>';
                }
        break;
}
?>