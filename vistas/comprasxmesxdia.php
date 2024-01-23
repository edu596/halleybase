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

if($_SESSION['compras']==1)
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
                          <h1  class="box-title">CONSULTAS DE COMPRAS</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>



                    
<!-- <div class="panel-body"  id="formularioregistros">
  <form name="formulario" id="formulario" method="POST"> -->

<form name="formulario" id="formulario" action="../reportes/RegistroVentas.php" method="POST" target="_blank">

    <div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12">
    <label> Año: </label>
    <select class="form-control" name="ano" id="ano" onchange="regventas()">

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
    <select class="form-control" name="mes" id="mes" onchange="regventas()">
      <option value="00">todos</option>
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
    <select class="form-control" name="dia" id="dia" onchange="regventas()">
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
    <label> Moneda: </label>
    <select class="form-control" name="moneda" id="moneda" onchange="regcompras()">
      <option value="dolar">$ DOLARES</option>
      <option value="soles">S/ SOLES</option>

    </select>
    <input type="hidden" name="moneda" id="moneda">
  </div> 


 <h1 class="box-title"><button class="btn btn-success" id="btnagregar" onclick="regcompras()"><i class="fa fa-eye"></i> REPORTE x MES</button></h1>


<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
</div>
  <!-- centro -->
    <div class="panel-body table-responsive" id="listadoregistros">
        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>HORA</th>
                            <th>DOCUMENTO</th>
                            <th>...</th>
                            <th>VALOR AFECTO</th>
                            <th>IGV</th>
                            <th>TOTAL</th>
                            <th>TIPO</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                      <tfoot>
                            <th></th>
                            <th>TOTALES</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                      </tfoot> 
                        </table>
                    </div>




</form>
               
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div>




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