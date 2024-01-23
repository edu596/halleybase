<?php
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
      

      <link rel="stylesheet" href="enviosunat.css">
      <!-- <link rel="stylesheet" media="all" href="../public/css/letter.css" data-turbolinks-track="reload"> -->

      <div class="content-wrapper">   



      



        <!-- Main content -->
        <section class="content">


          <div class="box-header with-border">
                          <h1 class="box-title"> FACTURA-</h1>
                    </div>     
           <button class="sepaiz boton btn btn-danger btn-lg" id="btnagregar" onclick= 'mostrarform(true)'>Nuevo</button> 
<button class="btn btn-success btn-lg" id="refrescartabla" onclick="refrescartabla()">Refrescar</button>

  


            <div class="row">
              <div class="col-md-12">
                  <div class="">


                 



<!-- <a data-toggle="modal" href="#modalpreview"><button class="btn btn-success" id="refrescartabla" > -->
<!-- <span class="sr-only"></span> modal</button></a> -->


   <!--  <button class="btn btn-info" id="btnagregara" onclick= 'mostrarultimocomprobante()'><i class="fa fa-newspaper-o"></i> cargar</button> -->
       
                        
  <!--   OFF <input type="checkbox" name="chk1" id="chk1" onclick="pause()"  data-toggle="tooltip" title="Automatizar envio a SUNAT"> ON -->
                        

                        



<!-- <div class="container">
  <div class="row">
        <a class="btn btn-primary view-pdf" href="../reportes/exFactura.php?id=62">View PDF</a>        
  </div>
</div> -->

                    <!-- /.box-header -->
                    <!-- centro -->

    <div class="table-responsive" id="listadoregistros">
    
  <table id="tbllistado" class="table table-sm table-striped table-bordered table-condensed table-hover dt-responsibe">

                          <thead>

                            <th> Opciones </th>
                            <th>Fecha emisión </th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            
                            <th>Factura</th>
                            <th>Total</th>
                            <th>-</th>
                            <th>-</th>
                            <th>Estado</th>
                            <th>Opciones de envio</th>
                            <th>Pdf/Guia</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          
                        </table>
      </div>


  <div class="panel-body"  id="formularioregistros">
    <form name="formulario" id="formulario" method="POST" autocomplete="off" >



<div class="form-group col-lg-3 col-md-4 col-sm-4 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">SERIE NUMERO</div>
                          <div class="panel-body">

      
     <label>Serie</label>
     <select  class=""  name="serie" id="serie"  onchange="incrementarNum();"  ></select>
         <input type="hidden" name="idnumeracion" id="idnumeracion" >
         <input type="hidden" name="SerieReal" id="SerieReal" >
         <input type="hidden" name="correo" id="correo" >
    

    
    <label>Número</label> <input type="text" style="font-size: 12pt;" name="numero_factura" id="numero_factura" class="" required="true" 
