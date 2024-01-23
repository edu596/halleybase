<?php 
require_once "../modelos/Consultas.php";

$consultas=new Consultas();

switch ($_GET["op"]){
    
        case 'empresa':

        $rspta=$consultas->mostrarempresa();
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idempresa . '>' . $reg->nombre_razon_social . '</option>';
                }
        break;

    }

?>