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
                          <h1 class="box-title">BIENES & SERVICIOS  <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo</button></h1>


                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" >
                          <thead>
                            <th>Opciones</th>
                            <th>Descripción</th>
                            <th>Código</th>
                            <th>Valor</th>
                            <th>Tipo</th>
                            <th>Cta. contable</th>
                            
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>

                          </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="idempresa" id="idempresa" value="<?php  echo $_SESSION['idempresa']; ?>">

                           <label>Descripción:</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion"  placeholder="Descripción" required>

                            
                            <label>Código:</label>
                            <input type="text" class="form-control" name="codigo" id="codigo" maxlength="4" placeholder="Código" required>

                            <label>Valor:</label>
                            <input type="text" class="form-control" name="valor" id="valor"  placeholder="Valor del servicio o inmueble" required>

                            <label>Tipo:</label>
                            <select  class="form-control" id="tipo" name="tipo">
                              <option value="bien">Bien</option>
                              <option value="servicio">Servicio</option>
                            </select>

                            <label>Cta contable:</label>
                            <input type="text" class="form-control" name="ccontable" id="ccontable"  placeholder="Cuenta contable" required>

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
<script type="text/javascript" src="scripts/bienservicio.js"></script>
<?php
}
ob_end_flush();
?>