<?php 

require_once "../modelos/Empresa.php";



$empresa = new Empresa();



$idempresa=isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";

$razonsocial=isset($_POST["razonsocial"])? limpiarCadena($_POST["razonsocial"]):"";

$ncomercial=isset($_POST["ncomercial"])? limpiarCadena($_POST["ncomercial"]):"";

$domicilio=isset($_POST["domicilio"])? limpiarCadena($_POST["domicilio"]):"";

$ruc=isset($_POST["ruc"])? limpiarCadena($_POST["ruc"]):"";

$tel1=isset($_POST["tel1"])? limpiarCadena($_POST["tel1"]):"";

$tel2=isset($_POST["tel2"])? limpiarCadena($_POST["tel2"]):"";

$correo=isset($_POST["correo"])? limpiarCadena($_POST["correo"]):"";

$web=isset($_POST["web"])? limpiarCadena($_POST["web"]):"";

$webconsul=isset($_POST["webconsul"])? limpiarCadena($_POST["webconsul"]):"";

$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

$ubigueo=isset($_POST["ubigueo"])? limpiarCadena($_POST["ubigueo"]):"";



$igv=isset($_POST["igv"])? limpiarCadena($_POST["igv"]):"";

$porDesc=isset($_POST["porDesc"])? limpiarCadena($_POST["porDesc"]):"";

$codubigueo=isset($_POST["codubigueo"])? limpiarCadena($_POST["codubigueo"]):"";



$ciudad=isset($_POST["ciudad"])? limpiarCadena($_POST["ciudad"]):"";

$distrito=isset($_POST["distrito"])? limpiarCadena($_POST["distrito"]):"";

$interior=isset($_POST["interior"])? limpiarCadena($_POST["interior"]):"";

$codigopais=isset($_POST["codigopais"])? limpiarCadena($_POST["codigopais"]):"";



$banco1=isset($_POST["banco1"])? limpiarCadena($_POST["banco1"]):"";

$cuenta1=isset($_POST["cuenta1"])? limpiarCadena($_POST["cuenta1"]):"";

$banco2=isset($_POST["banco2"])? limpiarCadena($_POST["banco2"]):"";

$cuenta2=isset($_POST["cuenta2"])? limpiarCadena($_POST["cuenta2"]):"";

$banco3=isset($_POST["banco3"])? limpiarCadena($_POST["banco3"]):"";

$cuenta3=isset($_POST["cuenta3"])? limpiarCadena($_POST["cuenta3"]):"";

$banco4=isset($_POST["banco4"])? limpiarCadena($_POST["banco4"]):"";

$cuenta4=isset($_POST["cuenta4"])? limpiarCadena($_POST["cuenta4"]):"";

$cuentacci1=isset($_POST["cuentacci1"])? limpiarCadena($_POST["cuentacci1"]):"";

$cuentacci2=isset($_POST["cuentacci2"])? limpiarCadena($_POST["cuentacci2"]):"";

$cuentacci3=isset($_POST["cuentacci3"])? limpiarCadena($_POST["cuentacci3"]):"";

$cuentacci4=isset($_POST["cuentacci4"])? limpiarCadena($_POST["cuentacci4"]):"";

$tipoimpresion=isset($_POST["tipoimpresion"])? limpiarCadena($_POST["tipoimpresion"]):"";
$textolibre=isset($_POST["textolibre"])? limpiarCadena($_POST["textolibre"]):"";

$envioauto=isset($_POST["opcea"])? limpiarCadena($_POST["opcea"]):"";

$rutarchivos=isset($_POST["rutarchivos"])? limpiarCadena($_POST["rutarchivos"]):"";



