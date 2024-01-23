<?php
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Compra.php";
require_once "../modelos/Venta.php";
require_once "../modelos/Articulo.php";
require_once "../modelos/Consultas.php";

$compra=new Compra();
$venta=new Venta();
$articulo=new Articulo();

$consulta=new Consultas();

$ano=isset($_POST["ano"])? limpiarCadena($_POST["ano"]):"";
$mes=isset($_POST["mes"])? limpiarCadena($_POST["mes"]):"";
$moneda=isset($_POST["moneda"])? limpiarCadena($_POST["moneda"]):"";



// $ano=isset($_POST["ano"])? limpiarCadena($_POST["ano"]):"";
// $codigo=isset($_POST["codigoInterno"])? limpiarCadena($_POST["codigoInterno"]):"";
// $fechas=isset($_POST["fechas"])? limpiarCadena($_POST["fechas"]):"";


switch ($_GET["op"]){

    // case 'guardaryeditar':
    // $rspta=$articulo->insertarkardexArticulo($ano, $codigo, $fechas);
    // break;

    //Registro de compras 
    case 'regcompras':

        $ano=$_GET['ano'];
        $mes=$_GET['mes'];
        $moneda=$_GET['moneda'];
        $idempresa=$_GET['idempresa'];


        $rspta=$compra->regcompra($ano, $mes, $moneda, $_SESSION['idempresa']);
        
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
        $ttmon=$_GET['tmon'];
        $idempresa=$_GET['idempresa'];

        $rspta=$venta->regventa($ano, $mes, $dia, $idempresa, $ttmon);
        
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            if($reg->tipodocu=='01'){
                $url='../reportes/exFactura.php?id=';
            }elseif ($reg->tipodocu=='03'){
                $url='../reportes/exBoleta.php?id=';
            }else{
                $url='../reportes/exNotapedido.php?id=';
            }

            
            $data[]=array(
                "0"=>$reg->fecha,
                "1"=>$reg->documento,
                //"2"=>'<a target="_blank" href="'.$url.$reg->id.'"> <i class="fa fa-file"> </i></a>',
                "2"=>$reg->subtotal,
                "3"=>$reg->igv,
                "4"=>$reg->total,
                "5"=>($reg->tipodocu=='01')?'<span class="label bg-green">Factura</span>'
                : (($reg->tipodocu=='03')?'<span class="label bg-orange">Boleta</span>'
                : '<span class="label bg-yellow">Nota de pedido</span>')
                
                );
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
    break;


    case 'regventasServicio':

        $ano=$_GET['ano'];
        $mes=$_GET['mes'];
        $dia=$_GET['dia'];
        $idempresa=$_GET['idempresa'];

        $rspta=$venta->regventa($ano, $mes, $dia, $idempresa);
        
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            if($reg->tipodocu=='01'){
                $url='../reportes/exFactura.php?id=';
            }elseif ($reg->tipodocu=='03'){
                $url='../reportes/exBoleta.php?id=';
            }else{
                $url='../reportes/exNotapedido.php?id=';
            }

            
            $data[]=array(
                "0"=>$reg->fecha,
                "1"=>$reg->documento,
                //"2"=>'<a target="_blank" href="'.$url.$reg->id.'"> <i class="fa fa-file"> </i></a>',
                "2"=>'',
                "3"=>$reg->subtotal,
                "4"=>$reg->igv,
                "5"=>$reg->total,
                "6"=>($reg->tipodocu=='01')?'<span class="label bg-green">Factura</span>'
                : (($reg->tipodocu=='03')?'<span class="label bg-orange">Boleta</span>'
                : '<span class="label bg-yellow">Nota de pedido</span>')
                
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
        $idempresa=$_GET['idempresa'];
        $tipomon=$_GET['tmn'];
        
        $rspta=$venta->regventaagruxdia($ano, $mes, $idempresa, $tipomon);
        
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








    


case 'consultakardexcodigo':

        $codigo=$_GET['cod'];
        $ano=$_GET['ano'];
        $xcodigot=$_GET['xct'];
        $almac=$_GET['aalml'];

        $tcompras=0;
        $tventas=0;
        //Comenzamos a crear las filas de los registros según la consulta mysql
        require_once "../modelos/Articulo.php";
        $articulo = new Articulo();
        $factorc=0;

            if ($xcodigot=='0') {
            $rsptano = $articulo->valoresiniciales($codigo);
            }else{
            $rsptano = $articulo->valoresinicialesTodos($ano);    
            }


while($regano= $rsptano->fetch_object())
{

//Para validar año 
if ($regano->anoarti==$ano) { //SI EL AÑO DE CONSULTA ES EL QUE SE PIDE

                if ($xcodigot=='0') {
                    $rspta8 = $articulo->obteneridarticulo($codigo);
                }else{
                    $rspta8 = $articulo->obteneridarticulotodos($ano);
                }

  

while($reg= $rspta8->fetch_object())
{ // inicio while id articulos
    $factorc=$reg->factorc;
    $idarticuloi=$reg->idarticulo;  
    $costoInicial=$reg->costo_compra;
    $saldoInicial=$reg->saldo_iniu;
    $valorInicial=$reg->valor_iniu;

  
    if ($xcodigot=='0') {
     $rspta2 = $articulo->kardexArticulo($ano, $codigo, $_SESSION['idempresa']);


            $saldoini=0;
            $saldofin=0;
            $saldofinal_v=0;
            $saldofin2=0; 
            $saldofin3=0; 
            $valorfin_p=0;
            $valorfin4=0;
            $saldofin4=0; 
            $saldofin5=0;
            $saldofinal_nc=0;
            $costo2=0;
            $costoi=0;
            $valori=0;
            $saldofinalglobal=0;

        $sw=0;

        while($reg= $rspta2->fetch_object())
        {  
            $fecha = $reg->fecha;
            $tipodoc=$reg->descripcion;
            $docum=$reg->numero_doc;
            $transac=$reg->transaccion;
            $tcambio=$reg->tcambio;
            $cantidad=$reg->cantidad;
            $idarticulo=$reg->idarticulo;
            $costoi=$reg->costo_compra;
            $idkardex=$reg->idkardex;
            $costoingreso=$reg->costo_1;
            $factorc=$reg->factorc;

    
if ($reg->moneda=='USD') {
            $costo1=($reg->costo_1 * 1.18) * $tcambio ;
             }else{ //SI MONEDA ES SOLES
            $costo1=$reg->costo_1;
            }
    $unimed=$reg->unidad_medida;
    $saldoini=$reg->saldo_iniu;
    $valorfinal=$reg->valor_iniu;
    $saldofinal=$reg->saldo_finu ;
    $totalventa=$reg->ventast;
    $valori=$reg->valor_iniu;


if ($transac=="COMPRA") {
    
            //Calculo para saldo final======================================
            $saldofin = $saldoini + $reg->cantidad + $saldofin2 + $saldofin5 - $saldofin4;
            //$saldofin = $saldofinal + $reg->cantidad  + $saldofin2 + $saldofin5 - $saldofin4;
            //Calculo para saldo final======================================
            //$costo2 = ($valorfinal + ($costo1 * $cantidad)) / ($saldoini + $cantidad + $saldofin3) ;
           if ($sw==0)
            {
            $costo2 = ($valorfinal + ($costoingreso * $cantidad)) / ($saldoini + $cantidad + $saldofin3); //SI ES EL PRIMER 
            //REGISTRO DE LA CONSULTA
            }
            else
            {
            $costo2 = ($vf + ($costoingreso * $cantidad)) / ($saldofinal_v + $cantidad + $saldofin3) ;
            }

            //Calculo para Valor final======================================
            $valorfin_p=$saldofin * number_format($costo2,2) ;
            //Calculo para Valor final======================================
            $saldofin2 = $saldofin2 + $reg->cantidad;
            $vf = $valorfin_p;
            $saldofin3 = $saldofin3 + $reg->cantidad;
            $sw=$sw + 1;
            $saldofinalglobal=$saldofin;
            $tcompras = $tcompras + $reg->cantidad;


   }else if ($transac=="VENTA"){

            $articulo->Updatecosto2($idkardex, $costoi);
            if ($saldofinalglobal==0)
            { 
                $saldofinalglobal=$reg->saldo_iniu;
            }
            //Calculo para saldo final======================================
            $saldofinal_v = $saldofinalglobal - $reg->cantidad;// - $saldofin4 ;
            //Calculo para saldo final======================================
            if ($sw==0)
            {
            $costo2=$reg->costo_compra;
            }else{
            $costo2=$costo2;
            }
            //Calculo para Valor final======================================
            $valorfin_p = $saldofinal_v * number_format($costo2,2) ;
            //Calculo para Valor final======================================
            $vf= $valorfin_p;
            $saldofin4= $saldofin4 + $reg->cantidad;
            $sw=$sw + 1;
            $saldofin3=0;

            $saldofinalglobal= $saldofinal_v ;
            $tventas = $tventas + $reg->cantidad;


    }else if ($transac=="O.SERVI.") {
            $articulo->Updatecosto2($idkardex, $costoi);
            if ($saldofinalglobal==0) { $saldofinalglobal=$reg->saldo_iniu; }
            //Calculo para saldo final======================================
            $saldofinal_v = $saldofinalglobal - $reg->cantidad;// - $saldofin4 ;
            //Calculo para costo 2======================================
            if ($costo2==0){$costo2=$reg->costo_compra;}else{
            $costo2=$costo2;
            }
            //Calculo para costo 2======================================
            //Calculo para Valor final======================================
            $valorfin_p = $saldofinal_v * number_format($costo2,2) ;
            //Calculo para Valor final======================================
            $vf= $valorfin_p;
            $saldofin4= $saldofin4 + $reg->cantidad;
            $sw=$sw + 1;
            $saldofinalglobal= $saldofinal_v;

//====================================================================================

    }else if ($transac=="NOTAC" || $transac=="ANULADO" ) {
            $articulo->Updatecosto2($idkardex, $costoi);
            //Calculo para saldo final======================================
            $saldofinal_nc = $saldofinalglobal + $reg->cantidad;// + $saldofin5 ;
            //Calculo para saldo final======================================
            //Calculo para costo 2======================================
            $costo2 = $costo2;
            //Calculo para costo 2======================================
            //Calculo para Valor final======================================
            $valorfin_p = $saldofinal_nc * number_format($costo2,2) ;
            //Calculo para Valor final======================================
            $saldofin5 = $saldofin5 + $reg->cantidad;
            $saldofinalglobal= $saldofinal_nc;
            $tventas = $tventas - $reg->cantidad;


    }else if ($transac=="COMPRA ANULADA"){
            if ($saldofinalglobal==0) { $saldofinalglobal=$reg->saldo_iniu; }
            //Calculo para saldo final======================================
            $saldofinal_v = $saldofinalglobal  - $reg->cantidad;// - $saldofin4 ;
            //$saldofin4 =  $saldofin4 + $reg->cantidad;
            //Calculo para saldo final======================================
            //Calculo para costo 2======================================
            if ($costo2==0){$costo2=$reg->costo_compra;}else{
            $costo2=$costo2;}
          
            //Calculo para costo 2======================================
            //Calculo para Valor final======================================
            $valorfin_p = $saldofinal_v * number_format($costo2,2) ;
            //Calculo para Valor final======================================
            $vf= $valorfin_p;
            $saldofin4= $saldofin4 + $reg->cantidad;
              $sw=$sw + 1;
            $saldofinalglobal= $saldofinal_v ;

    }else if ($transac=="DEV COMPRA" ) {
            $articulo->Updatecosto2($idkardex, $costoi);
            //Calculo para saldo final======================================
            $saldofinal_nc = $saldofinalglobal - $reg->cantidad;// + $saldofin5 ;
            //Calculo para saldo final======================================
            //Calculo para costo 2======================================
            $costo2 = $costo2;
            //Calculo para costo 2======================================
            //Calculo para Valor final======================================
            $valorfin_p = $saldofinal_nc * number_format($costo2,2) ;
            //Calculo para Valor final======================================
            $saldofin5 = $saldofin5 - $reg->cantidad;
            $saldofinalglobal= $saldofinal_nc;
            $tcompras = $tcompras - $reg->cantidad;

         }
    } // Fin while


         if ($tcompras!=0 || $tventas!=0) {
        $articulo->insertarkardexArticulo($_SESSION['idempresa'], $idarticulo, $codigo, $ano, $costoInicial, $saldoInicial, $valorInicial, $costo2, $saldofinalglobal, $valorfin_p, $tcompras, $tventas );

        }elseif ($tcompras==0 && $tventas==0){

            $rptaidarti=$articulo->consultaridarticulo($codigo);

        while ($regidart=$rptaidarti->fetch_object()) {
            $idarticulo= $regidart->idarticulo;

                $saldofinalglobal=$saldoInicial;
                $costo2=$costoInicial;
                $valorfin_p=$valorInicial;
                 }

             
            $articulo->insertarkardexArticulo($_SESSION['idempresa'], $idarticulo, $codigo , $ano, $costoInicial, $saldoInicial, $valorInicial, $costoInicial, $saldoInicial, $valorInicial, $tcompras, $tventas );
            }


                }else{ //============================TODOS LOS ARTICULOS =================================

    $tcompras=0;
    $ventas= 0;
    $rspta2 = $articulo->kardexArticulotodos($ano, $_SESSION['idempresa'], $almac);

        $saldoini=0;
        $saldofin=0;
        $saldofinal_v=0;
        $saldofin2=0; 
        $saldofin3=0; 
        $valorfin_p=0;
        $valorfin4=0;
        $saldofin4=0; 
        $saldofin5=0;
        $saldofinal_nc=0;
        $costo2=0;
        $costoi=0;
        $valori=0;
        $saldofinalglobal=0;
        $cantidad=0;

$sw=0;

while($reg= $rspta2->fetch_object())
{  
    //for($i=0; $i <= count($rspta2); $i++)
    //{
    
    $fecha = $reg->fecha;
    $tipodoc=$reg->descripcion;
    $docum=$reg->numero_doc;
    $transac=$reg->transaccion;
    $tcambio=$reg->tcambio;
    $cantidad=$reg->cantidad;
    $idarticulok=$reg->idarticulo;
    $costoi=$reg->costo_compra;
    $idkardex=$reg->idkardex;
    $costoingreso=$reg->costo_1;
    $factorc=$reg->factorc;

    $codigodkardex=$reg->codigodkardex;


                if ($reg->moneda=='USD') {
                            $costo1=($reg->costo_1 * 1.18) * $tcambio ;
                             }else{ //SI MONEDA ES SOLES
                            $costo1=$reg->costo_1;
                            }
                    $unimed=$reg->unidad_medida;
                    $saldoini=$reg->saldo_iniu;
                    $valorfinal=$reg->valor_iniu;
                    $saldofinal=$reg->saldo_finu ;
                    $totalventa=$reg->ventast;
                    $valori=$reg->valor_iniu;


                if ($transac=="COMPRA") {
                    
                            //Calculo para saldo final======================================
                            $saldofin = $saldoini + $reg->cantidad + $saldofin2 + $saldofin5 - $saldofin4;
                            //$saldofin = $saldofinal + $reg->cantidad  + $saldofin2 + $saldofin5 - $saldofin4;
                            //Calculo para saldo final======================================
                            //$costo2 = ($valorfinal + ($costo1 * $cantidad)) / ($saldoini + $cantidad + $saldofin3) ;
                           if ($sw==0)
                            {
                            $costo2 = ($valorfinal + ($costoingreso * $cantidad)) / ($saldoini + $cantidad + $saldofin3); //SI ES EL PRIMER 
                            //REGISTRO DE LA CONSULTA
                            }
                            else
                            {
                            $costo2 = ($vf + ($costoingreso * $cantidad)) / ($saldofinal_v + $cantidad + $saldofin3) ;
                            }

                            //Calculo para Valor final======================================
                            $valorfin_p=$saldofin * number_format($costo2,2) ;
                            //Calculo para Valor final======================================
                            $saldofin2 = $saldofin2 + $reg->cantidad;
                            $vf = $valorfin_p;
                            $saldofin3 = $saldofin3 + $reg->cantidad;
                            $sw=$sw + 1;
                            $saldofinalglobal=$saldofin;
                            $tcompras = $tcompras + $reg->cantidad;

                    $articulo->insertarkardexArticulo(
                    $_SESSION['idempresa'], 
                    $idarticuloi, 
                    $codigodkardex, 
                    $ano, 
                    $costoInicial, 
                    $saldoInicial, 
                    $valorInicial, 
                    $costo2, 
                    $saldofinalglobal, 
                    $valorfin_p, 
                    $tcompras,
                    '0'); 


                   }else if ($transac=="VENTA"){

                            $articulo->Updatecosto2($idkardex, $costoi);
                            if ($saldofinalglobal==0)
                            { 
                                $saldofinalglobal=$reg->saldo_iniu;
                            }
                            //Calculo para saldo final======================================
                            $saldofinal_v = $saldofinalglobal - $reg->cantidad;// - $saldofin4 ;
                            //Calculo para saldo final======================================
                            if ($sw==0)
                            {
                            $costo2=$reg->costo_compra;
                            }else{
                            $costo2=$costo2;
                            }
                            //Calculo para Valor final======================================
                            $valorfin_p = $saldofinal_v * number_format($costo2,2) ;
                            //Calculo para Valor final======================================
                            $vf= $valorfin_p;
                            $saldofin4= $saldofin4 + $reg->cantidad;
                            $sw=$sw + 1;
                            $saldofin3=0;

                            for($i=0; $i <= count($rspta2); $i++)
                            {

                            $saldofinalglobal= $saldofinal_v ;
                            $tventas=$tventas + $cantidad;
                            }

                    $articulo->insertarkardexArticulo(
                    $_SESSION['idempresa'], 
                    $idarticuloi, 
                    $codigodkardex, 
                    $ano, 
                    $costoInicial, 
                    $saldoInicial, 
                    $valorInicial, 
                    $costo2, 
                    $saldofinalglobal, 
                    $valorfin_p, 
                    '0',
                    $tventas); 

                   


                    }else if ($transac=="O.SERVI.") {
                            $articulo->Updatecosto2($idkardex, $costoi);
                            if ($saldofinalglobal==0) { $saldofinalglobal=$reg->saldo_iniu; }
                            //Calculo para saldo final======================================
                            $saldofinal_v = $saldofinalglobal - $reg->cantidad;// - $saldofin4 ;
                            //Calculo para costo 2======================================
                            if ($costo2==0){$costo2=$reg->costo_compra;}else{
                            $costo2=$costo2;
                            }
                            //Calculo para costo 2======================================
                            //Calculo para Valor final======================================
                            $valorfin_p = $saldofinal_v * number_format($costo2,2) ;
                            //Calculo para Valor final======================================
                            $vf= $valorfin_p;
                            $saldofin4= $saldofin4 + $reg->cantidad;
                            $sw=$sw + 1;
                            $saldofinalglobal= $saldofinal_v;

                //====================================================================================

                    }else if ($transac=="NOTAC" || $transac=="ANULADO" ) {
                            $articulo->Updatecosto2($idkardex, $costoi);
                            //Calculo para saldo final======================================
                            $saldofinal_nc = $saldofinalglobal + $reg->cantidad;// + $saldofin5 ;
                            //Calculo para saldo final======================================
                            //Calculo para costo 2======================================
                            $costo2 = $costo2;
                            //Calculo para costo 2======================================
                            //Calculo para Valor final======================================
                            $valorfin_p = $saldofinal_nc * number_format($costo2,2) ;
                            //Calculo para Valor final======================================
                            $saldofin5 = $saldofin5 + $reg->cantidad;
                            $saldofinalglobal= $saldofinal_nc;
                            $tventas = $tventas - $reg->cantidad;


                    }else if ($transac=="COMPRA ANULADA"){
                            if ($saldofinalglobal==0) { $saldofinalglobal=$reg->saldo_iniu; }
                            //Calculo para saldo final======================================
                            $saldofinal_v = $saldofinalglobal  - $reg->cantidad;// - $saldofin4 ;
                            //$saldofin4 =  $saldofin4 + $reg->cantidad;
                            //Calculo para saldo final======================================
                            //Calculo para costo 2======================================
                            if ($costo2==0){$costo2=$reg->costo_compra;}else{
                            $costo2=$costo2;}
                          
                            //Calculo para costo 2======================================
                            //Calculo para Valor final======================================
                            $valorfin_p = $saldofinal_v * number_format($costo2,2) ;
                            //Calculo para Valor final======================================
                            $vf= $valorfin_p;
                            $saldofin4= $saldofin4 + $reg->cantidad;
                              $sw=$sw + 1;
                            $saldofinalglobal= $saldofinal_v ;

                    }else if ($transac=="DEV COMPRA" ) {
                            $articulo->Updatecosto2($idkardex, $costoi);
                            //Calculo para saldo final======================================
                            $saldofinal_nc = $saldofinalglobal - $reg->cantidad;// + $saldofin5 ;
                            //Calculo para saldo final======================================
                            //Calculo para costo 2======================================
                            $costo2 = $costo2;
                            //Calculo para costo 2======================================
                            //Calculo para Valor final======================================
                            $valorfin_p = $saldofinal_nc * number_format($costo2,2) ;
                            //Calculo para Valor final======================================
                            $saldofin5 = $saldofin5 - $reg->cantidad;
                            $saldofinalglobal= $saldofinal_nc;
                            $tcompras = $tcompras - $reg->cantidad;

                         }

        //}//Fin FOR
                   

  
   } // Fin while

 

      
            
  } //Fin if 


} //Fin while  id articulos


    





 }else{ //SI EL AÑO ES DIFERENTE =============================================





$saldoini=0;
$saldofin=0;
$saldofinal_v=0;
$saldofin2=0; 
$saldofin3=0; 
$valorfin_p=0;
$valorfin4=0;
$saldofin4=0; 
$saldofin5=0;
$saldofinal_nc=0;
$costo2=0;
$idarticulo='';
$costoi=0;
$valori=0;
$saldofinalglobal=0;
$idkardex=0;
$sw=0;




if ($xcodigot=='0') {
$saldoant = $articulo->saldoanterior($ano,$codigo, '1');
}else{
$saldoant = $articulo->saldoanteriorTodos($ano, '1'); 
}

while($reg= $saldoant->fetch_object())
{  
    $costoanterior = $reg->costof;
    $saldoInicial=$reg->saldof;
    $valorInicial=$reg->valorf;
    $valorFinal2=$reg->valorf;
} 


//=====================================================================
if ($xcodigot=='0') {
$rspta2 = $articulo->kardexArticulo($ano,$codigo, '1');
while($reg= $rspta2->fetch_object())
{  
    $fecha = $reg->fecha;
    $tipodoc=$reg->descripcion;
    $docum=$reg->numero_doc;
    $transac=$reg->transaccion;
    $tcambio=$reg->tcambio;
    $cantidad=$reg->cantidad;
    $idarticulo=$reg->idarticulo;
    $costoi=$reg->costo_compra;
    $idkardex=$reg->idkardex;
    $costoingreso=$reg->costo_1;

     if ($reg->moneda=='USD') {
            $costoanterior=($costoanterior * 1.18) * $tcambio ;
             }else{
            $costoanterior=$costoanterior;
        }
        $unimed=$reg->unidad_medida;
        //$saldoini=$reg->saldo_iniu;
        $valorfinal=$reg->valor_iniu;
        $saldofinal=$reg->saldo_finu;
        $totalventa=$reg->ventast;
        //$valori=$reg->valor_iniu;
    
if ($transac=="COMPRA") {
                //Calculo para saldo final======================================
                $saldofin = $saldoInicial + $reg->cantidad  + $saldofin2 + $saldofin5 - $saldofin4;
                //Calculo para saldo final======================================
                //Calculo para costo 2======================================
                //VALFIN+(COSTO*CANTI))/(SALINI+CANTI)
                if ($sw==0){
                $costo2 = ($valorFinal2 + ($costoingreso * $cantidad)) / ($saldoInicial + $cantidad + $saldofin3);
                }
                else
                {
                $costo2 = ($vf + ($costoingreso * $cantidad)) / ($saldofinal_v + $cantidad + $saldofin3);
                }
                
                $valorfin_p=$saldofin * number_format($costo2,2) ;
                $saldofin2 = $saldofin2 + $reg->cantidad;
                $vf = $valorfin_p;
                $saldofin3 = $saldofin3 + $reg->cantidad;
                $sw=$sw + 1;
                $saldofinalglobal=$saldofin;
                $tcompras = $tcompras + $reg->cantidad;
//==================================================================================

   }else if ($transac=="VENTA") {
            $articulo->Updatecosto2($idkardex, $costoi);
            if ($saldofinalglobal==0) { $saldofinalglobal=$saldoInicial; }
            $saldofinal_v = $saldofinalglobal  - $reg->cantidad;// - $saldofin4 ;
            
                if ($sw==0)
                {
                    $costo2=$costoanterior;
                }else{
                    $costo2=$costo2;
                }

            $valorfin_p = $saldofinal_v * number_format($costo2,2) ;
            $vf= $valorfin_p;
            $saldofin4= $saldofin4 + $reg->cantidad;
            $sw=$sw + 1;
            $saldofinalglobal= $saldofinal_v;
            $saldofin3=0;
            $tventas = $tventas + $reg->cantidad;

}else if ($transac=="O.SERVI.") {
            $articulo->Updatecosto2($idkardex, $costoi);
            if ($saldofinalglobal==0) { $saldofinalglobal=$saldoInicial; }
            //Calculo para saldo final======================================
            $saldofinal_v = $saldofinalglobal - $reg->cantidad;// - $saldofin4 ;
            //Calculo para costo 2======================================
            if ($costo2==0){$costo2=$reg->costo_compra;}else{
            $costo2=$costo2;
            }
            //Calculo para costo 2======================================
            //Calculo para Valor final======================================
            $valorfin_p = $saldofinal_v * $costo2 ;
            //Calculo para Valor final======================================
            $vf= $valorfin_p;
            $saldofin4= $saldofin4 + $reg->cantidad;
            $sw=$sw + 1;
            $saldofinalglobal= $saldofinal_v ;

        //====================================================================================
    }else if ($transac=="NOTAC" || $transac=="ANULADO" ) {
            $articulo->Updatecosto2($idkardex, $costoi);
            //Calculo para saldo final======================================
            $saldofinal_nc = $saldofinalglobal + $reg->cantidad;// + $saldofin5 ;
            //Calculo para saldo final======================================
            //Calculo para costo 2======================================
            $costo2 = $costo2;
            //Calculo para costo 2======================================
            //Calculo para Valor final======================================
            $valorfin_p = $saldofinal_nc * number_format($costo2,2) ;
            //Calculo para Valor final======================================
            $saldofin5 = $saldofin5 + $reg->cantidad;
            $saldofinalglobal= $saldofinal_nc;
            $tventas = $tventas - $reg->cantidad;

    }else if ($transac=="COMPRA ANULADA"){
if ($saldofinalglobal==0) { $saldofinalglobal=$saldoInicial; }
        //Calculo para saldo final======================================
        $saldofinal_v = $saldofinalglobal  - $reg->cantidad;// - $saldofin4 ;
        //Calculo para saldo final======================================
        //Calculo para costo 2======================================
        if ($costo2==0){$costo2=$reg->costo_compra;}else{
        $costo2=$costo2;
        }
        //Calculo para costo 2======================================
        //Calculo para Valor final======================================
        $valorfin_p = $saldofinal_v * $costo2 ;
        //Calculo para Valor final======================================
        $vf= $valorfin_p;
        $saldofin4= $saldofin4 + $reg->cantidad;
          $sw=$sw + 1;
        $saldofinalglobal= $saldofinal_v;

        }else if ($transac=="DEV COMPRA" ) {
        $articulo->Updatecosto2($idkardex, $costoi);
        //Calculo para saldo final======================================
        $saldofinal_nc = $saldofinalglobal - $reg->cantidad;// + $saldofin5 ;
        //Calculo para saldo final======================================
        //Calculo para costo 2======================================
        $costo2 = $costo2;
        //Calculo para costo 2======================================
        //Calculo para Valor final======================================
        $valorfin_p = $saldofinal_nc * number_format($costo2,2) ;
        //Calculo para Valor final======================================
        $saldofin5 = $saldofin5 - $reg->cantidad;
        $saldofinalglobal= $saldofinal_nc;
        $tcompras = $tcompras - $reg->cantidad;


         if($idarticulo==""){
        $rptaidarti=$articulo->consultaridarticulo($codigo);
        while ($regidart=$rptaidarti->fetch_object()) {
            $idarticulo= $regidart->idarticulo;

            $saldofinalglobal=$saldoInicial;
            $costo2=$costoanterior;
            $valorfin_p=$valorFinal2;
                }
                            }   

    


         }


} // Fin while

$articulo->insertarkardexArticulo($_SESSION['idempresa'], $idarticulo, $codigo , $ano, $costoanterior, $saldoInicial, $valorInicial, $costo2, $saldofinalglobal, $valorfin_p, $tcompras, $tventas);

}else{ // ===============================================



    $rspta2 = $articulo->kardexArticulotodosotroano($ano, '1');
while($reg= $rspta2->fetch_object())
{  
    $fecha = $reg->fecha;
    $tipodoc=$reg->descripcion;
    $docum=$reg->numero_doc;
    $transac=$reg->transaccion;
    $tcambio=$reg->tcambio;
    $cantidad=$reg->cantidad;
    $idarticulok=$reg->idarticulo;
    $costoi=$reg->costo_compra;
    $idkardex=$reg->idkardex;
    $costoingreso=$reg->costo_1;

    $codigodkardex=$reg->codigodkardex;

     if ($reg->moneda=='USD') {
            $costoanterior=($costoanterior * 1.18) * $tcambio ;
             }else{
            $costoanterior=$costoanterior;
        }
        $unimed=$reg->unidad_medida;
        //$saldoini=$reg->saldo_iniu;
        $valorfinal=$reg->valor_iniu;
        $saldofinal=$reg->saldo_finu;
        $totalventa=$reg->ventast;
        //$valori=$reg->valor_iniu;
    
if ($transac=="COMPRA") {
                //Calculo para saldo final======================================
                $saldofin = $saldoInicial + $reg->cantidad  + $saldofin2 + $saldofin5 - $saldofin4;
                //Calculo para saldo final======================================
                //Calculo para costo 2======================================
                //VALFIN+(COSTO*CANTI))/(SALINI+CANTI)
                if ($sw==0){
                $costo2 = ($valorFinal2 + ($costoingreso * $cantidad)) / ($saldoInicial + $cantidad + $saldofin3);
                }
                else
                {
                $costo2 = ($vf + ($costoingreso * $cantidad)) / ($saldofinal_v + $cantidad + $saldofin3);
                }
                
                $valorfin_p=$saldofin * number_format($costo2,2) ;
                $saldofin2 = $saldofin2 + $reg->cantidad;
                $vf = $valorfin_p;
                $saldofin3 = $saldofin3 + $reg->cantidad;
                $sw=$sw + 1;
                $saldofinalglobal=$saldofin;
                $tcompras = $tcompras + $reg->cantidad;
//==================================================================================

   }else if ($transac=="VENTA") {
            $articulo->Updatecosto2($idkardex, $costoi);
            if ($saldofinalglobal==0) { $saldofinalglobal=$saldoInicial; }
            $saldofinal_v = $saldofinalglobal  - $reg->cantidad;// - $saldofin4 ;
            
                if ($sw==0)
                {
                    $costo2=$costoanterior;
                }else{
                    $costo2=$costo2;
                }

            $valorfin_p = $saldofinal_v * number_format($costo2,2) ;
            $vf= $valorfin_p;
            $saldofin4= $saldofin4 + $reg->cantidad;
            $sw=$sw + 1;
            $saldofinalglobal= $saldofinal_v;
            $saldofin3=0;
            $tventas = $tventas + $reg->cantidad;

}else if ($transac=="O.SERVI.") {
            $articulo->Updatecosto2($idkardex, $costoi);
            if ($saldofinalglobal==0) { $saldofinalglobal=$saldoInicial; }
            //Calculo para saldo final======================================
            $saldofinal_v = $saldofinalglobal - $reg->cantidad;// - $saldofin4 ;
            //Calculo para costo 2======================================
            if ($costo2==0){$costo2=$reg->costo_compra;}else{
            $costo2=$costo2;
            }
            //Calculo para costo 2======================================
            //Calculo para Valor final======================================
            $valorfin_p = $saldofinal_v * $costo2 ;
            //Calculo para Valor final======================================
            $vf= $valorfin_p;
            $saldofin4= $saldofin4 + $reg->cantidad;
            $sw=$sw + 1;
            $saldofinalglobal= $saldofinal_v ;

        //====================================================================================
    }else if ($transac=="NOTAC" || $transac=="ANULADO" ) {
            $articulo->Updatecosto2($idkardex, $costoi);
            //Calculo para saldo final======================================
            $saldofinal_nc = $saldofinalglobal + $reg->cantidad;// + $saldofin5 ;
            //Calculo para saldo final======================================
            //Calculo para costo 2======================================
            $costo2 = $costo2;
            //Calculo para costo 2======================================
            //Calculo para Valor final======================================
            $valorfin_p = $saldofinal_nc * number_format($costo2,2) ;
            //Calculo para Valor final======================================
            $saldofin5 = $saldofin5 + $reg->cantidad;
            $saldofinalglobal= $saldofinal_nc;
            $tventas = $tventas - $reg->cantidad;

    }else if ($transac=="COMPRA ANULADA"){
if ($saldofinalglobal==0) { $saldofinalglobal=$saldoInicial; }
        //Calculo para saldo final======================================
        $saldofinal_v = $saldofinalglobal  - $reg->cantidad;// - $saldofin4 ;
        //Calculo para saldo final======================================
        //Calculo para costo 2======================================
        if ($costo2==0){$costo2=$reg->costo_compra;}else{
        $costo2=$costo2;
        }
        //Calculo para costo 2======================================
        //Calculo para Valor final======================================
        $valorfin_p = $saldofinal_v * $costo2 ;
        //Calculo para Valor final======================================
        $vf= $valorfin_p;
        $saldofin4= $saldofin4 + $reg->cantidad;
          $sw=$sw + 1;
        $saldofinalglobal= $saldofinal_v;

        }else if ($transac=="DEV COMPRA" ) {
        $articulo->Updatecosto2($idkardex, $costoi);
        //Calculo para saldo final======================================
        $saldofinal_nc = $saldofinalglobal - $reg->cantidad;// + $saldofin5 ;
        //Calculo para saldo final======================================
        //Calculo para costo 2======================================
        $costo2 = $costo2;
        //Calculo para costo 2======================================
        //Calculo para Valor final======================================
        $valorfin_p = $saldofinal_nc * number_format($costo2,2) ;
        //Calculo para Valor final======================================
        $saldofin5 = $saldofin5 - $reg->cantidad;
        $saldofinalglobal= $saldofinal_nc;
        $tcompras = $tcompras - $reg->cantidad;


         if($idarticulo==""){
    $rptaidarti=$articulo->consultaridarticulo($codigo);
        while ($regidart=$rptaidarti->fetch_object()) {
            $idarticulo= $regidart->idarticulo;

            $saldofinalglobal=$saldoInicial;
            $costo2=$costoanterior;
            $valorfin_p=$valorFinal2;
        }
    }   

    }

    $articulo->insertarkardexArticulo($_SESSION['idempresa'], $idarticulok, $codigodkardex , $ano, $costoanterior, $saldoInicial, $valorInicial, $costo2, $saldofinalglobal, $valorfin_p, $tcompras, $tventas);
} // Fin while






} // fin de condicuonal 0






} //FIN DE IF


}







 $rspta50=$articulo->kardexxarticulo($xcodigot, $ano, $codigo);
 //Vamos a declarar un array
 $data= Array();
 while ($reg22=$rspta50->fetch_object()){
            
            $data[]=array(
                "0"=>$reg22->codigoart,
                "1"=>$reg22->nombre,
                "2"=>$reg22->ano,
                "3"=>$reg22->costoi,
                "4"=>$reg22->saldoi,
                "5"=>$reg22->valori,
                "6"=>$reg22->costof,
                "7"=>$reg22->saldof,
                "8"=>$reg22->valorf,
                "9"=>$reg22->tcompras,
                "10"=>$reg22->tventas,
        "11"=>'<a target="_blank" 
        href="../reportes/kardexarticuloxcodigo.php?codigoI='.$reg22->codigoart.'&anoo='.$reg22->ano.'">
                <i class="fa  fa-print"> </i>
                   </a>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);






    break;













 case 'resetearvalores':

        $codigo=$_GET['cod'];
        $ano=$_GET['ano'];
        $rspta=$articulo->resetearvalores($codigo, $ano);
        
        //Vamos a declarar un array
        $data= Array();
        $reg="";
        // while ($reg=$rspta->fetch_object()){
            
        //     if (($reg=="")) {
        //         $data[]="";
                
        //     }else{

        //     $data[]=array(
        //         "0"=>$reg->codigo,
        //         "1"=>$reg->nombre,
        //         "2"=>$reg->ano,
        //         "3"=>$reg->costoi,
        //         "4"=>$reg->saldoi,
        //         "5"=>$reg->valori,
        //         "6"=>$reg->costof,
        //         "7"=>$reg->saldof,
        //         "8"=>$reg->valorf
        //         );
        //     }
        // }

        $results = array(
            "sEcho"=>0, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
    break;


 case 'resetearvaloresTodos':
     $rspta=$articulo->resetearvaloresTodos();
        //Vamos a declarar un array
        $data= Array();
        $reg="";

        $results = array(
            "sEcho"=>0, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;




    case 'descargarcomprobante':
        $ano=$_GET['ano'];
        $mes=$_GET['mes'];
        $dia=$_GET['dia'];
        $comprobante=$_GET['comprobante'];
        $estado=$_GET['estado'];
        $rspta=$consulta->descargarcomprobante($ano, $mes, $dia, $comprobante, $estado, $_SESSION['idempresa']);
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
                "2"=>'<a target="_blank" href="'.$url.$reg->id.'"> <i class="fa fa-file"> </i></a>',
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


    case "selectUnidadum1":
        require_once "../modelos/Almacen.php";
        $almacen=new Almacen();
        $codigoart = $_GET['codaum1'];
        $rspta=$almacen->selectunidadxarticuloum1($codigoart);
        echo json_encode($rspta);
        break;


    case "selectUnidadum2":
        require_once "../modelos/Almacen.php";
        $almacen=new Almacen();
        $codigoart = $_GET['codaum2'];
        $rspta=$almacen->selectunidadxarticuloum2($codigoart);
        echo json_encode($rspta);
        break;


    case "selectAlm":
        require_once "../modelos/Almacen.php";
        $almacen=new Almacen();
        
        $rspta = $almacen->almacenlista();
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idalmacen . '>' . $reg->nombre . '</option>';
                }
        break;



         case 'totalpordiames':
        $ano=$_GET['ano'];
        $mes=$_GET['mes'];
        $moneda=$_GET['mmon'];

        $data= Array();
        $rspta = $consulta->totalpordia($ano, $mes, $moneda);
        while ($reg=$rspta->fetch_object()){
              $data[]=array(
                "0"=>$reg->total,
                "1"=>$reg->dia,
                "2"=>$reg->nombredia
                );

          }

            $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
        break;


        case 'totalpordiamesnotaped':
        $ano=$_GET['ano'];
        $mes=$_GET['mes'];


        $data= Array();
        $rspta = $consulta->totalpordianotapedido($ano, $mes);
        while ($reg=$rspta->fetch_object()){
              $data[]=array(
                "0"=>$reg->total,
                "1"=>$reg->dia,
                "2"=>$reg->nombredia
                );

          }

            $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
        break;


        case 'totalmesfactura':
        $ano=$_GET['ano'];
        $mes=$_GET['mes'];
        $moneda=$_GET['mmon'];

        $data= Array();
        $rspta = $consulta->totalmesfactura($ano, $mes, $moneda);
        while ($reg=$rspta->fetch_object()){
              $data[]=array(
                "0"=>$reg->totalfactura,
                "1"=>$reg->dia,
                "2"=>$reg->nombredia
                );

          }

            $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
        break;



         case 'totalmesboleta':
        $ano=$_GET['ano'];
        $mes=$_GET['mes'];
        $moneda=$_GET['mmon'];

        $data= Array();
        $rspta = $consulta->totalmesboleta($ano, $mes, $moneda);
        while ($reg=$rspta->fetch_object()){
              $data[]=array(
                "0"=>$reg->totalboleta,
                "1"=>$reg->dia,
                "2"=>$reg->nombredia
                );

          }

            $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
        break;


        case 'kardexporfechas':

        $fecha1=$_GET['f1'];
        $fecha2=$_GET['f2'];
        $vvV=$_GET['Opc'];
        $xxC=$_GET['xcd'];

        $saldoInicial="";
        $costoanterior="";
        $valorFinal2 ="";
        $valorInicial="";
        $idarticulo="";

        $tcompras=0;
        $tventas=0;

        $saldoini=0;
        $saldofin=0;
        $saldofinal_v=0;
        $saldofin2=0; 
        $saldofin3=0; 
        $valorfin_p=0;
        $valorfin4=0;
        $saldofin4=0; 
        $saldofin5=0;
        $saldofinal_nc=0;
        $costo2=0;
        $costoi=0;
        $costok=0;
        $valori=0;
        $saldofinalglobal=0;

            $idarticulok="";
            $idartikar="";
            $codigo="";
            $costoInicial=0;
            $saldoInicial=0;
            $valorInicial=0;

            $codigoalt="";
            $costoingreso=0;
            $aniIAn=0;

            
         $sw=0;

        require_once "../modelos/Articulo.php";
        $articulo = new Articulo();

    
        $datos=array(); //Array de lista


        $anoreg = $articulo->anoregistroarti($xxC);
        while($reganore= $anoreg->fetch_object())
            {
                $anoregart=$reganore->anorega;
            }


        $rspta2 = $articulo->kardexArticuloxfechasVentas($fecha1, $fecha2, $vvV, $xxC);
        while($reg= $rspta2->fetch_object())
            {

                        
                        $transac=$reg->transaccion;
                        $tcambio=$reg->tcambio;
                        $cantidad=$reg->cantidad;
                        $idkardex=$reg->idkardex;

                        $codigo=$reg->codigo;
                        $ano=$reg->ano;
                        $costok=$reg->costo_1;

                        if ($anoregart==$ano) {
                            $anosel=$ano;
                        }else{
                            $anosel=$ano - 1;
                        }
                        
                       
//============== para tabla de inventario guardada ==============================
         $rspta3 = $articulo->valoresinicialesInventario($anosel, $codigo);
        while($reg2= $rspta3->fetch_object())
            {

    //$saldoInicial=$reg2->saldoinicial;
    $saldoInicial=$reg2->saldofinal;
    $saldofinal=$reg2->saldofinal;
    $totalventa=$reg2->ventas;
    $valorInicial=$reg2->valorinicial;
    //$costoInicial=$reg2->costoinicial;
    $costoInicial=$reg2->costo;
    
       if ($transac=="VENTA") {
            //==================================================================================

       if ($saldofinalglobal==0) { $saldofinalglobal=$saldoInicial; }
    //Calculo para saldo final======================================
    $saldofinal_v = $saldofinalglobal  - $cantidad;// - $saldofin4 ;
    //Calculo para Valor final======================================
     if ($costo2==0)
        {
            $costo2=$costoInicial;
        }else{
            $costo2=$costo2;
        }

    $valorfin_p = $saldofinal_v * number_format($costo2,2) ;
    //Calculo para Valor final======================================
    $vf= $valorfin_p;
    $saldofin4= $saldofin4 + $cantidad;
    $tventas=$tventas + $cantidad;


            
        if ($tventas!=0) {
        $articulo->insertarkardexArticulo('1', '', $codigo, $ano, $costoInicial, $saldoInicial, $valorInicial, $costo2, $saldofinal_v, $valorfin_p, '', $tventas, $transac );
        }elseif ($tcompras==0 && $tventas==0){
            // $articulo->insertarkardexArticulo('1', $idarticulo, $codigo , $ano, $costoInicial, $saldoInicial, $valorInicial, $costoInicial, $saldoInicial, $valorInicial, '0', $tventas );
        }  


         $sw=$sw + 1;
         $saldofinalglobal= $saldofinal_v;
         $saldofin3=0;

            
            }else if ($transac=="COMPRA") {
                
     $rspta4 = $articulo->kArtxfechasCompras($fecha1, $fecha2, $codigo);
    //Calculo para costo 2======================================
     $saldofin = $saldoInicial + $cantidad  + $saldofin2 + $saldofin5 - $saldofin4;
    //VALFIN+(COSTO*CANTI))/(SALINI+CANTI)
    if ($sw==0){
    $costo2 = ($valorInicial + ($costok * $cantidad)) / ($saldoInicial + $cantidad + $saldofin3);

    }
    else
    {
    $costo2 = ($vf + ($costok * $cantidad)) / ($saldofinal_v + $cantidad + $saldofin3);
    //$costo2=(($saldofinal_v * $costoingreso) + ($cantidad * $costoingreso)) / ($saldofinal_v + $cantidad);
    }
    $valorfin_p=$saldofin * number_format($costo2,2) ;
    //Calculo para Valor final======================================

    $saldofin2 = $saldofin2 + $cantidad;
    $vf = $valorfin_p;
    $saldofin3 = $saldofin3 + $cantidad;
     $tcompras= $tcompras + $cantidad;          
            
                if ($tcompras!=0) {
                $articulo->insertarkardexArticulo('1', '', $codigo, $ano, $costoInicial, $saldoInicial, $valorInicial, $costo2, $saldofin, $valorfin_p, $tcompras, '', $transac );
                }elseif ($tcompras==0 && $tventas==0){
                    // $articulo->insertarkardexArticulo('1', $idarticulo, $codigo , $ano, $costoInicial, $saldoInicial, $valorInicial, $costoInicial, $saldoInicial, $valorInicial, $tcompras, '0' );
                }  
         $saldofinalglobal=$saldofin;






     }else if($transac=="") {

         $saldofinalglobal=$saldoInicial;
         $costo2=$costoanterior;
         $valorfin_p=$valorFinal2;
    }

    }//sdo while

        

    } // Fin while



  $rspta=$articulo->kardexxarticuloFechas();
 //Vamos a declarar un array
 $data= Array();
 while ($reg22=$rspta->fetch_object()){

    $Object = new DateTime();  
    $Year = $Object->format("Y"); 
            
        if ($anoregart==$Year) {
            $habilAno="disabled";
        }else{
            $habilAno="";
        }


            $data[]=array(
                "0"=>$reg22->codigo,
                "1"=>$reg22->nombre,
                "2"=>$reg22->ano,
                "3"=>$reg22->costoi,
                "4"=>$reg22->saldoi,
                "5"=>$reg22->tcompras,
                "6"=>$reg22->tventas,
                "7"=>$reg22->valori,
                "8"=>$reg22->saldof,
                "9"=>$reg22->costof,
                "10"=>$reg22->valorf,
                "11"=>'<button class="btn btn-success btn-sm"  data-toggle="tooltip" title="Guardar en inventario" onclick="guardarregistro('.$reg22->idregistro.')"><i class="fa fa-save"></i>
                </button> 
                <button class="btn btn-success btn-sm">

                <a target="_blank" href="../reportes/kardexArticulo.php?codigoI='.$reg22->codigo.'&anoo='.$reg22->ano.'&f1='.$fecha1.'&f2='.$fecha2.'" data-toggle="tooltip" title="Reporte kardex">
                <i class="fa fa-print"> </i>
                   </a>
                </button>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

    break;


    case 'mostraractual':

    $fecha1=$_GET['f1_'];
    $fecha2=$_GET['f2_'];
    $rspta=$articulo->mostraractual();

    //Vamos a declarar un array
 $data= Array();
 while ($reg=$rspta->fetch_object()){

            $data[]=array(
                "0"=>$reg->codigo,
                "1"=>$reg->nombre,
                "2"=>$reg->ano,
                "3"=>$reg->costoi,
                "4"=>$reg->saldoi,
                "5"=>$reg->tcompras,
                "6"=>$reg->tventas,
                "7"=>$reg->valori,
                "8"=>$reg->costof,
                "9"=>$reg->saldof,
                "10"=>$reg->valorf,
                "11"=>'<button class="btn btn-success btn-sm"  data-toggle="tooltip" title="Guardar en inventario" onclick="guardarregistro('.$reg->idregistro.')" ><i class="fa fa-save"></i>
                </button> 
                <button class="btn btn-success btn-sm">

                <a target="_blank" href="../reportes/kardexArticulo.php?codigoI='.$reg->codigo.'&anoo='.$reg->ano.'&f1='.$fecha1.'&f2='.$fecha2.'" data-toggle="tooltip" title="Reporte kardex">
                <i class="fa fa-print"> </i>
                   </a>
                </button>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

    break;


     case 'registrarxcodigo':
        $idva=$_GET['idregval'];   
        $rspta = $consulta->registrarxcodigo($idva);
        echo $rspta;// ? 'Registro ingresado': 'No se pudo registrar';
        break;




   }
?>