readonly style="font-size: 22px" >
    


              </div>
              </div>
              </div>
              </div>

              <div class="form-group col-lg-3 col-md-4 col-sm-4 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">FECHAS</div>
                          <div class="panel-body">


                            <label>Emisión:</label>
                            <input type="date"   class="" name="fecha_emision" id="fecha_emision" required="true" disabled="true" >
                          
                            <label>vencimiento:</label>
                            <input type="date"  class="" name="fechavenc" id="fechavenc" required="true" >
                          

                  </div>
              </div>
              </div>
              </div>


               <div class="form-group col-lg-3 col-md-4 col-sm-4 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">MONEDA</div>
                          <div class="panel-body">

                            
                           <label>Moneda:</label>
                           <select class="" name="tipo_moneda" id="tipo_moneda" onchange="tipodecambiosunat()">
                             <option value="PEN">PEN</option>
                             <option value="USD">USD</option>
                           </select>
                         
                         
                      
                           <label>T. camb:</label>
                            <input type="text" name="tcambio" id="tcambio" class="" readonly="true" >
                      

                  </div>
              </div>
              </div>
              </div>



              <div class="form-group col-lg-3 col-md-4 col-sm-4 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">TIPO ITEM</div>
                          <div class="panel-body">

                              
                          <label>Tipo de item:</label>
                          <select class="" name="tipofactura" id="tipofactura" onchange="cambiarlistado()" >
                          TIPO DE FACTURA
                          <option value="st">TIPO FACTURA</option>
                          <option value="productos" selected="true">PRODUCTOS</option>
                          <option value="servicios">SERVICIOS</option>

                        </select>
                         

                         
      <label>Vendedor:</label>
       <select class="form-control select-pickert"  data-live-search="true"  name="vendedorsitio" id="vendedorsitio" onchange="focusruccliente()">
       </select>
        



                  </div>
              </div>
              </div>
              </div>




               <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">DATOS DEL CLIENTE</div>
                          <div class="panel-body">


              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <label>Ruc cliente:</label>
               <input type="number" inputmode="decimal" class="" name="numero_documento2" 
               id="numero_documento2" maxlength="11" placeholder="RUC DE CLIENTE-ENTER"   
               onkeypress="agregarClientexRuc(event)" onblur="quitasuge1()" onfocus="focusTest(this)" class="focusNext">
               <div  class="form-control"  id="suggestions">
                </div>
                </div>



                          <div class="col-lg-8 col-md-4 col-sm-4 col-xs-12">
                            <label>Nombre comercial:</label>
                            <input type="text" class="" name="razon_social2" id="razon_social2" required="true"  placeholder="NOMBRE COMERCIAL" onblur="quitasuge2()" onfocus="focusTest(this)" class="focusNext">

                           <div id="suggestions2">
                           </div>
                          </div>


                          <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
                            <label>Domicilio fiscal:</label>
                            <input type="text" class="" name="domicilio_fiscal2" id="domicilio_fiscal2" required="true" placeholder="DIRECCIÓN CLIENTE" class="focusNext">
                          </div>

                          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <label>Correo:</label>
                            <input type="text" class="" name="correocli" id="correocli"   placeholder="CORREO CLIENTE" onkeypress="return focusbotonarticulo(event, this)" onfocus="focusTest(this)" class="focusNext">
                          </div>

                          <div class="col-lg-2 col-sm-4 col-md-4 col-xs-12">
                              <a data-toggle="modal" href="#ModalNcliente">           
                              <button id="btnAgregarCli" type="button" class="btn btn-info btn-lg">
                               Nuevo cliente. <span class="fa fa-user"> </span> 
                              </button>
                            </a>
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

                              <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <label>Nro. Guia:</label>
                          <div class="input-group mb-3">     
                          
                <input type="text" class="" name="guia_remision_29_2" id="guia_remision_29_2" placeholder="Nro de Guía" class="focusNext">
                          

                            <div class="input-group-append" id="DivComprobante">
                            <a data-toggle="modal" href="#myModalGuia" class="btn btn-success">
                              <i class="fa fa-bullseye"></i></a>
                            </div>

                            </div>
                          </div>


                          <div class="col-lg-2 col-sm-6 col-md-2 col-xs-12">
                          <label>Tipo precio:</label>
                          <select class="" id="tipopreciocod">
                            <option value='1' class="focusNext">Precio público</option>
                            <option value='2' >Precio por mayor</option>
                            <option value='3' >Precio distribuidor</option>
                          </select>
                         </div>

                          
                          <div class="col-lg-4 col-sm-12 col-md-6 col-xs-12">
                            <label>Código de barras:</label>
                          <input type="text" name="codigob" id="codigob" class="" onkeypress="agregarArticuloxCodigo(event)" onkeyup="mayus(this);" placeholder="Digite o escanee el código de barras" onblur="quitasuge3()" style="background-color: #F5F589;" class="focusNext">
                          <div id="suggestions3">
                           </div>
                          </div>



                          <div class="col-lg-2 col-sm-12 col-md-12 col-xs-12">
                          <input type="hidden" name="itemno" id="itemno" value="0">
                            <a data-toggle="modal" href="#myModalArt">           
                            <button id="btnAgregarArt" type="button" class="btn btn-info btn-lg" onclick="cambiarlistadoum2()">Artículo o servicio
                            </button>
                            </a>  
                          </div>
              
                        
                        
              
                

                              </div>
              </div>
              </div>
              </div>



               <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">TIPO DE PAGO</div>
                          <div class="panel-body">


                    
                          <label>Tipo de pago:</label>
                         <select class=""  name="tipopago" id="tipopago" onchange="contadocredito()" class="focusNext">
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



                  
                          <label>Tipo impuesto:</label>
                          <select class="form-control" name="nombre_trixbuto_4_p" id="nombre_tributo_4_p" onchange="tributocodnon()">
                          </select>
                  


                    
              <label>Pago tarj.:</label>
                <img src="../files/articulos/tarjetadc.png" data-toggle="tooltip" title="Pago por tarjeta"> <input type="checkbox" name="tarjetadc" id="tarjetadc" 
                onclick="activartarjetadc();">
                <input type="hidden" name="tadc"  id="tadc" >
              


              
                <label>Pago Transf.:</label>
                <img src="../files/articulos/transferencia.png" data-toggle="tooltip" title="Pago por transferencia"> <input type="checkbox" name="transferencia" id="transferencia" 
                onclick="activartransferencia();">
                <input type="hidden" name="trans"  id="trans" >
              



                                </div>
              </div>
              </div>
              </div>



                 <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">OTROS IMPUESTOS</div>
                          <div class="panel-body">


            
                <label>Reten:</label>
                <!-- <img src="../files/articulos/retencion.png" data-toggle="tooltip" title="Aplicar retención"> -->
                <input type="checkbox" name="retencion" id="retencion" 
                onclick="activarReten();">
                <input type="hidden" name="rete"  id="rete" >
            


      
              <label>%:</label>
                <input type="text" name="porcret"  id="porcret" value="3" >
      

      
              <label>Tipo:</label>
                <select id="tiporete" name="tiporete">
                  <option value="62">RIGV</option>
                  <option value="63">R2CAT</option>
                </select>
      

      
              <label>Valor:</label>
                <input type="text" id="valorrete" name="valorrete" >
      

      
                  <label>Precio o valor unitario :</label>
                Precio<input type="checkbox" name="vuniigv" id="vuniigv" onclick="modificarSubototales()"  data-toggle="tooltip" title="">Valor u.
      




                  </div>
              </div>
              </div>
              </div>



<!--Campos para guardar comprobante Factura-->
    <input type="hidden" name="idfactura" id="idfactura" >
    <input type="hidden" name="unidadMedida" id="unidadMedida" value="original" >

    <input type="hidden" name="firma_digital" id="firma_digital"  value="">

    <!--Datos de empresa Estrella-->
    <input type="hidden" name="idempresa" id="idempresa" value="<?php echo $_SESSION['idempresa'] ;     ?>">
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
      <input type="hidden" name="codigo_tributo_h" id="codigo_tributo_h" >
      <input type="hidden" name="nombre_tributo_h" id="nombre_tributo_h" >
      <input type="hidden" name="codigo_internacional_5" id="codigo_internacional_5" value="">
      <!-- <input type="hidden" name="iva" id="iva" value="<?php $_SESSION['iva']; ?>"> -->
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
    <input type="hidden" name="afectacion_igv_3" id="afectacion_igv_3"  value="" >
    <input type="hidden" name="afectacion_igv_4" id="afectacion_igv_4" value="" >
    <input type="hidden" name="afectacion_igv_5" id="afectacion_igv_5" value="" >
    <input type="hidden" name="afectacion_igv_6" id="afectacion_igv_6" value="">
    <input type="hidden" name="hora" id="hora">

    <input type="hidden" name="iglobal" id="iglobal"> 
<!--DETALLE-->


