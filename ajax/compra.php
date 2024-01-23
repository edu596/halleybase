<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Compra.php";
 
$compra=new Compra();
 
$idcompra=isset($_POST["idcompra"])? limpiarCadena($_POST["idcompra"]):"";
$idusuario=$_SESSION["idusuario"];
$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$fecha_emision=isset($_POST["fecha_emision"])? limpiarCadena($_POST["fecha_emision"]):"";
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$guia=isset($_POST["guia"])? limpiarCadena($_POST["guia"]):"";
$idempresa=isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";


$subtotal_compra=isset($_POST["subtotal_compra"])? limpiarCadena($_POST["subtotal_compra"]):"";
$total_igv=isset($_POST["total_igv"])? limpiarCadena($_POST["total_igv"]):"";
$total_compra=isset($_POST["total_final"])? limpiarCadena($_POST["total_final"]):"";

$tcambio=isset($_POST["tcambio"])? limpiarCadena($_POST["tcambio"]):"";
$hora=isset($_POST["hora"])? limpiarCadena($_POST["hora"]):"";
$moneda=isset($_POST["moneda"])? limpiarCadena($_POST["moneda"]):"";

$subarticulo=isset($_POST["subarticulo"])? limpiarCadena($_POST["subarticulo"]):"";

$idarticulonarti=isset($_POST["idarticulonarti"])? limpiarCadena($_POST["idarticulonarti"]):"";
$totalcantidad=isset($_POST["totalcantidad"])? limpiarCadena($_POST["totalcantidad"]):"";
$totalcostounitario=isset($_POST["totalcostounitario"])? limpiarCadena($_POST["totalcostounitario"]):"";

$factorc=isset($_POST["factorc"])? limpiarCadena($_POST["factorc"]):"";


$vunitario=isset($_POST["vunitario"])? limpiarCadena($_POST["vunitario"]):"";

