var tabla;
var tablas;

 toastr.options = {
                closeButton: false,
                debug: false,
                newestOnTop: false,
                progressBar: false,
                rtl: false,
                positionClass: 'toast-bottom-center',
                preventDuplicates: false,
                onclick: null
            };


//PARA ACTUALIZAR ESTADO 
let onOff = true;
function combus(){
    if (!onOff) {
        onOff=true;
        $("#combustible").val("0");
    }else{

        onOff=false;
        $("#combustible").val("1");
    }
    }
//PARA ACTUALIZAR ESTADO 




var div = document.getElementById("masdatos");
div.style.display = "none";


//Función que se ejecuta al inicio

function init(){

  mostrarform(false);

  listar();
  listarservicios();



  $("#formulario").on("submit",function(e)

  {

    guardaryeditar(e);  

  })



  $("#formnewfamilia").on("submit",function(e)

  {

    guardaryeditarFamilia(e); 

  })





  $("#formnewalmacen").on("submit",function(e)

  {

    guardaryeditarAlmacen(e); 

  })





  $("#formnewumedida").on("submit",function(e)

  {

    guardaryeditarUmedida(e); 

  })





  $("#formprintbar").on("submit",function(e)

  {

    

  })



  //Cargamos los items al select familia

  $.post("../ajax/articulo.php?op=selectFamilia", function(r){
              $("#idfamilia").html(r);
              $('#idfamilia').selectpicker('refresh');
  });





    //Cargamos los items al select almacen

    $idempresa=$("#idempresa").val();

  $.post("../ajax/articulo.php?op=selectAlmacen&idempresa="+$idempresa, function(r){
              $("#idalmacen").html(r);
              $('#idalmacen').selectpicker('refresh');

  });



  //Cargamos los items al select unidad medida

  $.post("../ajax/articulo.php?op=selectUnidad", function(r){
              $("#unidad_medida").html(r);
              $('#unidad_medida').selectpicker('refresh');

              $("#umedidacompra").html(r);
              $('#umedidacompra').selectpicker('refresh');

  });





  $("#imagenmuestra").hide();

}



//Función limpiar

function limpiar()

{

  $("#codigo").val("");

  $("#codigo_proveedor").val("");

  $("#nombre").val("");

  $("#costo_compra").val("");

  $("#saldo_iniu").val("");

  $("#valor_iniu").val("");

  $("#saldo_finu").val("");

  $("#valor_finu").val("");

  $("#stock").val("");

  $("#comprast").val("");

  $("#ventast").val("");

  $("#portador").val("");

  $("#merma").val("");

  $("#valor_venta").val("");

  $("#imagenmuestra").attr("src","");

  $("#imagenactual").val("");

  $("#print").hide();

  $("#idarticulo").val("");

  $("#Nnombre").val("");

  $("#codigosunat").val("");

  $("#ccontable").val("");

  $("#precio2").val("");

  $("#precio3").val("");





  //Nuevos campos

    $("#cicbper").val("");

    $("#nticbperi").val("");

    $("#ctticbperi").val("");

    $("#mticbperu").val("");

    //Nuevos campos



    $("#lote").val("");

    $("#marca").val("");

    $("#fechafabricacion").val("");

    $("#fechavencimiento").val("");

    $("#procedencia").val("");

    $("#fabricante").val("");



    $("#registrosanitario").val("");

    $("#fechaingalm").val("");

    $("#fechafinalma").val("");

    $("#proveedor").val("");

    $("#seriefaccompra").val("");

    $("#numerofaccompra").val("");

    $("#fechafacturacompra").val("");



    $("#preview").empty();



    $("#limitestock").val("");

    $("#tipoitem").val("productos");



    $("#equivalencia").val("");

    $("#factorc").val("");

    $("#fconversion").val("");

    $("#descripcion").val("");





}



function limpiaralmacen()

{

$("#nombrea").val("");

}




function mostrarcampos()

{

var x = document.getElementById("chk1").checked; 
var div = document.getElementById("masdatos");
if (x) {
  div.style.display = "block";
}else{
  div.style.display = "none";
}


}




