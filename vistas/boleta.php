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
            <!-- <link rel="stylesheet" href="style.css"> -->
            <link rel="stylesheet" href="enviosunat.css">
            
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">


             <div class="box-header with-border">
                          <h1 class="box-title">BOLETA</h1>
                           </div>

          
                          <button class="btn btn-info btn-lg" id="btnagregar" onclick="mostrarform(true)">Nuevo</button>
                           <button class="btn btn-success btn-lg " id="refrescartabla" onclick="refrescartabla()">Refrescar</button>



            <div class="row">
              <div class="col-md-12">
                  <div class="">

                   
                              <!-- </h1> <h4  style="color: red;">Presione "N" para nueva boleta / "A" artículos / "I" si es otra unidad de medida </h4> -->
              

    <!-- OFF <input type="checkbox" name="chk1" id="chk1" onclick="pause()"  data-toggle="tooltip" title="Mostrar estado de enviados a SUNAT" >  ON -->
         
                   


                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-hover table-bordered table-condensed dt-responsibe" >
                          <thead>
                            <th>...</th>
                           <!--  <th><i class="fa fa-send"></i></th> -->
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            
                            <th>Comprobante</th>
                            <th>Total</th>
                            <th></th>
                            <th></th>
                            <th>Estado</th>
                            <th>Opciones de envio</th>
                            <th>     </th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          
                        </table>
                    </div>


  <div class="panel-body" style="height: 400px;" id="formularioregistros">
    <form name="formulario" id="formulario" method="POST" autocomplete="off">

    <!-- <div class="form-group col-lg-6 col-md-8 col-sm-8 col-xs-12">
      <img src="../public/images/DatosEmpresa.jpg">
  </div> -->





<div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">SERIE NUMERO</div>
                          <div class="panel-body">



                
 <label>Serie</label><SELECT class=""  name="serie" id="serie"  onchange  ="incremetarNum()" ></SELECT>
     <input type="hidden" name="idnumeracion" id="idnumeracion" >
     <input type="hidden" name="SerieReal" id="SerieReal" >



