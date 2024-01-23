<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Ordenservicio.php";
require_once "../modelos/Numeracion.php";
$oservicio=new Ordenservicio();
//Orden de servicio
$idempresa=isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";
$idusuario=$_SESSION["idusuario"];
$idserie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";
$SerieReal=isset($_POST["SerieReal"])? limpiarCadena($_POST["SerieReal"]):"";
$numero=isset($_POST["numero"])? limpiarCadena($_POST["numero"]):"";

$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$idorden=isset($_POST["idorden"])? limpiarCadena($_POST["idorden"]):"";
$fecha_emision=isset($_POST["fechaemision"])? limpiarCadena($_POST["fechaemision"]):""; 
$formapago=isset($_POST["formapago"])? limpiarCadena($_POST["formapago"]):""; 
$formaentrega=isset($_POST["formaentrega"])? limpiarCadena($_POST["formaentrega"]):""; 
$fechaentrega=isset($_POST["fechaentrega"])? limpiarCadena($_POST["fechaentrega"]):""; 
$anotaciones=isset($_POST["anotaciones"])? limpiarCadena($_POST["anotaciones"]):""; 
$idnumeracion=isset($_POST["idnumeracion"])? limpiarCadena($_POST["idnumeracion"]):"";

$subtotal=isset($_POST["subtotal_factura"])? limpiarCadena($_POST["subtotal_factura"]):"";
$igv=isset($_POST["total_igv"])? limpiarCadena($_POST["total_igv"]):"";
$total=isset($_POST["total_final"])? limpiarCadena($_POST["total_final"]):"";

$numeracion=isset($_POST["numero"])? limpiarCadena($_POST["numero"]):"";
$hora=isset($_POST["hora"])? limpiarCadena($_POST["hora"]):"";

switch ($_GET["op"]){
    case 'guardaryeditarOrden':

        if (empty($idorden)){
        $rspta=$oservicio->insertar($idusuario, $idserie, $SerieReal, $numero, $idproveedor, $fecha_emision, $formapago, $formaentrega, $formaentrega, $idempresa, $fechaentrega, $anotaciones, $subtotal, $igv, $total, $hora, $_POST["idarticulo"], $_POST["descdet"], $_POST["cantidad"], $_POST["valor_unitario"], $_POST["subtotalBD"]);
            $hora=date("h:i:s");
            echo $rspta ? "Orden de servicio registrado": "No se pudieron registrar todos los datos de la orden";
        }
        else{
        }

    
    break;
 
    case 'anular':
        $rspta=$factura->anular($idfactura);
        echo $rspta ? "Factura anulada" : "Factura no se puede anular";
    break;

    case 'mostrar':
        $rspta=$factura->mostrar($idfactura);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;
 
    case 'listarDetalle':
        //Recibimos el idingreso
        $id=$_GET['id'];
 
        $rspta = $factura->listarDetalle($id);
        $subt=0;
        $igv=0;
        $total=0;
        echo ' 
        <thead style="background-color:#A9D0F9">
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th>Subtotal</th>
                                </thead>';
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<tr class="filas"><td>'.$reg->nombre.'</td><td>'.$reg->cantidad_item_12.'</td><td>'.$reg->valor_uni_item_14.'</td><td>'.$reg->valor_venta_item_21.'</td></tr>';

                    $subt=$subt+($reg->valor_venta_item_21);
                    $igv=$igv+($reg->igv_item);
                    $total=$subt+$igv;
                }
        echo ' <tfoot>
                                    <th>SUBTOTAL <h4 id="subtotal">S/.'.$subt.'</h4></th>
                                    <th></th> 
                                    <th>IGV  <h4 id="subtotal">S/.'.$igv.'</h4></th>
                                    <th></th> 
                                    <th>TOTAL  <h4 id="total">S/.'.$total.'</h4></th>
                                    <th></th> 
                                    <th></th>
                               </tfoot>

        ';
    break;
 

    case 'selectSerie':
        require_once "../modelos/Numeracion.php";
        $numeracion = new Numeracion();
 
        $rspta = $numeracion->llenarSerieOrden();
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idnumeracion . '>' . $reg->serie . '</option>';

                }
    break; 
 

 // Carga de tipos de documentos para venta
 case 'selectDocumento':
        require_once "../modelos/Venta.php";
        $venta = new Venta();
 
        $rspta = $venta->listarD();
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->documento . '>' . $reg->documento . '</option>';

                }
    break;

    //Carga de las series deacuerdo al tipo de documento
    case 'selectSerie':
        $tipo=$_GET['tipo'];
        $rspta = $venta->listarS($tipo);
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->serie . '>' . $reg->serie . '</option>';

                }
    break;


    //Carga de los últimos numeros de la numeración de acuerdo a la serie seleccionada
    case 'llenarNumero':
    $tipoC=$_GET['tipoC'];
    $serieC=$_GET['serieC'];
    $rspta = $venta->sumarC($tipoC,$serieC);
            while ($reg = $rspta->fetch_object())
                {
            echo $reg->addnumero;
                }
    break;

     //*-Case para cuando se seleccione o busque numero de documento cliente se carge en 
     //en siguiente campo su nombre.-*
        case 'llenarnombrecli':
        require_once "../modelos/Persona.php";
        $persona = new Persona();
        $numdocu=$_GET['numcli'];  //Se recibe de venta.js el parametro-->
        $rspta = $persona->listarcnumdocu($numdocu);
            while ($reg = $rspta->fetch_object())
                {
            echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
                }


    break;

     case 'listarArticulosfactura':
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
 
        $rspta=$articulo->listarActivosVentaSoloServicio($_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->familia.'\',\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.$reg->nombre.'\',\''.$reg->costo_compra.'\',\''.$reg->stock.'\',\''.$reg->unidad_medida.'\' ,\''.$reg->precio_venta.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->codigo,
                "3"=>$reg->unidad_medida,
                "4"=>$reg->costo_compra,
                "5"=>$reg->stock,
                "6"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;


    case 'listar':

        $rspta=$oservicio->listar();
        //Vamos a declarar un array
        $data= Array();

        $url='../reportes/exOservicio.php?id=';
 
        while ($reg=$rspta->fetch_object()){
            
   //=====================================================================================
        //$client=substr($reg->cliente,0,10);
        $data[]=array(
          // "0"=> ' <button class="btn btn-warning"  onclick="anular('.$reg->idorden.')" data-toggle="tooltip" title="Anular">
          //           <i  class="fa fa-level-down" ></i></button>'
          //           .
                    '<a target="_blank" href="'.$url.$reg->idorden.'"> <button class="btn btn-info" data-toggle="tooltip" title="Imprimir Orden"><i class="fa  fa-print" > </i></button>
                    </a>'
                     ,
                              
                "1"=>$reg->fechaemision,
                "2"=>$reg->serienumero,
                "3"=>$reg->razon_social,
                "4"=>$reg->formapago,
                "5"=>$reg->formaentrega,
                "6"=>$reg->fechaentrega,
                "7"=>$reg->total

                
                );
        }

    $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;



    case 'autonumeracion':
    
    $numeracion=new Numeracion();
    $Id=$_GET['id'];
    $rspta=$numeracion->llenarNumeroOrden($Id);
        while ($reg=$rspta->fetch_object())
        {
        echo $reg->Nnumero;    
        }
    break;

}
?>