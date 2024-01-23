<?php

//Activamos el almacenamiento en el buffer

session_start();

ob_start();

 

if (!isset($_SESSION["nombre"]))

  {
  header("Location: login.html");
  }

else

  {

require 'header.php';

 

  if ($_SESSION['escritorio']==1)

    {

      $hoy2=date('Y-m-d');

      

      require_once "../modelos/Consultas.php";
      $consulta = new Consultas();
      $rsptac = $consulta->totalcomprahoy($_SESSION['idempresa']);
      $regc=$rsptac->fetch_object();

      $rsptaegrecaja = $consulta->totalegresodia($hoy2);
      $regtscaja=$rsptaegrecaja->fetch_object();
      $totalegresocaja=$regtscaja->tegreso;


      $totalc=$regc->total_compra + $totalegresocaja  ;


      $rsptatc = $consulta->tipodecambio($_SESSION['idempresa']);
      $rptatcamb=$rsptatc->fetch_object();
      if ($rptatcamb=="") {
      $venta="";
      $compra="";
      }else{
        $venta=$rptatcamb->venta;
      $compra=$rptatcamb->compra;
      }


      $rptai = $consulta->ingresosdia($_SESSION['idempresa']);
      $rptai2=$rptai->fetch_object();
      $totalingresos=$rptai2->tingreso;
      

      $rptae = $consulta->egresosdia($_SESSION['idempresa']);
      $rptae2=$rptae->fetch_object();
      $totalegresos=$rptae2->tsalida;

 

      $rsptav = $consulta->totalventahoycotizacion($_SESSION['idempresa']);
      $regv=$rsptav->fetch_object();
      $totalvcotihoy=$regv->total_venta_coti_hoy;



      $rsptav = $consulta->totalventahoyFactura($_SESSION['idempresa']);
      $regv=$rsptav->fetch_object();
      $totalvfacturahoy=$regv->total_venta_factura_hoy;



      $rsptav = $consulta->totalventahoyBoleta($_SESSION['idempresa']);
      $regv=$rsptav->fetch_object();
      $totalvboletahoy=$regv->total_venta_boleta_hoy;



      $rsptav = $consulta->totalventahoyNotapedido($_SESSION['idempresa']);
      $regv=$rsptav->fetch_object();
      $totalvnpedidohoy=$regv->total_venta_npedido_hoy;

      
      $rsptaingcaja = $consulta->totalingresodia($hoy2);
      $regticaja=$rsptaingcaja->fetch_object();
      $totalingresocaja=$regticaja->tingreso;



      $totalventas=0;
      $totalventasgeneral=$totalvfacturahoy + $totalvboletahoy + $totalvnpedidohoy + $totalingresocaja ;


      $utilidad=$totalventasgeneral - $totalc;

      if ($utilidad < 0) {
          $coloru="color: rgb(223, 32, 64);";
      }
      else
      {
          $coloru="color: rgb(0, 153, 64);"; 
      }




           //Tipo de cambio
      date_default_timezone_set('America/Lima');
      $hoy=date('Y/m/d');
      $hoy2=date('Y-m-d');

      $rsptatc = $consulta->mostrartipocambio($hoy);
      $regtc=$rsptatc->fetch_object();

      if (!isset($regtc)) {
        $idtipocambio="";
        $fechatc="";
        $tccompra="";
        $tcventa=""; 
        $dfecha="";

      }else{
          $idtipocambio=$regtc->idtipocambio;
          $fechatc=$regtc->fecha;
          $tccompra=$regtc->compra;
          $tcventa=$regtc->venta;


           // if ($fechatc==$hoy2) {
           //      $dfecha="readonly";
           //    }else{
           //      $dfecha="";
           //  } 


            if ($fechatc=='') {
              $dfecha="";
            }
      }
      //Tipor de cambio

       $iddcjj="";
      //VALIDAR SI LA CAJA ES DEL DÍA
      $rptavcaja = $consulta->validarcaja($hoy2);
      $rptaidcaja = $consulta->validcaja($hoy2);
        $idcj=$rptaidcaja->fetch_object();
         if ($iddcjj=="") {
          $iddcjj="";
        }
        else
        {
          $iddcjj=$idcj->idcaja;
        }

      



       //Caja

      date_default_timezone_set('America/Lima');
      $hoy=date('Y/m/d');
      $hoy2=date('Y-m-d');

      $rsptatc = $consulta->mostrarcaja($hoy, $_SESSION['idempresa']);
      $regtc=$rsptatc->fetch_object();
      
      if (!isset($regtc)) {
        $idcaja="";
        $idcajai="";
        $idcajas="";
        $fecha="";
        $montoi="0";
        $montof="0"; 
        $dfecha="";
        $estadoCa="";
        $cajaestado="";
        $mensajecaja="ABRIR CAJA";
        $hb="";
        $color="";
        $btn="";
      }else{

          $idcaja=$regtc->idcaja;
          $idcajai=$regtc->idcaja;
          $idcajas=$regtc->idcaja;
          $fecha=$regtc->fecha;
          $montoi=$regtc->montoi;
          $montof=$regtc->montof;
          $estadoCa=$regtc->estado;

           if ($fecha==$hoy2) {
                $dfecha="readonly";
              }else{
                $dfecha="";
            } 

             if ($estadoCa=='') {
              $mensajecaja='ABRIR CAJA';
            }



            if ($estadoCa=='1') {
              $mensajecaja='ABIERTA';
              $hb="";
              $cajaestado='ABIERTA';
              $color='green';
              $btn="";
            }else{
              $mensajecaja='ABRIR CAJA';
              $hb="readonly";
              $cajaestado='CERRADA';
              $color='red';
              $btn="disabled";
            }
      }

      //Tipor de caja

      

 

      //Datos para mostrar el gráfico de barras de las compras
      $compras10 = $consulta->comprasultimos_5meses($_SESSION['idempresa']);
      $fechasc='';
      $totalesc='';
      $mes='';
      while ($regfechac= $compras10->fetch_object()) {
      $fechasc=$fechasc.'"'.$regfechac->fecha .'",';
      $totalesc=$totalesc.$regfechac->total .','; 
      $mes=$mes.'"'.$regfechac->mes .'",'; 
      }
      //Quitamos la última coma
      $fechasc=substr($fechasc, 0, -1);
      $totalesc=substr($totalesc, 0, -1);
      $mes=substr($mes, 0, -1);

     

      //Datos para mostrar el gráfico de barras de las ventas
      $ventas12 = $consulta->ventasultimos_3meses($_SESSION['idempresa']);
      $fechasv='';
      $totalesv='';
      while ($regfechav= $ventas12->fetch_object()) {
      $fechasv=$fechasv.'"'.$regfechav->fecha .'",';
      $totalesv=$totalesv.$regfechav->total .','; 
      }
      //Quitamos la última coma
      $fechasv=$fechasv;
      $totalesv=$totalesv;


      $consultaSTs = $consulta->consultaestados();
      $estado='';
      $totalestado='';
      $stEmitido=0;
      $stFirmado=0;
      $stAceptado=0;
      $stAnulado=0;
      $stNota=0;
      $stFisico=0;
      while ($regestados= $consultaSTs->fetch_object()) {

      $estadoD=$regestados->estado;

      $totalestadoD=$regestados->totalestados;

      switch ($estadoD) {

        case '1':

          $stEmitido=$totalestadoD;

          break;

        case '5':

          $stAceptado=$totalestadoD;;

          break;

        case '5':

          $stAceptado=$totalestadoD;;

          break;

        case '3':

          $stAnulado=$totalestadoD;;

          break;

        case '4':

          $stFirmado=$totalestadoD;;

          break;

        case '6':

          $stFisico=$totalestadoD;;

          break;

        

        default:

          # code...

          break;

      }

      }





      $consultaSTsCoti = $consulta->consultaestadoscotizaciones();

      $estadoC='';

      $totalestadoDCoti='';

      $stEmitidoCoti=0;

      $stAceptadoCoti=0;

      while ($regestadosCoti= $consultaSTsCoti->fetch_object()) {

      $estadoDCoti=$regestadosCoti->estado;

      $totalestadoDCoti=$regestadosCoti->totalestados;

      switch ($estadoDCoti) {

        case '1':

          $stEmitidoCoti=$totalestadoDCoti;

          break;

        case '5':

          $stAceptadoCoti=$totalestadoDCoti;;

          break;

        default:

          break;

                }

      }







      $consultaSTsOs = $consulta->consultaestadosdocumentoC();

      $estadoC='';

      $totalestadoDcobranza='';

      $stEmitidoDcobranza=0;

      $stAceptadoddcobranza=0;

      while ($regestadosDcobranza= $consultaSTsOs->fetch_object()) {

      $estadoDCoti=$regestadosDcobranza->estado;

      $totalestadoDcobranza=$regestadosDcobranza->totalestados;

      switch ($estadoDCoti) {

        case '1':

          $stEmitidoDcobranza=$totalestadoDcobranza;

          break;

        case '5':

          $stAceptadoddcobranza=$totalestadoDcobranza;;

          break;

        default:

          break;

                }

      }



       $lunes='0.00';

      $martes='0.00';

      $miercoles='0.00';

      $jueves='0.00';

      $viernes='0.00';

      $sabado='0.00';

      



      $consultadiase = $consulta->ventasdiasemana();

      while ($regdiase= $consultadiase->fetch_object()) {

      $nrodia=$regdiase->dia;

      switch ($nrodia) {

        case '2':

          $lunes=$regdiase->VentasDia;

          break;

        case '3':

          $martes=$regdiase->VentasDia;;

          break;

        case '4':

          $miercoles=$regdiase->VentasDia;;

          break;

        case '5':

          $jueves=$regdiase->VentasDia;;

          break;

        case '6':

          $viernes=$regdiase->VentasDia;;

          break;

        case '7':

          $sabado=$regdiase->VentasDia;;

          break;

        

        default:

          # code...

          break;

      }

      }

require_once "../modelos/Factura.php";
$factura = new Factura();
$datos = $factura->datosemp($_SESSION['idempresa']);
$datose = $datos->fetch_object();



?>



<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"> -->

<!--Contenido-->





  


<!-- Modal ABRIR / CERRAR CAJA -->
 <div class="modal fade" id="modalcaja">
    <div class="modal-dialog" style="width: 100% !important;">
      <div class="modal-content">
          <div class="modal-header">MANTENIMIENTO DE CAJA</div>

      <form name="formulariocaja" id="formulariocaja" method="POST">
          <div  id="montoscajamodal" name="montoscajamodal">  

          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
             Fecha del día: <input type="date" name="fechacaja" id="fechacaja" value="<?php echo $fecha; ?>" class=""  <?php  echo  $dfecha;  ?>     > 
             <input type="hidden" name="idcaja" id="idcaja" value="<?php echo $idcaja; ?>" >
             <input type="hidden" name="estadoCaja" id="estadoCaja" value="<?php echo $estadoCa; ?>" >
          </div>

          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
             Monto inicial del día:  <input type="number" inputmode="decimal" name="montoi" id="montoi" placeholder="Monto inicial" value=" <?php  echo ($montoi);  ?> " class=""  <?php  echo  $hb;  ?> onkeypress="return NumCheck(event, this)" >
          </div>

          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
              Monto final del día: 
              <input type="number" inputmode="decimal" name="montof" id="montof" placeholder="Monto final" value=" <?php  echo ($montof);  ?> " class=""  <?php  echo  $hb;  ?>  onkeypress="return NumCheck(event, this)" >
          </div>


<div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
    <button class="btn btn-primary btn-lg" type="submit" id="btngrabar" name="btngrabar" data-toggle="tooltip" title="ABRIR O CERRAR CAJA">
        <i class="fa fa-usd"></i> Abrir / Cerrar caja
    </button>
  </div>

<div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
   <a href="#ingresocaja" data-toggle="modal"> <button class="btn btn-success btn-lg" type="submit" id="btningreso" name="btningreso"  data-toggle="tooltip" title="INGRESO" <?php echo $btn;  ?>><i class="fa fa-dot-circle-o"></i> Ingreso </button></a>
</div>

<div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
   <a href="#salidacaja" data-toggle="modal"> 
     <button class="btn btn-danger btn-lg" type="submit" id="btnsalida" data-toggle="tooltip" 
     title="GASTO" name="btnsalida" <?php  echo $btn;  ?>>
     <i class="fa fa-motorcycle"></i> Salida</button></a>
  </div>

  
<div  class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
  <a href="#cajaconsulta" data-toggle="modal">  <button class="btn btn-primary btn-lg" data-toggle="tooltip" 
     title="CONSULTA DE INGRESOS Y GASTOS"><i class="fa fa-television"></i> Consulta</button></a>

   </div>

     
<!-- <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
     <a href="#cajaconsulta" data-toggle="modal">  <button class="btn btn-primary btn-lg" data-toggle="tooltip" 
     title="Reporte de caja"><i class="fa fa-money"></i> Reporte</button></a>
   </div> -->

<div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
      <input type="button" class="btn btn-primary btn-lg" data-toggle="tooltip" 
     title="Actualizar" onclick="actcajas();" value="Actualizar">
</div>

<div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
    <input type="hidden" id="fechacajahoy" name="fechacajahoy" value="<?php echo $fechatc; ?>">
      <input type="button" class="btn btn-success btn-lg" data-toggle="tooltip" 
     title="Recalcular ingresos y salidas" onclick="recalcular()" value="Recalcular del día">

</div>
  
     <label style="font-size: 18px; color:<?php  echo $color;  ?>;"> ESTADO: <?php  echo $mensajecaja;  ?> </label>
         
              </div> 
 <div  class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
<div class="panel-body table-responsive" >
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  FECHA DE CAJAS ANTERIORES.
    <table id="tbllistadocaja"  class="table table-striped table-hover table-bordered table-condensed nowrap">
                          <thead>
                            <th>Id</th>
                            <th>Fecha</th>
                            <th>Inicial </th>
                            <th>Final</th>
                            <th>Estado</th>
                            <th>...</th>
                          </thead>
                          <tbody > 
                          </tbody>
          </table>
        </div>
      </div>
    </div>


        </form>
          <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-ver" data-dismiss="modal" ><i class="fa fa-close"> </i>   Cerrar</button>

        </div>        

     </div>

   </div>

  </div>










  







   <!-- Modal ABRIR / CERRAR CAJA -->

 <div class="modal fade" id="modalfechas">
    <div class="modal-dialog" style="width: 40% !important;">
      <div class="modal-content">
          <div class="modal-header">Fechas anteriores</div>
        <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <table id="tbllistadocaja"  >

                          <thead >

                            <th>Fecha</th>

                            <th>Inicial </th>

                            <th>Final</th>

                          </thead>

                          <tbody > 



                          </tbody>

          </table>

        </div> -->

          <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-ver" data-dismiss="modal" >Cerrar</button>
        </div>        
     </div>
   </div>
  </div>







    <!-- Modal REPORTE ---------------------------------------------->

 <div class="modal fade" id="cajaconsulta">

    <div class="modal-dialog" style="width: 100% !important;">

      <div class="modal-content">

          <div class="modal-header">INGRESOS Y EGRESOS</div>

        <form name="formulariois" id="formulariois" action="../reportes/.php" method="POST" target="_blank">

<input type="hidden" name="idempresa" id="idempresa" value="<?php echo $_SESSION['idempresa'] ;  ?>">

  <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <label> Fecha 1: </label>
    <input type="date" name="fecha1" id="fecha1" class="" onchange="listarValidar()">
</div>
        
<div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <label> Fecha 2: </label>
    <input type="date" name="fecha2" id="fecha2" class="" onchange="listarValidar()">
</div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="panel-body table-responsive" id="listadoregistros">
 <table id="tbllistadocajavalidar" class="table table-striped table-bordered table-condensed table-hover" >

                    <thead>

                            <th>ID</th>
                            <th>FECHA</th>
                            <th>MONTO</th>
                            <th>CONCEPTO</th>
                            <th>TIPO</th>
                          </thead>

                          <tbody>                            

                          </tbody>

                        </table>
                      </div>
                    </div>
      </form>

          <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-ver" data-dismiss="modal" >Cerrar</button>
        </div>        

     </div>

   </div>

  </div>







  <!-- Modal ABRIR / INGRESO CAJA -->

 <div class="modal fade" id="ingresocaja">
    <div class="modal-dialog" style="width: 90% !important;">
      <div class="modal-content">
          <div class="modal-header" style="font-size: 18px; color: green;">INGRESO</div>
      <form name="formularioicaja" id="formularioicaja" method="POST">
        <div name="idcajaingreso" id="idcajaingreso">
          <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
             <input type="hidden" name="idcajai" id="idcajai" value="<?php echo $idcajai; ?>" >

          </div>

          <div class="form-group col-lg-12 col-md-4 col-sm-6 col-xs-12">
             Concepto:  <select  class="form-control" name="conceptoi" id="conceptoi" required data-live-search="true">
                        </select>
          </div>


          <div class="form-group col-lg-12 col-md-4 col-sm-6 col-xs-12">
             Descripción:  <textarea name="conceptoin" id="conceptoin" placeholder="Monto inicial" class=""  rows="2" cols="100" autofocus onkeyup="mayus(this)"></textarea>
          </div>

          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
              Monto: <input type="number" inputmode="decimal" name="montoin" id="montoin" placeholder="Monto" class=""  onkeypress="return NumCheck(event, this)" >
          </div>
          

          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
              Fecha: <input type="date" name="fechain" id="fechain">
          </div>
        </div>

  <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <button class="btn btn-success btn-lg" type="submit" id="btngrabar" name="btngrabar">
        GRABAR
          </button>
           <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal" >CERRAR</button>
  </div>
        </form>
          <div class="modal-footer">
        </div>        

     </div>

   </div>

  </div>





   <!-- Modal ABRIR / SALIDA CAJA -->

 <div class="modal fade" id="salidacaja">
    <div class="modal-dialog" style="width: 90% !important;">
      <div class="modal-content">
          <div class="modal-header" style="font-size: 18px; color: red;">EGRESO</div>
      <form name="formularioscaja" id="formularioscaja" method="POST">
        <div name="idcajasalida" id="idcajasalida">
          <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
             <input type="hidden" name="idcajas" id="idcajas" value="<?php echo $idcajas; ?>" >
          </div>

          <div class="form-group col-lg-12 col-md-4 col-sm-6 col-xs-12">
             Concepto:  <select  class="form-control" name="conceptos" id="conceptos" required data-live-search="true">
                        </select>
          </div>


          <div class="form-group col-lg-12 col-md-4 col-sm-6 col-xs-12">
             Descripción:  <textarea name="conceptosal" id="conceptosal" placeholder="Monto inicial" class=""  rows="2" cols="100" autofocus onkeyup="mayus(this)"></textarea>
          </div>
          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
              Monto: <input type="number" inputmode="decimal" name="montosal" id="montosal" placeholder="Monto" class=""  onkeypress="return NumCheck(event, this)" >
          </div>


          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
              Fecha: <input type="date" name="fechasal" id="fechasal">
          </div>

        </div>

  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
    <button class="btn btn-success btn-lg" type="submit" id="btngrabar" name="btngrabar">
        <i class="fa fa-save"></i> GRABAR
          </button>
          <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal" >CERRAR</button>
  </div>
        </form>
          <div class="modal-footer">
          
        </div>        
     </div>
   </div>
  </div>









 <!-- Modal tipo de cambio -->

 <div class="modal fade" id="modalTcambio">
    <div class="modal-dialog" style="width: 90% !important;">
      <div class="modal-content">
          <div class="modal-header"> Tipo de cambio desde SUNAT
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          
      <form name="formulariotcambio" id="formulariotcambio" method="POST">
        <input type="hidden" name="idemp" id="idemp" value="<?php echo $_SESSION["idempresa"] ?>">
          <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <label>Fecha: </label>
     <input type="date" name="fechatc" id="fechatc" value="<?php echo $fechatc; ?>" class=""  <?php  echo  $dfecha;  ?> onchange="consultartcambio();" readonly="true"> 
             <input type="hidden" name="idtcambio" id="idtcambio" value="<?php echo $idtipocambio; ?>" >
          </div>

          <div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
            <label>Compra:</label>
               <input type="number" inputmode="decimal" step="any" name="compra" id="compra" placeholder="Compra" value=" <?php  echo $tccompra;  ?> " class="">
          </div>

          <div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
            <label>Venta:</label>
               <input type="number" inputmode="decimal" step="any" name="venta" id="venta" placeholder="Venta" value=" <?php  echo $tcventa;  ?> " class="">
          </div>


           <div class="col-lg-12 col-xs-12">

             <button class="btn btn-success btn-lg" type="submit" id="btnguardartcambio" name="btnguardartcambio" value="btnguardartcambio">
        GUARDAR
          </button>


            <button class="btn btn-success btn-lg" type="button" id="btnguarconsultar" name="btnguarconsultar" onclick="consultartcambio();">
              <i class="fa fa-find"></i>DE SUNAT
          </button>


         
          
          </div>

  <!--  <iframe border="0" frameborder="0" height="300" width="100%" src="https://e-consulta.sunat.gob.pe/cl-at-ittipcam/tcS01Alias"></iframe> -->
        </form>
      
          <div class="modal-footer">
        </div>        
     </div>
   </div>
  </div>















      <!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="panel-body" >
                   <!--  <div class="box-header with-border">
                          <h1 class="box-title" > </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div> -->
                    <!-- /.box-header -->
                    <!-- centro -->

                    <span class="mel-stat-content">

                      

                    </span>





                       <!--   <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                          <div class="small-box bg-blue-active">
                              <div class="inner">
                                
                                <p>ARTICULOS</p>
                              </div>
                              <div class="icon">
                              </div>
                              <a href="articulo.php" class="small-box-footer">CREAR ARTICULO <i class="fa fa-arrow-circle-right"></i></a>
                              
                            </div>
                        </div> -->


                    

                        <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                          <div class="small-box bg-success" id="divutilidad">
                             <div class="inner">
                                <h4>

                                  <strong><h2 style="<?php echo $coloru; ?>">S/<?php echo number_format($utilidad,2); ?></h2></strong>

                                </h4>

                                <p>UTILIDAD TOTAL</p>

                              </div>

                              <div class="icon">
                                <i class="fa fa-line-chart fa-2" style="color: rgb(0, 153, 64);"></i>
                              </div>
                            </div>

                        </div>







                  


                          <div class="col-lg-4 col-md-3 col-sm-6 col-xs-6">
                          <div class="small-box bg-info" id="divingreso">
                              
                              <div class="inner">

                                <h4 >

                                  <strong><h2>S/<?php echo number_format($totalventasgeneral,2); ?></h2></strong>

                                </h4>

                                <p >INGRESOS</p>

                              </div>
                              <div class="icon">
                                <i class="fas fa-money" style="color: rgb(0, 153, 64);"></i>
                              </div>
                                </div>

                        </div>



                     



                          <div class="col-lg-4 col-md-3 col-sm-6 col-xs-6">
                          <div class="small-box bg-warning" id="divegreso">
                              
                              <div class="inner">
                                <h4>
                                  <strong><h2> S/<?php echo number_format($totalc,2); ?></h2></strong>
                                </h4>
                                <p>EGRESOS </p>
                              </div>
                              <div class="icon">
                                <i class="fas fa-shopping-basket" style="color: rgb(223, 32, 64);"></i>
                              </div>
                              
                            </div>
                        </div>


<!-- 
                            <div id="tourtip1" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <div class="small-box bg-info">
                              <div class="inner">
                                <h4>
                                  <strong><h2>S/ <?php echo number_format($totalvcotihoy,2); ?></h2></strong>
                                </h4>
                                <p>COTIZACIONES HOY</p>
                              </div>
                              <div class="icon">
                                <i class="fas fa-calculator fa-3"></i>
                              </div>
                              <a href="cotizacion.php" class="small-box-footer">EMITIR COTIZACIÓN <i class="fa fa-arrow-circle-right"></i></a>
                              
                            </div>
                        </div>
 -->

<!-- 
            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
                          <div class="small-box bg-success">
                              
                              <div class="inner">
                                <a class="btn btn-app" href="#ingresocaja" data-toggle="modal">
                                  <span class="badge bg-green">I</span>
                                  <i class="fas fa-plus-circle" style="color: green;"></i> INGRESOS
                                  </a>
                              </div>
                             
                            </div>
                        </div>   -->


               <!--          <div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
                          <div class="small-box bg-success">
                              
                              <div class="inner">
                                <a class="btn btn-app" href="#salidacaja" data-toggle="modal">
                                  <span class="badge bg-red">S</span>
                                  <i class="fas fa-minus-circle" style="color: red;"></i> SALIDAS
                                  </a>
                              </div>
                              
                            </div>
                        </div>
                       -->


                   <!--  <div class="small-box bg-info col-lg-8 col-md-3 col-sm-6 col-xs-12" >
                      
                        
                        <form name="formularioConceptoGAstoingreso" id="formularioConceptoGAstoingreso" method="POST">
                              
                                CONTROL DE INGRESOS Y GASTOS
                              

                              <div class="col-lg-12  col-xs-12">
                                  
                                  <select  class="form-control" name="Nom_Concepto" id="Nom_Concepto" required  data-live-search="true" onchange="focusOptMovMov()">
                            </select>
                              </div>


                                <div class="col-lg-2  col-xs-2">
                                  <LABEL>TIPO</LABEL>
                              </div>

                              <div class="col-lg-2  col-xs-10">
                                  <input type="radio" name="OptMov" id="OptMov" value="E" checked  onchange="focusMontoMov()"><label>INGRESO</label>
                                  <input type="radio" name="OptMov" id="OptMov" value="S" onchange="focusMontoMov()"><label>GASTO</label>
                              </div>


                              <div class="col-lg-2  col-xs-2">
                                  <LABEL>FECHA</LABEL>
                              </div>

                              <div class="col-lg-2  col-xs-10">
                                  <input type="date" name="Fecha_Mov_Con" id="Fecha_Mov_Con">
                              </div>

                             

                              <div class=" col-lg-2  col-xs-4">
                                  <LABEL>MONTO</LABEL>
                              </div>

                              <div class=" col-lg-2  col-xs-8">
                                  <input type="number" inputmode="decimal"  step="any" name="Monto_Mov" id="Monto_Mov" onkeypress="return NumCheck(event, this)" >
                              </div>

                              <div class=" col-lg-2  col-xs-4">
                                  <LABEL>OBSERVACIÓN</LABEL>
                              </div>

                              <div class=" col-lg-2  col-xs-8">
                                  <textarea  cols="1"  rows="3" name="ObseMov" id="ObseMov"></textarea>
                              </div>

                              

                                <div class="col-lg-2 col-xs-6" >
                                  <button  type="submit"  name="btnMov"  class="btn btn-success">GUARDAR </button>
                              </div>


                                   <div class="col-lg-2 col-xs-6" >
                                  <button  type="submit"  name="btnMovRpo"  class="btn btn-danger">REPORTE </button>
                              </div>

                               </form>
                          
                     </div> -->


                 


    <!--       <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" >
                          <div class="small-box bg-danger">
            <a target="_blank" href="../reportes/reporteie.php?idccaajja=<?php echo $iddcjj;?>" class="small-box-footer" target="_blank">REPORTE DEL DÍA</a>
                              <div class="inner" id="cchica">
                                
                                  <h4 style="color: rgb(0, 153, 64);">INGRESOS:<strong>  <?php echo number_format($totalingresos,2); ?></strong></h4>
                                
                                  <h4 style="color: rgb(223, 32, 64);">EGRESOS:<strong>  <?php echo number_format($totalegresos,2); ?></strong></h4>
                              </div>
            <a data-toggle="modal" href="#modalcaja" class="small-box-footer"> ABRIR CAJA
              <a data-toggle="modal" href="" class="small-box-footer">CAJA
            </a>
                    </div>
                        </div>
 -->




                       





                       <div class="col-lg-4 col-md-3 col-sm-6 col-xs-6">
                          <div class="small-box bg-warning">
                              <a href="../reportes/repVentasnPdias.php" 
                              class="small-box-footer" target="_blank">REPORTE DÍA <i class="fa fa-print"></i>
                            </a>

                            <a href="notapedido.php">
                              <div class="inner">
                                <h4>
                                  <strong><h2> S/<?php echo number_format($totalvnpedidohoy,2); ?></h2></strong>
                                </h4>
                                <p>NOTAS PEDIDO </p>
                              </div>
                            </a>
                              <div class="icon">
                                <i class="fas fa-money"></i>
                              </div>
                              <a href="notapedido.php" class="small-box-footer">EMITIR PEDIDO <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div> 






                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-6">
                          <div class="small-box bg-warning">
                              <a href="../reportes/RepVentasFacDia.php" class="small-box-footer" target="_blank">REPORTE DÍA <i class="fa fa-print"></i></a>    

                            <a href="factura.php">
                              <div class="inner">
                                <h4 >
                                  <strong><h2>S/<?php echo number_format($totalvfacturahoy,2); ?></h2></strong>
                                </h4>
                                <p >FACTURAS HOY</p>
                              </div>
                               </a>

                              <div class="icon">
                                <i class="fas fa-shopping-bag fa-2"></i>
                              </div>
                              <a href="factura.php" class="small-box-footer">EMITIR FACTURA <i class="fa fa-arrow-circle-right"></i></a>
                            </div>

                        </div>




                        
                        <div class="col-lg-4 col-md-3 col-sm-6 col-xs-6">
                          <div class="small-box bg-warning">
                              <a href="../reportes/RepVentasBolDia.php" class="small-box-footer" target="_blank">REPORTE DÍA <i class="fa fa-print"></i></a>
                              <a href="boleta.php">
                              <div class="inner">
                                <h4>
                                  <strong><h2>S/<?php echo number_format($totalvboletahoy,2); ?></h2></strong>
                                </h4>
                                <p >BOLETAS HOY</p>
                              </div>
                            </a>
                              <div class="icon">
                                <i class="fas fa-shopping-bag fa-2"></i>
                              </div>
                              <a href="boleta.php" class="small-box-footer">EMITIR BOLETA <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>



                       





                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                                Ventas
                            </div>
                            <div class="box-body">
                              <canvas id="ventas" width="400" height="250"></canvas>
                            </div>
                          </div>
                        </div>



                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                                Compras 
                            </div>
                            <div class="box-body">
                              <canvas id="compras" width="400" height="250"></canvas>
                            </div>
                          </div>
                        </div>

          <!--   <div class="panel-body table-responsive" id="listadoregistros">
                  <div id="chartContainer" style="height: 300px; width: 100%;"></div>
            </div> -->


  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 img-rounded">
    <input type="checkbox" id="spoiler1"></input>
                        <label for="spoiler1">COMPROBANTES PENDIENTES</label>
                          <div class="spoiler">
                      <div class="panel-body table-responsive" >
                            <table id="listacomprobantes2" class="table table-sm table-striped table-bordered table-condensed table-hover">
                                <thead>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Canti.</th>
                                <th>Compro.</th>
                              </thead>
                          <tbody>                            
                          </tbody>
                              </table>
                            </div>
                          </div>
          </div>
             




  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 img-rounded">
          <input type="checkbox" id="spoiler2"></input>
               <label for="spoiler2">CALCULO PAGO SUNAT IGV-RENTA</label>
                          <div class="spoiler">
                            
                            <div class="col-lg-3">
                            <label>Igv ventas</label>
                            </div>

                            <div class="col-lg-3">
                            <input type="text" name="vngraigv" id="vngraigv" placeholder="0.00" readonly=""> 
                            <input type="hidden" name="vngraigv2" id="vngraigv2"> 
                            </div>


                            <div class="col-lg-3">
                            <label>Igv compras</label>
                            </div>

                            <div class="col-lg-3">
                            <input type="text" name="cngraigv" id="cngraigv" placeholder="0.00" readonly="" >  
                            <input type="hidden" name="cngraigv2" id="cngraigv2" >
                            </div>


                            <div class="col-lg-3">
                            <label>1% ventas</label>
                            </div>

                            <div class="col-lg-3">
                            <input type="text" name="vngrarenta1porc" id="vngrarenta1porc" placeholder="0.00"  readonly="">
                            <input type="hidden" name="vngrarenta1porc2" id="vngrarenta1porc2"> 
                            </div>


                            <div class="col-lg-3">
                            <label>Pago del mes</label>
                            </div>

                            <div class="col-lg-3">
                            <h3 id="finalpagar" style="color: blue;"  >0.00</h3>
                            </div>

                          </div>
      </div>


                    


      <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 img-rounded">
               <input type="checkbox" id="spoiler3"></input>
               <label for="spoiler3">BUSCAR COMPROBANTE</label>
                      <div class="spoiler">
                        <div class="panel-heading"></div>
                          <div class="panel-body">


                      <form method="post" id="frmConsultaComp"  name="frmConsultaComp" action="../reportes/exBuscarComprobante.php" method="POST" target="_blank" >
                            
                                        <select  class=""  name="tipodoc" id="tipodoc" title="seleccione">
                                        <option value="01">FACTURA</option>
                                        <option value="03">BOLETA</option>
                                        <option value="07">NOTA DE CRÉDITO</option>
                                        <option value="08">NOTA DE DÉBITO</option>
                                      </select>


                                    <input type="input" name="serienumero" id="serienumero"  class="form-control" placeholder="Ej: FXXX-000000000" onfocus="focusTest(this);" >
                              
                                  <button type="submit" class="btn btn-info" name="boton" name="boton" value="Buscar">Buscar
                                    <i class="fa fa-arrow-circle-right"></i>
                                  </button>
                          </form>
                          </div>
                        </div>
                      
                    </div>




            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 img-rounded">
               <input type="checkbox" id="spoiler4"></input>
               <label for="spoiler4">CONSULTA RÁPIDA DE ARTÍCULO</label>
                      <div class="spoiler">
                          <div class="panel-body">

                            <form method="post" id="consultaarticulo"  name="consultaarticulo" method="POST">
                               
            <h3>Ingrese código</h3>
              <input type="text" name="codigoart" id="codigoart" class="" placeholder="ARTÍCULO" onfocus="focusTest(this);" > 
                                    
     <label id="lnombre" nombre="lnombre"></label>
     <label id="lstock" nombre="lstock"></label>
     <label id="lprecio" nombre="lprecio"></label> 
                                    

                                    <button type="submit" class="btn btn-info" name="btn-submit" id="btn-submit" value="Buscar">CONSULTAR
                                    <i class="fa fa-arrow-circle-right"></i>
                                  </button>





                            </form>




                          </div>
                        </div>
                     </div>


        
                         <!-- PARA CONSULTA DE ARTICULO -->

               <!--  <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">

                          <form method="post" id="consultaarticulo"  name="consultaarticulo" method="POST">

                            <div class="small-box bg-green-active">

                                
                      <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <label style="color:white;">Consulta rápida</label>

                                    <input type="text" name="codigoart" id="codigoart" class="" placeholder="ARTÍCULO" onfocus="focusTest(this);" >    
                        </div>
                                
                                      <div class="col-lg-4 col-md-2 col-sm-2 col-xs-2" >
                                      <label style="color:white;">NOMBRE:</label>
                                         <label id="lnombre" nombre="lnombre" style="font-size: 18px; "></label> 
                                      </div>



                                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                      <label style="color:white;">STOCK:</label>
                                        <label id="lstock" nombre="lstock" style="font-size: 18px;"></label> 
                                      </div>



                                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                      <label style="color:white;">PRECIO:</label>
                                        <label id="lprecio" nombre="lprecio" style="font-size: 18px; "></label> 

                                      </div>

                                  <button type="submit" class="btn btn-info" name="btn-submit" id="btn-submit" value="Buscar">CONSULTAR
                                    <i class="fa fa-arrow-circle-right"></i>
                                  </button>

                              

                              

                            </div>

                          </form>

                        </div> -->



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



      var codigo=$("#codigoart").val();

       $.post("../ajax/articulo.php?op=articuloBusqueda&codigoa="+codigo, function(data,status)

    {

       data=JSON.parse(data);

       if (data != null){

       document.querySelector('#lnombre').innerText = "Nombre: "+data.nombre;
       document.querySelector('#lstock').innerText = "Stock: "+data.stock+" "+data.unidad_medida;
       document.querySelector('#lprecio').innerText ="Precio: "+data.precio_venta;

        }

        else

        {

          alert("Verifique");

                       

//============== original ===========================================================

                }

//============== original ===========================================================

            });

          

        });

      });

    </script>





     <!-- PARA CONSULTA DE BUSQUEDA DE COMPROBANTE -->





                 <!--  <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">

                          <div class="small-box bg-yellow-active">

                              <div class="inner">

                                <p>ARTI.</p>

                              </div>

                              <div class="icon">

                                <i class="ion ion-bag"><a href="articulo.php"><img src="../public/images/articulos.png"></a></i>

                              </div>

                              <a href="articulo.php" class="small-box-footer"><i class="fa fa-plus"></i></a>

                            </div>

                        </div>



                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">

                          <div class="small-box bg-yellow-active">

                              <div class="inner">

                               

                                <p>SERV.</p>

                              </div>

                              <div class="icon">

                                <i class="ion ion-bag"><a href="bienservicio.php"><img src="../public/images/bienes.png"></a></i>

                              </div>

                              <a href="bienservicio.php" class="small-box-footer"> <i class="fa fa-plus"></i></a>

                            </div>

                         

                        </div> -->





                            <!-- PARA CONSULTA DE BUSQUEDA DE COMPROBANTE -->

                    <!--   <form method="post" id="formulariotcambio2"  name="formulariotcambio2"  method="POST" >

                            <div class="small-box bg-green-active" >

                              <div class="inner" >

                                <p>TIPO DE CAMBIO </p>

                                    <div class="form-group has-feedback" id="divtcambio" name="divtcambio">

                                    <input type="hidden" name="idtcambio" id="idtcambio" value="<?php echo $idtipocambio; ?>" >

                                    <input type="date" name="fechatc" id="fechatc" value="<?php echo $fechatc; ?>" class=""  <?php  echo  $dfecha; ?>   >  

                                    <input type="text" name="compra" id="compra" placeholder="Compra" value="<?php  echo $tccompra;  ?> " class="">

                                    <input type="text" name="venta" id="venta" placeholder="Venta" value="<?php  echo $tcventa;  ?> " class="">

                                  </div>

                              

                                  <button type="submit" class="btn btn-info" name="btnguardartcambio" name="btnguardartcambio" value="Buscar">GUARDAR

                                    <i class="fa fa-money"></i>

                                  </button>

                                 

                                    

                                  </button>

                              </div>

                              

                            </div>

                          </form> -->









                           <!--   <div   class="col-lg-12 col-md-6 col-sm-6 col-xs-12"    >
                          <div class="small-box bg-green-active"  id="montoscaja" name="montoscaja"   >
                            <div class="inner" >
                                <p style="font-size: 20px;">CAJA <?php  echo $cajaestado;  ?></p>
                                <p style="font-size: 14px;">INICIAL</p>
                                <h4 >
                                  <div   >
                                  <strong  >S/ <?php echo number_format($montoi,2); ?></strong>
                                  </div>
                                </h4>
                                <p style="font-size: 14px;">FINAL</p>
                                <h4 >
                                  <strong>S/ <?php echo number_format($montof,2); ?></strong>
                                </h4>



                              </div>

                              <a data-toggle="modal" href="#modalcaja"  class="small-box-footer">CAJA<i class="fa fa-arrow-circle-right"></i></a>


                              <div class="icon">
                               <i class="ion ion-bag"><a  data-toggle="modal" href="#modalcaja" ><img src="../public/images/caja.png"></a></i>

                              </div>

                            </div>

                        </div> -->

          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <input type="checkbox" id="spoiler6"></input>
                        <label for="spoiler6">ACCESOS RÁPIDOS</label>
                          <div class="spoiler">
                          <div class="panel-body table-responsive">

                      ASDASDASDASDASD

                          </div>
                        </div>
                    
                    </div>




          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <input type="checkbox" id="spoiler5"></input>
                        <label for="spoiler5">VENTAS DE LA SEMANA BOLETA - FACTURA (SOLES)</label>
                          <div class="spoiler">
                          <div class="panel-body table-responsive">

                        <table id="tbllistado" class="table table-striped table-hover table-bordered table-condensed">
                          <thead align="center">
                            <th>LUNES </th>
                            <th >MARTES</th>
                            <th >MIERCOLES</th>
                            <th >JUEVES</th>
                            <th >VIERNES</th>
                            <th >SABADO</th>
                          </thead>
                          <tbody align="" >
                          <td><?php  echo number_format($lunes,2);?></td>
                          <td><?php  echo number_format($martes,2);?></td>
                          <td><?php  echo number_format($miercoles,2);?></td>
                          <td><?php  echo number_format($jueves,2);?></td>
                          <td><?php  echo number_format($viernes,2);?></td>
                          <td><?php  echo number_format($sabado,2);?></td>

                          </tbody>
                        </table>

                          </div>
                        </div>
                    
                    </div>



      <!--     <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 img-rounded">
                <div class="panel panel-primary">
                      <div class="panel panel-info">
                        <div class="panel-heading">ESTADO DE COMPROBANTES</div>
                          <div class="panel-body table-responsive">

                    <table id="tbllistado" class="table table-striped table-hover table-bordered table-condensed">
                          <thead >

                            <th>EMITIDOS </th>
                            <th>FIRMADOS</th>
                            <th>SUNAT</th>
                            <th>ANULADOS</th>
                            <th>FISICOS</th>
                          </thead>

                          <tbody align="" >

                          <td style="color:brown; font-size: 18px; text-align: center;"><a href="validarcomprobantes.php?estadoC=1" data-toggle="tooltip" title="Ir a emitidos"><?php  echo ($stEmitido);?></a></td>

                          <td style="color:red; font-size: 18px; text-align: center;"><a href="validarcomprobantes.php?estadoC=4" data-toggle="tooltip" title="Ir a firmados"><?php  echo ($stFirmado);?></a></td>

                          <td style="color:green; font-size: 18px; text-align: center;"><a href="validarcomprobantes.php?estadoC=5" data-toggle="tooltip" title="Ir a enviados a SUNAT"><?php  echo ($stAceptado);?></a></td>

                          <td style="color:green; font-size: 18px; text-align: center;"><a href="validarcomprobantes.php?estadoC=3" data-toggle="tooltip" title="Ir a anulados"><?php  echo ($stAnulado);?></a></td>

                          <td style="color:orange; font-size: 18px; text-align: center;"><a href="validarcomprobantes.php?estadoC=6" data-toggle="tooltip" title="Ir a fisicos"><?php  echo ($stFisico);?></a></td>                                                     

                          </tbody>

                        </table>



                              </div>
                        </div>
                      </div>
                    </div>
 -->


