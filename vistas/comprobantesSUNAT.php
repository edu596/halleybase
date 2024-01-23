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
                          <h1  class="box-title">DESCARGA DE COMPROBANTES (FACTURA - BOLETA - N. CRÉDITO - N. DÉBITO ) PARA ENVIO SUNAT</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>



  <!-- centro -->
<div class="panel-body table-responsive" id="listadoregistros">

  <form name="exportaSUNAT" id="exportaSUNAT"  action="../modelos2/VentasSunat.php" method="post" >

  
        <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
    <label> Año: </label>
    <select class="" name="ano" id="ano" onchange="consultacomprobantes()">

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
    <select class="" name="mes" id="mes" onchange="consultacomprobantes()">
      
      <option value="01">Enero</option>
      <option value="02">Febrero</option>
      <option value="03">Marzo</option>
      <option value="04">Abril</option>
      <option value="05">Mayo</option>
      <option value="06">Junio</option>
      <option value="07">Julio</option>
      <option value="08">Agosto</option>
      <option value="09">Septiembre</option>
      <option value="10">Octubre</option>
      <option value="11">Noviembre</option>
      <option value="12">Diciembre</option>
    </select>
    <input type="hidden" name="mes_1" id="mes_1">
  </div> 

  <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
    <label> Día: </label>
    <select class="" name="dia" id="dia" onchange="consultacomprobantes()">
      <option value="01">01</option>
      <option value="02">02</option>
      <option value="03">03</option>
      <option value="04">04</option>
      <option value="05">05</option>
      <option value="06">06</option>
      <option value="07">07</option>
      <option value="08">08</option>
      <option value="09">09</option>
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
    <label> Comprobante: </label>
    <select class="" name="comprobante" id="comprobante" onchange="consultacomprobantes()">
      <option value="01">FACTURA</option>
      <option value="03">BOLETA</option>
      <option value="04">FACTURA DE SERVICIO</option>
      <option value="05">BOLETA DE SERVICIO</option>
      <option value="07">NOTA DE CREDITO / DEBITO</option>
        </select>
    <input type="hidden" name="mes_1" id="mes_1">
  </div> 



  <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <label> Estado: </label>
    <select class="" name="estadoC" id="estadoC" onchange="consultacomprobantes()">
      <option value="5">ACEPTADOS POR SUNAT</option>
      <option value="1">EMITIDOS</option>
      <option value="3">ANULADOS</option>
      <option value="4">FIRMADOS</option>
      <option value="6">FISICOS</option>
      
        </select>
    <input type="hidden" name="mes_1" id="mes_1">
  </div> 



  <div class="form-group col-lg-12 col-md-4 col-sm-6 col-xs-12">
    <div class="panel-body table-responsive" id="listadoregistros">
        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>FECHA EMISIÓN</th>
                            <th>COMPROBANTE</th>
                            <th>...</th>
                            <th>VALOR AFECTO</th>
                            <th>IGV</th>
                            <th>TOTAL</th>
                            <th>TIPO</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                        </table>
                    </div>
                  </div>





<div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
  <br>
<input type="submit" name="export" value="EXPORTAR" class="btn btn-success" >
</div>


</form>
</div>


<div class="form-group col-lg-12 col-md-4 col-sm-6 col-xs-12">
<h9 class="box-title" style="color: blue"> *Se descargarán todos los comprobantes en la carpeta DESCARGAS  del día seleccionado en archivos *.json </h9>
<br>
<!-- <h9 class="box-title" style="color: blue"> ** Si selecciona en origen LOCAL es porque tiene el sistema de forma local en su PC y no esta en ningún otro terminal, si selecciona HOSTING es porque tiene el sistema en un servidor web y que puede descargarlo desde cualquier ubicación de su dominio. </h9> -->
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

<script type="text/javascript" src="scripts/inventario.js"></script> 

<?php
}
ob_end_flush();
?>