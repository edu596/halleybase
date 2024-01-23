<?php 
session_start();
require_once "../modelos/Conex.php";
$conex=new Conex();


switch ($_GET["op"]){
    
        case 'empresa':
        $rspta=$conex->listadodb();
        echo json_encode($rspta);
        break;



        case 'asignarBd':
        $rspta=$conex->listadodb();
        echo json_encode($rspta);
        break;



        case 'verificarempresa':
      
        $Ruc=$_POST['nruccli'];
        $User=$_POST['UserBd'];
        $Password=$_POST['PasswordBd'];
        $NombreBaseDato=$_POST['NombreBaseDatos'];
        $_SESSION['rucempresa']=$Ruc;
      
        break;



        case 'BuscarEmpresa':
        $RucEPP=$_GET['rucEm'];
        $rspta=$conex->AccesoGeneral($RucEPP);
        echo json_encode($rspta);
        break;


       
    }



    // $file = fopen("../config/".$Ruc.".php", "w+");
      // fwrite($file, '<?php' . PHP_EOL);
      // fwrite($file, 'define("DB_HOST","localhost");' . PHP_EOL);
      // fwrite($file, 'define("DB_USERNAME","'.$User.'");' . PHP_EOL);
      // fwrite($file, 'define("DB_PASSWORD","7pDramPW0mxP");' . PHP_EOL);
      // fwrite($file, 'define("DB_NAME","'.$NombreBaseDato.'");' . PHP_EOL);
      // fwrite($file, 'define("DB_ENCODE","utf8");' . PHP_EOL);
      // fwrite($file, 'define("PRO_NOMBRE","SISTEMA HALLEY");' . PHP_EOL);
      // fwrite($file, ' php? ' . PHP_EOL);
      // fclose($file);

?>