<label>Número</label> <input type="text"  name="numero_boleta" id="numero_boleta" class="" required="true" readonly>




                             </div>
              </div>
              </div>
              </div>




              <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">FECHAS</div>
                          <div class="panel-body">



                            <label>Fecha operación:</label>
                            <input type="date" disabled="true" style="font-size: 12pt;"  class="" name="fecha_emision_01" id="fecha_emision_01" disabled="true" required="true" onchange="focusTdoc()" >

                          


                          
                            <label>Fecha vencimiento:</label>
                            <input type="date"  class="" name="fechavenc" id="fechavenc" required="true" >
                          



                  </div>
              </div>
              </div>
              </div>



               <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">MONEDA</div>
                          <div class="panel-body">



                           <label>Moneda:</label>
                           <select class="" name="tipo_moneda_24" id="tipo_moneda_24"  onchange="tipodecambiosunat();"  >
                             <option value="PEN" selected="true">PEN</option>
                             <option value="USD">USD</option>
                             
                           </select>
                         

                         
                           <label>T. camb:</label>
                            <input type="text" name="tcambio" id="tcambio" class="" readonly="true" >

                  </div>
              </div>
              </div>
              </div>



               <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">TIPO ITEM</div>
                          <div class="panel-body">

                              
                         

  <label>Tipo de boleta:</label>
      <select class="" name="tipoboleta" id="tipoboleta" onchange="cambiarlistado()" >
                          TIPO DE BOLETA
                          <option value="st">SELECCIONE TIPO DE BOLETA</option>
                          <option value="productos" selected="true">PRODUCTOS</option>
                          <option value="servicios">SERVICIOS</option>
                        </select>
  


                  <label>Vendedor:</label>
                  <select autofocus    name="vendedorsitio" id="vendedorsitio" class="form-control">
                   </select>
   



                  </div>
              </div>
              </div>
              </div>



 <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">DATOS DEL CLIENTE</div>
                          <div class="panel-body">


                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                             <label>DOCUMENTO:</label> 

                <select class="" name="tipo_doc_ide" id="tipo_doc_ide" onchange="focusI()"  >
                              <OPTION value="0">S/D</OPTION>
                              <OPTION value="1" >DNI</OPTION>
                              <OPTION value="4">C.E.</OPTION>
                              <OPTION value="7">PASAPORTE</OPTION>
                              <OPTION value="A">CED. D. IDE.</OPTION>
                              <OPTION value="6">RUC</OPTION>
                </select>
                          </div>

                          <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            <label>Nro (Presione Enter):</label> 
                              <input type="text" class="" name="numero_documento" 
                              id="numero_documento" placeholder="Número" value="-" onfocus="focusTest(this);" required="true"  onkeypress="agregarClientexDoc(event)" onchange="agregarClientexDocCha();"> 
                              <div id="suggestions">
                              </div>
                         </div>
                      


                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Nombres y apellidos:</label> <!--Datos del cliente-->
                            <input type="text" class="" name="razon_social" id="razon_social" maxlength="50" placeholder="NOMBRE COMERCIAL"   width="50x" value="-" required="true" onkeyup="mayus(this);" onkeypress="focusDir(event)" onblur="quitasuge2()">
                            <div id="suggestions2">
                           </div>
                          </div>

              


                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Dirección:</label>
                            <input type="text" class="" name="domicilio_fiscal" id="domicilio_fiscal" value="-"  onkeyup="mayus(this);"  placeholder="Dirección" onkeypress="agregarArt(event)">
                          </div>


            


                      </div>
              </div>
              </div>
              </div>




                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">DATOS PRODUCTO / SERVICIO</div>
                          <div class="panel-body">

                              <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <label>Nro Guia:</label>
                  <input type="text"  name="guia_remision_25" id="guia_remision_25" class="" placeholder="NRO DE GUÍA">
                          </div>


                                                   
                          <div class="col-lg-7 col-sm-12 col-md-6 col-xs-12">
                             <label>Código barra:</label>
                  <input type="text" name="codigob" id="codigob" class="" onkeypress="agregarArticuloxCodigo(event)" onkeyup="mayus(this);" placeholder="Digite o escanee el código de barras"  onchange="quitasuge3()" style="background-color: #F5F589;">
                  <div id="suggestions3">
                  </div>
                          </div>



                          <div class="col-lg-2 col-sm-12 col-md-12 col-xs-12">
                          <input type="hidden" name="itemno" id="itemno" value="0">
                            <a data-toggle="modal" href="#myModalArt">           
                            <button id="btnAgregarArt" type="button" class="btn btn-primary btn-lg"  onclick="cambiarlistadoum2()"> 
                              Artículos o servicios F1
                            </button>
                            </a>  
                          </div>
              
                    

                              </div>
              </div>
              </div>
              </div>




                    <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">TIPO DE PAGO</div>
                          <div class="panel-body">


                          <label>Tipo de pago:</label>
                         <select class=""  name="tipopago" id="tipopago" onchange="contadocredito()">
                            <option value="nn">SELECCIONE LA FORMA DE PAGO</option>
                            <option value="Contado" selected>CONTADO</option>
                            <option value="Credito">CRÉDITO</option>
                          </select>



                        <div id="tipopagodiv" style="display: none;" > 

                        
                          <label>N de cuotas:</label>
          <div class="input-group mb-3">
            <input name="ccuotas" id="ccuotas" onchange="focusnroreferencia()" class="" value="1"  onkeypress="return NumCheck(event, this)">
                          <div class="input-group-append">
                            <a data-toggle="modal" href="#modalcuotas" class="btn btn-success">
                              <i class="fa fa-table" data-toggle="tooltip" title="Mostrar cuotas"></i>
                            </a>
                          </div>

                          <div class="input-group-append">
                            <a data-toggle="modal" onclick="borrarcuotas()" class="btn btn-success">
                              <i class="fa fa-trash" data-toggle="tooltip" title="Limpiar cuotas"></i></a>
                          </div>
                        </div>
               

                          </div>


                           <label>Impuesto:</label>
                          <select class="form-control" name="codigo_tributo_18_3" id="codigo_tributo_18_3" onchange="tributocodnon()" >TRIBUTO</select>




                <img src="../files/articulos/tarjetadc.png" data-toggle="tooltip" title="Pago por tarjeta"> <input type="checkbox" name="tarjetadc" id="tarjetadc" 
                onclick="activartarjetadc();">
                <input type="hidden" name="tadc"  id="tadc" >
              


              
                <img src="../files/articulos/transferencia.png" data-toggle="tooltip" title="Pago por transferencia"> <input type="checkbox" name="transferencia" id="transferencia" 
                onclick="activartransferencia();">
                <input type="hidden" name="trans"  id="trans" >
              









                                </div>
              </div>
              </div>
              </div>




                 <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">OTROS IMPUESTOS</div>
                          <div class="panel-body">


              
                          <label>Nro transferencia:</label>
                          <input type="text" name="nroreferencia" id="nroreferencia" class="" style="color: blue;" placeholder="Nro de referencia de cuenta u otro">
              
                                     
                            <a data-toggle="modal" href="#myModalnuevoitem">           
                               <button id="btnAgregarArt" type="button" class="btn btn-danger " onclick="cambiarlistadoum()" >  Otra u. medida  </button>
                            </a>
                          


                          
                            <a data-toggle="modal" href="#myModalnp">           
                               <button id="btnAgregarArt" type="button" class="btn btn-success " onclick="cambiarlistadoum()">Nota Pedido</button>
                            </a>
                          

      




                  </div>
              </div>
              </div>
              </div>













