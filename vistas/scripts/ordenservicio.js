
var tabla;
var tablaCLiente;
var tablaArti;
 
//Función que se ejecuta al inicio
function init(){

    $("#formulario").on("submit",function(e)
    {
        guardaryeditarOservicio(e);  
    });

// Carga de combo para vendedores =====================
    cont=0;
    conNO=1;
    sw=0;
    actCli=0;
    

    //Cargamos los items al select proveedor
    $.post("../ajax/compra.php?op=selectProveedor", function(r){
                $("#idproveedor").html(r);
                $('#idproveedor').selectpicker('refresh');
    });

    mostrarform(false);
    listar();
   
}


function mayus(e) {
     e.value = e.value.toUpperCase();
}


function incrementarNum(){
    var serie=$("#serie option:selected").val();
    $.post("../ajax/ordenservicio.php?op=autonumeracion&id="+serie, function(r){
       $("#numero").val(r);
       var SerieReal = $("#serie option:selected").text();
        $("#SerieReal").val(SerieReal);
    });
   }

function incrementarinicio(){
 $.post("../ajax/ordenservicio.php?op=selectSerie", function(r)
        {
        $("#serie").html(r);
        var serieL=document.getElementById('serie');
        var opt = serieL.value;
        $.post("../ajax/ordenservicio.php?op=autonumeracion&id="+opt, function(r){
       $("#numero").val(r);
       var SerieReal = $("#serie option:selected").text();
        $("#SerieReal").val(SerieReal);
        });
        });
}

//Función para poner ceros antes del numero siguiente de la factura
function pad (n, length){
    var n= n.toString();
while(n.length<length)
    n="0" + n;
    return n;
}
//Fin de Función    


//Función limpiar
function limpiar()
{
    $("#idpersona").val("");
    $(".filas").remove();
    $("#subtotal").html("0");
    $("#subtotal_factura").val("");
    $("#igv_").html("0");
    $("#total_igv").val("");
    $("#total").html("0");
    $("#total_final").val("");
    $("#pre_v_u").val("");

 
    //Obtenemos la fecha actual
    $("#fechaemision").prop("disabled",false);
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var f=new Date();
    cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 

    //Para hora y minutos
    //&var today = now.getFullYear()+"-"+(month)+"-"+(day)+" "+(cad) ;
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fechaemision').val(today);

    document.getElementById("btnAgregarArt").style.backgroundColor= '#35770c';     
    cont=0;
    conNO=1;
    }



function capturarhora(){ 
var f=new Date();
cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 
$("#hora").val(cad);
}


 
//Función mostrar formulario
function mostrarform(flag)
{
   
    limpiar();
    
   if (flag)
    {
        
        incrementarinicio();
        listarArticulos();
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnagregar").hide();
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").show();
        document.getElementById('serie').focus();
        
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

    var mensaje=confirm("¿Desea cancelar el comprobante?")

    if (mensaje){
    limpiar();
    evaluar2();
    detalles=0;
    mostrarform(false);

    }
    
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
                    url: '../ajax/ordenservicio.php?op=listar',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },

         "rowCallback": 
         function( row, data ) {
            //$(row).addClass('selected');
            //$(row).id(0).addClass('selected');
        },

        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();


//Funcion para actualizar la pagina cada 20 segundos.
setInterval( function () {
tabla.ajax.reload(null, false);
}, 10000 );



}
 


//Función ListarArticulos
function listarArticulos()
{
    tablaArti=$('#tblarticulos').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     
                ],
        "ajax":
                {
                    url: '../ajax/ordenservicio.php?op=listarArticulosfactura',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 8,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();

    $('#tblarticulos').DataTable().ajax.reload();
}



//Función para guardar o editar
 
