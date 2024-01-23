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
<link rel="stylesheet" href="carga.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<div class="loader"></div>
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
                          <h1 class="box-title">Manipulación de información delicada, tome sus precauciones. </h1>
                         
                
                      
                    </div>
                    <!--Fin centro -->

                    <div class="col-md-8">
                         <img src="../public/images/copias.jpg" >
                      <table class="table table-striped table-bordered table-condensed  table-hover" style="font-size: 16px">
                       <tr><td>Copia de seguridad de base de datos</td>
                              <td><input type="checkbox" name="chk1" id="chk1" onclick="selectopt()"  data-toggle="tooltip" title="Activar copia de base de datos"></td>
                              <td> <input type="radio" name="tipoi" id="tipoi1" hidden="true" onclick="selectinstalacion()" value="local">Windows / 
                              <input type="radio" name="tipoi" id="tipoi2" hidden="true" onclick="selectinstalacion()" value="mac">MAC / 
                                 <input type="radio" name="tipoi" id="tipoi3" hidden="true" onclick="selectinstalacion()" value="web">Web <input type="text" name="rutainsta" id="rutainsta" hidden="true"> </td>
                              <input type="hidden" name="tipodato" id="tipodato">
                        </tr>
                        <tr><td>Reiniciar base de datos</td>
                              <td><input type="checkbox" name="chk2" id="chk2" onclick="selectopt2()"  data-toggle="tooltip" title="Reiniciar base de datos"></td>
                        </tr>
                      </table>
                       <button type="button" class="btn btn-primary" value="" onclick="copiabd()">Aceptar</button>

                    </div>



                  </div><!-- /.box -->

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
<script type="text/javascript" src="scripts/limpiarbd.js"></script>
<?php
}
ob_end_flush();
?>