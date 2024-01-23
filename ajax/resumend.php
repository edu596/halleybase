<?php
if (strlen(session_id())<1) {
	session_start();

	require_once "../modelos/Venta.php";

	$venta= new Venta();

switch ($_GET["op"]) {
	case 'resumend':
		$ano=$_GET['ano'];
        $mes=$_GET['mes'];
        $dia=$_GET['dia'];
        $sstt=$_GET['sst'];

        $rspta=$venta->resumend($ano, $mes, $dia, $sstt);
        
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
   
                $url='../reportes/exBoleta.php?id=';

            
            $data[]=array(
                "0"=>$reg->fechagedoc,
                "1"=>$reg->fechagerres,
                "2"=>$reg->tipocomp,
                "3"=>$reg->serienum.'<a target="_blank" href="'.$url.$reg->id.'"> <i class="fa fa-file"> </i></a>',
                "4"=>$reg->tipodocuCliente,
                "5"=>$reg->rucCliente,
                "6"=>$reg->tmoneda,
                "7"=>$reg->subtotal,
                "8"=>$reg->igv,
                "9"=>$reg->total,
                "10"=>$reg->estado
                
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
        $st=$_GET['stb'];
     $rspta=$venta->regbajasxmlBoleta($ano, $mes, $dia, $st, $_SESSION['idempresa']);
     echo json_encode($rspta) ;
    break;


    

    case 'enviarxmlbajaboleta':
        $nombrexmll=$_GET['nombrexml'];
        $rspta=$venta->enviarxmlbajaBoleta($nombrexmll, $_SESSION['idempresa']);
        echo json_encode($rspta);
    break;


    case 'ultimoarchivoxml':
        $ultimoxml=$_GET['ultimoxml'];

        $rspta=$venta->ultimoarchivoxmlBoleta($ultimoxml);
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

        $rspta=$venta->detallecomprobantesboleta($idxml);
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>$reg->numerob,
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



       case 'validarticket':
        $nroticket=$_GET['ntikk'];
        $rspta=$venta->validarticketboleta($nroticket, $_SESSION["idempresa"]);
        echo json_encode($rspta);
        break;



	}
}



?>