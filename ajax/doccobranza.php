<?php 
if (strlen(session_id()) < 1) 
  session_start();
 $data=Array();
require_once "../modelos/Doccobranza.php";
require_once "../modelos/Numeracion.php";
require_once "../modelos/Persona.php";
$persona=new Persona();


$doccobranza=new doccobranza();

$idccobranza=isset($_POST["idccobranza"])? limpiarCadena($_POST["idccobranza"]):"";
$idusuario=$_SESSION["idusuario"];
$fecha_emision=isset($_POST["fecha_emision"])? limpiarCadena($_POST["fecha_emision"]):""; 
$idempresa=isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";
$idserie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";
$SerieReal=isset($_POST["SerieReal"])? limpiarCadena($_POST["SerieReal"]):"";
$numero_doccobranza=isset($_POST["numero_doccobranza"])? limpiarCadena($_POST["numero_doccobranza"]):"";
$idnumeracion=isset($_POST["idnumeracion"])? limpiarCadena($_POST["idnumeracion"]):"";
$numeracion=isset($_POST["numeracion"])? limpiarCadena($_POST["numeracion"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$condicion=isset($_POST["condicion"])? limpiarCadena($_POST["condicion"]):"";

$subtotal_producto=isset($_POST["subtotal_doccobranza_producto"])? limpiarCadena($_POST["subtotal_doccobranza_producto"]):"";
$impuesto=isset($_POST["total_igv_producto"])? limpiarCadena($_POST["total_igv_producto"]):"";
$total=isset($_POST["total_final_producto"])? limpiarCadena($_POST["total_final_producto"]):"";

$subtotal_doccobranza_servicio=isset($_POST["subtotal_doccobranza_servicio"])? limpiarCadena($_POST["subtotal_doccobranza_servicio"]):"";
$total_igv_servicio=isset($_POST["total_igv_servicio"])? limpiarCadena($_POST["total_igv_servicio"]):"";
$total_final_servicio=isset($_POST["total_final_servicio"])? limpiarCadena($_POST["total_final_servicio"]):"";
$tarifas=isset($_POST["tarifaS"])? limpiarCadena($_POST["tarifaS"]):"";

$tipo_moneda=isset($_POST["tipo_moneda"])? limpiarCadena($_POST["tipo_moneda"]):"";
$tipo_doc_cli=isset($_POST["tipo_doc_cli"])? limpiarCadena($_POST["tipo_doc_cli"]):"";
$rucCliente=isset($_POST["numero_documento2"])? limpiarCadena($_POST["numero_documento2"]):"";
$dniCliente=isset($_POST["numero_documento"])? limpiarCadena($_POST["numero_documento"]):"";
$RazonSocial=isset($_POST["razon_social2"])? limpiarCadena($_POST["razon_social2"]):"";
$hora=isset($_POST["hora"])? limpiarCadena($_POST["hora"]):"";
$vendedorsitio=isset($_POST["vendedorsitio"])? limpiarCadena($_POST["vendedorsitio"]):"";
$email=isset($_POST["correocli"])? limpiarCadena($_POST["correocli"]):"";
$domicilio_fiscal2=isset($_POST["domicilio_fiscal2"])? limpiarCadena($_POST["domicilio_fiscal2"]):"";
$tipodoccobranza=isset($_POST["tipodoccobranza"])? limpiarCadena($_POST["tipodoccobranza"]):"";
$observacion=isset($_POST["observacion"])? limpiarCadena($_POST["observacion"]):"";
$tcambio=isset($_POST["tcambio"])? limpiarCadena($_POST["tcambio"]):"";
$tipo_moneda=isset($_POST["tipo_moneda"])? limpiarCadena($_POST["tipo_moneda"]):"";
$serienota=$SerieReal."-".$numero_doccobranza;

$otros=isset($_POST["otross"])? limpiarCadena($_POST["otross"]):"";


switch ($_GET["op"]){
    case 'guardaryeditardoccobranza':


if ($tipodoccobranza=='producto') {
    if (empty($idccobranza)){
        $rspta=$doccobranza->insertar($idempresa, $idusuario, $idcliente, $serienota, $tipo_moneda, $fecha_emision, $hora, $tipodoccobranza, $subtotal_producto,  $impuesto, $total, $observacion , $vendedorsitio, $_POST["idarticulo"], $_POST["codigo"], $_POST["cantidad"], $_POST["precio_unitario"], $numero_doccobranza, $idserie, $_POST["descdet"], $_POST["numero_orden_item"]);
            $hora=date("h:i:s");
            echo $rspta ? "doccobranza registrada": "No se pudieron registrar todos los datos de la doccobranza";
        }
   }else{

    if (empty($idccobranza)){

        if ($idcliente=="N"){
        $tipo_doc_ide="1";
         $rspta=$persona->insertardeBoleta(htmlspecialchars_decode($RazonSocial), $tipo_doc_ide, $dniCliente, $domicilio_fiscal2);

        $IdC=$persona->mostrarId();
        //para ultimo registro de cliente
        while ($reg = $IdC->fetch_object())
                {
            $idcl=$reg->idpersona;
                }

        $rspta=$doccobranza->insertar($idempresa, $idusuario, $idcl, $condicion, $fecha_emision, $serienota, $tarifas, $subtotal_doccobranza_servicio , $total_igv_servicio, $otros, '0', $total_final_servicio, $observacion, $tcambio, $tipo_moneda, $tipodoccobranza, $_POST["idserviciobien"], $_POST["codigo"], $_POST["cantidad"], $_POST["valor_unitario"], $_POST["descdet"], $_POST["numero_orden_item"], $numero_doccobranza, $idserie, $email, $domicilio_fiscal2, htmlspecialchars_decode($RazonSocial), $_POST["igvvalorventa"], $_POST["igvitem"], $_POST["vuniitem"], $_POST["valorventa"], $hora);
            echo $rspta ? "doccobranza registrado": "No se pudieron registrar todos los datos de la doccobranza";
        }else{

        $rspta=$doccobranza->insertar($idempresa, $idusuario, $idcliente, $condicion, $fecha_emision, $serienota, $tarifas, $subtotal_doccobranza_servicio , $total_igv_servicio, $otros, '0', $total_final_servicio, $observacion, $tcambio, $tipo_moneda, $tipodoccobranza, $_POST["idserviciobien"], $_POST["codigo"], $_POST["cantidad"], $_POST["valor_unitario"], $_POST["descdet"], $_POST["numero_orden_item"], $numero_doccobranza, $idserie, $email, $domicilio_fiscal2, htmlspecialchars_decode($RazonSocial), $_POST["igvvalorventa"], $_POST["igvitem"], $_POST["vuniitem"], $_POST["valorventa"] , $hora);
            echo $rspta ? "doccobranza registrado": "No se pudieron registrar todos los datos de la doccobranza";
            }
        }


    }

    
    break;


    case 'guardaryeditarTcambio':

            date_default_timezone_set('America/Lima');
            $hoy=date('d/m/Y');

        if (empty($idtcambio))
        {
                    $rspta=$doccobranza->insertarTc($fechatc,$compra, $venta);
                    echo $rspta ? "Tipo de cambio registrado": "No se pudieron registrar el tipo de cambio";
                    }
                else
                    {
                    $rspta=$doccobranza->editarTc($idtcambio, $fechatc,$compra, $venta);
                    echo $rspta ? "Tipo de cambio editado": "No se pudieron editar los datos del tipo de cambio";
        }
    break;
 
    case 'anular':
        $rspta=$doccobranza->anular($idccobranza);
        echo $rspta ? "doccobranza anulada" : "doccobranza no se puede anular";
    break;

    case 'enviarcorreo':
        $rspta=$doccobranza->enviarcorreo($idccobranza, $_SESSION['idempresa']);
        echo $rspta ;
    break;


    case 'actualizarNumero':
            require_once "../Modelos/Numeracion.php";
            $numeracion=new Numeracion();

            $num=$_GET['Num'];
            $idnumeracion=$_GET['Idnumeracion'];
            $rspta=$numeracion->UpdateNumeracion($num, $idnumeracion );
    break;
 
    case 'mostrar':
        $rspta=$doccobranza->mostrar($idccobranza);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;
 
   
    case 'selectCliente':
        require_once "../modelos/Persona.php";
        $persona = new Persona();
 
        $rspta = $persona->listarC();
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';

                }
    break;

    case 'selectClienteDocumento':
        require_once "../modelos/Persona.php";
        $persona = new Persona();
 
        $rspta = $persona->listarC();
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idpersona . '>' . $reg->num_documento . '</option>';

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


     case 'selectSerie':
        require_once "../modelos/Numeracion.php";
        $numeracion = new Numeracion();
 
        $rspta = $numeracion->llenarSeriedoccobranza($idusuario);
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idnumeracion . '>' . $reg->serie . '</option>';

                }
    break; 


    case 'autonumeracion':
    
    $numeracion=new Numeracion();
    $Ser=$_GET['ser'];
     $idempresa=$_GET['idempresa'];
    $rspta=$numeracion->llenarNumerodoccobranza($Ser, $_SESSION['idempresa']);
        while ($reg=$rspta->fetch_object())
        {
        echo $reg->Nnumero;    
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

    //*-Case para cuando se seleccione o busque el nombre del cliente se carge en 
     //en siguiente el numero de documento del cliente*
        case 'llenarnumdocucli':
        require_once "../modelos/Persona.php";
        $persona = new Persona();
        $nomcli=$_GET['nomcli'];  //*-Se recibe de venta.js el parametro-* 
        $rspta = $persona->listarcnom($nomcli);
            while ($reg = $rspta->fetch_object())
                {
            echo '<option value=' . $reg->idpersona . '>' . $reg->num_documento . '</option>';
                }
    break;

    case 'llenarIdcliente1':
        require_once "../modelos/Persona.php";
        $persona = new Persona();
        $numdocu=$_GET['numcli'];  //Se recibe de venta.js el parametro-->
        $rspta = $persona->listarcnumdocu($numdocu);
            while ($reg = $rspta->fetch_object())
                {
            echo $reg->idpersona;
                }
    break;


    case 'llenarIdcliente2':
        require_once "../modelos/Persona.php";
        $persona = new Persona();
        $nomcli=$_GET['nomcli'];  //Se recibe de venta.js el parametro-->
        $rspta = $persona->listarcnom($nomcli);
            while ($reg = $rspta->fetch_object())
                {
            echo $reg->idpersona;
                }
    break;


    case 'listarClientesdoccobranza':
        require_once "../modelos/Persona.php";
        $persona=new Persona();
 
        $rspta=$persona->listarCliVenta();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarCliente('.$reg->idpersona.',\''.$reg->razon_social.'\',\''.$reg->numero_documento.'\',\''.$reg->domicilio_fiscal.'\',\''.$reg->tipo_documento.'\')"><span class="fa fa-plus"></span></button>',

                "1"=>$reg->razon_social,
                "2"=>$reg->numero_documento,
                "3"=>$reg->domicilio_fiscal
                );
        }
        $results = array( 
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
    break;


     case 'listarArticulosdoccobranza':
        $idempresa=$_GET['idempresaA'];
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
 
        $rspta=$articulo->listarActivosVenta($_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalleproducto('.$reg->idarticulo.',\''.$reg->familia.'\',\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.$reg->nombre.'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->unidad_medida.'\' ,\''.$reg->precio_unitario.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->codigo,
                "3"=>$reg->unidad_medida,
                "4"=>$reg->precio_venta,
                "5"=>number_format($reg->stock,2),
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


    case 'listarArticulosservicio':
        require_once "../modelos/Bienservicio.php";
        $bienservicio=new Bienes_inmuebles();
        //$rspta=$bienservicio->listarActivosVentaDC($_SESSION['idempresa']);
        $rspta=$bienservicio->listarActivosVentaDCS();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalleServicio('.$reg->id.',\''.$reg->descripcion.'\',\''.$reg->codigo.'\',\''.$reg->valor.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->descripcion,
                "2"=>$reg->codigo,
                "3"=>$reg->valor
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
        $rspta=$doccobranza->listar($_SESSION['idempresa']);

        $urlCT='../reportes/exDoccobranza.php?id=';
        while ($reg=$rspta->fetch_object()){
        //Vamos a declarar un array
        
        $urlC=''; 


 $stt='';
if ($reg->estado=='5' || $reg->estado=='4') {
    $send=''; $stt='none';
}else{
    $send='none'; }

if ($reg->estado=='3'  ) {
     $stt='none'; }

   //=====================================================================================
        $data[]=array(
           "0"=>     '<a>
                     <i class="fa  fa-cancel"  data-toggle="tooltip" title="Anular documento"  onclick="anular('.$reg->idccobranza.')"> </i>
                     </a>

                     <a target="_blank" href="'.$urlCT.$reg->idccobranza.'">
                     <i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir doccobranza"  style="font-size:18px;" onclick=""> </i>
                     </a>

                        <a>
                          <i class="fa fa-play" data-toggle="tooltip" title="Generar factura"  style="font-size:18px; color:red;" onclick="nuevafactura('.$reg->idccobranza.')" > </i>
                        </a>'
                     ,
                "1"=>$reg->fecha,
                "2"=>$reg->serienumero,
                "3"=>$reg->cliente,
                "4"=>$reg->tipo_moneda,
                "5"=>$reg->total,
                "6"=>$reg->tcambio,
                "7"=>$reg->totalsoles,
                "8"=>$reg->observacion,
                "9"=>($reg->estado=='1')//si esta emitido
                ?'<i style="color:green;"><span>Emitido</span></i>'
                : '<i style="color:#BA4A00;"> <span>Anulado</span></i>'
                );
        }
       
    $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data
        );

        echo json_encode($results);
    break;




     case 'listarClientesdoccobranzaxDoc':
        require_once "../modelos/Persona.php";
        $persona=new Persona();
        $doc=$_GET['doc'];
        $rspta = $persona->buscarClientexDocdoccobranza($doc);
        
        echo json_encode($rspta);
        
        break;

    case 'listarClientesdoccobranzaxDocNuevos':
        require_once "../modelos/Persona.php";
        $persona=new Persona();
        $rspta = $persona->buscarClientexDocdoccobranzaNuevos();
        echo json_encode($rspta);
        
        break;

    case 'mostrarultimocomprobante':
        $rspta = $doccobranza->mostrarultimocomprobante($_SESSION['idempresa']);
        echo json_encode($rspta);
        break;


        case 'estadoDoc':
        $rspta=$doccobranza->mostrarCabFac();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $archivo=$reg->$reg->ruc."-".$reg->tipodoc."-".$reg->numerodoc;
                }
                echo json_encode($archivo);
        break;

    case 'listarArticulosdoccobranzaxcodigo':
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
        $idempresa=$_GET['idempresa'];
        $codigob=$_GET['codigob'];
        $rspta=$articulo->listarActivosVentaxCodigo($codigob, $idempresa);
        echo json_encode($rspta);
    break;

    case 'busquedaPredic':
        require_once "../modelos/doccobranza.php";
        $doccobranza=new doccobranza();
        $buscar = $_POST['b'];
        $rspta=$doccobranza->AutocompletarRuc($buscar);
        echo json_encode($rspta);
    break;

    case 'selectNombreCli':
        require_once "../modelos/Persona.php";
        $persona = new Persona();
        $nombre = $_POST['nombre'];
        $rspta = $persona->listarclienteFact($nombre);
 
        while ($reg = $rspta->fetch_object())
                {
                echo '<option value=' . $reg->idpersona . '>' . $reg->razon_social . '</option>';
                }
    break;

    case 'traerdcobranza':
        $idcobranza=$_GET['iddco'];
        $rspta=$doccobranza->traerdcobranza($idcobranza);
        echo json_encode($rspta);
    break;


     case 'listarDetalledc':
        //Recibimos el idingreso
        $id=$_GET['id'];
 
        $rspta = $doccobranza->listarDetalledc($id);
        $subt=0;
        $igv=0;
        $total=0;
        echo ' 
        <thead style="background-color:#35770c; color: #fff; text-align: justify;">
                                    <th>item</th>
                                    <th>Servicio</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Código</th>
                                    <th>Précio</th>
                                    <th>Valor uni.</th>
                                    <th>Importe </th>
        </thead>';
 
        while ($reg = $rspta->fetch_object())
                {
        echo '<tr class="filas">
        <td><input type="hidden" name="norden[]" id="norden[]" value="'.$reg->norden.'">'.$reg->norden.'</td>
        <td><input type="hidden" name="idarticulof[]" id="idarticulof[]" value="'.$reg->idarticulo.'">'.$reg->nombre.'</td>
        <td><textarea class="" name="descdetf[]" id="descdetf[]" rows="1" cols="10" style="display:none;">'.$reg->descdet.'</textarea>'.$reg->descdet.'</td>
        <td><input type="text"  name="cantidadf[]" id="cantidad[]f" style="display:none;" value="'.$reg->cantidad.'">'.$reg->cantidad.'</td>
        <td><input type="hidden" name="codigof[]" id="codigof[]" value="'.$reg->codigo.'">'.$reg->codigo.'</td>
        <td><input type="hidden" name="preciof[]" id="preciof[]" value="'.$reg->precio.'">'.$reg->precio.'</td>
        <td><input type="hidden" name="valorunitariof[]" id="valorunitariof[]" value="'.$reg->vuniitem.'">
        <input type="hidden" name="igvitem[]" id="igvitem[]" value="'.$reg->igvitem.'">
        <input type="hidden" name="unidad_medida[]" id="unidad_medida[]" value="'.$reg->unidad_medida.'">'.$reg->vuniitem.'</td>
        <td><input type="hidden" name="valorventaf[]" id="valorventaf[]" value="'.$reg->valorventa.'">
        <input type="hidden" name="afeigv3[]" id="afeigv3[]" value="10">
        <input type="hidden" name="afeigv4[]" id="afeigv4[]" value="1000">
        <input type="hidden" name="sumadcto[]" id="sumadcto[]" value="0">'.$reg->valorventa.'</td>
                </tr>';

                    $subt=$reg->neta;
                    $igv=$reg->igv;
                    $total=$reg->total;
                }
        echo ' <tfoot style="vertical-align: center;">
       <tr>
            <td>
                <td></td><td></td><td></td><td></td><td></td>
                <th style="font-weight: bold;  background-color:#A5E393;">Neta: </th>
                <th style="font-weight: bold; background-color:#A5E393;"> <h4 id="subtotalfactura">'.$subt.'</h4></th>

                                    
            </td>
        </tr> 
                                   
                                  <tr>
            <td>
                <td></td><td></td><td></td><td></td><td></td>
                <th style="font-weight: bold;  background-color:#A5E393;">Igv: </th>
                <th style="font-weight: bold; background-color:#A5E393;"> <h4 id="igvfactura">'.$igv.'</h4></th>

                                    
            </td>
        </tr> 

          <tr>
            <td>
                <td></td><td></td><td></td><td></td><td></td>
                <th style="font-weight: bold;  background-color:#A5E393;">Total: </th>
                <th style="font-weight: bold; background-color:#A5E393;"> <h4 id="totalfactura">'.$total.'</h4></th>

                                    
            </td>
        </tr> 

                                    
                   
                    <input type="hidden" name="subtotal_factura" id="subtotal_factura" value="'.$subt.'"> 
                    <input type="hidden" name="total_igv_factura" id="total_igv_factura" value="'.$igv.'">
                    <input type="hidden" name="total_final_factura" id="total_final_factura" value="'.$total.'">
                    <input type="hidden" name="pre_v_u" id="pre_v_u">

 </tfoot>';
    break;



    case 'consultaRucSunat':
        $token = 'apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';
        $nrucc = $_GET['nroucc'];

            // Iniciar llamada a API
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.apis.net.pe/v1/ruc?numero=' . $nrucc,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
                'Referer: https://apis.net.pe/api-ruc',
                'Authorization: Bearer' . $token
              ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // Datos listos para usar
            $datosRucCli = json_decode($response);
            echo json_encode($datosRucCli);
        break;

        case 'consultaDniSunat':
        $token = 'apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';
        $nndnii = $_GET['nrodni'];

            // Iniciar llamada a API
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.apis.net.pe/v1/dni?numero=' . $nndnii,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 2,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
                'Referer: https://apis.net.pe/consulta-dni-api',
                'Authorization: Bearer' . $token
              ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // Datos listos para usar
            $datosDniCli = json_decode($response);
            echo json_encode($datosDniCli);
        break;


         case 'listarClientesboletaxDoc':
        require_once "../modelos/Persona.php";
        $persona=new Persona();
        $doc=$_GET['doc'];
        $rspta = $persona->buscarClientexDocBoleta($doc);
        echo json_encode($rspta);
        
        break;




         
    
        }
?>