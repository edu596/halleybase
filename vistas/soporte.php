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
                          <h1 class="box-title"> CONTACTOS PARA SOPORTE  </h1>
                    </div>


             

               		<div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
               			<label >Correo:</label><br>
                    <label>tecnologo@tecnologosperu.com</label><br>
                    <label>Teléfonos:</label></br>
                    <label>Móvil: 966 461 459</label><br>
                    <label>Fijo: 4720383</label><br>
                    <label>Web:</label>
                    <a href="tecnologosperu.com" target="_blank">www.tecnologosperu.com</a>
                    <label>Sobre facturador SUNAT</label><br>
                 
                   
               		</div>

                  <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <img src="../files/logo/tecnologos.png" class="user-image" alt="User Image">
                  </div>

            <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <label style="font-size: 30px; color: blue; position: center">TECNOLOGOS PERÚ E.I.R.L</label><br>
                    <label style="font-size: 30px; color: blue; position: center">RUC: 20603504969</label>
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

}
ob_end_flush();
?>