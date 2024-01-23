<?php 
if (strlen(session_id()) < 1) 
  session_start();
 

 $data=Array();

require_once "../modelos/Cotizacion.php";
require_once "../modelos/Numeracion.php";
$cotizacion=new Cotizacion();

$cont=0;
$conNO=1;



$idcotizacion=isset($_POST["idcotizacion"])? limpiarCadena($_POST["idcotizacion"]):"";
$idusuario=$_SESSION["idusuario"];
$fecha_emision=isset($_POST["fecha_emision"])? limpiarCadena($_POST["fecha_emision"]):""; 
$idempresa=isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";
$idserie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";
$SerieReal=isset($_POST["SerieReal"])? limpiarCadena($_POST["SerieReal"]):"";
$numero_cotizacion=isset($_POST["numero_cotizacion"])? limpiarCadena($_POST["numero_cotizacion"]):"";
$idnumeracion=isset($_POST["idnumeracion"])? limpiarCadena($_POST["idnumeracion"]):"";
$numeracion=isset($_POST["numeracion"])? limpiarCadena($_POST["numeracion"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";

$subtotal_producto=isset($_POST["subtotal_cotizacion_producto"])? limpiarCadena($_POST["subtotal_cotizacion_producto"]):"";
$impuesto=isset($_POST["total_igv_producto"])? limpiarCadena($_POST["total_igv_producto"]):"";
$total=isset($_POST["total_final_producto"])? limpiarCadena($_POST["total_final_producto"]):"";

$subtotal_cotizacion_servicio=isset($_POST["subtotal_cotizacion_servicio"])? limpiarCadena($_POST["subtotal_cotizacion_servicio"]):"";
$total_igv_servicio=isset($_POST["total_igv_servicio"])? limpiarCadena($_POST["total_igv_servicio"]):"";
$total_final_servicio=isset($_POST["total_final_servicio"])? limpiarCadena($_POST["total_final_servicio"]):"";

$tipo_moneda=isset($_POST["tipo_moneda"])? limpiarCadena($_POST["tipo_moneda"]):"";
$tipodocuCliente=isset($_POST["tipo_documento_cliente"])? limpiarCadena($_POST["tipo_documento_cliente"]):"";
$rucCliente=isset($_POST["numero_documento2"])? limpiarCadena($_POST["numero_documento2"]):"";
$RazonSocial=isset($_POST["razon_social2"])? limpiarCadena($_POST["razon_social2"]):"";
$hora=isset($_POST["hora"])? limpiarCadena($_POST["hora"]):"";
$vendedorsitio=isset($_POST["vendedorsitio"])? limpiarCadena($_POST["vendedorsitio"]):"";
$email=isset($_POST["correocli"])? limpiarCadena($_POST["correocli"]):"";
$domicilio_fiscal2=isset($_POST["domicilio_fiscal2"])? limpiarCadena($_POST["domicilio_fiscal2"]):"";
$tipocotizacion=isset($_POST["tipocotizacion"])? limpiarCadena($_POST["tipocotizacion"]):"";
$observacion=isset($_POST["observacion"])? limpiarCadena($_POST["observacion"]):"";
$fechavalidez=isset($_POST["fechavalidez"])? limpiarCadena($_POST["fechavalidez"]):"";
$tcambio=isset($_POST["tcambio"])? limpiarCadena($_POST["tcambio"]):"";
$estado=isset($_POST["estadocoti"])? limpiarCadena($_POST["estadocoti"]):"";
$serienota=$SerieReal."-".$numero_cotizacion;


switch ($_GET["op"]){
    case 'guardaryeditarcotizacion':



    if (empty($idcotizacion)){
        $rspta=$cotizacion->insertar($idempresa, $idusuario, $idcliente, $serienota, $tipo_moneda, $fecha_emision, $hora, $tipocotizacion, $subtotal_producto,  $impuesto, $total, $observacion , $vendedorsitio, $_POST["idarticulo"], $_POST["codigo"], $_POST["cantidad"], $_POST["precio_unitario"], $numero_cotizacion, $idserie, $_POST["descdet"], $_POST["numero_orden_item"], $fechavalidez, $tcambio, $_POST["subtotalBD"], $_POST["pvt"], $_POST["igvBD"], $_POST["igvBD2"]);
            $hora=date("h:i:s");
            echo $rspta ? "Se guardo correctamente cotizacion" : "Problemas al guardar cotizacion" ;
        }else{
            $rspta=$cotizacion->editarcotizacion($idcotizacion, $idempresa, $idusuario, $idcliente, $serienota, $tipo_moneda, $fecha_emision, $hora, $tipocotizacion, $subtotal_producto,  $impuesto, $total, $observacion , $vendedorsitio, $_POST["idarticulo"], $_POST["codigo"], $_POST["cantidad"], $_POST["precio_unitario"], $numero_cotizacion, $idserie, $_POST["descdet"], $_POST["numero_orden_item"], $fechavalidez, $tcambio, $_POST["subtotalBD"], $_POST["pvt"], $_POST["igvBD"], $_POST["igvBD2"],$estado );
            $hora=date("h:i:s");
            echo $rspta ? "Se edito correctamente" : "Problemas al guardar" ;

        }
        
  
        

    
    break;


    case 'guardaryeditarTcambio':

            date_default_timezone_set('America/Lima');
            $hoy=date('d/m/Y');

        if (empty($idtcambio))
        {
                    $rspta=$cotizacion->insertarTc($fechatc,$compra, $venta);
                    echo $rspta ? "Tipo de cambio registrado": "No se pudieron registrar el tipo de cambio";
                    }
                else
                    {
                    $rspta=$cotizacion->editarTc($idtcambio, $fechatc,$compra, $venta);
                    echo $rspta ? "Tipo de cambio editado": "No se pudieron editar los datos del tipo de cambio";
        }
    break;
 
    case 'anular':
        $rspta=$cotizacion->anular($idcotizacion);
        echo $rspta ? "cotizacion anulada" : "cotizacion no se puede anular";
    break;

    case 'enviarcorreo':
        $rspta=$cotizacion->enviarcorreo($idcotizacion, $_SESSION['idempresa']);
        echo $rspta ;
    break;


    case 'baja':
       
        $rspta=$cotizacion->baja($idcotizacion);
        echo $rspta ? "La cotizacion esta de baja y anulada" : "cotizacion no se dar de baja";
    break;

    case 'actualizarNumero':
            require_once "../Modelos/Numeracion.php";
            $numeracion=new Numeracion();

            $num=$_GET['Num'];
            $idnumeracion=$_GET['Idnumeracion'];
            $rspta=$numeracion->UpdateNumeracion($num, $idnumeracion );
    break;
 
    case 'mostrar':
        $rspta=$cotizacion->mostrar($idcotizacion);
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

    case 'estado':
        
        
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
 
        $rspta = $numeracion->llenarSeriecotizacion($idusuario);
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idnumeracion . '>' . $reg->serie . '</option>';

                }
    break; 


    case 'autonumeracion':
    
    $numeracion=new Numeracion();
    $Ser=$_GET['ser'];
    $rspta=$numeracion->llenarNumerocotizacion($Ser);
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


    case 'listarClientescotizacion':
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


     case 'listarArticuloscotizacion':
        $idc=$_GET['idcoti'];
        $tpc=$_GET['tpcoti'];

        $almacen=$_GET['alm'];
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
 
        $rspta=$articulo->listarActivosVentaCoti($_SESSION['idempresa'], $tpc, $almacen);
        //Vamos a declarar un array
        $data= Array();
 

        
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>
                '<button class="btn btn-warning" onclick="agregarDetalleproducto('.$reg->idarticulo.',\''.$reg->familia.'\',\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.$reg->nombre.'\',\''.$reg->precio_venta.'\',
                \''.$reg->stock.'\',\''.$reg->abre.'\' ,\''.$reg->precio_unitario.'\',
                \''.$idc.'\' , \''.$reg->factorconversion.'\' , \''.$reg->factorc.'\' , \''.$reg->nombreum.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->codigo,
                "3"=>$reg->nombreum,
                "4"=>$reg->precio_venta,
                "5"=>$reg->factorconversion,
                "6"=>""//($reg->imagen=="")?"<img src='../files/articulos/simagen.png' height='35px' width='35px'>":
                //"<img src='../files/articulos/".$reg->imagen."' height='35px' width='35px'>"
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
        $rspta=$bienservicio->listarActivosVenta($_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalleServicio('.$reg->id.',\''.$reg->descripcion.'\',\''.$reg->codigo.'\',\''.$reg->valor.'\')"><span class="fa fa-plus"></span></button>',
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












    case 'listar':
        $rspta=$cotizacion->listar($_SESSION['idempresa']);

        $urlCT='../reportes/exCotizacion.php?id=';
        while ($reg=$rspta->fetch_object()){
        //Vamos a declarar un array
        $urlC=''; 
        $stt='';




if ($reg->estado=='3') {
     $stt='none'; 
     
}
//=====================================================================================
        $data[]=array(
          "0"=> 
                '<div class="dropup">
                <button  class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                :::
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-center">
                <li>
                   <a>
                      <span class=""  data-toggle="tooltip" title="Editar documento"  onclick="editarcotizacion('.$reg->idcotizacion.')" style="display:'.$stt.'"> Editar cotización
                      </span>
                    </a>
                </li>

                <li>
                    <a>
                    <span class=""  onclick="baja('.$reg->idcotizacion.')"  data-toggle="tooltip" title="Anular y dar de baja" '.$stt.'  style="display:'.$stt.'";  color:red;> Dar de baja 
                    </span> 
                    
                    </a>
                </li>

                   <li>

                   <a target="_blank" href="'.$urlCT.$reg->idcotizacion.'">
                    <i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir cotizacion"  onclick=""> </i>
                    Imprimir
                   </a>
                  
                  </li>


                </ul>
                </div>'


                    // <a>
                    //  <i class="fa  fa-pencil"  data-toggle="tooltip" title="Editar doccumento"  style="font-size:18px;" onclick="editarcotizacion('.$reg->idcotizacion.')"> </i>
                    //  </a>

                    //  <a>
                    //  <i class="fa fa-level-down"  onclick="baja('.$reg->idcotizacion.')"  data-toggle="tooltip" title="Anular y dar de baja" '.$stt.'  style="display:'.$stt.';  color:red; font-size:18px;"></i>
                    //  </a>
                    
                    //  <a target="_blank" href="'.$urlCT.$reg->idcotizacion.'">
                    //  <i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir cotizacion"  style="font-size:18px;" onclick=""> </i>
                    //  </a>'
                    ,

                "1"=>($reg->estado=='2')?'<a>
                       <i class="fa fa-play" data-toggle="tooltip" title="Generar factura"  color:red;" onclick="nuevafactura('.$reg->idcotizacion.')"></i>Emitir factura
                     </a>':'',
                "2"=>$reg->fecha,
                "3"=>$reg->serienota,
                "4"=>$reg->cliente,
                "5"=>$reg->total,
                "6"=>$reg->vendedor,
                "7"=>$reg->nrofactura,
                "8"=>($reg->estado=='1')//si esta emitido
                ?'<i><span style="color:brown;">EMITIDO</span></i>'
                : (($reg->estado=='2')?'<i  style="color:green;"> <span>APROBADO</span></i>'
                :'<i  style="color:red;"> <span>ANULADO</span></i>'),
                "9"=>$reg->moneda
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




    

     case 'listarClientescotizacionxDoc':
        require_once "../modelos/Persona.php";
        $persona=new Persona();
        $doc=$_GET['doc'];
        $rspta = $persona->buscarClientexDoccotizacion($doc);
        
        echo json_encode($rspta);
        
        break;

    case 'listarClientescotizacionxDocNuevos':
        require_once "../modelos/Persona.php";
        $persona=new Persona();
        $rspta = $persona->buscarClientexDoccotizacionNuevos();
        echo json_encode($rspta);
        
        break;

    case 'mostrarultimocomprobante':
        $rspta = $cotizacion->mostrarultimocomprobante($_SESSION['idempresa']);
        echo json_encode($rspta);
        break;


        case 'estadoDoc':
        $rspta=$cotizacion->mostrarCabFac();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $archivo=$reg->$reg->ruc."-".$reg->tipodoc."-".$reg->numerodoc;
                }
                echo json_encode($archivo);
        break;

    case 'listarArticuloscotizacionxcodigo':
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
        $idempresa=$_GET['idempresa'];
        $codigob=$_GET['codigob'];
        $rspta=$articulo->listarActivosVentaxCodigo($codigob, $idempresa);
        echo json_encode($rspta);
    break;

    case 'busquedaPredic':
        require_once "../modelos/cotizacion.php";
        $cotizacion=new cotizacion();
        $buscar = $_POST['b'];
        $rspta=$cotizacion->AutocompletarRuc($buscar);
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
        $rspta=$cotizacion->uploadFtp($idcotizacion);
        echo $rspta;
    break;

        case 'listarDR':

        $ano=$_GET['ano'];
        $mes=$_GET['mes'];
        //$idempresa=$_GET['idempresa'];

        $rspta=$cotizacion->listarDR($ano, $mes, $_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
        $data[]=array(
                "0"=>$reg->fecha,
                "1"=>$reg->numerocotizacion,
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
                ?'<button class="btn btn-warning"  onclick="ConsultaDR('.$reg->idcotizacion.')"> <i class="fa fa-eye" data-toggle="tooltip" title="Ver documento" ></i> </button>':''
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
        $rspta=$cotizacion->listarDRdetallado($id, $idempresa);
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
        require_once "../modelos/cotizacion.php";
        $cotizacion = new cotizacion(); 
        
        $rspta = $cotizacion->tributo();
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->codigo . '>' . $reg->descripcion . '</option>';
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



        case 'tppcambio':
        
        $dh=$_GET['dd'];
        $rpta=$cotizacion->tipodecambio($dh);
        echo json_encode($rpta);

        break;


        case 'editar':
        $rspta=$cotizacion->editar($idcotizacion);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;


        case 'numerof':
        $rspta=$cotizacion->listarnumerofilas($idcotizacion);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;



         case 'traercotizacion':
                $idcotizacion=$_GET['idcoti'];
                $rspta=$cotizacion->traercotizacion($idcotizacion);
                echo json_encode($rspta);
        break;



        case 'listarDetallecoti':
    //Recibimos el idingreso
        $id=$_GET['id'];
 
        $rspta = $cotizacion->listarDetallecotizacion($id);
        $subt=0;
        $igv=0;
        $total=0;
        echo ' 
        
        <thead style="background-color:#35770c; color: #fff; text-align: justify;">
                                    <th >Sup.</th>
                                    <th >Item</th>
                                    <th >Artículo</th>
                                    <th >Cantidad</th>
                                    <th >Cód.</th>
                                    <th >U.M.</th>
                                    <th >Prec. u.</th>
                                    <th >Val. u.</th>
                                    <th >Importe</th>
        </thead>';
 
        while ($reg = $rspta->fetch_object())
                {
        echo '<tr class="filas" id="fila'.$cont.'">
        <td>
        <i class="fa fa-close" onclick="eliminarDetalle('.$cont.')" title="Eliminar item"></i>
        </td>

        <td>
        <span name="numero_orden" id="numero_orden'.$cont.'">'.$reg->norden.'</span>
        <input type="hidden" name="numero_orden_item[]" id="numero_orden_item[]" value="'.$reg->norden.'" size="1">
        
        </td>

        <td>
        <input type="hidden" name="idarticulo[]" value="'.$reg->idarticulo.'">
        '.$reg->narticulo.' <input type="text" class=""  name="descdet[]" id="descdet[]" style="display:none;" onkeyup="mayus(this)" onkeypress="return focusDescdet(event, this)">
        </td>


        <td>
        <input type="text" required="true" class="" name="cantidad[]" id="cantidad[]"  onBlur="modificarSubototalesProductos()" size="2" onkeypress="return NumCheck(event, this)"  value="'.$reg->cantidad.'" focus >
        </td>


        <td>
        <input type="hidden" name="codigo[]" id="codigo[]" value="'.$reg->codigo.'" size="2">
        '.$reg->codigo.'
        </td>

        <input type="text" name="codigo[]" id="codigo[]" value="'.$reg->codigo.'" class="" size="4">

        <td>
        <input type="hidden" name="unidad_medida[]" id="unidad_medida[]" value="'.$reg->unidad_medida.'">
        '.$reg->unidad_medida.'
        </td>

        <td>
        <input type="text" class="" name="precio_unitario[]" id="precio_unitario[]" value="'.$reg->precioc.'"   onBlur="modificarSubototalesProductos()" size="5" onkeypress="return NumCheck2(event, this)" >
        </td>


        <td>
        <input type="text" class="" name="valor_unitario2[]" id="valor_unitario2[]" size="5"  value="'.$reg->valorunitario.'" onBlur="modificarSubototalesProductos()">
        </td>

        <td>
        <span name="subtotal" id="subtotal'.$cont.'">'.$reg->valorventa.'</span>
        <input type="hidden" name="subtotalBD[]" id="subtotalBD["'.$cont.'"]">
        <span name="igvG" id="igvG'.$cont.'" style="background-color:#9fde90bf;display:none;" ></span>
        <input type="hidden" name="igvBD[]" id="igvBD["'.$cont.'"]">
        <input type="hidden" name="igvBD2[]" id="igvBD2["'.$cont.'"]">
        <span name="total" id="total'.$cont.'" style="background-color:#9fde90bf; display:none;"></span>
        <span name="pvu_" id="pvu_'.$cont.'" style="display:none"></span>
        <input type="hidden" name="pvt[]" id="pvt["'.$cont.'"] size="2">
        <input  type="hidden" name="vuniitem[]" id="vuniitem["'.$cont.'"]><input type="hidden" name="valorventa[]" id="valorventa["'.$cont.'"]>
        </td>

        </tr>
              ';

                    $subt=$reg->subtotal;
                    $igv=$reg->impuesto;
                    $total=$reg->total;
                }
                 $cont++;
        
        echo '<tfoot style="vertical-align: center;">

                                
                        <tr>
                           <td><td></td><td></td><td></td><td></td><td></td><td></td>

                                    <th style="font-weight: bold;  background-color:#A5E393;">Subtotal </th>

                                    <th style="font-weight: bold; background-color:#A5E393;">
                                      
                                      <h4 id="subtotal">'.$subt.'</h4>

                                    </td>
                                    </tr> 

                                
                           <tr>
                            <td><td></td><td></td><td></td><td></td><td></td><td></td>

                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">igv 18% </th>

                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">

                                      <h4 id="igv_">'.$igv.'</h4>

                                    </th>
                                    </td>
                                    </tr> 
                                    

                             
                          <td><td></td><td></td><td></td><td></td><td></td><td></td>
                                    <th style="font-weight: bold; vertical-align: center; background-color:#A5E393;">Total </th>
                                    <th style="font-weight: bold; background-color:#A5E393;">

                        <h4 id="total" style="font-weight: bold; vertical-align: center; background-color:#A5E393;">'.$total.'</h4>

                    <input type="hidden" name="total_final_producto" id="total_final_producto">
                    <input type="hidden" name="subtotal_cotizacion_producto" id="subtotal_cotizacion_producto"> 
                    <input type="hidden" name="total_igv_producto" id="total_igv_producto">
                    
                                    </td>
                                    </tr>
                                </tfoot> ';
            break;
            


            



                case 'traerdetallenfactura':
       //Recibimos el idingreso
        $id=$_GET['id'];
 
        $rspta = $cotizacion->listarDetallecoti($id);
        $subt=0;
        $igv=0;
        $total=0;
        echo ' 
        
        <thead style="background-color:#35770c; color: #fff; text-align: justify;">
                                    
                                    <th scope="col">Item</th>
                                    <th scope="col">Artículo</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Cód.</th>
                                    <th scope="col">U.M.</th>
                                    <th scope="col">Prec. u.</th>
                                    <th scope="col">Val. u.</th>
                                    <th scope="col">Importe</th>
        </thead>';
 
        while ($reg = $rspta->fetch_object())
                {
        echo '<tbody><tr class="filas">
        <td><input type="hidden" name="norden[]" id="norden[]" value="'.$reg->norden.'">'.$reg->norden.'</td>
        <td><input type="hidden" name="idarticulof[]" id="idarticulof[]" value="'.$reg->idarticulo.'">'.$reg->narticulo.'
        <textarea class="" name="descdetf[]" id="descdetf[]" rows="1" cols="10" style="display:none;">'.$reg->descdet.'</textarea>'.$reg->descdet.'</td>
        <td><input type="text"  name="cantidadf[]" id="cantidad[]f" style="display:none;" value="'.$reg->cantidad.'">'.$reg->cantidad.'</td>
        <td><input type="hidden" name="codigof[]" id="codigof[]" value="'.$reg->codigo.'">'.$reg->codigo.'</td>
        <td><input type="hidden" name="preciof[]" id="preciof[]" value="'.$reg->precioc.'">'.$reg->nombreum.'</td>
        <td><input type="hidden" name="valorunitariof[]" id="valorunitariof[]" value="'.$reg->valorunitario.'">
        <input type="hidden" name="igvitem[]" id="igvitem[]" value="'.$reg->igvvalorventa.'">
        <input type="hidden" name="unidad_medida[]" id="unidad_medida[]" value="'.$reg->abre.'">'.$reg->precioc.'</td>
        <td><input type="hidden" name="valorventaf[]" id="valorventaf[]" value="'.$reg->valorventa.'">
        <input type="hidden" name="afeigv3[]" id="afeigv3[]" value="10">
        <input type="hidden" name="afeigv4[]" id="afeigv4[]" value="1000">
        <input type="hidden" required="true" name="cantidadreal[]" id="cantidadreal[]" value="'.$reg->cantidadreal.'"  >
        <input type="hidden" name="sumadcto[]" id="sumadcto[]" value="0">'.$reg->valorunitario.'</td>
        <td>'.$reg->valorventa.'</td>
                </tr>';

                    $subt=$reg->subtotal;
                    $igv=$reg->impuesto;
                    $total=$reg->total;
                }
        echo ' </tbody>
        <tfoot style="vertical-align: center;">
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

 </tfoot>
                                ';
    break;


    case 'selectAlmacen':
      
        
        $rspta = $cotizacion->almacenlista();
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idalmacen . '>' . $reg->nombre . '</option>';
                }
        break;



        case 'mostrarultimocomprobanteId':

        $rspta = $cotizacion->mostrarultimocomprobanteId($_SESSION['idempresa']);
        echo json_encode($rspta);
        break;


    
        }
?>