<!--Campos para guardar comprobante Factura-->
    <input type="hidden" name="idboleta" id="idboleta" >
    <input type="hidden" name="firma_digital_36" id="firma_digital_36"  value="44477344">



    <!--Datos de empresa Estrella-->
    <input type="hidden" name="idempresa" id="idempresa" value="<?php  echo $_SESSION['idempresa'];  ?>">
    
    <input type="hidden" name="tipo_documento_06" id="tipo_documento_06" value="03">
    <input type="hidden" name="numeracion_07" id="numeracion_07" value="">

    <!--Datos del cliente-->
    <input type="hidden" name="idcliente" id="idcliente">
    
    <input type="hidden" name="tipo_documento_cliente" id="tipo_documento_cliente" value="0">
    <!--Datos del cliente-->


    <!--Datos de impuestos-->
      <input type="hidden" name="codigo_tipo_15_1" id="codigo_tipo_15_1" value="1001">
      <input type="hidden" name="codigo_tributo_h" id="codigo_tributo_h" >
      <input type="hidden" name="nombre_tributo_h" id="nombre_tributo_h" >
      <input type="hidden" name="codigo_internacional_5" id="codigo_internacional_5" value="">
      <input type="hidden" name="tipo_documento_25_1" id="tipo_documento_25_1" value="0">
      <input type="hidden" name="codigo_leyenda_26_1" id="codigo_leyenda_26_1" value="1000">
      <input type="hidden" name="descripcion_leyenda_26_2" id="descripcion_leyenda_26_2" value="DESCRIPCION DE LEYENDA">
    <input type="hidden" name="version_ubl_37" id="version_ubl_37" value="2.0">
    <input type="hidden" name="version_estructura_38" id="version_estructura_38" value="1.0">
    <input type="hidden" name="tasa_igv" id="tasa_igv" value="0.18">
<!--Fin de campos-->

<input type="hidden" name="codigo_precio_14_1" id="codigo_precio" value="01" >

<!--DETALLE-->

    <input type="hidden" name="hora" id="hora">
<!--DETALLE-->

<input type="hidden" name="envioauto" id="envioauto" value="<?php  echo $_SESSION['envioauto']; ?>"> 
                         

<!--                       <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                           <a data-toggle="modal" href="#modalTcambio"><button class="btn btn-primary" id="tcambio" name="tcambio"><i class="fa fa-money"  data-toggle="tooltip" title="Tipo de cambio"></i> T.cambio</button> </a>
                         </div> -->


                      
                          <!-- <div class="form-group  col-lg-1">
                            
                            <a data-toggle="modal" href="#myModalCli">
                            <button id="btnAgregarCli" type="button" class="btn btn-primary" > <span class="fa fa-plus"></span></button>
                            </a>
                          </div> -->

                          <!--Datos del cliente-->
                         


                <!-- <div class="form-group  col-lg-1 col-sm-2 col-md-2 col-xs-12">
                          <img src="../public/images/scaner.png">
                          </div>   -->

        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label style="font-size: 16pt; color: red;" hidden="true" id="mensaje700" name="mensaje700" >Agregar DNI o C.E. del cliente.</label>
      </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <div class="table-responsive">
                            <table id="detalles" class="table">
                      <thead align="center" >
                                    <th>Sup.</th>
                                    <th>Item</th>
                                    <th>Artículo</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Dcto. %</th>
                                    <th>Cód. Prov.</th>
                                    <th>-</th>
                                    <th>U.M.</th>
                                    <th>Prec. Uni.</th>
                                    <th >Val. u.</th>
                                    <th>Stock</th>
                                    <th>Importe</th>
                                    
                      </thead>
                              <tfoot>

                                <!--DCTO-->
                                     <tr>
                          <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>

                                    <th style="font-weight: bold;  background-color:#A5E393;">Dcto. </th>

                                    <th style="font-weight: bold; background-color:#A5E393;">
                                      
                                      <h4 id="tdescuentoL">0.00</h4>
                                    </th>

                                    </td>
                                    </tr> 



                                     <!--ICBPER-->
                                    <tr>
                               <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>

                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">ICBPER </th>

                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">

                                      <h4 id="icbper">0</h4>
                                      

                                    </th>
                                    </td>
                                    </tr> 




                                    <tr>
                                      <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                             <th id="Titulo" style="font-weight: bold; vertical-align: center; background-color:#FFB887;">TOTAL</th>  <!--Datos de impuestos-->  <!--IGV-->
                            <th id="CuadroT" style="font-weight: bold; background-color:#FFB887;">

                          <!-- <h4 id="total" style="font-weight: bold; vertical-align: center; background-color:#FFB887;">0.00</h4> -->

