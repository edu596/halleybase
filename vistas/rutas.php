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
              <div class=" form-group col-lg-12 col-md-12 col-lg-12 col-xs-12">
                  <div class="box">
                    <div class="box-header with-border">
           <h3 class="box-title">CONFIGURACIÓN DE RUTAS DE ACCESO Y ALMACENAMIENTO.</h3> 
           <button class="btn btn-info" id="btnagregar" onclick= 'mostrarform(true)'><i class="fa fa-newspaper-o"></i> Nuevo</button>
          
                    </div>

        <div class="panel-body table-responsive" id="listadoregistros">
            <table border="0" cellspacing="5" cellpadding="5">
                <tbody>
                </tbody>
            </table>
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed  table-hover"  >
                          <thead>
                            <th>...</th>
                            <th >Data</th>
                            <th>Firma</th>
                            <th>Envio</th>
                            <th >Respuesta</th>
                            <th >Resp. Descomprimida</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          
                        </table>
          </div>
		


               <div class="panel-body" id="formularioregistros">
               	<form name="formulario" id="formulario" method="post">

                  <input type="hidden" name="idempresa" id="idempresa" value="<?php  echo $_SESSION['idempresa'];   ?>">
                    <div class="form-group col-lg-12 col-md-4 col-sm-6 col-xs-12">
                      <button class="btn btn-primary" type="submit" id="btnGuardar">GUARDAR</button>
                      <button type="button"   id="btncargar" name="btncargar" data-toggle="tooltip" title="Traer datos" class="btn btn-success" onclick="traerruta();">
                              ESTABLECER RUTAS</button>
                      <button id="btnCancelar" class="btn btn-danger" data-toggle="tooltip" title="Cancelar" onclick="cancelarform()" type="button">CANCELAR</button>
                    </div>

               		<div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
               			<input type="hidden" name="idruta" id="idruta">
               			<label>Ruta de carpeta DATA</label>
                          <input type="text" name="rutadata" id="rutadata">
               		</div>

               		<div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
               			<label>Ruta DATA ALTERNA </label>
                    <input type="text" name="rutadatalt" id="rutadatalt">
               		</div>

               		 <div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
               			<label>Ruta de carpeta FIRMA</label>
                    <input type="text" name="rutafirma" id="rutafirma">
               		</div>

               		<div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
               			<label>Ruta de carpeta ENVIO</label>
                    <input type="text" name="rutaenvio" id="rutaenvio">
               		</div>

               		<div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
               			<label>Ruta de carpeta RPTA</label>
                    <input type="text" name="rutarpta" id="rutarpta">
               		</div>

                  <div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
                    <label>Ruta de carpeta BAJA</label>
                    <input type="text" name="rutabaja" id="rutabaja">
                  </div>

                   <div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
                    <label>Ruta de carpeta RESUMEN CONTINGENCIAS</label>
                    <input type="text" name="rutaresumen" id="rutaresumen">
                  </div>

                  <div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
                    <label>Ruta de carpeta DESCARGAS</label>
                    <input type="text" name="rutadescargas" id="rutadescargas">
                  </div>

                   <div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
                    <label>Ruta de carpeta PLE</label>
                    <input type="text" name="rutaple" id="rutaple">
                  </div>

                  <div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
                    <label>Ruta de respuestas descomprimidas</label>
                    <input type="text" name="unziprpta" id="unziprpta">
                  </div>


                  <div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
                    <label>Ruta de imagenes de art.</label>
                    <input type="text" name="rutaarticulos" id="rutaarticulos">
                  </div>

                   <div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
                    <label>Ruta imagen logo</label>
                    <input type="text" name="rutalogo" id="rutalogo">
                  </div>

                   <div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
                    <label>Ruta de imagenes usuarios.</label>
                    <input type="text" name="rutausuarios" id="rutausuarios">
                  </div>


                  <div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
                    <label>Ruta salida facturas.</label>
                    <input type="text" name="salidafacturas" id="salidafacturas">
                  </div>


                  <div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
                    <label>Ruta salida boletas.</label>
                    <input type="text" name="salidaboletas" id="salidaboletas">
                  </div>




                   <div class="form-group col-lg-4 col-md-12 col-lg-12 col-xs-12">
                    <label>Empresa</label>
                      <select name="empresa" id="empresa" class="form-control"></select>

                  </div>


                   <!--  <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i></button>
                            <a href="escritorio.php">
                            <button class="btn btn-danger" type="button"><i class="fa fa-arrow-circle-left"></i></button><a>
                    </div> -->

               		


               	</form>

             
               </div>
<!-- <h5>*Configurar las rutas dependiendo si va trabajar de forma local o utilizará un Hosting, ingrese correctamente las rutas.</h5> -->

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
<script type="text/javascript" src="scripts/rutas.js"></script>
<?php
}
ob_end_flush();
?>