function limpiarcategoria()

{

$("#nombrec").val("");

}





function limpiarumedida()

{

$("#nombreu").val("");

$("#abre").val("");

$("#equivalencia2").val("");

}



//Función mostrar formulario

function mostrarform(flag)

{

  limpiar();

  if (flag)

  {

    $("#listadoregistros").hide();
    $("#listadoregistrosservicios").hide();
    $("#formularioregistros").show();
    $("#btnGuardar").prop("disabled",false);
    $("#btnagregar").hide();
    $("#costo_compra").attr('readonly', false);
    $("#saldo_iniu").attr('readonly', false);
    $("#valor_iniu").attr('readonly', false);
    $("#saldo_finu").attr('readonly', false);
    $("#valor_finu").attr('readonly', false);
    $("#stock").attr('readonly', false);
    $("#comprast").attr('readonly', false);
    $("#ventast").attr('readonly', false);
    $("#preview").empty();



  }

  else

  {

    $("#listadoregistros").show();
    $("#listadoregistrosservicios").show();
    $("#formularioregistros").hide();
    $("#btnagregar").show();

  }

}



//Función cancelarform

function cancelarform()
{
  limpiar();
  mostrarform(false);
}





//Función Listar

function listar()

{
  var $idempresa=$("#idempresa").val();
  tabla=$('#tbllistado').dataTable(
  {
    "aProcessing": true,//Activamos el procesamiento del datatables
      "aServerSide": true,//Paginación y filtrado realizados por el servidor

      dom: 'Bfrtip',//Definimos los elementos del control de tabla


      buttons: [              

                {

                messageTop: "PRODUCTOS" ,  
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'

            },

            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {

                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'

            },

            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'

            }

            ],

    "ajax":
        {
          url: '../ajax/articulo.php?op=listar&idempresa='+$idempresa,
          type : "get",
          dataType : "json",            
          error: function(e){
          console.log(e.responseText);  

          }

        },

    "bDestroy": true,
    "iDisplayLength": 5,//Paginación
      "order": [[ 4, "desc" ]]//Ordenar (columna,orden)
  }).DataTable();

}





function listarservicios()

{
  var $idempresa=$("#idempresa").val();
  tablas=$('#tbllistadoservicios').dataTable(
  {
    "aProcessing": true,//Activamos el procesamiento del datatables
      "aServerSide": true,//Paginación y filtrado realizados por el servidor
      dom: 'Bfrtip',//Definimos los elementos del control de tabla
      buttons: [              

                {

                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'

            },

            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {

                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'

            },

            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'

            }

            ],

    "ajax":
        {
          url: '../ajax/articulo.php?op=listarservicios&idempresa='+$idempresa,
          type : "get",
          dataType : "json",            
          error: function(e){
          console.log(e.responseText);  

          }

        },

    "bDestroy": true,
    "iDisplayLength": 5,//Paginación
      "order": [[ 4, "desc" ]]//Ordenar (columna,orden)
  }).DataTable();

}





//Función para guardar o editar



function guardaryeditar(e)

{

  e.preventDefault(); //No se activará la acción predeterminada del evento
  $("#btnGuardar").prop("disabled",true);
  var formData = new FormData($("#formulario")[0]);



  $.ajax({
    url: "../ajax/articulo.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function(datos)
      {                    

            bootbox.alert(datos);           
            mostrarform(false);
            tabla.ajax.reload();
      }

  });
 tabla.ajax.reload();
  limpiar();

}



function mostrar(idarticulo)