<input type="hidden" name="envioauto" id="envioauto" value="<?php  echo $_SESSION['envioauto']; ?>"> 
                        
                         <!--  <div class="form-group  col-lg-1 col-sm-2 col-md-2 col-xs-12">
                          <img src="../public/images/scaner.png">
                          </div>   -->

            <div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-12">
                

                         <!--  <div class="form-group  col-lg-2 col-sm-12 col-md-12 col-xs-12">
                            <a data-toggle="modal" href="#myModalnp">           
                               <button id="btnAgregarArt" type="button" class="btn btn-success btn-sm" onclick="cambiarlistadoum()">Nota Pedido</button>
                            </a>
                          </div> -->
            </div>




      

       




                  

                        <div class="form-group  col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        
                          <div class="table-responsive">
                            <table id="detalles" class="table table-striped table-hover table-bordered" >
                      <thead>

                                    <th >Sup.</th>
                                    <th >Item</th>
                                    <th >Artículo</th>
                                    <!-- <th >Trib.</th>
                                    <th>Afec.</th> -->
                                    <th >Descripción</th>
                                    <th >Cantidad</th>
                                    <th>Dcto. %</th>
                                    
                                    <th >Cód.</th>
                                    <!-- <th style="visibility: hidden;" >-</th> -->
                                    <th >U.M.</th>
                                    <th >Prec. u.</th>
                                    <th >Val. u.</th>
                                    <th >Stock</th>

                                    <th>Importe</th>
                                    
                      </thead>






                              <tfoot style="vertical-align: center;">
                                <!--SUBTOTAL-->
                                     <tr>
                          <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>
                          </td>
                                    <th style="font-weight: bold;  background-color:#A5E393;">Subtotal de venta </th>
                                    <th style="font-weight: bold; background-color:#A5E393;">
                                    <h4 id="subtotal">0.00</h4></th>
                                    </td>
                                    </tr> 
                                    <!--DCTO-->
                                     <tr>
                          <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                    <th style="font-weight: bold;  background-color:#A5E393;">Descuentos</th>
                                    <th style="font-weight: bold; background-color:#A5E393;">
                                    <h4 id="tdescuentoL">0.00</h4> </th>
                                    </td>
                                    </tr> 
                                <!--IGV-->
                           <tr>
                            <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">igv 18% </th>
                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">
                                    <h4 id="igv_">0.00</h4>
                                    </th>
                                    </td>
                                    </tr> 
                                    <!--ICBPER-->
                                    <tr>
                                 <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">ICBPER </th>
                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">
                                      <h4 id="icbper">0</h4>

                                    </th>
                                    </td>
                                    </tr> 



                                     <!--OTROS-->
                                    <tr>
                                 <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">OTROS </th>
                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">
                                    <input type="text"  id="otroscargos" name="otroscargos"   onchange="modificarSubototales();" disabled value="0.00">
                                    </th>
                                    </td>
                                    </tr> 



                             <!--TOTAL-->       
                          <tr><td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                               <th style="font-weight: bold; vertical-align: center; background-color:#A5E393;">Importe total </th> <!--Datos de impuestos-->  <!--IGV-->
                               <th style="font-weight: bold; background-color:#A5E393;">

                                 <!-- <h4 id="total" style="font-weight: bold; vertical-align: center; background-color:#A5E393;">0.00</h4> -->

                                 <input type="text" name="totalcaja" id="totalcaja"  OnFocus="focusTest(this);" onChange="modificarSubototales(1);"  readonly>




                    <input type="hidden" name="total_final" id="total_final">
                    <input type="hidden" name="subtotal_factura" id="subtotal_factura"> 
                    <input type="hidden" name="total_igv" id="total_igv">
                    <input type="hidden" name="total_icbper" id="total_icbper">
                    <input type="hidden" name="total_dcto" id="total_dcto">
                    <input type="hidden" name="pre_v_u" id="pre_v_u"><!--Datos de impuestos-->  <!--TOTAL-->

                    <input type="hidden" name="ipagado_final" id="ipagado_final"><!--Datos de impuestos-->  <!--TOTAL-->
                    <input type="hidden" name="saldo_final" id="saldo_final"></th><!--Datos de impuestos-->  <!--TOTAL-->




                                    </td>
                                    </tr>

                                     <tr>
                            <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                              <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">Total pagado </th>
                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">
                                      <h4 id="ipagado">0.00</h4>
                                    </th>
                                    </td>
                                    </tr> 

                                    <tr>
                            <td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                               <!-- <div id="column_center" class="col-xs-12 col-lg-6"> -->
                                    <th  style="font-weight: bold; vertical-align: center; background-color:#A5E393;">Saldo / vuelto </th>
                                    <th style="font-weight: bold; background-color:#A5E393; vertical-align: center;">
                                      <h4 id="saldo">0.00</h4>
                                    </th>

    <!-- <div class="my-fixed-item">
              <h3 id="subtotalflotante" style="font-weight: bold; background-color:#A5E393;">0.00</h3>    
               <h3 id="igvflotante" style="font-weight: bold; vertical-align: center; background-color:#A5E393;">0.00</h3>    
               <h3 id="totalflotante" style="font-weight: bold; vertical-align: center; background-color:#A5E393;">0.00</h3>
        <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar" data-toggle="tooltip" title="Guardar factura" >
               <i class="fa fa-save"></i> Guardar
            </button>
            <button id="btnCancelar" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Cancelar" onclick="cancelarform()" 
                type="button"><i class="fa fa-arrow-circle-left"> Cancelar</i>
            </button>
     </div> -->

                                    </td>
                                    </tr> 
                                </tfoot>
                                <tbody>
                                </tbody>

                                
                            </table>

                          </div>



    <!-- <div class="form-group  col-lg-6 col-sm-2 col-md-2 col-xs-12">
              <label>Pago rápido S/.</label>
                <button  type="button"   value="1" name="botonpago1" id="botonpago1"   class="btn btn-success btn-sm" onclick="botonrapido1()">1</button>
                <button  type="button" value="2" name="botonpago2" id="botonpago2" class="btn btn-success btn-sm" onclick="botonrapido2()" >2</button>
                <button value="5"  type="button" name="botonpago5" id="botonpago5" class="btn btn-success btn-sm" onclick="botonrapido5()">5</button>
                <button value="10"  type="button" name="botonpago10" id="botonpago10"  class="btn btn-success btn-sm" onclick="botonrapido10()">10</button>
                <button value="20" name="botonpago20"  type="button" id="botonpago20" class="btn btn-success btn-sm" onclick="botonrapido20()">20</button>
                <button  type="button"  value="50" name="botonpago50"  type="button" id="botonpago50"  class="btn btn-success btn-sm" onclick="botonrapido50()" >50</button>
                <button value="100" name="botonpago100" id="botonpago100" type="button" class="btn btn-success btn-sm" onclick="botonrapido100()">100</button>
                <button value="200" name="botonpago200" id="botonpago200" type="button" class="btn btn-success btn-sm" onclick="botonrapido200()">200</button>
           </div> -->

                          
 


  <div class="form-group  col-lg-6 col-sm-6 col-md-6 col-xs-12">
  <button class="btn btn-primary btn-lg " type="submit" id="btnGuardar" data-toggle="tooltip" title="Guardar factura" >
    <i class="fa fa-save"></i> Guardar</button>
  
    <button id="btnCancelar" class="btn btn-danger btn-lg" data-toggle="tooltip" title="Cancelar" onclick="cancelarform()"
