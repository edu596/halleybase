
<?php 
require_once "../modelos/Pedidorapido.php";
$pedidorapido=new Pedidorapido();

switch ($_GET["op"]){
		case 'listarplatos':
        $rspta=$pedidorapido->listarplatos();
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                //"0"=>'<button class="btn btn-warning" onclick="agregarDetalleItem('.$reg->idplato.',\''.$reg->idcategoria.'\',\''.$reg->codigo.'\',\''.$reg->nombre.'\',\''.htmlspecialchars($reg->nombre).'\',\''.$reg->precio.'\',\''.$reg->estado.'\',\''.$reg->nombreCategoria.'\',\''.$reg->imagen.'\')"><span class="fa fa-plus"></span></button>',
               "0"=>'<img src="../files/platos/'.$reg->imagen.'" height="300px" width="300px" style="text-align: center;"><br>
                <label style="text-align: center;">'.$reg->nombre.'</label>
                <label style="text-align: center;">'.$reg->precio.'</label>
                <button class="btn btn-warning" onclick="selectitem('.$reg->idplato.' , \''.$reg->imagen.'\', \''.$reg->nombre.'\' , \''.$reg->precio.'\' , \''.$reg->estado.'\')" <span class="fa fa-plus">AGREGAR</span></button>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;


        case 'listarplatos2':
        $rspta=$pedidorapido->listarplatos2();
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                //"0"=>'<button class="btn btn-warning" onclick="agregarDetalleItem('.$reg->idplato.',\''.$reg->idcategoria.'\',\''.$reg->codigo.'\',\''.$reg->nombre.'\',\''.htmlspecialchars($reg->nombre).'\',\''.$reg->precio.'\',\''.$reg->estado.'\',\''.$reg->nombreCategoria.'\',\''.$reg->imagen.'\')"><span class="fa fa-plus"></span></button>',
                "0"=>'<img src="../files/platos/'.$reg->imagen.'" height="300px" width="300px" style="text-align: center;"><br>
                <label style="text-align: center;">'.$reg->nombre.'</label>
                <label style="text-align: center;">'.$reg->precio.'</label>
                <button class="btn btn-warning" onclick="selectitem('.$reg->imagen.')" <span class="fa fa-plus">AGREGAR</span></button>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;



            case 'listarplatos3':
        $rspta=$pedidorapido->listarplatos3();
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                //"0"=>'<button class="btn btn-warning" onclick="agregarDetalleItem('.$reg->idplato.',\''.$reg->idcategoria.'\',\''.$reg->codigo.'\',\''.$reg->nombre.'\',\''.htmlspecialchars($reg->nombre).'\',\''.$reg->precio.'\',\''.$reg->estado.'\',\''.$reg->nombreCategoria.'\',\''.$reg->imagen.'\')"><span class="fa fa-plus"></span></button>',
               "0"=>'<img src="../files/platos/'.$reg->imagen.'" height="300px" width="300px" style="text-align: center;"><br>
                <label style="text-align: center;">'.$reg->nombre.'</label>
                <label style="text-align: center;">'.$reg->precio.'</label>
                <button class="btn btn-warning" onclick="selectitem('.$reg->precio.')" <span class="fa fa-plus">AGREGAR</span></button>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;



    case 'mesalist':
               
        $rspta = $pedidorapido->mesalist();
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value='.$reg->idmesa.'>'.$reg->nromesa.'</option>';
                }
    break;



    }
?>