{

  $.post("../ajax/articulo.php?op=mostrar",{idarticulo : idarticulo}, function(data, status)

  {

    data = JSON.parse(data);    

    mostrarform(true);

    $("#idarticulo").val(data.idarticulo);
    $("#idfamilia").val(data.idfamilia);
    $('#idfamilia').selectpicker('refresh');
    $("#idalmacen").val(data.idalmacen);
    $('#idalmacen').selectpicker('refresh');
    $("#unidad_medida").val(data.unidad_medida);
    $('#unidad_medida').selectpicker('refresh');
    $("#codigo_proveedor").val(data.codigo_proveedor);
    $("#codigo").val(data.codigo);
    $("#nombre").val(data.nombre);
    $("#unidad_medidad").val(data.unidad_medidad);
    $("#costo_compra").val(data.costo_compra);
    //$("#costo_compra").attr('readonly', true);
    $("#saldo_iniu").val(data.saldo_iniu);
    //$("#saldo_iniu").attr('readonly', true);
    $("#valor_iniu").val(data.valor_iniu);
    //$("#valor_iniu").attr('readonly', true);
    $("#saldo_finu").val(data.saldo_finu);
    //$("#saldo_finu").attr('readonly', true);
    $("#valor_finu").val(data.valor_finu);
    //$("#valor_finu").attr('readonly', true);
    $("#stock").val(data.stock);
    //$("#stock").attr('readonly', true);
    $("#comprast").val(data.comprast);
    //$("#comprast").attr('readonly', true);
    $("#ventast").val(data.ventast);
    //$("#ventast").attr('readonly', true);
    $("#portador").val(data.portador);
    $("#merma").val(data.merma);
    $("#valor_venta").val(data.precio_venta);
    $("#imagenmuestra").show();

    if (data.imagen=="") {
        $("#imagenmuestra").attr("src","../files/articulos/simagen.png");
        $("#imagenactual").val(data.imagen);
        $("#imagen").val("");
    }else{
        $("#imagenmuestra").attr("src","../files/articulos/" + data.imagen);
        $("#imagenactual").val(data.imagen);
        $("#imagen").val("");
    }



    $("#codigosunat").val(data.codigosunat);
    $("#ccontable").val(data.ccontable);
    $("#precio2").val(data.precio2);
    $("#precio3").val(data.precio3);

    $("#stockprint").val(data.stock);
    $("#codigoprint").val(data.codigo);
    $("#precioprint").val(data.precio_venta);

    //Nuevos campos

    $("#cicbper").val(data.cicbper);
    $("#nticbperi").val(data.nticbperi);
    $("#ctticbperi").val(data.ctticbperi);
    $("#mticbperu").val(data.mticbperu);
    //Nuevos campos

    $("#codigott").val(data.codigott);
    $('#codigott').selectpicker('refresh');
    $("#desctt").val(data.desctt);
    $('#desctt').selectpicker('refresh');

    $("#codigointtt").val(data.codigointtt);

    $('#codigointtt').selectpicker('refresh');

    $("#nombrett").val(data.nombrett);

    $('#nombrett').selectpicker('refresh');

    var checkBoxC = document.getElementById("combustible");
    if (data.combustible=="1") {
      onOff=true; 
      checkBoxC.checked = true;
    }else{ 
      onOff=false;
      checkBoxC.checked = false;
    }

    







    //Nuevos campos

    $("#lote").val(data.lote);

    $("#marca").val(data.marca);

     $("#fechafabricacion").val(data.fechafabricacion);

    $("#fechavencimiento").val(data.fechavencimiento);

    $("#procedencia").val(data.procedencia);

    $("#fabricante").val(data.fabricante);

    $("#registrosanitario").val(data.registrosanitario);

    $("#fechaingalm").val(data.fechaingalm);

    $("#fechafinalma").val(data.fechafinalma);

    $("#proveedor").val(data.proveedor);

    $("#seriefaccompra").val(data.seriefaccompra);

    $("#numerofaccompra").val(data.numerofaccompra);

    $("#fechafacturacompra").val(data.fechafacturacompra);



    $("#limitestock").val(data.limitestock);

    $("#tipoitem").val(data.tipoitem);



    $("#umedidacompra").val(data.umedidacompra);

    $('#umedidacompra').selectpicker('refresh');





    $("#factorc").val(data.factorc);

    $("#descripcion").val(data.descrip);


    var stt=$("#stock").val();
    var fc=$("#factorc").val();

    var stfc= stt * fc;

    $("#fconversion").val(stfc);

    //Nuevos campos

    

    generarbarcode();



  })

}