<!--                            <input type="number" inputmode="decimal" step="any" name="totalcaja" id="totalcaja"  OnFocus="focusTest(this);" onChange="modificarSubototales(1);" >
 -->
                           <input type="text" name="totalcaja" id="totalcaja"  OnFocus="focusTest(this);" onChange="modificarSubototales(1);" >


                      <input type="hidden" name="total_final" id="total_final">
                      <input type="hidden" name="pre_v_u" id="pre_v_u">
                      <input type="hidden" name="subtotal_boleta" id="subtotal_boleta">
                      <input type="hidden" name="total_igv" id="total_igv">
                      <input type="hidden" name="total_icbper" id="total_icbper">

                      <input type="hidden" name="total_dcto" id="total_dcto">

                      <input type="hidden" name="ipagado_final" id="ipagado_final"></th><!--Datos de impuestos-->  <!--TOTAL-->
                    <input type="hidden" name="saldo_final" id="saldo_final"><!--Datos de impuestos-->  <!--TOTAL-->

                            <!--Datos de impuestos-->  <!--TOTAL-->
                                    </td>
                                    </tr>


                                     <tr>
                            <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>

                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">Total pagado </th>

                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">

                                      <h4 id="ipagado">0.00</h4>

                                    </th>
                                    </td>
                                    </tr> 


                                    <tr>
                            <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>

                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">Saldo / vuelto </th>

                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">

                                      <h4 id="saldo">0.00</h4>

                                    </th>



      
<!--             <div class="my-fixed-item">
               <h3 id="subtotalflotante" style="font-weight: bold; background-color:#A5E393;">0.00</h3>    
               <h3 id="igvflotante" style="font-weight: bold; vertical-align: center; background-color:#A5E393;">0.00</h3>    
               <h3 id="totalflotante" style="font-weight: bold; vertical-align: center; background-color:#A5E393;">0.00</h3>
       <button class="btn btn-primary " type="submit" id="btnGuardar" data-toggle="tooltip" title="Guardar factura" >
                <i class="fa fa-save"></i> Guardar
            </button>
            <button id="btnCancelar" class="btn btn-danger " data-toggle="tooltip" title="Cancelar" onclick="cancelarform()" 
                type="button"><i class="fa fa-arrow-circle-left"> Cancelar</i>
            </button>
            </div> -->
       



                                    </td>
                                    </tr> 




                                </tfoot>
                        
                                <tbody>
                                </tbody>
                            </table>

<!--       <div class="form-group  col-lg-12 col-sm-2 col-md-2 col-xs-12" style="background-color: #b4d4ee;">
            <div class="text-center">
              <div>Pago rápido S/.</div>
                <button  type="button"   value="1" name="botonpago1" id="botonpago1"   class="btn btn-success " onclick="botonrapido1()">1</button>
                <button  type="button" value="2" name="botonpago2" id="botonpago2" class="btn btn-success " onclick="botonrapido2()" >2</button>
                <button value="5"  type="button" name="botonpago5" id="botonpago5" class="btn btn-success " onclick="botonrapido5()">5</button>
                <button value="10"  type="button" name="botonpago10" id="botonpago10"  class="btn btn-success " onclick="botonrapido10()">10</button>
                <button value="20" name="botonpago20"  type="button" id="botonpago20" class="btn btn-success " onclick="botonrapido20()">20</button>
                <button  type="button"  value="50" name="botonpago50"  type="button" id="botonpago50"  class="btn btn-success " onclick="botonrapido50()" >50</button>
                <button value="100" name="botonpago100" id="botonpago100" type="button" class="btn btn-success " onclick="botonrapido100()">100</button>
                <button value="200" name="botonpago200" id="botonpago200" type="button" class="btn btn-success " onclick="botonrapido200()">200</button>
                
           </div>
</div>
 -->


                          </div>
              </div>

    
                            <div class="form-group col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            </div>
                          <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <button class="btn btn-primary btn-lg" type="submit" id="btnGuardar" data-toggle="tooltip" title="Guardar boleta" ><i class="fa fa-save"></i> Guardar </button>
 
                            <button id="btnCancelar" class="btn btn-danger btn-lg" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left" data-toggle="tooltip" title="Cancelar"></i> Cancelar</button>
                          </div>


  <div class="modal fade" id="modalcuotas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 70% !important;" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">CUOTAS Y FECHAS DE PAGO</h4>
        </div>
        
          <h2 id="totalcomp"></h2>
        

<div class="table-responsive">
  <table class="table table-sm table-striped table-bordered table-condensed table-hover nowrap">
<tr>
  <td>CUOTAS</td>
  <td>
        <div >
        <label>Monto de cuotas</label>
          <div id="divmontocuotas" >
          </div>
          </div>
  </td>

  <td>
    <div >
        <label>Fechas de pago</label>
          <div id="divfechaspago" >
          
          </div>
        </div>
  </td>