<!-- <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12" id="estadosDiv">
                  <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-hover table-bordered table-condensed" style="text-align: center; font-family: courier new;">
                          <caption style="text-align: center;">COTIZACIONES</caption>
                          <thead align="center" title="Estado de cotizaciones">
                            <th style=" text-align: center">EMITIDOS </th>
                            <th style=" text-align: center">APROBADOS</th>
                          </thead>
                          <tbody align="" >
                          <td style="color:brown; font-size: 18px; text-align: center;"><a href="cotizacion.php" data-toggle="tooltip" title="Ir a emitidos"><?php  echo ($stEmitidoCoti);?></a></td>
                          <td style="color:red; font-size: 18px; text-align: center;"><a href="cotizacion.php" data-toggle="tooltip" title="Ir a firmados"><?php  echo ($stAceptadoCoti);?></a></td>
                          </tbody>
                        </table>
                    </div>
          </div>
 -->




<!--           <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12" id="estadosDiv">
                  <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-hover table-bordered table-condensed" style="text-align: center; font-family: courier new;">
                          <caption style="text-align: center;">DOCUMENTOS COBRANZA</caption>
                          <thead align="center" title="Estado de cotizaciones">
                            <th  text-align: "center">EMITIDOS </th>
                            <th  text-align: "center">APROBADOS</th>
                          </thead>
                          <tbody align="" >
                          <td style="color:brown; font-size: 18px; text-align: center;"><a href="doccobranza.php" data-toggle="tooltip" title="Ir a emitidos"><?php  echo ($stEmitidoDcobranza);?></a></td>
                          <td style="color:red; font-size: 18px; text-align: center;"><a href="cotizacion.php" data-toggle="tooltip" title=""><?php  echo ($stAceptadoddcobranza);?></a></td>
                          </tbody>
                        </table>
                    </div>
          </div> -->


     </div>


                 


                        
                    




                    <!--Fin centro -->

                  </div><!-- /.box -->
                  </section><!-- /.content -->
              </div><!-- /.col -->

          <!-- </div>/.row -->

     

 

    </div><!-- /.content-wrapper -->

  <!--Fin-Contenido-->


  <div class="modal fade" id="ModalNnotificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 50% !important;" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <!-- <img src="../public/images/notificacion.png"> -->
           <h1 class="modal-title" id="fechaaviso">ALERTAS DEL DÍA DE HOY</h1>
        </div>

            <form name="formularionnotificacion" id="formularionnotificacion" method="POST">
                  <input type="hidden" name="fechaaviso" id="fechaaviso">
              <div class="table-responsive" id="">
            <table id="listanotificaciones" class="table table-sm table-striped table-bordered table-condensed table-hover nowrap">
                          <thead>
                            <th>Notificación</th>
                            <th>Documento</th>
                            <th>Cliente</th>
                            <th >Proxima aviso</th>
                            <th >---</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                        </table>
                </div>

     <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <!--   <button class="btn btn-primary" type="button" id="btnguardarnnotificacion" name="btnguardarnnotificacion" value="">
          <i class="fa fa-save"></i> OK
          </button> -->

          <button type="button" class="btn btn-danger" data-dismiss="modal">OK</button>         
     </div>

        <div class="modal-footer">
        </div> 
        </form>



      </div>
    </div>
  </div>  

 




  <div class="modal fade" id="ModalComprobantes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 30% !important;" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <!-- <img src="../public/images/notificacion.png"> -->
           <h1 class="modal-title" id="fechaaviso">COMPROBANTES PENDIENTES</h1>
        </div>
        
            <table id="listacomprobantes" class="table table-sm table-striped table-bordered table-condensed table-hover nowrap">
                          <thead>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Cantidad</th>
                            <th>Comprobante</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          
                        </table>
        
                

     <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <button type="button" class="btn btn-danger" data-dismiss="modal">OK</button>         
     </div>

        <div class="modal-footer">
        </div> 
      </div>
    </div>
  </div>


   <div class="modal fade" id="anuncio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 40% !important; opacity: 0.8" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           
           
        </div>
        
           <img src="../files/oferta/oferta.png">
        
        <div class="modal-footer">
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
<script src="../public/js/chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script>
<script type="text/javascript" src="scripts/caja.js"></script>