function guardaryeditarOservicio(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("valor_unitario[]");
    var stk = document.getElementsByName("stock[]");

     sw=0;
     for (var i = 0; i < cant.length; i++) {
        
        var inpC=cant[i];
        var inpP=prec[i];
        var inStk=stk[i];
            
        if (inpP.value==0.00 || inpP.value=="" || inpC.value==0 || inStk.value==0 || $('#numero_orden').val()=="" ){
           sw=sw+1;
           
        }   
        } 

        if(sw!=0){
            alert("Revizar précio!, cantidad o Stock");
            inpP.focus();
        }else{

    var mensaje=confirm("¿Desea crear la orden de servicio?");
    if (mensaje){

   //========================================================     
   capturarhora();

    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/ordenservicio.php?op=guardaryeditarOrden",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    

              bootbox.alert(datos);
              mostrarform(false);
              listar();
        }
    });
            limpiar();
            sw=0;
        }
    }

}

//Función para anular registros
function anular(idorden)
{
    bootbox.confirm("¿Está Seguro de anular la orden de servicio?", function(result){
        if(result)
        {
            $.post("../ajax/ordenservicio.php?op=anular", {idfactura : idfactura}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}


//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto=18;
var cont=0;
var detalles=0;

$("#btnGuardar").hide();
 
  //Función para aceptar solo numeros con dos decimales
  function NumCheck(e, field) {
  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
  key = e.keyCode ? e.keyCode : e.which
  if(e.keyCode===13  && !e.shiftKey)
    {
       document.getElementById('valor_unitario[]').focus();  
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


function NumCheck2(e, field) {
  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
  key = e.keyCode ? e.keyCode : e.which

  if(e.keyCode===13  && !e.shiftKey)
    {
       document.getElementById('codigob').focus();  
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


function agregarDetalle(idarticulo,familia,codigo_proveedor,codigo,nombre,costo_compra,stock,unidad_medida, precio_venta)
  {
    var cantidad=0;
     if (idarticulo!="")
    {
        var subtotal=cantidad*costo_compra;
        var igv= subtotal * 0.18;
        var total_fin;
        var contador=1;
        
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+(cont) +')">X</button></td>'+
        '<td><span name="numero_orden" id="numero_orden'+cont+'"></span>'+
        '<input type="hidden" name="numero_orden_item[]" id="numero_orden_item[]" value="'+conNO+'" size="1" ></td>'+
        '<td><input type="hidden" name="idarticulo[]" style="font-family: times, serif; font-size:10pt; font-style:italic" value="'+idarticulo+'">'+nombre+' <input type="text" class="" name="descdet[]" id="descdet[]" size="25" onkeyup="mayus(this)" onkeypress="return focusDescdet(event, this)"></td>'+
        '<td><input type="text"  autofocus required="true" class="" name="cantidad[]" id="cantidad[]"  onBlur="modificarSubototales()" size="5" onkeypress="return NumCheck(event, this)"  font-weight:bold;" value="1"></td>'+
        '<td><input type="hidden" name="unidad_medida[]" id="unidad_medida[]" value="'+unidad_medida+'">'+unidad_medida+'</td>'+
        '<td><input type="text" class="form-control" name="valor_unitario[]" id="valor_unitario[]" value="'+precio_venta+'" onBlur="modificarSubototales()" size="5" onkeypress="return NumCheck2(event, this)" font-weight:bold;" OnFocus="focusTest(this);"></td>'+
        '<td><input type="text" class="form-control" name="stock[]" id="stock[]" value="'+stock+'" disabled="true" size="4" style="display:none;" ><span name="subtotal" id="subtotal'+cont+'"></span>'+
        '<input type="hidden" name="subtotalBD[]" id="subtotalBD["'+cont+'"]"></td>'+
        '<td><input type="hidden" class="form-control" name="valor_unitario2[]" id="valor_unitario2[]" size="5" disabled="true" onBlur="modificarSubototales()"><span name="igvG" id="igvG'+cont+'" style="background-color:#9fde90bf;display:none;"></span>'+
        '<input type="hidden" name="igvBD[]" id="igvBD["'+cont+'"]"> <input type="hidden" name="igvBD2[]" id="igvBD2["'+cont+'"]"></td>'+
        '<td><span name="total" id="total'+cont+'" style="background-color:#9fde90bf; display:none;" ></td>'+
        '<td><span name="pvu_" id="pvu_'+cont+'"  style="display:none"  ></span>'+
        '<input  type="hidden" name="pvt[]" id="pvt["'+cont+'"] size="2"></td>'+
        '</tr>'
        var id = document.getElementsByName("idarticulo[]");

        detalles=detalles+1;
        cont++;
        conNO++;
        $('#detalles').append(fila);
        modificarSubototales();
        $("#myModalArt").modal('hide');
        setTimeout(function(){
        document.getElementById('descdet[]').focus();
        },400);

    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del artículo");
        cont=0;
    }
  }


  function agregarArticuloxCodigo(e)
  {
    var codigob=$("#codigob").val();
    //var documento="20602501168";
    if(e.keyCode===13  && !e.shiftKey){
    $.post("../ajax/factura.php?op=listarArticulosfacturaxcodigo&codigob="+codigob, function(data,status)
    {
        data=JSON.parse(data);
       
       if (data != null){
        if (data.stock=="0.00") { 
            alert("El stock es 0!");
            }else{

        
        var contador=1;
        
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+(cont) +')">X</button></td>'+
        '<td><span name="numero_orden" id="numero_orden'+cont+'"></span>'+
        '<input type="hidden" name="numero_orden_item[]" id="numero_orden_item[]" value="'+conNO+'" size="1" ></td>'+
        '<td><input type="hidden" name="idarticulo[]" style="font-family: times, serif; font-size:10pt; font-style:italic" value="'+data.idarticulo+'">'+data.nombre+' <input type="text" class="" name="descdet[]" id="descdet[]" size="25" onkeyup="mayus(this)" onkeypress="return focusDescdet(event, this)"></td>'+
        '<td><input type="text"  autofocus required="true" class="form-control" name="cantidad[]" id="cantidad[]"  onBlur="modificarSubototales()" size="5" onkeypress="return NumCheck(event, this)"  font-weight:bold;" value="1"></td>'+
        '<td><input type="hidden" name="unidad_medida[]" id="unidad_medida[]" value="'+data.unidad_medida+'">'+data.unidad_medida+'</td>'+
        '<td><input type="text" class="form-control" name="valor_unitario[]" id="valor_unitario[]" value="'+data.precio_venta+'" onBlur="modificarSubototales()" size="5" onkeypress="return NumCheck2(event, this)" font-weight:bold;" OnFocus="focusTest(this);"></td>'+
        '<td><input type="text" class="form-control" name="stock[]" id="stock[]" value="'+data.stock+'" disabled="true" size="4" style="display:none;" ><span name="subtotal" id="subtotal'+cont+'"></span>'+
        '<input type="hidden" name="subtotalBD[]" id="subtotalBD["'+cont+'"]"></td>'+
        '<td><input type="hidden" class="form-control" name="valor_unitario2[]" id="valor_unitario2[]" size="5" disabled="true" onBlur="modificarSubototales()"><span name="igvG" id="igvG'+cont+'" style="background-color:#9fde90bf;display:none;"></span>'+
        '<input type="hidden" name="igvBD[]" id="igvBD["'+cont+'"]"> <input type="hidden" name="igvBD2[]" id="igvBD2["'+cont+'"]"></td>'+
        '<td><span name="total" id="total'+cont+'" style="background-color:#9fde90bf; display:none;" ></td>'+
        '<td><span name="pvu_" id="pvu_'+cont+'"  style="display:none"  ></span>'+
        '<input  type="hidden" name="pvt[]" id="pvt["'+cont+'"] size="2"></td>'+
        '</tr>'
        var id = document.getElementsByName("idarticulo[]");
        detalles=detalles+1;
        cont++;
        conNO++;
        $('#detalles').append(fila);
        modificarSubototales();
        $('#codigob').val("");
       document.getElementById("codigob").focus();
                }
                }
        else
        {
       alert("No existe");
       document.getElementById("btnAgregarArt").style.backgroundColor= '#35770c';     
       document.getElementById("codigob").focus();     
       
        }
        if (data.stock<=8) { alert("El stock esta al limite, verificar!");}
    });
 }
}
 


  function modificarSubototales()
  {
    var noi = document.getElementsByName("numero_orden_item[]");
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("valor_unitario[]");
    var vuni = document.getElementsByName("valor_unitario2[]");
    var st = document.getElementsByName("stock[]");
    var igv = document.getElementsByName("igvG");
    var sub = document.getElementsByName("subtotal");
    var tot = document.getElementsByName("total");
    var pvu = document.getElementsByName("pvu_");

     for (var i = 0; i <cant.length; i++) {
        var inpNOI=noi[i];
        var inpC=cant[i];
        var inpP=prec[i];
        var inpS=sub[i];
        var inpVuni=vuni[i];
        var inpI=igv[i];
        
        var inpT=tot[i];
        var inpPVU=pvu[i];
        var inStk=st[i];
            
        inStk.value=inStk.value;
        inpC.value=inpC.value;

         //Validar cantidad no sobrepase stock actual
         if(parseFloat(inpC.value) > parseFloat(inStk.value)){
            bootbox.alert("Mensaje, La cantidad supera al stock.");
            }
            else
            {

         inpPVU.value=inpP.value / 1.18;
         document.getElementsByName("valor_unitario2[]")[i].value = redondeo(inpPVU.value,5);
         

         inpNOI.value=inpNOI.value;
         inpI.value=inpI.value;
         
         inpS.value=(inpC.value * inpP.value);
         
         inpI.value= inpS.value * 0.18;    
         inpIitem = inpPVU.value * 0.18;    
         inpT.value=inpS.value + inpI.value;
         
         
        
        document.getElementsByName("subtotal")[i].innerHTML = redondeo(inpS.value,2);
        document.getElementsByName("igvG")[i].innerHTML = redondeo(inpI.value,2);
        document.getElementsByName("total")[i].innerHTML = redondeo(inpT.value,2);
        document.getElementsByName("pvu_")[i].innerHTML = redondeo(inpPVU.value,5);

        document.getElementsByName("numero_orden")[i].innerHTML = inpNOI.value;


        //Lineas abajo son para enviar el arreglo de inputs ocultos con los valor de IGV, Subtotal, y precio de venta
        //a la tala detalle_fact_art.
        document.getElementsByName("subtotalBD[]")[i].value = redondeo(inpS.value,2);
        document.getElementsByName("igvBD[]")[i].value = redondeo(inpIitem,2);
        document.getElementsByName("igvBD2[]")[i].value = redondeo(inpI.value,2);
        document.getElementsByName("pvt[]")[i].value = redondeo(inpPVU.value,5);
        //Fin de comentario

        //document.getElementsByName("valor_unitario2[]")[i].value = inpPVU.value.toFixed(2);
        }
//     bootbox.alert("Aviso, la cantidad supera al stock actual");
        if(inpP.value==0){
        inpP.style.backgroundColor= '#ffa69e';
        //document.getElementById("precio_unitario[]").style.backgroundColor= '#ffa69e';
        }else{
        inpP.style.backgroundColor= '#fffbfe';
        //document.getElementById("precio_unitario[]").style.backgroundColor= '#fffbfe';
            }

            if(inpC.value==0){
        inpC.style.backgroundColor= '#ffa69e';
        //document.getElementById("precio_unitario[]").style.backgroundColor= '#ffa69e';
        }else{
        inpC.style.backgroundColor= '#fffbfe';
        //document.getElementById("precio_unitario[]").style.backgroundColor= '#fffbfe';
            }

            if(inStk.value==0){
        inStk.style.backgroundColor= '#ffa69e';
        //document.getElementById("precio_unitario[]").style.backgroundColor= '#ffa69e';
        }else{
        inStk.style.backgroundColor= '#fffbfe';
        //document.getElementById("precio_unitario[]").style.backgroundColor= '#fffbfe';
            }
    }
    calcularTotales();
    }


  function calcularTotales(){
    //var noi = document.getElementsByName("numero_orden_item");
    var sub = document.getElementsByName("subtotal");
    var igv = document.getElementsByName("igvG");
    var tot = document.getElementsByName("total");
    var pvu = document.getElementsByName("pvu_");

    var subtotal = 0.0;
    var total_igv=0.0;
    var total = 0.0;
    var noi=0;
    var pvu=0.0;

    for (var i = 0; i <sub.length; i++) {

        //noi+=document.getElementsByName("numero_orden_item")[i].value;
        subtotal += document.getElementsByName("subtotal")[i].value;
        total_igv+=document.getElementsByName("igvG")[i].value;
        total+=document.getElementsByName("total")[i].value;
        pvu+=document.getElementsByName("pvu_")[i].value;

    }


    $("#subtotal").html(redondeo(subtotal,2));
    $("#subtotal_factura").val(redondeo(subtotal,2)); // a base de datos
    
    $("#igv_").html(redondeo(total_igv,2));
    $("#total_igv").val(redondeo(total_igv,4)); // a base de datos
    
    $("#total").html(number_format(redondeo(total,2),2));
    $("#total_final").val(redondeo(total,2));
    $("#pre_v_u").val(redondeo(pvu,2));
    
    evaluar();
  }

 
  function evaluar(){
    if (detalles>0)
    {
      $("#btnGuardar").show();

    }
    else
    {
      $("#btnGuardar").hide(); 
      cont=0;
    }
  }

    function evaluar2(){
    if (detalles>0)
    {
      $("#btnGuardar").hide(); 
       cont=0;
    }
    
  }
 
  function eliminarDetalle(indice){
    $("#fila" + indice).remove();
    calcularTotales();
    detalles=detalles-1;
    conNO=conNO - 1;
    actualizanorden();
    evaluar()
  }


function redondeo(numero, decimales)
{
var flotante = parseFloat(numero);
var resultado = Math.round(flotante*Math.pow(10,decimales))/Math.pow(10,decimales);
return resultado;
}


function decimalAdjust(type, value, exp) {
    // Si el exp no está definido o es cero...
    if (typeof exp === 'undefined' || +exp === 0) {
      return Math[type](value);
    }
    value = +value;
    exp = +exp;
    // Si el valor no es un número o el exp no es un entero...
    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
      return NaN;
    }
    // Shift
    value = value.toString().split('e');
    value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));

  // Decimal round
  if (!Math.round10) {
    Math.round10 = function(value, exp) {
      return decimalAdjust('round', value, exp);
    };
  }
  // Decimal floor
  if (!Math.floor10) {
    Math.floor10 = function(value, exp) {
      return decimalAdjust('floor', value, exp);
    };
  }
  // Decimal ceil
  if (!Math.ceil10) {
    Math.ceil10 = function(value, exp) {
      return decimalAdjust('ceil', value, exp);
    };
  }
}

function round(value, exp) {
  if (typeof exp === 'undefined' || +exp === 0)
    return Math.round(value);
  value = +value;
  exp  = +exp;

  if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
    return NaN;
  // Shift
  value = value.toString().split('e');
  value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));
  // Shift back
  value = value.toString().split('e');
  return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
}


//Función para el formato de los montos 
function number_format(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}


function actualizanorden()
{
var total = document.getElementsByName("numero_orden_item[]");

 for (var i = 0; i <=total.length; i++) {
        //var contNO=total[i];
        var contNO=total[i];
        contNO.value=i+1;
        
        //Lineas abajo son para enviar el arreglo de inputs con los valor de IGV, Subtotal, y precio de venta
        document.getElementsByName("numero_orden")[i].innerHTML = contNO.value;
        document.getElementsByName("numero_orden_item[]")[i].value = contNO.value;
        //Fin de comentario
    }//Final de for
}


function focusTest(el)
{
   el.select();
}


function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
//BLOQUEA ENTER 
document.onkeypress = stopRKey; 


function focusTest(el)
{
   el.select();
}



$(document).ready(function() {
    var table = $('#tbllistado').DataTable();
 
    $('#tbllistado tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            table.$('tr').removeClass('selected');
            $(this).addClass('selected');
        }
    } );

   $('#tbllistado').parents("tr").css("background-color","green") ;
   $('#button').click( function () {
        table.row('.selected').remove().draw( false );
    } );
} );


//Foco para el input cantidad
function focusDescdet(e, field)
{
if(e.keyCode===13  && !e.shiftKey)
    {
       document.getElementById('cantidad[]').focus();  
    }
 }


init();