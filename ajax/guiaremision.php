<?php
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Guiaremision.php";
$gremision=new Guiaremision();
require_once "../modelos/Numeracion.php";
$numeracion = new Numeracion();

$cont=0;
$contNO=1;
$detalle=0;


//Guia de R.
$idempresa=$_SESSION['idempresa'];
$idguia=isset($_POST["idguia"])? limpiarCadena($_POST["idguia"]):"";
$serie=isset($_POST["SerieReal"])? limpiarCadena($_POST["SerieReal"]):"";
$numero=isset($_POST["numero_guia"])? limpiarCadena($_POST["numero_guia"]):"";
$pllegada=isset($_POST["pllegada"])? limpiarCadena($_POST["pllegada"]):"";
$destinatario=isset($_POST["destinatario"])? limpiarCadena($_POST["destinatario"]):"";
$nruc=isset($_POST["nruc"])? limpiarCadena($_POST["nruc"]):"";
$ppartida=isset($_POST["ppartida"])? limpiarCadena($_POST["ppartida"]):"";
$fechat=isset($_POST["fecha_emision"])? limpiarCadena($_POST["fecha_emision"]):"";
$ncomprobante=isset($_POST["numero_comprobante"])? limpiarCadena($_POST["numero_comprobante"]):"";
$ocompra=isset($_POST["ocompra"])? limpiarCadena($_POST["ocompra"]):"";
$motivo=isset($_POST["motivo"])? limpiarCadena($_POST["motivo"]):"";
$idcomprobante=isset($_POST["idcomprobante"])? limpiarCadena($_POST["idcomprobante"]):"";
$idserie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";

$fechatraslado=isset($_POST["fechatraslado"])? limpiarCadena($_POST["fechatraslado"]):"";
$rsocialtransportista=isset($_POST["rsocialtransportista"])? limpiarCadena($_POST["rsocialtransportista"]):"";
$ructran=isset($_POST["ructran"])? limpiarCadena($_POST["ructran"]):"";
$placa=isset($_POST["placa"])? limpiarCadena($_POST["placa"]):"";
$marca=isset($_POST["marca"])? limpiarCadena($_POST["marca"]):"";
$cinc=isset($_POST["cinc"])? limpiarCadena($_POST["cinc"]):"";
$container=isset($_POST["container"])? limpiarCadena($_POST["container"]):"";
$nlicencia=isset($_POST["nlicencia"])? limpiarCadena($_POST["nlicencia"]):"";
$ncoductor=isset($_POST["ncoductor"])? limpiarCadena($_POST["ncoductor"]):"";

$npedido=isset($_POST["npedido"])? limpiarCadena($_POST["npedido"]):"";
$vendedor=isset($_POST["vendedor"])? limpiarCadena($_POST["vendedor"]):"";
$costmt=isset($_POST["costmt"])? limpiarCadena($_POST["costmt"]):"";
$fechacomprobante=isset($_POST["fechacomprobante"])? limpiarCadena($_POST["fechacomprobante"]):"";


$observaciones=isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";
$pesobruto=isset($_POST["pesobruto"])? limpiarCadena($_POST["pesobruto"]):"";
$umedidapbruto=isset($_POST["umedidapbruto"])? limpiarCadena($_POST["umedidapbruto"]):"";
$codtipotras=isset($_POST["codtipotras"])? limpiarCadena($_POST["codtipotras"]):"";

$tipodoctrans=isset($_POST["tipodoctrans"])? limpiarCadena($_POST["tipodoctrans"]):"";
$dniconduc=isset($_POST["dniconduc"])? limpiarCadena($_POST["dniconduc"]):"";

$tipocomprobante=isset($_POST["tipocomprobante"])? limpiarCadena($_POST["tipocomprobante"]):"";
$idpersona=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";

$ubigeopartida=isset($_POST["ubigeopartida"])? limpiarCadena($_POST["ubigeopartida"]):"";
$ubigeollegada=isset($_POST["ubigeollegada"])? limpiarCadena($_POST["ubigeollegada"]):"";

