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

                          <h1 class="box-title">  CONFIGURACIÓN DE EMPRESA 



                           <!-- <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo</button> </h1> -->

                    </div>



                    <div class="panel-body table-responsive" id="listadoregistros">

                      <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">

                          <thead>

                            <th>Opciones</th>

                            <th>Nombre comercial</th>

                            <th>Domicilio </th>

                            <th>Ruc</th>

                            <th>Telefono 1</th>

                            <th>Web</th>

                            <th>Logo</th>

                            

                            

                          </thead>



                          <tbody>                            

                          </tbody>



                          <tfoot>

                            <th>Opciones</th>

                            <th>Razon social</th>

                            <th>Domicilio </th> 

                            <th>Ruc</th>

                            <th>Telefono 1</th>

                            <th>Web</th>

                            <th>Logo</th>

                          </tfoot>



                      </table>

                    </div>







               <div class="panel-body" id="formularioregistros">

               	<form name="formulario" id="formulario" method="post">

<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">DENOMINACIONES</div>
                          <div class="panel-body">


                <div class="col-lg-6 col-md-12 col-lg-12 col-xs-12">
                                    <input type="hidden" name="idempresa" id="idempresa">
                                    <label>Razón Social</label>
                                    <input type="text" name="razonsocial" id="razonsocial" placeholder="Razón Social" class="">
                   </div>

                 <div class="col-lg-6 col-md-12 col-lg-12 col-xs-12">
                                    <label>Nombre comercial</label>
                                    <input type="text" name="ncomercial" id="ncomercial" placeholder="Nombre comercial" class="">
                                  </div>

              </div>
              </div>
              </div>
              </div>


              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">DOMICILIO</div>
                          <div class="panel-body">

                    <label>Domicilio fiscal</label>
                    <input type="text" name="domicilio" id="domicilio" placeholder="Domicilio fiscal" class="">


                             </div>
              </div>
              </div>
              </div>




              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">RUC - TELÉFONOS - CORREO</div>
                          <div class="panel-body">


                  <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>N° de RUC</label>
                    <input type="text" name="ruc" id="ruc" placeholder="Número de RUC" class="" onchange="asignarruta()">
                  </div>


                  <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>Teléfono 1</label>
                    <input type="text" name="tel1" id="tel1" placeholder="Teléfono 1" class="">
                  </div>


                    <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>Télefono 2</label>
                    <input type="text" name="tel2" id="tel2" placeholder="Teléfono 2" class="">
                    </div>


                    <div class="col-lg-3 col-md-6 col-lg-6 col-xs-12">
                    <label>Email</label>
                    <input type="text" name="correo" id="correo" placeholder="Correo contacto" class="">
                    </div>



                  <div class="col-lg-3 col-md-6 col-lg-6 col-xs-12">
                    <label>Página Web</label>
                    <input type="text" name="web" id="web" placeholder="Página web" class="">
                  </div>

                  


              </div>
              </div>
              </div>
              </div>


                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">IMPUESTO - UBIGEO</div>
                          <div class="panel-body">


             <div class="col-lg-4 col-md-6 col-lg-6 col-xs-12">
                    <label>Web consultas</label>
                    <input type="text" name="webconsul" id="webconsul" placeholder="Página web de consultas" class="">
                  </div>



                  <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>Código establec</label>
                    <input type="text" name="ubigueo" id="ubigueo" placeholder="Código de domicilio fiscal" class="" maxlength="5">
                  </div>



                  <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>Ubigeo Dom Fiscal</label>
                    <input type="text" name="codubigueo" id="codubigueo" >
                  </div>


                   <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>IVA</label>
                    <input type="text" name="igv" id="igv" placeholder="Ingrese el fiscal" class="" maxlength="5">
                  </div>



                  <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>% Descuento maximo</label>
                 <input type="text" name="porDesc" id="porDesc" placeholder="Limite de descuento" class="" maxlength="5">
                  </div>


              </div>
              </div>
              </div>
              </div>

               	

 <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">IMPUESTO - UBIGEO</div>
                          <div class="panel-body">


                <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                      <label>Ciudad</label>
                    <input type="text" name="ciudad" id="ciudad" placeholder="Lima">
                  </div>



                  <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>Distrito</label>
                    <input type="text" name="distrito" id="distrito" placeholder="Lima">
                  </div>



                  <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>Interior</label>
                    <input type="text" name="interior" id="interior" placeholder="Lima">
                  </div>



                  <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>Código de identificación</label>
                    <input type="text" name="codigopais" id="codigopais" placeholder="PE" >
                  </div>

                  <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>Tipo de impuesto</label>
                    
                  </div>


              </div>
              </div>
              </div>
              </div>


               <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">BANCOS</div>
                          <div class="panel-body">

                  <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>Banco 1</label>
                    <input type="text"  id="banco1" name="banco1" >
                  </div>


                   <div class="col-lg-5 col-md-6 col-lg-6 col-xs-12">
                    <label>Nro cuenta.</label>
                    <input type="text" name="cuenta1" id="cuenta1">
                  </div>


                   <div class="col-lg-5 col-md-6 col-lg-6 col-xs-12">
                    <label>CCI.</label>
                    <input type="text" name="cuentacci1" id="cuentacci1">
                  </div>


                <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>Banco 2</label>
                <input type="text"  id="banco2" name="banco2" >
                  </div>


                  <div class="col-lg-5 col-md-6 col-lg-6 col-xs-12">
                    <label>Nro cuenta.</label>
                    <input type="text" name="cuenta2" id="cuenta2">
                  </div>


                  <div class="col-lg-5 col-md-6 col-lg-6 col-xs-12">
                    <label>CCI.</label>
                    <input type="text" name="cuentacci2" id="cuentacci2">
                  </div>


                  <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>Banco 3</label>
                    <input type="text"  id="banco3" name="banco3" >
                  </div>


                  <div class="col-lg-5 col-md-6 col-lg-6 col-xs-12">
                    <label>Nro cuenta.</label>
                    <input type="text" name="cuenta3" id="cuenta3">
                  </div>


                  <div class="col-lg-5 col-md-6 col-lg-6 col-xs-12">
                    <label>CCI.</label>
                    <input type="text" name="cuentacci3" id="cuentacci3">
                  </div>


                 <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>Banco 4</label>
                  <input type="text"  id="banco4" name="banco4" >
                  </div>


                  <div class="col-lg-5 col-md-6 col-lg-6 col-xs-12">
                    <label>Nro cuenta.</label>
                    <input type="text" name="cuenta4" id="cuenta4">
                  </div>


                  <div class="col-lg-5 col-md-6 col-lg-6 col-xs-12">
                    <label>CCI.</label>
                    <input type="text" name="cuentacci4" id="cuentacci4">
                  </div>


              </div>
              </div>
              </div>
              </div>




               <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">IMPRESIÓN, TEXTO LIBRE, ENVÍO AUTOMÁTICO</div>
                          <div class="panel-body">



              <div class="col-lg-2 col-md-6 col-lg-6 col-xs-12">
                    <label>impresión por defecto</label>
                   <select id="tipoimpresion" name="tipoimpresion" >
                       <option value="58">Ticket 58mm</option>
                       <option value="80">Ticket 80mm</option>
                       <option value="01">A4 dos copias</option>
                       <option value="02">A4 completa</option>
                   </select>
                  </div>


                <div class="col-lg-6 col-md-6 col-lg-6 col-xs-12">
                    <label>Texto libre debajo de nombre de empresa en impresión</label>
                   <input type="text" name="textolibre" id="textolibre">
                  </div>

                   <div class="col-lg-4 col-md-6 col-lg-6 col-xs-12">
                    <label>Envío automático de comprobantes</label>
                    OFF <input type="checkbox" name="chk1" id="chk1" onclick="pause()"  data-toggle="tooltip" title="Automatizar envio a SUNAT"> ON
                    <input type="hidden" name="opcea" id="opcea">
                  </div>

                  <div class="col-lg-6 col-md-6 col-lg-6 col-xs-12">
                    <label>Ruta de archivos</label>
                 <input  type="text" id="rutarchivos" name="rutarchivos" >
                    
                  </div>


                                </div>
              </div>
              </div>
              </div>






                  <div class="form-group col-lg-12 col-md-12 col-lg-12 col-xs-12">





                 

                 



               



       


                  





                

                  

                  

                  

                  

                  

                  

                  



                



      <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">LOGO ACTUAL</div>
                          <div class="panel-body">

                    
                            <h3>Recomendación de tamaño: </h3>
                            <h3>167 x 166 píxeles (png, jpg)</h3>
                            <input type="file" class="" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" width="200px" height="200px" id="imagenmuestra">
                            <hr>
                            </div>
                            
                          </div>
                </div>
         </div>



               <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">VISTA PREVIA</div>
                          <div class="panel-body">
                            <div id="preview" ></div>
                        </div>
                          </div>
                            
                          </div>
                </div>
         </div>





                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

                      



                 







                    </div>





                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>



                            <button class="btn btn-danger"   onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>

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

<script type="text/javascript" src="scripts/empresa.js"></script>

<?php

}

ob_end_flush();

?>