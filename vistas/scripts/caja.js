 var fecha = new Date();
 var ano = fecha.getFullYear();
 var mes = fecha.getMonth();

    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var yea = now.getFullYear();


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

$("#ano").val(ano);
var periodo=month+yea;

    var today1 = now.getFullYear()+"-"+(month)+"-01" ;
    var today2 = now.getFullYear()+"-"+(month)+"-"+(day) ;

$("#Fecha_Mov_Con").val(today2);   
$("#fecha1").val(today1);
$("#fecha2").val(today2);


txt = document.getElementById("finalpagar");
txt.innerHTML="0.00";


function initcon()
{
  
  $.post("../ajax/conceptois.php?op=selectconcepto", function(r){
              $("#conceptoi").html(r);
              $('#conceptoi').selectpicker('refresh');
  });

//////////////////
  $.post("../ajax/conceptois.php?op=selectconcepto", function(r){
              $("#conceptos").html(r);
              $('#conceptos').selectpicker('refresh');
  });

    //$idempresa=$("#idempresa").val();
    $.post("../ajax/factura.php?op=selectConcepto", function(r){
              $("#Nom_Concepto").html(r);
              $('#Nom_Concepto').selectpicker('refresh');

  });



}


initcon();

 function mostrarventasgrav()
  {

    // IGV VENTAS
    var period=$("#periodo").val();
    $.post("../ajax/sunat621.php?op=ventasgrav&periD="+periodo, function(data, status)
    {
    data = JSON.parse(data);    
    $("#vngraigv").val(separator(data.vtasgravigv));
    $("#vngraigv2").val(data.vtasgravigv);


    // IGV COMPRAS
    var period=$("#periodo").val();
    $.post("../ajax/sunat621.php?op=comprasgrav&periD="+periodo, function(data, status)
    {
    data = JSON.parse(data);  
    if (data.cprasgrav===null)
    {
    $("#cngraigv2").val(0);
    }else{  
    $("#cngraigv").val(separator(data.cprasgravigv));
    $("#cngraigv2").val(data.cprasgravigv);
    }
    })


    // RENTA MENSUAL
    var period=$("#periodo").val();
    $.post("../ajax/sunat621.php?op=ventasgravRenta&periD="+periodo, function(data, status)
    {
    data = JSON.parse(data);    
    $("#vngrarenta1porc").val(separator(data.vtasgravigvrenta));
    $("#vngrarenta1porc2").val(data.vtasgravigvrenta);


     var tventas=parseFloat($("#vngraigv2").val());
      var tcompras=parseFloat($("#cngraigv2").val());
      var trenta=parseFloat($("#vngrarenta1porc2").val());

    var saldofinalfavor= parseFloat(tventas) - parseFloat(tcompras)   ;
    if (saldofinalfavor<0) {
      var totaligvrenta = 0  + trenta;
    }else{
          totaligvrenta=saldofinalfavor + parseFloat(trenta) ;
    }
    txt = document.getElementById("finalpagar");
    txt.innerHTML="S/ "+separator(totaligvrenta) ;




  })

  })

 
}


 mostrarventasgrav();
 listarValidar();


listar();
validartcdia();

$("#formulariocaja").on("submit",function(e)
    {
        guardaryeditarCaja(e);  

    });


$("#formulariotcambio").on("submit",function(e)
    {
        guardaryeditarTcambio(e); 

    });


$("#formulariotcambio2").on("submit",function(e)
    {
        guardaryeditarTcambio2(e); 

    });


$("#formularioicaja").on("submit",function(e)
    {
        guardaryeditaringresocaja(e); 

    });


$("#formularioscaja").on("submit",function(e)
    {
        guardaryeditarsalidacaja(e); 

    });


$("#formularioConceptoGAstoingreso").on("submit",function(e)
    {
        guardaryeditarmovimientoingsal(e); 

    });