switch ($_GET["op"]){

case 'guardaryeditarGuia':

    if ($tipocomprobante=='04') {
        
        $idarticuloM= $_POST["idarticulo"];
        $CantidadM= $_POST["cantidad"];
        $norden= $_POST["norden"];
        $descrip= $_POST["descdet"];
    }
    else
    {
            $idarticuloM= "";
            $CantidadM="";
             $norden= "";
             $descrip= "";
    }

    if (empty($idguia)){
        $rspta=$gremision->insertar(
            
            $serie,
            $numero, 
            $pllegada, 
            $destinatario, 
            $nruc, 
            $ppartida, 
            $fechat, 
            $ncomprobante, 
            $ocompra, 
            $motivo, 
            $idcomprobante, 
            $idserie, 
            $idempresa, 
            $fechatraslado,
            $rsocialtransportista,
            $ructran,
            $placa,
            $marca,
            $cinc,
            $container,
            $nlicencia,
            $ncoductor,
            $npedido,
            $vendedor,
            $costmt,
            $fechacomprobante,
            $observaciones, 
            $pesobruto,
            $umedidapbruto,
            $codtipotras,
            $tipodoctrans,
            $dniconduc,
            $tipocomprobante,
            $idpersona,
            $ubigeopartida,
            $ubigeollegada,
            $idarticuloM,
            $CantidadM,
            $norden,
            $descrip
        );
                
            echo $rspta ? "Guía registrada" : "No se pudieron registrar todos los datos de la Guía";
        }
        else
        {

        $rspta=$gremision->editarguia(
            $idguia,
            $serie,
            $numero, 
            $pllegada, 
            $destinatario, 
            $nruc, 
            $ppartida, 
            $fechat, 
            $ncomprobante, 
            $ocompra, 
            $motivo, 
            $idcomprobante, 
            $idserie, 
            $idempresa, 
            $fechatraslado,
            $rsocialtransportista,
            $ructran,
            $placa,
            $marca,
            $cinc,
            $container,
            $nlicencia,
            $ncoductor,
            $npedido,
            $vendedor,
            $costmt,
            $fechacomprobante,
            $observaciones, 
            $pesobruto,
            $umedidapbruto,
            $codtipotras,
            $tipodoctrans,
            $dniconduc,
            $tipocomprobante,
            $idpersona,
            $ubigeopartida,
            $ubigeollegada,
            $idarticuloM,
            $CantidadM,
            $norden,
            $descrip);

            echo $rspta ? "Guía Actualizada" : "No se pudieron actualizar todos los datos de la Guía";

        }

    
    break;

    case 'selectSerie':
    $rspta = $numeracion->llenarSerieGuia();
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idnumeracion . '>' . $reg->serie . '</option>';

                }
    break;

    case 'autonumeracion':
    
    $Ser=$_GET['ser'];
    $rspta=$numeracion->llenarNumeroGuia($Ser);
        while ($reg=$rspta->fetch_object())
        {
        echo $reg->Nnumero;    
        }
    break;






    //Listado de comprobantes para el Modal
    case 'listarComprobante':
        $tipp=$_GET['tip'];

        if ($tipp=='01') {
            $rspta=$gremision->buscarComprobante($_SESSION['idempresa']);

                    //Vamos a declarar un array
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarComprobante('.$reg->idfactura.',\''.$reg->tdcliente.'\',\''.$reg->ndcliente.'\',\''.$reg->rzcliente.'\',\''.$reg->domcliente.'\', \''.$reg->tipocomp.'\',\''.$reg->numerodoc.'\',\''.$reg->subtotal.'\',\''.$reg->igv.'\',\''.$reg->total.'\', \''.$reg->fechafactura.'\', \''.$reg->idpersona.'\',  \''.$reg->ubigeocli.'\')"><span class="fa fa-plus"></span></button>',

                "1"=>$reg->fechafactura,
                "2"=>$reg->ndcliente,
                "3"=>$reg->rzcliente,
                "4"=>$reg->domcliente,
                "5"=>$reg->numerodoc,
                "6"=>$reg->subtotal,
                "7"=>$reg->igv,
                "8"=>$reg->total
                );
        }

        }elseif($tipp=='03'){
            $rspta=$gremision->buscarComprobanteBoleta($_SESSION['idempresa']);
                    //Vamos a declarar un array
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarComprobante('.$reg->idboleta.',\''.$reg->tdcliente.'\',\''.$reg->ndcliente.'\',\''.$reg->rzcliente.'\',\''.$reg->domcliente.'\', \''.$reg->tipocomp.'\',\''.$reg->numerodoc.'\',\''.$reg->subtotal.'\',\''.$reg->igv.'\',\''.$reg->total.'\', \''.$reg->fechaboleta.'\' , \''.$reg->idpersona.'\',  \''.$reg->ubigeocli.'\')"><span class="fa fa-plus"></span></button>',

                "1"=>$reg->fechaboleta,
                "2"=>$reg->ndcliente,
                "3"=>$reg->rzcliente,
                "4"=>$reg->domcliente,
                "5"=>$reg->numerodoc,
                "6"=>$reg->subtotal,
                "7"=>$reg->igv,
                "8"=>$reg->total
                );
        }
        




        }else{

        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();

         require_once "../modelos/Rutas.php";
        $rutas = new Rutas();
        $Rrutas = $rutas->mostrar2("1");
        $Prutas = $Rrutas->fetch_object();
        $rutaarti=$Prutas->rutaarticulos; 

        $rspta=$articulo->listarActivos($_SESSION['idempresa']);
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->stock <= $reg->limitestock)?'<label style="color: red;">Limite stock es: </label>'. '<label style="color: red;">'.$reg->limitestock.'</label>'   
                                                : 
                '<button class="btn btn-warning btn-sm" onclick="agregarArticulos('.$reg->idarticulo.',\''.$reg->codigo.'\',\''.htmlspecialchars($reg->nombre).'\',\''.$reg->abre.'\')">
                <span class="fa fa-plus"></span>
                Agregar
                </button>'
            
                ,
                "1"=>$reg->nombre,
                "2"=>$reg->codigo,
                "3"=>$reg->nombreum,
                "4"=> $reg->precio_venta,
                "5"=>$reg->factorconversion,
                "6"=>($reg->imagen=="")? "<img src='../files/articulos/simagen.png' height='60px' width='60px'>":
                "<img  src=".$rutaarti.$reg->imagen." height='60px' width='60px'>"
                );
        }



        }
        $results = array( 
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);

   break;








