<?php
if (strlen(session_id())<1) {
	session_start();

	require_once "../modelos/Venta.php";

	$venta= new Venta();

switch ($_GET["op"]) {


	case 'regbajas':
		$ano=$_GET['ano'];
        $mes=$_GET['mes'];
        $dia=$_GET['dia'];

        $rspta=$venta->bajanc($ano, $mes, $dia, $_SESSION['idempresa']);
        
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            
                $url='../reportes/exNcredito.php?id=';
                $urlTipo='&tipodoc=01';
            
            $data[]=array(
                "0"=>$reg->fecha,
                "1"=>$reg->comentario_baja,
                "2"=>$reg->documento,
                "3"=>'<a target="_blank" href="'.$url.$reg->id.$urlTipo.'"> <i class="fa fa-file"> </i></a>',
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



    case 'generarbajaxml':
        $ano=$_GET['ano'];
        $mes=$_GET['mes'];
        $dia=$_GET['dia'];
     $rspta=$venta->regbajasxmlnc($ano, $mes, $dia, $_SESSION['idempresa']);
     echo json_encode($rspta) ;
    break;



    case 'enviarxmlbajanotacredito':
        $nombrexmll=$_GET['nombrexml'];
        $rspta=$venta->enviarxmlbajafactura($nombrexmll,  $_SESSION['idempresa']);
        echo json_encode($rspta);
    break;



    case 'ultimoarchivoxml':
        $ultimoxml=$_GET['ultimoxml'];

        $rspta=$venta->ultimoarchivoxmlnotacredito($ultimoxml);
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>$reg->fecha,
                "1"=>$reg->nombrebaja,
                "2"=>$reg->numticket,
                "3"=>'<button  class="btn btn-warning" onclick="detalle('.$reg->id.')"><span class="fa fa-plus"></span></button>'
                );
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
    break;




    


    case 'detallecomprobante':
        $idxml=$_GET['idxml'];

        $rspta=$venta->detallecomprobantes($idxml);
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>$reg->numerof,
                "1"=>$reg->fechaemision,
                "2"=>$reg->total
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


}



?>