<?php 
require_once "../modelos/Correo.php";

$correo = new Correo();

$idcorreo=isset($_POST["idcorreo"])? limpiarCadena($_POST["idcorreo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$username=isset($_POST["username"])? limpiarCadena($_POST["username"]):"";
$host=isset($_POST["host"])? limpiarCadena($_POST["host"]):"";
$password=isset($_POST["password"])? limpiarCadena($_POST["password"]):"";
$smtpsecure=isset($_POST["smtpsecure"])? limpiarCadena($_POST["smtpsecure"]):"";
$port=isset($_POST["port"])? limpiarCadena($_POST["port"]):"";
$mensaje=isset($_POST["mensaje"])? limpiarCadena($_POST["mensaje"]):"";
$correoavisos=isset($_POST["correoavisos"])? limpiarCadena($_POST["correoavisos"]):"";

		//Hash SHA256 en la contraseña
		//$clavehash=hash("SHA256", $password);
		//$clavehash="SHA256";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (empty($idcorreo)){
			$rspta=$correo->insertar(
				$nombre,
				$username,
				$host,
				$password,
				$smtpsecure,
				$port,
				$mensaje,
				$correoavisos
				);
			echo $rspta ? "Cuenta de correo actualizado" : "Cuenta no se pudo actualizar";
		}
		else
		{
			$rspta=$correo->editar(
				$idcorreo,
				$nombre,
				$username,
				$host,
				$password,
				$smtpsecure,
				$port,
				$mensaje,
				$correoavisos
				
				);
			echo $rspta ? "Cuenta de correo actualizado" : "Cuenta no se pudo actualizar";
		}
	break;

	case 'mostrar':
		$rspta=$correo->mostrar($idcorreo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 	break;
	
}
?>