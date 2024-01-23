<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
 
if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
 
if ($_SESSION['ventas']==1)
{
?>

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"> -->
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
            <link rel="stylesheet" href="style.css">
            
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">

                    <div class="box-header with-border">
                          <h1 class="box-title">BOLETA SERVICIO     <button class="btn btn-info" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-newspaper-o"></i> Nuevo</button>
                           <button class="btn btn-success" id="refrescartabla" onclick="refrescartabla()"><i class="fa fa-repeat"></i> Refrescar</button>
  </h1>
                        <div class="box-tools pull-right">

                  <input type="checkbox" name="chk1" id="chk1" onclick="pause()"  data-toggle="tooltip" title="Mostrar estado de enviados a SUNAT"> 
                        </div>
                    </div>


                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-hover table-bordered table-condensed" >
                          <thead>
                            <th>Opciones</th>
                           <!--  <th><i class="fa fa-send"></i></th> -->
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            
                            <th>Comprobante</th>
                            <th>Total</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          
                        </table>
                    </div>


  <div class="panel-body" style="height: 400px;" id="formularioregistros">
    <form name="formulario" id="formulario" method="POST">

    <!-- <div class="form-group col-lg-6 col-md-8 col-sm-8 col-xs-12">
      <img src="../public/images/DatosEmpresa.jpg">
  </div> -->



<div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
 <label>Serie</label><SELECT class="form-control"  name="serie" id="serie"  onchange  ="incremetarNum()" ></SELECT>
     <input type="hidden" name="idnumeracion" id="idnumeracion" >
     <input type="hidden" name="SerieReal" id="SerieReal" >
</div>

<div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
<label>Número</label> <input type="text"  name="numero_servicio" id="numero_servicio" class="form-control" required="true" readonly>
</div>

<div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
    <label>Vendedor</label>
    <select autofocus name="vendedorsitio" id="vendedorsitio" class="form-control">
  </select>
</div>




<!--Campos para guardar comprobante Factura-->
    <input type="hidden" name="idboleta" id="idboleta" >
    <input type="hidden" name="firma_digital_36" id="firma_digital_36"  value="">



    <!--Datos de empresa Estrella-->
    <input type="hidden" name="idempresa" id="idempresa" value="<?php  echo $_SESSION['idempresa'];  ?>">
    
    <input type="hidden" name="tipo_documento" id="tipo_documento" value="03">
    <input type="hidden" name="numeracion_07" id="numeracion_07" value="">
    <input type="hidden" name="numeracion" id="numeracion" value="">


    <!--Datos del cliente-->
    <input type="hidden" name="idcliente" id="idcliente">
    <input type="hidden" name="tipo_documento_cliente" id="tipo_documento_cliente" value="0">
    <!--Datos del cliente-->


    <!--Datos de impuestos-->
    <input type="hidden" name="total_operaciones_gravadas_codigo" id="total_operaciones_gravadas_codigo" value="1001">
    <input type="hidden" name="codigo_tipo_15_1" id="codigo_tipo_15_1" value="1001">

    <input type="hidden" name="codigo_tributo_h" id="codigo_tributo_h" >
      <input type="hidden" name="nombre_tributo_h" id="nombre_tributo_h" >

      <input type="hidden" name="codigo_internacional_5" id="codigo_internacional_5" value="">

      <!--IGV-->
      <input type="hidden" name="codigo_tributo_3" id="codigo_tributo_3" value="1000">
      <input type="hidden" name="nombre_tributo_4" id="nombre_tributo_4" value="IGV">
      <input type="hidden" name="codigo_internacional_5" id="codigo_internacional_5" value="VAT">
      <!--IGV-->

    <input type="hidden" name="tipo_moneda_24" id="tipo_moneda_24" value="PEN">

    <input type="hidden" name="tipo_documento_25_1" id="tipo_documento_25_1" value="03">
    

    <input type="hidden" name="codigo_leyenda_1" id="codigo_leyenda_1" value="1000">
    <input type="hidden" name="descripcion_leyenda_2" id="descripcion_leyenda_2" value="">

    <input type="hidden" name="version_ubl_37" id="version_ubl_37" value="2.0">
    <input type="hidden" name="version_estructura" id="version_estructura" value="1.0">

    <input type="hidden" name="tasa_igv" id="tasa_igv" value="0.18">
<!--Fin de campos-->

<input type="hidden" name="codigo_precio" id="codigo_precio" value="01" >


<!--DETALLE-->
    <input type="hidden" name="codigo_precio_14_1" id="codigo_precio" value="01" >
    <input type="hidden" name="afectacion_igv_3" id="afectacion_igv_3"  value="10" >
    <input type="hidden" name="afectacion_igv_4" id="afectacion_igv_4" value="1000" >
    <input type="hidden" name="afectacion_igv_5" id="afectacion_igv_5" value="IGV" >
    <input type="hidden" name="afectacion_igv_6" id="afectacion_igv_6" value="VAT">

    <input type="hidden" name="hora" id="hora">
<!--DETALLE-->
                        <div class="row">
                          <div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
                            <label>Fecha operación:</label>
                            <input type="date" disabled="true" style="font-size: 12pt;"  class="form-control" name="fecha_emision" id="fecha_emision" disabled="true" required="true" onchange="focusTdoc()" >

                          </div>
 
                          <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                           <label>Moneda:</label>
                           <select class="form-control" name="tipo_moneda_24" id="tipo_moneda_24">
                             <option value="PEN" selected="true">SOLES</option>
                             <!-- <option value="USD">DOLARES</option>
                             <option value="EUR">EUROS</option> -->
                           </select>
                         </div>

                         <div class="form-group col-lg-1 col-md-4 col-sm-6 col-xs-12">
                           <label>T. camb:</label>
                            <input type="text" name="tcambio" id="tcambio" class="form-control" >
                         </div>


                        </div>


                      <div class="row">


                          <!--Datos del cliente-->
                         <div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
                             <label>DOCUMENTO:</label> 

                <select class="form-control" name="tipo_doc_ide" id="tipo_doc_ide" onchange="focusI()"  >
                              <OPTION value="0">S/D</OPTION>
                              <OPTION value="1" >DNI</OPTION>
                              <OPTION value="4">C.E.</OPTION>
                              <OPTION value="7">PASAPORTE</OPTION>
                              <OPTION value="A">CED. D. IDE.</OPTION>
                              <OPTION value="6">RUC</OPTION>
                </select>
                          </div>

                          <div class="form-group col-lg-2">
                            <label>Documento:</label> 
                              <input type="text" class="form-control" name="numero_documento" 
                              id="numero_documento" maxlength="15" placeholder="Número" value="-" onfocus="focusTest(this);" required="true"  onkeypress="agregarClientexDoc(event)" onchange="agregarClientexDoc2()"  > 
                              <!-- true"  onkeypress="agregarClientexDoc(event)" onkeyup="agregarClientexDoc2()">  -->


                         </div>
                      


                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Nombres y apellidos:</label> <!--Datos del cliente-->
                            <input type="text" class="form-control" name="razon_social" id="razon_social" maxlength="50" placeholder="Razón Social"   width="50x" value="-" required="true" onkeyup="mayus(this);" onkeypress="focusDir(event)">
                          </div>

              


                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Dirección:</label>
                            <input type="text" class="form-control" name="domicilio_fiscal" id="domicilio_fiscal" value="-"  onkeyup="mayus(this);"  placeholder="Dirección" onkeypress="agregarArt(event)">
                          </div>

                  </div>

                        <div class="row">
                        </div>


                <div class="form-group  col-lg-2 col-sm-12 col-md-12 col-xs-12">
                            <a data-toggle="modal" href="#myModalArt">           
                              <button id="btnAgregarArt" type="button" class="btn btn-primary">   Servicios / bienes <span class="fa fa-car"></span> </button>
                            </a>
                </div>
                

                 

                 
                  <br>    

        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label style="font-size: 16pt; color: red;" hidden="true" id="mensaje700" name="mensaje700" >Agregar DNI o C.E. del cliente.</label>
      </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <div class="table-responsive">
                            <table id="detalles" class="table">
                      <thead align="center" style="background-color:#35770c; color: #fff;">
                                     <th >Sup.</th>
                                    <th >Item</th>
                                    <th >Bien o servicio</th>
                                    <th >Código</th>
                                    <th >Importe</th>
                                    
                      </thead>
                              <tfoot>

                                <!--DCTO-->
                                     <!-- <tr>
                          <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>

                                    <th style="font-weight: bold;  background-color:#A5E393;">Dcto. </th>

                                    <th style="font-weight: bold; background-color:#A5E393;">
                                      
                                      <h4 id="tdescuentoL">0.00</h4>

                                    </td>
                                    </tr>  -->

                                    <tr>
                                      <td><td></td><td></td>
                             <th id="Titulo" style="font-weight: bold; vertical-align: center; background-color:#FFB887;">TOTAL S/</th>  <!--Datos de impuestos-->  <!--IGV-->
                            <th id="CuadroT" style="font-weight: bold; background-color:#FFB887;">

                             <h4 id="total" style="font-weight: bold; vertical-align: center; background-color:#FFB887;">0.00</h4>

                      <input type="hidden" name="total_final" id="total_final">
                      <input type="hidden" name="pre_v_u" id="pre_v_u">
                      <input type="hidden" name="subtotal_boleta" id="subtotal_boleta">
                      <input type="hidden" name="total_igv" id="total_igv">

                      <input type="hidden" name="total_dcto" id="total_dcto">

                            </th><!--Datos de impuestos-->  <!--TOTAL-->
                                    </td>
                                    </tr>




                                </tfoot>
                        
                                <tbody>
                                </tbody>
                            </table>
                          </div>
              </div>

    
                            <div class="form-group col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            </div>
                          <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-6">
                            <button class="btn btn-primary" type="submit" id="btnGuardar" data-toggle="tooltip" title="Guardar boleta" ><i class="fa fa-save"></i> Guardar </button>
 
                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left" data-toggle="tooltip" title="Cancelar"></i> Cancelar</button>
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
 
  
 <!-- Modal -->
  <div class="modal fade" id="myModalCli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 100% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un cliente</h4>
        </div>
        <div class="table-responsive">
          <table id="tblaclientes" class="table table-striped table-bordered table-condensed table-hover" width=-5px>
            <thead>
                <th >Opciones</th>
                <th >Nombre</th>
                <th >RUC</th>
                <th >Dirección</th>
                
            </thead>
            <tbody>
               
            </tbody>
            <tfoot>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>RUC</th>
                <th>Dirección</th>

            </tfoot>
          </table>
        </div>

          <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>  
        </div> 

      </div>
    </div>
  </div>  
  <!-- Fin modal -->



  <!-- Modal -->
  <div class="modal fade" id="myModalArt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 100% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un bien o servicio</h4>
        </div>
        <div class="table-responsive">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover" >
            <thead>
                <th>Opciones</th>
                <th>Descripción</th>
                <th>Código</th>
                <th>Valor</th>
            </thead>
            <tbody>
               
            </tbody>
            <tfoot>
                <th>Opciones</th>
                <th>Descripción</th>
                <th>Código</th>
                <th>Valor</th>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->


   <!-- Modal -->
  <div class="modal fade" id="modalTcambio">
    <div class="modal-dialog" style="width: 100% !important;">
      <div class="modal-content">
          <div class="modal-header">
          </div>
          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <iframe border="1" frameborder="1" height="310" width="100%" src="https://e-consulta.sunat.gob.pe/cl-at-ittipcam/tcS01Alias"></iframe>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-ver" data-dismiss="modal" >Cerrar</button>
        </div>        
     </div>
   </div>
  </div>
  <!-- Modal -->


  <!-- Modal -->
  <div class="modal fade" id="ModalNcliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 100% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title ">Nuevo cliente</h4>
        </div>
        <div class="modal-body">


<div class="container">
      <form role="form" method="post" name="busqueda" id="busqueda" >
          <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <input type="number" class="form-control" name="nruc" id="nruc" placeholder="Ingrese RUC o DNI" pattern="([0-9][0-9][0-9][0-9][0-9][0-9]

[0-9][0-9][0-9][0-9][0-9]|[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9])" autofocus>
          </div>
           <button type="submit" class="btn btn-success" name="btn-submit" id="btn-submit" value="burcarclientesunat">
              <i class="fa fa-search"></i> Buscar SUNAT
            </button>
          </form>
  </div>

           <form name="formularioncliente" id="formularioncliente" method="POST">
                          <div class="">
                            <input type="hidden" name="idpersona" id="idpersona">
                            <input type="hidden" name="tipo_persona" id="tipo_persona" value="cliente">
                          </div>

                          <div class="form-group col-lg-1 col-md-12 col-sm-12 col-xs-12">
                            <label>Tipo Doc.:</label>
                            <select  class="form-control select-picker" name="tipo_documento" id="tipo_documento" required>                       
                            <option value="6"> RUC </option>
                            </select>
                          </div>

                            <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                              <label>N. Doc.:</label>
                              <input type="text" class="form-control" name="numero_documento3" id="numero_documento3" maxlength="20" 

