<?php 
require_once "../modelos/Ventadiaria.php";

$ventadiaria=new Ventadiaria();

$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$fecharegistro=isset($_POST["fecharegistroingreso"])? limpiarCadena($_POST["fecharegistroingreso"]):"";
$total=isset($_POST["total"])? limpiarCadena($_POST["total"]):"";


$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$descripcioncate=isset($_POST["descripcioncate"])? limpiarCadena($_POST["descripcioncate"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idventa)){
			$rspta=$ventadiaria->insertar($fecharegistro, $tipo, $total);
			echo $rspta ? "Ingreso registrado" : "Ingreso no se pudo registrar";
		}
		else {
			$rspta=$ventadiaria->editar($idventa, $fecharegistro,$tipo, $total);
			echo $rspta ? "Insumo actualizado" : "Insumo no se pudo actualizar";
		}
	break;



	case 'mostrar':
		//$idum=$_GET['idventas'];
		$rspta=$ventadiaria->mostrar($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$ventadiaria->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->fecharegistroingreso,
 				"1"=>$reg->tipo,
 				"2"=>$reg->total,
 				"3"=>'<a onclick="eliminar('.$reg->idventa.')"><i class="fa fa-close" style="color:red;"></i></a>'
 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	



	case 'eliminar':
		$rspta=$ventadiaria->eliminar($idventa);
 		echo $rspta ? "Ingreso eliminado" : "Ingreso no se puede eliminar";
 		break;
	break;
}
?>