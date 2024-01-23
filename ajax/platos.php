<?php 
require_once "../modelos/Platos.php";

$plato=new Plato();

$idplato=isset($_POST["idplato"])? limpiarCadena($_POST["idplato"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$precio=isset($_POST["precio"])? limpiarCadena($_POST["precio"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
//$tipo=isset($_POST["tipop"])? limpiarCadena($_POST["tipop"]):"";
$nombreCategoria=isset($_POST["nombreCategoria"])? limpiarCadena($_POST["nombreCategoria"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/platos/" . $imagen);
			}
		}

		if (empty($idplato)){
			$rspta=$plato->insertar(
				$idcategoria,
				$codigo,
				html_entity_decode($nombre , ENT_QUOTES | ENT_HTML401, 'UTF-8'),
				$precio,
				$imagen,
				$plato
				
				);
			echo $rspta ? "Plato registrado" : "Plato no se pudo registrar, ya existe el código";
		}
		else
		{
			$rspta=$plato->editar(
				$idplato,
				$idcategoria,
				$codigo,
				html_entity_decode($nombre , ENT_QUOTES | ENT_HTML401, 'UTF-8'),
				$precio,
				$imagen,
				$plato
				

				);
			echo $rspta ? "Plato actualizado" : "Plato no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$articulo->desactivar($idarticulo);
 		echo $rspta ? "Artículo Desactivado" : "Artículo no se puede desactivar";
 		break;


	case 'activar':
		$rspta=$articulo->activar($idarticulo);
 		echo $rspta ? "Artículo activado" : "Artículo no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$plato->mostrar($idplato);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;

 	case 'articuloBusqueda':
 		$codigo=$_GET['codigoa'];
		$rspta=$articulo->articuloBusqueda($codigo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
 		



	case 'listar':
		$rspta=$plato->listar();
		$url='../reportes/printbarcode.php?codigopr=';

 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'
 					 <a><i class="fa fa-pencil" onclick="mostrar('.$reg->idplato.')" style="color:orange; 
 					 font-size:22px;" data-toggle="tooltip" title="Editar plato"> </i> </a>
 					 '.
 					'<a><i class="fa fa-close" onclick="desactivar('.$reg->idplato.')" style="color:red; font-size:22px;" data-toggle="tooltip" title="Desactivar plato"></i></a>':

 					'<i class="fa fa-pencil" onclick="mostrar('.$reg->idplato.')"></i> '.
 					' <i class="fa fa-check"  onclick="activar('.$reg->idplato.')" style="color:green; font-size:22px;" data-toggle="tooltip" title="Activar plato"></i>',

 				"1"=>$reg->codigo,
 				"2"=>$reg->nombre,
 				"3"=>$reg->precio,
 				"4"=>"<img src='../files/platos/".$reg->imagen."' height='200px' width='300px' >",
 				"5"=>($reg->estado)?'<span class="label bg-green">A</span> 
 				':
 				'<span class="label bg-red">I</span>'

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;
	
	

	

	case "selectCategoria":
		$rspta=$plato->select();
		while ($reg= $rspta->fetch_object())
		{
			echo '<option value='.$reg->idcategoria.'>'.$reg->nombreCategoria.'</option>';
		}
		break;


		case "selectAlmacen":
		require_once "../modelos/Almacen.php";
		$almacen=new Almacen();
		$idempresa=$_GET['idempresa'];
		$rspta=$almacen->select($idempresa);
		while ($reg= $rspta->fetch_object())
		{
			echo '<option value='.$reg->idalmacen.'>'.$reg->nombre.'</option>';
		}
		break;

		case "selectUnidad":
		require_once "../modelos/Almacen.php";
		$almacen=new Almacen();
		$rspta=$almacen->selectunidad();
		while ($reg= $rspta->fetch_object())
		{
			echo '<option value='.$reg->abre.'>'.$reg->nombre.'</option>';
		}
		break;

		case 'buscararticulo':
    	$key = $_POST['key'];
		$rspta=$articulo->buscararticulo($key);
		echo json_encode($rspta); // ? "Cliente ya existe": "Documento valido";
		break;



		case 'guardaryeditarCategoria':
		if (empty($idcategoria)){
			$rspta=$plato->insertarCategoria($nombreCategoria);
			echo $rspta ? "Categoría registrada" : "Categoría no se pudo registrar";
		}
		else {
			$rspta=$plato->editarCategoria($idcategoria,$nombreCategoria);
			echo $rspta? "Categoría actualizada" : "Categoría no se pudo actualizar";
		}
		break;

		
}
?>