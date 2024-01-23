<?php 
require_once "../modelos/Persona.php";
$persona=new Persona();

$idpersona=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";
$tipo_persona=isset($_POST["tipo_persona"])? limpiarCadena($_POST["tipo_persona"]):"";
$nombres=isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]):"";
$apellidos=isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$numero_documento=isset($_POST["numero_documento"])? limpiarCadena($_POST["numero_documento"]):"";
$nruc=isset($_POST["numero_documento3"])? limpiarCadena($_POST["numero_documento3"]):""; //Viene de nuevo cliente
$razon_social=isset($_POST["razon_social"])? limpiarCadena($_POST["razon_social"]):"";
$nombre_comercial=isset($_POST["nombre_comercial"])? limpiarCadena($_POST["nombre_comercial"]):"";
$domicilio_fiscal=isset($_POST["domicilio_fiscal"])? limpiarCadena($_POST["domicilio_fiscal"]):"";
$departamento=isset($_POST["iddepartamento"])? limpiarCadena($_POST["iddepartamento"]):"";
$ciudad=isset($_POST["idciudad"])? limpiarCadena($_POST["idciudad"]):"";
$distrito=isset($_POST["iddistrito"])? limpiarCadena($_POST["iddistrito"]):"";
$telefono1=isset($_POST["telefono1"])? limpiarCadena($_POST["telefono1"]):"";
$telefono2=isset($_POST["telefono2"])? limpiarCadena($_POST["telefono2"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";


$razon_social3=isset($_POST["razon_social3"])? limpiarCadena($_POST["razon_social3"]):"";
$nombre_comercial3=isset($_POST["razon_social3"])? limpiarCadena($_POST["razon_social3"]):"";
$domicilio_fiscal3=isset($_POST["domicilio_fiscal3"])? limpiarCadena($_POST["domicilio_fiscal3"]):"";


$ubigeocli=isset($_POST["ubigeocli"])? limpiarCadena($_POST["ubigeocli"]):"";
$ubigeo=isset($_POST["ubigeo"])? limpiarCadena($_POST["ubigeo"]):"";

switch ($_GET["op"]){

	case 'guardaryeditar':
		if (empty($idpersona)){
			$rspta=$persona->insertar($tipo_persona, htmlspecialchars_decode($nombres), htmlspecialchars_decode($apellidos), $tipo_documento, $numero_documento, htmlspecialchars_decode($razon_social), htmlspecialchars_decode($nombre_comercial),htmlspecialchars_decode($domicilio_fiscal) ,$departamento,$ciudad, $distrito, $telefono1, $telefono2, htmlspecialchars_decode($email), $ubigeo);
			echo $rspta ? "Registro correcto" : "No se pudo registrar";
		}
		else {
			$rspta=$persona->editar($idpersona,$tipo_persona,$nombres,$apellidos,$tipo_documento,$numero_documento,$razon_social,$nombre_comercial,$domicilio_fiscal,$departamento,$ciudad,$distrito,$telefono1,$telefono2,$email, $ubigeo);
			echo $rspta ? "Registro actualizado" : "No se pudo actualizar";
		}
	break;

		case 'guardaryeditarnproveedor':
			$rspta=$persona->insertarnproveedor($tipo_persona, $numero_documento, htmlspecialchars_decode($razon_social));
			echo $rspta ? "Registro correcto" : "No se pudo registrar";

		break;



		case 'guardaryeditarNcliente':
		if (empty($idpersona)){
			$rspta=$persona->insertar($tipo_persona,htmlspecialchars_decode($nombres), htmlspecialchars_decode($apellidos), $tipo_documento, $nruc, htmlspecialchars_decode($razon_social), htmlspecialchars_decode($nombre_comercial), htmlspecialchars_decode($domicilio_fiscal) ,$departamento,$ciudad, $distrito, $telefono1, $telefono2,htmlspecialchars_decode($email), $ubigeocli);
			echo $rspta ? "Registro correcto" : "No se pudo registrar";
		}
		else {
			$rspta=$persona->editar($idpersona,$tipo_persona,htmlspecialchars_decode($nombres),htmlspecialchars_decode($apellidos),$tipo_documento,$nruc,htmlspecialchars_decode($razon_social),htmlspecialchars_decode($nombre_comercial),htmlspecialchars_decode($domicilio_fiscal),$departamento,$ciudad,$distrito,$telefono1,$telefono2,htmlspecialchars_decode($email), $ubigeocli);
			echo $rspta ? "Registro actualizado" : "No se pudo actualizar";
		}
	break;



			case 'guardaryeditarNclienteBoleta':
		if (empty($idpersona)){
			$rspta=$persona->insertar($tipo_persona,htmlspecialchars_decode($nombre_comercial3), htmlspecialchars_decode($nombre_comercial3), $tipo_documento, $nruc, htmlspecialchars_decode($razon_social3), htmlspecialchars_decode($nombre_comercial3), htmlspecialchars_decode($domicilio_fiscal3) ,'14','43','96', $telefono1, $telefono2,htmlspecialchars_decode($email));
			echo $rspta ? "Registro correcto" : "No se pudo registrar";
		}
		else {
			$rspta=$persona->editar($idpersona,$tipo_persona,htmlspecialchars_decode($nombre_comercial3),htmlspecialchars_decode($nombre_comercial3),$tipo_documento,$nruc,htmlspecialchars_decode($razon_social3),htmlspecialchars_decode($nombre_comercial3),htmlspecialchars_decode($domicilio_fiscal3),$departamento,$ciudad,$distrito,$telefono1,$telefono2,htmlspecialchars_decode($email));
			echo $rspta ? "Registro actualizado" : "No se pudo actualizar";
		}
	break;


	case 'eliminar':
		$rspta=$persona->eliminar($idpersona);
 		echo $rspta ? "Persona desactivada" : "Persona no se puede activar";
	break;

	case 'mostrar':
		$rspta=$persona->mostrar($idpersona);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'mostrarClienteVarios':
		$rspta=$persona->mostrarIdVarios();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'desactivar':
		$rspta=$persona->desactivar($idpersona);
 		echo $rspta ? "Persona Desactivado" : "Persona no se puede desactivar";
 		break;


	case 'activar':
		$rspta=$persona->activar($idpersona);
 		echo $rspta ? "Persona activado" : "Persona no se puede activar";
 		break;


	case 'listarp':
		$rspta=$persona->listarp();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<i class="fa fa-pencil" onclick="mostrar('.$reg->idpersona.')" style="color:orange; font-size: 14px;"> </i> '.
 					'   <i class="fa fa-close" onclick="desactivar('.$reg->idpersona.')" style="color:red;"></i> ':

 					'     <i class="fa fa-pencil" onclick="mostrar('.$reg->idpersona.')"></i> '.
 					'     <i class="fa fa-check" onclick="activar('.$reg->idpersona.')" style="color:green;"></i> ',
 					
 				"1"=>$reg->razon_social,
 				"2"=>$reg->numero_documento,
 				"3"=>$reg->telefono1,
 				"4"=>$reg->email,
 				"5"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
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

case 'listarc':
		$rspta=$persona->listarc();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<i class="fa fa-pencil" onclick="mostrar('.$reg->idpersona.')" style="color:orange; font-size:16px;"> </i> '.
 					'   <i class="fa fa-close" onclick="desactivar('.$reg->idpersona.')" style="color:red; font-size:16px;"    ></i> ':

 					'     <i class="fa fa-pencil" onclick="mostrar('.$reg->idpersona.')"></i> '.
 					'     <i class="fa fa-check" onclick="activar('.$reg->idpersona.')" style="color:green;"></i> ',
 					
 				"1"=>htmlspecialchars_decode($reg->razon_social),
 				"2"=>$reg->descripcion,
 				"3"=>$reg->numero_documento,
 				"4"=>$reg->telefono1,
 				"5"=>$reg->email,
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


	 // Carga de tipos de documentos para venta
 case 'selectDepartamento':
require_once "../modelos/Departamento.php";
$departamento = new Departamento(); 
        
        $rspta = $departamento->selectD();
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->iddepartamento . '>' . $reg->nombre . '</option>';
                }
    break;

     // Carga de tipos de documentos para venta
 case 'selectDepartamentoModificar':
require_once "../modelos/Departamento.php";
$departamento = new Departamento(); 
        
        $id=$_GET['id'];
        $rspta = $departamento->selectID($id);
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->iddepartamento . '>' . $reg->nombre . '</option>';
                }
    break;



	case 'selectCiudad':
	require_once "../modelos/Ciudad.php";
	$ciudad = new Ciudad();
		
        $id=$_GET['id'];
        $rspta = $ciudad->selectC($id);
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idciudad . '>' . $reg->nombre . '</option>';

                }
    break;

    case 'selectDistrito':
		require_once "../modelos/Distrito.php";
		$distrito = new Distrito();
        $id=$_GET['id'];
        $rspta = $distrito->selectDI($id);
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->iddistrito . '>' . $reg->nombre . '</option>';

                }
    break;


    case 'ValidarCliente':

    	$ndocumento=$_GET['ndocumento'];
		$rspta=$persona->validarCliente($ndocumento);
		echo json_encode($rspta); // ? "Cliente ya existe": "Documento valido";
		break;


		case 'ValidarProveedor':

    	$ndocumento=$_GET['ndocumento'];
		$rspta=$persona->validarProveedor($ndocumento);
		echo json_encode($rspta); // ? "Cliente ya existe": "Documento valido";
		break;

		case 'selectCliente':
        require_once "../modelos/Persona.php";
        $persona = new Persona();
 
        $rspta = $persona->listarc();
 
        while ($reg = $rspta->fetch_object())
                {
                echo '<option value=' . $reg->idpersona . '>' . $reg->numero_documento . '</option>';
                }
    	break;


    	case 'buscarclienteRuc':
    	$key = $_POST['key'];
		$rspta=$persona->buscarclienteRuc($key);
		echo json_encode($rspta); // ? "Cliente ya existe": "Documento valido";
		break;

		case 'buscarclienteDomicilio':
    	$key = $_POST['key'];
		$rspta=$persona->buscarclientenombre($key);
		echo json_encode($rspta); // ? "Cliente ya existe": "Documento valido";
		break;


		case 'combocliente':
		$rpta=$persona->combocliente();
		while ($reg= $rpta->fetch_object())
		 {
			echo '<option value='.$reg->numero_documento.'>'.$reg->numero_documento.' | '.$reg->nombre_comercial.'</option>';	
		 }
		 break;

		 case 'comboclientenoti':
		$rpta=$persona->combocliente();
		while ($reg= $rpta->fetch_object())
		 {
			echo '<option value='.$reg->idpersona.'>'.$reg->numero_documento.' | '.$reg->nombre_comercial.'</option>';	
		 }
		 break;



}
?>