function guardaryeditarmovimientoingsal(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardarcliente").prop("disabled",true);
    var formData = new FormData($("#formularioConceptoGAstoingreso")[0]);
    var es = $("#OptMov").val();

      $.ajax({
        url: "../ajax/factura.php?op=guardarMovimientoig",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos)
        {                    
              //bootbox.alert(datos); 
              if (es=="E")
              {
              toastr.success(datos);            
              }
              else
              {
               toastr.danger(datos);            
              }
        }

    });
     //  $("#salidacaja").modal('hide');
     // // $("#idcajasalida").load(" #idcajasalida"); 
       $("#divutilidad").load(" #divutilidad");          
       $("#divingreso").load(" #divingreso");          
       $("#divegreso").load(" #divegreso");               
     //  $("#montoscajamodal").load(" #montoscajamodal");      
     //  $("#montoscaja").load(" #montoscaja"); 
     //  $("#cchica").load(" #cchica");        
        limpiarMov();
       // actcajas();
}

function limpiarMov()
{
  $("#Monto_Mov").val("0.00");      
  $("#ObseMov").val("");      
  $("#Fecha_Mov_Con").val(today2);   
      $.post("../ajax/factura.php?op=selectConcepto", function(r){
              $("#Nom_Concepto").html(r);
              $('#Nom_Concepto').selectpicker('refresh');

  });

}


function focusOptMovMov()
{
  document.getElementById('OptMov').focus();  
}

function focusMontoMov()
{
  document.getElementById('Monto_Mov').focus();  
}



function guardaryeditarCaja(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardarcliente").prop("disabled",true);
    var formData = new FormData($("#formulariocaja")[0]);
    var estado = $("#estadoCaja").val();
    	$.ajax({
        url: "../ajax/factura.php?op=guardaryeditarCaja&estadocc="+estado,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos)
        {                    
              bootbox.alert(datos);           
              tablacaja.ajax.reload();
 			setInterval("actualizar()",1000);        }
    });
     $("#idcaja").load(" #idcaja");
     $("#idcajaingreso").load(" #idcajaingreso");      
     $("#idcajasalida").load(" #idcajasalida");            
     $("#montoscajamodal").load(" #montoscajamodal");      
     $("#montoscaja").load(" #montoscaja");  
     $("#modalcaja").hide();

}

function limpairis()
{
  $("#conceptoin").val("");      
  $("#montoin").val("");      
    $("#conceptosal").val("");      
  $("#montosal").val("");      

}






 function guardaryeditaringresocaja(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardarcliente").prop("disabled",true);
    var formData = new FormData($("#formularioicaja")[0]);
    var estado = $("#estado").val();

    	$.ajax({
        url: "../ajax/factura.php?op=guardaringreso",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos)
        {                    
            //bootbox.alert(datos);           
            toastr.success(datos);  
     	      tablacaja.ajax.reload();
        }
    });
      $("#ingresocaja").modal('hide');
      //$("#idcajaingreso").load(" #idcajaingreso");      
      $("#montoscajamodal").load(" #montoscajamodal");  
      $("#divutilidad").load(" #divutilidad");          
      $("#divingreso").load(" #divingreso");          
      $("#divegreso").load(" #divegreso");          
      $("#montoscaja").load(" #montoscaja");      	
      $("#cchica").load(" #cchica");        
      limpairis();
      actcajas();
}

 function guardaryeditarsalidacaja(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardarcliente").prop("disabled",true);
    var formData = new FormData($("#formularioscaja")[0]);
    var estado = $("#estado").val();

    	$.ajax({
        url: "../ajax/factura.php?op=guardarsalida",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos)
        {                    
              //bootbox.alert(datos); 
              toastr.success(datos);            
              tablacaja.ajax.reload();
        }

    });
     $("#salidacaja").modal('hide');
    // $("#idcajasalida").load(" #idcajasalida"); 
     $("#divutilidad").load(" #divutilidad");          
      $("#divingreso").load(" #divingreso");          
      $("#divegreso").load(" #divegreso");               
     $("#montoscajamodal").load(" #montoscajamodal");      
      $("#montoscaja").load(" #montoscaja"); 
      $("#cchica").load(" #cchica");        
        limpairis();
        actcajas();
}