//Función para desactivar registros

function desactivar(idarticulo)

{

  bootbox.confirm("¿Está Seguro de desactivar el artículo?", function(result){

    if(result)

        {

          $.post("../ajax/articulo.php?op=desactivar", {idarticulo : idarticulo}, function(e){

            bootbox.alert(e);

              tabla.ajax.reload();

          }); 

        }

  })

}



//Función para activar registros

function activar(idarticulo)

{

  bootbox.confirm("¿Está Seguro de activar el Artículo?", function(result){

    if(result)

        {

          $.post("../ajax/articulo.php?op=activar", {idarticulo : idarticulo}, function(e){

            bootbox.alert(e);

              tabla.ajax.reload();

          }); 

        }

  })

}



//función para generar el código de barras

function generarbarcode()

{

  codigo=$("#codigo").val();

  // descrip=$("#nombre").val();

  // unidadm=$("#unidad_medida").val();

  // codigof=codigo.concat(descrip, unidadm);

  JsBarcode("#barcode", codigo, {
    format: "code128",
  });
  $("#print").show();

}



//Función para imprimir el Código de barras

function imprimir()

{

  $("#print").printArea();

}





function calcula_valor_ini()

{

costo_compra=$("#costo_compra").val();

saldo_iniu=$("#saldo_iniu").val();



resu=costo_compra * saldo_iniu;



$("#valor_iniu").val(resu.toFixed(2));

$("#saldo_finu").val(saldo_iniu);

}



function sfinalstock()

{

sf=$("#saldo_finu").val();

$("#stock").val(sf);

}







 





function mayus(e) {

     e.value = e.value.toUpperCase();

}



function guardaryeditarFamilia(e)

{

  e.preventDefault(); //No se activará la acción predeterminada del evento

  

  var formData = new FormData($("#formnewfamilia")[0]);



  $.ajax({

    url: "../ajax/familia.php?op=guardaryeditar",

      type: "POST",

      data: formData,

      contentType: false,

      processData: false,



      success: function(datos)

      {                    

            bootbox.alert(datos);           

            $("#Nnombre").val("");

            tabla.ajax.reload();

            actfamilia();

      }

  });

  limpiarcategoria();

  $("#ModalNfamilia").modal('hide');

}





function guardaryeditarAlmacen(e)

{

  e.preventDefault(); //No se activará la acción predeterminada del evento

  

  var formData = new FormData($("#formnewalmacen")[0]);



  $.ajax({

    url: "../ajax/familia.php?op=guardaryeditaralmacen",

      type: "POST",

      data: formData,

      contentType: false,

      processData: false,



      success: function(datos)

      {                    

            bootbox.alert(datos);           

            tabla.ajax.reload();

            actalmacen();

      }

  });

  limpiaralmacen();

  $("#ModalNalmacen").modal('hide');

}



function guardaryeditarUmedida(e)

{

  e.preventDefault(); //No se activará la acción predeterminada del evento

  

  var formData = new FormData($("#formnewumedida")[0]);



  $.ajax({

    url: "../ajax/familia.php?op=guardaryeditarUmedida",

      type: "POST",

      data: formData,

      contentType: false,

      processData: false,



      success: function(datos)

      {                    

            bootbox.alert(datos);           

            tabla.ajax.reload();

            actalunidad();

      }

  });

  limpiarumedida();

  $("#ModalNumedida").modal('hide');

}







function actfamilia(){

$.post("../ajax/articulo.php?op=selectFamilia", function(r){

              $("#idfamilia").html(r);

              $('#idfamilia').selectpicker('refresh');



  });



}





function actalmacen(){

//Cargamos los items al select almacen

   $idempresa=$("#idempresa").val();

  $.post("../ajax/articulo.php?op=selectAlmacen&idempresa="+$idempresa, function(r){

              $("#idalmacen").html(r);

              $('#idalmacen').selectpicker('refresh');

  });

}





