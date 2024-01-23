<?php

if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Notacd.php";
require_once "../modelos/Numeracion.php";
$notacd=new Notacd();
$idusuario=$_SESSION["idusuario"];
$idnota=isset($_POST["idnota"])? limpiarCadena($_POST["idnota"]):"";
$idcomprobante=isset($_POST["idcomprobante"])? limpiarCadena($_POST["idcomprobante"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$serie=isset($_POST["SerieReal"])? limpiarCadena($_POST["SerieReal"]):"";
$numero_nc=isset($_POST["numero_nc"])? limpiarCadena($_POST["numero_nc"]):"";
$fecha=isset($_POST["fecha_emision"])? limpiarCadena($_POST["fecha_emision"]):"";
$codigo_nota=isset($_POST["codigo_nota"])? limpiarCadena($_POST["codigo_nota"]):"";
$codtiponota=isset($_POST["codtiponota"])? limpiarCadena($_POST["codtiponota"]):"";

$desc_motivo=isset($_POST["desc_motivo"])? limpiarCadena($_POST["desc_motivo"]):"";
$motivonota=isset($_POST["nomcodtipo"])? limpiarCadena($_POST["nomcodtipo"]):""; //Nuevo

$tipocomprobante=isset($_POST["tipocomprobante"])? limpiarCadena($_POST["tipocomprobante"]):"";
$numero_comprobante=isset($_POST["numero_comprobante"])? limpiarCadena($_POST["numero_comprobante"]):"";

$tipo_doc_ide=isset($_POST["tipo_documento_cliente"])? limpiarCadena($_POST["tipo_documento_cliente"]):"";
$numero_documento=isset($_POST["numero_documento_cliente"])? limpiarCadena($_POST["numero_documento_cliente"]):"";
$razon_social=isset($_POST["razon_social"])? limpiarCadena($_POST["razon_social"]):"";
$tipo_moneda=isset($_POST["tipo_moneda"])? limpiarCadena($_POST["tipo_moneda"]):"";
$sum_ot_car=isset($_POST["sum_ot_car"])? limpiarCadena($_POST["sum_ot_car"]):"";
$total_val_venta_oi=isset($_POST["total_val_venta_oi"])? limpiarCadena($_POST["total_val_venta_oi"]):"";
$total_val_venta_oe=isset($_POST["total_val_venta_oe"])? limpiarCadena($_POST["total_val_venta_oe"]):"";
$sum_isc=isset($_POST["sum_isc"])? limpiarCadena($_POST["sum_isc"]):"";
$sum_ot=isset($_POST["sum_ot"])? limpiarCadena($_POST["sum_ot"]):"";

//totales iguales en nota de credito y debito
$subtotal=isset($_POST["subtotal_comprobante"])? limpiarCadena($_POST["subtotal_comprobante"]):"";
$igv_=isset($_POST["total_igv"])? limpiarCadena($_POST["total_igv"]):"";
$total=isset($_POST["total_final"])? limpiarCadena($_POST["total_final"]):"";
//

$tipo_doc_mod=isset($_POST["tipo_doc_mod"])? limpiarCadena($_POST["tipo_doc_mod"]):"";
$idserie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";
$fecha_factura=isset($_POST["fecha_factura"])? limpiarCadena($_POST["fecha_factura"]):"";
$hora=isset($_POST["hora"])? limpiarCadena($_POST["hora"]):"";
$hora2=isset($_POST["hora2"])? limpiarCadena($_POST["hora2"]):"";
$fecha2=isset($_POST["fecha2"])? limpiarCadena($_POST["fecha2"]):"";
$adicional=isset($_POST["adicional"])? limpiarCadena($_POST["adicional"]):"";

//SI NOTA DE CREDITO ES PARA ANULAR TODA LA OPERACION
$subtotal_facturaNC=isset($_POST["subtotal_facturaNC"])? limpiarCadena($_POST["subtotal_facturaNC"]):"";
$total_igvNC=isset($_POST["total_igvNC"])? limpiarCadena($_POST["total_igvNC"]):"";
$total_finalNC=isset($_POST["total_finalNC"])? limpiarCadena($_POST["total_finalNC"]):"";

$tiponotaC=isset($_POST["tiponotaC"])? limpiarCadena($_POST["tiponotaC"]):"";

//Nuevas variables de nota de debito
$cantidadnd=isset($_POST["cantidadnd"])? limpiarCadena($_POST["cantidadnd"]):"";
$vunitariond=isset($_POST["vunitariond"])? limpiarCadena($_POST["vunitariond"]):"";
$totalnd=isset($_POST["totalnd"])? limpiarCadena($_POST["totalnd"]):"";


//SI LA NOTA DE CREDITO ES POR DESCUENTO GLOBAL
$subtotaldesc=isset($_POST["subtotaldesc"])? limpiarCadena($_POST["subtotaldesc"]):"";
$igvdescu=isset($_POST["igvdescu"])? limpiarCadena($_POST["igvdescu"]):"";
$totaldescu=isset($_POST["totaldescu"])? limpiarCadena($_POST["totaldescu"]):"";

$vendedorsitio=isset($_POST["vendedorsitio"])? limpiarCadena($_POST["vendedorsitio"]):"";
$idempresa=isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";
$tipodoc_mod=isset($_POST["tipo_doc_mod"])? limpiarCadena($_POST["tipo_doc_mod"]):"";

switch ($_GET["op"]){
    case 'guardaryeditarnc':
        if (empty($idnota)){

            if ($tiponotaC=='7') { //Si es nota de credito por item.
        $rspta=$notacd->insertarNC($idnota, $nombre, $serie, $numero_nc , $fecha, $codigo_nota, $codtiponota, $desc_motivo, $tipocomprobante, $numero_comprobante, $tipo_doc_ide, $numero_documento, $razon_social, $tipo_moneda, $sum_ot_car, $subtotal_facturaNC, $total_val_venta_oi, $total_val_venta_oe, $total_igvNC, $sum_isc, $sum_ot, $total_finalNC, $idserie, $idcomprobante, $fecha_factura, $hora, $tiponotaC, $_POST["idarticulo"], $_POST["codigo"], $_POST["cantidad"], $_POST["pvt"], $_POST["unidad_medida"], $_POST["igvBD"], $_POST["valor_unitario"],  $_POST["subtotalBD"], $vendedorsitio, $idempresa, $tipodoc_mod, $tipodoc_mod, $motivonota,  $_POST["aigv"], $_POST["codtrib"], $_POST["nomtrib"], $_POST["coditrib"], $_POST["numorden"], $_POST["descarti"]);

        $tipodocu=$_GET['tipodo'];
            if($tipodocu=="01"){
            //Nota creedito
            require_once "../modelos/Notacf.php";
            $notacf=new Notacf( );
            //Solo actualiza el stock y no anula el comprobante
            $rsptaf=$notacf->anularFacturaxItem($idcomprobante, $_POST["idarticulo"] , $_POST["cantidad"]);
            }

            if($tipodocu=="03"){
            require_once "../modelos/Notacb.php";
            $notacb=new Notacb();
            $rsptab=$notacb->anularBoletaxItem($idcomprobante, $_POST["idarticulo"] , $_POST["cantidad"]);
            }
            
            echo $rspta ? "Nota de crédito por item registrada" : "No se pudieron registrar todos los datos de la Nota de crédito";
            



            }elseif ($tiponotaC=='4'){ //Descuento global



                 $rspta=$notacd->insertarNCxDescuentoGlobal($idnota, $nombre, $serie, $numero_nc , $fecha, $codigo_nota, $codtiponota, $desc_motivo, $tipocomprobante, $numero_comprobante, $tipo_doc_ide, $numero_documento, $razon_social, $tipo_moneda, $sum_ot_car, $subtotaldesc, $total_val_venta_oi, $total_val_venta_oe, $igvdescu, $sum_isc, $sum_ot, $totaldescu, $idserie, $idcomprobante, $fecha_factura, $hora, $tiponotaC, $vendedorsitio, $idempresa, $tipodoc_mod, $motivonota);
                 echo $rspta ? "Nota de crédito registrada" : "No se pudieron registrar todos los datos de la Nota de crédito";
            } 

            else

                
            { //================= SI ES UNA NOTA DE CREDITO POR ANULACION TOTAL

    $rspta=$notacd->insertarNC($idnota, $nombre, $serie, $numero_nc , $fecha, $codigo_nota,$codtiponota, $desc_motivo, $tipocomprobante, $numero_comprobante, $tipo_doc_ide, $numero_documento, $razon_social, $tipo_moneda, $sum_ot_car, $subtotal, $total_val_venta_oi, $total_val_venta_oe, $igv_, $sum_isc, $sum_ot, $total, $idserie, $idcomprobante, $fecha_factura, $hora, $tiponotaC,'','','','','','','','', $vendedorsitio, $idempresa, $tipodoc_mod, $motivonota, '','','','','', $_POST["descarti"]);

        $tipodocu=$_GET['tipodo'];  //Para anular y actualizar el stock de los productos que se regresan
        if($tipodocu=="01"){
            //Nota creedito
            require_once "../modelos/Notacf.php";
            $notacf=new Notacf();
            $rsptaf=$notacf->anularFactura($idcomprobante);
            }

            if ($tipodocu=="03"){
            require_once "../modelos/Notacb.php";
            $notacb=new Notacb();
            $rsptab=$notacb->anularBoleta($idcomprobante);
            }

            echo $rspta ? "Nota de crédito registrada" : "No se pudo registrar la Nota de crédito completo";
            }

    }
    break;



case 'guardaryeditarnd':
        if (empty($idnota)){
        $rspta=$notacd->insertarND($idnota, $nombre, $serie, $numero_nc , $fecha, $codigo_nota,$codtiponota, $desc_motivo, $tipocomprobante, $numero_comprobante, $tipo_doc_ide, $numero_documento, $razon_social, $tipo_moneda, $sum_ot_car, $subtotaldesc, $total_val_venta_oi, $total_val_venta_oe, $igvdescu, $sum_isc, $sum_ot, $totaldescu, $idserie,$idcomprobante, $fecha2, $hora2, '0', $vendedorsitio, $idempresa, $tipodoc_mod, $motivonota);
        $tipodocu=$_GET['tipodo'];

        echo $rspta ? "Nota de débito registrada" : "No se pudieron registrar todos los datos de la Nota de débito";
                }
    break;


 
    case 'actualizarNumero':
            require_once "../Modelos/Numeracion.php";
            $numeracion=new Numeracion();

            $num=$_GET['Num'];
            $idnumeracion=$_GET['Idnumeracion'];
            $rspta=$numeracion->UpdateNumeracion($num, $idnumeracion );
    break;
 
  
    case 'listarNC':
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


        $rspta=$notacd->listarNC($_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            if($reg->codigo_nota=='07'){
                if ($reg->tipo_doc_mod=='01') {
                $url='../reportes/exNcredito.php?id=';
                $urlT='../reportes/exNotaCreditoTicket.php?id=';
                $urlTipo='&tipodoc=';
                }else{
                $url='../reportes/exNcredito.php?id=';
                $urlT='../reportes/exNotaCreditoTicketBoleta.php?id=';
                $urlTipo='&tipodoc=';

                }
            }

$stt='';
$sunatFirma=''; 
$sunatAceptado='Class'; 

// $mon="";
// if ($reg->tipo_moneda=="USD")
// {
// $mon='<i style="color:green;" data-toggle="tooltip" title="Por T.C. '.$reg->tcambio.' = '.$reg->valordolsol.' PEN">$</i>';
// }

               /* if ($reg->estado=='5') {
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
                     $stt='none'; 
                     $url='../reportes/exNcredito.php?id='; 
                     $sunat='';  
                }

                if ($reg->estado=='0') {
                     $stt='none'; 
                     $url='../reportes/exNcredito.php?id=';  
                     $sunat=''; 
                }*/

                $estadoenvio='1';
    //=====================================================================================

            $data[]=array(
                
"0"=> 

                '<div class="dropup">
                <button  class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                :::
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-center">
                <li>
                     <a target="_blank" href="'.$url.$reg->idnota.$urlTipo.$reg->tipo_doc_mod.'">  <i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir formato 2 copias" onclick=""></i> Imprimir Nota
                    </a>
                </li>


                  <li>
                  <a  onclick="baja('.$reg->idnota.')" color:red;"> 
                   <i class="fa fa-level-down"  data-toggle="tooltip" title="Dar de baja" onclick=""></i>Dar de 
                   baja
                    </a>

                  </li>

                  </ul>
                  </div>',
                    
            //         '<a target="_blank" href="'.$url.$reg->idnota.$urlTipo.$reg->tipo_doc_mod.'"> <button class="btn btn-info" data-toggle="tooltip" title="Imprimir Nota de crédito"><i class="fa  fa-print" > </i></button>
            //         </a>'

            // .
            //  '<button class="btn btn-info"  data-toggle="tooltip" title="Enviar por correo a: '.$reg->email.'" onclick="enviarcorreo('.$reg->idnota.')" '.$send.'><i class="fa fa-send"></i></button>'
            //          ,
                                    
                "1"=>$reg->numeroserienota,
                "2"=>$reg->fecha,
                "3"=>$reg->descripcion,
                "4"=>$reg->serie_numero,
                "5"=>$reg->razon_social,
                "6"=>$reg->total_val_venta_og,
                "7"=>$reg->sum_igv,
                "8"=>$reg->importe_total,

                //Actualizado ===============================================
                "9"=>($reg->estado=='1')//si esta emitido
                ?'<span style="color:#BA4A00;">'.$reg->DetalleSunat.'</span>'
            : (($reg->estado=='4')    ?'<span style="color:#239B56;">'.$reg->DetalleSunat.'</span>' //si esta firmado
            : (($reg->estado=='3' )?'<span style="color:#E59866;">'.$reg->DetalleSunat.'</span>' // si esta de baja
            : (($reg->estado=='0')?'<span style="color:#E59866;">c/nota</span>'  //si esta firmado
            : (($reg->estado=='5')?'<span style="color:#145A32;">'.$reg->DetalleSunat.'</span>' // Si esta aceptado por SUNAT
            : '<span style="color:#239B56;">'.$reg->DetalleSunat.'</span>' )))),
            //Opciones de envio
            "10"=>

            '<div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                Opciones
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-right">

                  <li>
                    <a onclick="generarxml('.$reg->idnota.')" '.$sunatFirma.'="class_a_href">
                    <i class="fa fa-download"  style="color:orange;" data-toggle="tooltip" title="Generar xml"> Generarl xml</i>
                    </a>
                  </li>


                  <li>
                   <a onclick="enviarxmlSUNAT('.$reg->idnota.')" ><i class="fa fa-send"  style="color:red; font-size:18px;" data-toggle="tooltip" title="Enviar a SUNATsss" ></i>Enviar a SUNATasdasdasdasd</a>
                  </li>

                   <li>
                   <a onclick="mostrarxml('.$reg->idnota.')"><i class="fa fa-check" style="color:orange; "  data-toggle="tooltip" title="Mostrar XML"> Mostrar XML</i></a>
                  </li>

                  <li>
                   <a onclick="mostrarrpta('.$reg->idnota.')"><i class="fa fa-check" style="color:green; "  data-toggle="tooltip" title="Mostrar respuesta CDR"> Mostrar CDR</i></a>
                  </li>


                 <li>
                   <a href="https://bit.ly/31qZoI1" target=_blank >  <img src="../public/images/sunat.png" style="color:green; "  data-toggle="tooltip" title="Consulta de validez con SUNAT"> Validar en SUNAT</i></a>
                  </li>



                   </ul>
                </div>'

                );
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
 
    break;


    case 'listarNCDia':
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


        $rspta=$notacd->listarNCDia($_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            if($reg->codigo_nota=='07'){
                if ($reg->tipo_doc_mod=='01') {
                $url='../reportes/exNcredito.php?id=';
                $urlT='../reportes/exNotaCreditoTicket.php?id=';
                $urlTipo='&tipodoc=';
                }else{
                $url='../reportes/exNcredito.php?id=';
                $urlT='../reportes/exNotaCreditoTicketBoleta.php?id=';
                $urlTipo='&tipodoc=';

                }
            }
$stt='';
$sunatFirma=''; 
$sunatAceptado='Class'; 

                $estadoenvio='1';
    //=====================================================================================

            $data[]=array(
                
                "0"=> 

                '<div class="dropup">
                <button  class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                :::
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-center">
                <li>
                     <a target="_blank" href="'.$url.$reg->idnota.$urlTipo.$reg->tipo_doc_mod.'">  <i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir formato 2 copias" onclick=""></i>
                     Imprimir Nota
                    </a>
                </li>


                  <li>
                  <a  onclick="baja('.$reg->idnota.')" color:red;"> 
                   <i class="fa fa-level-down"  data-toggle="tooltip" title="Dar de baja" onclick=""></i>Dar de 
                   baja
                    </a>

                  </li>

                  </ul>
                  </div>',
                    
            //         '<a target="_blank" href="'.$url.$reg->idnota.$urlTipo.$reg->tipo_doc_mod.'"> <button class="btn btn-info" data-toggle="tooltip" title="Imprimir Nota de crédito"><i class="fa  fa-print" > </i></button>
            //         </a>'

            // .
            //  '<button class="btn btn-info"  data-toggle="tooltip" title="Enviar por correo a: '.$reg->email.'" onclick="enviarcorreo('.$reg->idnota.')" '.$send.'><i class="fa fa-send"></i></button>'
            //          ,
                                    
                "1"=>$reg->numeroserienota,
                "2"=>$reg->fecha,
                "3"=>$reg->descripcion,
                "4"=>$reg->serie_numero,
                "5"=>$reg->razon_social,
                "6"=>$reg->total_val_venta_og,
                "7"=>$reg->sum_igv,
                "8"=>$reg->importe_total,

                //Actualizado ===============================================
                "9"=>($reg->estado=='1')//si esta emitido
                ?'<span style="color:#BA4A00;">'.$reg->DetalleSunat.'</span>'
            : (($reg->estado=='4')    ?'<span style="color:#239B56;">'.$reg->DetalleSunat.'</span>' //si esta firmado
            : (($reg->estado=='3' )?'<span style="color:#E59866;">'.$reg->DetalleSunat.'</span>' // si esta de baja
            : (($reg->estado=='0')?'<span style="color:#E59866;">c/nota</span>'  //si esta firmado
            : (($reg->estado=='5')?'<span style="color:#145A32;">'.$reg->DetalleSunat.'</span>' // Si esta aceptado por SUNAT
            : '<span style="color:#239B56;">'.$reg->DetalleSunat.'</span>' )))),
            //Opciones de envio
            "10"=>

            '<div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                Opciones
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-right">

                  <li>
                    <a onclick="generarxml('.$reg->idnota.')" '.$sunatFirma.'="class_a_href">
                    <i class="fa fa-download"  style="color:orange;" data-toggle="tooltip" title="Generar xml"> 
                    </i>Generar xml
                    </a>
                  </li>


                  <li>
                   <a onclick="enviarxmlSUNAT('.$reg->idnota.')" >
                   <i class="fa fa-send"  style="color:red; font-size:18px;" data-toggle="tooltip" title="Enviar a SUNAT">

                   </i> Enviar a SUNAT
                   </a>
                  </li>


                   <li>
                   <a onclick="mostrarxml('.$reg->idnota.')"><i class="fa fa-check" style="color:orange; "  data-toggle="tooltip" title="Mostrar XML"></i>
                    Mostrar XML
                    </a>
                  </li>

                  <li>
                   <a onclick="mostrarrpta('.$reg->idnota.')"><i class="fa fa-check" style="color:green; "  data-toggle="tooltip" title="Mostrar respuesta CDR"></i>
                   Mostrar CDR
                   </a>
                  </li>


                 <li>
                   <a href="https://bit.ly/31qZoI1" target=_blank >  <img src="../public/images/sunat.png" style="color:green; "  data-toggle="tooltip" title="Consulta de validez con SUNAT"> Validar en SUNAT</i></a>
                  </li>



                   </ul>
                </div>'



            // '<a><i class="fa fa-download" style="color:#2acc70; "  data-toggle="tooltip" title="Descargar JSON" onclick="downFtp('.$reg->idnota.')"  ></i></a>
            // <a onclick="generarxml('.$reg->idnota.')" '.$sunatFirma.'="class_a_href"><i class="fa fa-download"  style="color:orange; " data-toggle="tooltip" title="Generar xml"   ></i></a>
            // <a onclick="enviarxmlSUNAT('.$reg->idnota.')"  '.$sunatAceptado.'="class_a_href" ><i class="fa fa-send"  style="color:red; " data-toggle="tooltip" title="Enviar a SUNAT" ></i></a>
            // <a onclick="mostrarxml('.$reg->idnota.')"><i class="fa fa-check" style="color:orange; "  data-toggle="tooltip" title="Mostrar XML"></i></a>
            // <a onclick="mostrarrpta('.$reg->idnota.')"><i class="fa fa-check" style="color:green; "  data-toggle="tooltip" title="Mostrar respuesta CDR"   ></i></a>
            // <a href="https://bit.ly/31qZoI1" target=_blank >  <img src="../public/images/sunat.png" style="color:green; "  data-toggle="tooltip" title="Consulta de validez con SUNAT"   ></i></a>
            //  <a onclick="generarxml('.$reg->idnota.')" ><i class="fa fa-retweet"  style="color:orange; font-size:14px;" data-toggle="tooltip" title="Generar xml"   ></i></a>'

                );
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
 
    break;

    case 'enviarcorreo':
        $rspta=$notacd->enviarcorreo($idnota);
        echo $rspta ;
    break;


    case 'listarND':
    $idempresa=$_GET['idempresa'];
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
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

        $rspta=$notacd->listarND($idempresa);
        //Vamos a declarar un array
        $data= Array();
 

            while ($reg=$rspta->fetch_object()){
            if($reg->codigo_nota=='08'){
                if ($reg->tipo_doc_mod=='01') {
                $url='../reportes/exNdebito.php?id=';
                $urlT='../reportes/exNotaDebitoTicket.php?id=';
                $urlTipo='&tipodoc=';
                }else{
               $url='../reportes/exNdebito.php?id=';
               $urlT='../reportes/exNotaDebitoTicketBol.php?id=';
               $urlTipo='&tipodoc=';

                }
            }





            //==============Agregar====================================================
 //    $archivo=$reg->numero_ruc."-".$reg->codigo_nota."-".$reg->numeroserienota;
 //    $archivo2="R".$reg->numero_ruc."-".$reg->codigo_nota."-".$reg->numeroserienota;

 // //Validar si existe el archivo firmado
 //    foreach($files as $file){
 //    // Divides en dos el nombre de tu archivo utilizando el . 
 //    $dataSt = explode(".", $file);
 //    // Nombre del archivo
 //    $fileName = $dataSt[0];
 //    $st="1";
 //    // Extensión del archivo 
 //    $fileExtension = $dataSt[1];
 //    if($archivo == $fileName){
 //        $st="4";
 //        $UpSt=$notacd->ActualizarEstado($reg->idnota, $st,'',$reg->tipo_doc_mod, '');
 //        // Realizamos un break para que el ciclo se interrumpa
 //         break;
 //      }
 //    }

 //    //Validar si existe el archivo firmado
 //    foreach($files2 as $file2){
 //    // Divides en dos el nombre de tu archivo utilizando el . 
 //    $dataSt2 = explode(".", $file2);
 //    // Nombre del archivo
 //    $fileName = $dataSt2[0];
 //    // Extensión del archivo 
 //    $fileExtension = $dataSt2[1];
 //    if($archivo2 == $fileName){
 //        $st="5";
 //        $UpSt=$notacd->ActualizarEstado($reg->idnota, $st, $reg->idcomprobante, $reg->tipo_doc_mod,  $reg->serie_numero );
 //        // Realizamos un break para que el ciclo se interrumpa
 //         break;
 //      }
 //    }





$stt='';
$sunatFirma=''; 
$sunatAceptado='Class'; 

                if ($reg->estado=='5') {
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
                     $stt='none'; 
                     $url='../reportes/exNcredito.php?id='; 
                     $sunat='';  
                }

                if ($reg->estado=='0') {
                     $stt='none'; 
                     $url='../reportes/exNcredito.php?id=';  
                     $sunat=''; 
                }

                $estadoenvio='1';
    //=====================================================================================

            $data[]=array(
                  "0"=> 
                    
                    '<a target="_blank" href="'.$url.$reg->idnota.$urlTipo.$reg->tipo_doc_mod.'"><i class="fa  fa-print" data-toggle="tooltip" title="Imprimir Nota"> </i>
                    </a>'

                    ,
                                    
                "1"=>$reg->numeroserienota,
                "2"=>$reg->fecha,
                "3"=>$reg->descripcion,
                "4"=>$reg->serie_numero,
                "5"=>$reg->razon_social,
                "6"=>$reg->total_val_venta_og,
                "7"=>$reg->sum_igv,
                "8"=>$reg->importe_total,

                //Actualizado ===============================================
                "9"=>($reg->estado=='1')//si esta emitido
                ?'<i class="fa fa-file-text-o" style="font-size: 14px; color:#BA4A00;"> <span>'.$reg->DetalleSunat.'</span><i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span></i>'
            : (($reg->estado=='4')    ?'<i class="fa fa-thumbs-up" style="font-size: 14px; color:#239B56;"> <span>'.$reg->DetalleSunat.'</span> </i>' //si esta firmado
            : (($reg->estado=='3' )?'<i class="fa fa-dot-circle-o" style="font-size: 14px; color:#E59866;"> <span>Ba'.$reg->DetalleSunat.'ja</span></i> ' // si esta de baja
            : (($reg->estado=='0')?'<i class="fa fa-dot-circle-o" style="font-size: 14px; color:#E59866;"> <span>'.$reg->DetalleSunat.'</span></i> '  //si esta firmado
            : (($reg->estado=='5')?'<i class="fa fa-globe" style="font-size: 14px; color:#145A32;"> <span>'.$reg->DetalleSunat.'</span></i> ' // Si esta aceptado por SUNAT
            : '<i class="fa fa-newspaper" style="font-size: 14px; color:#239B56;"> <span>'.$reg->DetalleSunat.'</span></i> ' )))),
            //Opciones de envio
            "10"=>
            '
            <a onclick="generarxmlNd('.$reg->idnota.')" '.$sunatFirma.'="class_a_href"><i class="fa fa-download"  style="color:orange; " data-toggle="tooltip" title="Generar xml"   ></i></a>
            <a onclick="enviarxmlSUNAT('.$reg->idnota.')"  '.$sunatAceptado.'="class_a_href" ><i class="fa fa-send"  style="color:red; " data-toggle="tooltip" title="Enviar a SUNAT" ></i></a>
            <a onclick="mostrarxml('.$reg->idnota.')"><i class="fa fa-check" style="color:orange; "  data-toggle="tooltip" title="Mostrar XML"></i></a>
            <a onclick="mostrarrpta('.$reg->idnota.')"><i class="fa fa-check" style="color:green; "  data-toggle="tooltip" title="Mostrar respuesta CDR"   ></i></a>
            '

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
    $idempresa=$_GET['idempresa'];
    $rspta=$numeracion->llenarNumeroNcredito($Ser, $idempresa);
        while ($reg=$rspta->fetch_object())
        {
        echo $reg->Nnumero;    
        }
    break;


     case 'autonumeracionDebito':
    
    $numeracion=new Numeracion();
    $Ser=$_GET['ser'];
    $idempresa=$_GET['idempresa'];
    $rspta=$numeracion->llenarNumeroNdedito($Ser, $idempresa);
        while ($reg=$rspta->fetch_object())
        {
        echo $reg->Nnumero;    
        }
    break;

//====================================================================================
    
    case 'selectcatalogo9':
        require_once "../modelos/Notacd.php";

        $departamento = new Notacd(); 
        $rspta = $departamento->selectD();
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->codigo . '>' . $reg->descripcion . '</option>';
                }
    break;

    case 'selectcatalogo10':
        require_once "../modelos/Notacd.php";

        $departamento = new Notacd(); 
        $rspta = $departamento->selectDebito();
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->codigo . '>' . $reg->descripcion . '</option>';
                }
    break;



    case 'selectSerie':
    //$idempresa=$_GET['idempresa'];
        require_once "../modelos/Numeracion.php";
        $numeracion = new Numeracion();
 
        $rspta = $numeracion->llenarSerieNcredito($idusuario);
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idnumeracion . '>' . $reg->serie . '</option>';

                }
    break; 

    case 'selectSerieDebito':
        require_once "../modelos/Numeracion.php";
        $numeracion = new Numeracion();
 
        $rspta = $numeracion->llenarSerieNdebito($idusuario);
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idnumeracion . '>' . $reg->serie . '</option>';

                }
    break; 



case 'listarComprobante':

    $tipodocu=$_GET['tipodo'];
    $idempresa=$_GET['idempresa'];
    $mone=$_GET['mo'];

    if($tipodocu=='01'){
       require_once "../modelos/Notacf.php";
        $notacf=new Notacf();
        $rsptaf=$notacf->buscarComprobante($idempresa, $mone);
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rsptaf->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning btn-sm" onclick="agregarComprobante('.$reg->idfactura.',\''.$reg->tdcliente.'\',\''.$reg->ndcliente.'\',\''.$reg->rzcliente.'\',\''.$reg->domcliente.'\', \''.$reg->tipocomp.'\',\''.$reg->numerodoc.'\',\''.$reg->subtotal.'\',\''.$reg->igv.'\',\''.$reg->total.'\' ,\''.$reg->fecha1.'\',\''.$reg->fecha2.'\')"><span class="fa fa-plus"></span></button>',

                "1"=>$reg->ndcliente,
                "2"=>$reg->fecha1,
                "3"=>$reg->rzcliente,
                
                "4"=>$reg->numerodoc,
                "5"=>$reg->tmoneda,
                "6"=>$reg->subtotal,
                "7"=>$reg->igv,
                "8"=>$reg->total
                );
        }
        $results = array( 
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);

   


    }else if($tipodocu=='03'){ // sis es boleta

        require_once "../modelos/Notacb.php";
        $notacb=new Notacb();
        $rsptab=$notacb->buscarComprobante($idempresa, $mone);
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rsptab->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning btn-sm" onclick="agregarComprobante('.$reg->idboleta.',\''.$reg->tipo_documento.'\',\''.$reg->numero_documento.'\',\''.$reg->razon_social.'\',\''.$reg->domicilio.'\', \''.$reg->tipocomp.'\',\''.$reg->numerodoc.'\',\''.$reg->subtotal.'\',\''.$reg->igv.'\',\''.$reg->total.'\',\''.$reg->fecha1.'\',\''.$reg->fecha2.'\')"><span class="fa fa-plus"></span></button>',

                "1"=>$reg->numero_documento,
                "2"=>$reg->fecha1,
                "3"=>$reg->razon_social,
                
                "4"=>$reg->numerodoc,
                "5"=>$reg->tmoneda,
                "6"=>$reg->subtotal,
                "7"=>$reg->igv,
                "8"=>$reg->total
                );
        }
      
        $results = array( 
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);

    



        }
   break;







    case 'detalle':

    $tipodocu=$_GET['tipo'];
    $idcomp=$_GET['id'];
    

    if($tipodocu=="01"){ //FACTURA 
        require_once "../modelos/Notacf.php";
        $notacf=new Notacf();
        $rsptaf=$notacf->buscarComprobanteId($idcomp);
        
        $data= Array();
        $item=1;
        echo '<thead style="background-color:#494a48; color: #fff;">
                                  <th style="width: 15px;">+</th>
                                    <th>Item</th>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Va. Uni. Item</th>
                                    <th>Pre. Uni. Item</th>
                                    <th>Valor de venta</th>
                                    <th>Igv Item</th>


                      </thead>';
        while ($reg = $rsptaf->fetch_object())
                {
                    $sw=in_array($reg->idfactura, $data);
       
echo '<tr class="filas" id="fila">
        <td><button type="button" class="btn btn-info btn-sm" onclick="agregarDetalle('.$reg->idarticulo.',0,\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.$reg->descripcion.'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->unidad_medida.'\' ,\''.$reg->precio_unitario.'\' ,\''.$reg->descarti.'\')" data-toggle="tooltip" title="Agregar a detalle">√</button></td>    
    <td><span type="text"  name="numero_orden" id="numero_orden" value="'.$item.'" readonly>'.$item.'</span></td>
<td><span type="text" name="codigo" id="codigo"  value="'.$reg->codigo.'"  disabled="true" >'.$reg->codigo.'</span></td>
<td><span type="text"   name="descripcion" id="descripcion" value="'.$reg->descripcion.'" readonly>'.$reg->descripcion.'</span></td>
<td><span type="text"  name="cantidad" id="cantidad" value="'.$reg->cantidad.'" readonly >'.$reg->cantidad.'</span></td>
<td><span type="text"  name="vunitario" id="vunitario" value="'.$reg->vui.'"  readonly>'.$reg->vui.'</span></td>
<td><span type="text"  name="punitario" id="punitario" value="'.$reg->pvi.'"  readonly>'.$reg->pvi.'</span></td>
<td><span type="text" name="vventa" id="vventa" value="'.$reg->vvi.'" readonly>'.$reg->vvi.'</span></td>
<td><span type="text" name="igvventa" id="igvventa" value="'.$reg->igvi.'" readonly>'.$reg->igvi.'</span></td>
        </tr>';
        $item=$item + 1;
                }


         


 }else if ($tipodocu=="03"){ // BOLETA

        require_once "../modelos/Notacb.php";
        $notacb=new Notacb();
        $rsptab=$notacb->buscarComprobanteId($idcomp);
        
        $data= Array();
        $item=1;
        echo '<thead style="background-color:#494a48; color: #fff;">
                                  <th style="width: 15px;">+</th>
                                    <th>Item</th>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Va. Uni. Item</th>
                                    <th>Pre. Uni. Item</th>
                                    <th>Valor de venta</th>
                                    <th>Igv Item</th>


                      </thead>';
        while ($reg = $rsptab->fetch_object())
                {
                    $sw=in_array($reg->idboleta, $data);
       
echo '<tr class="filas" id="fila">

<td><button type="button" class="btn btn-info bt-sm" onclick="agregarDetalle('.$reg->idarticulo.',0,\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.$reg->descripcion.'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->unidad_medida.'\' ,\''.$reg->precio_unitario.'\')" data-toggle="tooltip" title="Agregar a detalle">√</button></td>

<td><span type="text"  name="numero_orden" id="numero_orden" value="'.$item.'" size="1" disabled="true" disabled="true">'.$item.'</span></td>
<td><span type="text" name="codigo" id="codigo"  value="'.$reg->codigo.'"  disabled="true" >'.$reg->codigo.'</span></td>
<td><span type="text"   name="descripcion" id="descripcion" value="'.$reg->descripcion.'" size="20" disabled="true" disabled="true">'.$reg->descripcion.'</span></td>
<td><span type="text"  name="cantidad" id="cantidad" value="'.$reg->cantidad.'" disabled="true" >'.$reg->cantidad.'</span></td>
<td><span type="text"  name="vunitario" id="vunitario" value="'.$reg->vui.'"  disabled="true">'.$reg->vui.'</span></td>
<td><span type="text"  name="punitario" id="punitario" value="'.$reg->pvi.'"  disabled="true">'.$reg->pvi.'</span></td>
<td><span type="text" name="vventa" id="vventa" value="'.$reg->vvi.'" disabled="true">'.$reg->vvi.'</span></td>
<td><span type="text" name="igvventa" id="igvventa" value="'.$reg->igvi.'" disabled="true">'.$reg->igvi.'</span></td>
        </tr>';
        $item=$item + 1;

        }
  






    }
    break;


    case 'generarxml':
        $rspta=$notacd->generarxml($idnota, $_SESSION['idempresa']);
        echo json_encode($rspta) ;
        break;

         case 'generarxmlNd':
        $rspta=$notacd->generarxmlNd($idnota, $_SESSION['idempresa']);
        echo json_encode($rspta) ;
        break;


        case 'enviarxmlSUNAT':
        $rspta=$notacd->enviarxmlSUNAT($idnota, $_SESSION['idempresa']);
        echo $rspta ;
        break;


        case 'mostrarxml':
        $rspta=$notacd->mostrarxml($idnota, $_SESSION['idempresa']);

        if ($rspta=="") {
            $rspta="No se ha creado";
        }
        echo json_encode($rspta) ;
    break;

    case 'mostrarrpta':
        $rspta=$notacd->mostrarrpta($idnota, $_SESSION['idempresa']);
        echo json_encode($rspta) ;
    break;


     case 'bajanc':
        $com=$_GET['comentario'];
        $hor=$_GET['hora'];
        date_default_timezone_set('America/Lima');
       //$hoy=date('Y/m/d');
        $hoy = date("Y-m-d"); 
        $rspta=$notacd->bajanc($idnota,$hoy,$com, $hor);
        echo $rspta ? "La nota de credito esta de baja" : "Nota no se dar de baja";
    break;


    case 'listarArticulosNC':

        $tmm=$_GET['itm'];
        $tpff=$_GET['tipof'];
        $tipoprecioa=$_GET['tipoprecioaa'];
        $almacen=$_GET['alm'];


       require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
         $idempresa=$_GET['idempresa'];
        $rspta=$articulo->listarActivosVentaumventa($_SESSION['idempresa'], $tpff, $almacen, $tipoprecioa);
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




}
?>