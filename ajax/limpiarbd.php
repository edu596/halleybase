<?php 
require_once "../modelos/Limpiarbd.php";

$limpiarbd = new Limpiarbd();


$idempresa=isset($_POST["empresa"])? limpiarCadena($_POST["empresa"]):"";

switch ($_GET["op"]){
 	case 'listar':
 	//$idempresa=$_GET['idempresa'];
		$rspta=$limpiarbd->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>' <i  onclick="limpiarbd('.$reg->idempresa.')" style="color:red;" class="fa fa-close" ></i> Borrar datos de tablas',
 				"1"=>$reg->nombre_comercial
 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'limpiarbd':
	//$idempresa=$_GET['idempresa'];
        $rspta=$limpiarbd->limpiarbd('1');
		echo $rspta ? "Datos borrados" : "No se pudieron eliminar los datos";
    break;
	

	case 'copiabd':
		
		$rti=$_GET["rt"];
		$tipodd=$_GET["td"];
		
		if ($tipodd=="local"){
		    $rspta=$limpiarbd->copiabdlocal($rti);    
		}else if($tipodd=="web"){
		    $rspta=$limpiarbd->copiabdweb();
		}else{
		    $rspta=$limpiarbd->copiabdlocal($rti);
		}
        
		echo json_encode($rspta) ;
    break;
}
?>