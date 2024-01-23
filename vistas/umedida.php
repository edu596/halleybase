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

if($_SESSION['almacen']==1)
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
                          <h1 class="box-title">UNIDAD DE MEDIDA
                            </h1>




                    </div>

                      
                           <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)">Nuevo</button>
                      
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover table-wraped">
                          <thead>
                            <th>OPCIONES</th>
                            <th>NOMBRE</th>
                            <th>ABREVIATURA</th>
                            <th>EQUIVALENCIA</th>
                            <th>ESTADO</th>
                            <th>ELIMINAR</th>
                           
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                             
                          </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <input type="hidden" name="idunidadm" id="idunidadm">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre:</label>
                            <input type="text" name="nombre" id="nombre" onkeyup="mayus(this)">
                            

                            <label>Abreviatura:</label>
                            <input type="text" class="" name="abre" id="abre" placeholder="Nombre de abreviatura" onkeyup="mayus(this)">

                            <label>Equivalencia:</label>
                            <input type="text" class="" name="equivalencia" id="equivalencia" placeholder="Equivalencia" >

                            

                          </div>

                         <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
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
<script type="text/javascript" src="scripts/umedida.js"></script>
<?php
}
ob_end_flush();
?>