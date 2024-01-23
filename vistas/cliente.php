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
if($_SESSION['ventas']==1)
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
                          <h1 class="box-title">  CLIENTES   <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>   </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">

                      <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" style="font-size: 12px">
                          <thead>
                            <th>Opciones</th>
                            <th>Razon social</th>
                            <th >Doc.</th>
                            <th>Número</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Estado</th>
                          </thead>

                          <tbody>                            
                          </tbody>

                          <tfoot>
                            <th>Opciones</th>
                            <th>Razon social</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Estado</th>
                          </tfoot>

                      </table>
                    </div>


                    <div class="panel-body" style="height: 400px;" id="formularioregistros">

                        <form name="formulario" id="formulario" method="POST">

                        


                          <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo Documento:</label>
                            <select  class="form-control"  name="tipo_documento" id="tipo_documento" required 
                            onchange="focusnd()" >                       
                            <option value="0"> S/D </option>
                            <option value="1"> DNI </option>
                            <option value="4"> CE </option>
                            <option value="6" selected="true"> RUC </option>
                            <option value="7"> PASAPORTE </option>
                            <option value="A"> CED </option>
                            </select>
                          </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Número de documento:</label>
                          <div class="input-group mb-3">
           <input type="text" name="numero_documento" id="numero_documento" 
           maxlength="11" placeholder="Presiones ENTER" onkeypress="agregarPersona(event)">
                              <input type="hidden" name="ndocu" id="ndocu">

                    <div class="input-group-append">
                        <button class="btn btn-success"  type="button" id="BtnSunat" 
                        name="BtnSunat"  onclick="BuscarPersona()"  >
                              <i> Buscar SUNAT/RENIEC</i>
                            </button>
                            </div>
                        </div>
                   </div>

                            <div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-12">
                            <label>Razón social:</label>
                            <input type="text" class="" name="razon_social" id="razon_social"  placeholder="Razón social"  onkeyup="mayus(this);" onkeypress="focusrz(event)">
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre comercial:</label>
                            <input type="text" class="" name="nombre_comercial" id="nombre_comercial"  placeholder="Nombre comercial"  onkeyup="mayus(this);" onkeypress="focusnc(event)">
                            </div>

                              <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label>Domicilio fiscal:</label>
                            <input type="text" class="" name="domicilio_fiscal" id="domicilio_fiscal" placeholder="Domicilio fiscal"  onkeyup="mayus(this);" onkeypress="focusdf(event)">
                            </div>



                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombres:</label>
                            <input type="hidden" name="idpersona" id="idpersona">
                            <input type="hidden" name="tipo_persona" id="tipo_persona" value="cliente">
                            <input type="text" class="" name="nombres" id="nombres" maxlength="100" placeholder="Opcional"  onkeyup="mayus(this);" onkeypress="focusnombre(event)" >
                          </div>


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Apellidos:</label>
                            <input type="text" class="" name="apellidos" id="apellidos" maxlength="100" placeholder="Opcional "  onkeyup="mayus(this);" onkeypress="focusapellido(event)">
                          </div>





                          


                           <!--  <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Departamento:</label>
                            <select  class="form-control" name="iddepartamento" id="iddepartamento"  data-live-search="true" onchange="llenarCiudad()"  onkeypress="focusdep(event)">
                            </select>
                            </div>

                            <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Ciudad:</label>
                            <select  class="form-control" name="idciudad" id="idciudad" onchange="llenarDistrito()" data-live-search="true" onkeypress="focusciu(event)" >                       
                            </select>
                            </div>

                             <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Distrito:</label>
                            <select  class="form-control" name="iddistrito" id="iddistrito" data-live-search="true" onkeypress="focusdist(event)" onchange="focusoctel1()">                       
                            </select>
                            </div> -->

                            <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                              <label>Teléfono 1:</label>
                              <input type="text" class="" name="telefono1" id="telefono1" maxlength="15" placeholder="Opcional" onkeypress="return NumChecktel1(event, this)">
                            </div>

                            <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                              <label>Teléfono 2:</label>
                              <input type="text" class="" name="telefono2" id="telefono2" maxlength="15" placeholder="Opcional" onkeypress="return NumChecktel2(event, this)">
                            </div>

                            <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                              <label>Ubigeo:</label>
                              <input type="text" class="" name="ubigeo" id="ubigeo" placeholder="Ubigeo" onkeypress="return NumChecktel2(event, this)">
                            </div>

                            <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                              <label>Email:</label>
                              <input type="text" class="" name="email" id="email" maxlength="50" placeholder="Opcional"  onkeypress="focusmail(event)">
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


   <script>

  
    </script>

<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/cliente.js"></script>
<?php
}
ob_end_flush();
?>