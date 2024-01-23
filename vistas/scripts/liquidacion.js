var tabla;
var tablas;
var cont=0;
var detalles=0;

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



//Función que se ejecuta al inicio

function init()
{

  mostrarform(false);
  listar();
  
  
  $("#formulario").on("submit",function(e)
  {
    guardaryeditar(e);  

  })

    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fechaemision').val(today);

   



}
  

 



function seltipoliq()
  {
    opttp=$("#tservicio").val();
    var x = document.getElementById("divvuelo");
    var y = document.getElementById("divservicio");
    if (opttp=="s")
    {

      x.style.display = "none";
      y.style.display = "block";
        

    

    }else{
    	 
        y.style.display = "none";
        x.style.display = "block";
        $(".filas").remove();
        detallevuelo();
        
    }

  }


  function detallevuelo()
  {
  	var fila='<tr class="filas" id="fila'+cont+'">'+
  	'<td><i class="fa fa-close" onclick="eliminarDetalle('+cont+')" data-toggle="tooltip" title="Eliminar item"></i></td>'+
  	'<td><input type="text" name="aerol[]" id=" aerol[]" onkeyup="mayus(this)"></td>'+
  	'<td><input type="text" name="nvuelo[]" id="nvuelo[]" ></td>'+
  	'<td><input type="date" name="fecha[]" id="fecha[]" ></td>'+
  	'<td><input type="text" name="destino[]" id="destino[]" onkeyup="mayus(this)"></td>'+
  	'<td><input type="time" name="hsalida[]" id="hsalida[]" value="08:00" max="23:59" min="00:00"></td>'+
  	'<td><input type="time" name="hretorno[]" id="hretorno[]" value="08:00" max="23:59" min="00:00" onkeypress="nextf(event, this)">'+
    '<input type="hidden"   name=detallevutl[] id=detallevutl[] value="dvuel"></td>'+
  	'<td><button type="button" onclick="detallevuelo()">Vuelo</button><button type="button" onclick="detalletl()">TL</button>  </td>'+
  	'</tr>'
  	cont++;
  	$('#detalles').append(fila);
  		detalles=detalles+1;
  }


   function detalletl()
  {
  	var fila='<tr class="filas" id="fila'+cont+'">'+
  	'<td><i class="fa fa-close" onclick="eliminarDetalle('+cont+')" data-toggle="tooltip" title="Eliminar item"></i></td>'+
  	'<td><input type="text" name="aerol[]" id=" aerol[]" onkeyup="mayus(this)"></td>'+
  	'<td colspan="5"><textarea  id="tldesc[]" name="tldesc[]" class="" cols="40" rows="2"></textarea></td>'+
  	'<td><button type="button" onclick="detallevuelo()">Vuelo</button>   <button type="button" onclick="detalletl()">TL</button>'+
    '<input type="hidden"  name=detallevutl[] id=detallevutl[] value="dtl"></td>'+
  	'</tr>'
  	cont++;
  	$('#detalles').append(fila);
  		detalles=detalles+1;
  }




function nextf(e, field) {
  key = e.keyCode ? e.keyCode : e.which
  if(e.keyCode===13  && !e.shiftKey)
    {
       detallevuelo();
    }
}

  function eliminarDetalle(indice){
    $("#fila" + indice).remove();
    detalles=detalles-1;
    actualizanorden();
  }

  function actualizanorden()
{
var total = document.getElementsByName("aerol[]");
var cont=0;
 for (var i = 0; i <= total.length; i++) {
        var cont=total[i];
        //cont.value=i+1;
    }//Final de for
}

function mayus(e) {
     e.value = e.value.toUpperCase();
}






  seltipoliq();




//Función limpiar

function limpiar()

{

  $("#idliquidacion").val("");
  $("#creserv").val("");
  $("#dnir").val("");
  $("#idcliente").val("");
  $("#datoscli").val("");
  $("#condiciones").val("");
  $("#tarifanore").val("");
  $("#file").val("");
  $("#programa").val("");
  $("#observaciones").val("");
  $("#restricciones").val("");
    $("#condiciones").val("");
  $("#tarifanore").val("");
  $("#item").val("");
  $("#precio").val("");
  $("#cantidad").val("");
  $("#total").val("");
  $("#entidadb").val("");
  $("#tipocuenta").val("");
  $("#titularc").val("");
  $("#ncuenta").val("");
  $("#codigoint").val("");
  $(".filas").remove();

  $("#tservicio").val("s");
  $("#nombrescli").val("");
  $("#apellidoscli").val("");
  $("#nombrecom").val("");




}

