limpiar();
listarPlatos();
var detalles=0;
     cont=0;
     conNO=1;

let count = 0;
function timer()
{
    count++;
    tabla.ajax.reload(null,false);
} 

document.getElementById("nruc").focus();

//PARA ACTUALIZAR ESTADO 
let onOff = true;
function tipocomprobante(){
    if (!onOff) {
        onOff=true;
        document.getElementById("clientefactura").style.display='block';
        document.getElementById("clienteboleta").style.display='none';
        document.getElementById("nruc").focus();
    }else{
        onOff=false;
        document.getElementById("clienteboleta").style.display='block';
        document.getElementById("clientefactura").style.display='none';
         }
    }
//PARA ACTUALIZAR ESTADO 



let onOff1 = true;
function mostrarp(){
    if (!onOff1) {
        onOff1=true;
        document.getElementById("detalleplatosdiv").style.display='none';

    }else{
        onOff1=false;
        
        $("#myModalrestaurant").modal('show');
        document.getElementById("detalleplatosdiv").style.display='block';
         }
    }
//PARA ACTUALIZAR ESTADO 

function limpiar()
{
    $("#idpersona").val("N");
    $("#tipo_doc_ide").val("0");
    $(".filas").remove();
      //pARA CARGAR el id del cliente varios
        $.post("../ajax/persona.php?op=mostrarClienteVarios", function(data,status)
        {
       data=JSON.parse(data);
       $('#idpersona').val(data.idpersona);
       $("#ndocumento").val(data.numero_documento);
       $("#nombrea").val(data.razon_social);
        });


        //Obtenemos la fecha actual
    $("#fechaemision").prop("disabled",false);
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fechaemision').val(today);
}


    function focusI(){
var tipo=$("#tipo_doc_ide option:selected").val();

if (tipo=="0"){

$.post("../ajax/persona.php?op=mostrarClienteVarios", function(data,status)
    {
       data=JSON.parse(data);
       $('#idpersona').val(data.idpersona);
       $("#ndocumento").val(data.numero_documento)
       $("#nombrea").val(data.razon_social)
   });
}


if (tipo=='1'){
$("#ndocumento").val("")
$("#nombrea").val("")
document.getElementById('ndocumento').focus(); 
document.getElementById('ndocumento').maxLength =20; 
}

if (tipo=='4'){
$("#ndocumento").val("")
$("#nombrea").val("")
document.getElementById('ndocumento').focus(); 
document.getElementById('ndocumento').maxLength =15; 
}

if (tipo=='7'){
$("#ndocumento").val("")
$("#nombrea").val("")
document.getElementById('ndocumento').focus(); 
document.getElementById('ndocumento').maxLength =15; 
}

if (tipo=='A'){
$("#ndocumento").val("")
$("#nombrea").val("")
document.getElementById('ndocumento').focus(); 
document.getElementById('ndocumento').maxLength =15; 
}

if (tipo=='6'){
$("#ndocumento").val("")
$("#nombrea").val("")
document.getElementById('ndocumento').focus(); 
document.getElementById('ndocumento').maxLength =11; 
}


}


//Función ListarArticulos
function listarPlatos()
{
 tablaArti=$('#tbllistado').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        //"scrollY":        "600px",
        //"scrollCollapse": true,
        //"bFilter": true,
        //"bPaginate": false,
        //"paging":   false,
        "ordering": false,
        "info":     false,
        "rowHeight": 'auto',

        'columnDefs': [
        {
      "targets": 0, // your case first column
      "className": "text-center"
         }
           ],

        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                ],

        "ajax":
                {
                    url: '../ajax/pedidorapido.php?op=listarplatos',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },
        "bDestroy": false,
        "iDisplayLength": 5,//Paginación
        //"order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }
    ).DataTable();
$('#tbllistado').DataTable().ajax.reload();


 tablaArt2=$('#tbllistado2').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        //"scrollY":        "600px",
        //"scrollCollapse": true,
       //"bFilter": false,
        //"bPaginate": false,
        //"paging":   false,
        "ordering": false,
        "info":     false,
        "rowHeight": 'auto',

        'columnDefs': [
        {
      "targets": 0, // your case first column
      "className": "text-center"
         }
                        ],
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                ],

        "ajax":
                {
                    url: '../ajax/pedidorapido.php?op=listarplatos2',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },
        "bDestroy": false,
        "iDisplayLength": 5,//Paginación
        
    }
    ).DataTable();
