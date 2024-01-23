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
                          <h1 class="box-title"> CONFIGURACIÓN DE CERTIFICADO  </h1>
                    </div>



               <div class="panel-body" id="formularioregistros">
               	<form name="formulario" id="formulario" method="post">

                  <div class="form-group col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>N° de RUC</label>
                    <input type="text" name="numeroruc" id="numeroruc" placeholder="Número de RUC" class="">
                  </div>

               		<div class="form-group col-lg-6 col-md-6 col-lg-6 col-xs-12">
               			<input type="hidden" name="idcarga" id="idcarga">
               			<label>Razón Social</label>
               			<input type="text" name="razon_social" id="razon_social" placeholder="Razón Social" class="">
               		</div>

                  <div class="form-group col-lg-4 col-md-6 col-lg-6 col-xs-12">
                    <label>Ubicación de certificado </label>
                    <div class="input-group mb-3">
                          <input type="text" name="rutacertificado" id="rutacertificado">
                          <div class="input-group-append">
                            <button type="button"   id="btncargar" name="btncargar"  
                            data-toggle="tooltip" title="Traer datos"  class="btn btn-success" onclick="traerruta();">
                              <i>...</i></button>
                          </div>
                        </div>
                    </div>

               		<div class="form-group col-lg-2 col-md-6 col-lg-6 col-xs-12">
               			<label>Usuario Sol</label>
               			<input type="text" name="usuarioSol" id="usuarioSol" placeholder="" class="">
               		</div>

               		<div class="form-group col-lg-2 col-md-6 col-lg-6 col-xs-12">
               			<label>Clave Sol</label>
               			<input type="password" name="claveSol" id="claveSol" placeholder="" class="">
               		</div>

                  <div class="form-group col-lg-3 col-md-6 col-lg-6 col-xs-12">
                    <label>Id Api Sunat</label>
                    <input type="password" name="claveSol" id="claveSol" placeholder="" class="">
                  </div>

                  <div class="form-group col-lg-4 col-md-6 col-lg-6 col-xs-12">
                    <label>Clave Api Sunat</label>
                    <input type="password" name="claveSol" id="claveSol" placeholder="" class="">
                  </div>




               			
              

                  <div class="form-group col-lg-6 col-md-6 col-lg-6 col-xs-12">
                    <label>Ruta del webservice FACTURA</label>
                    <input type="text" name="rutaserviciosunat" id="rutaserviciosunat" placeholder="../wsdl/billService.xml" class="" value="https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl">
                  </div>


                  <div class="form-group col-lg-6 col-md-6 col-lg-6 col-xs-12">
                    <label>Ruta del webservice GUIA</label>
                    <input type="text" name="webserviceguia" id="webserviceguia" placeholder="https://e-guiaremision.sunat.gob.pe/ol-ti-itemision-guia-gem/billService?wsdl" 
                    class="" value="https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService?wsdl">
                  </div>

                  <div class="form-group col-lg-4  col-md-6 col-sm-6 col-xs-12">
                            <label>Cargar certificado (PFX):</label>
                            <input type="file" class="" name="pfx" id="pfx" value="">
                            <input type="hidden" name="cargarcertificado" id="cargarcertificado">
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-lg-6 col-xs-12">
                      <label>Clave de certificado PFX</label>
                       <div class="input-group mb-3">
                          <input type="password" name="keypfx" id="keypfx" placeholder="" class="form-control" required>
                          <div class="input-group-append">
                            <button type="button"   id="btncargar" name="btncargar"  class="btn btn-success" onclick="validarclave();">
                              <i>Vefificar</i></button>
                          </div>
                        </div>



                    
                    
                    </div>


                  <div  class="form-group col-lg-4 col-md-6 col-lg-6 col-xs-12">
                    <label>Nombre de archivo .pem actual</label>
                    <input type="text" name="nombrepem" id="nombrepem" placeholder="" class="">
                  </div>


                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger btn-sm"   onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
<script type="text/javascript" src="scripts/cargarcertificado.js"></script>
<?php
}
ob_end_flush();
?>