function focusTest(el)
{
   el.select();
}

function NumCheck(e, field) {
  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
  key = e.keyCode ? e.keyCode : e.which
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


function calculototal()
{
    var cantidad=$("#cantidad").val();
    var precio=$("#precio").val();

    var total=cantidad * precio;
    $("#total").val(separator(total));
}


document.onkeypress = stopRKey; 

//Función mostrar formulario
function mostrarform(flag)

{

 $.post("../ajax/liquidacion.php?op=datoscuentas", function(data){
            data=JSON.parse(data);
            $("#ncuenta").val(data.cuenta1);        
            $("#codigoint").val(data.cuentacci1);        
            $("#entidadb").val(data.banco1);        
            $("#titularc").val(data.nombre_comercial);        
    });
  

  if (flag)

  {

    $("#listadoregistros").hide();
    $("#listadoregistrosservicios").hide();
    $("#formularioregistros").show();
    $("#btnGuardar").prop("disabled",false);
    $("#btnagregar").hide();
    $("#preview").empty();
    limpiar();

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

                //messageTop: "PRODUCTOS" ,  
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
          url: '../ajax/liquidacion.php?op=listar',
          type : "get",
          dataType : "json",            
          error: function(e){
          console.log(e.responseText);  

          }

        },

    "bDestroy": true,
    "iDisplayLength": 5,//Paginación
      "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
  }).DataTable();

}











//Función para guardar o editar



function guardaryeditar(e)

{

  e.preventDefault(); //No se activará la acción predeterminada del evento
  $("#btnGuardar").prop("disabled",true);
  var formData = new FormData($("#formulario")[0]);



  $.ajax({
    url: "../ajax/liquidacion.php?op=guardaryeditarLiquidacion",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function(datos)
      {                    

            bootbox.alert(datos);           
            limpiar();
            mostrarform(false);
            tabla.ajax.reload();
      }

  });
}



