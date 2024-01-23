var tabla;
var ubd;
var ubp;
var ubdi;
var ubiparti


var ubd2;
var ubp2;
var ubdi2;
var ubiparti2

var cont=0;
var contNO=1;
var nrofila="";
var tipoc="";


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
function init(){
    mostrarform(false);
    listar();
 
     $("#formulario").on("submit",function(e)
     {
         guardaryeditarGuia(e);  
     });

        
     $.post("../ajax/guiaremision.php?op=selectSerie", function(r)
        {
        $("#serie").html(r);
        $("#serie").selectpicker('refresh');
        });

     //Obtenemos la fecha actual
    $("#fecha_emision").prop("disabled",false);
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_emision').val(today);
    $('#fechatraslado').val(today);
    $('#fechacomprobante').val(today);


      $.post("../ajax/articulo.php?op=selectUnidad", function(r){
              $("#umedidapbruto").html(r);
              $('#umedidapbruto').selectpicker('refresh');
    });


       $.post("../ajax/guiaremision.php?op=selectDepartamento", function(r){
            $("#ubdepartamento1").html(r);
            $('#ubdepartamento1').selectpicker('refresh');
    });


       $.post("../ajax/guiaremision.php?op=selectDepartamento", function(r){
            $("#ubdepartamento2").html(r);
            $('#ubdepartamento2').selectpicker('refresh');
    });

        
        $.post("../ajax/guiaremision.php?op=datosempresas", function(e)
    {
       data=JSON.parse(e);
       $("#ppartida").val(data.domicilio_fiscal);
       $("#ubigeopartida").val(data.codubigueo);

    }
    );



    cont=0;

    traerdatosempresa();
}


       function llenarprovin(){
        var iddepartamento=$("#ubdepartamento1 option:selected").val();
        $.post("../ajax/guiaremision.php?op=selectprovinc&idd="+iddepartamento, function(r){
       $("#ubprovincia1").html(r);
       $('#ubprovincia1').selectpicker('refresh');
       $("#ubprovincia1").val(""); 
        });
        
    }


    function llenarprovin2(){
        var iddepartamento=$("#ubdepartamento2 option:selected").val();
        $.post("../ajax/guiaremision.php?op=selectprovinc&idd="+iddepartamento, function(r){
       $("#ubprovincia2").html(r);
       $('#ubprovincia2').selectpicker('refresh');
       $("#ubprovincia2").val(""); 
        });
        
    }



    function llenardistri(){
    var iddistri=$("#ubprovincia1 option:selected").val();
    $.post("../ajax/guiaremision.php?op=selectDistrito&idc="+iddistri, function(r){
       $("#ubdistrito1").html(r);
       $('#ubdistrito1').selectpicker('refresh');

    });
    }


        function llenardistri2(){
    var iddistri=$("#ubprovincia2 option:selected").val();
    $.post("../ajax/guiaremision.php?op=selectDistrito&idc="+iddistri, function(r){
       $("#ubdistrito2").html(r);
       $('#ubdistrito2').selectpicker('refresh');

    });
    }


    // Carga de combo para vendedores =====================
    $.post("../ajax/vendedorsitio.php?op=selectVendedorsitio&idempresa=1", function(r){
            $("#vendedor").html(r);
            $('#vendedor').selectpicker('refresh');
    });



    function traerdatosempresa()
    {
   
    }



    function llenarubipp()
    {
       ubd=$("#ubdepartamento1").val();
       ubp=$("#ubdepartamento1").val();
       ubdi=$("#ubdistrito1").val();
       $("#ubigeopartida").val(ubd+ubp+ubdi); 

    }

    function llenarubipp2()
    {
       ubd2=$("#ubdepartamento2").val();
       ubp2=$("#ubdepartamento2").val();
       ubdi2=$("#ubdistrito2").val();
       $("#ubigeollegada").val(ubd2+ubp2+ubdi2); 

    }




function incrementarNum(){
    var serie=$("#serie option:selected").val();
    $.post("../ajax/guiaremision.php?op=autonumeracion&ser="+serie, function(r){

       var n2=pad(r,0);
       $("#numero_guia").val(n2);

       var SerieReal = $("#serie option:selected").text();
        $("#SerieReal").val(SerieReal);
    }); 
}

