<?php 
				use Greenter\XMLSecLibs\Certificate\X509Certificate;
				use Greenter\XMLSecLibs\Certificate\X509ContentType;

require_once "../modelos/Cargacertificado.php";

$ccertificado = new Cargacertificado();
$idcarga=isset($_POST["idcarga"])? limpiarCadena($_POST["idcarga"]):"";
$numeroruc=isset($_POST["numeroruc"])? limpiarCadena($_POST["numeroruc"]):"";
$razon_social=isset($_POST["razon_social"])? limpiarCadena($_POST["razon_social"]):"";
$usuarioSol=isset($_POST["usuarioSol"])? limpiarCadena($_POST["usuarioSol"]):"";
$claveSol=isset($_POST["claveSol"])? limpiarCadena($_POST["claveSol"]):"";
$rutacertificado=isset($_POST["rutacertificado"])? limpiarCadena($_POST["rutacertificado"]):"";
$rutaserviciosunat=isset($_POST["rutaserviciosunat"])? limpiarCadena($_POST["rutaserviciosunat"]):"";



$keypfx=isset($_POST["keypfx"])? limpiarCadena($_POST["keypfx"]):"";
$webserviceguia=isset($_POST["webserviceguia"])? limpiarCadena($_POST["webserviceguia"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
				
				$ext = explode(".", $_FILES["pfx"]["name"]);
				$cpem = round(microtime(true)) ;
				$name = basename($_FILES["pfx"]["name"]);
				$name2 = basename($_FILES["pfx"]["name"],'.pfx');
				move_uploaded_file($_FILES["pfx"]["tmp_name"], $rutacertificado . $name);

				require 'vendor/autoload.php';
				$pfx = file_get_contents($rutacertificado.$name);
				$password = $keypfx;
				$certificate = new X509Certificate($pfx, $password);
				$pem = $certificate->export(X509ContentType::PEM);
				file_put_contents($rutacertificado.$name2.'.pem', $pem);

		if (empty($idcarga)){
			$rspta=$ccertificado->insertar(
				$numeroruc,
				$razon_social,
				strtoupper($usuarioSol),
				$claveSol,
				$rutacertificado,
				$rutaserviciosunat,
				$name2.'.pem',
				$keypfx,
				$webserviceguia
				);
			echo $rspta ? ", Datos almacenados" : "Problemas al guardar";
		}
		else
		{
			$rspta=$ccertificado->editar($idcarga,
				html_entity_decode($numeroruc , ENT_QUOTES | ENT_HTML401, 'UTF-8'),
				html_entity_decode($razon_social , ENT_QUOTES | ENT_HTML401, 'UTF-8'),
				strtoupper($usuarioSol),
				$claveSol,
				$rutacertificado,
				$rutaserviciosunat,
				$name2.'.pem',
				$keypfx,
				$webserviceguia
				);
			echo $rspta ? " , Datos editados" : "Problemas al editar";
		}

	break;

	case 'mostrar':
		$rspta=$ccertificado->mostrar();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 	break;


 	 	case 'validarclave':
				$ext = explode(".", $_FILES["pfx"]["name"]);
				$cpem = round(microtime(true)) ;
				$name = basename($_FILES["pfx"]["name"]);
				$name2 = basename($_FILES["pfx"]["name"],'.pfx');
				move_uploaded_file($_FILES["pfx"]["tmp_name"], $rutacertificado . $name);
				require 'vendor/autoload.php';
				$pfx = file_get_contents($rutacertificado.$name);
				$password = $keypfx;
				$certificate = new X509Certificate($pfx, $password);
				//echo json_encode($certificate);
				//$pem = $certificate->export(X509ContentType::PEM);
				
 	break;


 	 case 'traerdatosempresa':
                
        $rspta = $ccertificado->mostrarrutaarchivos();
        echo json_encode($rspta);
        break;








}
?>