case 'detalle':

    $idcomp=$_GET['id'];
    $tipocom2=$_GET['tipo2'];

if ($tipocom2=='01') {

      $rsptaf=$gremision->buscarComprobanteId($idcomp);
        $data= Array();
        $item=1;
        echo '<thead>
                                    <th>...</th>
                                    <th>CANTIDAD.</th>
                                    <th>CÓDIGO</th>
                                    <th>NOMBRE</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>UNIDAD MEDIDA</th>
                                    

                      </thead>';
        while ($reg = $rsptaf->fetch_object())
                {
                    $sw=in_array($reg->idfactura, $data);
       
echo ' <tr class="filas" id="fila">
<td></td>

<td><input type="hidden" class="form-control"  name="cantidad" id="cantidad" value="'.$reg->cantidad.'" disabled="true" style="visible:hidden;">
      <span> '.$reg->cantidad.' </span></td>

<td><input type="hidden" name="codigo" id="codigo"  value="'.$reg->codigo.'" class="form-control" disabled="true">
<span> '.$reg->codigo.' </span></td>

<td><input type="hidden" class="form-control"  name="descripcion" id="descripcion" value="'.$reg->descripcion.'" size="20" disabled="true" disabled="true">
<span> '.$reg->descripcion.' </span></td>

<td></td>

<td><input type="hidden" class="form-control"  name="unidad_medida" id="unidad_medida" value="'.$reg->unidad_medida.'" disabled="true" ><span> '.$reg->unidad_medida.' </span>
</td>

        </tr>';
        $item=$item + 1;
                }



}else{


     $rsptaf=$gremision->buscarComprobanteIdBoleta($idcomp);
        $data= Array();
        $item=1;
        echo '<thead>
                                    <th>...</th>
                                    <th>CANTIDAD.</th>
                                    <th>CÓDIGO</th>
                                    <th>NOMBRE</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>UNIDAD MEDIDA</th>
                                    

                      </thead>';
        while ($reg = $rsptaf->fetch_object())
                {
                    $sw=in_array($reg->idboleta, $data);
       
echo ' <tr class="filas" id="fila">
    
    <td></td>

<td><input type="hidden" class="form-control"  name="cantidad" id="cantidad" value="'.$reg->cantidad.'" disabled="true" style="visible:hidden;">
      <span> '.$reg->cantidad.' </span></td>

<td><input type="hidden" name="codigo" id="codigo"  value="'.$reg->codigo.'" class="form-control" disabled="true">
<span> '.$reg->codigo.' </span></td>

<td><input type="hidden" class="form-control"  name="descripcion" id="descripcion" value="'.$reg->descripcion.'" size="20" disabled="true" disabled="true">
<span> '.$reg->descripcion.' </span></td>

<td></td>


<td><input type="hidden" class="form-control"  name="unidad_medida" id="unidad_medida" value="'.$reg->unidad_medida.'" disabled="true" ><span> '.$reg->unidad_medida.' </span></td>

        </tr>';
        $item=$item + 1;
                }


}


      





    break;




