<?php 
require_once "../modelos/Vendedorsitio.php";

$vendedorsitio=new vendedorsitio();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$empresa=isset($_POST["empresa"])? limpiarCadena($_POST["empresa"]):"";



switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id)){
			$rspta=$vendedorsitio->insertar($nombre, $empresa);
			echo $rspta ? "Registrado" : "No registrado";
		}
		else {
			$rspta=$vendedorsitio->editar($id, $nombre, $empresa);
			echo $rspta ? "Editado" : "No editado";
		}
	break;

	case 'desactivar':
		$rspta=$vendedorsitio->desactivar($id);
 		echo $rspta ? "Vendedor Desactivado" : "Vendedor no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$vendedorsitio->activar($id);
 		echo $rspta ? "Vendedor activada" : "Vendedor no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$vendedorsitio->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$idempresa=$_GET['idempresa'];
		$rspta=$vendedorsitio->listar($idempresa);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->id.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
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

	case 'selectVendedorsitio':
		$idempresa=$_GET['idempresa'];
		require_once "../modelos/Vendedorsitio.php";
		$vendedorsitio = new Vendedorsitio(); 
        
        $rspta = $vendedorsitio->select($idempresa);
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->nombre . '>' . $reg->nombre . '</option>';
                }
    break;
}
?>