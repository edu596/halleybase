var tabla;

//Función que se ejecuta al inicio
function init(){
  mostrarform(false);
  listar();

  $("#formulario").on("submit",function(e)
  {
    guardaryeditar(e);  
  })

  $("#formnewcategoria").on("submit",function(e)
  {
    guardaryeditarCategoria(e); 
  })

  //Cargamos los items al select familia
  $.post("../ajax/platos.php?op=selectCategoria", function(r){
              $("#idcategoria").html(r);
              $('#idcategoria').selectpicker('refresh');
  });


  //$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
  $("#codigo").val("");
  $("#nombre").val("");
  $("#precio").val("");
  //$("#imagenmuestra").attr("src","");
  //$("#imagenactual").val("");
  $("#idplato").val("");
  $("#Nnombre").val("");
}


function limpiarcategoria()
{
$("#nombrec").val("");
}



//Función mostrar formulario
function mostrarform(flag)
{
  limpiar();
  if (flag)
  {
    $("#listadoregistros").hide();
    $("#formularioregistros").show();
    $("#btnGuardar").prop("disabled",false);
    $("#btnagregar").hide();
  }
  else
  {
    $("#listadoregistros").show();
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

  tabla=$('#tbllistado').dataTable(
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
          url: '../ajax/platos.php?op=listar',
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
    url: "../ajax/platos.php?op=guardaryeditar",
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
  limpiar();
}

function mostrar(idplato)
{
  $.post("../ajax/platos.php?op=mostrar", {idplato : idplato}, function(data, status)
  {
    data = JSON.parse(data);    
    mostrarform(true);

    $("#idplato").val(data.idplato);
    //$("#tipop").val(data.tipo);
    $("#idcategoria").val(data.idcategoria);
    $("#codigo").val(data.codigo);
    $("#nombre").val(data.nombre);
    $("#precio").val(data.precio);

    $("#imagenmuestra").show();
    if (data.imagenmuestra=="") {
    $("#imagenmuestra").attr("src","../files/platos/sinplato.png");
    }else{
      $("#imagenmuestra").attr("src","../files/platos/" + data.imagen);
    }
    
    $("#imagenactual").val(data.imagen);
    $("#imagen").val("");

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

function guardaryeditarCategoria(e)
{
  e.preventDefault(); //No se activará la acción predeterminada del evento
  
  var formData = new FormData($("#formnewcategoria")[0]);

  $.ajax({
    url: "../ajax/platos.php?op=guardaryeditarCategoria",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function(datos)
      {                    
            bootbox.alert(datos);           
            $("#Nnombre").val("");
            tabla.ajax.reload();
            actcategoria();
      }
  });
  limpiarcategoria();
  $("#ModalNcategoria").modal('hide');
}


function actcategoria(){
$.post("../ajax/platos.php?op=selectCategoria", function(r){
              $("#idcategoria").html(r);
              $('#idcategoria').selectpicker('refresh');
  });

}



function actalunidad(){
//Cargamos los items al select almacen
  $.post("../ajax/articulo.php?op=selectUnidad", function(r){
              $("#unidad_medida").html(r);
              $('#unidad_medida').selectpicker('refresh');
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

  function costoco() {
       document.getElementById('costo_compra').focus();  
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
       document.getElementById('comprast').focus();  
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
}


init();