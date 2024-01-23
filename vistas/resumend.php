<?php
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
<!DOCTYPE html>  
 <html>  
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">    
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"> -->

</head>  
      <body>  
           <br /><br />  
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="">

                    <div class="box-header with-border">
                          <h1  class="box-title">RESUMEN DIARIO DE EMISIONES Y BAJAS PARA BOLETAS BOLETAS.</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>



  <!-- centro -->
<div class="panel-body table-responsive" id="listadoregistros">

  <form name="exportaDbaja" id="exportaDbaja"  action="../modelos2/Resumend.php" method="post" >

  
        <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
    <label> Año: </label>
    <select class="" name="ano" id="ano" onchange="regbajas()">

      <option value="2017">2017</option>
      <option value="2018">2018</option>
      <option value="2019">2019</option>
      <option value="2020">2020</option>
      <option value="2021">2021</option>
      <option value="2022">2022</option>
      <option value="2023">2023</option>
      <option value="2024">2024</option>
      <option value="2025">2025</option>
      <option value="2026">2026</option>
      <option value="2027">2027</option>
      <option value="2028">2028</option>
      <option value="2029">2029</option>
    </select>
    <input type="hidden" name="ano_1" id="ano_1">
  </div>

 <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
    <label> Mes: </label>
    <select class="" name="mes" id="mes" onchange="regbajas()">
      
      <option value="1">Enero</option>
      <option value="2">Febrero</option>
      <option value="3">Marzo</option>
      <option value="4">Abril</option>
      <option value="5">Mayo</option>
      <option value="6">Junio</option>
      <option value="7">Julio</option>
      <option value="8">Agosto</option>
      <option value="9">Septiembre</option>
      <option value="10">Octubre</option>
      <option value="11">Noviembre</option>
      <option value="12">Diciembre</option>
    </select>
    <input type="hidden" name="mes_1" id="mes_1">
  </div> 

  <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
    <label> Día: </label>
    <select class="" name="dia" id="dia" onchange="regbajas()">
      <option value=" ">Ninguno</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
      <option value="13">13</option>
      <option value="14">14</option>
      <option value="15">15</option>
      <option value="16">16</option>
      <option value="17">17</option>
      <option value="18">18</option>
      <option value="19">19</option>
      <option value="20">20</option>
      <option value="21">21</option>
      <option value="22">22</option>
      <option value="23">23</option>
      <option value="24">24</option>
      <option value="25">25</option>
      <option value="26">26</option>
      <option value="27">27</option>
      <option value="28">28</option>
      <option value="29">29</option>
      <option value="30">30</option>
      <option value="31">31</option>
    </select>
    <input type="hidden" name="mes_1" id="mes_1">
  </div> 


  <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
    <label> Estado: </label>
    <select class="" name="estadoD" id="estadoD" onchange="regbajas()">
      <option value="01">EMITIDO</option>
      <option value="03">ANULADO</option>
        </select>
    
  </div> 


  <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
    <label> Origen: </label>
    <select class="" name="destino" id="destino">
      <option value="01">LOCAL</option>
      <option value="02">REMOTO</option>
        </select>
    <input type="hidden" name="mes_1" id="mes_1">
  </div> 


  <div class="form-group col-lg-12 col-md-4 col-sm-6 col-xs-12">
    <div class="panel-body table-responsive" id="listadoregistros">
        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" style="font-size: 12px;">
                          <thead>
                            <th>Fec. gen. doc.</th>
                            <th>Fec. gen. resu.</th>
                            <th>Tipo doc.</th>
                            <th>Serie&num</th>
                            <th>Tipo Doc Cli.</th>
                            <th>Num. cli.</th>
                            <th>Tip. Mon.</th>
                            <th>Total op. gr.</th>
                            <th>Total IGV</th>
                            <th>Total</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                      <tfoot>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                      </tfoot> 
                        </table>
                    </div>
                  </div>

<!-- <div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
<button type="submit" name="export" value="" class="btn btn-success"><span class="fa fa-download "> Descargar plano</span></button>
</div> -->

</form>


<div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
<button class="btn btn-danger" name="generarbajaxml" name="generarbajaxml" onclick="generarbajaxml();">Generar Xml</button>
</div>

<div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
<a href="https://bit.ly/2JDIPCm" target="_blank"><img src="../public/images/sunat.png"> Consultar estado en SUNAT</a>
</div>


<div class="form-group col-lg-12 col-md-4 col-sm-6 col-xs-12">
    <div class="panel-body table-responsive" id="listadoregistros">
        <table id="tbllistadoxml" class="table table-striped table-bordered table-condensed table-hover" >
                          <thead>
                            <th>FECHA ENVIO</th>
                            <th>NOMBRE DE ARCHIVO</th>
                            <th>NRO TICKET</th>
                            <th>DETALLE</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                      
                        </table>
                    </div>
                  </div>

    <div class="panel-body table-responsive" id="listadoregistros">
        <table id="tbllistadocomprobante" class="table table-striped table-bordered table-condensed table-hover" >
                          <thead>
                            <th>NUMERO COMPROBANTE</th>
                            <th>FECHA EMISIÓN</th>
                            <th>TOTAL</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                      
                        </table>
                    </div>
                  </div>
</div>




<!-- <div class="box-header with-border">
<h1 class="box-title"><button class="btn btn-success" id="btnagregar" onclick="regventas()"><i class="fa fa-plus-circle"></i> DESACARGAR</button></h1>
</div> -->
               
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div>
</body>
</html>

<?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>

<script type="text/javascript" src="scripts/resumend.js"></script> 

<?php
}
ob_end_flush();
?>