function actalunidad(){

//Cargamos los items al select almacen

  $.post("../ajax/articulo.php?op=selectUnidad", function(r){

              $("#unidad_medida").html(r);

              $('#unidad_medida').selectpicker('refresh');



              $("#umedidacompra").html(r);

              $('#umedidacompra').selectpicker('refresh');

  });

}



document.onkeypress = stopRKey; 





function stopRKey(evt) {

var evt = (evt) ? evt : ((event) ? event : null);

var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);

if ((evt.keyCode == 13) && (node.type=="text")) {return false;}

}





function focusfamil(){

  document.getElementById('idfamilia').focus();  

}



function tipoitem(){

  document.getElementById('tipoitem').focus();  

}



function focuscodprov(){

  document.getElementById('codigo_proveedor').focus();  

}



function focusnomb(e, field) {

    if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('nombre').focus();  

    }

 }



 function focusum(e, field) {

    if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('unidad_medida').focus();  

    }

 }



 function limitestockf(e, field) {

    if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('limitestock').focus();  

    }

 }



  function costoco() {



  //idun= $('#unidad_medida').val();

  //$.post("../ajax/articulo.php?op=mostrarequivalencia&iduni="+idun, function(data,status)

    //{

      // data=JSON.parse(data);

       //$('#factorc').val(data.equivalencia);

   //});





       document.getElementById('factorc').focus();  

 }



  function umventa(e, field) {

    if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('unidad_medida').focus();  

    }

 }





 function cinicial() {

       document.getElementById('factorc').focus();  

 }





//Función para aceptar solo numeros con dos decimales

  function focussaldoi(e, field) {

  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46

  key = e.keyCode ? e.keyCode : e.which



  if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('saldo_iniu').focus();  

    }

  // backspace

          if (key == 8) return true;

          if (key == 9) return true;

        if (key > 47 && key < 58) {

          if (field.val() === "") return true;

          var existePto = (/[.]/).test(field.val());

          if (existePto === false){

              regexp = /.[0-9]{10}$/;

          }

          else {

            regexp = /.[0-9]{2}$/;

          }

          return !(regexp.test(field.val()));

        }



        if (key == 46) {

          if (field.val() === "") return false;

          regexp = /^[0-9]+$/;

          return regexp.test(field.val());

        }

        return false;

}



  function valori(e, field) {

  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46

  key = e.keyCode ? e.keyCode : e.which



  if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('valor_iniu').focus();  

    }

  // backspace

          if (key == 8) return true;

          if (key == 9) return true;

        if (key > 47 && key < 58) {

          if (field.val() === "") return true;

          var existePto = (/[.]/).test(field.val());

          if (existePto === false){

              regexp = /.[0-9]{10}$/;

          }

          else {

            regexp = /.[0-9]{2}$/;

          }

          return !(regexp.test(field.val()));

        }



        if (key == 46) {

          if (field.val() === "") return false;

          regexp = /^[0-9]+$/;

          return regexp.test(field.val());

        }

        return false;

}



function saldof(e, field) {

  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46

  key = e.keyCode ? e.keyCode : e.which



  if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('saldo_finu').focus();  

    }

  // backspace

          if (key == 8) return true;

          if (key == 9) return true;

        if (key > 47 && key < 58) {

          if (field.val() === "") return true;

          var existePto = (/[.]/).test(field.val());

          if (existePto === false){

              regexp = /.[0-9]{10}$/;

          }

          else {

            regexp = /.[0-9]{2}$/;

          }

          return !(regexp.test(field.val()));

        }



        if (key == 46) {

          if (field.val() === "") return false;

          regexp = /^[0-9]+$/;

          return regexp.test(field.val());

        }

        return false;

}

  



  function valorf(e, field) {

  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46

  key = e.keyCode ? e.keyCode : e.which



  if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('valor_finu').focus();  

    }

  // backspace

          if (key == 8) return true;

          if (key == 9) return true;

        if (key > 47 && key < 58) {

          if (field.val() === "") return true;

          var existePto = (/[.]/).test(field.val());

          if (existePto === false){

              regexp = /.[0-9]{10}$/;

          }

          else {

            regexp = /.[0-9]{2}$/;

          }

          return !(regexp.test(field.val()));

        }



        if (key == 46) {

          if (field.val() === "") return false;

          regexp = /^[0-9]+$/;

          return regexp.test(field.val());

        }

        return false;

}