type="button">
Cancelar
</button>

                          </div>

                        </div>


<!-- Modal -->
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
  <div class="modal fade" id="modalTcambio">
    <div class="modal-dialog" style="width: 100% !important;">
      <div class="modal-content">
          <div class="modal-header">
        </div>
          <!-- <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <iframe border="0" frameborder="0" height="310" width="100%" src="https://e-consulta.sunat.gob.pe/cl-at-ittipcam/tcS01Alias"></iframe>
          </div> -->
          <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-ver" data-dismiss="modal" >Cerrar</button>
        </div>        
     </div>
   </div>
  </div>

   <!-- FIN Modal -->
 
  
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

             <td align="center"><a onclick="cargarbien()" name="tipoitem" id="tipoitem" value="bien"><img src="../public/images/producto.png"><br>Productos</a></td>
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
                            <input type="text" class="" name="razon_social" id="razon_social" maxlength="100" placeholder="Razón social" 

required onkeypress="return focusDomi(event, this)">
                            </div>


                            <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label>Domicilio:</label>
                            <input type="text" class="" name="domicilio_fiscal" id="domicilio_fiscal"  placeholder="Domicilio fiscal" required onkeypress="focustel(event, this)" >
                            </div>

                          <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            <label>Dep.:</label>
                            <input type="text" class="" name="iddepartamento" id="iddepartamento" onchange="llenarCiudad()">
                            
                            </div>

                            <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            <label>Ciud.:</label>
                            <input type="text" class="" name="idciudad" id="idciudad" onchange="llenarDistrito()" >                       
                            
                            </div>
                          
                             <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            <label>Dist.:</label>
                            <input type="text" class="" name="iddistrito" id="iddistrito">                    

                            </div>

                            <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                              <label>Telefono.:</label>
            <input type="number" class="" name="telefono1" id="telefono1" maxlength="15" placeholder="Teléfono 1" 
pattern="([0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]|[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9])" onkeypress="return focusemail(event, 

this)">
                            </div>

            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
              <label>correo.:</label>
        <input type="text" class="" name="email" id="email" maxlength="50" placeholder="CORREO" onkeypress="return focusguardar(event, this)">
               </div>

               <input type="hidden" name="ubigeocli" id="ubigeocli" >

<div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">

      <button class="btn btn-primary" type="submit" id="btnguardarncliente" name="btnguardarncliente" value="btnGuardarcliente">
        <i class="fa fa-save"></i> Guardar
      </button>
</div>

    <!--<div class="form-group col-lg-12 col-md-4 col-sm-6 col-xs-12">
    <iframe border="0" frameborder="0" height="450" width="100%" marginwidth="1" 
    src="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias">
    </iframe>
    </div>   -->

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

                  //         $.ajax({
                  //         data: { "nruc" : $("#nruc").val() },
                  //         type: "POST",
                  //         dataType: "json",
                  //         url: "../ajax/consultasunat.php",
                  //       }).done(function( data, textStatus, jqXHR ){

                  //         if(data['success']!="false" && data['success']!=false)
                  //         {

                  //           if(typeof(data['result'])!='undefined')
                  //           {
                  //             $("#tbody").html("");
                  //             $("#numero_documento3").val(data.result.RUC);
                  //             $("#razon_social").val(data.result.RazonSocial);
                  //             $("#domicilio_fiscal").val(data.result.Direccion);
                  //             $("#telefono1").css("background-color","#D1F2EB");
                  //             $("#email").css("background-color","#D1F2EB");
                  //             $("#telefono1").focus();
                  //           }

                  //           $("#error").hide();
                  //           $(".result").show();
                          
                  //         }
                  //         else
                  //         {

                  //           if(typeof(data['msg'])!='undefined')
                  //           {
                  //             alert( data['msg'] );
                  //           }
                  //           $("#nruc").focus();
                                          
                  //         }
                  //       }).fail(function( jqXHR, textStatus, errorThrown ){
                  //         alert( "Solicitud fallida:" + textStatus );
                  //         $this.button('reset');
                  //         $.ajaxblock();
                  // });

//============== original ===========================================================


  //var numero = $('#nruc').val(), url_s = "consulta.php",parametros = {'dni':numero};
  var numero = $('#nruc').val(),
  //url_s = "https://incared.com/api/apirest";
  url_s = "../ajax/factura.php?op=consultaRucSunat&nroucc="+numero;
  parametros = {'action':'getnumero','numero':numero}
  
  if (numero == '') {
    alert("El campo documento esta vacio ");
    $.ajaxunblock();
  }else{
    $.ajax({
        type: 'POST',
        url: url_s,
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
              $('#domicilio_fiscal').val(data.direccion);
              $('#iddistrito').val(data.distrito);
              $('#idciudad').val(data.provincia);
              $('#iddepartamento').val(data.departamento);
              $('#ubigeocli').val(data.ubigeo);
          }
          $.ajaxunblock();
        },
        error: function(data){
            alert("Problemas al tratar de enviar el formulario");
            $.ajaxunblock();
        }
    }); 
  }

