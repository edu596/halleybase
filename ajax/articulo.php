<?php 

require_once "../modelos/Articulo.php";



$articulo=new Articulo();



$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$idfamilia=isset($_POST["idfamilia"])? limpiarCadena($_POST["idfamilia"]):"";
$codigo_proveedor=isset($_POST["codigo_proveedor"])? limpiarCadena($_POST["codigo_proveedor"]):"";
$idalmacen=isset($_POST["idalmacen"])? limpiarCadena($_POST["idalmacen"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$unidad_medida=isset($_POST["unidad_medida"])? limpiarCadena($_POST["unidad_medida"]):"";
$costo_compra=isset($_POST["costo_compra"])? limpiarCadena($_POST["costo_compra"]):"";
$saldo_iniu=isset($_POST["saldo_iniu"])? limpiarCadena($_POST["saldo_iniu"]):"";
$valor_iniu=isset($_POST["valor_iniu"])? limpiarCadena($_POST["valor_iniu"]):"";
$saldo_finu=isset($_POST["saldo_finu"])? limpiarCadena($_POST["saldo_finu"]):"";
$valor_finu=isset($_POST["valor_finu"])? limpiarCadena($_POST["valor_finu"]):"";
$stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$comprast=isset($_POST["comprast"])? limpiarCadena($_POST["comprast"]):"";
$ventast=isset($_POST["ventast"])? limpiarCadena($_POST["ventast"]):"";
$portador=isset($_POST["portador"])? limpiarCadena($_POST["portador"]):"";
$merma=isset($_POST["merma"])? limpiarCadena($_POST["merma"]):"";
$valor_venta=isset($_POST["valor_venta"])? limpiarCadena($_POST["valor_venta"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$codigosunat=isset($_POST["codigosunat"])? limpiarCadena($_POST["codigosunat"]):"";
$ccontable=isset($_POST["ccontable"])? limpiarCadena($_POST["ccontable"]):"";
$precio2=isset($_POST["precio2"])? limpiarCadena($_POST["precio2"]):"";
$precio3=isset($_POST["precio3"])? limpiarCadena($_POST["precio3"]):"";



//Nuevos codigos 

$cicbper=isset($_POST["cicbper"])? limpiarCadena($_POST["cicbper"]):"";
$nticbperi=isset($_POST["nticbperi"])? limpiarCadena($_POST["nticbperi"]):"";
$ctticbperi=isset($_POST["ctticbperi"])? limpiarCadena($_POST["ctticbperi"]):"";
$mticbperu=isset($_POST["mticbperu"])? limpiarCadena($_POST["mticbperu"]):"";



//Nuevos codigos 





//N-------------------

$codigott=isset($_POST["codigott"])? limpiarCadena($_POST["codigott"]):"";
$desctt=isset($_POST["desctt"])? limpiarCadena($_POST["desctt"]):"";
$codigointtt=isset($_POST["codigointtt"])? limpiarCadena($_POST["codigointtt"]):"";
$nombrett=isset($_POST["nombrett"])? limpiarCadena($_POST["nombrett"]):"";

//N-----------------------





$lote=isset($_POST["lote"])? limpiarCadena($_POST["lote"]):"";

$marca=isset($_POST["marca"])? limpiarCadena($_POST["marca"]):"";

$fechafabricacion=isset($_POST["fechafabricacion"])? limpiarCadena($_POST["fechafabricacion"]):"";

$fechavencimiento=isset($_POST["fechavencimiento"])? limpiarCadena($_POST["fechavencimiento"]):"";

$procedencia=isset($_POST["procedencia"])? limpiarCadena($_POST["procedencia"]):"";

$fabricante=isset($_POST["fabricante"])? limpiarCadena($_POST["fabricante"]):"";

$registrosanitario=isset($_POST["registrosanitario"])? limpiarCadena($_POST["registrosanitario"]):"";

$fechaingalm=isset($_POST["fechaingalm"])? limpiarCadena($_POST["fechaingalm"]):"";

$fechafinalma=isset($_POST["fechafinalma"])? limpiarCadena($_POST["fechafinalma"]):"";

$proveedor=isset($_POST["proveedor"])? limpiarCadena($_POST["proveedor"]):"";

$seriefaccompra=isset($_POST["seriefaccompra"])? limpiarCadena($_POST["seriefaccompra"]):"";

$numerofaccompra=isset($_POST["numerofaccompra"])? limpiarCadena($_POST["numerofaccompra"]):"";

$fechafacturacompra=isset($_POST["fechafacturacompra"])? limpiarCadena($_POST["fechafacturacompra"]):"";



$limitestock=isset($_POST["limitestock"])? limpiarCadena($_POST["limitestock"]):"";

$tipoitem=isset($_POST["tipoitem"])? limpiarCadena($_POST["tipoitem"]):"";
$factorc=isset($_POST["factorc"])? limpiarCadena($_POST["factorc"]):"";
$umedidacompra=isset($_POST["umedidacompra"])? limpiarCadena($_POST["umedidacompra"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";


$idalmacennarticulo=isset($_POST["idalmacennarticulo"])? limpiarCadena($_POST["idalmacennarticulo"]):"";
$idfamilianarticulo=isset($_POST["idfamilianarticulo"])? limpiarCadena($_POST["idfamilianarticulo"]):"";
$tipoitemnarticulo=isset($_POST["tipoitemnarticulo"])? limpiarCadena($_POST["tipoitemnarticulo"]):"";
$nombrenarticulo=isset($_POST["nombrenarticulo"])? limpiarCadena($_POST["nombrenarticulo"]):"";
$stocknarticulo=isset($_POST["stocknarticulo"])? limpiarCadena($_POST["stocknarticulo"]):"";
$precioventanarticulo=isset($_POST["precioventanarticulo"])? limpiarCadena($_POST["precioventanarticulo"]):"";
$codigonarticulonarticulo=isset($_POST["codigonarticulonarticulo"])? limpiarCadena($_POST["codigonarticulonarticulo"]):"";
$descripcionnarticulo=isset($_POST["descripcionnarticulo"])? limpiarCadena($_POST["descripcionnarticulo"]):"";
$umedidanp=isset($_POST["umedidanp"])? limpiarCadena($_POST["umedidanp"]):"";

$combustible=isset($_POST["combustible"])? limpiarCadena($_POST["combustible"]):"";


	require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2("1");
    $Prutas = $Rrutas->fetch_object();
    $rutaimagen=$Prutas->rutaarticulos; // ru



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

				//move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/" . $imagen);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaimagen.$imagen);

			}

		}



		if (empty($idarticulo)){

			$rspta=$articulo->insertar($idalmacen,
				$codigo_proveedor,
				$codigo,
				html_entity_decode($nombre , ENT_QUOTES | ENT_HTML401, 'UTF-8'),
				$idfamilia,
				$unidad_medida,
				$costo_compra,
				$saldo_iniu,
				$valor_iniu,
				$saldo_finu,
				$valor_finu,
				$stock,
				$comprast,
				$ventast,
				$portador,
				$merma,
				$valor_venta,
				$imagen, //VA IMAGEN
				$codigosunat,
				$ccontable,
				$precio2,
				$precio3,
				$cicbper,
				$nticbperi,
				$ctticbperi,
				$mticbperu,
				$codigott, $desctt, $codigointtt, $nombrett,
				$lote, $marca, $fechafabricacion, $fechavencimiento, $procedencia, $fabricante, $registrosanitario,
				$fechaingalm, $fechafinalma, $proveedor, $seriefaccompra, $numerofaccompra, $fechafacturacompra,
				$limitestock, $tipoitem, $umedidacompra, $factorc, $descripcion,$combustible
				);

			echo $rspta ? "Artículo registrado" : "Error";

		}

		else

		{

			$rspta=$articulo->editar($idarticulo,
				$idalmacen,
				$codigo_proveedor,
				$codigo,
				html_entity_decode($nombre , ENT_QUOTES | ENT_HTML401, 'UTF-8'),
				$idfamilia,
				$unidad_medida,
				$costo_compra,
				$saldo_iniu,
				$valor_iniu,
				$saldo_finu,
				$valor_finu,
				$stock,
				$comprast,
				$ventast,
				$portador,
				$merma,
				$valor_venta,
				$imagen,
				$codigosunat,
				$ccontable,
				$precio2,
				$precio3,
				$cicbper,
				$nticbperi,
				$ctticbperi,
				$mticbperu,
				$codigott, $desctt, $codigointtt, $nombrett,
				$lote, $marca, $fechafabricacion,  $fechavencimiento, $procedencia, $fabricante, $registrosanitario,
				$fechaingalm, $fechafinalma, $proveedor, $seriefaccompra, $numerofaccompra, $fechafacturacompra,
				$limitestock, $tipoitem,  $umedidacompra, $factorc, $descripcion, $combustible

				);

			echo $rspta ? "Artículo actualizado" : "Artículo no se pudo actualizar";

		}

	break;

	case 'guardarnuevoarticulo':

			if (empty($idarticulo)){ 
				$rspta=$articulo->insertar(
				$idalmacennarticulo,
				'',
				$codigonarticulonarticulo,
				html_entity_decode($nombrenarticulo , ENT_QUOTES | ENT_HTML401, 'UTF-8'),
				$idfamilianarticulo,
				$umedidanp,
				'',
				$stocknarticulo,
				'',
				$stocknarticulo,
				'',
				$stocknarticulo,
				'',
				'',
				'',
				'',
				$precioventanarticulo,
				'', //VA IMAGEN
				'',
				'',
				$precioventanarticulo,
				$precioventanarticulo,
				'',
				'',
				'',
				'',
				'', '', '', '',
				'', '', '', '', '', '', '',
				'', '', '', '', '', '',
				'0', $tipoitemnarticulo, $umedidanp, '1', $descripcionnarticulo

				);
			}

			echo $rspta ? "Artículo registrado" : "Error";
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

		$rspta=$articulo->mostrar($idarticulo);

 		//Codificar el resultado utilizando json

 		echo json_encode($rspta);

 		break;





 	case 'mostrarequivalencia':



 		require_once "../modelos/Almacen.php";

		$almacen=new Almacen();

		$idmm=$_GET['iduni'];

		$rspta=$almacen->selectunidadid($idmm);

 		//Codificar el resultado utilizando json

 		echo json_encode($rspta);

 		break;







	case 'validarcodigo':



 		

		$coddd=$_GET['cdd'];

		$rspta=$articulo->validarcodigo($coddd);

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

		$idempresa=$_GET['idempresa'];
		$rspta=$articulo->listar($idempresa);
		$url='../reportes/printbarcode.php?codigopr=';
 		//Vamos a declarar un array

 		$data= Array();



 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'
 				<div class="dropup">
                <button  class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                :::
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-center">
                <li>
                	<a target="_blank" href="'.$url.$reg->codigo.'&st='.$reg->st2.'&pr='.$reg->precio.'"> <i class="fa fa-barcode" data-toggle="tooltip" title="imprimir codigo de barras"></i>Código de barra </a>
                </li>

                <li>
                	<a  onclick="mostrar('.$reg->idarticulo.')"> <i class="fa fa-pencil" style="color:orange;" data-toggle="tooltip" title="Editar artículo"> </i> Editar artículo</a>
                </li>

                <li>
                	<a onclick="desactivar('.$reg->idarticulo.')" >
                	<i class="fa fa-close" style="color:red;" data-toggle="tooltip" title="Desactivar artículo"></i> Desactivar articulo</a>
                </li>

                </ul>
                </div>' :

                '
                <div class="dropup">
                <button  class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                :::
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-center">
                <li>
                	<a target="_blank" href="'.$url.$reg->codigo.'&st='.$reg->st2.'&pr='.$reg->precio.'"> <i class="fa fa-barcode" data-toggle="tooltip" title="imprimir codigo de barras"></i>Código de barra </a>
                </li>

                <li>
                	<a  onclick="mostrar('.$reg->idarticulo.')"> <i class="fa fa-pencil" style="color:orange;" data-toggle="tooltip" title="Editar artículo"> </i> Editar artículo</a>
                </li>

                <li>
                	<a onclick="activar('.$reg->idarticulo.')" >
                	<i class="fa fa-close" style="color:green;" data-toggle="tooltip" title="Activar artículo"></i> Activar articulo</a>
                </li>

                </ul>
                </div>'



 				// <a target="_blank" href="'.$url.$reg->codigo.'&st='.$reg->st2.'&pr='.$reg->precio.'"> <i class="fa fa-barcode" data-toggle="tooltip" title="imprimir codigo de barras"></i> </a>

 				// 	 <i class="fa fa-pencil" onclick="mostrar('.$reg->idarticulo.')" style="color:orange;" data-toggle="tooltip" title="Editar artículo"> </i> 

 			

 					// <i class="fa fa-close" onclick="desactivar('.$reg->idarticulo.')" style="color:red;" data-toggle="tooltip" title="Desactivar artículo"></i>':

 					// '<i class="fa fa-pencil" onclick="mostrar('.$reg->idarticulo.')"></i> '.

 					// ' <i class="fa fa-check"  onclick="activar('.$reg->idarticulo.')" style="color:green;" data-toggle="tooltip" title="Activar artículo"></i>',
                ,



 				"1"=>$reg->nombre,
 				"2"=>$reg->nombreal,
 				"3"=>$reg->codigo,
 				"4"=>$reg->stock,
 				"5"=>$reg->precio,
 				"6"=>$reg->ccontable ,
 				"7"=>($reg->imagen=="")?"<img src='../files/articulos/simagen.png' height='100px' width='120px'>":
 				 "<img src='$rutaimagen$reg->imagen' height='100px' width='120px'>",
 				"8"=>($reg->estado)?'<span class="label bg-green">A</span> 
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



		case 'listarservicios':

		$idempresa=$_GET['idempresa'];
		$rspta=$articulo->listarservicios($idempresa);
		$url='../reportes/printbarcode.php?codigopr=';
 		//Vamos a declarar un array

 		$data= Array();



 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'
 				<div class="dropup">
                <button  class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                :::
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-center">
                <li>
                	<a target="_blank" href="'.$url.$reg->codigo.'&st='.$reg->st2.'&pr='.$reg->precio.'"> <i class="fa fa-barcode" data-toggle="tooltip" title="imprimir codigo de barras"></i>Código de barra </a>
                </li>

                <li>
                	<a  onclick="mostrar('.$reg->idarticulo.')"> <i class="fa fa-pencil" style="color:orange;" data-toggle="tooltip" title="Editar artículo"> </i> Editar artículo</a>
                </li>

                <li>
                	<a onclick="desactivar('.$reg->idarticulo.')" >
                	<i class="fa fa-close" style="color:red;" data-toggle="tooltip" title="Desactivar artículo"></i> Desactivar articulo</a>
                </li>

                </ul>
                </div>' :

                '
                <div class="dropup">
                <button  class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                :::
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-center">
                <li>
                	<a target="_blank" href="'.$url.$reg->codigo.'&st='.$reg->st2.'&pr='.$reg->precio.'"> <i class="fa fa-barcode" data-toggle="tooltip" title="imprimir codigo de barras"></i>Código de barra </a>
                </li>

                <li>
                	<a  onclick="mostrar('.$reg->idarticulo.')"> <i class="fa fa-pencil" style="color:orange;" data-toggle="tooltip" title="Editar artículo"> </i> Editar artículo</a>
                </li>

                <li>
                	<a onclick="activar('.$reg->idarticulo.')" >
                	<i class="fa fa-close" style="color:green;" data-toggle="tooltip" title="Activar artículo"></i> Activar articulo</a>
                </li>

                </ul>
                </div>',

 				"1"=>$reg->nombre,
 				"2"=>$reg->nombreal,
 				"3"=>$reg->codigo,
 				"4"=>$reg->stock,
 				"5"=>$reg->precio,
 				"6"=>$reg->ccontable ,
 				// "7"=>($reg->imagen=="")?"<img src='../files/articulos/simagen.png' height='35px' width='35px'>":
 				// "<img src='$rutaimagen$reg->imagen' height='35px' width='35px'>",
 				"7"=>($reg->estado)?'<span class="label bg-green">A</span> 
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

	



	case 'inventarioValorizado':

		$rspta=$articulo->listar();

 		//Vamos a declarar un array

 		$data= Array();



 		while ($reg=$rspta->fetch_object()){

 			$data[]=array(

 				"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"> <i class="fa fa-pencil"> </i> </button>'.

 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idarticulo.')">   <i class="fa fa-close"></i>   </button>':



 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')">      <i class="fa fa-pencil"></i> </button>'.

 					' <button class="btn btn-primary" onclick="activar('.$reg->idarticulo.')">     <i class="fa fa-check"></i>   </button>',



 				"1"=>$reg->codigo_proveedor,

 				"2"=>$reg->codigo,

 				"3"=>$reg->familia,

 				"4"=>$reg->nombre,

 				"5"=>$reg->stock,

 				"6"=>$reg->precio,

 				

 				"7"=>"<img src='../files/articulos/".$reg->imagen."' height='60px' width='60px' >",

 				"8"=>($reg->estado)?'<span class="label bg-green">A</span>':

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



	case "selectFamilia":
		require_once "../modelos/Familia.php";
		$familia = new Familia();
		$rspta = $familia->select("1");
		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idfamilia . '>' . $reg->descripcion . '</option>';
				}

	break;



	case "selectFamilia":

		require_once "../modelos/Familia.php";

		$familia=new Familia();

		$rspta=$$familia->select();

		while ($reg= $rspta->fetch_object())

		{

			echo '<option value='.$reg->idfamilia.'>'.$reg->nombre.'</option>';

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

			echo '<option value='.$reg->idunidad.'>'.$reg->nombreum.' | '.$reg->abre.'</option>';

		}

		break;



		case 'buscararticulo':

    	$key = $_POST['key'];

		$rspta=$articulo->buscararticulo($key);

		echo json_encode($rspta); // ? "Cliente ya existe": "Documento valido";

		break;



		case "comboarticulo":
		$anor=$_GET['anor'];
		$alm=$_GET['aml'];
		$rpta=$articulo->comboarticulo($anor, $alm);
		while ($reg=$rpta->fetch_object())
		{
			echo '<option value='.$reg->codigo.'>'.$reg->codigo.' | '.$reg->nombre.'     | Año registro: '.$reg->anoregistro.'</option>';
		}
		break;



		case "comboarticulomg":
		$alm=$_GET['aml'];
		$anor=$_GET['anor'];
		$rpta=$articulo->comboarticulo($anor, $alm);
		while ($reg=$rpta->fetch_object())

		{

			echo '<option value='.$reg->idarticulo.'>'.$reg->codigo.' | '.$reg->nombre.'     | Año registro: '.$reg->anoregistro.'</option>';

		}

		break;


		case "comboarticulokardex":
		//$anor=$_GET['anor'];
		$rpta=$articulo->comboarticuloKardex();
		while ($reg=$rpta->fetch_object())
		{
			echo '<option value='.$reg->codigo.'>'.$reg->codigo.' | '.$reg->nombre.'</option>';
		}
		break;



		 











		

}

?>