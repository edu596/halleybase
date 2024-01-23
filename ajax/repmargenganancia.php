<?php 
require_once "../modelos/Familia.php";
$familia=new Familia();

//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Articulo.php";
$articulo = new Articulo();

$idfamilia=isset($_POST["idfamilia"])? limpiarCadena($_POST["idfamilia"]):"";
$idalmacen=isset($_POST["idalmacen"])? limpiarCadena($_POST["idalmacen"]):"";
$nombrea=isset($_POST["nombrea"])? limpiarCadena($_POST["nombrea"]):"";
$nombrec=isset($_POST["nombrec"])? limpiarCadena($_POST["nombrec"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
$direc=isset($_POST["direc"])? limpiarCadena($_POST["direc"]):"";
$idempresa=isset($_POST["idempresa2"])? limpiarCadena($_POST["idempresa2"]):"";


$nombreu=isset($_POST["nombreu"])? limpiarCadena($_POST["nombreu"]):"";
$abre=isset($_POST["abre"])? limpiarCadena($_POST["abre"]):"";
$equivalencia=isset($_POST["equivalencia2"])? limpiarCadena($_POST["equivalencia2"]):"";



switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idfamilia)){
			$rspta=$familia->insertarCategoria($nombrec);
			echo $rspta ? "Categoría registrada" : "Categoría no se pudo registrar";
		}
		else {
			$rspta=$familia->editarVategoria($idfamilia,$nombrec);
			echo $rspta ? "Categoría actualizada" : "Categoría no se pudo actualizar";
		}
	break;




    case 'eliminarmargen':
        $rpta = $articulo->eliminarmargen();
        echo $rpta ? 'Registros eliminados' : 'Problemas para eliminar';
    break;





	case 'calcularmargen':

        $opp=$_GET['opt'];
        $idarticulo=$_GET['idart'];
        $anomg=$_GET['ano'];
        $mesmg=$_GET['mes'];

        $totalco=0;
        $totalve=0;
		$margengg=0;


if ($opp=="xcodigo"){
$totalcompras = $articulo->totalcomprasxcodigo($idarticulo, $anomg, $mesmg);
while($reg= $totalcompras->fetch_object())
{
    $totalco=$reg->totalcostocompra;
}


$totalventas = $articulo->totalventasxcodigo($idarticulo, $anomg, $mesmg);
while($reg= $totalventas->fetch_object())
{
    $totalve=$reg->totalingresoventa;
}


if ($totalve!="" || $totalco!="" )
{
	$margengg=($totalve-$totalco);
	$porcemg=(($totalve-$totalco)/$totalco)*100;
}


if ($totalco!=0 || $totalve!=0) {
$articulo->insertarmargenganancia($idarticulo, $anomg, $mesmg , $totalve, $totalco, $margengg, $porcemg);
}elseif ($totalco==0 && $totalve==0)
{
$articulo->insertarmargenganancia($idarticulo, $anomg, $mesmg , '0', '0', '0', '0');
}


 $rspta=$articulo->mostrarmargeng($idarticulo, $anomg, $mesmg);
 $data= Array();
 while ($reg22=$rspta->fetch_object()){
            
            $data[]=array(
                "0"=>$reg22->nombre,
                "1"=>$reg22->totalventas,
                "2"=>$reg22->totalcompras,
                "3"=>$reg22->ganancia,
                "4"=>$reg22->porcentaje." %"
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

   }
   else
   {

   	

// PARA CONSULTA DE TODOS LOS ARTICULOSGENERAL
$idartic="";
$totalcompras = $articulo->totalcomprasgeneral($anomg, $mesmg);
$v=0;

while($reg= $totalcompras->fetch_object())
{
    $idartic=$reg->idarticulo;
    $totalco=$reg->totalcostocompra;
    
    $arre = array(array('idartiii'=>$idartic, 'tcomp'=>$totalco));
    $articulo->insertarmargengananciageneral($arre[0]['idartiii'], $anomg, $mesmg , '0' , $arre[0]['tcomp'], '0', '0');
 }
$v++;




$totalventas = $articulo->totalventasgeneral($anomg, $mesmg);
while($reg= $totalventas->fetch_object())
{
    $idartiv=$reg->idarticulo;
    $totalve=$reg->totaliventa;
	//$arre2 = array( array('idartiii'=>$idartiv, 'tvent'=>$totalve));
	$arre2 =array( array('idartiii'=>$idartiv, 'tvent'=>$totalve));

	$arre3 = array( array('idart4'=>$arre2[0]['idartiii'], 'ttventas'=>$arre2[0]['tvent'], 'ttcompras'=>$arre[0]['tcomp']));	
	$articulo->insertarmargengananciageneral($arre3[0]['idart4'], $anomg, $mesmg , $arre2[0]['tvent'], '0', '0', '0');
}






 $rspta=$articulo->mostrarmargengtodos($anomg, $mesmg);
 $data= Array();
 while ($reg22=$rspta->fetch_object()){
            
            if ($reg22->ganancia>0) {
                $gp="<i class='fa fa-hand-o-up' style='color: green;'></i>";
            }
            else
            {
                $gp="<i class='fa fa-hand-o-down' style='color: red;'></i>" ;  
            }
            $data[]=array(
                "0"=>$reg22->nombre,
                "1"=>$reg22->totalventas,
                "2"=>$reg22->totalcompras,
                "3"=>$reg22->ganancia." ".$gp,
                "4"=>$reg22->porcentaje." %"
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


	
}
?>