function numero(){

       $("#numero_guia").val("000000ssdf");
}

//Función para poner ceros antes del numero siguiente de la factura
function pad (n, length){
    var n= n.toString();
while(n.length<length)
    n="0" + n;
    return n;
}


//Función mostrar formulario
function mostrarform(flag)
{
   
    //limpiar();

    if (flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnagregar").hide();
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").show();
        listarComprobante();
        incrementarNum();
        boletafactura();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
        

    }
}

//Función para aceptar solo numeros con dos decimales
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

//Funcion para mayusculas
function mayus(e) {
     e.value = e.value.toUpperCase();
}
//=========================




//Función para mostrar en Modal las facturas 
function listarComprobante()
{

  $(".filas").remove();
    detalles=0;
    var cont=0;
    var contNO=1;
    var nrofila="";
    var tipoc="";


    tipocompr=$('#tipocomprobante').val();
 if (tipocompr=='01' ||  tipocompr=='03') {
    tabla=$('#tblacomprobante').dataTable(
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
                  
                    url: '../ajax/guiaremision.php?op=listarComprobante&tip='+tipocompr,
                    //url: '../ajax/notac.php?op=listarComprobante',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();
  }



    if (tipocompr=='04') {

      tabla=$('#tblarticulos').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [],
        "ajax":
                {
                  
                    url: '../ajax/guiaremision.php?op=listarComprobante&tip='+tipocompr,
                    //url: '../ajax/notac.php?op=listarComprobante',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();



      $("#myModalArt").modal('show');
    }
}


var divCom = document.getElementById("DivComprobante");
var divCli = document.getElementById("DivCliente");

divCom.style.display = "none";

function boletafactura()
{
    x=$("#tipocomprobante").val();
    var divClien = document.getElementById("DivCliente");
    //var div = document.getElementById("datosorigen");
    if (x=='04') {
        divClien.style.display = "none";
        divClien.style.disable = "true";
        divCom.style.display = "block";
        
        }else{
        divClien.style.display = "block";
        divCom.style.display = "none";
        divClien.style.disable = "false";
        
        }
        listarComprobante();        
    
}




function agregarComprobante(idcomprobante,tdcliente,ndcliente,rzcliente, domcliente,tipocomp, 
    numerodoc, subtotal, igv, total, fechafactura, idpersona, ubigeocli)
  {
    
     if (idcomprobante!="")
    {
        
        $('#idcomprobante').val(idcomprobante);
        $('#numero_comprobante').val(numerodoc);
        $('#pllegada').val(domcliente);
        $('#destinatario').val(rzcliente);
        $('#nruc').val(ndcliente);
        $('#fechacomprobante').val(fechafactura);
        $('#idpersona').val(idpersona);
        $('#ubigeollegada').val(ubigeocli);

    $("#btnGuardar").show();
    
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del cliente");
    }

 //========================================================================
    tipocompr=$('#tipocomprobante').val();
    $.post("../ajax/guiaremision.php?op=detalle&id="+idcomprobante+'&tipo2='+tipocompr,function(r){
        $("#detalles").html(r);
    });

//============================================================================
$("#myModalComprobante").modal('hide');
}

var detalles=0;


  function eliminarDetalle(indice){
    $("#fila" + indice).remove();
    detalles=detalles-1;
    contNO=contNO - 1;
    evaluar();
    actualizanorden();
    
  }


    function evaluar(){
    if (detalles>0)
    {
      $("#btnGuardar").show();
      $("#contaedit").val(cont);
      actualizanorden();
    }
    else
    {
      $("#btnGuardar").hide(); 
      detalles=0;
      cont=0;
      contNO=0;
      $("#contaedit").val("");
    }
  }

  function actualizanorden()
{
var total = document.getElementsByName("nordenhi[]");
var contNO=0;
 for (var i = 0; i <= total.length; i++) {
        var contNO=total[i];
        contNO.value=i+1;
        
        //Lineas abajo son para enviar el arreglo de inputs con los valor de IGV, Subtotal, y precio de venta
        document.getElementsByName("norden[]")[i].value = contNO.value;

        //Fin de comentario
    }//Final de for
    
}








function agregarArticulos(idarticulo,codigo,nombre,abre)
  {

    nrofila=($("#contaedit").val());
        if (nrofila=="") {
            contNO=1;
            cont=0;
            detalles=0;
        }else{
            cont=parseFloat(nrofila);
            contNO=parseFloat(contNO)+ parseFloat(nrofila); 
            detalles=parseFloat(nrofila); 
        }

  
     if (idarticulo!="")
    {
         var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><i class="fa fa-close" onclick="eliminarDetalle('+cont+')" data-toggle="tooltip" title="Eliminar item"></i>'+
        '<input type="hidden" name="idarticulo[]" value="'+idarticulo+'"></td>'+
        '<td><input type="text"  name="cantidad[]" id="cantidad[]" value="1">'+
        '<input  type="hidden"  name="norden[]" id="norden[]" value="'+contNO+'">'+
        '<input  type="hidden"  name="nordenhi[]" id="nordenhi[]"></td>'+
        '<td><input type="text"  name="codigo[]" id="codigo[]" value="'+codigo+'" readonly></td>'+
        '<td><input type="text"  name="nombre[]" id="nombre[]" value="'+nombre+'" readonly></td>'+
        '<td><input type="text"  name="descdet[]" id="descdet[]" value="-"></td>'+
        '<td><input type="text"  name="abre[]" id="abre[]" value="'+abre+'" readonly></td>'+
        '</tr>'


        var id = document.getElementsByName("idarticulo[]");
        var can = document.getElementsByName("cantidad[]");
        var cantiS=0;

        for (var i = 0; i < id.length; i++) {//PARA VALIDACION SI YA ESTA INGRESADO EL ITEM
            var idA=id[i];
            var cantiS=can[i];

             if (idA.value==idarticulo) { 
                        cantiS.value=parseFloat(cantiS.value) + 1; //Agrega a la cantidad en 1
                        fila="";
                        cont=cont - 1;
                        contNO=contNO -1;
                        }else{
                        detalles=detalles;
                        }
             } //Fin de for 
    detalles=detalles+1;
    cont++;
    contNO++;
    nrofila++;
    
     $('#detalles').append(fila);
    toastr.success('Agregado al detalle '+nombre);
    evaluar();
    actualizanorden();

    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del cliente");
    }

     evaluar();
}













function guardaryeditarGuia(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
        
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/guiaremision.php?op=guardaryeditarGuia",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    

              bootbox.alert(datos);
              mostrarform(false);
              listar();
              tabla.ajax.reload();
        }
    });
            limpiar();
    
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
            },

            {
                text:      '<span class="label bg-orange"><i class="fa fa-check"></i></span> Emitido',
            },
                        {
                text:      '<span class="label bg-brown"><i class="fa fa-certificate"></i></span> Firmado',
            },
                        {
                text:      '<img src="../public/images/sunat.png"> Enviado',
            }
           

                ],
        "ajax":
                {
                    url: '../ajax/guiaremision.php?op=listar',
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
 
function limpiar(){


    $("#idguia").val("");
    //$("#numero_documento").val("");
    $("#numero_guia").val("");
    $("#pllegada").val("");
    $("#destinatario").val("");
    $("#nruc").val("");
    $("#numero_comprobante").val("");
    //$("#serie").val("");
    $(".filas").remove();
    $("#tipocomprobante").val("01");

    //para que los cheks se deseleccionen
    var ch=document.getElementsByName("motivo");
    var i;
    for(i=0; i< ch.length; i++){
        ch[i].checked=false;
    }
    
 
    //Obtenemos la fecha actual
    $("#fecha_emision").prop("disabled",false);
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_emision').val(today);
    cont=0;

            $("#fechatraslado").val(today);
            $("#rsocialtransportista").val("");
            $("#ructran").val("");
            $("#placa").val("");
            $("#marca").val("");
            $("#cinc").val("");
            $("#container").val("");
            $("#nlicencia").val("");
            $("#ncoductor").val("");
            $("#ocompra").val("");
            $("#npedido").val("");
            $("#vendedor").val("");
            $("#costmt").val("");
            $("#numero_comprobante").val("");
            $("#fechacomprobante").val(today);

            $("#observaciones").val("");
            $("#pesobruto").val("");
            $("#dniconduc").val("");





    }


//Función cancelarform
function cancelarform()
{
    limpiar();
    detalles=0;
    mostrarform(false);
}



function refrescartabla()
{
tabla.ajax.reload();
}



function generarxml(idguia)
{
    bootbox.confirm("¿Está Seguro de generar el archivo XML.?", function(result){
        if(result)
        {
            $.post("../ajax/guiaremision.php?op=generarxml", {idguia : idguia}, function(e)
            {
                data=JSON.parse(e);
                bootbox.alert('Se ha generardo el archivo XML: <a href="'+data.cabextxml+'" download=" '+data.cabxml+'">" ARCHIVO XML:   '+data.cabxml+'"</a> de clic en el nombre para descargarlo.');
                tabla.ajax.reload();
            }); 
            refrescartabla();
        }
    })
}



function enviarxmlS(idguia)
{
    bootbox.confirm("¿Está Seguro de enviar archivo firmado a SUNAT?", function(result){
        if(result)
        {
            $.post("../ajax/guiaremision.php?op=enviarxmlS", {idguia : idguia}, function(e){
                //data2=JSON.parse(e);
                bootbox.alert(e);
                tabla.ajax.reload();   
            }); 
             refrescartabla();
        }

    })
    
    
}



function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}


 function anular(e) {
          tecla = (document.all) ? e.keyCode : e.which;
          return (tecla != 13);
     }