</tr>



</table>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <!-- <button type="button" class="btn btn-success" onclick="mesescontinuos()" >Meses continuos</button> -->

        </div>      
          
      </div>
     
    </div>
  </div>  
  <!-- Fin modal -->

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





  <!-- Modal   SELECCION DE PRODUCTO O SERVICIO -->
  <div class="modal fade" id="myModalnuevoitem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" role="Documento"> 
    <div class="modal-dialog" style="width: 50% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Nuevo Item</h4>
        </div>

        <div class="col-sm-12">
          <div class="form-inline">
            <div class="form-group">

              <table>

                <tr>

             <td align="center"><a onclick="cargarbien()" name="tipoitem" id="tipoitem" value="bien"><img src="../public/images/producto.png"><br>Productos</a>
             </td>
              <!-- <td align="center"><a onclick="cargarservicio()" name="tipoitem" id="tipoitem" value="servicio"><img src="../public/images/servicio.png"><br>Servicios</a></td> -->
              <input type="hidden" name="familia" id="familia">
              <input type="hidden" name="nombre" id="nombre">
              <input type="hidden" name="codigo_proveedor" id="codigo_proveedor">
              <input type="hidden" name="stock" id="stock">
              <input type="hidden" name="cicbper" id="cicbper">

              <input type="hidden" name="cantidadrealitem" id="cantidadrealitem">
              <input type="hidden" name="factorcitem" id="factorcitem">
              <input type="hidden" name="umedidaoculto" id="umedidaoculto">

               </tr>

                <tr>
                  <td>Articulo:</td>
                  <td> <input type="text" name="nombrearti" id="nombrearti" readonly></td>
                  <td>Cantidad:</td>
                  <td><input type="text" name="icantidad" id="icantidad"  class="" onkeyup="calculartotalitem();" value="1">

                  </td>

                </tr>


               <tr>
                <td>Stock:</td>
                <td><input type="text" name="stoc" id="stoc"  readonly></td>
              <td>Précio unitario:</td>
              <td><input type="text" name="ipunitario" id="ipunitario" class="" onkeyup="calvaloruniitem();"></td>
               
                </tr>

                <tr>
                  <td >ABRE:</td>
              <td><input type="text" name="iumedida" id="iumedida" class="" readonly size="4"></td>
              <td >Cambiar medida:</td>
              <td><select name="unidadm"  id="unidadm" class=""  onchange="cambioUm()"  size="2" ></select></td>

              
               </tr>

               <tr>
                <td>Valor unitario:</td>
              <td><input type="text" name="ivunitario" id="ivunitario" class="" readonly></td>
              <td>Código:</td>
                <td><input type="hidden" name="iiditem" id="iiditem" class="">
                <input type="text" name="icodigo" id="icodigo" class=""></td>
                
              </tr>

              <tr>
                <td>Descuento:</td>
              <td><input type="text" name="idescuento" id="idescuento" class="" readonly></td>
              <td>Descripción:</td>
              <td><textarea name="idescripcion" id="idescripcion" class="">  </textarea></td>
              
              </tr>


              <tr>
                <td>IGV (18%):</td>
              <td>
              <input type="radio" name="iigv" id="iigv" value="grav" onclick="calcuigv()" checked> Gvdo &nbsp;&nbsp;
              <input type="radio" name="iigv"  id="iigv" value="exo" onclick="calcuigv()" disabled> Exo.&nbsp;&nbsp;
              <input type="radio" name="iigv"  id="iigv" value="ina" onclick="calcuigv()" disabled> Ina.
              </td>
            <td>ICBPER:</td>

              <td>
              <!-- <input type="text" name="iicbper1" id="iicbper1" class="" size="4"> -->
              <input type="text" name="iicbper2" id="iicbper2" xclass=""  readonly>
              </td>
              
            </tr>

            <tr>
              <td>
              </td>

              <td><input type="text" name="iigvresu" id="iigvresu" class=""  value="0" readonly=""></td>
            <td>Impuesto ICBPER:</td>
              <td><input type="text" name="iimpicbper" id="iimpicbper" class="" readonly=""></td>
            
            </tr>

              <tr>
            </tr>

            <tr></tr>

            <tr>
              <td>Importe total del Item:</td>
              <td><input type="text" name="iimportetotalitem" id="iimportetotalitem" class="" readonly></td>
              <td></td>
              <td></td>

            </tr>

            <tr>
            <td align="justify">
              <button type="button" class="btn btn-success" data-dismiss="modal" onclick="agregarItemdetalle()"><i class="fa fa-check"></i> Aceptar </button> 
            </td>
            <td align="justify">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar </button>
            </td>

            </tr>

            </table>

              </div>
          </div>
        </div>

          <div class="modal-footer">
          
          </div> 

      </div>
    </div>
  </div>  
  <!-- Fin modal -->



  <!-- Modal -->
  <div class="modal fade" id="myModalArt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 100% !important; opacity: ;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

           <div class="form-group  col-lg-2 col-sm-12 col-md-12 col-xs-12">
                
                
                 <select class="" id="tipoprecio"  onchange="listarArticulos()" >
                <option value='1' >PRECIO PÚBLICO</option>
                <option value='2' >PRÉCIO POR MAYOR</option>
                <option value='3' >PRÉCIO DISTRIBUIDOR</option>
                </select>

              </div>

              <div class="form-group  col-lg-2 col-sm-12 col-md-12 col-xs-12">
                
                <select class="form-control" id="almacenlista"  onchange="listarArticulos()" >
                </select>
              </div>

          <div class="form-group  col-lg-2 col-sm-4 col-md-6 col-xs-12">
          <button class="btn btn-success" id="refrescartabla" onclick="refrescartabla()">
            <span class="sr-only"></span>Actualizar</button>
          </div>

          <div class="form-group  col-lg-2 col-sm-4 col-md-6 col-xs-12">
            <button class="btn btn-danger" id="refrescartabla" onclick="nuevoarticulo()">
            <span class="sr-only"></span>Nuevo artículo</button>
          </div>


          </div>


          <div class="form-group  col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="table-responsive">
          <table id="tblarticulos" class="table table-striped table-bordered  table-hover">
            <thead>
                <th>+++</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Un. Med.</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen</th>
            </thead>
            <tbody>
               
            </tbody>
            <tfoot>
                
            </tfoot>
          </table>
        </div>
      </div>

        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> -->
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->


   <!-- Modal  SERVICIOS -->
  <div class="modal fade" id="myModalserv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 100% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un bien o servicio</h4>
        </div>
        <div class="table-responsive">
          <table id="tblaservicios" class="table table-striped table-bordered table-condensed table-hover" >
            <thead>
                <th>Opciones</th>
                <th>Descripción</th>
                <th>Código</th>
                <th>um</th>
                <th>Precio</th>
                <th>stock </th>
                
                
            </thead>
            <tbody>
               
            </tbody>
            <tfoot>
                <th>Opciones</th>
                <th>Descripción</th>
                <th>Código</th>
                <th>um</th>
                <th>Precio</th>
                <th>stock </th>
                

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
 <div class="modal fade" id="myModalArtItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 65% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione tipo de précio</h4>

           <select class="" id="tipoprecio"  style="background-color: #85d197;" >
          <option value='1' >PRECIO PÚBLICO</option>
          <option value='2' >PRÉCIO POR MAYOR</option>
          <option value='3' >PRÉCIO DISTRIBUIDOR</option>
          </select>

          <button class="btn btn-success" id="refrescartabla" onclick="refrescartabla2()">
            <i class="fa fa-refresh fa-spin fa-1x fa-fw">
            </i>
            <span class="sr-only">
            </span>
            Actualizar
          </button>

          </div>
        <div class="table-responsive">
          <table id="tblarticulositem" name="tblarticulositem"
           class="table table-striped table-bordered  table-hover">
            <thead>
                <th></th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Un. Med.</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen</th>
            </thead>
            <tbody>
               
            </tbody>
            <tfoot>
                
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
              <!-- <iframe border="1" frameborder="1" height="310" width="100%" src="https://e-consulta.sunat.gob.pe/cl-at-ittipcam/tcS01Alias"></iframe> -->
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-ver" data-dismiss="modal" >Cerrar</button>
        </div>        
     </div>
   </div>
  </div>
  <!-- Modal -->


  <input type="hidden" name="idultimocom" id="idultimocom">

  <!-- Modal -->
  <!-- <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 100% !important;" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">COMPROBANTE</h4>
        </div>
        
    <iframe name="modalCom" id="modalCom" border="0" frameborder="0"  width="100%" style="height: 800px;" marginwidth="1" 
    src="">
    </iframe>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>   -->
  <!-- Fin modal -->

  <!-- Modal VISTA PREVIA IMPRESION -->
  <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 100% !important;" >
      <div class="modal-content" >
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">SELECCIONE EL FORMATO DE IMPRESIÓN</h4>
        </div>
            
            <div class="text-center">

          <a onclick="preticket()">
            <div  class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
              <img src="../files/vistaprevia/ticket.jpg">
            </div>
          </a>

          <a onclick="prea42copias()">
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
              <img src="../files/vistaprevia/a42copias.jpg">
            </div>
          </a>

          <a onclick="prea4completo()">
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
              <img src="../files/vistaprevia/a4completo.jpg">
            </div>
          </a>
          <img src="../files/vistaprevia/hoja.jpg"> RECUERDE QUE PUEDE ENVIAR LOS COMPROBANTES POR CORREO. EVITE IMPRIMIR.
          </div>
          


        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->



  <!-- Modal -->
  <div class="modal fade" id="modalPreview2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 95%; height: auto; !important;" >
      <div class="modal-content">
        
        <div class="modal-header" style="display: grid;">
          <h4 class="modal-title">BOLETA ELECTRÓNICA</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <button type="button" class="btn btn-success" onclick="generaryenviarsunat()">Enviar a SUNAT</button>
        </div>
       <input type="hidden" id="idboleta2" name="idboleta2" >
        


    <iframe name="modalCom" id="modalCom" border="0" frameborder="0"  width="100%" style="height: 800px;" marginwidth="1" 
    src="">
    </iframe>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->







  <div class="modal fade" id="modalPreviewticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 95%; height: auto; !important;" >
      <div class="modal-content">
       
        <div class="modal-header" style="display: grid;">
          <h4 class="modal-title">BOLETA ELECTRÓNICA FORMATO TICKET</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <button type="button" class="btn btn-success" onclick="generaryenviarsunat()">Enviar a SUNAT</button>

        </div>
        <input type="hidden" id="idboleta2" name="idboleta2">