document.getElementById("btnguardarncliente").focus();
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





  <!-- Modal  SERVICIOS -->
  <div class="modal fade" id="myModalserv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 100% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un bien o servicio</h4>
          <button class="btn btn-success" id="refrescartabla" onclick="refrescartabla()"><i class="fa fa-refresh fa-spin fa-1x fa-fw"></i>
            <span class="sr-only"></span> Refrescar</button>
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
  <div class="modal fade" id="myModalArt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 100%  !important; opacity: 5;">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        
          <div class="form-group  col-lg-4 col-sm-12 col-md-12 col-xs-12">
                <h4 class="modal-title">Seleccione el tipo de precio</h4>
                 <select class="" id="tipoprecio"  onchange="listarArticulos()" >
                <option value='1' >PRECIO PÚBLICO</option>
                <option value='2' >PRÉCIO POR MAYOR</option>
                <option value='3' >PRÉCIO DISTRIBUIDOR</option>
                </select>

              </div>

              <div class="form-group  col-lg-4 col-sm-12 col-md-12 col-xs-12">
                <h4 class="modal-title">Seleccione almacen</h4>
                <select class="" id="almacenlista"  onchange="listarArticulos()" >
                </select>
              </div>

        

      
          <button class="btn btn-success" id="refrescartabla" onclick="refrescartabla()">
            <span class="sr-only"></span>Actualizar</button>


            <button class="btn btn-danger" id="refrescartabla" onclick="nuevoarticulo()">
            <span class="sr-only"></span>Nuevo artículo</button>

    </div>

<div class="form-group  col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="table-responsive">
        <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover" >
            <thead>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Descripción</th>
                <th>Precio sistema</th>
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
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->





 <!-- Modal -->
  <div class="modal fade" id="myModalGuia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 100%  !important; opacity: 5;">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>

<div class="form-group  col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="table-responsive">
          <table id="tblguias" class="table table-striped table-bordered table-condensed table-hover" >
            <thead>
                <th>Seleccionar</th>
                <th>Número Guia</th>
                <th>Fecha</th>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->







<input type="hidden" name="idultimocom" id="idultimocom">








  <!-- Modal VISTA PREVIA IMPRESION -->
  <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 90% !important;" >
      <div class="modal-content" >
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">SELECCIONE EL FORMATO DE IMPRESIÓN</h4>
        </div>
            
        <div class="text-center">

          <a onclick="preticket()">
            <div  class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
              <img src="../files/vistaprevia/ticket.jpg" >
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

          
          
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              ENVIAR POR CORREO FACTURA N°: <h3 style="" id="ultimocomprobante"> </h3> AL CORREO: <h3 style="" id="ultimocomprobantecorreo"></h3>
              <a onclick="enviarcorreoprew()">
              <img src="../public/images/mail.png"> 
              </a>
              </div>
        <button class="btn btn-info" name="estadoenvio" id="estadoenvio" value="ESTADO ENVIO A SUNAT" onclick="estadoenvio()">Estado envio</button> 
        <h3 id="estadofact">Documento emitido</h3>

              <h3 id="estadofact2" style="color: red;"> Recuerde que para enviar por correo debe hacer la vista previa para que se generen los archivos PDF.</h3>

               <h4>Recuerde que puede enviar los comprobantes por correo. Cuide el planeta.</h4> <img src="../files/vistaprevia/hoja.jpg">
          
          </div>
          


        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" >Cerrar</button>
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
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <button type="button" class="btn btn-success" onclick="generaryenviarsunat()">Enviar a SUNAT</button>
          <h4 class="modal-title">FACTURA ELECTRÓNICA</h4>
        </div>
        <input type="hidden" id="idfactura2" name="idfactura2" >
        
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







    <!-- Modal -->
  <div class="modal fade" id="modalPreviewticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 95%; height: auto; !important;" >
      <div class="modal-content">
        <div class="modal-header" style="display: grid;">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <button type="button" class="btn btn-success" onclick="generaryenviarsunat()">Enviar a SUNAT</button>
        </div>
          <input type="hidden" id="idboleta2" name="idboleta2">
         <div  class="form-group col-lg-4 col-sm-2 col-md-4">
</div>
        
      <div  class="form-group col-lg-4 col-sm-8 col-md-6 col-xs-12">
    <iframe name="modalComticket" id="modalComticket" border="1" frameborder="1"  style="height: 800px; width: 100%; ">
    </iframe>
        </div>

     <div  class="form-group col-lg-4 col-sm-2 col-md-4">
</div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->





 


 <!-- Modal COMPLETAR COMPRA -->
 <div class="modal fade" id="modalcompletar"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 50% !important;" >
      <div class="modal-content">
        <div class="modal-header">

          <h2 class="text-center">Completar</h2>       
          <div class="large-9 columns" >
            
        
      <h4 class="text-center">Medio de pago</h4>

      <div class="callout columns border-green">
      <div  class="large-6 columns">
        <label >Tipo</label>

        <select name="000" id="000"><option value="26814">EFECTIVO</option>
              <option value="26815">TARJETA DÉBITO</option>
              <option value="26816">TARJETA CRÉDITO</option>
              <option value="26817">DEPÓSITO</option>
              <option value="26818">GIRO</option>
              <option value="26819">CHEQUE</option>
              <option value="26820">CUPÓN</option>
              <option value="26821">PAYPAL</option>
              <option value="26822">CRÉDITO - POR PAGAR</option>
              <option value="26823">OTROS</option>
        </select>

 
      
        <label for="invoice_payments_attributes_0_importe">Importe</label>
        <input class="" type="text"  id="invoice_payments_attributes_0_importe">
      
      
        <label for="invoice_payments_attributes_0_nota">Nota</label>
        <input class="" type="text"id="invoice_payments_attributes_0_nota">
      
      
        <!-- <label for="nil"><br></label>
        <span class="postfix"><input type="hidden" name="invoice[payments_attributes][0][_destroy]" id="invoice_payments_attributes_0__destroy" value="false"><a class="button tiny alert expanded remove_fields dynamic" href="#"><i class="fa fa-trash"></i></a></span> 
      </div> -->
      </div>