<script type="text/javascript">




   




$(document).ready(function () {


    $("#tourtip1").tourTip({
      title: "Emisión de cotizaciones",
      description: "Esta sección es para crear nuevas cotizaciones.",
      previous: true,
      position: 'right'
    });


  


    //$.tourTip.start();

  });







function reloadPage () { 
location.reload (true) 
}

  toastr.options = {
                closeButton: false,
                debug: false,
                newestOnTop: false,
                progressBar: false,
                rtl: false,
                positionClass: 'toast-bottom-full-width',
                preventDuplicates: false,
                onclick: null
            };


showComprobantes();

$("#formularionnotificacion").on("submit",function(e)
    {
        guardaryeditarnotificacion(e);
    });


var now = new Date();
var day = ("0" + now.getDate()).slice(-2);
var month = ("0" + (now.getMonth() + 1)).slice(-2);
var fechahoy = now.getFullYear()+"-"+(month)+"-"+(day);
$("#fechaaviso").val(fechahoy);

function guardaryeditarnotificacion(e)
{
    e.preventDefault(); //
    var formData = new FormData($("#formularionnotificacion")[0]);


    $.ajax({
        //url: "../ajax/ventas.php?op=editarnotificacion",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos)
        {                    
              //toastr.success(datos);  
              //tabla.ajax.reload();
        }

    });
    $("#ModalNnotificacion").modal('hide');
    $("#ModalComprobantes").modal('hide');
}