function st(e, field) {

  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46

  key = e.keyCode ? e.keyCode : e.which



  if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('stock').focus();  

    }

  // backspace

          if (key == 8) return true;

          if (key == 9) return true;

        if (key > 47 && key < 58) {

          if (field.val() === "") return true;

          var existePto = (/[.]/).test(field.val());

          if (existePto === false){

              regexp = /.[0-9]{10}$/;

          }

          else {

            regexp = /.[0-9]{2}$/;

          }

          return !(regexp.test(field.val()));

        }



        if (key == 46) {

          if (field.val() === "") return false;

          regexp = /^[0-9]+$/;

          return regexp.test(field.val());

        }

        return false;

}



function totalc(e, field) {

  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46

  key = e.keyCode ? e.keyCode : e.which



  if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('valor_venta').focus(); 
          var stt=$("#stock").val();
          var fc=$("#factorc").val();
          var stfc= stt * fc;
          $("#fconversion").val(stfc);

    }

  // backspace

          if (key == 8) return true;

          if (key == 9) return true;

        if (key > 47 && key < 58) {

          if (field.val() === "") return true;

          var existePto = (/[.]/).test(field.val());

          if (existePto === false){

              regexp = /.[0-9]{10}$/;

          }

          else {

            regexp = /.[0-9]{2}$/;

          }

          return !(regexp.test(field.val()));

        }



        if (key == 46) {

          if (field.val() === "") return false;

          regexp = /^[0-9]+$/;

          return regexp.test(field.val());

        }

        return false;




}



function totalv(e, field) {

  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46

  key = e.keyCode ? e.keyCode : e.which



  if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('ventast').focus();  

    }

  // backspace

          if (key == 8) return true;

          if (key == 9) return true;

        if (key > 47 && key < 58) {

          if (field.val() === "") return true;

          var existePto = (/[.]/).test(field.val());

          if (existePto === false){

              regexp = /.[0-9]{10}$/;

          }

          else {

            regexp = /.[0-9]{2}$/;

          }

          return !(regexp.test(field.val()));

        }



        if (key == 46) {

          if (field.val() === "") return false;

          regexp = /^[0-9]+$/;

          return regexp.test(field.val());

        }

        return false;

}



function porta(e, field) {

  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46

  key = e.keyCode ? e.keyCode : e.which



  if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('portador').focus();  

    }

  // backspace

          if (key == 8) return true;

          if (key == 9) return true;

        if (key > 47 && key < 58) {

          if (field.val() === "") return true;

          var existePto = (/[.]/).test(field.val());

          if (existePto === false){

              regexp = /.[0-9]{10}$/;

          }

          else {

            regexp = /.[0-9]{2}$/;

          }

          return !(regexp.test(field.val()));

        }



        if (key == 46) {

          if (field.val() === "") return false;

          regexp = /^[0-9]+$/;

          return regexp.test(field.val());

        }

        return false;

}



function mer(e, field) {

  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46

  key = e.keyCode ? e.keyCode : e.which



  if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('merma').focus();  

    }

  // backspace

          if (key == 8) return true;

          if (key == 9) return true;

        if (key > 47 && key < 58) {

          if (field.val() === "") return true;

          var existePto = (/[.]/).test(field.val());

          if (existePto === false){

              regexp = /.[0-9]{10}$/;

          }

          else {

            regexp = /.[0-9]{2}$/;

          }

          return !(regexp.test(field.val()));

        }



        if (key == 46) {

          if (field.val() === "") return false;

          regexp = /^[0-9]+$/;

          return regexp.test(field.val());

        }

        return false;

}