</div>
      </div  >    
          <div class="large-3 columns">
            <div class="text-center">
              <div>Pago rápido</div>
              <i class="fa fa-arrow-down"></i>
            </div>
            <div class="stacked button-group">
              
              <a href="#" class="button tiny bold secondary quick-cash" quick-cash="invoice_payments_attributes_0_importe">
                <spa class="current_currency">S/</spa>
                <span class="value">1</span>
              </a>
              <a href="#" class="button tiny bold secondary quick-cash" quick-cash="invoice_payments_attributes_0_importe">
                <spa class="current_currency">S/</spa>
                <span class="value">2</span>
              </a>
              <a href="#" class="button tiny bold secondary quick-cash" quick-cash="invoice_payments_attributes_0_importe">
                <spa class="current_currency">S/</spa>
                <span class="value">5</span>
              </a>
              <a href="#" class="button tiny bold secondary quick-cash" quick-cash="invoice_payments_attributes_0_importe">
                <spa class="current_currency">S/</spa>
                <span class="value">10</span>
              </a>
              <a href="#" class="button tiny bold secondary quick-cash" quick-cash="invoice_payments_attributes_0_importe">
                <spa class="current_currency">S/</spa>
                <span class="value">20</span>
              </a>
              <a href="#" class="button tiny bold secondary quick-cash" quick-cash="invoice_payments_attributes_0_importe">
                <spa class="current_currency">S/</spa>
                <span class="value">50</span>
              </a>
              <a href="#" class="button tiny bold secondary quick-cash" quick-cash="invoice_payments_attributes_0_importe">
                <spa class="current_currency">S/</spa>
                <span class="value">100</span>
              </a>
              <a href="#" class="button tiny bold secondary quick-cash" quick-cash="invoice_payments_attributes_0_importe">
                <spa class="current_currency">S/</spa>
                <span class="value">200</span>
              </a>
              <a href="#" class="button tiny bold alert clean">
                <spa class=""></spa>
                <span class="">Limpiar</span>
              </a>
            </div>
          </div>
      </div>
          <div class="large-12 columns">
            <div class="callout columns border-green">
              <div class="large-4 columns">
                <label for="invoice_importe_total">Importa TOTAL</label>
                <input type="text" name="importe_total" id="pizza_importe_total" readonly="readonly">
              </div>
              <div class="large-4 columns">
                <label for="invoice_importe_pagado">Importe TOTAL pagado</label>
                <input id="pizza_importe_pagado" readonly="readonly" type="text" name="invoice[importe_pagado]">
              </div>
              <div class="large-4 columns">
                <label for="invoice_diferencia_vuelto">Diferencia (vuelto)</label>
                <input id="pizza_diferencia_vuelto" readonly="readonly" type="text" name="invoice[diferencia_vuelto]">
              </div>
            </div>
          </div>
          <div class="">
            <input type="submit" name="commit" value="Crear Comprobante" class="button large expanded" data-disable-with="Enviando..." data-confirm="Confirmar que deseas generar este documento">
          </div>
          
          <div class="margin-top text-center">
            <a class="button warning" data-close="">Cerrar</a>
          </div>
          
          <button class="close-button large" type="button" data-close="">
            <span aria-hidden="true">×</span>
          </button>
   
    

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
          <h4 class="modal-title">ARCHIVO XML DE FACTURA</h4>
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
    <div class="modal-dialog modal-lg" style="width: 70% !important;" >
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
                           <select  class="" name="idalmacennarticulo" id="idalmacennarticulo" required  data-live-search="true">
                            </select>
                          </div>

                          <div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
                            <label>Categoría</label>
                            <select  class="" name="idfamilianarticulo" id="idfamilianarticulo" required data-live-search="true">
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
                            <input type="text" class=" focus" name="nombrenarticulo" 
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
                            <select  class="" name="umedidanp" id="umedidanp" required data-live-search="true">
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




  <!-- Modal  nuevo articulo -->
  <div class="modal fade" id="ModalNnotificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 40% !important;" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
                         <!-- <img src="../public/images/notifi.png" height="35px"> -->
           </div>

          <h4 class="modal-title">NUEVA NOTIFICACIÓN</h4>
        </div>
            <form name="formularionnotificacion" id="formularionnotificacion" method="POST">

                        <!-- <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                          <label>CÓDIGO</label>
                          <input type="hidden" name="idnotificacion" id="idnotificacion">
                           <input type="text" name="codigonotificacion" id="codigonotificacion">
                          </div> -->



                          <div class="form-group col-lg-6 col-md-4 col-sm-6 col-xs-12">
                            <label>Nombre</label>
                            <input type="text" name="nombrenotificacion" id="nombrenotificacion">
                          </div>


                           <div class="form-group col-lg-6 col-md-4 col-sm-6 col-xs-12">
                            <label>Fecha notificación</label>
                            <input type="date" name="fechaaviso" id="fechaaviso" class="">
                            <input type="date" name="fechacreacion" id="fechacreacion" class="" style="visibility: hidden;">
                            </div>

                          <div class="form-group col-lg-6 col-md-4 col-sm-6 col-xs-12">
                            <label>Cliente</label>
                            <input type="hidden" name="idclientenoti" id="idclientenoti">
                            <input type="hidden" name="tipo_documento_noti" id="tipo_documento_noti" value="01">
                            <h3 id="clinoti"></h3>
                          </div>

                           <div class="form-group col-lg-6 col-md-4 col-sm-6 col-xs-12">
                            <label>Documento</label>
                            <h3>FACTURA</h3>
                          </div>

                              
                              <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <label>Continua</label>
                            NO <input type="checkbox" name="continuo" id="continuo" onclick="continuoNoti();"> SI
                            <input type="hidden" name="selconti" id="selconti">
                              </div>

                              <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <label>Activa</label>
                            NO <input type="checkbox" name="estadonoti" id="estadonoti" onclick="estadoNoti();"> SI
                            <input type="hidden" name="selestado" id="selestado">
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





  <!-- Modal  nuevo rangos -->
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
                            <label>ID FACTURA 1</label>
                            <input type="text" name="idfactu1" id="idfactu1">
                          </div>

                           <div class="form-group col-lg-6 col-md-4 col-sm-6 col-xs-12">
                            <label>ID FACTURA 2</label>
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








   <!-- Modal nota de pedidos -->
  <div class="modal fade" id="myModalnp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 50% !important; opacity: ;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>


          <div class="form-group  col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="table-responsive">
          <table id="tblnotapedido" class="table table-striped table-bordered  table-hover nowrap">
            <thead>
                <th>Selecc.</th>
                <th>Fechabre</th>
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


  <!-- Modal  nueva guia -->
  <div class="modal fade" id="ModalNuevaGuia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 80% !important;" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
            <h4 class="modal-title">NUEVA GUIA</h4>

         
        </div>
            <form name="formularioguia" id="formularioguia" method="POST" onkeypress="">



              <input type="hidden" name="contaedit" id="contaedit">
    <div class="form-group col-lg-12 col-md-6 col-sm-4 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">NÚMERO, SERIE, FECHAS</div>
                          <div class="panel-body">

              <div   class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                   <label >SERIE</label>
                   <input type="hidden" name="idguia" id="idguia">
                    <select class="form-control" name="serie" id="serie" onchange="incrementarNum()" tabindex="1" >
                    </select>
                       <input type="hidden" name="idnumeracion" id="idnumeracion" >
                       <input type="hidden" name="SerieRealGuia" id="SerieReal" >
                   </div> 


        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
            <label>NÚMERO</label>
          <input type="text" name="numero_guia" id="numero_guia" class="form-control" required="true" readonly tabindex="2">
          </div>


             <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                <label>Fecha emisión:</label>
           <input type="date"  style="font-size: 12pt;"  class="form-control" name="fecha_emision_guia" id="fecha_emision_guia" required="true" tabindex="3" readonly="true">
          </div>

                          <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                            <label>Fecha inicio traslado:</label>
                        <input type="date"  style="font-size: 12pt;"  class="form-control" name="fechatraslado" id="fechatraslado" required="true"  class="form-control" tabindex="4" >
                          </div>



              <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                      <label>Motivo traslado:</label>
                        <select name="motivo" id="motivo" class="form-control" tabindex="5">
                          <option value="01">VENTA </option>
                          <option value="14">VENTA SUJETA A CONFIRMACION DEL COMPRADOR </option>
                          <option value="02">COMPRA </option>
                          <option value="04">TRASLADO ENTRE ESTABLECIMIENTOS DE LA MISMA EMPRESA </option>
                          <option value="18">TRASLADO EMISOR ITINERANTE CP </option>
                          <option value="08">IMPORTACION </option>
                          <option value="09">EXPORTACION </option>
                          <option value="19">TRASLADO A ZONA PRIMARIA </option>
                          <option value="13">OTROS </option>
                        </select>

                      </div>



                      <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                             <label>Tipo transporte:</label> 
                             <select id="codtipotras" name="codtipotras" tabindex="6" class="form-control" onchange="tipotrans()">
                               <option value="01" selected="true">TRANSPORTE PÚBLICO</option>
                               <option value="02">TRANSPORTE PRIVADO</option>
                             </select>

                         </div>






                  </div>
              </div>
              </div>
              </div>



               <div class="form-group col-lg-12 col-md-6 col-sm-4 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">DATOS DE INICIO DE TRASLADO</div>
                          <div class="panel-body">


                  <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                      <label>Comprobante:</label>
                        <select name="tipocomprobante" id="tipocomprobante" class="form-control" onchange="boletafactura()" tabindex="7" readonly>
                          <option value="01">FACTURA </option>
                          <option value="03">BOLETA</option>
                          <option value="04">DESDE ARTÍCULOS</option>
                        </select>
                      </div>


                  
                      <div id="datosorigen">

                      <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                             <label>Destinatario:</label> 

                    
            <input type="text" class="form-control" name="destinatario" id="destinatario" maxlength="100" 
                             placeholder=""  onkeypress="mayus(this);" tabindex="8" readonly="true">
              <div  class=""  id="suggestions">
                </div>

                         </div>



                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                             <label>RUC:</label> 
                  <input type="text" class="form-control" name="nrucguia" id="nrucguia" maxlength="11" placeholder=""  onkeypress="return NumCheck(event,this)" tabindex="9" readonly="true">
                         </div>

                         </div>
              </div>
              </div>
              </div>
              </div>


               <div class="form-group col-lg-12 col-md-6 col-sm-4 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">  DATOS DEL PUNTO DE PARTIDA Y LLEGADA & OTROS DATOS</div>
                          <div class="panel-body">


                          <div class="col-lg-10 col-md-4 col-sm-6 col-xs-12">
                             <label>Dirección punto de partida:</label> 
                <input type="text" class="form-control" name="ppartida" id="ppartida"  placeholder=""  required="true" value="" onkeyup="mayus(this);" tabindex="13" readonly="true">
                           </div>



              
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                       <label>Ubigeo partida:</label>
                    <input type="text" name="ubigeopartida" id="ubigeopartida" onblur="quitasuge()" tabindex="14" class="form-control" readonly="true"> 
                    <div  class=""  id="suggestionsub1"></div>
                </div>


                <div class="col-lg-10 col-md-4 col-sm-6 col-xs-12">
                             <label>Dirección punto de llegada:</label> 
                             <input type="text" class="form-control" name="pllegada" id="pllegada"  placeholder=""  required="true" onkeyup="mayus(this);" tabindex="15" >

                           </div>

                        

                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                       <label>Ubigeo llegada:</label>
                    <input type="text" name="ubigeollegada" id="ubigeollegada"  tabindex="16" class="form-control">
                    <div  class=""  id="suggestionsub2"></div>
                </div>



                  </div>
              </div>
              </div>
              </div>



               <div class="form-group col-lg-12 col-md-6 col-sm-4 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">OBSERVACIONES </div>
                          <div class="panel-body">

                  <div class="col-lg-12 col-md-4 col-sm-6 col-xs-12">
                             <label>Observaciones:</label> 
                      <textarea id="observaciones"  rows="1" cols="7"  name="observaciones" tabindex="17" class="form-control"></textarea>
                         </div>



                              </div>
              </div>
              </div>
              </div>


              <div class="form-group col-lg-12 col-md-6 col-sm-4 col-xs-12 img-rounded" id="datostransp" style="display: none">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">DATOS DEL TRANSPORTISTA </div>
                          <div class="panel-body">


                             
                   <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                             <label>Tipo :</label> 
                             <select  class="form-control" id="tipodoctrans" name="tipodoctrans" tabindex="10">
                               <option value="01" selected="true">DNI</option>
                               <option value="06" selected="true">RUC</option>
                             </select>

                         </div>


                          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                             <label>Ruc transp. :</label> 
                             <input type="text" class="form-control" name="ructran" id="ructran"  placeholder=""   onkeypress="mayus(this);"  maxlength="11" tabindex="11" style="background-color: #f4ff91" >
                         </div>

                           <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                             <label>Razón social transportista :</label> 
                             <input type="text" class="form-control" name="rsocialtransportista" id="rsocialtransportista" maxlength="100" placeholder=""   onkeyup="mayus(this);" tabindex="12" style="background-color: #f4ff91">
                         </div>



                  </div>
              </div>
              </div>
              </div>





               <div class="form-group col-lg-12 col-md-6 col-sm-4 col-xs-12 img-rounded" id="datosconduc"  style="display: none">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">DATOS CONDUCTOR</div>
                          <div class="panel-body">


          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                             <label>DNI conductor:</label> 
                             <input type="text" class="form-control" name="dniconduc" id="dniconduc"  placeholder="DNI CONDUCTOR" tabindex="18" style="background-color: #f4ff91">
                         </div>


                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                             <label>Nombre coductor:</label> 
                             <input type="text" class="form-control" name="ncoductor" id="ncoductor"  placeholder=""   onkeyup="mayus(this);" tabindex="19"  style="background-color: #f4ff91">
                         </div>

                          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                             <label>Nro de licencia:</label> 
                             <input type="text" class="form-control" name="nlicencia" id="nlicencia"  placeholder=""   onkeyup="mayus(this);" tabindex="20" style="background-color: #f4ff91" >

                         </div>


                              </div>
              </div>
              </div>
              </div>





              <div class="form-group col-lg-12 col-md-6 col-sm-4 col-xs-12 img-rounded" id="datosvehi" style="display: none">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">DATOS VEHÍCULO</div>
                          <div class="panel-body">




                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                             <label>Marca:</label> 
                             <input type="text" class="form-control" name="marca" id="marca"  onkeyup="mayus(this);" tabindex="21"  style="background-color: #f4ff91">
                         </div>



                         <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                             <label>Placa:</label> 
                             <input type="text" class="form-control" name="placa" id="placa"  onkeyup="mayus(this);" tabindex="22"   style="background-color: #f4ff91">
                         </div>


                         <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                             <label>Constancia de inscr.:</label> 
                             <input type="text" class="form-control" name="cinc" id="cinc"   onkeyup="mayus(this);"  tabindex="23"  style="background-color: #f4ff91">
                         </div>




                              </div>
              </div>
              </div>
              </div>



               <div class="form-group col-lg-12 col-md-6 col-sm-4 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">MEDIDAS Y PESO</div>
                          <div class="panel-body">



                          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                             <label>Container:</label> 
                             <input type="text" class="form-control" name="container" id="container"  placeholder=""   onkeyup="mayus(this);" tabindex="24" >

                         </div>


                           


                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                             <label>U. M. P. bruto:</label> 
                        <select  class="form-control" name="umedidapbruto" id="umedidapbruto"   tabindex="25" >
                            <option value="mtr">Metros</option>

                          </select>

                         </div>



                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                             <label>Peso bruto:</label> 
                             <input type="text" class="form-control" name="pesobruto" id="pesobruto"  placeholder="0.00"   onkeyup="mayus(this);" tabindex="26" value="0.00" >

                         </div>

                                        </div>
              </div>
              </div>
              </div>




               <div class="form-group col-lg-12 col-md-6 col-sm-4 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">DATOS DEL COMPROBANTE</div>
                          <div class="panel-body">

                         <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                             <label>Orden de compra:</label> 
                             <input type="text" class="form-control" name="ocompra" id="ocompra"  placeholder=""  onkeyup="mayus(this);" tabindex="27"  >
                         </div>



                         <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                             <label>Nro de pedido:</label> 
                             <input type="text" class="form-control" name="npedido" id="npedido"  placeholder=""  onkeyup="mayus(this);" tabindex="28" >
                         </div>



                         <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                             <label>Vendedor:</label> 
                             <select class="form-control" name="vendedor" id="vendedor"  tabindex="29">
                             </select>
                             
                         </div>





                         <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                             <label>Costo min. de tras.:</label> 
                             <input type="text" class="form-control" name="costmt" id="costmt"  onkeypress="mayus(this);" tabindex="30" value="0.00" >
                         </div>



                         <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                            <label>Nro. Comprobante:</label> <!--Datos del cliente-->
                            <input type="text" class="form-control" name="numero_comprobante" id="numero_comprobante"  placeholder=""  width="50x" tabindex="31" readonly="true" >
                          </div>


                          <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                            <label>Fecha comprobante:</label> <!--Datos del cliente-->
                            <input type="date" class="form-control" name="fechacomprobante" id="fechacomprobante"  placeholder=""  width="50x" tabindex="32" readonly="true">
                          </div>

               </div>     
              </div>
              </div>
              </div>



    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">DETALLE GUIA</div>
                          <div class="panel-body">
 


<div class="col-lg-12 col-md-4 col-sm-6 col-xs-12">
           <div class="table-responsive">
                <table id="detallesGuia" class="table table-striped table-bordered">
                    
                 </table>
      </div>
    </div>
              </div>
              </div>
              </div>
              </div>


         


     <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <button class="btn btn-primary" type="submit" id="btnguardarguia" name="btnguardarguia" value="">
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




<script type="text/javascript" src="scripts/factura.js"></script>






<?php 
}
ob_end_flush();
?>