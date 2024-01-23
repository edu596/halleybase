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
                          <h1 class="box-title">Lista de vendedores  <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo</button></h1>


                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" style="font-size: 12px">
                          <thead>
                            <th>OPCIONES</th>
                            <th>NOMBRE</th>
                            
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>OPCIONES</th>
                            <th>NOMBRE</th>
                            
                          </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                         <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">

                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="50" placeholder="Nombre" onkeyup="mayus(this);" required autofocus>
                            <input type="hidden" name="id" id="id">

                          </div>

                         <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">

                            <select name="empresa" id="empresa" class="form-control">
              
                            </select>
                            <input type="hidden" name="idempresa" id="idempresa" value="<?php echo $_SESSION['idempresa'];   ?>">
                          </div>
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
<script type="text/javascript" src="scripts/vendedorsitio.js"></script>
<?php
}
ob_end_flush();
?>