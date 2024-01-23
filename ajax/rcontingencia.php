<?php 
if (strlen(session_id()) < 1) 
  session_start();


require_once "../modelos/Rcontingencia.php";
$rcontingencia=new Rcontingencia();


$rucemisor=isset($_POST["rucemisor"])? limpiarCadena($_POST["rucemisor"]):"";
$rf=isset($_POST["rf"])? limpiarCadena($_POST["rf"]):"";
$fechag=isset($_POST["fechag"])? limpiarCadena($_POST["fechag"]):"";
$ncor=isset($_POST["ncor"])? limpiarCadena($_POST["ncor"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':


$rspta=$rcontingencia->crear($rucemisor, $rf, $fechag, $ncor, $_POST["motivoc"], $_POST["fechacomp"], $_POST["tipocp"], $_POST["seriecp"], $_POST["numerocp"], $_POST["numeroft"], $_POST["tipodc"], $_POST["numerodc"], $_POST["nombrecli"], $_POST["totalvvg"], $_POST["totalvve"], $_POST["totalvoi"], $_POST["isc"], $_POST["igv"], $_POST["otrosc"], $_POST["total"] , $_POST["tipocpm"], $_POST["seriecpm"],$_POST["numerocpm"]);
                
    echo $rspta ? "Archivo creado": "Archivo no creado";

    break;
}


?>

