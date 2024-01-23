<?php 
require_once "../modelos/Insumos.php";

$insumos=new Insumos();

$idinsumo=isset($_POST["idinsumo"])? limpiarCadena($_POST["idinsumo"]):"";
$tipodato=isset($_POST["tipodato"])? limpiarCadena($_POST["tipodato"]):"";
$idutilidad=isset($_POST["idutilidad"])? limpiarCadena($_POST["idutilidad"]):"";
$categoriai=isset($_POST["categoriai"])? limpiarCadena($_POST["categoriai"]):"";
$fecharegistro=isset($_POST["fecharegistro"])? limpiarCadena($_POST["fecharegistro"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";


$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$descripcioncate=isset($_POST["descripcioncate"])? limpiarCadena($_POST["descripcioncate"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idinsumo)){
			$rspta=$insumos->insertar($tipodato, $fecharegistro, $categoriai, $descripcion, $monto);
			echo $rspta ? "Monto registrado" : "Monto no se pudo registrar";
		}
		else {
			$rspta=$insumos->editar($idinsumo, $fecharegistro,$categoriai, $descripcion, $monto);
			echo $rspta ? "Insumo actualizado" : "Insumo no se pudo actualizar";
		}
	break;



	case 'mostrar':
		$rspta=$insumos->mostrar($idinsumo);
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$fech=$_GET['hh'];
		$rspta=$insumos->listar($fech);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->idinsumo,
 				"1"=>$reg->tipodato,
 				"2"=>$reg->descripcionc,
 				"3"=>$reg->descripcion,
 				"4"=>$reg->gasto,
 				"5"=>$reg->ingreso,
 				"6"=>'<a onclick="eliminar('.$reg->idinsumo.')"><i class="fa fa-close" style="color:red;"></i></a>'
 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	

	case 'selectcate':
        require_once "../modelos/Insumos.php";
        $insumos = new Insumos();
         $rspta = $insumos->selectcategoria();
         while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idcategoriai . '>' . $reg->descripcionc . '</option>';

                }
    break;

    case 'guardaryeditarcate':
		if (empty($idcategoria)){
			$rspta=$insumos->insertarcategoria($descripcioncate);
			echo $rspta ? "Categoría registrada" : "Categoría no se pudo registrar";
		}
	break;

	case 'eliminar':
		$rspta=$insumos->eliminar($idinsumo);
 		echo $rspta ? "Insumo eliminado" : "Insumo no se puede eliminar";
 		break;
	break;

	case 'eliminarutilidad':
		$rspta=$insumos->eliminarutilidad($idutilidad);
 		echo $rspta ? "Utilidad eliminada" : "Utilidad no se puede eliminar";
 		break;
	break;



	case 'calcularutilidad':
		$ff1=$_GET['f1'];
		$ff2=$_GET['f2'];
		$rspta=$insumos->calcularuti($ff1, $ff2);
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->idutilidad,
 				"1"=>$reg->fecha1,
 				"2"=>$reg->fecha2,
 				"3"=>$reg->totalgastos,
 				"4"=>$reg->totalventas,
 				"5"=>$reg->utilidad,
 				"6"=>$reg->porcentaje,
 				"7"=>($reg->estado=='0')?'<span>No aprobado</span> <a onclick="aprobarutilidad('.$reg->idutilidad.')"><i class="fa fa-check" style="color:red;"></i></a>':'<span>Aprobado</span>',
 				"8"=>'<a onclick="eliminarutilidad('.$reg->idutilidad.')"><i class="fa fa-close" style="color:red;">del</i></a>
 				<a onclick="recalcularutilidad('.$reg->idutilidad.')"><i class="fa fa-repeat" style="color:green;">reload</i></a>',
 				"9"=>'<a onclick="reporteutilidad('.$reg->idutilidad.')"><i class="fa fa-print" style="color:green;"></i></a>'

 				 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
 		break;

 		case 'recalcularutilidad':
		$idduti=$_GET['iduti'];
		
		$rspta=$insumos->recalcularuti($idduti);
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->idutilidad,
 				"1"=>$reg->fecha1,
 				"2"=>$reg->fecha2,
 				"3"=>$reg->totalgastos,
 				"4"=>$reg->totalventas,
 				"5"=>$reg->utilidad,
 				"6"=>$reg->porcentaje,
 				"7"=>($reg->estado=='0')?'<span>No aprobado</span> <a onclick="aprobarutilidad('.$reg->idutilidad.')"><i class="fa fa-check" style="color:red;"></i></a>':'<span>Aprobado</span>',
 				"8"=>'<a onclick="eliminarutilidad('.$reg->idutilidad.')"><i class="fa fa-close" style="color:red;">del</i></a>
 				<a onclick="recalcularutilidad('.$reg->idutilidad.')"><i class="fa fa-repeat" style="color:green;">reload</i></a>',
 				"9"=>'<a onclick="reporteutilidad('.$reg->idutilidad.')"><i class="fa fa-print" style="color:green;"></i></a>'
 				 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
 		break;



 		case 'listarutilidad':
		$rspta=$insumos->listarutilidad();
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->idutilidad,
 				"1"=>$reg->fecha1,
 				"2"=>$reg->fecha2,
 				"3"=>$reg->totalgastos,
 				"4"=>$reg->totalventas,
 				"5"=>$reg->utilidad,
 				"6"=>$reg->porcentaje,
 				"7"=>($reg->estado=='0')?'<span>No aprobado</span> <a onclick="aprobarutilidad('.$reg->idutilidad.')"><i class="fa fa-check" style="color:red;"></i></a>':'<span>Aprobado</span>',
 				"8"=>'<a onclick="eliminarutilidad('.$reg->idutilidad.')"><i class="fa fa-close" style="color:red;">del</i></a>   
 				<a onclick="recalcularutilidad('.$reg->idutilidad.')"><i class="fa fa-repeat" style="color:green;">reload</i></a>',
 				"9"=>'<a onclick="reporteutilidad('.$reg->idutilidad.')"><i class="fa fa-print" style="color:green;"></i></a>'

 				 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	

		case 'aprobarutilidad':
		$rspta=$insumos->aprobarutilidad($idutilidad);
 		echo $rspta ? "Utilidad aprobada" : "Utilidad no se pudo aprobar";
 		break;
	break;
}
?>