function actualizar(){location.reload(true);}

function actcajas()
{
      //$("#idcajaingreso").load(" #idcajaingreso");      
      $("#montoscajamodal").load(" #montoscajamodal");      
      $("#montoscaja").load(" #montoscaja"); 
      //$("#idcajasalida").load(" #idcajasalida"); 
      //initcon();     
}




function recalcular()
{

  ftcc=$("#fechatc").val();
  $.post("../ajax/ventas.php?op=recalcular&fechatc="+ftcc, function(data)
{
 bootbox.alert(data);

});
     

}








function guardaryeditarTcambio(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardarcliente").prop("disabled",true);
    var formData = new FormData($("#formulariotcambio")[0]);

    $.ajax({
        url: "../ajax/factura.php?op=guardaryeditarTcambio",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    
              bootbox.alert(datos);           
              tablacaja.ajax.reload();
              
        }

    });
    
     $("#modalTcambio").modal('hide');
     $("#divtcambio").load(" #divtcambio");      
}




function consultartcambio()
{
ftcc=$("#fechatc").val();
//ftcc="2021-06-25";

$.post("../ajax/ventas.php?op=consultatcambio&fechatc="+ftcc, function(data, status)
{
 
 data=JSON.parse(data);
 //bootbox.alert(data);
 $("#venta").val(data.venta);
 $("#compra").val(data.compra);

});

}


function validartcdia()
{
  inpcompra=$("#compra").val();
  inpventa=$("#venta").val();

  if(inpcompra=="  " && inpventa=="  " ){
      $("#modalTcambio").modal("show");
  }else{
      $("#modalTcambio").modal("hide");
  }
  
}






function guardaryeditarTcambio2(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardarcliente").prop("disabled",true);
    var formData = new FormData($("#formulariotcambio2")[0]);

    $.ajax({
        url: "../ajax/factura.php?op=guardaryeditarTcambio",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    
              bootbox.alert(datos);           
              tablacaja.ajax.reload();
              
        }

    });
    
    // $("#modalTcambio").modal('hide');
}






function listar()
{
  tablacaja=$('#tbllistadocaja').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
         'bFilter': false,
        buttons: [                
                   
                ],
        "ajax":
                {
                    url: '../ajax/factura.php?op=listarcaja',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);
                    tablacaja.ajax.reload();    
                    }
                },

         "rowCallback": 
         function( row, data ) {

        },

        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();
  tablacaja.ajax.reload(); 
}



function montoi596(idcaja)
{
  $.post("../ajax/factura.php?op=montoii&mtii="+idcaja, function(data, status)
{
 data=JSON.parse(data);
 $("#montoi").val(data.montof);
});

}
 



//$("#fechacaja").prop("disabled",false);
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var f=new Date();
    cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 

    //Para hora y minutos
    //&var today = now.getFullYear()+"-"+(month)+"-"+(day)+" "+(cad) ;
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fechacaja').val(today);
    
    $('#fechatc').val(today);
    $('#fechain').val(today);
    $('#fechasal').val(today);




//BLOQUEA ENTER 
document.onkeypress = stopRKey; 

function focusTest(el)
{
   el.select();
}




function listarValidar()
{
    var f1 = $("#fecha1").val();
    var f2 = $("#fecha2").val();
    

    tabla=$('#tbllistadocajavalidar').dataTable(
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
                    url: '../ajax/factura.php?op=listarvalidarcaja&ff1='+f1+'&ff2='+f2,
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },
         "rowCallback": 
         function( row, data ) {
        },

        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();

}





function NumCheck(e, field) {
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



function mayus(e) {
     e.value = e.value.toUpperCase();
}



  function separator(numb) {
    var str = numb.toString().split(".");
    str[0] = str[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return str.join(".");
}



function recalculardia(idcaja)
{
    $.post("../ajax/factura.php?op=recalculardia",{idcaja : idcaja}, function(data)
    {
    bootbox.alert(data);
    tablacaja.ajax.reload(); 
    });
}




