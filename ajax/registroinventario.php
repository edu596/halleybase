<?php 
require_once "../modelos/Registroinventario.php";

$registroinv=new Registroinv();

$idregistro=isset($_POST["idregistro"])? limpiarCadena($_POST["idregistro"]):"";
$ano=isset($_POST["ano"])? limpiarCadena($_POST["ano"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$denominacion=isset($_POST["denominacion"])? limpiarCadena($_POST["denominacion"]):"";
$costoinicial=isset($_POST["costoinicial"])? limpiarCadena($_POST["costoinicial"]):"";
$saldoinicial=isset($_POST["saldoinicial"])? limpiarCadena($_POST["saldoinicial"]):"";
$valorinicial=isset($_POST["valorinicial"])? limpiarCadena($_POST["valorinicial"]):"";
$compras=isset($_POST["compras"])? limpiarCadena($_POST["compras"]):"";
$ventas=isset($_POST["ventas"])? limpiarCadena($_POST["ventas"]):"";
$saldofinal=isset($_POST["saldofinal"])? limpiarCadena($_POST["saldofinal"]):"";
$costo=isset($_POST["costo"])? limpiarCadena($_POST["costo"]):"";
$valorfinal=isset($_POST["valorfinal"])? limpiarCadena($_POST["valorfinal"]):"";



switch ($_GET["op"]){
	case 'guardar':
	if(empty($idregistro))
	{	
			$rspta=$registroinv->insertar($ano, $codigo, $denominacion, $costoinicial, $saldoinicial, $valorinicial, $compras, $ventas, $saldofinal, $costo, $valorfinal);
			echo $rspta ? "Registro correcto" : "No se pudo registrar";
		
	}else{
			$rspta=$registroinv->editar($idregistro, $ano, $codigo, $denominacion, $costoinicial, $saldoinicial, $valorinicial, $compras, $ventas, $saldofinal, $costo, $valorfinal);
			echo $rspta ? "Regsitro actualizado" : "No se pudo actualizar";
		}
	break;

	

	case 'mostrar':
		$rspta=$registroinv->mostrar($idregistro);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'eliminar':
		$rspta=$registroinv->eliminar($idregistro);
 		
 		echo $rspta? "Registro eliminado": "No se pudo eliminar";
 		break;
	




	case 'listar':
		$rspta=$registroinv->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		$cod="";
 		while ($reg=$rspta->fetch_object()){
 			//$cod=strval($reg->codigo);
 			$data[]=array(
 				
 				"0"=>'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idregistro.')" data-toggle="tooltip" title="Editar" >
 				<i class="fa fa-pencil"></i></button>
 				<button class="btn btn-danger btn-sm" onclick="eliminar('.$reg->idregistro.')" data-toggle="tooltip" title="Eliminar">
 				<i class="fa fa-trash"></i></button>',
 				"1"=>$reg->ano,
 				"2"=>$reg->codigo,
 				"3"=>$reg->denominacion,
 				"4"=>$reg->costoinicial,
 				"5"=>number_format($reg->saldoinicial,2),
 				"6"=>number_format($reg->valorinicial,2),
 				"7"=>number_format($reg->compras,2),
 				"8"=>number_format($reg->ventas,2),
 				"9"=>number_format($reg->saldofinal,2),
 				"10"=>$reg->costo,
 				"11"=>number_format($reg->valorfinal,2)
 				
 				
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