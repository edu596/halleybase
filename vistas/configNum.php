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
                          <h1 class="box-title">SERIES & NUMERACIÓN  <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo</button></h1>


                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" style="font-size: 12px">
                          <thead>
                            <th>OPCIONES</th>
                            <th>DOCUMENTO</th>
                            <th>SERIE</th>
                            <th>NUMERO</th>
                            <th>ESTADO</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>OPCIONES</th>
                            <th>DOCUMENTO</th>
                            <th>SERIE</th>
                            <th>NUMERO</th>
                            <th>ESTADO</th>
                          </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo documento:</label>
                            <input type="hidden" name="idnumeracion" id="idnumeracion">

                            <select  class="form-control select-picker" name="tipo_documento" id="tipo_documento" required>
                              <option value="01">FACTURA</option>
                              <option value="03">BOLETA</option>
                              <option value="07">NOTA DE CREDITO</option>
                              <option value="08">NOTA DE DEBITO</option>
                              <option value="09">GUÍA DE REMISIÓN REMITENTE</option>
                              <option value="12">TICKET DE MAQUINA REGISTRADORA</option>
                              <option value="13">DOCUMENTOS EMITIDOS POR BANCOS</option>
                              <option value="18">SUPERINTENDENCIA DE BANCA Y SEGUROS</option>
                              <option value="31">DOCUMENTOS EMITIDOS POR LAS AFP</option>
                              <option value="56">GUIA DE REMISION DE TRANSPORTISTA</option>
                              <option value="99">ORDEN DE SERVICIO</option>
                              <option value="50">NOTA DE PEDIDO</option>
                              <option value="20">COTIZACION</option>
                              <option value="30">DOCUMENTO DE COBRANZA</option>
                              <option value="90">BOLETA DE PAGO</option>


                            </select>

                            
                            <label>Serie:</label>
                            <input type="text" class="form-control" name="serie" id="serie" maxlength="4" placeholder="Serie" required>

                            <label>Número:</label>
                            <input type="text" class="form-control" name="numero" id="numero" maxlength="50" placeholder="Número" required>

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
<script type="text/javascript" src="scripts/configNum.js"></script>
<?php
}
ob_end_flush();
?>