$('#tbllistado2').DataTable().ajax.reload();


tablaArt3=$('#tbllistado3').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        
      // "bFilter": false,
        //"bPaginate": false,
        //"paging":   false,
        "ordering": false,
        "info":     false,
        "rowHeight": 'auto',

        'columnDefs': [
        {
      "targets": 0, // your case first column
      "className": "text-center"
         }
           ],

        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                ],

        "ajax":
                {
                    url: '../ajax/pedidorapido.php?op=listarplatos3',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },
        "bDestroy": false,
        "iDisplayLength": 5,//Paginación
    }
    ).DataTable();
$('#tbllistado3').DataTable().ajax.reload();
}


function selectitem(idplato, imagen, nombre, precio, estado)
{
      if (idplato!="") {
      $("#myModalrestaurant").modal('hide');
      $("#myModalrestaurant2").modal('show');

      $("#idplato").val(idplato);
      $("#nombreplato").val(nombre);
      $("#precioplato").val(precio);
      $("#cantidadplato").val($("#quantity").val());

      $("#imagenpedido").attr("src", "../files/platos/"+imagen);
      document.querySelector('#tituloplato').innerText = nombre;
      document.querySelector('#precioplato').innerText = "S/. "+precio;

      if (estado=='1') {
      document.querySelector('#estadoplato').style.color="green";    
      document.querySelector('#estadoplato').innerText = "DISPONIBLE";
      }else{
      document.querySelector('#estadoplato').style.color="red";    
      document.querySelector('#estadoplato').innerText = "NO DISPONIBLE";
      }
      }
}

function agregaraldetalle()
{

    $idplato=$("#idplato").val();
    $nombreplato=$("#nombreplato").val();
    $precio=$("#precio").val();
    $cantidadplato=$("#cantidadplato").val();

     if ($idplato!="")
    {
                
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><i class="fa fa-close" onclick="eliminarDetalle('+(cont) +')" style="color:red;"  data-toggle="tooltip" title="Eliminar item"></i></td>'+
        '<td><span name="numero_orden" id="numero_orden'+cont+'" ></span>'+
        '<input type="hidden" name="itemidplato[]" id="itemidplato[]" >'+nombreplato+'</td>'+
        '</tr>'

        detalles=detalles+1;
        cont++;
        conNO++;
       
        $('#detalleplatos').append(fila);
        //$("#myModalnuevoitem").modal('hide');

    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del artículo");
        cont=0;
    }


}



    $.post("../ajax/pedidorapido.php?op=mesalist", function(r){
            $("#mesaselect").html(r);
            $('#mesaselect').selectpicker('refresh');
    });





    function agregarClientexRuc(e)
  {
    var documento=$("#nruc").val();
    if(e.keyCode===13  && !e.shiftKey){
    $.post("../ajax/factura.php?op=listarClientesfacturaxDoc&doc="+documento, function(data,status)
    {
       data=JSON.parse(data);
       if (data != null){
       $('#idpersona').val(data.idpersona);
       $("#rsocial").val(data.razon_social);
       $('#dfiscal').val(data.domicilio_fiscal);
       $('#correo').val(data.email);
       
       document.getElementById("correo").focus();
       
        }else{
       $('#idpersona').val("");
       $("#rsocial").val("No existe");
       $('#dfiscal').val("No existe");
       alert("Cliente no registrado");

       $("#ModalNcliente").modal('show');
       $("#nrucbusqueda").val($("#nruc").val());
       
        }
    });
 }

     if(e.keyCode===11 && !e.shiftKey){
        $.post("../ajax/factura.php?op=listarClientesfacturaxDoc&doc="+documento, function(data,status)
        {
       data=JSON.parse(data);
       $('#idpersona').val(data.idpersona);
       $("#rsocial").val(data.razon_social);
       $('#dfiscal').val(data.domicilio_fiscal);

        if (data.email=="") {
            $('#correo').css("background-color", "#FBC6AA");
            document.getElementById("correo").focus();
       }
       
        });
         }

}


