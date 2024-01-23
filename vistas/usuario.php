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
                  <div class="">
                    <div class="box-header with-border">
                          <h1 class="box-title">Usuario <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Login</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Foto</th>
                            <th>Estado</th>

                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                             <th>Opciones</th>
                            <th>Login</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Foto</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">

                          <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre(*):</label>
                            <input type="hidden" name="idusuario" id="idusuario">
                            <input type="text" class="" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required onkeyup="mayus(this)">
                          </div>

                           <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <label>Apellido(*):</label>
                            <input type="text" class="" name="apellidos" id="apellidos" maxlength="100" placeholder="Nombre" required onkeyup="mayus(this)">
                          </div>

                         

                           <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo de documento(*):</label>
                            <select class="form-control" name="tipo_documento" id="tipo_documento" required>
                            <option value="DNI">DNI</option>
                            <option value="RUC">RUC</option>
                            <option value="CEDULA">CEDULA</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Número(*):</label>
                            <input type="text" class=""  name="num_documento" id="num_documento" maxlength="20" placeholder="Documento" required  onkeypress="return NumCheck(event, this)">
                          </div>

                          <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <label>Dirección</label>
                            <input type="text" class="" name="direccion" id="direccion" placeholder="Dirección" maxlength="70" onkeyup="mayus(this)">
                          </div>

                          <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Teléfono:</label>
                            <input type="text" class="" name="telefono" id="telefono" maxlength="9" placeholder="Teléfono" onkeypress="return NumCheck(event, this)" >
                          </div>

                          <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Email:</label>
                            <input type="text" class="" name="email" id="email" maxlength="50" placeholder="Email">
                          </div>

                          <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Cargo:</label>
                            <input type="text" class="" name="cargo" id="cargo" maxlength="20" placeholder="Cargo" onkeyup="mayus(this)">
                          </div>

                         <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Login:</label>
                            <input type="text" class="" name="login" id="login" maxlength="20" placeholder="Login" required onkeyup="mayus(this)">
                          </div>

                      
                          <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <label>Diferenciar entre minuscula y mayuscula, si edita vuelva a poner la clave</label>
                            <input type="password" class="" name="clave" id="clave" maxlength="20" placeholder="Clave" required > 
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Imagen:</label>
                            <input type="file" class="" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" width="150px" height="120px" id="imagenmuestra">
                          </div>

                          <br>

<div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-12">
                  <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Permisos</th>
                            <th>Series</th>
                            <th>Empresas</th>
                            

                          </thead>
                          <tbody>
                          <tr>
                        <td> 
                          
                            <ul style="list-style: none", id="permisos" >
                            </ul>
                         
                        </td>

                        <td>
                            
                          
                            <ul style="list-style: none", id="series" >

                            </ul>
                         
                        </td>

                        <td>
                             
                          
                            <ul style="list-style: none", id="empresas" >

                            </ul>
                        

                        </td>


                        </tr>                            
                          </tbody>
                          <tfoot>
                             
                          </tfoot>
                        </table>
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

<script type="text/javascript" src="scripts/usuario.js"></script>
<?php
}
ob_end_flush();
?>