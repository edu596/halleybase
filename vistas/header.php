<?php
if(strlen(session_id())<1)
{
session_start();
}


if ($_SESSION['escritorio']==1)

    {

      require_once "../modelos/Consultas.php";
      $consulta = new Consultas();

      $rsptatc = $consulta->tipodecambio($_SESSION['idempresa']);
      $rptatcamb=$rsptatc->fetch_object();
       $venta=$rptatcamb->venta;
       $compra=$rptatcamb->compra;


      $empresa= $consulta->mostrarempresa($_SESSION['idempresa']);
      $rptaNem=$empresa->fetch_object();
      $Nempre=$rptaNem->nombre_comercial;
      
}
 

?>




<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> SISTEMA HALLEY</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Boxicons CSS -->
   <!--  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="estilos_abrir.css">     -->


    <link rel="stylesheet" href="fonts/style.css">
    <link rel="stylesheet" href="../public/css/factura.css">


    <!-- Bootstrap 3.3.5 -->
   <!--  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->

    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/toastr.css">

    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <link rel="stylesheet" media="all" href="../public/css/letter.css" data-turbolinks-track="reload">
    <script src="https://kit.fontawesome.com/95cdb670ac.js" crossorigin="anonymous"></script>


    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../public/img/halley.png">

    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">    
    <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">


    <link href="../public/css/html5tooltips.css" rel="stylesheet">
    <link href="../public/css/html5tooltips.animation.css" rel="stylesheet">

    <link rel="stylesheet" href="../public/css/autobusqueda.css">
    <link rel="stylesheet" href="enviosunat.css">
    <link rel="stylesheet" href="style.css"> 

    <link rel="stylesheet" href="carga.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>


   <!--  <link rel="stylesheet" href="../public/css/starter-template.css" >
    <link rel="stylesheet" href="../public/css/estilos.css" > -->
    <!-- Meta Pixel Code -->
    
    <link rel=" stylesheet" type="text/css" href="../public/css/tinytools.tourtip.min.css">
    
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


      
 </head>



<script type="text/javascript">
$(window).load(function() {
    $(".loader").fadeOut("slow");
});
</script>



  <body class="hold-transition skin-blue-light sidebar-mini">

    <div class="loader" id="ld" name="ld"></div>
   <!--  <body class="skin-blue-light sidebar-mini sidebar-collapse"> -->
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b> HALLEY</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b><?php echo $Nempre; ?></b></span>
            
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>


          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->


              <!--  <li class="dropdown open">
                            <a href="" class="dropdown-toggle legitRipple drop-bell" data-toggle="dropdown">
                                  <span ><?php echo $Nempre; ?>  </span>
                                   
                            </a>
                            
                          </li> -->

<li  class="dropdown user user-menu">
     
      <input type="hidden" id="idtemporizador">
      <input type="hidden" id="estado" value="<?php echo $_SESSION['estadotempo']; ?>" >
      <input type="hidden" id="envioauto" value="<?php echo $_SESSION['envioauto']; ?>" >
      <input type="hidden" id="tiempo" >
      <img src="">


      <!-- <a href="" class="fa-globe"><span class="num">2</span></a> -->

     <!--  <a class="fa fa-globe">
      <span class="fa fa-comment"></span>
        <span class="num">2</span>
      </a>  -->

     
        <li class="dropdown user user-menu"   >
               <a data-toggle="modal" href="#modalcaja">
                <i class="fa fa-lightbulb-o" datta-toggle="tooltip"  title="Ingreso a caja">
                  
                </i>
                </a>
        </li>
     



 
       <?php  $stt=$_SESSION['envioauto'];   
            if ($stt=='1'){
              echo "<li class='dropdown user user-menu'>
              <a>
                <img src='../files/iconos/luzv.gif' title='ENVIO AUTOMÁTICO ACTIVADO' width='20px'>
              </a>
              </li>";
            }else{
              echo "<li class='dropdown user user-menu'>
              <a>
                <img src='../files/iconos/luzn.gif' title='ENVIO AUTOMÁTICO DESACTIVADO' width='20px'>
              </a>
              </li>";
            }
                 ?>
    </li>


  <!--  <li class="dropdown user user-menu">
               <div class="demo-content">
            <div id="notification-header">
              <div style="position:relative">
                <button id="notification-icon" name="button" onclick="myFunction()" class="dropbtn"><span id="notification-count"><?php if($count>0) { echo $count; } ?></span>
                  <img src="../public/images/icono.png" />
                </button>
                <div id="notification-latest"></div>
              </div>          
            </div>
          </div>
              </li> -->


              
               

