<?php 

if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/SueldoBoleta.php";
$tipoSe=new TipoSeguro();
$empleadobol=new EmpleadoBoleta();
$boletapago=new BoletaPago();

//seguro
$idusuario=$_SESSION["idusuario"];
$idtipoSeguro=isset($_POST["idtipoSeguro"])? limpiarCadena($_POST["idtipoSeguro"]):"";
$tipoSeguro=isset($_POST["tipoSeguro"])? limpiarCadena($_POST["tipoSeguro"]):"";
$nombreSeguro=isset($_POST["nombreSeguro"])? limpiarCadena($_POST["nombreSeguro"]):"";
$snp=isset($_POST["snp"])? limpiarCadena($_POST["snp"]):"";
$aoafp=isset($_POST["aoafp"])? limpiarCadena($_POST["aoafp"]):"";
$invsob=isset($_POST["invsob"])? limpiarCadena($_POST["invsob"]):"";
$comiafp=isset($_POST["comiafp"])? limpiarCadena($_POST["comiafp"]):"";



//EMPLEADO
$idempleado=isset($_POST["idempleado"])? limpiarCadena($_POST["idempleado"]):"";
$nombresE=isset($_POST["nombresE"])? limpiarCadena($_POST["nombresE"]):"";
$apellidosE=isset($_POST["apellidosE"])? limpiarCadena($_POST["apellidosE"]):"";
$fechaingreso=isset($_POST["fechaingreso"])? limpiarCadena($_POST["fechaingreso"]):"";
$ocupacion=isset($_POST["ocupacion"])? limpiarCadena($_POST["ocupacion"]):"";
$tiporemuneracion=isset($_POST["tiporemuneracion"])? limpiarCadena($_POST["tiporemuneracion"]):"";
$dni=isset($_POST["dni"])? limpiarCadena($_POST["dni"]):"";
$autogenessa=isset($_POST["autogenessa"])? limpiarCadena($_POST["autogenessa"]):"";
$cusspp=isset($_POST["cusspp"])? limpiarCadena($_POST["cusspp"]):"";
$sueldoBruto=isset($_POST["sueldoBruto"])? limpiarCadena($_POST["sueldoBruto"]):"";
$horasT=isset($_POST["horasT"])? limpiarCadena($_POST["horasT"]):"";
$asigFam=isset($_POST["asigFam"])? limpiarCadena($_POST["asigFam"]):"";
$trabNoct=isset($_POST["trabNoct"])? limpiarCadena($_POST["trabNoct"]):"";

$idempresab=isset($_POST["idempresab"])? limpiarCadena($_POST["idempresab"]):"";

//BOLETA PAGO
$idboletaPago=isset($_POST["idboletaPago"])? limpiarCadena($_POST["idboletaPago"]):"";
$mesbp=isset($_POST["mes"])? limpiarCadena($_POST["mes"]):"";
$anobp=isset($_POST["ano"])? limpiarCadena($_POST["ano"]):"";


$cdias=isset($_POST["cdias"])? limpiarCadena($_POST["cdias"]):"";
$totaldias=isset($_POST["choras"])? limpiarCadena($_POST["choras"]):"";
$hextras=isset($_POST["cchoras"])? limpiarCadena($_POST["cchoras"]):"";
$totalhoex=isset($_POST["horasex"])? limpiarCadena($_POST["horasex"]):"";
$totalsbru=isset($_POST["totalsbru"])? limpiarCadena($_POST["totalsbru"]):"";
$totaldescu=isset($_POST["totaldescu"])? limpiarCadena($_POST["totaldescu"]):"";
$saldopagar=isset($_POST["saldopagar"])? limpiarCadena($_POST["saldopagar"]):"";
$fechapagoboleta=isset($_POST["fechapagoboleta"])? limpiarCadena($_POST["fechapagoboleta"]):"";
$importeessa=isset($_POST["importeessa"])? limpiarCadena($_POST["importeessa"]):"";
$nboleta=isset($_POST["nboleta2"])? limpiarCadena($_POST["nboleta2"]):"";

$nrobol=isset($_POST["nrobol"])? limpiarCadena($_POST["nrobol"]):"";
$idserie=isset($_POST["idserie"])? limpiarCadena($_POST["idserie"]):"";