$ruc=isset($_POST["ruc"])? limpiarCadena($_POST["ruc"]):"";
$razon_social=isset($_POST["razon_social"])? limpiarCadena($_POST["razon_social"]):"";

 

 
switch ($_GET["op"]){
    case 'guardaryeditar':

    if ($subarticulo=='0'){  

        if (empty($idcompra)){

            $rspta=$compra->insertar(
                $idusuario, 
                $idproveedor, 
                $fecha_emision, 
                $tipo_comprobante, 
                $serie_comprobante, 
                $num_comprobante, 
                $guia, 
                $subtotal_compra, 
                $total_igv, 
                $total_compra, 
                $_POST["idarticulo"], 
                $_POST["valor_unitario"], 
                $_POST["cantidad"], 
                $_POST["subtotalBD"], 
                $_POST["codigo"] , 
                $_POST["unidad_medida"], 
                $tcambio, 
                $hora,
                $moneda, 
                $idempresa,
                $ruc,
                $razon_social
            );
                echo $rspta ? "Compra registrada" : "Problema al registrar la compra, revise con el la base de datos";
            }

            }else{

                if (empty($idcompra)){

                $rspta=$compra->insertarsubarticulo(
                $idusuario, 
                $idproveedor, 
                $fecha_emision, 
                $tipo_comprobante, 
                $serie_comprobante, 
                $num_comprobante, 
                $guia, 
                $subtotal_compra, 
                $total_igv, 
                $total_compra, 
                $_POST["idarticulo"], 
                $_POST["valor_unitario"], 
                $_POST["cantidad"], 
                $_POST["subtotalBD"], 
                $_POST["codigo"] , 
                $_POST["unidad_medida"], 
                $tcambio, 
                $hora,
                $moneda, 
                $idempresa,
                $_POST["codigobarra"],
                $idarticulonarti,
                $totalcantidad,
                $totalcostounitario,
                $vunitario,
                $factorc
            );
                echo $rspta ? "Compra registrada con subarticulos" : "Problema al registrar la compra, revise con el la base de datos";
            }
                
            }

       
    break;
 
    // case 'anular':
    //     $rspta=$compra->anular($idcompra);
    //     echo $rspta ? "Ingreso anulado" : "Ingreso no se puede anular";
    // break;
 
    case 'mostrar':
        $rspta=$compra->mostrar($idcompra);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;

    case 'eliminarcompra':
        date_default_timezone_set('America/Lima');
        //$hoy=date('Y/m/d');
        $hoy = date("Y-m-d"); 
        $rspta=$compra->AnularCompra($idcompra, $hoy, $_SESSION['idempresa']);
        echo $rspta ? "Compra eliminada" : "Problema al eliminar la compra, revise con el la base de datos";
    break;
 





    case 'listarDetalle':
        //Recibimos el idingreso
        $id=$_GET['id'];
 
        $rspta = $compra->listarDetalle($id);
        $subt=0;
        $igv=0;
        $total=0;
        echo '<thead style="background-color:#A9D0F5">
                                    <th>ARTÍCULO</th>
                                    <th>CANTIDAD</th>
                                    <th>PRECIO COMPRA</th>
                                    <th>Subtotal</th>
                                </thead>';
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<tr class="filass"> <td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->costo_compra.'</td><td>'.$reg->subtotal.'</td></tr>';

                    $subt=$subt+($reg->subtotal);
                    $igv=$igv+($reg->subtotal*0.18);
                    $total=$subt+$igv;
                }
         echo ' <tfoot style="vertical-align: center;">

                                <!--SUBTOTAL-->
                                    <tr>
                          <td><td></td><td></td><td></td><td></td><td><td>

                                    <th style="font-weight: bold; vertical-align: center; background-color:#A5E393;">SUBTOTAL (S/.)</th>

                                    <th style="font-weight: bold; background-color:#A5E393;">
                                      
                                      <h4 id="subtotal" style="font-weight: bold; vertical-align: center; background-color:#A5E393;">'.$subt.'</h4></th> 
                                    </td>
                                    </tr>

                                <!--IGV-->
                          <tr><td><td></td><td></td><td></td><td></td><td><td>

                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;"> IGV  18% (S/.)</th>

                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">

                                      <h4 id="igv_" style="vertical-align: right; font-weight: bold; background-color:#A5E393;">'.$igv.'</h4>

                                    </th>
                                    </td>
                                    </tr>
                                    

                                    
                                    <tr><td><td></td><td></td><td></td><td></td><td><td>
                                    <th style="font-weight: bold; vertical-align: center; background-color:#FFB887;">TOTAL (S/.)</th> <!--Datos de impuestos-->  <!--IGV-->
                                    <th style="font-weight: bold; background-color:#FFB887;">

                                      <h4 id="total" style="font-weight: bold; vertical-align: center; background-color:#FFB887;">'.$total.'</h4>

                                      
                                    </th><!--Datos de impuestos-->  <!--TOTAL-->
                                    </td>
                                    </tr>


                                </tfoot>';
    break;




 
    case 'listar':
        $idempre=$_GET['idempresa'];
        $rspta=$compra->listar($_SESSION['idempresa']);
        //Vamos a declarar un array
        $data= Array();
        
        $st="";

        while ($reg=$rspta->fetch_object()){
            if ($reg->estado=='3') {
                $st='none';
            }else{
                $st='';
                 }
            $data[]=array(
                "0"=>

                '<div class="dropup">
                <button  class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                :::
                <span class="caret"></span></button>
                <ul class="dropdown-menu pull-center">
                    <li>
                   <a target="_blank" href="../reportes/compraReporte.php?idcompra='.$reg->idcompra.'" data-toggle="tooltip" title="Vista impresión"> Imprimir <i class="fa  fa-eye">  </i>
                     </a> 
                  
                  </li>

                  <li>
                   <a onclick="eliminarcompra('.$reg->idcompra.')" data-toggle="tooltip" title="Anular compra"> Anular <i class="fa fa-close">  </i>
                   </a>

                </ul>
                </div>'


            //     <a target="_blank" href="../reportes/compraReporte.php?idcompra='.$reg->idcompra.'" data-toggle="tooltip" title="Vista impresión"> <i class="fa  fa-eye"> </i>
            //         </a> 
            // <i  class="fa fa-close"   onclick="eliminarcompra('.$reg->idcompra.')" data-toggle="tooltip" title="Anular y dar de baja"  style="display:'.$st.';  color:red;" ></i>' 
                    ,
                "1"=>$reg->fecha,
                "2"=>$reg->proveedor,
                "3"=>$reg->usuario,
                "4"=>$reg->descripcion,
                "5"=>$reg->serie.'-'.$reg->numero,
                "6"=>$reg->total,
                "7"=>($reg->estado=='1')?'<span class="label bg-green">Ingresado</span>':
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
 
    case 'selectProveedor':
        require_once "../modelos/Persona.php";
        $persona = new Persona();
 
        $rspta = $persona->listarp();
 
        while ($reg = $rspta->fetch_object())
                {
                echo '<option value=' . $reg->idpersona . '>' . $reg->razon_social . '</option>';
                }
    break;
 
    case 'listarArticulos':
        $subarticu=$_GET['subarti'];
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
 
        $rspta=$articulo->listarActivos($_SESSION['idempresa']);
        $data= Array();

        while ($reg=$rspta->fetch_object()){
                
            $data[]=array(
                "0"=>'<button class="btn btn-warning btn-sm" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\',\''.$reg->codigo_proveedor.'\',\''.$reg->codigo.'\',\''.$reg->nombre.'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\',\''.$reg->abre.'\' ,\''.$reg->precio_unitario.'\', \''.$reg->costo_compra.'\', \''.$reg->factorc.'\' , \''.$reg->nombreum.'\')"><span class="fa fa-plus fa-sm"></span></button>',
                "1"=>$reg->codigo,
                "2"=>$reg->nombre,
                "3"=>$reg->codigo_proveedor,
                "4"=>$reg->nombreum,
                "5"=>$reg->stock,
                "6"=>$reg->precio_final_kardex//,
                //"7"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
                );
        
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);




        echo json_encode($results);
    break;


    case 'mostrarumventa':
        $ida=$_GET['idarti'];
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
        $rspta2=$articulo->listarActivosumventa($ida);
        echo json_encode($rspta2);
    break;



    case 'listarArticuloscompraxcodigo':
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
        $codigob=$_GET['codigob'];
        $rspta=$articulo->listarActivosVentaxCodigo($codigob, $_SESSION['idempresa']);
        echo json_encode($rspta);
    break;
}


?>