<!-- 
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                  
                </a>

                <ul class="dropdown-menu">
                  
                  <li class="user-header">
                    <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                    <p>
                      <small> <?php echo $_SESSION['nombre']; ?> </small>
                      <small> <?php echo $_SESSION['ruc']; ?> </small>
                      <small> <?php echo $_SESSION['nombreemp']; ?> </small>
                  
                    </p>
                  </li>
                  
                  
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar Sesión</a>
                    </div>
                  </li>

                </ul>
              </li>
 -->
                          <li class="dropdown open">
                            <a href="" class="dropdown-toggle legitRipple drop-bell" data-toggle="dropdown">
                                  <!-- V:  <?php echo $venta; ?>   -->
                                   
                            </a>
                            
                          </li>


                           <li class="dropdown open">
                            <a href="" class="dropdown-toggle legitRipple drop-bell" data-toggle="dropdown">
                                   <!-- C:  <?php echo $compra; ?> -->
                                   
                            </a>
                            
                          </li>


                          <li class="dropdown open">
                           <!--  <a href="" class="dropdown-toggle legitRipple drop-bell" data-toggle="dropdown">
                                   <?php echo date("d-m-Y"); ?>
                          
                            </a> -->
                            <input type="hidden" name="iva" id="iva" value='<?php echo $_SESSION['iva']; ?>'>
                            
                          </li>


              <!-- <li class="dropdown user user-menu"  title="Inicio" >
                <a href="escritorio.php"> 
                <i class="fa fa-home" > </i> 
                </a>
              </li> -->

              
<!--                 <a href="validafactura.php"> 
                <i class="">VF</i> 
                </a>
              


              <li class="dropdown user user-menu"  title="Validar boletas" >
                <a href="validaboleta.php"> 
                <i class="" >VB</i> 
                </a>
              </li> -->


              
              
             <!--  <li class="dropdown user user-menu"  title="Configuración de empresa" >
                <a href="empresa.php"> 
                <i class="fa fa-cubes" >EMP</i> 
                </a>
              </li> -->

            <!--   <li class="dropdown user user-menu" title="Ir a artículos" >
                <a href="articulo.php">
                <i class="fa fa-car" >
                  ART
                </i>
                
                </a>
              </li>

               
 -->

              <li class="dropdown user user-menu"  title="Tipo de cambio" >
               <a data-toggle="modal" href="#modalTcambio">
                <i class="fa fa-money">
                  
                </i>
                </a>
              </li>


              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                  <!-- <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span> -->
                </a>

                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                    <p>
                      <small> <?php echo $_SESSION['nombre']; ?> </small>
                      <small> <?php echo $_SESSION['ruc']; ?> </small>
                      <small> <?php echo $_SESSION['nombreemp']; ?> </small>
                      <!-- <small> <?php echo $_SESSION['domicilio']; ?> </small> -->
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar Sesión</a>
                    </div>
                  </li>

                </ul>
              </li>



            </ul>
          </div>
      </nav>