$importe5t=isset($_POST["importe5t"])? limpiarCadena($_POST["importe5t"]):"";
$taoafp=isset($_POST["importetasa"])? limpiarCadena($_POST["importetasa"]):"";
$tinvsob=isset($_POST["importetasais"])? limpiarCadena($_POST["importetasais"]):"";
$tcomiafp=isset($_POST["importetasacomi"])? limpiarCadena($_POST["importetasacomi"]):"";
$tsnp=isset($_POST["importesnp"])? limpiarCadena($_POST["importesnp"]):"";

$conceptoadicional=isset($_POST["conceptoadicional"])? limpiarCadena($_POST["conceptoadicional"]):"";
$importeconcepto=isset($_POST["importeconcepto"])? limpiarCadena($_POST["importeconcepto"]):"";



switch ($_GET["op"]){


	case 'guardareditarboletapago':
	if (empty($idboletaPago)) {
			$rpta=$boletapago->insertar($idempleado, $mesbp, $anobp, $cdias, $totaldias, $hextras, $totalhoex,  $totalsbru, 
				$importe5t, $totaldescu, $saldopagar, $fechapagoboleta, $importeessa, $nboleta, $nrobol, $idserie, $taoafp, $tinvsob,
				$tcomiafp, $tsnp, $conceptoadicional, $importeconcepto);
			echo $rpta ? "Se guardo correctamente " : "Problema al guardar";
	}else{
			$rpta=$boletapago->editarboletapago($idboletaPago, $mesbp, $anobp, $cdias, $totaldias, $hextras, $totalhoex, 
				$totalsbru, $importe5t, $totaldescu, $saldopagar, $fechapagoboleta, $importeessa, $nboleta, $nrobol, $idserie, $taoafp, $tinvsob,
				$tcomiafp, $tsnp , $conceptoadicional, $importeconcepto);
			echo $rpta ? "Se edito correctamente la boleta de pago" : "Problema al editar boleta de pago";
		}
 		break;



	case 'selectSerie':
        $rspta = $boletapago->llenarSerieBol($idusuario);
        echo json_encode($rspta);
    break; 


    case 'autonumeracion':
    
    $Ser=$_GET['ser'];
    $rspta=$boletapago->llenarNumeroBolpago($Ser);
        while ($reg=$rspta->fetch_object())
        {
        echo $reg->Nnumero;    
        }
    break;

	

	case 'listarboletapago':
		
		$rspta=$boletapago->listarboletapago();
 		$data= Array();

 		$urlprint='';

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->idboletapago,
 				"1"=>$reg->nroboleta,
 				"2"=>$reg->empleado,
 				"3"=>$reg->mes,
 				"4"=>$reg->ano,
 				"5"=>$reg->totaldiast,
 				"6"=>$reg->totalhorasEx,
 				"7"=>$reg->totalbruto,
 				"8"=>$reg->totaldcto,
 				"9"=>$reg->sueldopagar,
 				"10"=>$reg->nombre_comercial,
 				"11"=>

             '<div class="dropup">
                <button  class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                :::
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-center">
                <li>
                   <a onclick="eliminar('.$reg->idboletapago.')"><i class="fa fa-close" style="color:red;"></i>Eliminar</a>
                  
                  </li>

                  <li>
                  <a onclick="editarboleta('.$reg->idboletapago.')"><i class="fa fa-pencil" style="color:orange;"></i>Editar boleta</a>

                   <li>
                  <a  onclick="previoprint('.$reg->idboletapago.')"> <i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir boleta de pago" onclick=""></i>
                        Imprimir
                    </a>
                  </li>
                </ul>
                </div>'

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
		break;


		case 'eliminarboleta':
		$rspta=$boletapago->eliminarbol($idboletaPago);
 		echo $rspta ? "Boleta eliminada" : "Boleta no se puede eliminar";
 		break;


		case 'mostrarbolpago':
		$rspta=$boletapago->mostrarboletapago($idboletaPago);
 		echo json_encode($rspta);
 		break;



	case 'seleccionempleado':
	$iddem=$_GET['idemple'];
		$rspta=$boletapago->seleccionempleado($iddem);
 		echo json_encode($rspta);
 		break;
	

	case 'ultimaboleta':
		$rspta=$boletapago->ultimaboleta();
 		echo json_encode($rspta);
 		break;
	


	case "cargarempleadosdeempresa":
		$idempe=$_GET['idem'];
		$rspta=$boletapago->cargarempleados($idempe);
		while ($reg = $rspta->fetch_object())
				{
					echo '<option value='.$reg->idempleado.'>' . $reg->nombresE.' '.$reg->apellidosE. '</option>';
				}
		break;









	case "cargarempresas":
		$rspta=$empleadobol->cargarempresa();
		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idempresa . '>' . $reg->nombre_razon_social . '</option>';
				}
		break;


		case "cargarseguro":
		$rspta=$empleadobol->cargarseguro();
		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idtipoSeguro . '>' . $reg->tipoSeguro.' | '.$reg->nombreSeguro.'</option>';
				}
		break;


	case 'guardaryeditarempleado':
		if (empty($idempleado)){
			$rspta=$empleadobol->insertarempleado($nombresE, $apellidosE, $fechaingreso, $ocupacion, $tiporemuneracion, $dni, $autogenessa, $cusspp, $sueldoBruto, $horasT, $asigFam, $trabNoct, $idempresab, $idtipoSeguro);
			echo $rspta ? "Empleado registrado" : "No se pudo registrar";
		}
		else {
			$rspta=$empleadobol->editarempleado($idempleado, $nombresE, $apellidosE, $fechaingreso, $ocupacion, $tiporemuneracion, $dni, $autogenessa, $cusspp, $sueldoBruto, $horasT, $asigFam, $trabNoct, $idempresab, $idtipoSeguro);
			echo $rspta ? "Empleado actualizado" : "No se pudo actualizar";
		}
	break;


	case 'listarempleado':
		
		$rspta=$empleadobol->listarempleado();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre_comercial,
 				"1"=>$reg->nombresE,
 				"2"=>$reg->apellidosE,
 				"3"=>$reg->fechaingreso,
 				"4"=>$reg->ocupacion,
 				"5"=>$reg->dni,
 				"6"=>$reg->cusspp,
 				"7"=>$reg->sueldoBruto,
 				"8"=>$reg->horasT,
 				"9"=>$reg->nombreSeguro,
 				
 				"10"=>'<a onclick="eliminar('.$reg->idempleado.')"><i class="fa fa-close" style="color:red;"></i></a>
 					  <a onclick="editar('.$reg->idempleado.')"><i class="fa fa-pencil" style="color:orange;"></i></a>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;



	


		case 'eliminarempleado':
		$rspta=$empleadobol->eliminaremple($idempleado);
 		echo $rspta ? "Empleado eliminado" : "Empleado no se puede eliminar";
 		break;


 			case 'mostrarempleado':
		$rspta=$empleadobol->mostrarempleado($idempleado);
 		echo json_encode($rspta);
 		break;
	








	case 'guardaryeditartiposeguro':
		if (empty($idtipoSeguro)){
			$rspta=$tipoSe->insertarts($tipoSeguro, $nombreSeguro, $snp, $aoafp, $invsob, $comiafp);
			echo $rspta ? "Registrado" : "No se pudo registrar";
		}
		else {
			$rspta=$tipoSe->editarts($idtipoSeguro, $tipoSeguro, $nombreSeguro, $snp, $aoafp, $invsob, $comiafp);
			echo $rspta ? "Actualizado" : "No se pudo actualizar";
		}
	break;





	case 'mostrarts':
		$rspta=$tipoSe->mostrar($idtipoSeguro);
 		echo json_encode($rspta);
 		break;
	break;

	case 'listarts':
		
		$rspta=$tipoSe->listarts();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->tipoSeguro,
 				"1"=>$reg->nombreSeguro,
 				"2"=>$reg->snp,
 				"3"=>$reg->aoafp,
 				"4"=>$reg->invsob,
 				"5"=>$reg->comiafp,
 				"6"=>'<a onclick="eliminar('.$reg->idtipoSeguro.')"><i class="fa fa-close" style="color:red;"></i></a>
 					  <a onclick="editar('.$reg->idtipoSeguro.')"><i class="fa fa-pencil" style="color:orange;"></i></a>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'eliminartse':
		$rspta=$tipoSe->eliminarts($idtipoSeguro);
 		echo $rspta ? "Tipo de seguro eliminado" : "Tipo de seguro no se puede eliminar";
 		break;


	
}
?>