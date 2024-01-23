<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Factura.php";
require_once "../modelos/Numeracion.php";
$factura=new Factura();

//Factura
$idfactura=isset($_POST["idfactura"])? limpiarCadena($_POST["idfactura"]):"";
//$idusuario="2";
$idusuario=$_SESSION["idusuario"];
$fecha_emision=isset($_POST["fecha_emision"])? limpiarCadena($_POST["fecha_emision"]):""; 
$firma_digital=isset($_POST["firma_digital"])? limpiarCadena($_POST["firma_digital"]):"";
$idempresa=isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$tipo_documento_dc=isset($_POST["tipo_documento_dc"])? limpiarCadena($_POST["tipo_documento_dc"]):"";
$idserie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";
$SerieReal=isset($_POST["SerieReal"])? limpiarCadena($_POST["SerieReal"]):"";
$numero_factura=isset($_POST["numero_factura"])? limpiarCadena($_POST["numero_factura"]):"";
$idnumeracion=isset($_POST["idnumeracion"])? limpiarCadena($_POST["idnumeracion"]):"";
$numeracion=isset($_POST["numeracion"])? limpiarCadena($_POST["numeracion"]):"";
$idcliente=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";
$total_operaciones_gravadas_codigo=isset($_POST["total_operaciones_gravadas_codigo"])? limpiarCadena($_POST["total_operaciones_gravadas_codigo"]):"";
$total_operaciones_gravadas_monto=isset($_POST["subtotal_factura"])? limpiarCadena($_POST["subtotal_factura"]):"";
$sumatoria_igv_1=isset($_POST["total_igv"])? limpiarCadena($_POST["total_igv"]):"";
$sumatoria_igv_2=isset($_POST["total_igv"])? limpiarCadena($_POST["total_igv"]):"";
$total_icbper=isset($_POST["total_icbper"])? limpiarCadena($_POST["total_icbper"]):""; // NUEVO *BOLSAS TOTAL DE MONTO*
$codigo_tributo_3=isset($_POST["codigo_tributo_h"])? limpiarCadena($_POST["codigo_tributo_h"]):"";
$nombre_tributo_4=isset($_POST["nombre_tributo_h"])? limpiarCadena($_POST["nombre_tributo_h"]):"";
$codigo_internacional_5=isset($_POST["codigo_internacional_5"])? limpiarCadena($_POST["codigo_internacional_5"]):"";
$importe_total_venta=isset($_POST["total_final"])? limpiarCadena($_POST["total_final"]):"";
$tipo_documento_guia=isset($_POST["tipo_documento_guia"])? limpiarCadena($_POST["tipo_documento_guia"]):"";
$codigo_leyenda_1=isset($_POST["codigo_leyenda_1"])? limpiarCadena($_POST["codigo_leyenda_1"]):"";
$descripcion_leyenda_2=isset($_POST["descripcion_leyenda_2"])? limpiarCadena($_POST["descripcion_leyenda_2"]):"";
$version_ubl=isset($_POST["version_ubl"])? limpiarCadena($_POST["version_ubl"]):"";
$version_estructura=isset($_POST["version_estructura"])? limpiarCadena($_POST["version_estructura"]):"";
$tipo_moneda=isset($_POST["tipo_moneda"])? limpiarCadena($_POST["tipo_moneda"]):"";
$tasa_igv=isset($_POST["tasa_igv"])? limpiarCadena($_POST["tasa_igv"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
$codigo_precio=isset($_POST["codigo_precio"])? limpiarCadena($_POST["codigo_precio"]):"";
$tipodocuCliente=isset($_POST["tipo_documento_cliente"])? limpiarCadena($_POST["tipo_documento_cliente"]):"";
$rucCliente=isset($_POST["numero_documento2"])? limpiarCadena($_POST["numero_documento2"]):"";
$RazonSocial=isset($_POST["razon_social2"])? limpiarCadena($_POST["razon_social2"]):"";
$numero_guia=isset($_POST["numero_guia"])? limpiarCadena($_POST["numero_guia"]):"";
$hora=isset($_POST["hora"])? limpiarCadena($_POST["hora"]):"";
$guia_remision_29_2=isset($_POST["guia_remision_29_2"])? limpiarCadena($_POST["guia_remision_29_2"]):"";
$vendedorsitio=isset($_POST["vendedorsitio"])? limpiarCadena($_POST["vendedorsitio"]):"";
$email=isset($_POST["correocli"])? limpiarCadena($_POST["correocli"]):"";
$domicilio_fiscal2=isset($_POST["domicilio_fiscal2"])? limpiarCadena($_POST["domicilio_fiscal2"]):"";
$tdescuento=isset($_POST["total_dcto"])? limpiarCadena($_POST["total_dcto"]):"";
//$nombre_tributo=isset($_POST["nombre_tributo_4_p"])? limpiarCadena($_POST["nombre_tributo_4_p"]):"";

//Datos de tipo de cambio
$tcambio=isset($_POST["tcambio"])? limpiarCadena($_POST["tcambio"]):"";
$fechatc=isset($_POST["fechatc"])? limpiarCadena($_POST["fechatc"]):"";
$compra=isset($_POST["compra"])? limpiarCadena($_POST["compra"]):"";
$venta=isset($_POST["venta"])? limpiarCadena($_POST["venta"]):"";
$idemp=isset($_POST["idemp"])? limpiarCadena($_POST["idemp"]):"";

$idtcambio=isset($_POST["idtcambio"])? limpiarCadena($_POST["idtcambio"]):"";

$idcaja=isset($_POST["idcaja"])? limpiarCadena($_POST["idcaja"]):"";
$idcajai=isset($_POST["idcajai"])? limpiarCadena($_POST["idcajai"]):"";
$idcajas=isset($_POST["idcajas"])? limpiarCadena($_POST["idcajas"]):"";


$fechacaja=isset($_POST["fechacaja"])? limpiarCadena($_POST["fechacaja"]):"";
$montoi=isset($_POST["montoi"])? limpiarCadena($_POST["montoi"]):"";
$montof=isset($_POST["montof"])? limpiarCadena($_POST["montof"]):"";






$ipagado=isset($_POST["ipagado_final"])? limpiarCadena($_POST["ipagado_final"]):"";
$saldo=isset($_POST["saldo_final"])? limpiarCadena($_POST["saldo_final"]):"";
$tipopago=isset($_POST["tipopago"])? limpiarCadena($_POST["tipopago"]):"";
$nroreferencia=isset($_POST["nroreferencia"])? limpiarCadena($_POST["nroreferencia"]):"";

$tipofactura=isset($_POST["tipofactura"])? limpiarCadena($_POST["tipofactura"]):"";

//---- datos del documnto de cobranza ----//
$fedc=isset($_POST["fecemifa"])? limpiarCadena($_POST["fecemifa"]):"";
$SerieRealdc=isset($_POST["SerieRealfactura"])? limpiarCadena($_POST["SerieRealfactura"]):"";
$numero_facturadc=isset($_POST["numero_factura"])? limpiarCadena($_POST["numero_factura"]):"";
$idseriedc=isset($_POST["seriefactura"])? limpiarCadena($_POST["seriefactura"]):"";
$idclientef=isset($_POST["idclientef"])? limpiarCadena($_POST["idclientef"]):"";
$subtotalfactura=isset($_POST["subtotal_factura"])? limpiarCadena($_POST["subtotal_factura"]):"";
$totaligv=isset($_POST["total_igv_factura"])? limpiarCadena($_POST["total_igv_factura"]):"";
$totalfactura=isset($_POST["total_final_factura"])? limpiarCadena($_POST["total_final_factura"]):"";
$tipomonedafactura=isset($_POST["tipo_moneda_factura"])? limpiarCadena($_POST["tipo_moneda_factura"]):"";
$tipodocucli=isset($_POST["tipodocucli"])? limpiarCadena($_POST["tipodocucli"]):"";
$nrodoccli=isset($_POST["numero_documento_factura"])? limpiarCadena($_POST["numero_documento_factura"]):"";
$razonsf=isset($_POST["razon_socialnfactura"])? limpiarCadena($_POST["razon_socialnfactura"]):"";
$horaf=isset($_POST["horaf"])? limpiarCadena($_POST["horaf"]):"";
$correocliente=isset($_POST["correocliente"])? limpiarCadena($_POST["correocliente"]):"";
$domfiscal=isset($_POST["domicilionfactura"])? limpiarCadena($_POST["domicilionfactura"]):"";
$tcambiofactura=isset($_POST["tcambiofactura"])? limpiarCadena($_POST["tcambiofactura"]):"";
$tipopagonfactura=isset($_POST["tipopagonfactura"])? limpiarCadena($_POST["tipopagonfactura"]):"";
$nroreferenciaf=isset($_POST["nroreferenciaf"])? limpiarCadena($_POST["nroreferenciaf"]):"";
$idempresa2=isset($_POST["idempresa2"])? limpiarCadena($_POST["idempresa2"]):"";

$tipofacturacoti=isset($_POST["tipofacturacoti"])? limpiarCadena($_POST["tipofacturacoti"]):"";


$idcotizacion=isset($_POST["idcotizacion"])? limpiarCadena($_POST["idcotizacion"]):"";

$ccuotas=isset($_POST["ccuotas"])? limpiarCadena($_POST["ccuotas"]):"";
$fechavecredito=isset($_POST["fechavecredito"])? limpiarCadena($_POST["fechavecredito"]):"";
$montocuota=isset($_POST["montocuota"])? limpiarCadena($_POST["montocuota"]):"";

$otroscargos=isset($_POST["otroscargos"])? limpiarCadena($_POST["otroscargos"]):"";

$tadc=isset($_POST["tadc"])? limpiarCadena($_POST["tadc"]):"";
$transferencia=isset($_POST["trans"])? limpiarCadena($_POST["trans"]):"";


$fechavenc=isset($_POST["fechavenc"])? limpiarCadena($_POST["fechavenc"]):""; 

$rete=isset($_POST["rete"])? limpiarCadena($_POST["rete"]):""; 
$porcret=isset($_POST["porcret"])? limpiarCadena($_POST["porcret"]):""; 

$tiporete=isset($_POST["tiporete"])? limpiarCadena($_POST["tiporete"]):""; 


$idfactu1=isset($_POST["idfactu1"])? limpiarCadena($_POST["idfactu1"]):""; 
$idfactu2=isset($_POST["idfactu2"])? limpiarCadena($_POST["idfactu2"]):""; 
$serier=isset($_POST["serier"])? limpiarCadena($_POST["serier"]):""; 


// INGRESO Y SALIDA 

$idconceptoi=isset($_POST["conceptoi"])? limpiarCadena($_POST["conceptoi"]):"";
$idconceptos=isset($_POST["conceptos"])? limpiarCadena($_POST["conceptos"]):"";
$conceptoin=isset($_POST["conceptoin"])? limpiarCadena($_POST["conceptoin"]):"";
$montoin=isset($_POST["montoin"])? limpiarCadena($_POST["montoin"]):"";
$fechain=isset($_POST["fechain"])? limpiarCadena($_POST["fechain"]):"";



$conceptosal=isset($_POST["conceptosal"])? limpiarCadena($_POST["conceptosal"]):"";
$montosal=isset($_POST["montosal"])? limpiarCadena($_POST["montosal"]):"";
$fechasal=isset($_POST["fechasal"])? limpiarCadena($_POST["fechasal"]):"";

$cont=0;
$contNO=1;
$detalle=0;

$IdConcepto=isset($_POST["Nom_Concepto"])? limpiarCadena($_POST["Nom_Concepto"]):"";
$Fecha_Mov_Con=isset($_POST["Fecha_Mov_Con"])? limpiarCadena($_POST["Fecha_Mov_Con"]):"";
$Monto_Mov=isset($_POST["Monto_Mov"])? limpiarCadena($_POST["Monto_Mov"]):"";
$ObseMov=isset($_POST["ObseMov"])? limpiarCadena($_POST["ObseMov"]):"";

//$OpcionMovGI=$_POST["btnMov"];
$OpcionMovGI=isset($_POST["OptMov"])? limpiarCadena($_POST["OptMov"]):"";
$egresoMovimiento=$_POST["egresoMovimiento"];




switch ($_GET["op"]){
    case 'guardaryeditarFactura':

        if (empty($idfactura)){
        $rspta=$factura->insertar($idusuario, $fecha_emision, $firma_digital, $idempresa, $tipo_documento, $numeracion, $idcliente, $total_operaciones_gravadas_codigo, $total_operaciones_gravadas_monto, $sumatoria_igv_1, $sumatoria_igv_2, $codigo_tributo_3, $nombre_tributo_4, $codigo_internacional_5, $importe_total_venta, $tipo_documento_guia, $guia_remision_29_2, $codigo_leyenda_1, $descripcion_leyenda_2, $version_ubl, $version_estructura, $tipo_moneda, $tasa_igv, $_POST["idarticulo"], $_POST["numero_orden_item"], $_POST["cantidad"], $_POST["codigo_precio"], $_POST["pvt"], $_POST["igvBD2"], $_POST["igvBD2"], $_POST["afectacionigv"], $_POST["codigotributo"], '', '', $_POST["igvBD"], $_POST["valor_unitario"], $_POST["subtotalBD"], $_POST["codigo"] , $_POST["unidad_medida"], $idserie, $SerieReal, $numero_factura, $tipodocuCliente,  $rucCliente , htmlspecialchars_decode($RazonSocial), $hora, $_POST["sumadcto"], $vendedorsitio, htmlspecialchars_decode($email), htmlspecialchars_decode($domicilio_fiscal2), $_POST["codigotributo"], $tdescuento, $tcambio, $tipopago, $nroreferencia, $ipagado, $saldo, $_POST["descdet"], $total_icbper, $tipofactura, $_POST["cantidadreal"],'', 
            $ccuotas, $fechavecredito, $montocuota, $otroscargos , $tadc, $transferencia, 
            $_POST["ncuotahiden"], $_POST["montocuotacre"], $_POST["fechapago"], $fechavenc, $rete, $porcret, $tiporete);
                
            $hora=date("h:i:s");
                
            echo $rspta;// ? "Se guardo correctamente" : "No se guardo factura";
        }
        else{
        }
   
    break;



    case 'guardaryeditarfacturadc':

        if (empty($idfactura)){
        $rspta=$factura->insertar($idusuario, $fedc, '', $idempresa2, '01', '', $idclientef, '1001', $subtotalfactura, $totaligv, $totaligv, '1000', 'IGV', 'VAT', $totalfactura, '-', '-', '1000', '-', '2.0', '1.0', $tipomonedafactura, '0.18', $_POST["idarticulof"], $_POST["norden"], $_POST["cantidadf"], '01', $_POST["valorunitariof"], $_POST["igvitem"], $_POST["igvitem"], $_POST["afeigv3"], $_POST["afeigv4"], '', '', $_POST["igvitem"], $_POST["preciof"], $_POST["valorventaf"], $_POST["codigof"] , $_POST["unidad_medida"], $idseriedc, $SerieRealdc, $numero_facturadc, $tipodocucli,  $nrodoccli , htmlspecialchars_decode($razonsf), $horaf, $_POST["sumadcto"], '', htmlspecialchars_decode($correocliente), htmlspecialchars_decode($domfiscal), '1000', '', $tcambiofactura, $tipopago, $nroreferenciaf, '', '', $_POST["descdetf"], '', '','','', $ccuotas, '', '', '' , 
            $tadc, $transferencia, $_POST["ncuotahiden"], $_POST["montocuotacre"], $_POST["fechapago"], $fedc);
                
           // $hora=date("h:i:s");
                
            echo $rspta ? "Factura registrada desde documento de cobranza": "No se pudieron registrar todos los datos de la factura";
        }
        else{
        }
   
    break;


        case 'guardaryeditarfacturaCoti':

        if (empty($idfactura)){
        $rspta=$factura->insertar($idusuario, $fedc, '', $idempresa2, '01', '', $idclientef, '1001', $subtotalfactura, $totaligv, $totaligv, '1000', 'IGV', 'VAT', $totalfactura, '-', '-', '1000', '-', '2.0', '1.0', $tipomonedafactura, '0.18', $_POST["idarticulof"], $_POST["norden"], $_POST["cantidadf"], '01', $_POST["valorunitariof"], $_POST["igvitem"], $_POST["igvitem"], $_POST["afeigv3"], $_POST["afeigv4"], '', '', $_POST["igvitem"], $_POST["preciof"], $_POST["valorventaf"], $_POST["codigof"] , $_POST["unidad_medida"], $idseriedc, $SerieRealdc, $numero_facturadc, $tipodocucli,  $nrodoccli , htmlspecialchars_decode($razonsf), $horaf, $_POST["sumadcto"], '', htmlspecialchars_decode($correocliente), htmlspecialchars_decode($domfiscal), '1000', '', $tcambiofactura, $tipopago, $nroreferenciaf, '', '', $_POST["descdetf"], '', $tipofacturacoti, $_POST["cantidadreal"], $idcotizacion, 
            $ccuotas, '', '', '' , $tadc, $transferencia, $_POST["ncuotahiden"], $_POST["montocuotacre"], $_POST["fechapago"], $fedc);
                
           // $hora=date("h:i:s");
                
            echo $rspta ? "Factura registrada desde cotización": "No se pudieron registrar todos los datos de la factura";
        }
        else{
        }
   
    break;


    case 'guardaryeditarTcambio':

            date_default_timezone_set('America/Lima');
              $hoy=date('d/m/Y');
             //$hoy=date('Y/m/d');

        if (empty($idtcambio))
        {
                    $rspta=$factura->insertarTc($fechatc,$compra, $venta, $idemp);
                    echo $rspta ? "Tipo de cambio registrado": "No se pudieron registrar el tipo de cambio";
                    }
                else
                    {
                    $rspta=$factura->editarTc($idtcambio, $fechatc,$compra, $venta, $idemp);
                    echo $rspta ? "Tipo de cambio editado": "No se pudieron editar los datos del tipo de cambio";
        }
    break;


    case 'guardaryeditarCaja':

              date_default_timezone_set('America/Lima');
              $hoy=date('d/m/Y');
              $estado=$_GET['estadocc'];


        if (empty($idcaja))
            {
                $rspta=$factura->insertarCaja($fechacaja,$montoi, $montof, $_SESSION['idempresa']);
                echo $rspta ? "Caja registrada": "No se pudieron registrar datos de la caja";     

                }
                else
                {
                 if ($estado=='0') {
                    $rspta=$factura->editarCaja($idcaja, $fechacaja, $montoi, $montof, '1', $_SESSION['idempresa']);
                    echo $rspta ? "Caja abierta": "No se pudieron editar los datos de la caja";
                        }else{
                    $rspta=$factura->editarCaja($idcaja, $fechacaja, $montoi, $montof, '0', $_SESSION['idempresa']);
                    echo $rspta ? "Caja Cerrada": "No se pudieron editar los datos de la caja";
       
                        }
            }
    break;









    case 'guardaringreso':
              
                    $rspta=$factura->registraringreso($idcajai, $idconceptoi, $conceptoin, $montoin, $fechain);
                    echo $rspta ? "Se registro ingreso": "No se pudo registrar el ingreso";
        
    break;

    case 'guardarsalida':
              
                    $rspta=$factura->registrarsalida($idcajas, $idconceptos, $conceptosal, $montosal, $fechasal);
                    echo $rspta ? "Se registro salida": "No se pudo registrar la salida";
        
    break;

 
    case 'anular':
        $rspta=$factura->anular($idfactura);
        echo $rspta ? "Factura anulada" : "Factura no se puede anular";
    break;

    case 'enviarcorreo':
        $idf=$_GET['idfact'];
        $correo=$_GET['ema'];
        $rspta=$factura->enviarcorreo($idf, $correo);
        echo $rspta ;
    break;
 

    case 'traercorreocliente':
        $idfacc=$_GET['iddff'];
        $rspta=$factura->traercorreocliente($idfacc);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;



    case 'generarxml':
        $rspta=$factura->generarxml($idfactura, $_SESSION['idempresa']);
        echo json_encode($rspta) ;
    break;

    case 'regenerarxml':
        $rspta=$factura->regenerarxml($idfactura,  $_SESSION['idempresa']);
        echo json_encode($rspta) ;
        break;


    case 'mostrarxml':
        $rspta=$factura->mostrarxml($idfactura, $_SESSION['idempresa']);

        if ($rspta=="") {
            $rspta="No se ha creado";
        }
        echo json_encode($rspta) ;
    break;

    case 'mostrarrpta':
        $rspta=$factura->mostrarrpta($idfactura, $_SESSION['idempresa']);
        echo json_encode($rspta) ;
    break;

    case 'enviarxmlSUNAT':
        $rspta=$factura->enviarxmlSUNAT($idfactura, $_SESSION['idempresa']);
        echo $rspta ;
    break;


    case 'consultarcdr':
        $rspta=$factura->reconsultarcdr($idfactura, $_SESSION['idempresa']);
        echo $rspta ;
    break;


    case 'enviarxmlSUNATbajas':
        $rspta=$factura->enviarxmlSUNATbajas($idfactura,  $_SESSION['idempresa']);
        echo $rspta ;
        break;


     case 'downFtp':
        $rspta=$factura->downftp($idfactura, $_SESSION['idempresa']);
        echo json_encode($rspta);
    break;

    case 'ftp':
       $rspta=$factura->ftp();
        echo $rspta ;
    break;

    case 'baja':
        $com=$_GET['comentario'];
        $hor=$_GET['hora'];
        date_default_timezone_set('America/Lima');
       //$hoy=date('Y/m/d');
        $hoy = date("Y-m-d"); 
        $rspta=$factura->baja($idfactura,$hoy,$com, $hor);
        echo $rspta ? "La factura esta de baja y anulada" : "Factura no se dar de baja";
    break;

    case 'actualizarNumero':
            require_once "../Modelos/Numeracion.php";
            $numeracion=new Numeracion();

            $num=$_GET['Num'];
            $idnumeracion=$_GET['Idnumeracion'];
            $rspta=$numeracion->UpdateNumeracion($num, $idnumeracion );
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

    case 'selectSerie':
        require_once "../modelos/Numeracion.php";
        $numeracion = new Numeracion();
 
        $rspta = $numeracion->llenarSerieFactura($idusuario);
 
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


    case 'listarClientesfactura':
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


     case 'listarArticulosfactura':

        require_once "../modelos/Rutas.php";
        $rutas = new Rutas();
        $Rrutas = $rutas->mostrar2("1");
        $Prutas = $Rrutas->fetch_object();
        $rutaarti=$Prutas->rutaarticulos; 

        
        $tmm=$_GET['itm'];
        $tpff=$_GET['tipof'];
        $tipoprecioa=$_GET['tipoprecioaa'];
        $almacen=$_GET['alm'];
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();



           if ($tmm=='0') {
            $rspta=$articulo->listarActivosVentaumventa($_SESSION['idempresa'], $tpff, $almacen, $tipoprecioa);
        $data= Array();
        while ($reg=$rspta->fetch_object()){

            $data[]=array(

                // "0"=>'<input type="number" inputmode="decimal" id="cantisuge[]" name="cantisuge[]" value="1" OnFocus="focusTest(this);">',
                
                // "1"=>'<input type="number" inputmode="decimal" id="preciosuge[]" name="preciosuge[]" onchange="converprecanti();" value="'.$reg->precio_venta.'" OnFocus="focusTest(this);">
                // <input type="hidden" id="preciosugeO[]" name="preciosugeO[]" value="'.$reg->precio_venta.'">',

                "0"=>($reg->stock <= $reg->limitestock)?'<label style="color: red;">Limite stock es: </label>'. '<label style="color: red;">'.$reg->limitestock.'</label>'   
                                                : 
                '<button class="btn btn-warning btn-circle" onclick="agregarDetalle(0,'.$reg->idarticulo.',\''.$reg->familia.'\',\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.htmlspecialchars($reg->nombre).'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->abre.'\' ,\''.$reg->precio_unitario.'\',\''.$reg->cicbper.'\', \''.$reg->mticbperu.'\'  , \''.$reg->factorconversion.'\' , \''.$reg->factorc.'\',  \''.$reg->nombreum.'\' , 
                \''.str_replace ("\r\n", " ", $reg->descrip).'\', 
                \''.$reg->tipoitem.'\',
                \''.$reg->combustible.'\')">
                <span class="fa fa-plus"></span>
                </button>'
            .
            '<button class="btn btn-success btn-circle" onclick="agregarDetalle(1,'.$reg->idarticulo.',\''.$reg->familia.'\',\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.htmlspecialchars($reg->nombre).'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->abre.'\' ,\''.$reg->precio_unitario.'\',\''.$reg->cicbper.'\', \''.$reg->mticbperu.'\'  , \''.$reg->factorconversion.'\' , \''.$reg->factorc.'\',  \''.$reg->nombreum.'\' , 
                \''.str_replace ("\r\n", " ", $reg->descrip).'\', \''.$reg->tipoitem.'\', \''.$reg->combustible.'\')">
                <span class="fa fa-outdent"></span>
                </button>'
                ,
                "1"=>$reg->nombre,
                "2"=>$reg->codigo,
                "3"=>($reg->combustible=='1')? 
                '<span class="fa-solid fa-gas-pump" style="color:red;">'.$reg->nombreum.'</span>':$reg->nombreum,
                "4"=> $reg->precio_venta,
                "5"=>$reg->factorconversion,
                "6"=>($reg->imagen=="")? "<img src='../files/articulos/simagen.png' height='60px' width='60px'>":
                "<img  src=".$rutaarti.$reg->imagen." height='60px' width='60px'>"
                );
        }

         }else{

            $rspta=$articulo->listarActivosVentaumcompra($_SESSION['idempresa'], $tpff, $almacen, $tipoprecioa);
                $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->stock <= $reg->limitestock)?'<label style="color: red;">Limite stock es: </label>'. '<label style="color: red;">'.$reg->limitestock.'</label>'   
                                                : 
                '<button class="btn btn-warning btn-sm" onclick="agregarDetalleItem('.$reg->idarticulo.',\''.$reg->familia.'\',\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.htmlspecialchars($reg->nombre).'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->abre.'\' ,\''.$reg->precio_unitario.'\',\''.$reg->cicbper.'\', \''.$reg->mticbperu.'\' , \''.$reg->factorconversion.'\' , \''.$reg->factorc.'\' , \''.str_replace ("\r\n", " ", $reg->descrip).'\',  \''.$reg->factorconversion.'\')">
                <span class="fa fa-plus"></span>
                </button>',
                "1"=>$reg->nombre,
                "2"=>$reg->codigo,
                "3"=>$reg->nombreum,
                "4"=> $reg->precio_venta,
                "5"=>$reg->stock,
                "6"=>($reg->imagen=="")?"<img src='../files/articulos/simagen.png' height='120' width='120px'>":
                "<img src='../files/articulos/".$reg->imagen."' height='120px' width='120px'>"
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










    case 'listarArticulosfacturaItem':
        //$idempresa=$_GET['idempresaA'];
        $tipoprecio=$_GET['tipoprecio'];
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
        switch ($tipoprecio) {
            case '1':
            $rspta=$articulo->listarActivosVenta($_SESSION['idempresa']);
                break;
            case '2':
            $rspta=$articulo->listarActivosVenta2($_SESSION['idempresa']);
                break;
            case '3':
            $rspta=$articulo->listarActivosVenta3($_SESSION['idempresa']);
                break;
            default:
                break;
        }
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalleItem('.$reg->idarticulo.',\''.$reg->familia.'\',\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.htmlspecialchars($reg->nombre).'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->unidad_medida.'\' ,\''.$reg->precio_unitario.'\',\''.$reg->cicbper.'\', \''.$reg->mticbperu.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->codigo,
                "3"=>$reg->unidad_medida,
                "4"=> $reg->precio_venta,
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
        require_once "../modelos/Articulo.php";
        $bienservicio=new Articulo();
        $rspta=$bienservicio->listarActivosVentaSoloServicio($_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();
        while ($reg=$rspta->fetch_object()){
             $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalleItem('.$reg->idarticulo.',\''.$reg->familia.'\',\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.htmlspecialchars($reg->nombre).'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->unidad_medida.'\' ,\''.$reg->precio_unitario.'\',\''.$reg->cicbper.'\', \''.$reg->mticbperu.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->codigo,
                "3"=>$reg->unidad_medida,
                "4"=> $reg->precio_venta,
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



 case 'listarArticulosNC':
       require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
         $idempresa=$_GET['idempresa'];
        $rspta=$articulo->listarActivosVentaumventa($idempresa);
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->familia.'\',\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.$reg->nombre.'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->unidad_medida.'\' ,\''.$reg->precio_unitario.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->codigo,
                "3"=>$reg->unidad_medida,
                "4"=>$reg->precio_venta,
                "5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
                
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;



    case 'envioautomatico':
        $idempr=$_SESSION['idempresa'];
        $rspta=$factura->listar($_SESSION['idempresa']);
        
        while ($reg=$rspta->fetch_object()){
            if ($reg->estado=='1') {
                //Validar si existe el archivo firmado
                $factura->generarxml($reg->idfactura, $_SESSION['idempresa']);
            }elseif ($reg->estado=='4'){
                $factura->enviarxmlSUNAT($reg->idfactura, $_SESSION['idempresa']);
            }
        }

    break;




    

    case 'listar':
    //$idempr=$_GET['idempresa'];
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($_SESSION['idempresa']);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta ENVIO
    $rutarpta=$Prutas->rutarpta; // ruta de la carpeta RESPUESTA

    //Agregar=====================================================
    // Ruta del directorio donde están los archivos
        
        $path  = $rutaenvio; 
        $pathFirma=$rutafirma;
        $pathRpta  = $rutarpta; 
        // Arreglo con todos los nombres de los archivos
        $files = array_diff(scandir($path), array('.', '..')); 
        $filesFirma = array_diff(scandir($pathFirma), array('.', '..')); 
        $files2 = array_diff(scandir($pathRpta), array('.', '..')); 
        //=============================================================

        $rspta=$factura->listar($_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();

        $urlT='../reportes/exTicketFactura.php?id=';
        $urlF='../reportes/exFactura.php?id=';
        $urlC='../reportes/exFacturaCompleto.php?id=';
 
        while ($reg=$rspta->fetch_object()){
            if($reg->tipo_documento_07=='Ticket'){
               $url='../reportes/exTicketFactura.php?id=';
           }else{
               $url='../reportes/exFactura.php?id=';
            }
    //==============Agregar====================================================
    $archivo=$reg->numero_ruc."-".$reg->tipo_documento_07."-".$reg->numeracion_08;
    $archivo2="R".$reg->numero_ruc."-".$reg->tipo_documento_07."-".$reg->numeracion_08;
    $fileBaja=$reg->numero_ruc."-RA".$reg->fechabaja."-011";
    $rptaSunat=$reg->CodigoRptaSunat;

    
$stt='';
$vs='';
$sunatFirma=''; 
$sunatAceptado='Class'; 

$estadoenvio='1';

$mon="";
if ($reg->moneda=="USD")
{
$mon='<i style="color:green;" data-toggle="tooltip" title="Por T.C. '.$reg->tcambio.' = '.$reg->valordolsol.' PEN">$</i>';
}


$fpago="";
if ($reg->formapago=="Credito")
{
$fpago='<i style="color:red;" data-toggle="tooltip" title="Comprobante al crédito">Cred.</i>';
}



   
   //=====================================================================================
        //$client=substr($reg->cliente,0,10);
        $data[]=array(
          "0"=> 
          '<div class="dropdown">
                <button  class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                :::
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-center">
                
                <li>
            <a  onclick="actguia('.$reg->idfactura.')"> 
            <i class="fa fa-handshake-o"  data-toggle="tooltip" title="Dar de baja" onclick=""></i>Actualizar N° guia
            </a>



                     <a  onclick="baja('.$reg->idfactura.')" style="display:'.$vs.';  color:red;"> 
                   <i class="fa fa-level-down"  data-toggle="tooltip" title="Dar de baja" onclick=""></i>Dar de baja
                    </a>

                <a onclick="duplicarf('.$reg->idfactura.')"  style="color:green;"  data-toggle="tooltip" title="Duplicar factura" '.$stt.'">
                  <i  class="fa fa-files-o"></i>
                  Duplicar factura
                  </a>


                  <a onclick="duplicarfr('.$reg->idfactura.')"  style="color:green;"  data-toggle="tooltip" title="Duplicar x rangos idfactura" '.$stt.'">
                  <i  class="fa fa-files-o"></i>
                  Duplicar x rangos
                  </a>


                  <a onclick="crearnoti('.$reg->idfactura.')">
                  <i  class="fa fa-bell"></i>
                  Crear notificación
                  </a>



                  
                  </li>

                  <li>
                  <a  onclick="prea42copias2('.$reg->idfactura.')"> 
                   <i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir formato 2 copias" onclick=""></i>
                   Imprimir formato 2 copias
                    </a>
                    </i>

                   <li>
                  <a  onclick="preticket258mm('.$reg->idfactura.')"><i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir Ticket 50mm"> </i>
                  Ticket 58mm
                     </a>
                  </li>


                  
                  <li>
                  <a  onclick="preticket280mm('.$reg->idfactura.')"><i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir Ticket 80mm"> </i>
                  Ticket 80mm
                     </a>

                  </li>


                   <li>
                 <a onclick="prea4completo2('.$reg->idfactura.')"><i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir formato completo"> </i>Imprimir formato completo
                     </a>
                  </li>

                   <li>
                 <a onclick="enviarcorreo('.$reg->idfactura.')"><i class="fa  fa-send"  data-toggle="tooltip" title=""> </i>Enviar por correo
                     </a>
                  </li>

                 


                </ul>
                </div>',
                              
                "1"=>$reg->fecha,
                "2"=>$reg->cliente,
                "3"=>$reg->vendedorsitio,
                "4"=>$reg->numeracion_08,
                "5"=>$reg->importe_total_venta_27." ".$mon." ".$fpago,
                "6"=>($reg->tarjetadc=='1')?'<img src="../files/articulos/tarjetadc.png" width="20px" 
                data-toggle="tooltip" title="TARJETA '.$reg->montotarjetadc.'">':'',
                "7"=>($reg->transferencia=='1')?'<img src="../files/articulos/transferencia.png" width="20px" data-toggle="tooltip" title="BANCO '.$reg->montotransferencia.'">':'',

                //Actualizado ===============================================
                "8"=>($reg->estado=='1')//si esta emitido
                ?'<span style="color:#BA4A00;">'.$reg->DetalleSunat.'</span>'
            : (($reg->estado=='4')    ?'<span style="color:#239B56;">'.$reg->DetalleSunat.'</span>' //si esta firmado

            : (($reg->estado=='3' )?'<span style="color:#E59866;">'.$reg->DetalleSunat.'</span>' // si esta de baja

            : (($reg->estado=='0')?'<span style="color:#E59866;">c/nota</span>'  //si esta firmado

            : (($reg->estado=='5')?'<span style="color:#145A32;">'.$reg->DetalleSunat.'</span>' // Si esta aceptado por SUNAT

    : '<span style="color:#239B56;">'.$reg->DetalleSunat.'</span>' )))),

            //Opciones de envio
            "9"=>

            '<div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                Opciones
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-right">
                  <li>
                   <a onclick="generarxml('.$reg->idfactura.')" '.$sunatFirma.'="class_a_href"><i class="fa fa-download"  style="color:orange; font-size:18px;" data-toggle="tooltip" title="Generar xml"></i>Generar xml</a>
                  </li>


                  <li>
                    <a onclick="enviarxmlSUNAT('.$reg->idfactura.')" ><i class="fa fa-send"  style="color:red; font-size:18px;" data-toggle="tooltip" title="Enviar a SUNAT" ></i>Enviar a SUNAT</a>
                  </li>


                  <li>
                    <a onclick="mostrarxml('.$reg->idfactura.')"><i class="fa fa-check" style="color:orange; font-size:18px;"  data-toggle="tooltip" title="Mostrar XML"></i>Mostrar XML</a>
                  </li>

                   <li>
                   <a onclick="mostrarrpta('.$reg->idfactura.')"><i class="fa fa-check" style="color:green; font-size:18px;"  data-toggle="tooltip" title="Mostrar respuesta CDR"></i>Mostrar respuesta</a>
                  </li>

                  <li>
                   <a href="https://n9.cl/fo5y" target=_blank >  <img src="../public/images/sunat.png" style="color:green; font-size:18px;"  data-toggle="tooltip" title="Consulta de validez con SUNAT"></i>Consulta de validez</a>
                  </li>


                 <li>
                    <a onclick="consultarcdr('.$reg->idfactura.')" ><i class="fa fa-refresh"  style="color:red; font-size:18px;" data-toggle="tooltip" title="Enviar a SUNAT" ></i>Reconsultar a SUNAT</a>
                  </li>

                  <li>
                    <a onclick="cambiartarjetadc('.$reg->idfactura.')" ><i class="fa fa-credit-card"></i> Cambiar a tarjeta</a>
                  </li>

                  <li>
                    <a onclick="montotarjetadc('.$reg->idfactura.')" ><i class="fa fa-money"></i> Modificar monto tarjeta </a>
                  </li>


                  <li>
                    <a onclick="cambiartransferencia('.$reg->idfactura.')" ><i class="fa fa-exchange"></i> Cambiar a transferencia </a>
                  </li>

                  <li>
                    <a onclick="montotransferencia('.$reg->idfactura.')" ><i class="fa fa-money"></i> Modificar monto transferencia </a>
                  </li>



                   </ul>
                </div>',
                "10"=>'<a data-toggle="tooltip" title="Generar guia" onclick="generarguia('.$reg->idfactura.')"  ><i class="fa fa-car" style="color:red; font-size:24px;"></i></a>
                <a data-toggle="tooltip" title="Impresion por defecto" onclick="tipoimpresionxfactura('.$reg->idfactura.')"  ><i class="fa fa-file-pdf-o" style="color:green; font-size:24px;"></i></a> 
                '
                );
        } //Fin While

    $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;


    

    case 'listarValidar':

        $ano=$_GET['ano'];
        $mes=$_GET['mes'];
        $dia=$_GET['dia'];
        //$idempresa=$_GET['idempresa'];

    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($_SESSION['idempresa']);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta ENVIO
    $rutarpta=$Prutas->rutarpta; // ruta de la carpeta RESPUESTA

    //Agregar=====================================================
    // Ruta del directorio donde están los archivos
        
        $path  = $rutaenvio; 
        $pathFirma=$rutafirma;
        $pathRpta  = $rutarpta; 
        // Arreglo con todos los nombres de los archivos
        $files = array_diff(scandir($path), array('.', '..')); 
        $filesFirma = array_diff(scandir($pathFirma), array('.', '..')); 
        $files2 = array_diff(scandir($pathRpta), array('.', '..')); 
        //=============================================================

        $rspta=$factura->listarValidar($ano, $mes, $dia, $_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();

        $urlT58mm='../reportes/exTicketFactura58mm.php?id=';
        $urlT80mm='../reportes/exTicketFactura80mm.php?id=';
        $urlF='../reportes/exFactura.php?id=';
        $urlC='../reportes/exFacturaCompleto.php?id=';
 
        while ($reg=$rspta->fetch_object()){
            if($reg->tipo_documento_07=='Ticket'){
               $url='../reportes/exTicketFactura.php?id=';
           }else{
               $url='../reportes/exFactura.php?id=';
            }
    //==============Agregar====================================================
    $archivo=$reg->numero_ruc."-".$reg->tipo_documento_07."-".$reg->numeracion_08;
    $archivo2="R".$reg->numero_ruc."-".$reg->tipo_documento_07."-".$reg->numeracion_08;
    $fileBaja=$reg->numero_ruc."-RA".$reg->fechabaja."-011";




 $stt='';
 $vs='';
 $sunatFirma=''; 
 $sunatAceptado='Class'; 


 if ($reg->estado=='5') { // ACEPTADO PO SUNAT
     $send='';
     $stt='';
     $sunatFirma='class';
     $sunatAceptado='class';  
   
 }
 else if ($reg->estado=='4' )
 {
     $send='';
     $stt='';
     $sunatFirma='class';
     $sunatAceptado='';  
 }
 else
 {
     $send='none';
 }


if ($reg->estado=='3') {
     $stt='disabled';
     $vs='none'; 
     $sunat='';
     $sunatFirma='class';  
}

if ($reg->estado=='0') {
     $stt='none'; 
     
     $sunat=''; 
}

$estadoenvio='1';

$mon="";
if ($reg->moneda=="USD")
{
$mon='<i style="color:green;" data-toggle="tooltip" title="T.C. '.$reg->tcambio.' = '.$reg->valordolsol.' PEN">$</i>';
}


$fpago="";
if ($reg->formapago=="Credito")
{
$fpago='<i style="color:red;" data-toggle="tooltip" title="Comprobante al crédito">Cred.</i>';
}

   
   //=====================================================================================
        //$client=substr($reg->cliente,0,10);
        $data[]=array(
          "0"=>

          '
          <input type="hidden" name="idoculto[]" id="idoculto[]" value="'.$reg->idfactura.'">
          <input type="hidden" name="estadoocu[]" id="estadoocu[]" value="'.$reg->estado.'">

          <div class="dropup">
                <button  class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                :::
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-center">
                <li>
                   <a  onclick="baja('.$reg->idfactura.')" style="display:'.$vs.';  color:red;"> 
                   <i class="fa fa-level-down"  data-toggle="tooltip" title="Dar de baja" onclick=""></i>Dar de 
                   baja
                    </a>
                  
                  </li>

                  <li>
                  <a target="_blank" href="'.$url.$reg->idfactura.'"> 
                   <i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir formato 2 copias" onclick=""></i>
                   Imprimir formato 2 copias
                    </a>

                   <li>
                  <a  target="_blank" href="'.$urlT58mm.$reg->idfactura.'"><i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir Ticket"> </i>
                  Imprimir Ticket 58mm
                     </a>
                  </li>

                  <li>
                  <a  target="_blank" href="'.$urlT80mm.$reg->idfactura.'"><i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir Ticket"> </i>
                  Imprimir Ticket 80mm
                     </a>
                  </li>


                   <li>
                 <a target="_blank" href="'.$urlC.$reg->idfactura.'"><i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir formato completo"> </i>Imprimir formato completo
                     </a>
                  </li>

                   <li>
                 <a onclick="enviarcorreo('.$reg->idfactura.')"><i class="fa  fa-send"  data-toggle="tooltip" title=""> </i>Enviar por correo
                     </a>
                  </li>


                </ul>
                </div>'

          
                     ,
                              
                "1"=>$reg->fecha,
                "2"=>$reg->cliente,
                "3"=>$reg->vendedorsitio,
                "4"=>$reg->numeracion_08,
                "5"=>$reg->importe_total_venta_27." ".$mon." ".$fpago,

                "6"=>($reg->tarjetadc=='1')?'<img src="../files/articulos/tarjetadc.png" width="20px" 
                data-toggle="tooltip" title="TARJETA '.$reg->montotarjetadc.'">':'',
                "7"=>($reg->transferencia=='1')?'<img src="../files/articulos/transferencia.png" width="20px" data-toggle="tooltip" title="BANCO '.$reg->montotransferencia.'">':'',

                //Actualizado ===============================================
               "8"=>($reg->estado=='1')//si esta emitido
                ?'<span style="color:#BA4A00;">'.$reg->DetalleSunat.'</span>'
            : (($reg->estado=='4')    ?'<span style="color:#239B56;">'.$reg->DetalleSunat.'</span>' //si esta firmado

            : (($reg->estado=='3' )?'<span style="color:#E59866;">'.$reg->DetalleSunat.'</span>' // si esta de baja

            : (($reg->estado=='0')?'<span style="color:#E59866;">c/nota</span>'  //si esta firmado

            : (($reg->estado=='5')?'<span style="color:green;">'.$reg->DetalleSunat.'</span>' // Si esta aceptado por SUNAT

    : '<span style="color:#239B56;">'.$reg->DetalleSunat.'</span>' )))),

            //Opciones de envio
            "9"=>

             '<div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                Opciones
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-right">
                  <li>
                   <a onclick="generarxml('.$reg->idfactura.')" ><i class="fa fa-download"  style="color:orange; font-size:18px;" data-toggle="tooltip" title="Generar xml"></i>Generar xml</a>
                  </li>


                  <li>
                    <a onclick="enviarxmlSUNAT('.$reg->idfactura.')"  '.$sunatAceptado.'="class_a_href" ><i class="fa fa-send"  style="color:red; font-size:18px;" data-toggle="tooltip" title="Enviar a SUNAT" ></i>Enviar a SUNAT</a>
                  </li>


                  <li>
                    <a onclick="mostrarxml('.$reg->idfactura.')"><i class="fa fa-check" style="color:orange; font-size:18px;"  data-toggle="tooltip" title="Mostrar XML"></i>Mostrar XML</a>
                  </li>

                   <li>
                   <a onclick="mostrarrpta('.$reg->idfactura.')"><i class="fa fa-check" style="color:green; font-size:18px;"  data-toggle="tooltip" title="Mostrar respuesta CDR"></i>Mostrar respuesta</a>
                  </li>

                   <li>
                   <a onclick="regenerarxml('.$reg->idfactura.')" ><i class="fa fa-retweet"  style="color:black; font-size:14px;" data-toggle="tooltip" title="Regenerar xml docuemntos de baja"></i>Regenerar xml</a>
                  </li>

                  <li>
                   <a onclick="enviarxmlSUNATbajas('.$reg->idfactura.')"><i class="fa fa-send"  style="color:black; font-size:18px;" data-toggle="tooltip" title="Enviar a SUNAT documentos de baja" > </i>Reenviar xml</a>
                  </li>

                  <li>
                   <a href="https://n9.cl/fo5y" target=_blank >  <img src="../public/images/sunat.png" style="color:green; font-size:18px;"  data-toggle="tooltip" title="Consulta de validez con SUNAT"></i>Consulta de validez</a>
                  </li>

                  <li>
                    <a onclick="consultarcdr('.$reg->idfactura.')" ><i class="fa fa-refresh"  style="color:red; font-size:18px;" data-toggle="tooltip" title="Enviar a SUNAT" ></i>Reconsultar a SUNAT</a>
                  </li>

                  <li>
                    <a onclick="cambiartarjetadc('.$reg->idfactura.')" ><i class="fa fa-credit-card" style="color:blue;"></i> Cambiar a tarjeta</a>
                  </li>

                  <li>
                    <a onclick="montotarjetadc('.$reg->idfactura.')" ><i class="fa fa-money" style="color:blue;"></i> Modificar monto tarjeta </a>
                  </li>


                  <li>
                    <a onclick="cambiartransferencia('.$reg->idfactura.')" ><i class="fa fa-exchange" style="color:green;"></i> Cambiar a transferencia </a>
                  </li>

                  <li>
                    <a onclick="montotransferencia('.$reg->idfactura.')" ><i class="fa fa-money" style="color:green;"></i> Modificar monto transferencia </a>
                  </li>



                   </ul>
                </div>'              
            ,

              "10"=>($reg->estado=='1' || $reg->estado=='4' )?'<input type="checkbox"  id="chid[]"  name="chid[]">':'<input type="checkbox"  id="chid[]"  name="chid[]" style="display:none;"> '
                //Actualizado ===============================================
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
    $Ser=$_GET['ser'];
    //$idempresa=$_GET['idempresa'];
    $rspta=$numeracion->llenarNumeroFactura($Ser);
        while ($reg=$rspta->fetch_object())
        {
        echo $reg->Nnumero;    
        }
    break;


     case 'listarClientesfacturaxDoc':
        require_once "../modelos/Persona.php";
        $persona=new Persona();
        $doc=$_GET['doc'];
        $rspta = $persona->buscarClientexDocFactura($doc);
        
        echo json_encode($rspta);
        
        break;


        case 'listarClientesliqui':
        require_once "../modelos/Persona.php";
        $persona=new Persona();
        $doc=$_GET['doc'];
        $rspta = $persona->buscarClientes($doc);
        echo json_encode($rspta);
        break;



    case 'listarClientesfacturaxDocNuevos':
        require_once "../modelos/Persona.php";
        $persona=new Persona();
        $rspta = $persona->buscarClientexDocFacturaNuevos();
        echo json_encode($rspta);
        
        break;

    case 'mostrarultimocomprobante':
        $rspta = $factura->mostrarultimocomprobante($_SESSION['idempresa']);
        echo json_encode($rspta);
        break;


    case 'mostrarultimocomprobanteId':
        $rspta = $factura->mostrarultimocomprobanteId($_SESSION['idempresa']);
        echo    json_encode($rspta);
        break;


    case 'enviarcorreoultimocomprobante':
        $rspta = $factura->enviarUltimoComprobantecorreo($_SESSION['idempresa']);
        echo $rspta;
        break;


        case 'estadoDoc':
        $rspta=$factura->mostrarCabFac();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $archivo=$reg->$reg->ruc."-".$reg->tipodoc."-".$reg->numerodoc;
                }
                echo json_encode($archivo);
        break;

    case 'listarArticulosfacturaxcodigo':
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
        //$idempresa=$_GET['idempresa'];
        $codigob=$_GET['codigob'];
        $tipre=$_GET['tipp'];
        $rspta=$articulo->listarActivosVentaxCodigo($codigob, $tipre);
        echo json_encode($rspta);
    break;

    case 'busquedaPredic':
        require_once "../modelos/Factura.php";
        $factura=new Factura();
        $buscar = $_POST['b'];
        $rspta=$factura->AutocompletarRuc($buscar);
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


   

        case 'uploadFtp':
        $rspta=$factura->uploadFtp($idfactura);
        echo $rspta;
    break;

        case 'listarDR':

        $ano=$_GET['ano'];
        $mes=$_GET['mes'];
        //$idempresa=$_GET['idempresa'];

        $rspta=$factura->listarDR($ano, $mes, $_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
        $data[]=array(
                "0"=>$reg->fecha,
                "1"=>$reg->numerofactura,
                "2"=>$reg->cliente,
                "3"=>$reg->ruccliente,
                "4"=>$reg->opgravada,
                "5"=>$reg->igv,
                "6"=>$reg->total,
                "7"=>$reg->fechabaja,
                "8"=>($reg->estado=='0')
                ?'<i style="color:#BA4A00;"  > <span>NOTA</span></i>': '<i  style="color:#E59866;" > <span>BAJA</span></i>',

                "9"=>$reg->vendedorsitio,
                "10"=>($reg->estado=='0')
                ?'<button class="btn btn-warning"  onclick="ConsultaDR('.$reg->idfactura.')"> <i class="fa fa-eye" data-toggle="tooltip" title="Ver documento" ></i> </button>':''
            );
    }
    $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
        break;

        case 'listarDRdetallado':
        $id = $_GET['idcomp'];
        $idempresa = $_GET['idempresa'];
        //$idcomp = '28';
        $rspta=$factura->listarDRdetallado($id, $idempresa);
        $data= Array();

        while ($reg=$rspta->fetch_object()){
        $data[]=array(
                "0"=>($reg->codigo_nota=='07')
                ?'<i style="color:#BA4A00;"  > <span>NOTA DE CRÉDITO</span></i>': '<i  style="color:#E59866;" > <span>NOTA DE DEBITO</span></i>',
                "1"=>$reg->numero,
                "2"=>$reg->fecha,
                "3"=>$reg->motivo,
                "4"=>$reg->subtotal,
                "5"=>$reg->igv,
                "6"=>$reg->total
            );
    }
    $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
        break;

        case 'selectTributo':
        require_once "../modelos/Factura.php";
        $factura = new Factura(); 
        
        $rspta = $factura->tributo();
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->codigo . '>' . $reg->descripcion . '</option>';
                }
        break;





        case 'selectAlmacen':
        require_once "../modelos/Factura.php";
        $factura = new Factura(); 
        
        $rspta = $factura->almacenlista();
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idalmacen . '>' . $reg->nombre . '</option>';
                }
        break;






        case 'tcambiodia':
        require_once "../modelos/Consultas.php";
        $consulta = new Consultas(); 
        
         date_default_timezone_set('America/Lima');
         $hoy=date('Y/m/d');
         
        $rspta = $consulta->mostrartipocambio($hoy);
        while ($reg = $rspta->fetch_object())
                {
                    echo $reg->venta;
                }
        break;


        case 'tcambiodiaCompra':
        require_once "../modelos/Consultas.php";
        $consulta = new Consultas(); 
        
         date_default_timezone_set('America/Lima');
         $hoy=date('Y/m/d');
         
        $rspta = $consulta->mostrartipocambio($hoy);
        while ($reg = $rspta->fetch_object())
                {
                    echo $reg->compra;
                }
        break;


        case 'listarcaja':
        $rspta=$factura->listarcaja($_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();
        $urlCT='../reportes/reporteie.php?idccaajja=';
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>$reg->idcaja,
                "1"=>$reg->fecha,
                "2"=>$reg->montoi,
                "3"=>$reg->montof,
                "4"=>$reg->estado,
    "5"=>'<a onclick="montoi596('.$reg->idcaja.')" data-toggle="tooltip" title="Asignar valor al monto inicial"><i class="fa fa-plus"></i></a>'.
    '  <a target="_blank" href="'.$urlCT.$reg->idcaja.'">'.
    '<i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir ingresos y egresos del día"  onclick=""></i>
     </a>'.
     '  <a onclick="recalculardia('.$reg->idcaja.')" data-toggle="tooltip" title="Recalcular movimientos del día"><i class="fa fa-refresh"></i></a>'


                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;


    case 'listarvalidarcaja':
        $fff1=$_GET['ff1'];
        $fff2=$_GET['ff2'];
        

        $rspta=$factura->listarValidarcaja($fff1, $fff2);
        $data= Array();
        while ($reg=$rspta->fetch_object()){
          $data[]=array(    
                "0"=>$reg->idis,
                "1"=>$reg->fecha,
                "2"=>$reg->monto,
                "3"=>$reg->concepto,
                "4"=>($reg->tipo=='INGRESO')
                ?'<i style="color:green;"> <span>INGRESO</span></i>': '<i  style="color:red;" > <span>SALIDA</span></i>'
                 );
        }
    $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);


    break;


    case 'selectunidadmedida':
        require_once "../modelos/Consultas.php";
        $consulta = new Consultas();
 
        $rspta = $consulta->selectumedida();
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->abre . '>' . $reg->nombreum . '</option>';

                }
    break;


    case 'selectunidadmedidanuevopro':
        require_once "../modelos/Consultas.php";
        $consulta = new Consultas();
 
        $rspta = $consulta->selectumedida();
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idunidad . '>' . $reg->nombreum ." | ".$reg->abre. '</option>';

                }
    break;


     case 'datostemporizadopr':
        $rspta = $factura->consultatemporizador();
        echo json_encode($rspta);
        break;

        case 'activartempo':
        $st=$_GET['st'];
        $tiempo=$_GET['tiempo'];
        $rspta = $factura->onoffTempo($st, $tiempo);
        echo ($rspta);
        break;

    case 'regenerarxmlEA':
        $ano=$_GET['anO'];
        $mes=$_GET['meS'];
        $dia=$_GET['diA'];
        $idcomprobante=$_GET['idComp'];
        $estadoOcu=$_GET['SToc'];
        $Chfac=$_GET['Ch'];
        $opcii=$_GET['opt'];

        switch ($opcii) {
            case 'firmar':
                $rspta=$factura->solofirma($ano, $mes, $dia, $idcomprobante, $estadoOcu, $Chfac, $_SESSION['idempresa']);
                break;
            case 'enviar':
                $rspta=$factura->soloenviar($ano, $mes, $dia, $idcomprobante, $estadoOcu, $Chfac, $_SESSION['idempresa']);
                break;

            case 'fienviar':
                $rspta=$factura->generarxmlEA($ano, $mes, $dia, $idcomprobante, $estadoOcu, $Chfac, $_SESSION['idempresa']);
            
            default:
                # code...
                break;
        }
        
        echo json_encode($rspta) ;
        break;







        case 'tcambiog':
        $tcf=$_GET['feccf'];
        $rspta = $factura->mostrartipocambio($tcf);
        echo json_encode($rspta);
        break;


        case 'montoii':
        $mtiii=$_GET['mtii'];
        $rspta = $factura->asignarmi($mtiii);
        echo json_encode($rspta);
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




       case 'cambiartarjetadc_':
        $opc=$_GET['opcion'];
        $rspta=$factura->cambiartarjetadc($idfactura, $opc);
        echo $rspta ? "Cambio realizado correctamente": "Problemas al cambiar" ;
        break;

        case 'montotarjetadc_':
        $mto=$_GET['monto'];
        $rspta=$factura->montotarjetadc($idfactura, $mto);
        echo $rspta ? "Cambio realizado correctamente": "Problemas al cambiar" ;
        break;


        case 'cambiartransferencia':
        $opc=$_GET['opcion'];
        $rspta=$factura->cambiartransferencia($idfactura, $opc);
        echo $rspta ? "Cambio realizado correctamente": "Problemas al cambiar" ;
        break;

        case 'montotransferencia':
        $mto=$_GET['monto'];
        $rspta=$factura->montotransferencia($idfactura, $mto);
        echo $rspta ? "Cambio realizado correctamente": "Problemas al cambiar" ;
        break;


        case 'duplicar':
        $rspta=$factura->duplicar($idfactura);
        echo $rspta ? "Factura ha sido duplicada" : "Factura no se pudo duplicar";
        break;


        case 'traerclinoti':
        $rspta=$factura->traerclinoti($idfactura);
        echo json_encode($rspta);
        break;


        case 'guardarrangosfac':
        if (empty($idnotificacion)){
            $rspta=$factura->duplicarrangos($idfactu1, $idfactu2, $serier);
            echo $rspta ? "Registro correcto" : "No se pudo registrar";
        }
        break;



        case 'detalledenotapedido':

    $idcomp=$_GET['id'];
    $totalNP="";
    $igvNP="";
    $subtotalNP="";
    $rsptaf=$factura->buscarComprobanteIdNotaPedido($idcomp);
        $data= Array();
        $item=1;
        echo '<thead style="background-color:#35770c; color: #fff; align: center; " >
                                    <th>Sup.</th>
                                    <th>Item</th>
                                    <th>Artículo</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Dcto. %</th>
                                    <th>Cód. Prov.</th>
                                    <th>-</th>
                                    <th>U.M.</th>
                                    <th>Prec. Uni.</th>
                                    <th >Val. u.</th>
                                    <th>Stock</th>
                                    <th>Importe</th>
                                    

                      </thead>';
        while ($reg = $rsptaf->fetch_object())
                {
                    $totalNP=$reg->total;
                    $subtotalNP=$reg->subtotal/1.18;
                    $igvNP=($reg->total / 1.18)*0.18;
    echo '
    <tr class="filas" id="fila'.$reg->norden.'">
    <td></td>

    <td><span name="numero_orden" id="numero_orden'.$reg->norden.'">'.$reg->norden.'</span>
    <input type="hidden" name="numero_orden_item_29[]" id="numero_orden_item_29[]" value="'.$reg->norden.'"></td>

    <td><input type="hidden" name="idarticulo[]" id="idarticulo[]" 
    value="'.$reg->idarticulo.'"> <span>'.$reg->descripcion.'</span></td>

    <td><textarea class="" name="descdet[]" id="descdet[]" rows="1" cols="70" onkeyup="mayus(this)" onkeypress="return focusDescdet(event, this)"></textarea>
    <select name="codigotributo[]" class="" style="display:none;">
    <option value="1000">IGV</option>
    <option value="9997">EXO</option>
    <option value="9998">INA</option>
    </select>

    <select name="afectacionigv[]" class="" style="display:none;">
    <option value="10">10-GOO</option>
    <option value="20">20-EOO</option>
    <option value="30">30-FREE</option>
    </select></td>

    <td><input type="text"  class="" required="true" name="cantidad_item_12[]" id="cantidad_item_12[]"  size="6" onkeypress="return NumCheck(event, this)"  value="'.$reg->cantidad.'">
    <input type="hidden"  name="cantidad2[]" id="cantidad2[]"  readonly value="" size="6" onkeypress="return NumCheck(event, this)" ></td>

    <td><input type="text"  class="" name="descuento[]" id="descuento[]"   size="2" onkeypress="return NumCheck(event, this)" >
    <span name="SumDCTO" id="SumDCTO'.$reg->norden.'" style="display:none"></span> <input type="hidden"  required="true" class="" name="sumadcto[]" id="sumadcto[]"> </td>

    <td><input type="hidden" name="codigo_proveedor[]" id="codigo_proveedor[]" value=""></td>

    <td><input type="text" name="codigo[]" id="codigo[]" value="'.$reg->codigo.'" class="" style="display:none;"></td>

    <td><input type="hidden" name="unidad_medida[]" id="unidad_medida[]" value="'.$reg->abre.'">'.$reg->abre.'</td>

    <td><input type="text" class="" name="precio_unitario[]" id="precio_unitario[]" value="'.$reg->pvi.'"  size="7" onkeypress="return NumCheck2(event, this)" OnFocus="focusTest(this); return false;"></td>

    <td><input type="text" class="" name="valor_unitario[]" id="valor_unitario[]" size="5"  
    value="'.$reg->pvi.'"></td>

    <td><input type="text" name="stock[]" id="stock[]" value="'.$reg->stock.'" disabled="true" size="7" ></td>

    <td><span name="subtotal" id="subtotal'.$reg->norden.'">'.$reg->vvi.'</span>
    <input type="hidden" name="subtotalBD[]" id="subtotalBD["'.$reg->norden.'"]" value="'.($reg->vvi/1.18).'">
    <span name="igvG" id="igvG'.$reg->norden.'" style="background-color:#9fde90bf; display:none;"></span>
    <input type="hidden" name="igvBD[]" id="igvBD["'.$reg->norden.'"]" value="'.($reg->vvi/1.18)*0.18.'">
    <input type="hidden" name="igvBD2[]" id="igvBD2["'.$reg->norden.'"]" value="'.($reg->pvi/1.18)*0.18.'">
    <span name="total" id="total'.$reg->norden.'" style="background-color:#9fde90bf; display:none;">
    </span>
    <span name="pvu_" id="pvu_'.$reg->norden.'"  style="display:none"  ></span>
    <input  type="hidden" name="vvu[]" id="vvu["'.$reg->norden.'"] size="2" value="'.($reg->pvi/1.18).'">
    <input  type="hidden" name="cicbper[]" id="cicbper["'.$reg->norden.'"] value="" >
    <input  type="hidden" name="mticbperu[]" id="mticbperu["'.$reg->norden.'"]" value="'.$mticbperuSunat.'">
    <input type="hidden"  class="" required="true" name="factorc[]" id="factorc[]" >
    <input type="hidden"  class="" required="true" name="cantidadreal[]" id="cantidadreal[]" >
    <span name="mticbperuCalculado" id="mticbperuCalculado'.$reg->norden.'" style="background-color:#9fde90bf;display:none;"></span></td>
    </tr>

     </thead>';
 }
       
    echo '<tfoot style="vertical-align: center;">
                                <!--SUBTOTAL-->
                                     <tr>
                          <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>
                          </td>
                                    <th style="font-weight: bold;  background-color:#A5E393;">Subtotal de venta </th>
                                    <th style="font-weight: bold; background-color:#A5E393;">
                                    <h4 id="subtotal">0.00</h4></th>
                                    </td>
                                    </tr> 
                                    <!--DCTO-->
                                     
                                <!--IGV-->
                           <tr>
                            <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">igv 18% </th>
                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">
                                    <h4 id="igv_">0.00</h4>
                                    </th>
                                    </td>
                                    </tr> 
                                    <!--ICBPER-->
                           

                                     <!--OTROS-->
                           
                             <!--TOTAL-->       
                          <tr><td></td><td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                               <th style="font-weight: bold; vertical-align: center; background-color:#A5E393;">Importe total </th> <!--Datos de impuestos-->  <!--IGV-->
                               <th style="font-weight: bold; background-color:#A5E393;">
                                 <h4 id="total" style="font-weight: bold; vertical-align: center; background-color:#A5E393;">0.00</h4>
                    <input type="hidden" name="total_final" id="total_final">
                    <input type="hidden" name="subtotal_factura" id="subtotal_factura"> 
                    <input type="hidden" name="total_igv" id="total_igv">
                    <input type="hidden" name="total_icbper" id="total_icbper">
                    <input type="hidden" name="total_dcto" id="total_dcto">
                    <input type="hidden" name="pre_v_u" id="pre_v_u"><!--Datos de impuestos-->  <!--TOTAL-->

                    <input type="hidden" name="ipagado_final" id="ipagado_final"><!--Datos de impuestos-->  <!--TOTAL-->
                    <input type="hidden" name="saldo_final" id="saldo_final"></th><!--Datos de impuestos-->  <!--TOTAL-->
                                    </td>
                                    </tr>

                                     <tr>
                            <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                              <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">Total pagado </th>
                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">
                                      <h4 id="ipagado">0.00</h4>
                                    </th>
                                    </td>
                                    </tr> 

                                    <tr>
                            <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                               <!-- <div id="column_center" class="col-xs-12 col-lg-6"> -->
                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">Saldo / vuelto </th>
                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">
                                      <h4 id="saldo">0.00</h4>
                                    </th>


                                    </td>
                                    </tr> 
                                </tfoot>
                                <tbody>
                                </tbody>';
   



   break;


   case 'generarenviar':
        $idfac=$_GET['idf'];
        $rspta=$factura->generarenviar($idfac, $_SESSION['idempresa']);
        echo $rspta ;
    break;


    case 'traerguia':
        $idgg=$_GET['idg'];
        $rspta=$factura->traerguia($idgg);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;




         case 'listarDetalleguia':
    //Recibimos el idingreso
        $id=$_GET['id'];
        $tipc=$_GET['tp'];
        $nord=1;
        $rspta = $factura->listarDetalleguia($id);

        echo ' 
                        <thead>

                                    <th >Sup.</th>
                                    <th >Item</th>
                                    <th >Artículo</th>
                                    <th >Descripción</th>
                                    <th >Cantidad</th>
                                    <th>Dcto. %</th>
                                    <th >Cód.</th>
                                    <th >U.M.</th>
                                    <th >Prec. u.</th>
                                    <th >Val. u.</th>
                                    <th >Stock</th>
                                    <th>Importe</th>
                                    
                      </thead>';

        while ($reg = $rspta->fetch_object())
                {
                   for($i=0; $i < count($reg); $i++){
        echo '<tr class="filas" id="fila'.$cont.'">
        <td></td>
        <td><span name="numero_orden" id="numero_orden'.$cont.'"></span>
        <input type="hidden" name="numero_orden_item[]" id="numero_orden_item[]" value="'.$nord.'"></td>
        <td><input type="hidden" name="idarticulo[]" value="'.$reg->idarticulo.'"> <input type="text" class="" style="display:none;" name="descdet_[]" id="descdet_[]" onkeyup="mayus(this)" onkeypress="return focusDescdet(event, this)" >'.$reg->nombre.'</td>
       
        <td><textarea class="" name="descdet[]" id="descdet[]" rows="1" cols="30" onkeyup="mayus(this)" onkeypress="return focusDescdet(event, this)" readonly>'.$reg->descdet.'</textarea>
        <select name="codigotributo[]"  class="" style="display:none;"> <option value="1000">IGV</option>   <option value="9997">EXO</option><option value="9998">INA</option></select>
        <select name="afectacionigv[]" id="afectacionigv[]"   class="" style="display:none;">
        <option value="10">10-GOO</option>
        <option value="20">20-EOO</option><option value="30">30-FREE</option></select></td>

        <td><input type="text"  required="true" class="" name="cantidad[]" id="cantidad[]"  onBlur="modificarSubototales(1)" size="2" onkeypress="return NumCheck(event, this)"  font-weight:bold;" value="'.$reg->cantidad.'" readonly></td>
        <td><input type="text"  class="" name="descuento[]" id="descuento[]"  onBlur="modificarSubototales(1)" size="2" onkeypress="return NumCheck(event, this)" readonly>
        <span name="SumDCTO" id="SumDCTO'.$cont.'" style="display:none"></span> <input type="hidden"  required="true" class="" name="sumadcto[]" id="sumadcto[]"></td>
        
        <td><input type="hidden" name="codigo[]" id="codigo[]" value="'.$reg->codigo.'">'.$reg->codigo.'</td> <input type="text" name="codigo[]" id="codigo[]" value="'.$reg->codigo.'" class="" size="4" style="display:none;">
        <td><input type="hidden" name="unidad_medida[]" id="unidad_medida[]" value="'.$reg->abre.'">'.$reg->nombreum.'</td>
        <td><input type="text" class="" name="valor_unitario[]" id="valor_unitario[]" value="'.$reg->precio_venta.'"   onBlur="modificarSubototales(1)" size="5" onkeypress="return NumCheck2(event, this)"  OnFocus="focusTest(this);"></td>
        <td><input type="text" class="" name="valor_unitario2[]" id="valor_unitario2[]" size="15"  value="'.$reg->precio_venta.'"  onBlur="modificarSubototales(1)" OnFocus="focusTest(this);" readonly></td>
        <td><input type="text" class="" name="stock[]" id="stock[]" value="'.$reg->factorconversion.'" disabled="true" size="4" readonly></td>

        <td><span name="subtotal" id="subtotal'.$cont.'"></span>
        <input type="hidden" name="subtotalBD[]" id="subtotalBD["'.$cont.'"]">
        <span name="igvG" id="igvG'.$cont.'" style="background-color:#9fde90bf;display:none;"></span>
        <input type="hidden" name="igvBD[]" id="igvBD["'.$cont.'"]"><input type="hidden" name="igvBD2[]" id="igvBD2["'.$cont.'"]"></span>
        <span name="total" id="total'.$cont.'" style="background-color:#9fde90bf; display:none;"></span>
        <span name="pvu_" id="pvu_'.$cont.'"  style="display:none"></span>
        <input  type="hidden" name="pvt[]" id="pvt["'.$cont.'"] size="2">
        <input  type="hidden" name="cicbper[]" id="cicbper["'.$cont.'"] value="'.$reg->cicbper.'">
        <input  type="hidden" name="mticbperu[]" id="mticbperu["'.$cont.'"]" value="'.$reg->mticbperuSunat.'">
        <input type="hidden"  class="" required="true" name="factorc[]" id="factorc[]"   value="'.$reg->factorc.'">
        <input type="hidden"  class="" required="true" name="cantidadreal[]" id="cantidadreal[]">
        <span name="mticbperuCalculado" id="mticbperuCalculado'.$cont.'" style="background-color:#9fde90bf;display:none;"></span>
        </td>
        </tr>';
                                }
            $cont++;
            $nord++;
            $detalles++;
                                }

                  echo ' <tfoot style="vertical-align: center;">
                                <!--SUBTOTAL-->
                                     <tr>
                          <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>
                          </td>
                                    <th style="font-weight: bold;  background-color:#A5E393;">Subtotal de venta </th>
                                    <th style="font-weight: bold; background-color:#A5E393;">
                                    <h4 id="subtotal">0.00</h4></th>
                                    </td>
                                    </tr> 
                                    <!--DCTO-->
                                     <tr>
                          <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                    <th style="font-weight: bold;  background-color:#A5E393;">Descuentos</th>
                                    <th style="font-weight: bold; background-color:#A5E393;">
                                    <h4 id="tdescuentoL">0.00</h4> </th>
                                    </td>
                                    </tr> 
                                <!--IGV-->
                           <tr>
                            <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">igv 18% </th>
                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">
                                    <h4 id="igv_">0.00</h4>
                                    </th>
                                    </td>
                                    </tr> 
                                    <!--ICBPER-->
                                    <tr>
                                 <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">ICBPER </th>
                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">
                                      <h4 id="icbper">0</h4>

                                    </th>
                                    </td>
                                    </tr> 

                                     <!--OTROS-->
                                    <tr>
                                 <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">OTROS </th>
                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">
                                    <input type="text"  id="otroscargos" name="otroscargos"   onchange="modificarSubototales();" disabled value="0.00">
                                    </th>
                                    </td>
                                    </tr> 
                             <!--TOTAL-->       
                          <tr><td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                               <th style="font-weight: bold; vertical-align: center; background-color:#A5E393;">Importe total </th> <!--Datos de impuestos-->  <!--IGV-->
                               <th style="font-weight: bold; background-color:#A5E393;">
                                 <h4 id="total" style="font-weight: bold; vertical-align: center; background-color:#A5E393;">0.00</h4>
                    <input type="hidden" name="total_final" id="total_final">
                    <input type="hidden" name="subtotal_factura" id="subtotal_factura"> 
                    <input type="hidden" name="total_igv" id="total_igv">
                    <input type="hidden" name="total_icbper" id="total_icbper">
                    <input type="hidden" name="total_dcto" id="total_dcto">
                    <input type="hidden" name="pre_v_u" id="pre_v_u"><!--Datos de impuestos-->  <!--TOTAL-->

                    <input type="hidden" name="ipagado_final" id="ipagado_final"><!--Datos de impuestos-->  <!--TOTAL-->
                    <input type="hidden" name="saldo_final" id="saldo_final"></th><!--Datos de impuestos-->  <!--TOTAL-->
                                    </td>
                                    </tr>

                                     <tr>
                            <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                              <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">Total pagado </th>
                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">
                                      <h4 id="ipagado">0.00</h4>
                                    </th>
                                    </td>
                                    </tr> 

                                    <tr>
                            <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                               <!-- <div id="column_center" class="col-xs-12 col-lg-6"> -->
                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">Saldo / vuelto </th>
                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">
                                      <h4 id="saldo">0.00</h4>
                                    </th>

                                    </td>
                                    </tr> 
                                </tfoot>';


                
            break;


        case 'recalculardia':
        $rspta=$factura->recalculardia($idcaja);
        echo $rspta? "Actualizado": "Error al actualizar";
        break;


         case 'imprimircomprobanteId':
        $rspta = $factura->imprimircomprobanteId($_SESSION['idempresa']); 
        echo json_encode($rspta);
        break;


    case 'generardefactura':
        $idfact=$_GET['idf'];
        $rspta = $factura->generardefactura($idfact); 


    break;



        case "selectConcepto":
        require_once "../modelos/Factura.php";
        $factura=new Factura();
        //$idempresa=$_GET['idempresa'];
        $rspta=$factura->selectConcepto();
        while ($reg= $rspta->fetch_object())
        {
            echo '<option value='.$reg->idconcepto.'>'.$reg->nombre_concepto.'</option>';
        }

        break;

      

            case 'guardarMovimientoig':
             $ES="";
            if ($OpcionMovGI=="E")
            {
                $ES="Ingreso.";
            }else{
                $ES="Egreso.";
            }
                    $rspta=$factura->registrarmovimientoig($OpcionMovGI, $IdConcepto, $_SESSION["idempresa"],  $Fecha_Mov_Con, $Monto_Mov, $ObseMov);
                    echo $rspta ? "Se registro movimiento de ".$ES   : "No se pudo registrar el movimiento";
            
        
            break;


    
        }
?>