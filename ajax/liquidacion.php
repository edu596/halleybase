<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Liquidacion.php";

$cont=0;
$conNO=1;

$liquidacion=new Liquidacion();

$tservicio=isset($_POST["tservicio"])? limpiarCadena($_POST["tservicio"]):"";

$idliquidacion=isset($_POST["idliquidacion"])? limpiarCadena($_POST["idliquidacion"]):"";
$fechaemision=isset($_POST["fechaemision"])? limpiarCadena($_POST["fechaemision"]):"";
$creserv=isset($_POST["creserv"])? limpiarCadena($_POST["creserv"]):"";
$dnir=isset($_POST["dnir"])? limpiarCadena($_POST["dnir"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$datoscli=isset($_POST["datoscli"])? limpiarCadena($_POST["datoscli"]):"";
$file=isset($_POST["file"])? limpiarCadena($_POST["file"]):"";
$programa=isset($_POST["programa"])? limpiarCadena($_POST["programa"]):"";
$observaciones=isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";
$restricciones=isset($_POST["restricciones"])? limpiarCadena($_POST["restricciones"]):"";

$item=isset($_POST["item"])? limpiarCadena($_POST["item"]):"";
$precio=isset($_POST["precio"])? limpiarCadena($_POST["precio"]):"";
$cantidad=isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";
$total=isset($_POST["total"])? limpiarCadena($_POST["total"]):"";
$entidadb=isset($_POST["entidadb"])? limpiarCadena($_POST["entidadb"]):"";
$tipocuenta=isset($_POST["tipocuenta"])? limpiarCadena($_POST["tipocuenta"]):"";
$titularc=isset($_POST["titularc"])? limpiarCadena($_POST["titularc"]):"";
$ncuenta=isset($_POST["ncuenta"])? limpiarCadena($_POST["ncuenta"]):"";
$codigoint=isset($_POST["codigoint"])? limpiarCadena($_POST["codigoint"]):"";

$condiciones=isset($_POST["condiciones"])? limpiarCadena($_POST["condiciones"]):"";
$tarifanore=isset($_POST["tarifanore"])? limpiarCadena($_POST["tarifanore"]):"";

$tipomoneda=isset($_POST["tipomoneda"])? limpiarCadena($_POST["tipomoneda"]):"";
$tcambio=isset($_POST["tcambio"])? limpiarCadena($_POST["tcambio"]):"";

$tldesc=isset($_POST["tldesc"])? limpiarCadena($_POST["tldesc"]):"";


switch ($_GET["op"]){
    case 'guardaryeditarLiquidacion':
    $hora=date("h:i:s");
    if ($tservicio=='s'){

        if (empty($idliquidacion)){
        $rspta=$liquidacion->insertar(
            $tservicio,
            $idcliente,
            $fechaemision, 
            $file, 
            $programa, 
            $observaciones, 
            $restricciones, 
            $item, 
            $precio, 
            $cantidad, 
            $total, 
            $entidadb, 
            $tipocuenta, 
            $titularc, 
            $ncuenta, 
            $codigoint,
            $hora,
            $tipomoneda,
            $tcambio,
            $creserv,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            $condiciones,
            $tarifanore
        );
            echo $rspta ? "Se guardo correctamente" : "No se guardo factura";
        }
        else
        { // CASO DE EDITAR

            $rspta=$liquidacion->editar(
            $idliquidacion,    
            $tservicio,
            $idcliente,
            $fechaemision, 
            $file, 
            $programa, 
            $observaciones, 
            $restricciones, 
            $item, 
            $precio, 
            $cantidad, 
            $total, 
            $entidadb, 
            $tipocuenta, 
            $titularc, 
            $ncuenta, 
            $codigoint,
            $hora,
            $tipomoneda,
            $tcambio,
            $creserv,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
            
        );
             
        echo $rspta ? "Se edito correctamente" : "No se edito factura";

        }


            }else{ // SI ES VUELO


    if (empty($idliquidacion)){
        $rspta=$liquidacion->insertar(
            $tservicio,
            $idcliente,
            $fechaemision,
            '', 
            '',  
            '', 
            '',  
            $item, 
            $precio, 
            $cantidad, 
            $total, 
            $entidadb, 
            $tipocuenta, 
            $titularc, 
            $ncuenta, 
            $codigoint,
            $hora,
            $tipomoneda,
            $tcambio,
            $creserv,
            $_POST["aerol"],
            $_POST["nvuelo"],
            $_POST["fecha"],
            $_POST["destino"],
            $_POST["hsalida"],
            $_POST["hretorno"],
            $_POST["tldesc"],
            $_POST["detallevutl"],
            $condiciones,
            $tarifanore
        );

            echo $rspta ? "Se guardo correctamente" : "No se guardo factura";

        }
        else
        { // CASO DE EDITAR

            $rspta=$liquidacion->editar(
            $idliquidacion,    
            $tservicio,
            $idcliente,
            $fechaemision, 
            '', 
            '', 
            '', 
            '', 
            $item, 
            $precio, 
            $cantidad, 
            $total, 
            $entidadb, 
            $tipocuenta, 
            $titularc, 
            $ncuenta, 
            $codigoint,
            $hora,
            $tipomoneda,
            $tcambio,
            $creserv,
            $_POST["aerol"],
            $_POST["nvuelo"],
            $_POST["fecha"],
            $_POST["destino"],
            $_POST["hsalida"],
            $_POST["hretorno"],
            $_POST["tldesc"],
            $_POST["detallevutl"],
            $condiciones,
            $tarifanore
            
        );
            echo $rspta ? "Se edito correctamente" : "No se edito factura";

        }
    }
   
    break;



    case 'guardaryeditarfacturadc':

        if (empty($idliquidacion)){
        $rspta=$factura->insertar($idusuario, $fedc, '', $idempresa2, '01', '', $idclientef, '1001', $subtotalfactura, $totaligv, $totaligv, '1000', 'IGV', 'VAT', $totalfactura, '-', '-', '1000', '-', '2.0', '1.0', $tipomonedafactura, '0.18', $_POST["idarticulof"], $_POST["norden"], $_POST["cantidadf"], '01', $_POST["valorunitariof"], $_POST["igvitem"], $_POST["igvitem"], $_POST["afeigv3"], $_POST["afeigv4"], '', '', $_POST["igvitem"], $_POST["preciof"], $_POST["valorventaf"], $_POST["codigof"] , $_POST["unidad_medida"], $idseriedc, $SerieRealdc, $numero_facturadc, $tipodocucli,  $nrodoccli , htmlspecialchars_decode($razonsf), $horaf, $_POST["sumadcto"], '', htmlspecialchars_decode($correocliente), htmlspecialchars_decode($domfiscal), '1000', '', $tcambiofactura, $tipopago, $nroreferenciaf, '', '', $_POST["descdetf"], '', '','','', $ccuotas, '', '', '' , 
            $tadc, $transferencia, $_POST["ncuotahiden"], $_POST["montocuotacre"], $_POST["fechapago"], $fedc);
                
           // $hora=date("h:i:s");
                
            echo $rspta ? "Factura registrada desde documento de cobranza": "No se pudieron registrar todos los datos de la factura";
        }
        else{
        }
   
    break;



        case 'buscarclientepred':
    	$key = $_POST['key'];
		$rspta=$liquidacion->buscarclientepredict($key);
		echo json_encode($rspta); // ? "Cliente ya existe": "Documento valido";
		break;

		case 'listarClientesliqui':
        require_once "../modelos/Persona.php";
        $persona=new Persona();
        $doc=$_GET['doc'];
        $rspta = $liquidacion->buscarClientes($doc);
        echo json_encode($rspta);
        break;


        case 'listar':

        //$idempresa=$_GET['idempresa'];
        $rspta=$liquidacion->listar();
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>
                '<div class="dropdown">
                <button  class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                :::
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-center">

                <li>
                  <a  onclick="impresion('.$reg->idliquidacion.')"> 
                   <i class="fa  fa-print"  data-toggle="tooltip" title="Imprimir" onclick=""></i>
                   Imprimir
                    </a>
                 </li>

                <li>
                    <a  onclick="editarcotizacion('.$reg->idliquidacion.')"> <i class="fa fa-pencil" style="color:orange;" data-toggle="tooltip" title="Editar liquidación"> </i> Editar</a>
                </li>

                

                </ul>
                </div>',
                "1"=>$reg->idliquidacion,
                "2"=>$reg->fechaemision,
                "3"=>$reg->nombre_comercial,
                "4"=>$reg->total
                );

        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

    break;


     case 'datoscuentas':
        $rspta=$liquidacion->cuentasempresa($_SESSION["idempresa"]);
        echo json_encode($rspta); // ? "Cliente ya existe": "Documento valido";
        break;


    case 'editar':
        $rspta=$liquidacion->datosliquidacion($idliquidacion);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;



        case 'traerdetallenvuelo':
        $id=$_GET['id'];
 
        $rspta = $liquidacion->listarDetalleliquidacion($id);
        echo ' <thead>
                            <th>...</th>
                            <th>Aerolinea</th>
                            <th>N° vuelo</th>
                            <th>Fecha</th>
                            <th>Destino</th>
                            <th>H.salida</th>
                            <th>H.retorno</th>
                            <th>...</th>
                </thead>';


 
        while ($reg = $rspta->fetch_object())
                {


            if ($reg->detallevutl=="dvuel") {
           
   echo '<tr class="filas" id="fila'.$cont.'">
        <td><i class="fa fa-close" 
        onclick="eliminarDetalle('.$cont.')" data-toggle="tooltip" title="Eliminar item"></i></td>
    <td><input type="text" name="aerol[]" id=" aerol[]"  value="'.$reg->aerolinea.'" onkeyup="mayus(this)"></td>
    <td><input type="text" name="nvuelo[]" id="nvuelo[]" value="'.$reg->nvuelo.'" ></td>
    <td><input type="date" name="fecha[]" id="fecha[]" value="'.$reg->fechaidaretor.'" ></td>
    <td><input type="text" name="destino[]" id="destino[]" onkeyup="mayus(this)" value="'.$reg->destino.'"></td>
    <td><input type="time" name="hsalida[]" id="hsalida[]" value="'.$reg->hsalida.'" max="23:59" min="00:00"></td>
    <td><input type="time" name="hretorno[]" id="hretorno[]" value="'.$reg->hretorno.'" max="23:59" min="00:00" onkeypress="nextf(event, this)"><input type="hidden" name=detallevutl[] id=detallevutl[] value="dvuel">
    </td>
    <td><button type="button" onclick="detallevuelo()">Vuelo</button>   <button type="button" onclick="detalletl()">TL</button>
    </td>
        </tr>';


    }else{

        echo '
        <tr class="filas" id="fila'.$cont.'">
    <td><i class="fa fa-close" onclick="eliminarDetalle('.$cont.')" data-toggle="tooltip" title="Eliminar item"></i></td>
    <td><input type="text" name="aerol[]" id="aerol[]" onkeyup="mayus(this)" value="'.$reg->aerolinea.'"></td>
    <td colspan="5"><textarea  id="tldesc[]" name="tldesc[]" class="" cols="40" rows="2" 
    >'.$reg->tldesc.'</textarea></td>
    <td><button type="button" onclick="detallevuelo()">Vuelo</button><button type="button" onclick="detalletl()">TL</button>
    <input type="hidden"  name=detallevutl[] id=detallevutl[] value="dtl"></td>
    </tr>';

    }
                    
                }
                 $cont++;
        
       break;





    
        }
?>