placeholder="Documento"  onkeypress="return focusRsocial(event, this)"  >
                            </div>

             
                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <label>Razón social:</label>
                            <input type="text" class="form-control" name="razon_social3" id="razon_social3" maxlength="100" placeholder="Razón social" 

required onkeypress="return focusDomi(event, this)">
                            </div>

                            <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label>Domicilio:</label>
                            <input type="text" class="form-control" name="domicilio_fiscal3" id="domicilio_fiscal3" maxlength="100" 

placeholder="Domicilio fiscal" required onkeypress="focustel(event, this)" >
                            </div>

                            <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                              <input type="number" class="form-control" name="telefono1" id="telefono1" maxlength="15" placeholder="Teléfono 1" pattern="([0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]|[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9])" onkeypress="return focusemail(event, this)">
                            </div>

                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="email" id="email" maxlength="50" placeholder="CORREO" required="true" 

onkeypress="return focusguardar(event, this)">
                            </div>

<div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
      <button class="btn btn-primary" type="submit" id="btnguardarncliente" name="btnguardarncliente" value="btnGuardarcliente">
        <i class="fa fa-save"></i> Guardar
      </button>
</div>

    <div class="form-group col-lg-12 col-md-4 col-sm-6 col-xs-12">
    <iframe border="0" frameborder="0" height="450" width="100%" marginwidth="1" 
    src="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias">
    </iframe>
    </div>   

         </form>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

   <script src="scripts/ajaxview.js"></script>
    <script>