require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2("1");
    $Prutas = $Rrutas->fetch_object();
    $rutalogo=$Prutas->rutalogo; 

 switch ($_GET["op"]){

    case 'guardaryeditar':



        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))

        {
            $imagen=$_POST["imagenactual"];
        }
        else
        {

            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png" || $_FILES['imagen']['type'] == "image/gif")

            {

                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file( $_FILES["imagen"]["tmp_name"] , $rutalogo.$imagen);
                move_uploaded_file( $_FILES["imagen"]["tmp_name"] , '../files/logo/'.$imagen);
                copy($rutalogo.$imagen, '../files/logo/'.$imagen);

            }

        }


        if ($envioauto=='1') {
        //Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        $_SESSION['envioauto']='1';
        }else{
        //Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
            $_SESSION['envioauto']='0';
        }





        if (empty($idempresa)){

            $rspta=$empresa->insertar(

                html_entity_decode($razonsocial , ENT_QUOTES | ENT_HTML401, 'UTF-8'),

                html_entity_decode($ncomercial , ENT_QUOTES | ENT_HTML401, 'UTF-8'),

                $domicilio,

                $ruc,

                $tel1,

                $tel2,

                $correo,

                $web,

                $webconsul,

                $imagen,

                $ubigueo,

                $igv,

                $porDesc,

                $codubigueo,

                $ciudad,

                $distrito,

                $interior,

                $codigopais,

                $banco1,

                $cuenta1,

                $banco2,

                $cuenta2,

                $banco3,

                $cuenta3,

                $banco4,

                $cuenta4,

                $cuentacci1,

                $cuentacci2,

                $cuentacci3,

                $cuentacci4,

                $tipoimpresion,
                $textolibre,
                $envioauto,
                $rutarchivos

                );

            echo $rspta ? "Empresa registrada" : "Empresa no se pudo registrar";

        }

        else

        {


            $rspta=$empresa->editar($idempresa,

                html_entity_decode($razonsocial , ENT_QUOTES | ENT_HTML401, 'UTF-8'),
                html_entity_decode($ncomercial , ENT_QUOTES | ENT_HTML401, 'UTF-8'),
                $domicilio,
                $ruc,
                $tel1,
                $tel2,
                $correo,
                $web,
                $webconsul,
                $imagen,
                $ubigueo,

                $igv,

                $porDesc,

                $codubigueo,

                $ciudad,

                $distrito,

                $interior,

                $codigopais,

                $banco1,

                $cuenta1,

                $banco2,

                $cuenta2,

                $banco3,

                $cuenta3,

                $banco4,

                $cuenta4,

                $cuentacci1,

                $cuentacci2,

                $cuentacci3,

                $cuentacci4,

                $tipoimpresion,
                $textolibre,
                $envioauto,
                $rutarchivos

                );





            echo $rspta ? "Empresa actualizada" : "Empresa no se pudo actualizar";

            //print($_SERVER['DOCUMENT_ROOT']);

        }

    break;



    case 'mostrar':

        $rspta=$empresa->mostrar($idempresa);
         //Codificar el resultado utilizando json
         echo json_encode($rspta);

     break;



     case 'listar':

        $rspta=$empresa->listar();

         //Vamos a declarar un array

         $data= Array();



         while ($reg=$rspta->fetch_object()){

             $data[]=array(

                 "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idempresa.')"><i class="fa fa-pencil"></i></button>',

                 // .

                 //     ' <button class="btn btn-danger" onclick="desactivar('.$reg->idnumeracion.')"><i class="fa fa-close"></i></button>':

                 //     '<button class="btn btn-warning" onclick="mostrar('.$reg->idnumeracion.')"><i class="fa fa-pencil"></i></button>'.

                 //     ' <button class="btn btn-primary" onclick="activar('.$reg->idnumeracion.')"><i class="fa fa-check"></i></button>',

                 "1"=>$reg->nombre_comercial,

                 "2"=>$reg->domicilio_fiscal,

                 "3"=>$reg->numero_ruc,

                 "4"=>$reg->telefono1,

                 "5"=>$reg->web,

                 "6"=>($reg->logo=="")?"<img src='../files/logo/simagen.png' height='300' width='300px'>":

                 "<img src='../files/logo/".$reg->logo."' height='300px' width='300px'>"

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