<?php 
session_start();
require_once "../modelos/Usuario.php";
$usuario=new Usuario();

$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$apellidos=isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";


switch ($_GET["op"])
{
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
			}
		}
		//Hash SHA256 en la contraseña
		$clavehash=hash("SHA256", $clave);
		//$clavehash="SHA256";
		

		if (empty($idusuario)){
			$rspta=$usuario->insertar($nombre,$apellidos, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso'], $_POST['serie'], $_POST['empresa']);
			echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
		}
		else {
			$rspta=$usuario->editar($idusuario, $nombre,$apellidos, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso'], $_POST['serie'], $_POST['empresa']);
			echo $rspta ? "Usuario actualizado" : "No se pudieron actualizar todos los datos del usuario";
		}
	break;

	case 'desactivar':
		$rspta=$usuario->desactivar($idusuario);
 		echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
 		break;
	

	case 'activar':
		$rspta=$usuario->activar($idusuario);
 		echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
 		break;
	

	case 'mostrar':
		$rspta=$usuario->mostrar($idusuario);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;


	case 'listar':
		$rspta=$usuario->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->login,
                "2"=>$reg->nombre,
 				"3"=>$reg->apellidos,
 				"4"=>$reg->tipo_documento,
 				"5"=>$reg->num_documento,
 				"6"=>$reg->telefono,
 				"7"=>$reg->email,
 				"8"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px' >",
 				"9"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'permisos':
        //Obtenemos todos los permisos de la tabla permisos
        require_once "../modelos/Permiso.php";
        $permiso = new Permiso();
        $rspta = $permiso->listar();
 
        //Obtener los permisos asignados al usuario
        $id=$_GET['id'];
        $marcados = $usuario->listarmarcados($id);
        //Declaramos el array para almacenar todos los permisos marcados
        $valores=array();
 
        //Almacenar los permisos asignados al usuario en el array
        while ($per = $marcados->fetch_object())
            {
                array_push($valores, $per->idpermiso);
            }
    
        //Mostramos la lista de permisos en la vista y si están o no marcados
        while ($reg = $rspta->fetch_object())
                {
                    $sw=in_array($reg->idpermiso,$valores)?'checked':'';
                    echo '<li> <input type="checkbox" '.$sw.'  name="permiso[]" value="'.$reg->idpermiso.'">'.$reg->nombre.'</li>';
                }
    break;

    case 'permisosEmpresa':
        //Obtenemos todos los permisos de la tabla permisos
        require_once "../modelos/Permiso.php";
        $permiso = new Permiso();
        $rspta = $permiso->listarEmpresa();
 
        //Obtener los permisos asignados al usuario
        $id=$_GET['id'];
        $marcados = $usuario->listarmarcadosEmpresa($id);
        //Declaramos el array para almacenar todos los permisos marcados
        $valores=array();
 
        //Almacenar los permisos asignados al usuario en el array
        while ($per = $marcados->fetch_object())
            {
                array_push($valores, $per->idempresa);
            }
    
        //Mostramos la lista de permisos en la vista y si están o no marcados
        while ($reg = $rspta->fetch_object())
                {
                    $sw=in_array($reg->idempresa,$valores)?'checked':'';
                    echo '<li> <input type="checkbox" '.$sw.'  name="empresa[]" value="'.$reg->idempresa.'">'.$reg->nombre_razon_social.'</li>';
                }
    break;


    case 'permisosEmpresaTodos':
        //Obtenemos todos los permisos de la tabla permisos
        require_once "../modelos/Permiso.php";
        $permiso = new Permiso();
        $rspta = $permiso->listarEmpresa();
        $marcados = $usuario->listarmarcadosEmpresaTodos();
        //Declaramos el array para almacenar todos los permisos marcados
        $valores=array();
 
        //Almacenar los permisos asignados al usuario en el array
        while ($per = $marcados->fetch_object())
            {
                array_push($valores, $per->idempresa);
            }
    
        //Mostramos la lista de permisos en la vista y si están o no marcados
        while ($reg = $rspta->fetch_object())
                {
                    //$sw=in_array($reg->idempresa,$valores)?'checked':'';
                    echo '<li> <input type="checkbox"  name="empresa[]" value="'.$reg->idempresa.'">'.$reg->nombre_razon_social.'</li>';
                }
    break;


    case 'series':
        //Obtenemos todos los permisos de la tabla permisos
        require_once "../modelos/Numeracion.php";
        $numeracion = new Numeracion();
        $rspta = $numeracion->listarSeries();
 
        //Obtener los permisos asignados al usuario
        $id=$_GET['id'];
        $marcados = $usuario->listarmarcadosNumeracion($id);
        //Declaramos el array para almacenar todos los permisos marcados
        $valores=array();
 
        //Almacenar los permisos asignados al usuario en el array
        while ($per = $marcados->fetch_object())
            {
                array_push($valores, $per->idnumeracion);
            }
            


        //Mostramos la lista de permisos en la vista y si están o no marcados
        while ($reg = $rspta->fetch_object())
                {
                    $nombres="";
                    switch ($reg->tipo_documento) {
                            case '01':
                            $nombres="FACTURA";
                            break;
                            case '03':
                            $nombres="BOLETA";
                            break;
                            case '07':
                            $nombres="NOTA DE CRÉDITO";
                            break;
                            case '08':
                            $nombres="NOTA DE DEBITO";
                            break;
                            case '09':
                            $nombres="GUIA REMISION REMITENTE";
                            break;
                            case '12':
                            $nombres="TICKET DE MAQUINA REGISTRADORA";
                            break;
                            case '13':
                            $nombres="DOCUM. EMIT. POR BANC. & SEG.";
                            break;
                            case '18':
                            $nombres="SBS";
                            break;
                            case '31':
                            $nombres="DOC. EMIT. POR AFP";
                            break;
                            case '50':
                            $nombres="NOTA DE PEDIDO";
                            break;
                            case '56':
                            $nombres="GUIA REMISION TRANSPOR.";
                            break;
                            case '99':
                            $nombres="ORDEN DE SERVICIO";
                            case '20':
                            $nombres="COTIZACION";
                            break;
                            case '30':
                            $nombres="DOCUMENTO COBRANZA";
                            break;
                            case '90':
                            $nombres="BOLETAS DE PAGO";
                            break;
                        default:
                            # code...
                            break;
                    }
                    $sw=in_array($reg->idnumeracion,$valores)?'checked':'';
                    echo '<li> <input type="checkbox" '.$sw.' name="serie[]" value="'.$reg->idnumeracion.'">'.$reg->serie.'-'.$nombres.' </li>';
                }
    break;


    case 'seriesnuevo':
        //Obtenemos todos los permisos de la tabla permisos
        require_once "../modelos/Numeracion.php";
        $numeracion = new Numeracion();
        $rspta = $numeracion->listarSeriesNuevo();
        //Mostramos la lista de permisos en la vista y si están o no marcados
        while ($reg = $rspta->fetch_object())
                {
                    $nombres="";
                    switch ($reg->tipo_documento) {
                            case '01':
                            $nombres="FACTURA";
                            break;
                            case '03':
                            $nombres="BOLETA";
                            break;
                            case '07':
                            $nombres="NOTA DE CRÉDITO";
                            break;
                            case '08':
                            $nombres="NOTA DE DEBITO";
                            break;
                            case '09':
                            $nombres="GUIA REMISION REMITENTE";
                            break;
                            case '12':
                            $nombres="TICKET DE MAQUINA REGISTRADORA";
                            break;
                            case '13':
                            $nombres="DOCUM. EMIT. POR BANC. & SEG.";
                            break;
                            case '18':
                            $nombres="SBS";
                            break;
                            case '31':
                            $nombres="DOC. EMIT. POR AFP";
                            break;
                            case '50':
                            $nombres="NOTA DE PEDIDO";
                            break;
                            case '56':
                            $nombres="GUIA REMISION TRANSPOR.";
                            break;
                            case '99':
                            $nombres="ORDEN DE SERVICIO";
                            case '20':
                            $nombres="COTIZACION";
                            break;
                            case '30':
                            $nombres="DOCUMENTO COBRANZA";
                            break;
                            case '90':
                            $nombres="BOLETAS DE PAGO";
                            break;
                        default:
                            # code...
                            break;
                    }
                    
                    echo '<li> <input type="checkbox" name="serie[]" value="'.$reg->idnumeracion.'">'.$reg->serie.'-'.$nombres.' </li>';
                }
    break;

    case 'verificar':

        $logina=$_POST['logina'];
        $clavea=$_POST['clavea'];
         $empresa=$_POST['empresa'];
        $st=$_POST['st'];


        //Hash SHA256 en la contraseña
        //$clavehash=$clavea;
        $clavehash=hash("SHA256",$clavea);
        $rspta=$usuario->verificar($logina, $clavehash, $empresa);
        $rspta2=$usuario->onoffTempo($st);
        $rspta3=$usuario->consultatemporizador();
        $fetch=$rspta->fetch_object();
        $fetch3=$rspta3->fetch_object();
 
        if (isset($fetch))
        {
            //Declaramos las variables de sesión
            $_SESSION['idusuario']=$fetch->idusuario;
            $_SESSION['nombre']=$fetch->nombre;
            $_SESSION['imagen']=$fetch->imagen;
            $_SESSION['login']=$fetch->login;

            $_SESSION['empresa']=$fetch->nombre_razon_social;
            $_SESSION['idempresa']=$fetch->idempresa;
            $_SESSION['estadotempo']=$fetch3->estado;
            $_SESSION['iva']=$fetch->igv;

            $_SESSION['ruc']=$fetch->numero_ruc;
            $_SESSION['nombreemp']=$fetch->nombre_comercial;
            $_SESSION['domicilio']=$fetch->domicilio_fiscal;
            $_SESSION['envioauto']=$fetch->envioauto;

            // $_SESSION['tcventa']=$fetch->venta;
            // $_SESSION['tccompra']=$fetch->compra;
 
            //Obtenemos los permisos del usuario
            $marcados = $usuario->listarmarcados($fetch->idusuario);
            $usuario->savedetalsesion($fetch->idusuario);
 
            //Declaramos el array para almacenar todos los permisos marcados
            $valores=array();
 
            //Almacenamos los permisos marcados en el array
            while ($per = $marcados->fetch_object())
                {
                    array_push($valores, $per->idpermiso);
                }
 
            //Determinamos los accesos del usuario
            in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
            in_array(2,$valores)?$_SESSION['almacen']=1:$_SESSION['almacen']=0;
            in_array(3,$valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
            in_array(4,$valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
            in_array(5,$valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
            //in_array(6,$valores)?$_SESSION['consultac']=1:$_SESSION['consultac']=0;
            //in_array(7,$valores)?$_SESSION['consultav']=1:$_SESSION['consultav']=0;
            //===============================================
            in_array(8,$valores)?$_SESSION['inventarios']=1:$_SESSION['inventarios']=0;
            in_array(9,$valores)?$_SESSION['kardex']=1:$_SESSION['kardex']=0;
            in_array(10,$valores)?$_SESSION['boletapago']=1:$_SESSION['boletapago']=0;
            in_array(11,$valores)?$_SESSION['produccion']=1:$_SESSION['produccion']=0;
 
        }
        echo json_encode($fetch);
     break;




     case 'salir':
        //Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");
 
    break;


     
    // case 'cargarbd':
    //     require_once "../modelos/Vendedorsitio.php";
    //     $vendedorsitio = new Vendedorsitio(); 
        
    //     $rspta = $vendedorsitio->select();
    //     while ($reg = $rspta->fetch_object())
    //             {
    //                 echo '<option value=' . $reg->nombre . '>' . $reg->nombre . '</option>';
    //             }
    // break;
}
?>