$(document).ready(function()
{
      showNotification();
      setTimeout(function () 
      {
        $("#ModalNnotificacion").modal('hide');
           //showComprobantes();
        }, 8000);

      

      // $("#anuncio").modal('show');
      // setTimeout(function () 
      // {
      //   $("#anuncio").modal('hide');
      //      //showComprobantes();
      //   }, 6000);



    

});








function nextM(idnotificacion)
{

    $.post("../ajax/ventas.php?op=avanzar", {idnotificacion : idnotificacion}, function(e){
            toastr.success(e);  
          }); 

}


function showNotification() { 
   tabla=$('#listanotificaciones').dataTable(
    {
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        searching:false,
        buttons: [],
        "ajax":
                {
                    url: '../ajax/ventas.php?op=notificaciones&fechanoti='+fechahoy,
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },

         "rowCallback": 
         function( row, data ) {
          if (data) {
            $("#ModalNnotificacion").modal('show');
          }
        },

        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();

};







function showComprobantes()
 { 
   tabla=$('#listacomprobantes2').dataTable(
    {
        "aProcessing": true,
        "aServerSide": true,
        "bPaginate": false,
        "paging": false,
        "bInfo": false,
        dom: 'Bfrtip',
        searching:false,
        lengthChange: false,
        
        
        buttons: [],
        "ajax":
                {
                    url: '../ajax/ventas.php?op=ComprobantesPendientes',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },

         "rowCallback": 
         function( row, data ) {
          if (data) {
            //$("#ModalComprobantes").modal('show');
          }
        },

        "fnDrawCallback": 
        function(oSettings) {
          $('.dataTables_paginate').hide();
        },

        "bDestroy": true,
        "iDisplayLength": 20,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();

}





function estadoNoti()
{
    var estanoti = document.getElementById("estadonoti").checked;
    if (estanoti==true) {
        $("#selestado").val("1");
    }else{
        $("#selestado").val("0");
    }
}



// $.post("../ajax/factura.php?op=datostemporizadopr", function(data)
//    {
//        data=JSON.parse(data);
//        if (data != null){
//        $('#idtemporizador').val(data.idtempo);
//        $('#estado').val(data.estado);
//        $("#tiempo").val(data.tiempo);
//        $("#tiempoN").val(data.tiempo);
//         }
//    });


// if ($('#estado').val()=='1') {
// $(document).ready(function () {
//     setInterval(function () {
//         //$("#estadosDiv").load();
//         $("#estadosDiv").load(" #estadosDiv");
//          $.ajax({
//             type: "POST",
//             url: '../ajax/ventas.php?op=listarValidarComprobantesSiempre',
//            });
//     }, 5000);
// });

//   $.ajax({
//             type: "POST",
//             url: '../ajax/ventas.php?op=listarValidarComprobantesSiempre',
//            });
// }



//setInterval ('reloadPage ()', '30000'); 

var ctx = document.getElementById("compras").getContext('2d');
var compras = new Chart(ctx, {


    type: 'bar',
    data: {
        labels: [<?php echo $mes; ?>],
        datasets: [{
            label:'Últimos 5 meses S/',
            data: [<?php echo $totalesc; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],

            borderWidth: 1

        }]

    }, 

    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

 

 

 

var ctx = document.getElementById("ventas").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasv; ?>],
        datasets: [{
            label: 'Últimos 3 meses S/',
            data: [<?php echo $totalesv; ?>],
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255,99,132,1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true

                }

            }]

        }

    }

});



  
  

</script>





</script>

 





<?php 

}

ob_end_flush();

?>