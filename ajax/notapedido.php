<?php 
if (strlen(session_id()) < 1)  
  session_start();
 
require_once "../modelos/Notapedido.php";
require_once "../modelos/Numeracion.php"; 
$notapedido=new Notapedido();

$cont=0;
$conNO=1;


require_once "../modelos/Persona.php";
$persona=new Persona();
$idboleta=isset($_POST["idboleta"])? limpiarCadena($_POST["idboleta"]):"";

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

$codigo_tipo_15_1=isset($_POST["codigo_tipo_15_1"])? limpiarCadena($_POST["codigo_tipo_15_1"]):"";

$codigo_tributo_18_3=isset($_POST["codigo_tributo_18_3"])? limpiarCadena($_POST["codigo_tributo_18_3"]):"";

$nombre_tributo_18_4=isset($_POST["nombre_tributo_18_4"])? limpiarCadena($_POST["nombre_tributo_18_4"]):"";
$codigo_internacional_18_5=isset($_POST["codigo_internacional_18_5"])? limpiarCadena($_POST["codigo_internacional_18_5"]):"";
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
$cestado1=isset($_POST["chestado"])? limpiarCadena($_POST["chestado"]):"";
$tiponota=isset($_POST["tiponota"])? limpiarCadena($_POST["tiponota"]):"";

$adelanto=isset($_POST["adelanto"])? limpiarCadena($_POST["adelanto"]):"";
$faltante=isset($_POST["faltante"])? limpiarCadena($_POST["faltante"]):"";
$ncotizacion=isset($_POST["ncotizacion"])? limpiarCadena($_POST["ncotizacion"]):"";
$ambtra=isset($_POST["ambtra"])? limpiarCadena($_POST["ambtra"]):"";
$estadonota=isset($_POST["estadonota"])? limpiarCadena($_POST["estadonota"]):"";