function preciov(e, field) {

  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46

  key = e.keyCode ? e.keyCode : e.which



  if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('valor_venta').focus();  

    }

  // backspace

          if (key == 8) return true;

          if (key == 9) return true;

        if (key > 47 && key < 58) {

          if (field.val() === "") return true;

          var existePto = (/[.]/).test(field.val());

          if (existePto === false){

              regexp = /.[0-9]{10}$/;

          }

          else {

            regexp = /.[0-9]{2}$/;

          }

          return !(regexp.test(field.val()));

        }



        if (key == 46) {

          if (field.val() === "") return false;

          regexp = /^[0-9]+$/;

          return regexp.test(field.val());

        }

        return false;

}





function limitest(e, field) {

  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46

  key = e.keyCode ? e.keyCode : e.which



  if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('unidad_medida').focus();  

    }

  // backspace

          if (key == 8) return true;

          if (key == 9) return true;

        if (key > 47 && key < 58) {

          if (field.val() === "") return true;

          var existePto = (/[.]/).test(field.val());

          if (existePto === false){

              regexp = /.[0-9]{10}$/;

          }

          else {

            regexp = /.[0-9]{2}$/;

          }

          return !(regexp.test(field.val()));

        }



        if (key == 46) {

          if (field.val() === "") return false;

          regexp = /^[0-9]+$/;

          return regexp.test(field.val());

        }

        return false;

}





function codigoi(e, field) {

  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46

  key = e.keyCode ? e.keyCode : e.which



  if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('codigo').focus();  

    }

  // backspace

          if (key == 8) return true;

          if (key == 9) return true;

        if (key > 47 && key < 58) {

          if (field.val() === "") return true;

          var existePto = (/[.]/).test(field.val());

          if (existePto === false){

              regexp = /.[0-9]{10}$/;

          }

          else {

            regexp = /.[0-9]{2}$/;

          }

          return !(regexp.test(field.val()));

        }



        if (key == 46) {

          if (field.val() === "") return false;

          regexp = /^[0-9]+$/;

          return regexp.test(field.val());

        }

        return false;

}





$(".modal-wide").on("show.bs.modal", function() {

  var height = $(window).height() - 200;

  $(this).find(".modal-body").css("max-height", height);

});



function unidadvalor()

{

  valor=$("#nombreu").val();

  $("#abre").val(valor);

}

    





function refrescartabla()

{

tabla.ajax.reload();
tablas.ajax.reload();

}







document.getElementById("imagen").onchange = function(e) {
  // Creamos el objeto de la clase FileReader
  let reader = new FileReader();
  // Leemos el archivo subido y se lo pasamos a nuestro fileReader
  reader.readAsDataURL(e.target.files[0]);
  // Le decimos que cuando este listo ejecute el código interno
  reader.onload = function(){
    let preview = document.getElementById('preview'),
            image = document.createElement('img');

    image.src = reader.result;
    preview.innerHTML = '';
    preview.append(image);
    toastr.success('Imagen cargada');
  };

}







function mostrarequivalencia()

{

      

  idun= $('#unidad_medida').val();

  $.post("../ajax/articulo.php?op=mostrarequivalencia&iduni="+idun, function(data,status)

    {

       data=JSON.parse(data);

       $('#equivalencia').val(data.equivalencia);

   });



}







function validarcodigo() {



  cod= $('#codigo').val();

  $.post("../ajax/articulo.php?op=validarcodigo&cdd="+cod, function(data,status)

    {

      data=JSON.parse(data);

      

      if (data.codigo= cod) {

        alert("código Existe, debe cambiarlo");

        document.getElementById('codigo').focus();  

      }





   });





       

 }






 function generarcodigonarti()
 {
    //alert("asdasdas");
    var caracteres1 = $("#nombre").val();
    var codale = "";
    codale=caracteres1.substring(-3,3);
    var caracteres2 = "ABCDEFGHJKMNPQRTUVWXYZ012346789";
    codale2 = "";
       for (i=0; i<3; i++) {
        var autocodigo="";
        codale2 += caracteres2.charAt(Math.floor(Math.random()*caracteres2.length)); 
    }
        $("#codigo").val(codale+codale2);
       
  }





init();