function mayus(e) {

     e.value = e.value.toUpperCase();

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




function focusnomb(e, field) {

    if(e.keyCode===13  && !e.shiftKey){

       document.getElementById('nombre').focus();  

    }

 }


function refrescartabla()

{

tabla.ajax.reload();
//tablas.ajax.reload();

}








  function agregarCliente(e)
  {
    var documento=$("#dnir").val();
    if(e.keyCode===13  && !e.shiftKey){
    $.post("../ajax/liquidacion.php?op=listarClientesliqui&doc="+documento, function(data,status)
    {
       data=JSON.parse(data);
       if (data != null){
       $('#idcliente').val(data.idpersona);
       //$("#datoscli").val(data.razon_social);

       $("#datoscli").val(data.nombres);
       $("#nombrescli").val(data.nombres);
       $("#apellidoscli").val(data.apellidos);
       $("#nombrecom").val(data.nombre_comercial);
      
      
        }else{

       $('#idcliente').val("");
       $("#datoscli").val("No existe");

       $("#nombrescli").val("-");
       $("#apellidoscli").val("-");
       $("#nombrecom").val("-");

          
       
        }

       $('#suggestions').fadeOut();
       $('#suggestions2').fadeOut();
    });
 }
}


 



 $(document).ready(function() {
    $('#dnir').on('keyup', function() {
        var key = $(this).val();  
        var dataString = 'key='+key;
    $.ajax({
            type: "POST",
            url: "../ajax/liquidacion.php?op=buscarclientepred",
            data: dataString,
            success: function(data) {
                $('#suggestions').fadeIn().html(data);
                
                $('.suggest-element').on('click', function(){
                        var id = $(this).attr('id');
                        $('#dnir').val($('#'+id).attr('ndocumento'));
                        $('#datoscli').val($('#'+id).attr('nombrecli'));
                        $("#idcliente").val(id);
                       $('#suggestions').fadeOut();
                        return false;
                });
            }
        });
    });
}); 


//  $(document).ready(function() {
//     $('#datoscli').on('keyup', function() {
//         var key = $(this).val();  
//         var dataString = 'key='+key;
//     $.ajax({
//             type: "POST",
//             url: "../ajax/liquidacion.php?op=buscarclientepred",
//             data: dataString,
//             success: function(data) {
//                 $('#suggestions2').fadeIn().html(data);
                
//                 $('.suggest-element').on('click', function(){
//                         var id = $(this).attr('id');
//                         $('#dnir').val($('#'+id).attr('ndocumento'));
//                         $('#datoscli').val($('#'+id).attr('nombrecli'));

//                         $('#nombrescli').val($('#'+id).attr('nombrescli'));
//                         $('#apellidoscli').val($('#'+id).attr('apellidoscli'));
//                         $('#nombrecom').val($('#'+id).attr('nombrecom'));

//                         $("#idcliente").val(id);
//                         $('#suggestions2').fadeOut();
//                         return false;
                        
//                 });
//             }
//         });
//     });
// }); 





 function focusTest(el)
{
   el.select();
}


function validartc()
{
      var tcv=$("#tipomoneda").val();
      if (tcv=="USD") {
    fechatcf=$("#fechaemision").val();
    $.post("../ajax/factura.php?op=tcambiog&feccf="+fechatcf, function(data, status)
    {
     data=JSON.parse(data);
     $("#tcambio").val(data.venta);
     document.getElementById('precio').focus(); 
    });
    }else{
       $("#tcambio").val("0"); 
       document.getElementById('precio').focus();
    }

}


document.addEventListener('keypress', function(evt) {
  // Si el evento NO es una tecla Enter
  if (evt.key !== 'Enter') {
    return;
  }
  
  let element = evt.target;

  // Si el evento NO fue lanzado por un elemento con class "focusNext"
  if (!element.classList.contains('focusNext')) {
    return;
  }

  // AQUI logica para encontrar el siguiente
  let tabIndex = element.tabIndex + 1;
  var next = document.querySelector('[tabindex="'+tabIndex+'"]');

  // Si encontramos un elemento
  if (next) {
    next.focus();
    event.preventDefault();
  }
});


function impresion(idliquidacion)
{
              var rutacarpeta='../reportes/liquidacion.php?id='+idliquidacion;
              $("#modalCom").attr('src',rutacarpeta);
              $("#modalPreview").modal("show");
}



function editarcotizacion(idliquidacion)
 {

    $.post("../ajax/liquidacion.php?op=editar",{idliquidacion : idliquidacion}, function(data, status)
  {
    data = JSON.parse(data); 
    mostrarform(true);
        $("#idliquidacion").val(data.idliquidacion);
        
        if (data.tipoliqui=="s") {

        $("#tservicio").val(data.tipoliqui);
        $("#fechaemision").val(data.fechaemision);
        $("#creserv").val(data.codreserva);
        $("#dnir").val(data.rucdni);
        $("#idcliente").val(data.idcliente);
        $("#datoscli").val(data.nombre_comercial);
        $("#file").val(data.file);
        $("#programa").val(data.programa);
        $("#observaciones").val(data.observaciones);
        $("#restricciones").val(data.restriccionestarifa);
        $("#tipomoneda").val(data.tipomoneda);
        $("#precio").val(data.precio);
        $('#cantidad').val(data.cantidad);
        $('#total').val(separator(data.total));

        $('#tipocuenta').val(data.tipocuenta);
        $('#titularc').val(data.titularcuenta);
        $('#ncuenta').val(data.nrocuenta);
        $('#item').val(data.item);
        $('#entidadb').val(data.entidadbancaria);
        $('#codigoint').val(data.nrocuentacci);



      }else{

        $("#tservicio").val(data.tipoliqui);
        $("#fechaemision").val(data.fechaemision);
        $("#creserv").val(data.codreserva);
        $("#dnir").val(data.rucdni);
        $("#idcliente").val(data.idcliente);
        $("#datoscli").val(data.nombre_comercial);
        $("#file").val(data.file);
        $("#programa").val(data.programa);
        $("#observaciones").val(data.observaciontarifa);
        $("#restricciones").val(data.restriccionestarifa);
        $("#tipomoneda").val(data.tipomoneda);
        $("#precio").val(data.precio);
        $('#cantidad').val(data.cantidad);
        $('#total').val(separator(data.total));

        $('#tipocuenta').val(data.tipocuenta);
        $('#titularc').val(data.titularcuenta);
        $('#ncuenta').val(data.nrocuenta);
        $('#item').val(data.item);
        $('#entidadb').val(data.entidadbancaria);
        $('#codigoint').val(data.nrocuentacci);



        seltipoliq();
        $.post("../ajax/liquidacion.php?op=traerdetallenvuelo&id="+idliquidacion,function(r){
            $("#detalles").html(r);
        });

        $('#condiciones').val(data.condiciones);
        $('#tarifanore').val(data.tarifanore);


      }
          

    })


    $("#btnGuardar").show();

 }


 function separator(numb) {
    var str = numb.toString().split(".");
    str[0] = str[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return str.join(".");
}










init();