init();

$('#suggestions').fadeOut();

$(document).ready(function() {
    $('#ubigeopartida').on('keyup', function() {
        $('#suggestions').fadeOut();
        var key = $(this).val();  
        var dataString = 'key='+key;
    $.ajax({
            type: "POST",
            url: "../ajax/guiaremision.php?op=buscarubigeo",
            data: dataString,
            
            success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestions').fadeIn().html(data);

                //Al hacer click en algua de las sugerencias
                $('.suggest-element').on('click', function(){
                    var id = $(this).attr('id');
                        $('#ubigeopartida').val($('#'+id).attr('codigo'));
                        $('#suggestions').fadeOut();
                        return false;
                });
            }
        });
    });
}); 









$(document).ready(function() {
 $('#ubigeollegada').on('keyup', function() {
        var key = $(this).val();  
        var dataString = 'key='+key;
    $.ajax({
            type: "POST",
            url: "../ajax/guiaremision.php?op=buscarubigeo",
            data: dataString,
            
            success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestions2').fadeIn().html(data);

                //Al hacer click en algua de las sugerencias
                $('.suggest-element').on('click', function(){
                    var id = $(this).attr('id');
                        $('#ubigeollegada').val($('#'+id).attr('codigo'));
                        $('#suggestions2').fadeOut();
                        return false;
                });
            }
        });
    });

 }); 