$(document).ready(function() {
    $('#nruc').on('keyup', function() {
        var key = $(this).val();  
        $('#suggestions2').fadeOut();
        var dataString = 'key='+key;
    $.ajax({
            type: "POST",
            url: "../ajax/persona.php?op=buscarclienteRuc",
            data: dataString,
            
            success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestions').fadeIn().html(data);

                //Al hacer click en algua de las sugerencias
                $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#nruc').val($('#'+id).attr('ndocumento'));
                        $('#rsocial').val($('#'+id).attr('ncomercial'));
                        $('#dfiscal').val($('#'+id).attr('domicilio'));
                        $('#correo').val($('#'+id).attr('email'));
                        $("#idpersona").val(id);
                        $('#suggestions').fadeOut();
                        return false;
                });
            }
        });
    });
});


$(document).ready(function() {
    $('#rsocial').on('keyup', function() {
        $('#suggestions').fadeOut();
        var key = $(this).val();        
        var dataString = 'key='+key;
    $.ajax({
            type: "POST",
            url: "../ajax/persona.php?op=buscarclienteDomicilio",
            data: dataString,
            success: function(data) {
                $('#suggestions2').fadeIn().html(data);
                $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#nruc').val($('#'+id).attr('ndocumento'));
                        $('#rsocial').val($('#'+id).attr('ncomercial'));
                        $('#dfiscal').val($('#'+id).attr('domicilio'));
                        $('#correo').val($('#'+id).attr('email'));
                        $("#idpersona").val(id);
                        $('#suggestions2').fadeOut();
                        return false;
                });

            }

        });

    });
    
}); // Ready function  


function quitasuge2()
{
    $('#suggestions2').fadeOut();
}

function quitasuge1()
{
    $('#suggestions').fadeOut();
}



function agregarClientexDoc(e)
  {
    var dni=$("#ndocumento").val();

    if(e.keyCode===13  && !e.shiftKey){
      $.post("../ajax/boleta.php?op=listarClientesboletaxDoc&doc="+dni, function(data,status)
      {
       data=JSON.parse(data);
       
       if (data != null){
       $('#idpersona').val(data.idpersona);
       $("#nombrea").val(data.nombres);
       document.getElementById("btnAgregarArt").style.backgroundColor= '#367fa9';
       document.getElementById("mensaje700").style.display='none';
       document.getElementById('btnAgregarArt').focus(); 

        }else if($('#tipo_doc_ide').val()=='1') {  // SI ES DNI

        var dni=$("#ndocumento").val();
        var url = '../ajax/consulta_reniec.php';
        $.ajax({ 
        type:'POST',
        url:url,
        data:'dni='+dni,
        success: function(datos_dni){ 
      var datos = eval(datos_dni);
      if (datos!=null) {
        $('#idpersona').val("N");
        //document.getElementById('razon_social').focus(); 
        $('#nombrea').val(datos[1]+" "+datos[2]+" "+datos[3]);
           }
           else
           {
            $('#idpersona').val("N");
            document.getElementById('nombrea').focus(); 
            }
      }});

      } 
      else if($('#tipo_doc_ide').val()=='6')  // SI ES RUC
      {

    var dni=$("#ndocumento").val();
    $.post("../ajax/factura.php?op=listarClientesfacturaxDoc&doc="+dni, function(data,status)
    {
       data=JSON.parse(data);
       if (data != null){
       $('#idpersona').val(data.idpersona);
       $("#nombrea").val(data.razon_social);
        }else{
       $('#idpersona').val("");
       $("#nombrea").val("No registrado");
       alert("Cliente no registrado");
       $("#ModalNcliente").modal('show');
       $("#nrucbusqueda").val($("#ndocumento").val());
       
        }
    });
        $('#suggestions').fadeOut();
        $('#suggestions2').fadeOut();
      }else{
       $('#idpersona').val("N");
       $("#nombrea").val("");
       document.getElementById("btnAgregarArt").style.backgroundColor= '#35770c';     
       document.getElementById('nombrea').style.Color= '#35770c'; 
       document.getElementById('nombrea').focus(); 

       }});
    }
}




function agregarPlatoItem(idplato,
    nombre, precio, cantidad, imagen)
  {


       
  }