<div  class="form-group col-lg-4 col-sm-2 col-md-4">
</div>
    <div  class="form-group col-lg-4 col-sm-8 col-md-6 col-xs-12">
      <div class="printMe">
    <iframe name="modalComticket" id="modalComticket" border="1" frameborder="1"  style="height: 800px; width: 100%; ">
    </iframe>
        </div>
  </div>
  <div  class="form-group col-lg-4 col-sm-2 col-md-4">
</div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> -->
           <!-- <button type="button" id="btnPrint" class="btn btn-primary">Print</button> -->
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
            <input type="number" class="" name="nruc" id="nruc" placeholder="Ingrese RUC o DNI" pattern="([0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]|[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9])" autofocus>
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
                            <select  class=" select-picker" name="tipo_documento" id="tipo_documento" required>                       
                            <option value="6"> RUC </option>
                            </select>
                          </div>

                            <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                              <label>N. Doc.:</label>
                              <input type="text" class="" name="numero_documento3" id="numero_documento3" maxlength="20" 

placeholder="Documento"  onkeypress="return focusRsocial(event, this)"  >
                            </div>

             
                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <label>Razón social:</label>
                            <input type="text" class="" name="razon_social3" id="razon_social3" maxlength="100" placeholder="Razón social" 

required onkeypress="return focusDomi(event, this)">
                            </div>

                            <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label>Domicilio:</label>
                            <input type="text" class="" name="domicilio_fiscal3" id="domicilio_fiscal3" maxlength="100" 

