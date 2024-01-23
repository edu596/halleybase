<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Boleta.php";
require_once "../modelos/Numeracion.php"; 
$boleta=new Boleta();

require_once "../modelos/Persona.php";
$persona=new Persona();

require_once "../modelos/Usuario.php";
$usuario=new Usuario();


//Factura
$idboleta=isset($_POST["idboleta"])? limpiarCadena($_POST["idboleta"]):"";
//$idusuario="2";
$idusuario=$_SESSION["idusuario"];
$fecha_emision_01=isset($_POST["fecha_emision_01"])? limpiarCadena($_POST["fecha_emision_01"]):""; 
$firma_digital_36=isset($_POST["firma_digital_36"])? limpiarCadena($_POST["firma_digital_36"]):"";
$idempresa=isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";
$tipo_documento_06=isset($_POST["tipo_documento_06"])? limpiarCadena($_POST["tipo_documento_06"]):"";
$idserie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";
$SerieReal=isset($_POST["SerieReal"])? limpiarCadena($_POST["SerieReal"]):"";
$numero_boleta=isset($_POST["numero_boleta"])? limpiarCadena($_POST["numero_boleta"]):"";
$idnumeracion=isset($_POST["idnumeracion"])? limpiarCadena($_POST["idnumeracion"]):"";
$numeracion_07=isset($_POST["numeracion_07"])? limpiarCadena($_POST["numeracion_07"]):"";
$monto_15_2=isset($_POST["subtotal_boleta"])? limpiarCadena($_POST["subtotal_boleta"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$codigo_tipo_15_1=isset($_POST["codigo_tipo_15_1"])? limpiarCadena($_POST["codigo_tipo_15_1"]):"";
$sumatoria_igv_18_1=isset($_POST["total_igv"])? limpiarCadena($_POST["total_igv"]):"";
$sumatoria_igv_18_2=isset($_POST["total_igv"])? limpiarCadena($_POST["total_igv"]):"";

$total_icbper=isset($_POST["total_icbper"])? limpiarCadena($_POST["total_icbper"]):""; //NUEVO POR BOLSAS


$codigo_tipo_15_1=isset($_POST["codigo_tipo_15_1"])? limpiarCadena($_POST["codigo_tipo_15_1"]):"";

$codigo_tributo_18_3=isset($_POST["codigo_tributo_h"])? limpiarCadena($_POST["codigo_tributo_h"]):"";
$nombre_tributo_18_4=isset($_POST["nombre_tributo_h"])? limpiarCadena($_POST["nombre_tributo_h"]):"";
$codigo_internacional_18_5=isset($_POST["codigo_internacional_5"])? limpiarCadena($_POST["codigo_internacional_5"]):"";


$importe_total_23=isset($_POST["total_final"])? limpiarCadena($_POST["total_final"]):"";
$tipo_documento_25_1=isset($_POST["tipo_documento_25_1"])? limpiarCadena($_POST["tipo_documento_25_1"]):"";
$guia_remision_25=isset($_POST["guia_remision_25"])? limpiarCadena($_POST["guia_remision_25"]):"";
$codigo_leyenda_26_1=isset($_POST["codigo_leyenda_26_1"])? limpiarCadena($_POST["codigo_leyenda_26_1"]):"";
$descripcion_leyenda_26_2=isset($_POST["descripcion_leyenda_26_2"])? limpiarCadena($_POST["descripcion_leyenda_26_2"]):"";
$version_ubl_37=isset($_POST["version_ubl_37"])? limpiarCadena($_POST["version_ubl_37"]):"";
$version_estructura_38=isset($_POST["version_estructura_38"])? limpiarCadena($_POST["version_estructura_38"]):"";
$tipo_moneda_24=isset($_POST["tipo_moneda_24"])? limpiarCadena($_POST["tipo_moneda_24"]):"";
$tasa_igv=isset($_POST["tasa_igv"])? limpiarCadena($_POST["tasa_igv"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
$codigo_precio=isset($_POST["codigo_precio"])? limpiarCadena($_POST["codigo_precio"]):"";
$rucCliente=isset($_POST["numero_documento"])? limpiarCadena($_POST["numero_documento"]):"";
$RazonSocial=isset($_POST["razon_social"])? limpiarCadena($_POST["razon_social"]):"";
$tipo_doc_ide=isset($_POST["tipo_doc_ide"])? limpiarCadena($_POST["tipo_doc_ide"]):"";
$domicilio_fiscal=isset($_POST["domicilio_fiscal"])? limpiarCadena($_POST["domicilio_fiscal"]):"";
$hora=isset($_POST["hora"])? limpiarCadena($_POST["hora"]):"";
$vendedorsitio=isset($_POST["vendedorsitio"])? limpiarCadena($_POST["vendedorsitio"]):"";

$tcambio=isset($_POST["tcambio"])? limpiarCadena($_POST["tcambio"]):"";
$tdescuento=isset($_POST["total_dcto"])? limpiarCadena($_POST["total_dcto"]):"";



$ipagado=isset($_POST["ipagado_final"])? limpiarCadena($_POST["ipagado_final"]):"";
$saldo=isset($_POST["saldo_final"])? limpiarCadena($_POST["saldo_final"]):"";
$tipopago=isset($_POST["tipopago"])? limpiarCadena($_POST["tipopago"]):"";
$nroreferencia=isset($_POST["nroreferencia"])? limpiarCadena($_POST["nroreferencia"]):"";
$tipoboleta=isset($_POST["tipoboleta"])? limpiarCadena($_POST["tipoboleta"]):"";

$ccuotas=isset($_POST["ccuotas"])? limpiarCadena($_POST["ccuotas"]):"";
$fechavecredito=isset($_POST["fechavecredito"])? limpiarCadena($_POST["fechavecredito"]):"";
$montocuota=isset($_POST["montocuota"])? limpiarCadena($_POST["montocuota"]):"";

$tadc=isset($_POST["tadc"])? limpiarCadena($_POST["tadc"]):"";
$transferencia=isset($_POST["trans"])? limpiarCadena($_POST["trans"]):"";


$fechavenc=isset($_POST["fechavenc"])? limpiarCadena($_POST["fechavenc"]):""; 



$idfactu1=isset($_POST["idfactu1"])? limpiarCadena($_POST["idfactu1"]):""; 
$idfactu2=isset($_POST["idfactu2"])? limpiarCadena($_POST["idfactu2"]):""; 
$serier=isset($_POST["serier"])? limpiarCadena($_POST["serier"]):""; 




switch ($_GET["op"]){
    case 'guardaryeditarBoleta':

if (empty($idboleta)){

   if($importe_total_23 >= 700){

    if ($idcliente=="N"){
        //$tipo_doc_ide="1";
         $rspta=$persona->insertardeBoleta($RazonSocial, $tipo_doc_ide, $rucCliente, $domicilio_fiscal);

        $IdC=$persona->mostrarId();
        //para ultimo registro de cliente
        while ($reg = $IdC->fetch_object())
                {
            $idcl=$reg->idpersona;
                }
        
    $rspta=$boleta->insertar($idusuario, $fecha_emision_01, $firma_digital_36, $idempresa, $tipo_documento_06, $numeracion_07, $idcl, $codigo_tipo_15_1, $monto_15_2, $sumatoria_igv_18_1, $sumatoria_igv_18_2, $codigo_tributo_18_3, $nombre_tributo_18_4, $codigo_internacional_18_5, $importe_total_23, $codigo_leyenda_26_1,  $descripcion_leyenda_26_2,  $tipo_documento_25_1, $guia_remision_25, $version_ubl_37, $version_estructura_38, $tipo_moneda_24, $tasa_igv, $_POST["idarticulo"], $_POST["numero_orden_item_29"], $_POST["cantidad_item_12"], $_POST["codigo_precio_14_1"], $_POST["precio_unitario"], $_POST["igvBD"], $_POST["igvBD"], $_POST["afectacionigv"],$_POST["codigotributo"], '', '', $_POST["igvBD2"], $_POST["vvu"], $_POST["subtotalBD"], $_POST["codigo"] , $_POST["unidad_medida"], $idserie, $SerieReal, $numero_boleta, $tipo_doc_ide, $rucCliente, html_entity_decode($RazonSocial , ENT_QUOTES | ENT_HTML401, 'UTF-8'), $hora, $_POST["sumadcto"], $vendedorsitio, $tcambio, $tdescuento, $domicilio_fiscal, $tipopago, $nroreferencia, $ipagado, $saldo, $_POST["descdet"], $total_icbper, $tipoboleta, $_POST["cantidadreal"], $ccuotas, $fechavecredito, $montocuota, $tadc, $transferencia,  $_POST["ncuotahiden"], $_POST["montocuotacre"], $_POST["fechapago"], $fechavenc );
    echo $rspta;// ? "Se guardo boleta correctamente":"No se guardo boleta" ;
        }
        else
        {

            $rspta=$boleta->insertar($idusuario, $fecha_emision_01, $firma_digital_36, $idempresa, $tipo_documento_06, $numeracion_07, $idcliente, $codigo_tipo_15_1, $monto_15_2, $sumatoria_igv_18_1, $sumatoria_igv_18_2, $codigo_tributo_18_3, $nombre_tributo_18_4, $codigo_internacional_18_5, $importe_total_23, $codigo_leyenda_26_1,  $descripcion_leyenda_26_2,  $tipo_documento_25_1, $guia_remision_25, $version_ubl_37, $version_estructura_38, $tipo_moneda_24, $tasa_igv, $_POST["idarticulo"], $_POST["numero_orden_item_29"], $_POST["cantidad_item_12"], $_POST["codigo_precio_14_1"], $_POST["precio_unitario"], $_POST["igvBD"], $_POST["igvBD"], $_POST["afectacionigv"],$_POST["codigotributo"],'', '', $_POST["igvBD2"], $_POST["vvu"], $_POST["subtotalBD"], $_POST["codigo"] , $_POST["unidad_medida"], $idserie, $SerieReal, $numero_boleta, $tipo_doc_ide, $rucCliente,html_entity_decode($RazonSocial , ENT_QUOTES | ENT_HTML401, 'UTF-8'), $hora, $_POST["sumadcto"], $vendedorsitio, $tcambio, $tdescuento, $domicilio_fiscal, $tipopago, $nroreferencia, $ipagado, $saldo, $_POST["descdet"], $total_icbper, $tipoboleta, $_POST["cantidadreal"], $ccuotas, $fechavecredito, $montocuota, $tadc, $transferencia,  $_POST["ncuotahiden"], $_POST["montocuotacre"], $_POST["fechapago"], $fechavenc );
            echo $rspta;// ? "Se guardo boleta correctamente":"No se guardo boleta" ;


        } //FIN DE SEGUNDO IF

        }
        else //ELSE DE PRIMER IF
        {
        // SI EL TOTAL ES MENOR DE 700

    if ($idcliente=="N"){

         $rspta=$persona->insertardeBoleta($RazonSocial, $tipo_doc_ide, $rucCliente, $domicilio_fiscal);
         $IdC=$persona->mostrarId();
         while ($reg = $IdC->fetch_object())
                {
            $idcl=$reg->idpersona;
                }
        $rspta=$boleta->insertar($idusuario, $fecha_emision_01, $firma_digital_36, $idempresa, $tipo_documento_06, $numeracion_07, $idcl, $codigo_tipo_15_1, $monto_15_2, $sumatoria_igv_18_1, $sumatoria_igv_18_2, $codigo_tributo_18_3, $nombre_tributo_18_4, $codigo_internacional_18_5, $importe_total_23, $codigo_leyenda_26_1,  $descripcion_leyenda_26_2,  $tipo_documento_25_1, $guia_remision_25, $version_ubl_37, $version_estructura_38, $tipo_moneda_24, $tasa_igv, $_POST["idarticulo"], $_POST["numero_orden_item_29"], $_POST["cantidad_item_12"], $_POST["codigo_precio_14_1"], $_POST["precio_unitario"], $_POST["igvBD"], $_POST["igvBD"], $_POST["afectacionigv"],$_POST["codigotributo"], '', '', $_POST["igvBD2"], $_POST["vvu"], $_POST["subtotalBD"], $_POST["codigo"] , $_POST["unidad_medida"], $idserie, $SerieReal, $numero_boleta, $tipo_doc_ide, $rucCliente, html_entity_decode($RazonSocial , ENT_QUOTES | ENT_HTML401, 'UTF-8'), $hora, $_POST["sumadcto"] , $vendedorsitio, $tcambio, $tdescuento, $domicilio_fiscal, $tipopago, $nroreferencia, $ipagado, $saldo, $_POST["descdet"], $total_icbper, $tipoboleta, $_POST["cantidadreal"], $ccuotas, $fechavecredito, $montocuota, $tadc, $transferencia,  $_POST["ncuotahiden"], $_POST["montocuotacre"], $_POST["fechapago"], $fechavenc );
            echo $rspta;//? "Se guardo boleta correctamente":"No se guardo boleta" ;
        //


        }
        else //===========#####################
        {

        $rspta=$boleta->insertar(
            $idusuario, 
            $fecha_emision_01, 
            $firma_digital_36, 
            $idempresa, 
            $tipo_documento_06, 
            $numeracion_07, 
            $idcliente, 
            $codigo_tipo_15_1, 
            $monto_15_2, 
            $sumatoria_igv_18_1, 
            $sumatoria_igv_18_2, 
            $codigo_tributo_18_3, 
            $nombre_tributo_18_4, 
            $codigo_internacional_18_5, 
            $importe_total_23, 
            $codigo_leyenda_26_1,  
            $descripcion_leyenda_26_2,  
            $tipo_documento_25_1, 
            $guia_remision_25, 
            $version_ubl_37, 
            $version_estructura_38, 
            $tipo_moneda_24, 
            $tasa_igv, 
            $_POST["idarticulo"], 
            $_POST["numero_orden_item_29"], 
            $_POST["cantidad_item_12"], 
            $_POST["codigo_precio_14_1"], 
            $_POST["precio_unitario"], 
            $_POST["igvBD"], 
            $_POST["igvBD"], 
            $_POST["afectacionigv"],
            $_POST["codigotributo"],
            '', 
            '', 
            $_POST["igvBD2"], 
            $_POST["vvu"], 
            $_POST["subtotalBD"], 
            $_POST["codigo"] , 
            $_POST["unidad_medida"], 
            $idserie, 
            $SerieReal, 
            $numero_boleta, 
            $tipo_doc_ide, 
            $rucCliente,html_entity_decode($RazonSocial , ENT_QUOTES | ENT_HTML401, 'UTF-8'), 
            $hora, 
            $_POST["sumadcto"], 
            $vendedorsitio, 
            $tcambio, 
            $tdescuento, 
            $domicilio_fiscal, 
            $tipopago, 
            $nroreferencia, 
            $ipagado, 
            $saldo, 
            $_POST["descdet"], 
            $total_icbper, 
            $tipoboleta,  
            $_POST["cantidadreal"], 
            $ccuotas, 
            $fechavecredito, 
            $montocuota, 
            $tadc, 
            $transferencia,  
            $_POST["ncuotahiden"], 
            $_POST["montocuotacre"], 
            $_POST["fechapago"], 
            $fechavenc);
            echo $rspta;//? "Se guardo boleta correctamente":"No se guardo boleta" ;

          }

         }
     } // $######################## FIN DE IF SI ES MAYOR O MENOR A 700
    break;



    case 'mostrarultimocomprobante':
       $rspta = $boleta->mostrarultimocomprobante($_SESSION['idempresa']);
       echo json_encode($rspta);
        break;

    case 'mostrarultimocomprobanteId':
        $rspta = $boleta->mostrarultimocomprobanteId($_SESSION['idempresa']); 
        echo json_encode($rspta);
        break;

        case 'imprimircomprobanteId': 
        $rspta = $boleta->imprimircomprobanteId($_SESSION['idempresa']); 
        echo json_encode($rspta);
        break;  

 
    case 'anular':
        $rspta=$boleta->anular($idboleta);
        echo $rspta ? "Boleta anulada" : "Boleta no se puede anular";
    break;


    case 'baja':
        $com=$_GET['comentario'];
        $hor=$_GET['hora'];
        date_default_timezone_set('America/Lima');
        //$hoy=date('Y/m/d');
        $hoy = date("Y-m-d"); 
        $rspta=$boleta->baja($idboleta, $hoy, $com, $hor );
        echo $rspta ? "Boleta de baja" : "Boleta no se puede dar de baja";
    break;

    case 'actualizarNumero':
            require_once "../Modelos/Numeracion.php";
            $numeracion=new Numeracion();

            $num=$_GET['Num'];
            $idnumeracion=$_GET['Idnumeracion'];
            $rspta=$numeracion->UpdateNumeracion($num, $idnumeracion );
    break;
 
    case 'mostrar':
        $rspta=$factura->mostrar($idboleta);
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
 
        $rspta = $numeracion->llenarSerieBoleta($idusuario);
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idnumeracion . '>' . $reg->serie . '</option>';

                }
    break; 
 

    //Carga de los últimos numeros de la numeración de acuerdo a la serie seleccionada
    case 'llenarNumeroFactura':
    $tipoC=$_GET['tipoC'];
    $serieC=$_GET['serieC'];
    $rspta = $venta->sumarC($tipoC,$serieC);
            while ($reg = $rspta->fetch_object())
                {
            echo $reg->addnumero;
                }
    break;

    case 'llenarNumeroBoleta':
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


    case 'listarClientesboleta':
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


    

    case 'listarArticulosboletaxcodigo':
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
        $idempresa=$_GET['idempresa'];
        $codigob=$_GET['codigob'];
        $rspta=$articulo->listarActivosVentaxCodigo($codigob, $idempresa);
        echo json_encode($rspta);
    break;

    

    case 'listar':
    require_once "../modelos/Rutas.php";
    $numero='BKLKASD';
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($_SESSION['idempresa']);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta ENVIO
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta ENVIO
    $rutarpta=$Prutas->rutarpta; // ruta de la carpeta RESPUESTA

    //Agregar=====================================================
        // Ruta del directorio donde están los archivos
        $path  = $rutaenvio; 
        $path2  = $rutarpta; 
        // Arreglo con todos los nombres de los archivos
        $files = array_diff(scandir($path), array('.', '..')); 
        $files2 = array_diff(scandir($path2), array('.', '..')); 

        //=============================================================


        $rspta=$boleta->listar($_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){

            $urlT='../reportes/exTicketBoleta.php?id=';
            $urlB='../reportes/exBoleta.php?id=';
            $urlC='../reportes/exBoletaCompleto.php?id=';

            if($reg->tipo_documento_06=='Ticket'){
                $url='../reportes/exTicket.php?id=';
            }else{
                $url='../reportes/exBoleta.php?id=';

            }

    //==============Agregar====================================================
    $archivo=$reg->numero_ruc."-".$reg->tipo_documento_06."-".$reg->numeracion_07;
    $archivo2="R".$reg->numero_ruc."-".$reg->tipo_documento_06."-".$reg->numeracion_07;
    $rptaSunat=$reg->CodigoRptaSunat;

    //===========================================================================


    
$stt='';
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
    //$boleta->enviarxmlSUNAT($reg->idboleta);
}
else
{
    $send='none';
}
if ($reg->estado=='3') {
     $stt='none'; 
     $sunat='';  
}
if ($reg->estado=='0') {
     $stt='none'; 
     
     $sunat=''; 
}
$estadoenvio='1';

$mon="";
if ($reg->moneda=="USD")
{
$mon='<i style="color:green;" data-toggle="tooltip" title="Por T.C. '.$reg->tcambio.' = '.$reg->valordolsol.' PEN">$</i>';
}


    //=====================================================================================
    $data[]=array(
            "0"=>


             '<div class="dropdown">
                <button  class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                :::
                <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-center">



                
                <li>
                   <a  onclick="baja('.$reg->idboleta.')" style="display:'.$stt.';  color:red;"> 
                   <i class="fa fa-level-down"  data-toggle="tooltip" title="Dar de baja" ></i>
                      Dar de baja
                    </a>

                </i>

                
                    <li>
                <a onclick="duplicarb('.$reg->idboleta.')"  style="color:green;"  data-toggle="tooltip" title="Duplicar boleta" '.$stt.'">
                  <i  class="fa fa-files-o"></i>
                  Duplicar boleta
                  </a>


                  <a onclick="duplicarbr()"  style="color:green;"  data-toggle="tooltip" title="Duplicar x rangos idboleta" '.$stt.'">
                  <i  class="fa fa-files-o"></i>
                  Duplicar x rangos
                  </a>
                  
                  </li>






                  <li>
                  <a  onclick="prea42copias2('.$reg->idboleta.')"> 
                   <i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir formato 2 copias" onclick=""></i>
                   Imprimir formato 2 copias
                    </a>
                 </li>

                   <li>
                  <a  onclick="preticket258mm('.$reg->idboleta.')"><i class="fa  fa-print"  data-toggle="tooltip" title="Ticket 58mm"> </i>
                  Ticket 58mm
                     </a>
                  </li>

                   <li>
                  <a  onclick="preticket280mm('.$reg->idboleta.')"><i class="fa  fa-print"  data-toggle="tooltip" title="Ticket 80mm"> </i>
                  Ticket 80mm
                     </a>
                  </li>


                   <li>
                 <a onclick="prea4completo2('.$reg->idboleta.')"><i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir formato completo"> </i>Imprimir formato completo
                     </a>
                  </li>

                  

                  <li>
                 <a onclick="enviarcorreo('.$reg->idboleta.')"><i class="fa  fa-send"  data-toggle="tooltip" title=""> </i>Enviar por correo
                     </a>
                  </li>



                </ul>
                </div>',

                "1"=>$reg->fecha,
                "2"=>$reg->cliente,
                "3"=>$reg->vendedorsitio,
                "4"=>$reg->numeracion_07,
                "5"=>$reg->importe_total_23." ".$mon,
                "6"=>($reg->tarjetadc=='1')?'<img src="../files/articulos/tarjetadc.png" width="20px" 
                data-toggle="tooltip" title="TARJETA '.$reg->montotarjetadc.'">':'',
                "7"=>($reg->transferencia=='1')?'<img src="../files/articulos/transferencia.png" width="20px" data-toggle="tooltip" title="BANCO '.$reg->montotransferencia.'">':'',

                //Actualizado ===============================================
                "8"=>($reg->estado=='1')//si esta emitido
                ?'<span style="color:#BA4A00;">'.$reg->DetalleSunat.'</span>'

            : (($reg->estado=='4') ?'<span style="color:#239B56;">'.$reg->DetalleSunat.'</span>' //si esta firmado

            : (($reg->estado=='3' )?'<span style="color:#E59866;">'.$reg->DetalleSunat.'</span>' // si esta de baja

            : (($reg->estado=='0')?'<span style="color:#E59866;">'.$reg->DetalleSunat.'</span>'  //si esta firmado

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
                   <a onclick="generarxml('.$reg->idboleta.')" ><i class="fa fa-download"  style="color:orange; font-size:18px;" data-toggle="tooltip" title="Generar xml"></i>Generar xml</a>
                  </li>


                  <li>
                    <a onclick="enviarxmlSUNAT('.$reg->idboleta.')"  '.$sunatAceptado.'="class_a_href" ><i class="fa fa-send"  style="color:red; font-size:18px;" data-toggle="tooltip" title="Enviar a SUNAT" ></i>Enviar a SUNAT</a>
                  </li>


                  <li>
                    <a onclick="mostrarxml('.$reg->idboleta.')"><i class="fa fa-check" style="color:orange; font-size:18px;"  data-toggle="tooltip" title="Mostrar XML"></i>Mostrar XML</a>
                  </li>

                   <li>
                   <a onclick="mostrarrpta('.$reg->idboleta.')"><i class="fa fa-check" style="color:green; font-size:18px;"  data-toggle="tooltip" title="Mostrar respuesta CDR"></i>Mostrar respuesta</a>
                  </li>

                  <li>
                   <a href="https://n9.cl/fo5y" target=_blank >  <img src="../public/images/sunat.png" style="color:green; font-size:18px;"  data-toggle="tooltip" title="Consulta de validez con SUNAT"></i>Consulta de validez</a>
                  </li>

                    <li>
                    <a onclick="consultarcdr('.$reg->idboleta.')" ><i class="fa fa-refresh"  style="color:red; font-size:18px;" data-toggle="tooltip" title="Enviar a SUNAT" ></i>Reconsultar a SUNAT</a>
                  </li>


                  <li>
                    <a onclick="cambiartarjetadc('.$reg->idboleta.')" ><i class="fa fa-credit-card" style="color:blue;"></i> Cambiar a tarjeta</a>
                  </li>

                  <li>
                    <a onclick="montotarjetadc('.$reg->idboleta.')" ><i class="fa fa-money" style="color:blue;"></i> Modificar monto tarjeta </a>
                  </li>


                  <li>
                    <a onclick="cambiartransferencia('.$reg->idboleta.')" ><i class="fa fa-exchange" style="color:green;"></i> Cambiar a transferencia </a>
                  </li>

                  <li>
                    <a onclick="montotransferencia('.$reg->idboleta.')" ><i class="fa fa-money" style="color:green;"></i> Modificar monto transferencia </a>
                  </li>



                   </ul>
                </div>',
            "10"=>'<a data-toggle="tooltip" title="Impresion por defecto" onclick="tipoimpresionxboleta('.$reg->idboleta.')"  ><i class="fa fa-file-pdf-o" style="color:green;"></i></a>'
        );
        }
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
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta ENVIO
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta ENVIO
    $rutarpta=$Prutas->rutarpta; // ruta de la carpeta RESPUESTA

    //Agregar=====================================================
        // Ruta del directorio donde están los archivos
        $path  = $rutaenvio; 
        $path2  = $rutarpta; 
        // Arreglo con todos los nombres de los archivos
        $files = array_diff(scandir($path), array('.', '..')); 
        $files2 = array_diff(scandir($path2), array('.', '..')); 

        //=============================================================


        $rspta=$boleta->listarValidar($ano, $mes, $dia, $_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){

            $urlT58mm='../reportes/exTicketBoleta58mm.php?id=';
            $urlT80mm='../reportes/exTicketBoleta80mm.php?id=';
            $urlB='../reportes/exBoleta.php?id=';
            $urlC='../reportes/exBoletaCompleto.php?id=';

            if($reg->tipo_documento_06=='Ticket'){
                $url='../reportes/exTicket.php?id=';
            }else{
                $url='../reportes/exBoleta.php?id=';

            }

    //==============Agregar====================================================
    $archivo=$reg->numero_ruc."-".$reg->tipo_documento_06."-".$reg->numeracion_07;
    $archivo2="R".$reg->numero_ruc."-".$reg->tipo_documento_06."-".$reg->numeracion_07;
    //===========================================================================



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
    //$boleta->enviarxmlSUNAT($reg->idboleta);
}
else
{
    $send='none';
}
if ($reg->estado=='3') {
     $stt='none'; 
     $sunat=''; 
     $vs='none'; 
}
if ($reg->estado=='0') {
     $stt='none'; 
     
     $sunat=''; 
}
$estadoenvio='1';

$mon="";
if ($reg->moneda=="USD")
{
$mon='<i style="color:green;" data-toggle="tooltip" title="Por T.C. '.$reg->tcambio.' = '.$reg->valordolsol.' PEN">$</i>';
}
    //=====================================================================================

            $data[]=array(
                "0"=>

                 '
                 <input type="hidden" name="idoculto[]" id="idoculto[]" value="'.$reg->idboleta.'">
                 <input type="hidden" name="estadoocu[]" id="estadoocu[]" value="'.$reg->estado.'">

                 <div class="dropup">
                <button  class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                ...
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-center">
                <li>
                   <a  onclick="baja('.$reg->idboleta.')" style="display:'.$vs.';  color:red;"> 
                   <i class="fa fa-level-down"  data-toggle="tooltip" title="Dar de baja" onclick=""></i>
                   Dar de baja
                    </a>
                  
                  </li>

                  <li>
                  <a  target="_blank" href="'.$url.$reg->idboleta.'"> 
                   <i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir formato 2 copias" onclick=""></i>
                   Imprimir formato 2 copias
                    </a>

                   <li>
                  <a target="_blank" href="'.$urlT58mm.$reg->idboleta.'"><i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir Ticket"> </i>
                  Imprimir Ticket 58mm
                     </a>
                  </li>

                   <li>
                  <a target="_blank" href="'.$urlT80mm.$reg->idboleta.'"><i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir Ticket"> </i>
                  Imprimir Ticket 80mm
                     </a>
                  </li>


                   <li>
                 <a target="_blank" href="'.$urlC.$reg->idboleta.'"><i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir formato completo"> </i>Imprimir formato completo
                     </a>
                  </li>

                   <li>
                    <a onclick="consultarcdr('.$reg->idboleta.')" ><i class="fa fa-refresh"  style="color:red; font-size:18px;" data-toggle="tooltip" title="Enviar a SUNAT" ></i>Reconsultar a SUNAT</a>

                      <a onclick="duplicarbr()"  style="color:green;"  data-toggle="tooltip" title="Duplicar x rangos idboleta" '.$stt.'">
                            <i  class="fa fa-files-o"></i>
                                Duplicar x rangos
                        </a>


                  </li>



                </ul>
                </div>'
       
                     ,
                    

                "1"=>$reg->fecha,
                "2"=>$reg->nombres,
                "3"=>$reg->vendedorsitio,
                "4"=>$reg->numeracion_07,
                "5"=>$reg->importe_total_23." ".$mon,

                "6"=>($reg->tarjetadc=='1')?'<img src="../files/articulos/tarjetadc.png" width="20px" 
                data-toggle="tooltip" title="TARJETA '.$reg->montotarjetadc.'">':'',
                "7"=>($reg->transferencia=='1')?'<img src="../files/articulos/transferencia.png" width="20px" data-toggle="tooltip" title="BANCO '.$reg->montotransferencia.'">':'',

                //Actualizado ===============================================
               "8"=>($reg->estado=='1')//si esta emitido
                ?'<span style="color:#BA4A00;">'.$reg->DetalleSunat.'</span>'

            : (($reg->estado=='4') ?'<span style="color:#239B56;">'.$reg->DetalleSunat.'</span>' //si esta firmado

            : (($reg->estado=='3' )?'<span style="color:#E59866;">'.$reg->DetalleSunat.'</span>' // si esta de baja

            : (($reg->estado=='0')?'<span style="color:#E59866;">'.$reg->DetalleSunat.'</span>'  //si esta firmado

            : (($reg->estado=='5')?'<span style="color:#145A32;">'.$reg->DetalleSunat.'</span>' // Si esta aceptado
            : '<span style="color:#239B56;">'.$reg->DetalleSunat.'</span>' )))), 

            //Opciones de envio
            "9"=>

             '<div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                Opciones
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-right">
                  <li>
                   <a onclick="generarxml('.$reg->idboleta.')" '.$sunatFirma.'="class_a_href"><i class="fa fa-download"  style="color:orange; font-size:18px;" data-toggle="tooltip" title="Generar xml"></i>Generar xml</a>
                  </li>


                  <li>
                    <a onclick="enviarxmlSUNAT('.$reg->idboleta.')"  '.$sunatAceptado.'="class_a_href" ><i class="fa fa-send"  style="color:red; font-size:18px;" data-toggle="tooltip" title="Enviar a SUNAT" ></i>Enviar a SUNAT</a>
                  </li>


                  <li>
                    <a onclick="mostrarxml('.$reg->idboleta.')"><i class="fa fa-check" style="color:orange; font-size:18px;"  data-toggle="tooltip" title="Mostrar XML"></i>Mostrar XML</a>
                  </li>

                   <li>
                   <a onclick="mostrarrpta('.$reg->idboleta.')"><i class="fa fa-check" style="color:green; font-size:18px;"  data-toggle="tooltip" title="Mostrar respuesta CDR"></i>Mostrar respuesta</a>
                  </li>

                  <li>
                   <a href="https://n9.cl/fo5y" target=_blank >  <img src="../public/images/sunat.png" style="color:green; font-size:18px;"  data-toggle="tooltip" title="Consulta de validez con SUNAT"></i>Consulta de validez</a>
                  </li>

                    <li>
                    <a onclick="regenerarxml('.$reg->idboleta.')" ><i class="fa fa-retweet"  style="color:black; font-size:14px;" data-toggle="tooltip" title="Regenerar xml que estan de baja"></i>Regenerar xml</a>
                  </li>


                   <li>
                    <a onclick="enviarxmlSUNATbajas('.$reg->idboleta.')"><i class="fa fa-send"  style="color:black; font-size:18px;" data-toggle="tooltip" title="Enviar a SUNAT que estan de baja" ></i>Enviar a SUNAT</a>
                  </li>

                   <li>
                    <a onclick="consultarcdr('.$reg->idboleta.')" ><i class="fa fa-refresh"  style="color:red; font-size:18px;" data-toggle="tooltip" title="Enviar a SUNAT" ></i>Reconsultar a SUNAT</a>
                  </li>


                  <li>
                    <a onclick="cambiartarjetadc('.$reg->idboleta.')" ><i class="fa fa-credit-card"></i> Cambiar a tarjeta</a>
                  </li>

                  <li>
                    <a onclick="montotarjetadc('.$reg->idboleta.')" ><i class="fa fa-money"></i> Modificar monto tarjeta </a>
                  </li>


                  <li>
                    <a onclick="cambiartransferencia('.$reg->idboleta.')" ><i class="fa fa-exchange"></i> Cambiar a transferencia </a>
                  </li>

                  <li>
                    <a onclick="montotransferencia('.$reg->idboleta.')" ><i class="fa fa-money"></i> Modificar monto transferencia </a>
                  </li>


                   </ul>
                </div>',

                "10"=>($reg->estado=='1' || $reg->estado=='4' )?'<input type="checkbox"  id="chid[]"  name="chid[]">':'<input type="checkbox"  id="chid[]"  name="chid[]" style="display:none;">'


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



    case 'envioautomatico':
 $idempr=$_SESSION['idempresa'];
        $rspta=$boleta->listar($_SESSION['idempresa']);
        
        while ($reg=$rspta->fetch_object()){
            if ($reg->estado=='1') {
                //Validar si existe el archivo firmado
                $boleta->generarxml($reg->idboleta, $_SESSION['idempresa']);
            }elseif ($reg->estado=='4'){
                $boleta->enviarxmlSUNAT($reg->idboleta, $_SESSION['idempresa']);
            }
        }
 
    break;




    

    case 'autonumeracion':
    
    $numeracion=new Numeracion();
    $Ser=$_GET['ser'];
    $idempresa=$_GET['idempresa'];
    $rspta=$numeracion->llenarNumeroBoleta($Ser, $idempresa);
        while ($reg=$rspta->fetch_object())
        {
        echo $reg->Nnumero;    
        }
    break;


    case 'listarClientesboletaxDoc':
        require_once "../modelos/Persona.php";
        $persona=new Persona();
        $doc=$_GET['doc'];
        $rspta = $persona->buscarClientexDocBoleta($doc);
        
        echo json_encode($rspta);
        
        break;

    case 'enviarcorreo':
        $idb=$_GET['idbol'];
        $correo=$_GET['ema'];
        $rspta=$boleta->enviarcorreo($idb, $correo);
        echo $rspta ;
    break;


    case 'listarDR':

    $ano=$_GET['ano'];
    $mes=$_GET['mes'];
    //$idempresa=$_GET['idempresa'];

        $rspta=$boleta->listarDR($ano, $mes, $_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
        $data[]=array(
                "0"=>$reg->fecha,
                "1"=>$reg->numeroboleta,
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
                ?'<button class="btn btn-warning"  onclick="ConsultaDR('.$reg->idboleta.')"> <i class="fa fa-eye" data-toggle="tooltip" title="Ver documento" ></i> </button>':''
            );
    }
    $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
        break;

    case 'downFtp':
        $rspta=$boleta->downftp($idboleta, $_SESSION['idempresa']);
        echo json_encode($rspta);
    break;


    case 'selectunidadmedida':
        require_once "../modelos/Consultas.php";
        $consulta = new Consultas();

        $iiddaa=$_GET['idar'];
 
        $rspta = $consulta->selectumedidadearticulo($iiddaa);
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->abre . '>' . $reg->nombreum . '</option>';

                }
    break;


     case 'listarArticulosboleta':

        require_once "../modelos/Rutas.php";
        $rutas = new Rutas();
        $Rrutas = $rutas->mostrar2("1");
        $Prutas = $Rrutas->fetch_object();
        $rutaarti=$Prutas->rutaarticulos; 
        
        $tipob=$_GET['tb'];
        $tipoprecio=$_GET['tprecio'];
        $tmm=$_GET['itm'];

         $almacen=$_GET['alm'];
        
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();



        if ($tmm=='0') {
        $rspta=$articulo->listarActivosVentaumventa($_SESSION['idempresa'], $tipob, $almacen, $tipoprecio);

        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->stock <= $reg->limitestock)?'<label style="color: red;">Limite stock es: </label>'. '<label style="color: red;">'.$reg->limitestock.'</label>'   
                                                : 
                '<button class="btn btn-warning btn-circle" onclick="agregarDetalle(0,'.$reg->idarticulo.',\''.$reg->familia.'\',\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.htmlspecialchars($reg->nombre).'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->abre.'\' ,\''.$reg->precio_unitario.'\',\''.$reg->cicbper.'\', \''.$reg->mticbperu.'\' , \''.$reg->factorconversion.'\' , \''.$reg->factorc.'\' , \''.str_replace ("\r\n", " ", $reg->descrip).'\',  \''.$reg->tipoitem.'\', \''.$reg->combustible.'\')">
                <span class="fa fa-clone" data-toggle="tooltip" title="Agregar continuo">
                </span>
                </button>'
                    .
                '<button class="btn btn-success btn-circle" onclick="agregarDetalle(1,'.$reg->idarticulo.',\''.$reg->familia.'\',\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.htmlspecialchars($reg->nombre).'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->abre.'\' ,\''.$reg->precio_unitario.'\',\''.$reg->cicbper.'\', \''.$reg->mticbperu.'\' , \''.$reg->factorconversion.'\' , \''.$reg->factorc.'\' , \''.str_replace ("\r\n", " ", $reg->descrip).'\',  \''.$reg->tipoitem.'\', \''.$reg->combustible.'\')">
                <span class="fa fa-outdent" data-toggle="tooltip" title="Agregar individual">
                </span>
                </button>',
                "1"=>$reg->nombre,
                "2"=>$reg->codigo,
                "3"=>$reg->nombreum,
                "4"=> $reg->precio_venta,
                "5"=> $reg->factorconversion,//($tipob=="productos")? $reg->factorconversion : $reg->stock,
                "6"=>($reg->imagen=="")?
                "<img src='../files/articulos/simagen.png' height='60px' width='60px'>":
                "<img  src=".$rutaarti.$reg->imagen." height='60px' width='60px'>"
                );
        }

    }else{

                $rspta=$articulo->listarActivosVentaumcompra($_SESSION['idempresa'], $tipob, $almacen, $tipoprecio);

        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->stock <= $reg->limitestock)?'<label style="color: red;">Limite stock es: </label>'. '<label style="color: red;">'.$reg->limitestock.'</label>'   
                                                : 
                '<button class="btn btn-warning" onclick="agregarDetalleItem('.$reg->idarticulo.',\''.$reg->familia.'\',\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.htmlspecialchars($reg->nombre).'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->abre.'\' ,\''.$reg->precio_unitario.'\',\''.$reg->cicbper.'\', \''.$reg->mticbperu.'\', \''.$reg->factorconversion.'\' , \''.$reg->factorc.'\', \''.str_replace ("\r\n", " ", $reg->descrip).'\',  \''.$reg->factorconversion.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->codigo,
                "3"=>$reg->nombreum,
                "4"=> $reg->precio_venta,
                "5"=>$reg->stock,
                "6"=>($reg->imagen=="")?"<img src='../files/articulos/simagen.png' height='120px' width='120px'>":
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




    case 'listarArticulosboletaItem':
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
        $tipob=$_GET['tb'];
        
        $rspta=$articulo->listarActivosVentaumventa($_SESSION['idempresa'], "productos");
        
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                 "0"=>'<button class="btn btn-warning" onclick="agregarDetalleitem('.$reg->idarticulo.',\''.$reg->familia.'\',\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.htmlspecialchars($reg->nombre).'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->abre.'\' ,\''.$reg->precio_unitario.'\',\''.$reg->cicbper.'\', \''.$reg->mticbperu.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->codigo,
                "3"=>$reg->unidad_medida,
                "4"=> $reg->precio_venta,
                "5"=>number_format($reg->stock,2),
                "6"=>""//"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
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
                "6"=>""//"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
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
        $rspta=$boleta->generarxml($idboleta, $_SESSION['idempresa']);
        echo json_encode($rspta) ;
    break;


    case 'generarenviar':
        $idbol=$_GET['idb'];
        $rspta=$boleta->generarenviar($idbol, $_SESSION['idempresa']);
        echo $rspta ;
    break;

    case 'mostrarxml':
        $rspta=$boleta->mostrarxml($idboleta, $_SESSION['idempresa']);

        if ($rspta=="") {
            $rspta="No se ha creado";
        }
        echo json_encode($rspta) ;
    break;

    case 'mostrarrpta':
        $rspta=$boleta->mostrarrpta($idboleta, $_SESSION['idempresa']);
        echo json_encode($rspta) ;
    break;

    case 'enviarxmlSUNAT':
        $rspta=$boleta->enviarxmlSUNAT($idboleta, $_SESSION['idempresa']);
        echo $rspta ;
    break;


    case 'regenerarxml':
        $rspta=$boleta->regenerarxml($idboleta, $_SESSION['idempresa']);
        echo json_encode($rspta) ;
    break;

    case 'enviarxmlSUNATbajas':
        $rspta=$boleta->enviarxmlSUNATbajas($idboleta, $_SESSION['idempresa']);
        echo $rspta ;
    break;

    case 'regenerarxmlEA':
        $ano=$_GET['anO'];
        $mes=$_GET['meS'];
        $dia=$_GET['diA'];
        $idcomprobante=$_GET['idComp'];
        $estadoOcu=$_GET['SToc'];
        $Chfac=$_GET['Ch'];
        $rspta=$boleta->generarxmlEA($ano, $mes, $dia, $idcomprobante, $estadoOcu, $Chfac, $_SESSION['idempresa']);
        echo json_encode($rspta) ;
    break;


    case 'selectAlmacen':
        
        
        $rspta = $boleta->almacenlista();
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idalmacen . '>' . $reg->nombre . '</option>';
                }
        break;

        case 'consultarcdr':
        $rspta=$boleta->reconsultarcdr($idboleta, $_SESSION['idempresa']);
        echo $rspta ;
        break;

          case 'tcambiog':
        $tcf=$_GET['feccf'];
        $rspta = $boleta->mostrartipocambio($tcf);
        echo json_encode($rspta);
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



        case 'cambiartarjetadc_':
        $opc=$_GET['opcion'];
        $rspta=$boleta->cambiartarjetadc($idboleta, $opc);
        echo $rspta ? "Cambio realizado correctamente": "Problemas al cambiar" ;
        break;

        case 'montotarjetadc_':
        $mto=$_GET['monto'];
        $rspta=$boleta->montotarjetadc($idboleta, $mto);
        echo $rspta ? "Cambio realizado correctamente": "Problemas al cambiar" ;
        break;


        case 'cambiartransferencia':
        $opc=$_GET['opcion'];
        $rspta=$boleta->cambiartransferencia($idboleta, $opc);
        echo $rspta ? "Cambio realizado correctamente": "Problemas al cambiar" ;
        break;

        case 'montotransferencia':
        $mto=$_GET['monto'];
        $rspta=$boleta->montotransferencia($idboleta, $mto);
        echo $rspta ? "Cambio realizado correctamente": "Problemas al cambiar" ;
        break;


        case 'duplicar':
        $rspta=$boleta->duplicar($idboleta);
        echo $rspta ? "Boleta ha sido duplicada" : "Boleta no se pudo duplicar";
    break;


    case 'listarnp':
        $rspta=$boleta->listarnotape();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            
            $data[]=array(
                "0"=>
                   '<button class="btn btn-warning" onclick="agregarNotapedido(
                   '.$reg->idboleta.',
                   \''.$reg->idcliente.'\',
                   \''.$reg->tdcliente.'\',
                   \''.$reg->doccliente.'\', 
                   \''.$reg->razon_social.'\',
                   \''.$reg->domicilio_fiscal.'\',
                   \''.$reg->fecha.'\',
                   \''.$reg->numeracion_07.'\',
                   \''.$reg->totalimporte.'\')"><span class="fa fa-plus"></span></button>',

                "1"=>$reg->idboleta,
                "2"=>$reg->fecha,
                "3"=>$reg->nombres,
                "4"=>$reg->numeracion_07,
                "5"=>$reg->totalimporte
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;




    case 'detalledenotapedido':

    $idcomp=$_GET['id'];
    $totalNP="";
    $igvNP="";
    $subtotalNP="";
    $rsptaf=$boleta->buscarComprobanteIdNotaPedido($idcomp);
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
       
    echo '<tfoot>
                            <tr>
                            <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                             <th id="Titulo" style="font-weight: bold; vertical-align: center; background-color:#FFB887;">TOTAL</th>  
                             
                            <th id="CuadroT" style="font-weight: bold; background-color:#FFB887;">

                                   <h4 id="total" style="font-weight: bold; vertical-align: center; background-color:#FFB887;">'.$totalNP.'</h4>

    <input type="hidden" name="total_final" id="total_final" value="'.$totalNP.'">
    <input type="hidden" name="pre_v_u" id="pre_v_u">
    <input type="hidden" name="subtotal_boleta" id="subtotal_boleta" value='.$subtotalNP.'>
    <input type="hidden" name="total_igv" id="total_igv" value="'.$igvNP.'">
                      </th>

                      <!--Datos de impuestos-->  <!--TOTAL-->
                    <input type="hidden" name="saldo_final" id="saldo_final"></th>
                    <!--Datos de impuestos-->  <!--TOTAL-->

                            </th>
                            <!--Datos de impuestos-->  <!--TOTAL-->
                                    </td>
                                    </tr>
                          

                           
                   </tfoot>';
   



   break;



     case 'guardarrangosfac':
        if (empty($idnotificacion)){
            $rspta=$boleta->duplicarrangos($idfactu1, $idfactu2, $serier);
            echo $rspta ? "Registro correcto ENTRE RANGOS" : "No se pudo registrar";
        }
        break;

}


?>