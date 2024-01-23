<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
 
if (!isset($_SESSION["nombre"]))
{
  $swsession=0;
  header("Location: login.html");
}
else
{
$swsession=1;
require 'header.php';
 
if ($_SESSION['ventas']==1)
{
?>

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
                          <h1 class="box-title"> FACTURA SERVICIOS
    <button class="btn btn-info" id="btnagregar" onclick= 'mostrarform(true)'><i class="fa fa-newspaper-o"></i> Nuevo</button>
     <button class="btn btn-success" id="refrescartabla" onclick="refrescartabla()"><i class="fa fa-repeat"></i> Refrescar</button>
  
                          </h1>
                        <div class="box-tools pull-right">
                          <input type="checkbox" name="chk1" id="chk1" onclick="pause()"  data-toggle="tooltip" title="Automatizar envio a SUNAT"> 
                        </div>
                    </div>


<!-- <div class="container">
  <div class="row">
        <a class="btn btn-primary view-pdf" href="../reportes/exFactura.php?id=62">View PDF</a>        
  </div>
</div> -->

                    <!-- /.box-header -->
                    <!-- centro -->

                    <div class="panel-body table-responsive" id="listadoregistros">
    <table border="0" cellspacing="5" cellpadding="5">
        <tbody>
         <!--  <tr>
            <td>Total mínimo:</td>
            <td><input type="text"  id="min" name="min" class="form-control" placeholder="ej. 1,050.50" ></td>
        </tr>
        <tr>
         <td>Total máximo:</td>
         <td><input type="text" id="max" name="max" class="form-control" placeholder="ej. 1,050.50"></td>
        </tr> -->
    </tbody>
  </table>
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed  table-hover"  >
                          <thead>
                            <th > Opciones </th>
                            <th>Fecha </th>
                            <th>Cliente</th>
                            <th >Vendedor</th>
                            <th>Factura</th>
                            <th>Total</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          
                        </table>
                    </div>


  <div class="panel-body"  id="formularioregistros">
    <form name="formulario" id="formulario" method="POST" >




<div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12" >
     <label>Serie</label>
     <select  class="form-control"  name="serie" id="serie"  onchange="incrementarNum();"  ></select>
         <input type="hidden" name="idnumeracion" id="idnumeracion" >
         <input type="hidden" name="SerieReal" id="SerieReal" >
    </div>

    <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
    <label>Número</label> <input type="text" style="font-size: 12pt;" name="numero_servicio" id="numero_servicio" class="form-control" required="true" 

readonly style="font-size: 22px" >
    </div>

     <div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
      <label>Vendedor:</label>
       <select class="form-control"  name="vendedorsitio" id="vendedorsitio" onchange="focusruccliente()">
       </select>
        </div>



<!--Campos para guardar comprobante Factura-->
    <input type="hidden" name="idfactura" id="idfactura" >
    <input type="hidden" name="firma_digital" id="firma_digital"  value="">



    <!--Datos de empresa Estrella-->
    <input type="hidden" name="idempresa" id="idempresa" value="<?php echo $_SESSION['idempresa'] ;  ?>">
    <!-- <input type="hidden" name="razon_social_empresa" id="razon_social_empresa" value="Compañía Comercial ESTRELLA S.A.">
    <input type="hidden" name="ruc_empresa" id="ruc_empresa" value="20100088917"> -->
    <!--Datos de empresa Estrella-->


    <input type="hidden" name="tipo_documento" id="tipo_documento" value="01">
    <input type="hidden" name="numeracion" id="numeracion" value="">

    <!--Datos del cliente-->
    <input type="hidden" name="idpersona" id="idpersona" required="true">
    <input type="hidden" name="tipo_documento_cliente" id="tipo_documento_cliente">
    <!--Datos del cliente-->


    <!--Datos de impuestos-->
    <input type="hidden" name="total_operaciones_gravadas_codigo" id="total_operaciones_gravadas_codigo" value="1001">

      <!--IGV-->
      <input type="hidden" name="codigo_tributo_3" id="codigo_tributo_3" value="1000">
      <input type="hidden" name="nombre_tributo_4" id="nombre_tributo_4" value="IGV">
      <input type="hidden" name="codigo_internacional_5" id="codigo_internacional_5" value="VAT">
      <!--IGV-->

    <!-- <input type="hidden" name="tipo_moneda" id="tipo_moneda" value="PEN"> -->

    <input type="hidden" name="tipo_documento_guia" id="tipo_documento_guia" value="">
    
    <input type="hidden" name="codigo_leyenda_1" id="codigo_leyenda_1" value="1000">
    <input type="hidden" name="descripcion_leyenda_2" id="descripcion_leyenda_2" value="DESCRIPCION DE LEYENDA">

    <input type="hidden" name="version_ubl" id="version_ubl" value="2.0">
    <input type="hidden" name="version_estructura" id="version_estructura" value="1.0">

    <input type="hidden" name="tasa_igv" id="tasa_igv" value="0.18">
<!--Fin de campos-->




<!--DETALLE-->
    <input type="hidden" name="codigo_precio" id="codigo_precio" value="01" >
    <input type="hidden" name="afectacion_igv_3" id="afectacion_igv_3"  value="10" >
    <input type="hidden" name="afectacion_igv_4" id="afectacion_igv_4" value="1000" >
    <input type="hidden" name="afectacion_igv_5" id="afectacion_igv_5" value="IGV" >
    <input type="hidden" name="afectacion_igv_6" id="afectacion_igv_6" value="VAT">
    <input type="hidden" name="hora" id="hora">
<!--DETALLE-->
                        <div class="row">
                          <div class="form-group  col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha operación:</label>
                            <input type="date"  style="font-size: 12pt;"  class="form-control" name="fecha_emision" id="fecha_emision" 

required="true" disabled="true" >
                          </div>

                          <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                           <label>Moneda:</label>
                           <select class="form-control" name="tipo_moneda" id="tipo_moneda">
                             <option value="PEN">SOLES</option>
                             <!-- <option value="USD">DOLARES</option>
                             <option value="EUR">EUROS</option> -->
                           </select>
                         </div>

                          <!-- <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                           
                           <a data-toggle="modal" href="#modalTcambio">
                            <button class="btn btn-primary" id="tcambio" data-toggle="tooltip" title="Tipo de cambio" name="tcambio">
                              <i class="fa fa-money" ></i> T. Cambio
                            </button> </a>
                         </div> -->



                          <div class="form-group col-md-2">

                          </div>
                        </div> 


                      <div class="row">
                          
                         
                          
                      

                         <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                             <input type="text" class="form-control" name="numero_documento2" id="numero_documento2" maxlength="11" placeholder="RUC 

DE CLIENTE-ENTER"  required="true" onkeypress="agregarClientexRuc(event)">
                              </div>



                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="razon_social2" id="razon_social2" required="true"  placeholder="RAZÓN 

SOCIAL">

                           <!-- <select id="razon_social2" name="razon_social2" class="form-control selectpicker" data-live-search="true" required >
                           </select> -->
                          </div>


                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="domicilio_fiscal2" id="domicilio_fiscal2" required="true" 

placeholder="DIRECCIÓN CLIENTE" >
                          </div>

                          <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="correocli" id="correocli" required="true"  placeholder="CORREO CLIENTE" 

onkeypress="return focusbotonarticulo(event, this)" onfocus="focusTest(this)">
                          </div>

   <!--                       <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" name="guia_remision_29_2" id="guia_remision_29_2" placeholder="Nro de Guía de remisión" >
                          </div> -->

                   <!-- <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                    <input type="checkbox" name="chk2" id="chk2">
                   </div> -->
                      

                      <div class="form-group  col-lg-6 col-md-4 col-sm-6 col-xs-12">
                      </div>

                        <div class="form-group col-lg-2 col-md-4 col-sm-6  col-xs-12">
                            <a data-toggle="modal" href="#myModalArt">           
                            <button id="btnAgregarArt" type="button" class="btn btn-primary" > 
                               Servicios / bienes <span class="fa fa-car"></span>
                            </button>
                            </a>  
                        </div>

                        <div class="form-group  col-lg-2 col-md-4 col-sm-6 col-xs-12">
                            <!-- <a data-toggle="modal" href="#myModalCli">            -->
                              <a data-toggle="modal" href="#ModalNcliente">           
                              <button id="btnAgregarCli" type="button" class="btn btn-primary">
                               Nuevo cliente <span class="fa fa-user"> </span> 
                              </button>
                            </a>
                          </div>

                  </div>

                        <div class="form-group  col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <div class="row">
                          
                        </div>


 
                          <div class="table-responsive">
                            <table id="detalles" class="table table-striped table-hover table-bordered" >
                      <thead style="background-color:#35770c; color: #fff; text-align: justify;">

                                    <th >Sup.</th>
                                    <th >Item</th>
                                    <th >Bien o servicio</th>
                                    <th >Código</th>
                                    <th >Importe</th>
                      </thead>


                              <tfoot style="vertical-align: center;">

                                <!--SUBTOTAL-->
                                     <tr>
                          <td><td></td><td></td>

                                    <th style="font-weight: bold;  background-color:#A5E393;">Op. Gravada </th>

                                    <th style="font-weight: bold; background-color:#A5E393;">
                                      
                                      <h4 id="subtotal">0.00</h4>

                            </td>
                                    </tr> 

                                <!--IGV-->
                           <tr>
                            <td><td></td><td></td>

                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">igv 18% </th>

                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">

                                      <h4 id="igv_">0.00</h4>

                                    </th>
                                    </td>
                                    </tr> 
                                    

                             <!--TOTAL-->       
                          <td><td></td><td></td>
                                    <th style="font-weight: bold; vertical-align: center; background-color:#A5E393;">Total </th> <!--Datos de 

impuestos-->  <!--IGV-->
                                    <th style="font-weight: bold; background-color:#A5E393;">

                                      <h4 id="total" style="font-weight: bold; vertical-align: center; background-color:#A5E393;">0.00</h4>

                    <input type="hidden" name="total_final" id="total_final">
                    <input type="hidden" name="subtotal_servicio" id="subtotal_servicio"> 
                    <input type="hidden" name="total_igv" id="total_igv">

                      <input type="hidden" name="pre_v_u" id="pre_v_u"></th><!--Datos de impuestos-->  <!--TOTAL-->
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
                            </a><button class="btn btn-primary" type="submit" id="btnGuardar" data-toggle="tooltip" title="Guardar factura" ><i 

class="fa fa-save"></i> Guardar</button>
 
                            <button id="btnCancelar" class="btn btn-danger" data-toggle="tooltip" title="Cancelar" onclick="cancelarform()" 

type="button"><i class="fa fa-arrow-circle-left"> Cancelar</i></button>

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
  <div class="modal fade" id="myModalCli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" role="Documento" >
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
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Salir
          </button>

          <a data-toggle="modal" href="#ModalNcliente">
          <button type="button" class="btn btn-primary" data-dismiss="modal" 
          onclick=""><i class="fa fa-user" data-toggle="tooltip" title="Nuevo cLiente"></i> Nuevo cliente</button>  
          </a>

          </div> 

      </div>
    </div>
  </div>  
  <!-- Fin modal -->


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
                            <input type="text" class="form-control" name="razon_social" id="razon_social" maxlength="100" placeholder="Razón social" 

required onkeypress="return focusDomi(event, this)">
                            </div>


                            <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label>Domicilio:</label>
                            <input type="text" class="form-control" name="domicilio_fiscal" id="domicilio_fiscal" maxlength="100" 

placeholder="Domicilio fiscal" required onkeypress="focustel(event, this)" >
                            </div>

                           <!--  <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            <label>Dep.:</label>
                            <select  class="form-control select-picker" name="iddepartamento" id="iddepartamento"  data-live-search="true" 

onchange="llenarCiudad()" >
                            </select>
                            </div>

                            <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            <label>Ciud.:</label>
                            <select  class="form-control select-picker" name="idciudad" id="idciudad" onchange="llenarDistrito()" data-live-

search="true" >                       
                            </select>
                            </div>
                          
                             <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            <label>Dist.:</label>
                            <select  class="form-control select-picker" name="iddistrito" id="iddistrito" data-live-search="true">                    

   
                            </select>
                            </div> -->

                            <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                              <input type="number" class="form-control" name="telefono1" id="telefono1" maxlength="15" placeholder="Teléfono 1" 

pattern="([0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]|[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9])" onkeypress="return focusemail(event, 

this)">
                            </div>

                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="email" id="email" maxlength="50" placeholder="CORREO" required="true" 

onkeypress="return focusguardar(event, this)">
                            </div>

                          <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnguardarncliente" name="btnguardarncliente" 

value="btnGuardarcliente"><i class="fa fa-save"></i> Guardar</button>

                         </div>
    <div class="form-group col-lg-12 col-md-4 col-sm-6 col-xs-12">
    <iframe border="0" frameborder="0" height="450" width="100%" marginwidth="1" src="https://e-consultaruc.sunat.gob.pe/cl-ti-

itmrconsruc/jcrS00Alias">
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
       $('#numero_documento2').val(data.numero_documento);
       $("#razon_social2").val(data.razon_social);
       $('#domicilio_fiscal2').val(data.domicilio_fiscal);
       $('#correocli').val(data.email);
       document.getElementById("btnAgregarArt").style.backgroundColor= '#367fa9';
       document.getElementById("btnAgregarArt").focus();
       $("#ModalNcliente").modal('hide');
        }
        else
        {
    //============== original ===========================================================
    // var url = 'llama.php';
    // $.ajax({ 
    // type:'POST',
    // url:url,
    // datatype:"json",
    // data:'ruc='+ documento,
    // success: function(datos_ruc){ 
    //   var datos = JSON.parse(datos_ruc);
    //   if (datos!=null) {
    //         $("#numero_documento3").val(datos.entity.ruc);
    //         $("#razon_social").val(datos.entity.nombre_o_razon_social);
    //         $("#domicilio_fiscal").val(datos.entity.direccion_completa);
    //         $("#telefono1").css("background-color","#D1F2EB");
    //         $("#email").css("background-color","#D1F2EB");
    //         $("#telefono1").focus();
    //   }
      
    //   }
    //   });

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
                              $("#razon_social").val(data.result.RazonSocial);
                              $("#domicilio_fiscal").val(data.result.Direccion);
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
              <iframe border="0" frameborder="0" height="310" width="100%" src="https://e-consulta.sunat.gob.pe/cl-at-ittipcam/tcS01Alias"></iframe>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-ver" data-dismiss="modal" >Cerrar</button>
        </div>        
     </div>
   </div>
  </div>

  

<?php
}
else
{
 require 'noacceso.php';
}
require 'footer.php';
?>


<!-- Para consulta RUC SUNAT -->
<!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS

+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-

h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script src="js/ajaxview.js"></script> -->


<script type="text/javascript" src="scripts/servicio.js"></script>


<?php 
}
ob_end_flush();
?>