</header>


 


      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">  
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>

            <?php
            if($_SESSION['escritorio']==1)
              {
                echo ' <li>
              <a href="escritorio.php">
                <i class="fa fa-home"></i> <span>Inicio</span>
              </a>
            </li>';
            }
            ?>


            <?php
            if($_SESSION['almacen']==1)
              {
                echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Almacén & servicios</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>

              <ul class="treeview-menu">
                <li><a href="articulo.php"><i class="fa fa-bicycle"></i> Artículos</a></li>
                <li><a href="almacen.php"><i class="fa fa-archive"></i> Almacen</a></li>
                
                <li><a href="familia.php"><i class="fa fa-tree"></i> Familias</a></li>
                
                
                <li><a href="umedida.php"><i class="fa fa-sliders"></i>Unidad de medida</a></li>

              </ul>
            </li>';
            }

            // <li><a href="mesa.php" style="color: green;"><i class="fa fa-table"></i>Meza</a></li>
            //     <li><a href="platos.php"><i class="fa fa-cutlery"></i> Platos </a></li>
            //<li><a href="bienservicio.php"><i class="fa fa-circle-o"></i> Bienes&Servicios</a></li>

            //<li><a href="servicio.php"><i class="fa fa-circle-o"></i>Factura de servicio FS</a></li>
            //<li><a href="servicioboleta.php"><i class="fa fa-circle-o"></i>Boleta de servicio FS</a></li>
            //<li><a href="pedidorapido.php" style="color: blue;"><i class="fa fa-fighter-jet"></i>Pedido rápido</a></li>
            ?>


            <?php
            // if($_SESSION['compras']==1)
            //   {
            //     echo '<li class="treeview">
            //   <a href="#">
            //     <i class="fa fa-th"></i>
            //     <span>Compras</span>
            //      <i class="fa fa-angle-left pull-right"></i>
            //   </a>
            //   <ul class="treeview-menu">
            //     <li><a href="compra.php"><i class="fa fa-file-powerpoint-o"></i> Ingresos</a></li>
            //     <li><a href="regcompras.php"><i class="fa fa-car"></i>Registro de Compras</a></li>
            //     <li><a href="proveedor.php"><i class="fa fa-group"></i> Proveedores</a></li>
            //     <li><a href="insumos.php"><i class="fa fa-flash"></i> Gastos / Ingresos</a></li>
            //     <li><a href="utilidadsemana.php"><i class="fa fa-magic"></i>Reporte Gastos/ingresos</a></li>
            //   </ul>
            // </li>';
            // }
            ?>

                 <?php

            if($_SESSION['ventas']==1)
              {
                echo '<li class="treeview">
                      <a href="#">
                    <i class="fa fa-shopping-cart"></i>
                      <span>Ventas</span>
                    <i class="fa fa-angle-left pull-right"></i>
                      </a>


              <ul class="treeview-menu">
                
                
            <li class="treeview">
            <a href="#">
            <i class="fa fa-bullseye"></i>
            <span>Factura</span>
            <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
            <li><a href="factura.php"><i class="fa fa-soccer-ball-o"> </i> Emitir Factura eletrónica</a></li>
            <li><a href="validafactura.php"><i class="fa fa-toggle-on"> </i> Administración Facturas</a></li>
            <li><a href="cbaja.php" ><i class="fa fa-tint"> </i> Adm. baja Facturas</a></li>
            </ul>
            </li>

                
            <li class="treeview"><a href="#">
            <i class="fa fa-coffee"></i>
            <span>Boleta</span>
            <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
            <li><a href="boleta.php"><i class="fa fa-tablet"> </i> Emitir Boleta eletrónica </a></li>
            <li><a href="validaboleta.php"><i class="fa fa-toggle-on"> </i> Validar Boletas</a></li>
            <li><a href="resumend.php" ><i class="fa fa-tint"> </i> Adm. baja boletas</a></li>
            </ul>
            </li>


             <li class="treeview">
            <a href="#">
            <i class="fa fa-bullseye"></i>
            <span>Cuotas</span>
            <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
            <li><a href="cuotas.php"><i class="fa fa-soccer-ball-o"> </i>Consultar cuotas</a></li>
            
            </ul>
            </li>




        




            <li class="treeview"><a href="#">
            <i class="fa fa-credit-card"></i>
            <span>NOTAS C/D</span>
            <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="notac.php" ><i class="fa fa-tree"></i>Nota crédito</a></li>
                <li><a href="notad.php" ><i class="fa fa-toggle-off"></i>Nota débito </a></li>
            </ul>
            </li>

             



              
           <li><a href="cliente.php"><i class="fa  fa-handshake-o"></i>Clientes</a></li>
           
                

              </ul>
            </li> ';
            }
            ?>

      



           


