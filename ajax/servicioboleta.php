<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Servicioboleta.php";
require_once "../modelos/Numeracion.php"; 
$servicioboleta=new Boletaservicio();

require_once "../modelos/Persona.php";
$persona=new Persona();


//Factura
$idboleta=isset($_POST["idboleta"])? limpiarCadena($_POST["idboleta"]):"";
//$idusuario="2";
$idusuario=$_SESSION["idusuario"];
$fecha_emision_01=isset($_POST["fecha_emision"])? limpiarCadena($_POST["fecha_emision"]):""; 
$firma_digital=isset($_POST["firma_digital"])? limpiarCadena($_POST["firma_digital"]):"";
$idempresa=isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$idserie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";
$SerieReal=isset($_POST["SerieReal"])? limpiarCadena($_POST["SerieReal"]):"";
$numero_servicio=isset($_POST["numero_servicio"])? limpiarCadena($_POST["numero_servicio"]):"";
$idnumeracion=isset($_POST["idnumeracion"])? limpiarCadena($_POST["idnumeracion"]):"";
$numeracion=isset($_POST["numeracion"])? limpiarCadena($_POST["numeracion"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$total_operaciones_gravadas_codigo=isset($_POST["total_operaciones_gravadas_codigo"])? limpiarCadena($_POST["total_operaciones_gravadas_codigo"]):"";
$operacion_gravada=isset($_POST["subtotal_boleta"])? limpiarCadena($_POST["subtotal_boleta"]):"";
$sumatoria_igv_1=isset($_POST["total_igv"])? limpiarCadena($_POST["total_igv"]):"";
$sumatoria_igv_2=isset($_POST["total_igv"])? limpiarCadena($_POST["total_igv"]):"";
$codigo_tributo_3=isset($_POST["codigo_tributo_3"])? limpiarCadena($_POST["codigo_tributo_3"]):"";
$nombre_tributo_4=isset($_POST["nombre_tributo_4"])? limpiarCadena($_POST["nombre_tributo_4"]):"";
$codigo_internacional_5=isset($_POST["codigo_internacional_5"])? limpiarCadena($_POST["codigo_internacional_5"]):"";
$importe_total_venta=isset($_POST["total_final"])? limpiarCadena($_POST["total_final"]):"";
$tipo_documento_guia=isset($_POST["tipo_documento_guia"])? limpiarCadena($_POST["tipo_documento_guia"]):"";
$codigo_leyenda_1=isset($_POST["codigo_leyenda_1"])? limpiarCadena($_POST["codigo_leyenda_1"]):"";
$descripcion_leyenda_2=isset($_POST["descripcion_leyenda_2"])? limpiarCadena($_POST["descripcion_leyenda_2"]):"";
$version_ubl=isset($_POST["version_ubl"])? limpiarCadena($_POST["version_ubl"]):"";
$version_estructura=isset($_POST["version_estructura"])? limpiarCadena($_POST["version_estructura"]):"";
$tipo_moneda=isset($_POST["tipo_moneda_24"])? limpiarCadena($_POST["tipo_moneda_24"]):"";
$tasa_igv=isset($_POST["tasa_igv"])? limpiarCadena($_POST["tasa_igv"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
$codigo_precio=isset($_POST["codigo_precio"])? limpiarCadena($_POST["codigo_precio"]):"";
$tipodocuCliente=isset($_POST["tipo_documento_cliente"])? limpiarCadena($_POST["tipo_documento_cliente"]):"";
$rucCliente=isset($_POST["numero_documento"])? limpiarCadena($_POST["numero_documento"]):"";
$RazonSocial=isset($_POST["razon_social"])? limpiarCadena($_POST["razon_social"]):"";
$numero_guia=isset($_POST["numero_guia"])? limpiarCadena($_POST["numero_guia"]):"";
$hora=isset($_POST["hora"])? limpiarCadena($_POST["hora"]):"";
$guia_remision_29_2=isset($_POST["guia_remision_29_2"])? limpiarCadena($_POST["guia_remision_29_2"]):"";
$vendedorsitio=isset($_POST["vendedorsitio"])? limpiarCadena($_POST["vendedorsitio"]):"";
$email="";
$domicilio_fiscal2=isset($_POST["domicilio_fiscal"])? limpiarCadena($_POST["domicilio_fiscal"]):"";
$importe_total_23=isset($_POST["total_final"])? limpiarCadena($_POST["total_final"]):"";
$codigo_tipo_15_1=isset($_POST["codigo_tipo_15_1"])? limpiarCadena($_POST["codigo_tipo_15_1"]):"";

switch ($_GET["op"]){
    case 'guardaryeditarservicio':

if (empty($idboleta)){

   if($importe_total_23 >= 700){

    if ($idcliente=="N"){
        //$tipo_doc_ide="1";
         $rspta=$persona->insertardeBoleta($RazonSocial, $tipodocuCliente, $rucCliente, $domicilio_fiscal2);

        $IdC=$persona->mostrarId();
        //para ultimo registro de cliente
        while ($reg = $IdC->fetch_object())
                {
            $idcl=$reg->idpersona;
                }
        
    $rspta=$servicioboleta->insertar($idusuario, $fecha_emision_01, $firma_digital, $idempresa, $tipo_documento, $numeracion, $idcl, $codigo_tipo_15_1, $operacion_gravada, $sumatoria_igv_1, $sumatoria_igv_2, $codigo_tributo_3, $nombre_tributo_4, $codigo_internacional_5, $importe_total_23, $codigo_leyenda_1,  $descripcion_leyenda_2,  $tipo_documento, '', '', '', $tipo_moneda, $tasa_igv, $_POST["idserviciobien"], $_POST["numero_orden_item"], '1', $_POST["codigo_precio"], $_POST["pvt"], $_POST["igvBD2"], $_POST["igvBD2"], $_POST["afectacion_igv_3"],$_POST["afectacion_igv_4"], $_POST["afectacion_igv_5"], $_POST["afectacion_igv_6"], $_POST["igvBD"], $_POST["valor_unitario"], $_POST["subtotalBD"], $_POST["codigo"] , 'SRV', $idserie, $SerieReal, $numero_servicio, $tipodocuCliente, $rucCliente, html_entity_decode($RazonSocial , ENT_QUOTES | ENT_HTML401, 'UTF-8'), $hora, $_POST["descdet"], $vendedorsitio, $email, $domicilio_fiscal2);

    echo $rspta ? "Boleta registrada con cliente nuevo (>700)" : "No se pudierón registrar todos los datos de la boleta con cliente nuevo";
        }
        else
        {

            $rspta=$servicioboleta->insertar($idusuario, $fecha_emision_01, $firma_digital, $idempresa, $tipo_documento, $numeracion, $idcliente, $codigo_tipo_15_1, $operacion_gravada, $sumatoria_igv_1, $sumatoria_igv_2, $codigo_tributo_3, $nombre_tributo_4, $codigo_internacional_5, $importe_total_23, $codigo_leyenda_1,  $descripcion_leyenda_2,  $tipo_documento, '', '', '', $tipo_moneda, $tasa_igv, $_POST["idserviciobien"], $_POST["numero_orden_item"], '1', $_POST["codigo_precio"], $_POST["pvt"], $_POST["igvBD2"], $_POST["igvBD2"], $_POST["afectacion_igv_3"],$_POST["afectacion_igv_4"], $_POST["afectacion_igv_5"], $_POST["afectacion_igv_6"], $_POST["igvBD"], $_POST["valor_unitario"], $_POST["subtotalBD"], $_POST["codigo"] , 'SRV', $idserie, $SerieReal, $numero_servicio, $tipodocuCliente, $rucCliente,$RazonSocial, $hora, $_POST["descdet"], $vendedorsitio, $email, $domicilio_fiscal2);

                
            echo $rspta ? "Boleta registrada con cliente varios (>700)" : "No se pudierón registrar todos los datos de la boleta con cliente varios";


        } //FIN DE SEGUNDO IF

        }
        else //ELSE DE PRIMER IF
        {
        // SI EL TOTAL ES MENOR DE 700

    if ($idcliente=="N"){

         $rspta=$persona->insertardeBoleta($RazonSocial, $tipodocuCliente, $rucCliente, $domicilio_fiscal2);
         $IdC=$persona->mostrarId();
         while ($reg = $IdC->fetch_object())
                {
            $idcl=$reg->idpersona;
                }
        $rspta=$servicioboleta->insertar($idusuario, $fecha_emision_01, $firma_digital, $idempresa, $tipo_documento, $numeracion, $idcl, $codigo_tipo_15_1, $operacion_gravada, $sumatoria_igv_1, $sumatoria_igv_2, $codigo_tributo_3, $nombre_tributo_4, $codigo_internacional_5, $importe_total_23, $codigo_leyenda_1,  $descripcion_leyenda_2,  $tipo_documento, '', '', '', $tipo_moneda, $tasa_igv, $_POST["idserviciobien"], $_POST["numero_orden_item"], '1', $_POST["codigo_precio"], $_POST["pvt"], $_POST["igvBD2"], $_POST["igvBD2"], $_POST["afectacion_igv_3"],$_POST["afectacion_igv_4"], $_POST["afectacion_igv_5"], $_POST["afectacion_igv_6"], $_POST["igvBD"], $_POST["valor_unitario"], $_POST["subtotalBD"], $_POST["codigo"] , 'SRV', $idserie, $SerieReal, $numero_servicio, $tipodocuCliente, $rucCliente,$RazonSocial, $hora, $_POST["descdet"], $vendedorsitio, $email, $domicilio_fiscal2);

            echo $rspta ? "Boleta registrada menor a 700 con cliente nuevo" : "No se pudierón registrar todos los datos de la boleta menor a 700 con cliente nuevo";
        //


        }
        else //===========#####################
        {

           $rspta=$servicioboleta->insertar($idusuario, $fecha_emision_01, $firma_digital, $idempresa, $tipo_documento, $numeracion, $idcliente, $codigo_tipo_15_1, $operacion_gravada, $sumatoria_igv_1, $sumatoria_igv_2, $codigo_tributo_3, $nombre_tributo_4, $codigo_internacional_5, $importe_total_23, $codigo_leyenda_1,  $descripcion_leyenda_2,  $tipo_documento, '', '', '', $tipo_moneda, $tasa_igv, $_POST["idserviciobien"], $_POST["numero_orden_item"], '1', $_POST["codigo_precio"], $_POST["pvt"], $_POST["igvBD2"], $_POST["igvBD2"], $_POST["afectacion_igv_3"],$_POST["afectacion_igv_4"], $_POST["afectacion_igv_5"], $_POST["afectacion_igv_6"], $_POST["igvBD"], $_POST["valor_unitario"], $_POST["subtotalBD"], $_POST["codigo"] , 'SRV', $idserie, $SerieReal, $numero_servicio, $tipodocuCliente, $rucCliente, $RazonSocial, $hora, $_POST["descdet"], $vendedorsitio, $email, $domicilio_fiscal2);
            echo $rspta ? "Boleta registrada " : "No se pudierón registrar todos los datos de la boleta menor a 700 con cliente varios";

          }

         }
     } // $######################## FIN DE IF SI ES MAYOR O MENOR A 700
    break;
 
    case 'anular':
        $rspta=$servicioboleta->anular($idboleta);
        echo $rspta ? "Boleta de servicio anulada" : "Boleta de servicio no se puede anular";
    break;


    case 'baja':
        $com=$_GET['comentario'];
        $hor=$_GET['hora'];
        date_default_timezone_set('America/Lima');
        //$hoy=date('Y/m/d');
        $hoy = date("Y-m-d"); 
        $rspta=$servicioboleta->baja($idboleta, $hoy, $com, $hor );
        echo $rspta ? "Boleta de servicio esta baja" : "Boleta de servicio no se puede dar de baja";
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


     case 'listarArticulosservicio':
        require_once "../modelos/Bienservicio.php";
        $bienservicio=new Bienes_inmuebles();
        $idempresa=$_GET['idempresa'];
        $rspta=$bienservicio->listarActivosVenta($idempresa);
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->id.',\''.$reg->descripcion.'\',\''.$reg->codigo.'\',\''.$reg->valor.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->descripcion,
                "2"=>$reg->codigo,
                "3"=>number_format($reg->valor,2)
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


        $rspta=$servicioboleta->listar($idempresa);
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){

            $urlT='../reportes/exTicketSerBoleta.php?id=';
            $urlB='../reportes/exServicioboleta.php?id=';
            $urlC='../reportes/exBoletaServicioCompleto.php?id=';

            if($reg->tipo_documento=='Ticket'){
                $url='../reportes/exTicketSerBoleta.php?id=';
            }else{
                $url='../reportes/exServicioboleta.php?id=';

            }

    //==============Agregar====================================================
    $archivo=$reg->numero_ruc."-".$reg->tipo_documento."-".$reg->numeracion;
    $archivo2="R".$reg->numero_ruc."-".$reg->tipo_documento."-".$reg->numeracion;
    //===========================================================================

    if ($reg->estado=='3') {
        $st="3";
        $UpSt=$servicioboleta->ActualizarEstado($reg->idboleta, $st);
    }
    elseif ($reg->estado=='0'){
        $st="0";
        $UpSt=$servicioboleta->ActualizarEstado($reg->idboleta, $st);
    }    
    else
    {
       
    //Validar si existe el archivo firmado
    foreach($files as $file){
    // Divides en dos el nombre de tu archivo utilizando el . 
    $dataSt = explode(".", $file);
    // Nombre del archivo
    $fileName = $dataSt[0];
    $st="1";
    // Extensión del archivo 
    $fileExtension = $dataSt[1];
    if($archivo == $fileName){
        $st="4";
        $UpSt=$servicioboleta->ActualizarEstado($reg->idboleta, $st);
      }
    }

    //Validar si existe el archivo aceptado por sunat
    foreach($files2 as $file2){
    // Divides en dos el nombre de tu archivo utilizando el . 
    $dataSt2 = explode(".", $file2);
    // Nombre del archivo
    $fileName = $dataSt2[0];
    // Extensión del archivo 
    $fileExtension = $dataSt2[1];
    if($archivo2 == $fileName){
        $st="5";
        $UpSt=$servicioboleta->ActualizarEstado($reg->idboleta, $st);
    }
}
}//Fin if 
$stt='';
if ($reg->estado=='5' || $reg->estado=='4') {
    $send='';
    $stt='none';
}
else
{
    $send='none';
}

if ($reg->estado=='3'  ) {
     $stt='none';   
}




    //=====================================================================================

            $data[]=array(
                "0"=>
    ' <i  class="fa fa-level-down"   onclick="baja('.$reg->idboleta.')" data-toggle="tooltip" title="Anular y dar de baja"  style="display:'.$stt.';  color:red;" ></i>'
                    .
                    '<a target="_blank" href="'.$url.$reg->idboleta.'"> 
                    <i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir formato 2 copias" onclick="" > </i>
                    </a>'
                     .
                    '<a target="_blank" href="'.$urlT.$reg->idboleta.'"><i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir Ticket"> </i>
                    </a>'
                    .
                    '<a target="_blank" href="'.$urlC.$reg->idboleta.'"><i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir formato completo"> </i>
                    </a>'
                    .
       '<i class="fa fa-send"  data-toggle="tooltip" title="Enviar por correo a: '.$reg->email.'"  onclick="enviarcorreo('.$reg->idboleta.')"   style="display:'.$send.'; color:blue;" >
            </i>'
                     ,
                    

                "1"=>$reg->fecha,
                "2"=>$reg->nombres,
                "3"=>$reg->vendedorsitio,
                "4"=>$reg->numeracion,
                "5"=>$reg->importe_total_23,

                //Actualizado ===============================================
                "6"=>($reg->estado=='1')//si esta emitido
                ?'<i class="fa fa-file-text-o" style="font-size: 18px; color:#BA4A00;"> <span>Emitido</span></i> 
                <i class="fa fa-download"  data-toggle="tooltip" title="Descargar archivos" onclick="downFtp('.$reg->idboleta.')"  ></i>'
                : (($reg->estado=='4')?'<i class="fa fa-thumbs-up" style="font-size: 18px; color:#239B56;"> <span>Firmado</span></i>' //si esta firmado

                : (($reg->estado=='3' )?'<i class="fa fa-dot-circle-o" style="font-size: 18px; color:#E59866;"> <span>De baja</span></i> ' // si esta de baja

                : (($reg->estado=='0' )?'<i class="fa fa-dot-circle-o" style="font-size: 18px; color:#E59866;"> <span>Con Nota cd</span></i> ' // si esta de baja

                : (($reg->estado=='5')?'<i class="fa fa-globe" style="font-size: 15px; color:#145A32;"> <span>Aceptado por SUNAT</span></i> ' // Si esta aceptado por SUNAT

                : '<i class="fa fa-newspaper" style="font-size: 18px; color:#239B56;"> <span>Físico</span></i> ' )))) //Si esta anulado
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
        $rspta=$servicioboleta->enviarcorreo($idboleta, $_SESSION['idempresa']);
        echo $rspta ;
    break;


    case 'listarDR':

    $ano=$_GET['ano'];
    $mes=$_GET['mes'];
    //$idempresa=$_GET['idempresa'];

        $rspta=$servicioboleta->listarDR($ano, $mes, $_SESSION['idempresa']);
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
        $rspta=$servicioboleta->downftp($idboleta, $_SESSION['idempresa']);
        echo json_encode($rspta);
    break;
 

   }
?>