function quitasuge()
{
    if ($('#ubigeopartida').val()=="") { $('#suggestions').fadeOut(); }
    if ($('#ubigeollegada').val()=="") { $('#suggestions2').fadeOut(); }

    
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







$(document).ready(function() {
    $('#destinatario').on('keyup', function() {
        var key = $(this).val();        
        var dataString = 'key='+key;
    $.ajax({
            type: "POST",
            url: "../ajax/persona.php?op=buscarclienteDomicilio",
            data: dataString,
            success: function(data) {
                $('#suggestions').fadeIn().html(data);
                $('.suggest-element').on('click', function(){
                        var id = $(this).attr('id');
                        $('#nruc').val($('#'+id).attr('ndocumento'));
                        $('#destinatario').val($('#'+id).attr('ncomercial'));
                        $('#pllegada').val($('#'+id).attr('domicilio'));
                        $('#ubigeollegada').val($('#'+id).attr('ubigeo'));
                        $("#idpersona").val(id);
                        $('#suggestions').fadeOut();
                        return false;
                });

            }

        });

    });
    
}); // Ready function 






function tipotrans()
{
    tipot=$("#codtipotras").val();

    if (tipot=="01") {
        $("#datosconduc").hide();    
        $("#datosvehi").hide();    
        $("#datostransp").hide();    
    }else{
        $("#datosconduc").show();    
        $("#datosvehi").show();    
        $("#datostransp").show();    
    }
}


function mostrarformedicion(flag,sesion)
{

        //limpiar();
    if (flag)
    {
        
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnagregar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").show();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}




function editarguia(idguia)
 {



    $.post("../ajax/guiaremision.php?op=editar",{idguia : idguia}, function(data, status)
  {
    data = JSON.parse(data); 
    mostrarformedicion(true);
        $("#idguia").val(data.idguia);
        $("#numero_guia").val(data.snumero);
        $("#fecha_emision").val(data.fechaemision);
        $("#fechatraslado").val(data.fechatraslado);
        $("#motivo").val(data.motivo);
        $("#codtipotras").val(data.codtipotras);
        $("#tipocomprobante").val(data.comprobante);
        $("#idpersona").val(data.idpersona);
        $("#destinatario").val(data.razon_social);
        $("#nruc").val(data.numero_documento);
        $("#ppartida").val(data.ppartida);
        $("#ubigeopartida").val(data.ubigeopartida);
        $("#pllegada").val(data.pllegada);
        $("#ubigeollegada").val(data.ubigeollegada);
        $("#observaciones").val(data.observaciones);
        $("#dniconduc").val(data.dniconductor);
        $("#ncoductor").val(data.ncoductor);
        $("#nlicencia").val(data.nlicencia);

        $("#tipodoctrans").val(data.tipodoctrans);
        $("#ructran").val(data.ructran);
        $("#rsocialtransportista").val(data.rsocialtransportista);

        $("#marca").val(data.marca);
        $("#placa").val(data.placa);
        $("#cinc").val(data.cinc);
        $("#container").val(data.container);
        $("#umedidapbruto").val(data.umedidapbruto);
        $("#pesobruto").val(data.pesobruto);
        $("#ocompra").val(data.ocompra);

        $("#npedido").val(data.npedido);
        $("#vendedor").val(data.vendedor);
        $("#costmt").val(data.costmt);

        $("#numero_comprobante").val(data.ncomprobante);
        $("#fechacomprobante").val(data.fechacomprobante);
        $("#idcomprobante").val(data.idcomprobante);

          tipotrans();
          boletafactura();


      tipoc=data.comprobante;
 
        $.post("../ajax/guiaremision.php?op=listarDetalleguia&id="+idguia+"&tp="+tipoc,function(r){
        $("#detalles").html(r);
        });
    

    });



    


        $.post("../ajax/guiaremision.php?op=numerof&id="+idguia, {idguia : idguia} ,function(data,status)
        {
                data=JSON.parse(data);
                $("#contaedit").val(data.cantifilas);
                 cont=parseFloat(data.cantifilas);
                 contNO=parseFloat(contNO)+ parseFloat(data.cantifilas); 
                 detalles=parseFloat(data.cantifilas); 
        });
       
        $("#btnGuardar").show();

 }


 //BLOQUEA ENTER 
document.onkeypress = stopRKey; 





function baja(idguia)
{
    bootbox.confirm("Desea anular la guia?", function(result)
    {
      if(result)
      {
          $.post("../ajax/guiaremision.php?op=anular" , {idguia, idguia}, function(e)
          {
            bootbox.alert(e);
            tabla.ajax.reload();
          });
      }


    });

}


function previoprintGuiaUltima(idguia)
{
              var rutacarpeta='../reportes/exguia2copias.php?id='+idguia;
              $("#modalComGuia").attr('src',rutacarpeta);
              $("#modalPreviewGuia").modal("show");
}



function previoprint()
{
$.post("../ajax/guiaremision.php?op=mostrarultimocomprobanteId", function(data,status)
    {
       data=JSON.parse(data);
       if (data != null) 
       {
              var rutacarpeta='../reportes/exguia2copias.php?id='+data.idguia;
               $("#modalComGuia").attr('src',rutacarpeta);
              $("#modalPreviewGuia").modal("show");
            }
    }); // codigo igual hasta aqui.
}