<!-- <li><a href="rcontingencia.php"><i class="fa fa-circle-o"></i>Resumen de contingencia </a></li> 
      <li><a href="comprobantesSUNAT.php"><i class="fa fa-circle-o"></i>Descarga de comprobantes</a></li>
-->
                   <?php
            if($_SESSION['acceso']==1)
              {
                echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-cog"></i> <span>Acceso y configuraciones</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              
              
              <li><a href="cbaja.php" ><i class="fa fa-arrow-down"></i>Comunicación baja facturas</a></li>
              <li><a href="resumend.php" ><i class="fa fa-arrow-down"></i>Resumen diario o baja de boletas</a></li>
              <li><a href="bajanc.php"><i class="fa fa-arrow-down"></i>Comunicación de baja N. crédito</a></li>
              <li><a href="vendedorsitio.php"><i class="fa fa-users"></i>Vendedor sitio</a></li>
              
              <li><a href="catalogo5.php"><i class="fa fa-gears"></i>Catalogo #5</a></li>
              <li><a href="empresa.php"><i class="fa fa-gears"></i> Conf. Empresa</a></li>
              <li><a href="limpiarbd.php"><i class="fa fa-database"></i> Base de datos</a></li>

              <li><a href="cargarcertificado.php"><i class="fa fa-certificate"></i>Cargar certificado</a></li>
              <li><a href="correo.php"><i class="fa fa-envelope-open"></i>Configurar correo</a></li>
             
            <li><a href="configNum.php"><i class="fa fa-list-ol"></i>Config. Numeración</a></li>
            <li><a href="rutas.php"><i class="fa fa-sitemap"></i>Configurar rutas</a></li>
            <li><a href="notificaciones.php"><i class="fa fa-bell"></i>Notificaciones</a></li>
            <li><a href="usuario.php"><i class="fa fa-users"></i> Usuarios</a></li>

            
                 </ul>
            </li>
            ';
            }




            // f($_SESSION['produccion']==1)
            //   {
            //     echo '<li class="treeview">
            //   <a href="#">
            //     <i class="fa fa-cog"></i> <span>Acceso y configuraciones</span>
            //     <i class="fa fa-angle-left pull-right"></i>
            //    </a>
            //   <ul class="treeview-menu">';
            // }
            ?>
              

            <li>
              <a href="soporte.php">
                <i class="fa fa-info-circle"></i> <span>Soporte</span>
                <small class="label pull-right bg-green">IT</small>
              </a>
<!-- 
              <a href="http://www.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaMovil.jsp" target="_blank">
                <i class="fa fa-info-circle"></i> <span>SUNAT</span>
                <small class="label pull-right bg-green">SUNAT</small>
              </a> -->

             <!--  <a href="../Sunat/example/index.php" target="_blank">
                <i class="fa fa-info-circle"></i> <span>Consulta SUNAT</span>
                <small class="label pull-right bg-green"></small>
              </a> -->

              <!-- <a href="http://www.sunat.gob.pe/cl-at-ittipcam/tcS01Alias" target="_blank">
                <i class="fa fa-info-circle"></i> <span>T.C.</span>
                <small class="label pull-right bg-green">T.C.</small>
              </a> -->
      

            <a href="../manual/manual.pdf" target="_blank">
                <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                <small class="label pull-right bg-red">PDF</small>
              </a>


              <a href="videos.php">
                <i class="fa fa-plus-square"></i> <span>Videos</span>
                <small class="label pull-right bg-red">VIDEOS</small>
              </a>



            </li>
                        
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

