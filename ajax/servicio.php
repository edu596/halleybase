<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Servicio.php";
require_once "../modelos/Numeracion.php";
$servicio=new Servicio();

//servicio
$idfactura=isset($_POST["idfactura"])? limpiarCadena($_POST["idfactura"]):"";
//$idusuario="2";
$idusuario=$_SESSION["idusuario"];
$fecha_emision=isset($_POST["fecha_emision"])? limpiarCadena($_POST["fecha_emision"]):""; 
$firma_digital=isset($_POST["firma_digital"])? limpiarCadena($_POST["firma_digital"]):"";
$idempresa=isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$idserie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";
$SerieReal=isset($_POST["SerieReal"])? limpiarCadena($_POST["SerieReal"]):"";
$numero_servicio=isset($_POST["numero_servicio"])? limpiarCadena($_POST["numero_servicio"]):"";
$idnumeracion=isset($_POST["idnumeracion"])? limpiarCadena($_POST["idnumeracion"]):"";
$numeracion=isset($_POST["numeracion"])? limpiarCadena($_POST["numeracion"]):"";
$idcliente=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";
$total_operaciones_gravadas_codigo=isset($_POST["total_operaciones_gravadas_codigo"])? limpiarCadena($_POST["total_operaciones_gravadas_codigo"]):"";
$total_operaciones_gravadas_monto=isset($_POST["subtotal_servicio"])? limpiarCadena($_POST["subtotal_servicio"]):"";
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

switch ($_GET["op"]){
    case 'guardaryeditarservicio':

    

        if (empty($idfactura)){
        $rspta=$servicio->insertar($idusuario, $fecha_emision, $firma_digital, $idempresa, $tipo_documento, $numeracion, $idcliente, $total_operaciones_gravadas_codigo, $total_operaciones_gravadas_monto, $sumatoria_igv_1, $sumatoria_igv_2, $codigo_tributo_3, $nombre_tributo_4, $codigo_internacional_5, $importe_total_venta, $tipo_documento_guia, $guia_remision_29_2, $codigo_leyenda_1, $descripcion_leyenda_2, $version_ubl, $version_estructura, $tipo_moneda, $tasa_igv, $_POST["idserviciobien"], $_POST["numero_orden_item"], '1', $_POST["codigo_precio"], $_POST["pvt"], $_POST["igvBD2"], $_POST["igvBD2"], $_POST["afectacion_igv_3"], $_POST["afectacion_igv_4"], $_POST["afectacion_igv_5"], $_POST["afectacion_igv_6"], $_POST["igvBD"], $_POST["valor_unitario"], $_POST["subtotalBD"], $_POST["codigo"] , 'SRV', $idserie, $SerieReal, $numero_servicio, $tipodocuCliente,  $rucCliente , $RazonSocial, $hora, $_POST["descdet"], $vendedorsitio, $email, $domicilio_fiscal2);
                
            $hora=date("h:i:s");
                
            echo $rspta ? "servicio registrado": "No se pudieron registrar todos los datos de la servicio";
        }
        else{
        }

    
    break;
 
    case 'anular':
        $rspta=$servicio->anular($idfactura);
        echo $rspta ? "servicio anulada" : "servicio no se puede anular";
    break;

    case 'enviarcorreo':
        $rspta=$servicio->enviarcorreo($idfactura);
        echo $rspta ;
    break;

    case 'ftp':
       $rspta=$servicio->ftp();
        echo $rspta ;
    break;

    case 'baja':
        $com=$_GET['comentario'];
        $hor=$_GET['hora'];
        $hoy = date("Y-m-d"); 
        $rspta=$servicio->baja($idfactura,$hoy,$com, $hor);
        echo $rspta ? "La servicio esta de baja y anulada" : "servicio no se dar de baja";
    break;

    case 'actualizarNumero':
            require_once "../Modelos/Numeracion.php";
            $numeracion=new Numeracion();

            $num=$_GET['Num'];
            $idnumeracion=$_GET['Idnumeracion'];
            $rspta=$numeracion->UpdateNumeracion($num, $idnumeracion );
    break;
 
    case 'mostrar':
        $rspta=$servicio->mostrar($idfactura);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;
 
    case 'listarDetalle':
        //Recibimos el idingreso
        $id=$_GET['id'];
 
        $rspta = $servicio->listarDetalle($id);
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
 
        $rspta = $numeracion->llenarSerieservicio($idusuario);
 
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


    case 'listarClientesservicio':
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
        //$idempresa=$_GET['idempresa'];
        $rspta=$bienservicio->listarActivosVenta($_SESSION['idempresa']);
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


 case 'listarArticulosNC':
       require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
 
        $rspta=$articulo->listarActivosVenta();
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


    case 'listar':
    $idempresa=$_GET['idempresa'];
    require_once "../modelos/Servicio.php";
    $servicio=new Servicio();
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
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

        $rspta=$servicio->listarServicio($idempresa);
        //Vamos a declarar un array
        $data= Array();

        $urlT='../reportes/exTicketSerFactura.php?id=';
        $urlF='../reportes/exServicio.php?id=';
        $urlC='../reportes/exFacturaServicioCompleto.php?id=';
 
        while ($reg=$rspta->fetch_object()){
            if($reg->tipo_documento_07=='Ticket'){
               $url='../reportes/exTicketSerFactura.php?id=';
           }else{
               $url='../reportes/exServicio.php?id=';
            }
    //==============Agregar====================================================
    $archivo=$reg->numero_ruc."-".$reg->tipo_documento_07."-".$reg->numeracion_08;
    $archivo2="R".$reg->numero_ruc."-".$reg->tipo_documento_07."-".$reg->numeracion_08;
    $fileBaja=$reg->numero_ruc."-RA".$reg->fechabaja."-011";


if ($reg->estado=='3'){
        $st="3";
        $UpSt=$servicio->ActualizarEstado($reg->idfactura, $st);
}
elseif ($reg->estado=='0'){
        $st="0";
        $UpSt=$servicio->ActualizarEstado($reg->idfactura, $st);
 }else{       
       
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
        $UpSt=$servicio->ActualizarEstado($reg->idfactura, $st);
   
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
        $UpSt=$servicio->ActualizarEstado($reg->idfactura, $st);
    }
    }

}//Fin if 

