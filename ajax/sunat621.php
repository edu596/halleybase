<?php 
if (strlen(session_id()) < 1) 
  session_start();


require_once "../modelos/Sunat621.php";



$sunat621=new Sunat621();


$idcalculo=isset($_POST["idcalculo"])? limpiarCadena($_POST["idcalculo"]):"";
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";

$vngra=isset($_POST["vngra2"])? limpiarCadena($_POST["vngra2"]):"";

$cnvg=isset($_POST["cngra2"])? limpiarCadena($_POST["cngra2"]):"";

$igvng=isset($_POST["vngraigv2"])? limpiarCadena($_POST["vngraigv2"]):"";

$igvcn=isset($_POST["cngraigv2"])? limpiarCadena($_POST["cngraigv2"]):"";

$totaltribvent=isset($_POST["vngraigvtotal2"])? limpiarCadena($_POST["vngraigvtotal2"]):"";
$totaltribcom=isset($_POST["cngraigvtotal2"])? limpiarCadena($_POST["cngraigvtotal2"]):"";

$rentingnet=isset($_POST["vngrarenta2"])? limpiarCadena($_POST["vngrarenta2"]):"";
$renttribcal=isset($_POST["vngrarenta1porc2"])? limpiarCadena($_POST["vngrarenta1porc2"]):"";
$totalrent=isset($_POST["vngrarentatotal2"])? limpiarCadena($_POST["vngrarentatotal2"]):"";

$tribpagsfavigv=isset($_POST["imresusa2"])? limpiarCadena($_POST["imresusa2"]):"";
$tribpagsfavrent=isset($_POST["rentatotal2"])? limpiarCadena($_POST["rentatotal2"]):"";
$tibpagsalfav=isset($_POST["tpsf2"])? limpiarCadena($_POST["tpsf2"]):"";
$totaldtirbigv=isset($_POST["impopagarigv2"])? limpiarCadena($_POST["impopagarigv2"]):"";
$totaldtirbrent=isset($_POST["totaldtrenta2"])? limpiarCadena($_POST["totaldtrenta2"]):"";


	require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2("1");
    $Prutas = $Rrutas->fetch_object();
    $rutaimagen=$Prutas->rutaarticulos; // ru

switch ($_GET["op"]){

	case 'guardaryeditar':

		if (empty($idcalculo)){

			$rspta=$sunat621->insertar(
				$_SESSION['idempresa'],
				$periodo,
				$vngra,
				$cnvg,
				$igvng,
				$igvcn,
				$totaltribvent,
				$totaltribcom,
				$rentingnet,
				$renttribcal,
				$totalrent,
				$tribpagsfavigv,
				$tribpagsfavrent,
				$tibpagsalfav,
				$totaldtirbigv,
				$totaldtirbrent
				);

			echo $rspta ? "Periodo registrado" : "Error al registrar";

		}

		else

		{

			$rspta=$sunat621->editar(
				$idcalculo,
				$vngra,
				$cnvg,
				$igvng,
				$igvcn,
				$totaltribvent,
				$totaltribcom,
				$rentingnet,
				$renttribcal,
				$totalrent,
				$tribpagsfavigv,
				$tribpagsfavrent,
				$tibpagsalfav,
				$totaldtirbigv,
				$totaldtirbrent

				);

			echo $rspta ? "Periodo actualizado" : "Periodo no se pudo actualizar";

		}

	break;

 	case 'ventasgrav':
		$prd=$_GET['periD'];
		$rspta=$sunat621->datos621($prd);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;


 	case 'eliminarperiodo':
		$idcal=$_GET['idcalcc'];
		$rspta=$sunat621->eliminarperiodo($idcal);
 		
 		echo $rspta ? "Periodo eliminado" : "Problemas al eliminar"  ;
 		break;

 	

 	 case 'comprasgrav':
		$prd=$_GET['periD'];
		$rspta=$sunat621->datos621Compra($prd);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;


 		case 'ventasgravRenta':
		$prd=$_GET['periD'];
		$rspta=$sunat621->datos621Renta($prd);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;


 		case 'buscarperiodo':
		$prd=$_GET['periD'];
		$rspta=$sunat621->buscarperiodo($prd);
 		echo json_encode($rspta);
 		break;

}




?>