placeholder="Domicilio fiscal" required onkeypress="focustel(event, this)" >
                            </div>

                            <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                              <input type="number" class="" name="telefono1" id="telefono1" maxlength="15" placeholder="Teléfono 1" pattern="([0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]|[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9])" onkeypress="return focusemail(event, this)">
                            </div>

                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="" name="email" id="email" maxlength="50" placeholder="CORREO" required="true" 

onkeypress="return focusguardar(event, this)">
                            </div>

<div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
      <button class="btn btn-primary" type="submit" id="btnguardarncliente" name="btnguardarncliente" value="btnGuardarcliente">
        <i class="fa fa-save"></i> Guardar
      </button>
</div>

    <!--<div class="form-group col-lg-12 col-md-4 col-sm-6 col-xs-12">
    <iframe border="0" frameborder="0" height="450" width="100%" marginwidth="1" 
    src="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias">
    </iframe>
    </div> -->

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
        type: 'POST',
        url: "../ajax/boleta.php?op=consultaDniSunat&nrodni="+numero,
        dataType:'json',
        //data:parametros,

        beforeSend: function(){
        },  
        complete:function(data){
        
        },
        success: function(data){
          $('.before-send').fadeOut(500);
          if(!jQuery.isEmptyObject(data.error)){
            alert(data.error);
          }else{
              
              $("#numero_documento3").val(data.numeroDocumento);
              $('#razon_social').val(data.nombre);
          }
          $.ajaxunblock();
        },
        error: function(data){
            alert("Problemas al tratar de enviar el formulario");
            $.ajaxunblock();
        }
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
  <div class="modal fade" id="modalPreviewXml" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 70% !important;" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">ARCHIVO XML DE BOLETA</h4>
          <a name="bajaxml" id="bajaxml" download><span class="fa fa-font-pencil">DESCARGAR XML </span></a>
        </div>
        
    <iframe name="modalxml" id="modalxml" border="0" frameborder="0"  width="100%" style="height: 800px;" marginwidth="1" 
    src="">
    </iframe>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->




  <!-- Modal  nuevo articulo -->
  <div class="modal fade" id="modalnuevoarticulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 95% !important;" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">NUEVO ARTÍCULO - SOLO PARA UNIDAD</h4>
        </div>
            <form name="formularionarticulo" id="formularionarticulo" method="POST">
                        <div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
                          <label>Almacen</label>
                          <input type="hidden" name="idarticulonuevo" id="idarticulonuevo">
                          <input type="hidden" name="idempresa" id="idempresa" value="<?php echo $_SESSION['idempresa']; ?>">
                           <select  class="form-control" name="idalmacennarticulo" id="idalmacennarticulo" required  data-live-search="true">
                            </select>
                          </div>

                          <div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
                            <label>Categoría</label>
                            <select  class="form-control" name="idfamilianarticulo" id="idfamilianarticulo" required data-live-search="true">
                            </select>
                          </div>


                           <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo</label>
                            <select class="" name="tipoitemnarticulo" id="tipoitemnarticulo"  onchange="focuscodprov()" >
                            <option value="productos" selected="true">PRODUCTO</option>
                              <option value="servicios">SERVICIO</option>
                              </select>
                            </div>

                              
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Descripción / Nombre:</label>
                            <input type="text" class="" name="nombrenarticulo" 
                            id="nombrenarticulo"  placeholder="Nombre"  onkeyup="mayus(this);" 
                            onkeypress=" return limitestockf(event, this)" autofocus="true" 
                            onchange="generarcodigonarti()">
                              </div>


                         <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Stock:</label>
                            <input type="text" class="" name="stocknarticulo" id="stocknarticulo" maxlength="100" placeholder="Stock" required="true" 
                             onkeypress="return NumCheck(event, this)" >
                          </div>



                          <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Precio venta (S/.):</label>
                            <input type="text" class="" name="precioventanarticulo" id="precioventanarticulo" onkeypress="return NumCheck(event, this)" >
                          </div>

                          <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Código:</label>
                            <input type="text" class="" name="codigonarticulonarticulo" id="codigonarticulonarticulo">
                          </div>

                          <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <label>Unidad medida:</label>
                            <select  class="form-control" name="umedidanp" id="umedidanp" required data-live-search="true">
                          </select>
                          </div>


                          <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <label>Descripción:</label>
                            <textarea  id="descripcionnarticulo" name="descripcionnarticulo"  rows="3" cols="70" onkeyup="mayus(this)" onkeypress="return focusDescdet(event, this)"> </textarea> 
                          </div>
        
    

        <div class="modal-footer">
          
          <button class="btn btn-primary" type="submit" id="btnguardarncliente" name="btnguardarncliente" value="btnGuardarcliente">
            <i class="fa fa-save"></i> Guardar
          </button>

          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div> 

        </form>

      </div>
    </div>
  </div>  
  <!-- Fin modal -->


  <!-- Modal nota de pedidos -->
  <div class="modal fade" id="myModalnp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 80% !important; opacity:">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <button class="btn btn-success" id="refrescartablanp" onclick="refrescartablanp()">
            <i class="fa fa-refresh fa-spin fa-1x fa-fw">
            </i>
            <span class="sr-only">
            </span>
            Actualizar
          </button>
          </div>


          <div class="form-group  col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="table-responsive">
          <table id="tblnotapedido" class="table table-striped table-bordered  table-hover nowrap">
            <thead>
                <th>Selecc.</th>
                <th>Nro</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Número NP</th>
                <th>Total</th>
            </thead>
            <tbody>
               
            </tbody>
            <tfoot>
                
            </tfoot>
          </table>
        </div>
      </div>

        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> -->
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->



  <!-- Modal  nuevo articulo -->
  <div class="modal fade" id="Modalduplicar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 40% !important;" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                         
           </div>

          <h4 class="modal-title">INGRESE RANGOS</h4>
        </div>
            <form name="formulariorangos" id="formulariorangos" method="POST">

                          <div class="form-group col-lg-6 col-md-4 col-sm-6 col-xs-12">
                            <label>ID BOLETA 1</label>
                            <input type="text" name="idfactu1" id="idfactu1">
                          </div>

                           <div class="form-group col-lg-6 col-md-4 col-sm-6 col-xs-12">
                            <label>ID BOLETA 2</label>
                            <input type="text" name="idfactu2" id="idfactu2">
                          </div>


                          <div class="form-group col-lg-6 col-md-4 col-sm-6 col-xs-12">
                            <label>SERIE</label>
                            <input type="text" name="serier" id="serier">
                          </div>

     <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <button class="btn btn-primary" type="submit" id="btnguardarnnotificacion" name="btnguardarnnotificacion" value="">
            <i class="fa fa-save"></i> Guardar
          </button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>         
     </div>
                          
        <div class="modal-footer">
        </div> 
        </form>

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
<script type="text/javascript" src="scripts/boleta.js"></script>


<?php 
}
ob_end_flush();
?>