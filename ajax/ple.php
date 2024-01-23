<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Compra.php";
require_once "../modelos/Venta.php";

 
$compra=new Compra();
$venta=new Venta();



$ano=isset($_POST["ano"])? limpiarCadena($_POST["ano"]):"";
$mes=isset($_POST["mes"])? limpiarCadena($_POST["mes"]):"";
$moneda=isset($_POST["moneda"])? limpiarCadena($_POST["moneda"]):"";


switch ($_GET["op"]){
    //Registro de compras 
    case 'regcompras':

        $ano=$_GET['ano'];
        $mes=$_GET['mes'];
        $moneda=$_GET['moneda'];

        $rspta=$compra->regcompra($ano, $mes, $moneda);
        
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            
            $data[]=array(
                
                "0"=>$reg->fecha,
                "1"=>$reg->tipo_documento,
                "2"=>$reg->serie,
                "3"=>$reg->numero,
                "4"=>$reg->numero_documento,
                "5"=>$reg->razon_social,
                "6"=>$reg->subtotal,
                "7"=>$reg->igv,
                "8"=>$reg->total,
                );
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
    break;



    //Registro de ventas de facturas y boletas
    case 'regventas':

        $ano=$_GET['ano'];
        $mes=$_GET['mes'];
        $dia=$_GET['dia'];

        $rspta=$venta->regventa($ano, $mes, $dia);
        
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            if($reg->tipodocu=='01'){
                $url='../reportes/exFactura.php?id=';
            }else{
                $url='../reportes/exBoleta.php?id=';
            }

            
            $data[]=array(
                "0"=>$reg->fecha,
                "1"=>$reg->documento,
                "2"=>'<a target="_blank" href="'.$url.$reg->id.'"> <button class="btn btn-info" type="button"><i class="fa fa-file"> </i></button></a>',
                "3"=>$reg->subtotal,
                "4"=>$reg->igv,
                "5"=>$reg->total,
                "6"=>($reg->tipodocu=='01')?'<span class="label bg-green">Factura</span>':
                '<span class="label bg-orange ">Boleta</span>'
                );
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
    break;




    //Registro de ventas de facturas y boletas agrupado por dias
    case 'regvenagruxdia':

        $ano=$_GET['ano'];
        $mes=$_GET['mes'];
        
        $rspta=$venta->regventaagruxdia($ano, $mes);
        
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            
            $data[]=array(
                "0"=>$reg->fecha,
                "1"=>$reg->subtotal,
                "2"=>$reg->igv,
                "3"=>$reg->total
                );
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
    break;



   //============================================= 

    //Totales que van al final de la consulta 
    case 'totalregcompras':

        $ano=$_GET['ano'];
        $mes=$_GET['mes'];

        $rspta=$compra->totalregcompra($ano, $mes);

        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            
            $data[]=array(
                
                "0"=>$reg->valor_inafecto,
                "1"=>$reg->igv,
                "2"=>$reg->total,
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