//============== original ===========================================================
      $(document).ready(function(){
        $("#btn-submit").click(function(e){
          var $this = $(this);
          e.preventDefault();
//============== original ===========================================================

      var documento=$("#nruc").val();
       $.post("../ajax/factura.php?op=listarClientesfacturaxDoc&doc="+documento, function(data,status)
    {
       data=JSON.parse(data);
       if (data != null){
        alert("Ya esta registrado cliente, se agregarán sus datos!");
       $('#idpersona').val(data.idpersona);
       $('#numero_documento').val(data.numero_documento);
       $("#razon_social").val(data.razon_social);
       $('#domicilio_fiscal').val(data.domicilio_fiscal);
       //$('#correocli').val(data.email);
       document.getElementById("btnAgregarArt").style.backgroundColor= '#367fa9';
       document.getElementById("btnAgregarArt").focus();
       $("#ModalNcliente").modal('hide');
        }
        else
        {

                          $.ajax({
                          data: { "nruc" : $("#nruc").val() },
                          type: "POST",
                          dataType: "json",
                          url: "../ajax/consultasunat.php",
                        }).done(function( data, textStatus, jqXHR ){

                          if(data['success']!="false" && data['success']!=false)
                          {

                            if(typeof(data['result'])!='undefined')
                            {
                              $("#tbody").html("");
                              $("#numero_documento3").val(data.result.RUC);
                              $("#razon_social3").val(data.result.RazonSocial);
                              $("#domicilio_fiscal3").val(data.result.Direccion);
                              $("#telefono1").css("background-color","#D1F2EB");
                              $("#email").css("background-color","#D1F2EB");
                              $("#telefono1").focus();
                            }

                            $("#error").hide();
                            $(".result").show();
                          
                          }
                          else
                          {

                            if(typeof(data['msg'])!='undefined')
                            {
                              alert( data['msg'] );
                            }
                            $("#nruc").focus();
                                          
                          }
                        }).fail(function( jqXHR, textStatus, errorThrown ){
                          alert( "Solicitud fallida:" + textStatus );
                          $this.button('reset');
                          $.ajaxblock();
                  });
//============== original ===========================================================
                }
//============== original ===========================================================
            });
          
        });
      });
    </script>


    </div>


          <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i>
          Cerrar</button>  
          </div> 

      </div>
    </div>
  </div>  
  <!-- Fin modal -->

<?php
}
else
{
  require 'noacceso.php';
}
 
require 'footer.php';
?>
<script type="text/javascript" src="scripts/servicioboleta.js"></script>


<?php 
}
ob_end_flush();
?>