case 'listar':
        $stt="";
        $rspta=$gremision->listar($_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            
                $url='../reportes/exGuia.php?id=';
                $url2c='../reportes/exguia2copias.php?id=';
                $urlticket='../reportes/exticketguia.php?id=';

            $data[]=array(
                "0"=>'
                <div class="dropdown">
                <button  class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                :::
                <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-center">

                <li>
                    <a target="_blank" href="'.$url.$reg->idguia.'"><i class="fa fa-print" data-toggle="tooltip" title="Impresión A4"></i>Impresión A4</a>
                </li>


                 <li>
                    <a target="_blank" href="'.$url2c.$reg->idguia.'"><i class="fa fa-print" data-toggle="tooltip" title="Impresión 2 copias"></i>Impresión 2 copias</a>
                </li>

                <li>
                <a target="_blank" href="'.$urlticket.$reg->idguia.'"><i class="fa fa-print" data-toggle="tooltip" title="Impresión ticket"></i>Impresión ticket</a>
                </li>

                <li>
                <a onclick="generarxml('.$reg->idguia.')"><i class="fa fa-certificate"></i>Generar xml</a>
                </li>

               <li>
               <a onclick="enviarxmlS('.$reg->idguia.')"><i class="fa fa-paper-plane"></i>Enviar SUNAT</a>
                </li>

                <li>
                    <a data-toggle="tooltip" title="Editar documento"  
                      onclick="editarguia('.$reg->idguia.')" style="display:'.$stt.'">
                      <i class="fa fa-pencil"></i> Editar guia
                     
                    </a>
                </li>

                <li>
                <a onclick="baja('.$reg->idguia.')"><i class="fa fa-circle"></i>Anular guia</a>
                </li>


                </ul>
                </div>',







                
                "1"=>$reg->fechat,
                "2"=>$reg->snumero,
                "3"=>$reg->destinatario,
                "4"=>$reg->ncomprobante,
                "5"=>($reg->estado=='1') ? '<span class="label bg-orange" data-toggle="tooltip" title="'.$reg->DetalleSunat.'"><i class="fa fa-check"></i></span>': 
                (($reg->estado=='5') ? '<img src="../public/images/sunat.png" data-toggle="tooltip" title="'.$reg->DetalleSunat.'">':
                (($reg->estado=='4') ? '<span class="label bg-brown" data-toggle="tooltip" title="'.$reg->DetalleSunat.'"><i class="fa fa-certificate"></i></span>':                    
                '<span class="label bg-red">Anulada</span>'))

            );
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
 
    break;




    case 'listarGuias':
        //$nrucc=$_GET['ndocli'];
        $rspta=$gremision->listarGuiaFact();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            
            $data[]=array(
                "0"=>'<button class="btn btn-warning" 
                onclick="selguia('.$reg->idguia.')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->snumero,
                "2"=>$reg->fechat
                

            );
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
 
    break;








    
    case 'generarxml':
        $rspta=$gremision->generarxml($idguia, $_SESSION['idempresa']);
        echo json_encode($rspta) ;
    break;

    case 'enviarxmlS':
        $rspta=$gremision->enviarSUN($idguia, $_SESSION['idempresa']);
        echo $rspta;
    break;




    case 'selectDepartamento':

        
        $rspta = $gremision->selectD();
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idDepa . '>' . $reg->departamento . '</option>';
                }
    break;


    case 'selectprovinc':
    
        $id=$_GET['idd'];
        $rspta = $gremision->selectP($id);
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idProv . '>' . $reg->provincia . '</option>';

                }
    break;


     case 'selectDistrito':
        
        $id=$_GET['idc'];
        $rspta = $gremision->selectDI($id);
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idDist . '>' . $reg->distrito . '</option>';

                }
    break;


    case 'datosempresas':
        $rspta=$gremision->datosempresa(1);
        echo json_encode($rspta) ;
    break;

    case 'buscarubigeo':
        $key = $_POST['key'];
        $rspta=$gremision->buscarubigeo($key);
        echo json_encode($rspta); // ? "Cliente ya existe": "Documento valido";
        break;


        case 'editar':
        $rspta=$gremision->editar($idguia);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

        case 'numerof':
        $rspta=$gremision->listarnumerofilas($idguia);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;



        

        case 'listarDetalleguia':
    //Recibimos el idingreso
        $id=$_GET['id'];
        $tipc=$_GET['tp'];
        $nord=1;
        $rspta = $gremision->listarDetalleguia($id, $tipc);

        $dis="";
        $ocu="";

        if ($tipc=="01" || $tipc=="03") {
                 $dis="readonly";
                 $ocu="none";
        }

        echo ' 
                        <thead>
                                    <th>...</th>
                                    <th>CANTIDAD.</th>
                                    <th>CÓDIGO</th>
                                    <th>NOMBRE</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>UNIDAD MEDIDA</th>
                       </thead>';
        while ($reg = $rspta->fetch_object())
                {
                    for($i=0; $i < count($reg); $i++){
        echo '<tr class="filas" id="fila'.$cont.'">
        <td><i class="fa fa-close" onclick="eliminarDetalle('.$cont.')" data-toggle="tooltip" title="Eliminar item"   style="display:'.$ocu.';" ></i>
        <input type="hidden" name="idarticulo[]" value="'.$reg->idarticulo.'"></td>
        <td><input type="text" '. $dis.' name="cantidad[]" id="cantidad[]" value="'.$reg->cantidad.'">
        <input  type="hidden"  name="norden[]" id="norden[]" value="'.$nord.'">
        <input  type="hidden"  name="nordenhi[]" id="nordenhi[]"></td>
        <td><input type="text" '. $dis.' name="codigo[]" id="codigo[]" value="'.$reg->codigo.'"></td>
        <td><input type="text" '. $dis.' name="nombre[]" id="nombre[]" value="'.$reg->nombre.'"></td>
        <td><input type="text" '. $dis.' name="descdet[]" id="descdet[]" value="'.$reg->descdet.'"></td>
        <td><input type="text" '. $dis.' name="abre[]" id="abre[]" value="'.$reg->abre.'"></td>
        </tr>';

                                        }
            $cont++;
            $detalle++;
            $nord++;

                }
                
            break;


            case 'anular':
                $rpta=$gremision->anular($idguia);
                echo $rpta? "Guia de remision anulada" : "Problemas al anular";

            break;


             case 'mostrarultimocomprobanteId':
        $rspta = $gremision->mostrarultimocomprobanteId();
        echo json_encode($rspta);
        break;








  
    
}

?>