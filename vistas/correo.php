<?php
//Activamos el almacenamiento del Buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
if($_SESSION['acceso']==1)
{
?>

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"> -->

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
           <h1 class="box-title">  CONFIGURACIÓN DE CORREO   </h1> <i class="fa fa-send"></i>
                    </div>


               <div class="panel-body" id="formularioregistros">
               	<form name="formulario" id="formulario" method="post">

               		<div class="form-group col-lg-6 col-md-6 col-lg-6 col-xs-12">
               			<input type="hidden" name="idcorreo" id="idcorreo">
               			<label>Nombre</label>
               			<input type="text" name="nombre" id="nombre" placeholder="Nombre a mostrar" class="">
               		</div>

               		<div class="form-group col-lg-6 col-md-6 col-lg-6 col-xs-12">
               			<label>Nombre de usario</label>
               			<input type="text" name="username" id="username" placeholder="Nombre de usuario" class="">
               		</div>

               		<div class="form-group col-lg-6 col-md-6 col-lg-6 col-xs-12">
               			<label>Host</label>
               			<input type="text" name="host" id="host" placeholder="Host server de su dominio de correo" class="">
               		</div>

               		<div class="form-group col-lg-6 col-md-6 col-lg-6 col-xs-12">
               			<label>Password</label>
               			<input type="password" name="password" id="password" placeholder="Clave de correo" class="">
               		</div>

               		<div class="form-group col-lg-6 col-md-6 col-lg-6 col-xs-12">
               			<label>SMTSecure</label>
               			<input type="text" name="smtpsecure" id="smtpsecure" placeholder="Protocolo " class="">
               		</div>

               		<div class="form-group col-lg-6 col-md-6 col-lg-6 col-xs-12">
               			<label>Puerto</label>
               			<input type="text" name="port" id="port" placeholder="Puerto a utilizar Default 587" class="">
               		</div>


                  <div class="form-group col-lg-6 col-md-6 col-lg-6 col-xs-12">
                    <label>Correo de avisos</label>
                    <input type="text" name="correoavisos" id="correoavisos" placeholder="Correo de avisos" class="">
                  </div>

               		<div class="form-group col-lg-12 col-md-12 col-lg-12 col-xs-12">
               			<label>Mensaje</label>
               			<input type="text" name="mensaje" id="mensaje" placeholder="Mensaje a mostrar en el correo" class="">
               		</div>


                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i></button>

                            <a href="escritorio.php"><button class="btn btn-danger" type="button"><i class="fa fa-arrow-circle-left"></i></button><a>
                    </div>
               		


               	</form>

                 
               </div>


                		</div>
                    </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/correo.js"></script>
<?php
}
ob_end_flush();
?>