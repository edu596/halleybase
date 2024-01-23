<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Notacd.php";
require_once "../modelos/Numeracion.php";
$notacd=new Notacd();

$idnota=isset($_POST["idnota"])? limpiarCadena($_POST["idnota"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$serie=isset($_POST["SerieReal"])? limpiarCadena($_POST["SerieReal"]):"";
$numero_nc=isset($_POST["numero_nc"])? limpiarCadena($_POST["numero_nc"]):"";
$fecha=isset($_POST["fecha_emision"])? limpiarCadena($_POST["fecha_emision"]):"";
$codigo_nota=isset($_POST["codigo_nota"])? limpiarCadena($_POST["codigo_nota"]):"";
$desc_motivo=isset($_POST["desc_motivo"])? limpiarCadena($_POST["desc_motivo"]):"";
$tipo_doc_mod=isset($_POST["tipo_doc_mod"])? limpiarCadena($_POST["tipo_doc_mod"]):"";
$numero_comprobante=isset($_POST["numero_comprobante"])? limpiarCadena($_POST["numero_comprobante"]):"";
$tipo_doc_ide=isset($_POST["tipo_documento_cliente"])? limpiarCadena($_POST["tipo_documento_cliente"]):"";
$numero_documento=isset($_POST["numero_documento"])? limpiarCadena($_POST["numero_documento"]):"";
$razon_social=isset($_POST["razon_social"])? limpiarCadena($_POST["razon_social"]):"";
$tipo_moneda=isset($_POST["tipo_moneda"])? limpiarCadena($_POST["tipo_moneda"]):"";
$sum_ot_car=isset($_POST["sum_ot_car"])? limpiarCadena($_POST["sum_ot_car"]):"";
$total_val_venta_oi=isset($_POST["total_val_venta_oi"])? limpiarCadena($_POST["total_val_venta_oi"]):"";
$total_val_venta_oe=isset($_POST["total_val_venta_oe"])? limpiarCadena($_POST["total_val_venta_oe"]):"";
$sum_isc=isset($_POST["sum_isc"])? limpiarCadena($_POST["sum_isc"]):"";
$sum_ot=isset($_POST["sum_ot"])? limpiarCadena($_POST["sum_ot"]):"";

$subtotal=isset($_POST["subtotal_comprobante"])? limpiarCadena($_POST["subtotal_comprobante"]):"";
$igv_=isset($_POST["total_igv"])? limpiarCadena($_POST["total_igv"]):"";
$total=isset($_POST["total_final"])? limpiarCadena($_POST["total_final"]):"";

$tipo_doc_mod=isset($_POST["tipo_doc_mod"])? limpiarCadena($_POST["tipo_doc_mod"]):"";




switch ($_GET["op"]){
    case 'guardaryeditarnc':
        if (empty($idnota)){
        $rspta=$notacd->insertarNC($idnota, $nombre, $serie, $numero_nc , $fecha, $codigo_nota, $desc_motivo, $tipo_doc_mod, $numero_comprobante, $tipo_doc_ide, $numero_documento, $razon_social, $tipo_moneda, $sum_ot_car, $subtotal, $total_val_venta_oi, $total_val_venta_oe, $igv_, $sum_isc, $sum_ot, $total);
                
            echo $rspta ? "Nota de crédito registrada" : "No se pudieron registrar todos los datos de la Nota de crédito";
        }
        else{
        }

    
    break;
 
    case 'anular':
        $rspta=$factura->anular($idfactura);
        echo $rspta ? "Factura anulada" : "Factura no se puede anular";
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


   

    case 'listar':
        $rspta=$factura->listar();
        //Vamos a declarar un array
        $data= Array();
            $data[]=array(
                "0"=>(($reg->estado=='1')?' <i class="fa fa-close"  onclick="anular('.$reg->idfactura.')"></i></button>'.
                    '<a target="_blank" href="'.$url.$reg->idfactura.'"><i class="fa fa-file"></i></button></a>':''),
                    //'<button class="btn btn-warning" onclick="mostrar('.$reg->idfactura.')"><i class="fa fa-eye"></i></button>').
                
                "1"=>$reg->fecha,
                "2"=>$reg->cliente,
                "3"=>$reg->usuario,
                "4"=>$reg->numeracion_08,
                "5"=>$reg->importe_total_venta_27,
                "6"=>($reg->estado=='1')?'<span class="label bg-green">Emitida</span>':
                '<span class="label bg-red">Anulado</span>'
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
    $rspta=$numeracion->llenarNumeroNcredito($Ser);
        while ($reg=$rspta->fetch_object())
        {
        echo $reg->Nnumero;    
        }
    break;

//====================================================================================
    // Carga de tipos de documentos para venta
    case 'selectcatalogo9':
        require_once "../modelos/Notacf.php";

        $departamento = new Notacf(); 
        $rspta = $departamento->selectD();
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->codigo . '>' . $reg->descripcion . '</option>';
                }
    break;



    case 'selectSerie':
        require_once "../modelos/Numeracion.php";
        $numeracion = new Numeracion();
 
        $rspta = $numeracion->llenarSerieNcredito();
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idnumeracion . '>' . $reg->serie . '</option>';

                }
    break; 



case 'listarComprobante':

    $tipodocu=$_GET['tipodo'];

    if($tipodocu=="01"){
       require_once "../modelos/Notacf.php";
        $notacf=new Notacf();
        $rsptaf=$notacf->buscarComprobante();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rsptaf->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarComprobante('.$reg->idfactura.',\''.$reg->tipo_documento.'\',\''.$reg->numero_documento.'\',\''.$reg->razon_social.'\',\''.$reg->domicilio.'\', \''.$reg->tipocomp.'\',\''.$reg->numerodoc.'\', \''.$reg->codigo.'\',\''.$reg->descripcion.'\',\''.$reg->cantidad.'\', \''.$reg->vui.'\',\''.$reg->pvi.'\',\''.$reg->vvi.'\',\''.$reg->igvi.'\',\''.$reg->subtotal.'\',\''.$reg->igv.'\',\''.$reg->total.'\')"><span class="fa fa-plus"></span></button>',

                "1"=>$reg->numero_documento,
                "2"=>$reg->razon_social,
                "3"=>$reg->domicilio,
                "4"=>$reg->numerodoc,
                "5"=>$reg->subtotal,
                "6"=>$reg->igv,
                "7"=>$reg->total
                );
        }
        $results = array( 
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);

    }else{ // si es boleta

        require_once "../modelos/Notacb.php";
        $notacb=new Notacb();
        $rsptab=$notacb->buscarComprobante();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rsptab->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarComprobante('.$reg->idboleta.',\''.$reg->tipo_documento.'\',\''.$reg->numero_documento.'\',\''.$reg->razon_social.'\',\''.$reg->domicilio.'\', \''.$reg->tipocomp.'\',\''.$reg->numerodoc.'\', \''.$reg->codigo.'\',\''.$reg->descripcion.'\',\''.$reg->cantidad.'\', \''.$reg->vui.'\',\''.$reg->pvi.'\',\''.$reg->vvi.'\',\''.$reg->igvi.'\',\''.$reg->subtotal.'\',\''.$reg->igv.'\',\''.$reg->total.'\')"><span class="fa fa-plus"></span></button>',

                "1"=>$reg->numero_documento,
                "2"=>$reg->razon_social,
                "3"=>$reg->domicilio,
                "4"=>$reg->numerodoc,
                "5"=>$reg->subtotal,
                "6"=>$reg->igv,
                "7"=>$reg->total
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

    if($tipodocu=="01"){
        require_once "../modelos/Notacf.php";
        $notacf=new Notacf();
        $rsptaf=$notacf->buscarComprobanteId($idcomp);
        
        $data= Array();
        $item=1;
        echo '<thead style="background-color:#35770c; color: #fff;">
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
       
echo ' <tr class="filas" id="fila">
    <td><input type="text" class="form-control" name="numero_orden" id="numero_orden" value="'.$item.'" size="1" disabled="true" disabled="true"></td>
<td><input type="text" name="codigo" id="codigo"  value="'.$reg->codigo.'" class="form-control" disabled="true" ></td>
<td><input type="text" class="form-control"  name="descripcion" id="descripcion" value="'.$reg->descripcion.'" size="20" disabled="true" disabled="true"></td>
<td><input type="text" class="form-control"  name="cantidad" id="cantidad" value="'.$reg->cantidad.'" disabled="true" ></td>
<td><input type="text" class="form-control"   name="vunitario" id="vunitario" value="'.$reg->vui.'"  disabled="true"></td>
<td><input type="text" class="form-control"  name="punitario" id="punitario" value="'.$reg->pvi.'"  disabled="true"></td>
<td><input type="text" class="form-control"  name="vventa" id="vventa" value="'.$reg->vvi.'" disabled="true" ></td>
<td><input type="text" class="form-control"  name="igvventa" id="igvventa" value="'.$reg->igvi.'" disabled="true" ></td>
        </tr>';
        $item=$item + 1;
                }


        }else{

        require_once "../modelos/Notacb.php";
        $notacb=new Notacb();
        $rsptab=$notacb->buscarComprobanteId($idcomp);
        
        $data= Array();
        $item=1;
        echo '<thead style="background-color:#35770c; color: #fff;">
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
       
echo ' <tr class="filas" id="fila">
    <td><input type="text" class="form-control" name="numero_orden" id="numero_orden" value="'.$item.'" size="1" disabled="true" disabled="true"></td>
<td><input type="text" name="codigo" id="codigo"  value="'.$reg->codigo.'" class="form-control" disabled="true" ></td>
<td><input type="text" class="form-control"  name="descripcion" id="descripcion" value="'.$reg->descripcion.'" size="20" disabled="true" disabled="true"></td>
<td><input type="text" class="form-control"  name="cantidad" id="cantidad" value="'.$reg->cantidad.'" disabled="true" ></td>
<td><input type="text" class="form-control"   name="vunitario" id="vunitario" value="'.$reg->vui.'"  disabled="true"></td>
<td><input type="text" class="form-control"  name="punitario" id="punitario" value="'.$reg->pvi.'"  disabled="true"></td>
<td><input type="text" class="form-control"  name="vventa" id="vventa" value="'.$reg->vvi.'" disabled="true" ></td>
<td><input type="text" class="form-control"  name="igvventa" id="igvventa" value="'.$reg->igvi.'" disabled="true" ></td>
        </tr>';
        $item=$item + 1;

        }
    }
    break;


}
?>