$stt='';

if ($reg->estado=='5' ||  $reg->estado=='4'  ) {
    $send='';
    $stt='none'; 
}
else
{
    $send='none';
}

if ($reg->estado=='3') {
     $stt='none'; 
     $url='../reportes/exServicio.php?id=';  
}

if ($reg->estado=='0') {
     $stt='none'; 
     $url='../reportes/exServicio.php?id=';  
}

   
   //=====================================================================================
        //$client=substr($reg->cliente,0,10);
        $data[]=array(
          "0"=> '<i  class="fa fa-level-down"  onclick="baja('.$reg->idfactura.')"  data-toggle="tooltip" title="Anular y dar de baja" '.$stt.'  style="display:'.$stt.';  color:red;"></i>'
                    .
                    '<a target="_blank" href="'.$url.$reg->idfactura.'">
                     <i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir formato dos copias"  onclick=""> </i>
                     </a>'
                    .
                    '<a target="_blank" href="'.$urlT.$reg->idfactura.'"> 
                     <i class="fa fa-print" data-toggle="tooltip" title="Imprimir Ticket"  > </i>
                    </a>'
                    .
                    '<a target="_blank" href="'.$urlC.$reg->idfactura.'"> 
                     <i class="fa fa-print" data-toggle="tooltip" title="Imprimir formato completo"  > </i>
                    </a>'

                    .
            '<i class="fa fa-send"  data-toggle="tooltip" title="Enviar por correo a: '.$reg->email.'"  onclick="enviarcorreo('.$reg->idfactura.')"   style="display:'.$send.'; color:blue;" >
            </i>'
            // .
            // '<button class="btn btn-info"  onclick="ftp()"><i class="fa fa-level-down"></i></button>'
                     ,
                              
                "1"=>$reg->fecha,
                "2"=>$reg->cliente,
                "3"=>$reg->vendedorsitio,
                "4"=>$reg->numeracion_08,
                "5"=>$reg->importe_total_venta_27,

                //Actualizado ===============================================
                "6"=>($reg->estado=='1')//si esta emitido
                ?'<i class="fa fa-file-text-o" style="font-size: 18px; color:#BA4A00;"> <span>Emitido</span></i> 
                <i class="fa fa-download"  data-toggle="tooltip" title="Descargar archivos" onclick="downFtp('.$reg->idfactura.')"  ></i>'
                //<button class="btn btn-info"  data-toggle="tooltip" title="Descargar archivos" onclick="downFtp('.$reg->idfactura.')"> <i class="fa fa-download" ></i> </button>
                 //<button class="btn btn-warning"  data-toggle="tooltip" title="Subir archivos" onclick="uploadFtp('.$reg->idfactura.')"> <i class="fa fa-upload" ></i> </button>'
            : (($reg->estado=='4')?'<i class="fa fa-thumbs-up" style="font-size: 18px; color:#239B56;"> <span>Firmado</span></i>' //si esta firmado

            : (($reg->estado=='3' )?'<i class="fa fa-dot-circle-o" style="font-size: 18px; color:#E59866;"> <span>De baja</span></i> ' // si esta de baja

            : (($reg->estado=='0')?'<i class="fa fa-dot-circle-o" style="font-size: 18px; color:#E59866;"> <span>Tiene Nota de credito/debito</span></i> '  //si esta firmado

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







    case 'listarValidar':

        $ano=$_GET['ano'];
        $mes=$_GET['mes'];
        $dia=$_GET['dia'];

    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2();
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

        $rspta=$servicio->listarValidar($ano, $mes, $dia);
        //Vamos a declarar un array
        $data= Array();

        $urlT='../reportes/exTicketservicio.php?id=';
        $urlF='../reportes/exservicio.php?id=';
 
        while ($reg=$rspta->fetch_object()){
            if($reg->tipo_documento_07=='Ticket'){
               $url='../reportes/exTicketservicio.php?id=';
           }else{
               $url='../reportes/exservicio.php?id=';
            }
    //==============Agregar====================================================
    $archivo=$reg->numero_ruc."-".$reg->tipo_documento_07."-".$reg->numeracion_08;
    $archivo2="R".$reg->numero_ruc."-".$reg->tipo_documento_07."-".$reg->numeracion_08;
    $fileBaja=$reg->numero_ruc."-RA".$reg->fechabaja."-011";


if ($reg->estado=='3'){
        $st="3";
        $UpSt=$servicio->ActualizarEstado($reg->idfactura, $st);
}
elseif ($reg->estado=='0'){
        $st="0";
        $UpSt=$servicio->ActualizarEstado($reg->idfactura, $st);
 }else{       
       
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
        $UpSt=$servicio->ActualizarEstado($reg->idfactura, $st);
   
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
        $UpSt=$servicio->ActualizarEstado($reg->idfactura, $st);
    }
    }

}//Fin if 

$stt='';

if ($reg->estado=='5' ||  $reg->estado=='4'  ) {
    $send='';
    $stt='disabled'; 
}
else
{
    $send='disabled';
}

if ($reg->estado=='3') {
     $stt='disabled'; 
     $url='../reportes/exservicio.php?id=';  
}

if ($reg->estado=='0') {
     $stt='disabled'; 
     $url='../reportes/exservicio.php?id=';  
}

   
   //=====================================================================================
        //$client=substr($reg->cliente,0,10);
        $data[]=array(
          "0"=> ' <button class="btn btn-warning"  onclick="baja('.$reg->idfactura.')" data-toggle="tooltip" title="Anular y dar de baja" '.$stt.' >
                    <i  class="fa fa-level-down" ></i></button>'
                    .
                    '<a target="_blank" href="'.$url.$reg->idfactura.'"> <button class="btn btn-info" data-toggle="tooltip" title="Imprimir servicio"><i class="fa  fa-print" > </i></button>
                    </a>'
                    // .
                    // '<a target="_blank" href="'.$urlT.$reg->idfactura.'"> <button class="btn btn-warning" data-toggle="tooltip" title="Imprimir Ticket"><i class="fa fa-print" > </i></button>
                    // </a>'
            .
            '<button class="btn btn-info"  data-toggle="tooltip" title="Enviar por correo a: '.$reg->email.'"  onclick="enviarcorreo('.$reg->idfactura.')" '.$send.'><i class="fa fa-send">
                     </i></button>'
            // .
            // '<button class="btn btn-info"  onclick="ftp()"><i class="fa fa-level-down"></i></button>'
                     ,
                              
                "1"=>$reg->fecha,
                "2"=>$reg->cliente,
                "3"=>$reg->vendedorsitio,
                "4"=>$reg->numeracion_08,
                "5"=>$reg->importe_total_venta_27,

                //Actualizado ===============================================
                "6"=>($reg->estado=='1')//si esta emitido
                ?'<i class="fa fa-file-text-o" style="font-size: 18px; color:#BA4A00;"> <span>Emitido</span></i> '
                //<button class="btn btn-info"  data-toggle="tooltip" title="Descargar archivos" onclick="downFtp('.$reg->idfactura.')"> <i class="fa fa-download" ></i> </button>
                 //<button class="btn btn-warning"  data-toggle="tooltip" title="Subir archivos" onclick="uploadFtp('.$reg->idfactura.')"> <i class="fa fa-upload" ></i> </button>'
            : (($reg->estado=='4')?'<i class="fa fa-thumbs-up" style="font-size: 18px; color:#239B56;"> <span>Firmado</span></i>' //si esta firmado

            : (($reg->estado=='3' )?'<i class="fa fa-dot-circle-o" style="font-size: 18px; color:#E59866;"> <span>De baja</span></i> ' // si esta de baja

            : (($reg->estado=='0')?'<i class="fa fa-dot-circle-o" style="font-size: 18px; color:#E59866;"> <span>Tiene Nota de credito/debito</span></i> '  //si esta firmado

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
    $rspta=$numeracion->llenarNumeroservicio($Ser);
        while ($reg=$rspta->fetch_object())
        {
        echo $reg->Nnumero;    
        }
    break;


     case 'listarClientesservicioxDoc':
        require_once "../modelos/Persona.php";
        $persona=new Persona();
        $doc=$_GET['doc'];
        $rspta = $persona->buscarClientexDocservicio($doc);
        
        echo json_encode($rspta);
        
        break;

    case 'listarClientesservicioxDocNuevos':
        require_once "../modelos/Persona.php";
        $persona=new Persona();
        
        $rspta = $persona->buscarClientexDocservicioNuevos();
        
        echo json_encode($rspta);
        
        break;


        case 'estadoDoc':
        $rspta=$servicio->mostrarCabFac();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $archivo=$reg->$reg->ruc."-".$reg->tipodoc."-".$reg->numerodoc;
                }
                echo json_encode($archivo);
        break;

    case 'listarArticulosservicioxcodigo':
    
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
        $idempresa=$_GET['idempresa'];
        $codigob=$_GET['codigob'];
        $rspta=$articulo->listarActivosVentaxCodigo($codigob, $idempresa);
        echo json_encode($rspta);
    break;

    case 'busquedaPredic':
        require_once "../modelos/servicio.php";
        $servicio=new servicio();
        $buscar = $_POST['b'];
        $rspta=$servicio->AutocompletarRuc($buscar);
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


    case 'downFtp':
        $rspta=$servicio->downftp($idfactura, $_SESSION['idempresa']);
        echo json_encode($rspta);
    break;

        case 'uploadFtp':
        $rspta=$servicio->uploadFtp($idfactura);
        echo $rspta;
    break;

        case 'listarDR':

        $ano=$_GET['ano'];
        $mes=$_GET['mes'];

        $rspta=$servicio->listarDR($ano, $mes);
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
        $data[]=array(
                "0"=>$reg->fecha,
                "1"=>$reg->numeroservicio,
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
        //$idcomp = '28';
        $rspta=$servicio->listarDRdetallado($id);
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
    
        }
?>