switch ($_GET["op"]){

    case 'guardaryeditarCambioestado':
        $rspta=$notapedido->actualizarestados($_POST["idnota"], $cestado1 );
        echo $rspta ? "Comprobantes actualizados" : "No se pudierón actualizar";
    break;


    case 'guardaryeditarBoleta':

if (empty($idboleta)){

    if ($idcliente=="N"){
        //$tipo_doc_ide="1";
         $rspta=$persona->insertardeBoleta($RazonSocial, $tipo_doc_ide, $rucCliente, $domicilio_fiscal);

        $IdC=$persona->mostrarId();
        //para ultimo registro de cliente
        while ($reg = $IdC->fetch_object())
                {
            $idcl=$reg->idpersona;
                }
        
 $rspta=$notapedido->insertar($idusuario, $fecha_emision_01, $firma_digital_36, $idempresa, $tipo_documento_06, $numeracion_07, $idcl, $codigo_tipo_15_1, $monto_15_2, $sumatoria_igv_18_1, $sumatoria_igv_18_2, $codigo_tributo_18_3, $nombre_tributo_18_4, $codigo_internacional_18_5, $importe_total_23, $codigo_leyenda_26_1,  $descripcion_leyenda_26_2,  $tipo_documento_25_1, $guia_remision_25, $version_ubl_37, $version_estructura_38, $tipo_moneda_24, $tasa_igv, $_POST["idarticulo"], $_POST["numero_orden_item_29"], $_POST["cantidad_item_12"], $_POST["codigo_precio_14_1"], $_POST["precio_unitario"], $_POST["igvBD"], $_POST["igvBD"], $_POST["afectacion_igv_3"], $_POST["afectacion_igv_4"], $_POST["afectacion_igv_5"], $_POST["afectacion_igv_6"], $_POST["igvBD2"], $_POST["vvu"], $_POST["subtotalBD"], $_POST["codigo"] , $_POST["unidad_medida"], $idserie, $SerieReal, $numero_boleta, $tipo_doc_ide, $rucCliente,$RazonSocial, $hora, $_POST["descdet"], $vendedorsitio, '0', $tiponota, $_POST["cantidadreal"], 
    $faltante, $adelanto, $ncotizacion, $ambtra, $estadonota);

    echo $rspta ? "Nota de pedido registrada nuevo" : "No se pudierón registrar todos los datos de la Nota de pedido";
        }
        else
        {
            if (empty($_POST["idnota"])) {
                $_POST["idnota"]="";
            }

 $rspta=$notapedido->insertar($idusuario, $fecha_emision_01, $firma_digital_36, $idempresa, $tipo_documento_06, $numeracion_07, $idcliente, $codigo_tipo_15_1, $monto_15_2, $sumatoria_igv_18_1, $sumatoria_igv_18_2, $codigo_tributo_18_3, $nombre_tributo_18_4, $codigo_internacional_18_5, $importe_total_23, $codigo_leyenda_26_1,  $descripcion_leyenda_26_2,  $tipo_documento_25_1, $guia_remision_25, $version_ubl_37, $version_estructura_38, $tipo_moneda_24, $tasa_igv, $_POST["idarticulo"], $_POST["numero_orden_item_29"], $_POST["cantidad_item_12"], $_POST["codigo_precio_14_1"], $_POST["precio_unitario"], $_POST["igvBD"], $_POST["igvBD"], $_POST["afectacion_igv_3"], $_POST["afectacion_igv_4"], $_POST["afectacion_igv_5"], $_POST["afectacion_igv_6"], $_POST["igvBD2"], $_POST["vvu"], $_POST["subtotalBD"], $_POST["codigo"] , $_POST["unidad_medida"], $idserie, $SerieReal, $numero_boleta, $tipo_doc_ide, $rucCliente,$RazonSocial, $hora, $_POST["descdet"], $vendedorsitio, $_POST["idnota"], $tiponota, $_POST["cantidadreal"], $faltante, $adelanto, $ncotizacion, $ambtra, $estadonota );

                
            echo $rspta ? "Nota de pedido registrada cliente nuevo" : "No se pudierón registrar todos los datos de la Nota de pedido";


        } //FIN DE SEGUNDO IF




     } // $######################## FIN DE IF SI ES MAYOR O MENOR A 700
     else
     {
            $rspta=$notapedido->editarnota($idboleta, $idusuario, $fecha_emision_01, $firma_digital_36, $idempresa, $tipo_documento_06, $numeracion_07, $idcliente, $codigo_tipo_15_1, $monto_15_2, $sumatoria_igv_18_1, $sumatoria_igv_18_2, $codigo_tributo_18_3, $nombre_tributo_18_4, $codigo_internacional_18_5, $importe_total_23, $codigo_leyenda_26_1,  $descripcion_leyenda_26_2,  $tipo_documento_25_1, $guia_remision_25, $version_ubl_37, $version_estructura_38, $tipo_moneda_24, $tasa_igv, $_POST["idarticulo"], $_POST["numero_orden_item_29"], $_POST["cantidad_item_12"], $_POST["codigo_precio_14_1"], $_POST["precio_unitario"], $_POST["igvBD"], $_POST["igvBD"], $_POST["afectacion_igv_3"], $_POST["afectacion_igv_4"], $_POST["afectacion_igv_5"], $_POST["afectacion_igv_6"], $_POST["igvBD2"], $_POST["vvu"], $_POST["subtotalBD"], $_POST["codigo"] , $_POST["unidad_medida"], $idserie, $SerieReal, $numero_boleta, $tipo_doc_ide, $rucCliente,$RazonSocial, $hora, $_POST["descdet"], $vendedorsitio, $_POST["idnota"], $tiponota, $_POST["cantidadreal"], $faltante, $adelanto, $ncotizacion, $ambtra, $estadonota);
            //$hora=date("h:i:s");
            echo $rspta ? "Se edito correctamente" : "Problemas al guardar" ;

        }
        

    break;














 
    case 'anular':
        $rspta=$notapedido->anular($idnotaped);
        echo $rspta ? "Nota de pedido anulada" : "Nota de pedido no se puede anular";
    break;


    case 'baja':
        $com=$_GET['comentario'];
        $hor=$_GET['hora'];
        $hoy = date("Y-m-d"); 
        $rspta=$notapedido->baja($idboleta, $hoy, $com, $hor );
        echo $rspta ? "Nota de pedido de baja" : "Nota de pedido no se puede dar de baja";
    break;

    case 'actualizarNumero':
            require_once "../Modelos/Numeracion.php";
            $numeracion=new Numeracion();

            $num=$_GET['Num'];
            $idnumeracion=$_GET['Idnumeracion'];
            $rspta=$numeracion->UpdateNumeracion($num, $idnumeracion );
    break;
 
    case 'mostrar':
        $rspta=$notapedido->mostrar($idnotaped);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;
 
    case 'listarDetalle':
        //Recibimos el idingreso
        $id=$_GET['id'];
 
        $rspta = $notapedido->listarDetalle($id);
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
 
        $rspta = $numeracion->llenarSerieNpedido($idusuario);
 
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


     case 'listarArticulonota':
        $tipob=$_GET['tb'];
        $tipoprecio=$_GET['tprecio'];
        $tmm=$_GET['itm'];
        $almacen=$_GET['alm'];

        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
 
    
        $rspta=$articulo->listarActivosVentaumventa($_SESSION['idempresa'], $tipob, $almacen, $tipoprecio);
        //$rspta=$articulo->listarActivosVentaumventa($_SESSION['idempresa'], 'productos', '2', '1');
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->stock <= $reg->limitestock)?'<label style="color: red;">Limite stock es: </label>'. '<label style="color: red;">'.$reg->limitestock.'</label>'   
                                                : 
                '<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->familia.'\',\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.$reg->nombre.'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->abre.'\' ,\''.$reg->precio_unitario.'\',\''.$reg->factorconversion.'\' , \''.$reg->factorc.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->factorconversion,
                "3"=>$reg->nombreum,
                "4"=>$reg->precio_venta,
                "5"=>$reg->codigo,
                "6"=>($reg->imagen=="")?"<img src='../files/articulos/simagen.png' height='120px' width='120px'>":
                "<img src='../files/articulos/".$reg->imagen."' height='120px' width='120px'>"
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
        $codigob=$_GET['codigob'];
        $rspta=$articulo->listarActivosVentaxCodigo($codigob, $_SESSION['idempresa']);
        echo json_encode($rspta);
    break;

    

    case 'listar':
        $rspta=$notapedido->listar();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){

            $urlT='../reportes/exNotapedidoTicket.php?id=';
            $urlB='../reportes/exNotapedido.php?id=';
            $urlC='../reportes/exNotapedidocompleto.php?id=';

            if($reg->tipo_documento_06=='Ticket'){
                $url='../reportes/exNotapedidoTicket.php?id=';
            }else{
                $url='../reportes/exNotapedido.php?id=';

            }

$stt='';
if ($reg->estado=='5' || $reg->estado=='4') {
    $stt='none';
}
else
{
    $send='none';
}

if ($reg->estado=='3'  ) {
     $stt='none';   
}

            $data[]=array(
                "0"=>$reg->idboleta,
                "1"=>

                   '<div class="dropdown">
                <button  class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                :::
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-center">

                <li>
                   <a onclick="editarnotav('.$reg->idboleta.')">
                <i class="fa fa-pencil" data-toggle="tooltip" title="Editar documento"></i>
                                            Editar Nota  
                    </a>
                </li>


                <li>
                  <a   onclick="baja('.$reg->idboleta.')" data-toggle="tooltip" title="Cancelar recibo" style="visible:'.$stt.'; color:red;"> <i class="fa fa-thumbs-down" data-toggle="tooltip" title="Dra de baja"></i>  Dar de baja
                  </a>
                  </li>

                  <li>
                  <a target="_blank" href="'.$url.$reg->idboleta.'&idcliente='.$reg->idcliente.'">
                   <i class="fa  fa-print" data-toggle="tooltip" title="Imprimir Recibo"></i>
                  Imprimir Nota 2 copias
                  </a>
                  </i>

                   <li>
                  <a target="_blank" href="'.$urlC.$reg->idboleta.'&idcliente='.$reg->idcliente.'">
                   <i class="fa  fa-print" data-toggle="tooltip" title="Imprimir Recibo"></i>
                  Imprimir hoja completa
                  </a>
                  </i>




                   <li>
                <a  onclick="preticket2('.$reg->idboleta.')"><i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir Ticket"> </i> 
                Imprimir ticket
                    </a>
                  </li>

                </ul>
                </div>'
                    // // ' 
                    // <i  class="fa fa-level-down" onclick="baja('.$reg->idboleta.')" data-toggle="tooltip" title="Cancelar recibo" style="visible:'.$stt.'; color:red;"  ></i>'
                    // .
                    // '<a target="_blank" href="'.$url.$reg->idboleta.'&idcliente='.$reg->idcliente.'"> <i class="fa  fa-print" data-toggle="tooltip" title="Imprimir Recibo" > </i>
                    // </a>'
                    // .
                    // '<a target="_blank" href="'.$urlT.$reg->idboleta.'"> <i class="fa  fa-print" data-toggle="tooltip" title="Imprimir Ticket"> </i>
                    // </a>
                     ,
                "2"=>$reg->fecha,
                "3"=>$reg->nombres,
                "4"=>$reg->vendedorsitio,
                "5"=>$reg->numeracion_07,
                "6"=>$reg->importe_total_23,

                //Actualizado ===============================================
                "7"=>($reg->estado=='1')//si esta emitido
                ?'<span>EMITIDO</span></i>     '
                : (($reg->estado=='4')?'<i class="fa fa-thumbs-up" style="font-size: 18px; color:#239B56;"> <span>Firmado</span></i>' //si esta firmado

                : (($reg->estado=='3' )?'<i class="fa fa-dot-circle-o" style="font-size: 18px; color:#E59866;"> <span>De baja</span></i> ' // si esta de baja

                : (($reg->estado=='0' )?'<i class="fa fa-dot-circle-o" style="font-size: 18px; color:#E59866;"> <span>Con Nota cd</span></i> ' // si esta de baja

                : (($reg->estado=='5')?'<span style="color:green;"">APROBADO</span>' // Si esta aceptado por SUNAT

                : '<i class="fa fa-thumbs-down" style="font-size: 18px; color:#922B21;"> <span>Anulado</span></i> ' )))) //Si esta anulado
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
    $rspta=$numeracion->llenarNumeroNpedido($Ser);
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

        $rspta=$notapedido->enviarcorreo($idnotaped);
        echo $rspta ;
    break;




    case 'listarcomprobantesclientesEstado':
        $dnicliente=$_GET['dnicliente'];
        $rspta=$notapedido->listarcomprobantes($dnicliente);
        $data= Array();
        while ($reg=$rspta->fetch_object()){
         $data[]=array(
                "0"=>'<a onclick="agregarClientesComprobantes('.$reg->idboleta.',\''.$reg->fecha.'\',\''.$reg->nombres.'\',\''.$reg->numeroserie.'\',\''.$reg->total.'\')" data-toggle="tooltip" title="Agregar">+</a>',
               "1"=>$reg->fecha,
                "2"=>$reg->nombres,
                "3"=>$reg->numeroserie,
                "4"=>$reg->total,
                "5"=>($reg->estado=='1')?'<span>EMITIDO</span>'
                : (($reg->estado=='5')?'<span>PAGADO</span>':
                    '<span>ANULADO</span>')
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;


    case 'listarcomprobantes':
        $rspta=$notapedido->listarcomprobantesCE();
        $data= Array();
        while ($reg=$rspta->fetch_object()){
         $data[]=array(
                "0"=>'<a onclick="agregarDetalleEstadocliente('.$reg->idboleta.',\''.$reg->fecha.'\',\''.$reg->nombres.'\',\''.$reg->numeroserie.'\',\''.$reg->total.'\',\''.$reg->estado.'\')" data-toggle="tooltip" title="Agregar">+</a>',
               "1"=>$reg->fecha,
                "2"=>$reg->nombres,
                "3"=>$reg->numeroserie,
                "4"=>$reg->total,
                "5"=>($reg->estado=='1')?'<span>EMITIDO</span>'
                : (($reg->estado=='5')?'<span>PAGADO</span>':
                    '<span>ANULADO</span>')
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;





    case 'selectAlmacen':
            
        $rspta = $notapedido->almacenlista();
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idalmacen . '>' . $reg->nombre . '</option>';
                }
        break;


        case 'mostrarultimocomprobanteId':
        $rspta = $notapedido->mostrarultimocomprobanteId($_SESSION['idempresa']);
        echo    json_encode($rspta);
        break;


         case 'editar':
        $rspta=$notapedido->editar($idboleta);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

        case 'numerof':
        $rspta=$notapedido->listarnumerofilas($idboleta);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;


        case 'traercotizacion':
                $idcotizacion=$_GET['idcoti'];
                $rspta=$cotizacion->traercotizacion($idcotizacion);
                echo json_encode($rspta);
        break;



        case 'listarDetallenota':
    //Recibimos el idingreso
        $id=$_GET['id'];
 
        $rspta = $notapedido->listarDetallenotav($id);
        $subt=0;
        $igv=0;
        $total=0;
        echo '
        <thead style="background-color:#35770c; color: #fff; text-align: justify;">
                                     <th>Sup.</th>
                                    <th>Item</th>
                                    <th>Artículo</th>
                                    <th >Descrip.</th>
                                    <th>Cant.</th>
                                    
                                    <th>U.M.</th>
                                    <th>Prec. Uni.</th>
                                    <th>Stock</th>
                                    
                                    <th>Importe</th>
        </thead>';
 
        while ($reg = $rspta->fetch_object())
                {
        echo '<tr class="filas" id="fila'.$cont.'">
        <td>
        <button type="button" class="btn btn-danger btn-sm" 
        onclick="eliminarDetalle('.$cont.')">X</button>
        </td>

        <td>
        <span name="numero_orden" id="numero_orden'.$cont.'">'.$reg->norden.'</span>
        <input type="hidden" name="numero_orden_item_29[]" id="numero_orden_item_29[]" 
        value="'.$reg->norden.'">
        </td>

        <td><input type="hidden" name="idarticulo[]" style="font-family: times, serif; font-size:14pt; font-style:italic" value="'.$reg->idarticulo.'">'.$reg->descripcion.
        '</td>

        <td><input type="text" class="" name="descdet[]" id="descdet[]" onkeyup="mayus(this)" onkeypress="return focusDescdet(event, this)">
        </td>

        <td><input type="text"  class="" required="true" name="cantidad_item_12[]" id="cantidad_item_12[]" onBlur="modificarSubototales()" onkeypress="return NumCheck(event, this)" value="'.$reg->cantidad.'">
        </td>

        

        <td><input type="hidden" name="unidad_medida[]" id="unidad_medida[]" value="'.$reg->abre.'">
        '.$reg->unidad_medida.'</td>

        <td><input type="text" class="" name="precio_unitario[]" id="precio_unitario[]" value="'.$reg->pvi.'" onBlur="modificarSubototales()" size="7" onkeypress="return NumCheck2(event, this)" OnFocus="focusTest(this); return false;">
        </td>

        <td><input type="text" class="" name="stock[]" id="stock[]" value="'.$reg->stock.'" disabled="true" size="7">
        </td>
        
        <td>
        <span name="subtotal" id="subtotal'.$cont.'">'.$reg->vvi.'</span>
        <input type="hidden"  class="" name="subtotalBD[]" id="subtotalBD["'.$cont.'"]" onBlur="modificarSubototales()" value="'.$reg->vvi.'">
        <span name="igvG" id="igvG'.$cont.'" style="background-color:#9fde90bf; display:none;">
        </span>
        <input type="hidden" name="igvBD[]" id="igvBD["'.$cont.'"]" value="">
        <input type="hidden" name="igvBD2[]" id="igvBD2["'.$cont.'"]" value="">
        <span name="total" id="total'.$cont.'" display:none;" ></span>
        <span name="pvu_" id="pvu_'.$cont.'"  style="display:none"></span>
        <input type="hidden"  class="" required="true" name="factorc[]" id="factorc[]" value="">
        <input type="hidden"  class="" required="true" name="cantidadreal[]" id="cantidadreal[]" >
        <input  type="hidden" name="vvu[]" id="vvu["'.$cont.'"] size="2" value="'.$reg->vui.'">
        </td>
        </tr>';

                    $subt=$reg->subtotal;
                    $igv=$reg->igv;
                    $total=$reg->total;
                    $adel=$reg->adelanto;
                    $falt=$reg->faltante;
                }
                 $cont++;
        
        echo '<tfoot>
                      <tr><td><td></td><td></td><td></td><td></td><td></td><td></td>
                             <th id="Titulo" style="font-weight: bold; vertical-align: center; background-color:#FFB887;">TOTAL CONCEPTO</th>  
                             <!--Datos de impuestos-->  <!--IGV-->
                            <th id="CuadroT" style="font-weight: bold; background-color:#FFB887;">

                            <h4 id="total" style="font-weight: bold; vertical-align: center; background-color:#FFB887;">'.$subt.'</h4>

    <input type="hidden" name="total_final" id="total_final" value="'.$total.'">
    <input type="hidden" name="pre_v_u" id="pre_v_u">
    <input type="hidden" name="subtotal_boleta" id="subtotal_boleta" value="'.$subt.'">
    <input type="hidden" name="total_igv" id="total_igv" value="'.$igv.'">

                            </th>
                            <!--Datos de impuestos-->  <!--TOTAL-->
                            </td>
                        </tr>

                       

                    <tr>
                        <tr><td><td></td><td></td><td></td><td></td><td></td><td></td>
                             <th id="Titulo" style="font-weight: bold; vertical-align: center; background-color:#FFB850;">ADELANTO <label id="porade" style="font-weight: bold;" >%</label></th>
                             <th style="font-weight: bold; background-color:#FFB860;">
                    <input type="text" class="" name="adelanto" id="adelanto" 
                    onchange="modificarSubototales();" value="'.$adel.'" onfocus="focusTest(this)" >
                            </th>  
                                    </td>
                        </tr>


                    <tr><td><td></td><td></td><td></td><td></td><td></td><td></td>
                             <th id="Titulo" style="font-weight: bold; vertical-align: center; background-color:#FFB860;">FALTANTE <label id="porfalt" style="font-weight: bold;" >%</label></th>  <!--Datos de impuestos-->  <!--IGV-->
                <th style="font-weight: bold; background-color:#FFB860;">
                            <input type="text" class="" name="faltante" id="faltante" value="'.$falt.'" readonly>
                            </th>  
                         </td>
                        </tr>

             <tr>
               <tr><td><td></td><td></td><td></td><td></td><td></td><td></td>
                <th id="Titulo" style="font-weight: bold; vertical-align: center; background-color:#FFB887;">TOTAL ABONAR
                </th>  <!--Datos de impuestos-->  <!--IGV-->
              <th id="CuadroT" style="font-weight: bold; background-color:#FFB887;">
               <h4 id="total_g" style="font-weight: bold; vertical-align: center; background-color:#FFB887;">0.00
               </h4>
               <input type="hidden" name="total_g" id="total_g">
                </th><!--Datos de impuestos-->  <!--TOTAL-->
                </td>
            </tr>


                                </tfoot>';
            break;



   }


?>