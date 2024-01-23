<?php
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Cuotas.php";


$cuotas=new Cuotas();
$ano=isset($_POST["ano"])? limpiarCadena($_POST["ano"]):"";

switch ($_GET["op"]){

    case 'cuotapagada':
    $idc=$_GET['idc1'];
    $idcomp=$_GET['idco1'];
    $tipodoc=$_GET['tipcoo2'];
    $rspta=$cuotas->cuotpagada($idc, $idcomp, $tipodoc);
    break;


     case 'cancelarpag':
    $idc=$_GET['idc1'];
    $idcomp=$_GET['idco1'];
    $tipodoc=$_GET['tipcoo2'];
    $rspta=$cuotas->cancelacuot($idc, $idcomp, $tipodoc);
    break;

    //Registro de ventas de facturas y boletas agrupado por dias
    case 'listartcomprobantesC':

        $f1=$_GET['fec1'];
        $f2=$_GET['fec2'];
        $moneda=$_GET['mon'];
        $tipocom=$_GET['tipc'];
        
        $rspta=$cuotas->listartcomprobantes($f1, $f2, $moneda, $tipocom);


        
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            
            $data[]=array(
                "0"=>'<a>
                      <span class="fa fa-pencil"  data-toggle="tooltip" title="Editar documento"  onclick="editarcuotas('.$reg->idcomprobante.',\''.$reg->tipocomprobante.'\' ,\''.$reg->numerocomp.'\',\''.$reg->fechae.'\' ,\''.$reg->fechaa.'\',\''.$reg->cliente.'\',\''.$reg->total.'\')"> 
                      </span>
                    </a>',
                "1"=>$reg->numerocomp,
                "2"=>$reg->fechae,
                "3"=>$reg->cliente,
                "4"=>$reg->total,
                "5"=>$reg->ncuota,
                "6"=>'<span style="color:green;">'.$reg->cuotaspagadas.'</span>',
                "7"=>'<span style="color:red;">'.$reg->cuotaspendientes.'</span>'

                );
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
    break;



    case 'buscarcuotas':

        $idccpp=$_GET['idcompp'];
        $tppcc=$_GET['tipcc'];
        $rspta=$cuotas->buscarcuotasC($idccpp, $tppcc);
        
        //Vamos a declarar un array
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->estadocuota=='0')?'<a onclick="cuotapagada('.$reg->idcuota.',\''.$reg->idcomprobante.'\' ,\''.$reg->tipocomprobante.'\')">
                <i class="fa fa-check"  style="color:green; font-size:18px;" data-toggle="tooltip" title="Pagar cuota">
                </i>
                </a>'
                :
                '<a onclick="cancelarpago('.$reg->idcuota.',\''.$reg->idcomprobante.'\' ,\''.$reg->tipocomprobante.'\')">
                <i class="fa fa-ban"  style="color:red; font-size:18px;" data-toggle="tooltip" title="Cancelar pago">
                </i>
                </a>',
                "1"=>$reg->ncuota,
                "2"=>$reg->fechacuota,
                "3"=>$reg->montocuota,
                "4"=>($reg->estadocuota=='1')?'<span style="color:green;">PAGADO</span>':'<span style="color:red;">PENDIENTE</span>'
                );
            
        }

        $results = array(
            "sEcho"=>0, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
    break;


 



   }
?>