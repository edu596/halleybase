var tabla;
iva=$("#iva").val();

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

function init()
{

  buscarperiodo();
  
  $("#formulario").on("submit",function(e)
  {
    guardaryeditar(e);  
  })
}




//Función para guardar o editar
function guardaryeditar(e)

{

  e.preventDefault(); //No se activará la acción predeterminada del evento
  $("#btnGuardar").prop("disabled",true);
  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "../ajax/sunat621.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function(datos)
      {                    

            bootbox.alert(datos);           
            buscarperiodo();
      }

  });
  //limpiar();
  
}








function limpiar()

{

  
  $("#idcalculo").val("");

  // $("#vngra").val("0");
  // $("#cngra").val("0");
  // $("#vngraigv").val("0");
  // $("#cngraigv").val("0");
  // $("#vngraigvtotal").val("0");
  // $("#cngraigvtotal").val("0");
  // $("#vngrarenta").val("0");
  // $("#vngrarenta1porc").val("0");
  // $("#vngrarentatotal").val("0");
  

  $("#imresusa").val("0");
  $("#imresusa2").val("0");
  $("#rentatotal").val("0");
  $("#rentatotal2").val("0");
  $("#sfpa").val("0");
  $("#tpsf").val("0");
  $("#tpsf2").val("0");
  $("#subtigv").val("0");
  $("#subtigv2").val("0");
  $("#subtrenta").val("0");
  $("#subtrenta2").val("0");


$("#totaldtigv").val("");
$("#totaldtigv2").val("");
$("#totaldtrenta").val("");
$("#totaldtrenta2").val("");
$("#impopagarigv").val("");
$("#impopagarigv2").val("");
$("#impopagarrenta").val("");
$("#impopagarrenta2").val("");

txt = document.getElementById("finalpagar");
txt.innerHTML="0.00";


}



//Función cancelarform
function cancelarform()
{
  limpiar();
  mostrarform(false);
}


function buscarperiodo()

{
  var period=$("#periodo").val();
  $.post("../ajax/sunat621.php?op=buscarperiodo&periD="+period, function(data, status)
  {
    data = JSON.parse(data);    
    if (data===null)
    {
        toastr.warning('Periodo sin registros');  
          limpiar();
          mostrarventasgrav();
          mostrarcomprasgrav();
          mostrarventasgravRenta();
          

    }else{
        toastr.success('Existe registro almacenado');  
        $("#idcalculo").val((data.idcalculo));

        $("#vngra").val(separator(data.vngra));
        $("#vngra2").val((data.vngra));

        $("#cngra").val(separator(data.cnvg));
        $("#cngra2").val((data.cnvg));

        $("#vngraigv").val(separator(data.igvng));
        $("#vngraigv2").val((data.igvng));

        $("#cngraigv").val(separator(data.igvcn));
        $("#cngraigv2").val((data.igvcn));

        $("#vngraigvtotal").val(separator(data.totaltribvent));
        $("#vngraigvtotal2").val((data.totaltribvent));

        $("#cngraigvtotal").val(separator(data.totaltribcom));
        $("#cngraigvtotal2").val((data.totaltribcom));

        $("#vngrarenta").val(separator(data.rentingnet));
        $("#vngrarenta2").val((data.rentingnet));

        $("#vngrarenta1porc").val(separator(data.renttribcal));
        $("#vngrarenta1porc2").val((data.renttribcal));

        $("#vngrarentatotal").val(separator(data.totalrent));
        $("#vngrarentatotal2").val((data.totalrent));

        $("#imresusa").val(separator(data.tribpagsfavigv));
        $("#imresusa2").val((data.tribpagsfavigv));

        $("#rentatotal").val(separator(data.tribpagsfavrent));
        $("#rentatotal2").val((data.tribpagsfavrent));

        $("#tpsf").val(separator(data.tibpagsalfav));
        $("#tpsf2").val((data.tibpagsalfav));

        $("#subtigv").val(separator(data.totaldtirbigv));
        $("#subtigv2").val((data.totaldtirbigv));

        $("#subtrenta").val(separator(data.totaldtirbrent));
        $("#subtrenta2").val((data.totaldtirbrent));

        txt = document.getElementById("finalpagar");
        txt.innerHTML="S/ "+separator(parseFloat(data.totaldtirbigv) + parseFloat(data.totaldtirbrent));

        txt2 = document.getElementById("finalpagar2");
        txt2.innerHTML="S/ "+separator(parseFloat(data.totaldtirbigv) + parseFloat(data.totaldtirbrent));

    }


    
  })
}















function eliminarperiodo()

{
  var idcalculo=$("#idcalculo").val();

  bootbox.confirm("¿Está Seguro de eliminar el periodo?", function(result){
       if(result)
        {
  $.post("../ajax/sunat621.php?op=eliminarperiodo&idcalcc="+idcalculo, function(r)
  {
       toastr.success(r);
       buscarperiodo();
       })
}
})


}




function mostrarventasgrav()

{
	var period=$("#periodo").val();
  $.post("../ajax/sunat621.php?op=ventasgrav&periD="+period, function(data, status)
  {
    data = JSON.parse(data);    
    
    $("#vngra").val(separator(data.vtasgrav));
    $("#vngra2").val(data.vtasgrav);
    $("#vngraigv").val(separator(data.vtasgravigv));
    $("#vngraigv2").val(data.vtasgravigv);
    $("#vngraigvtotal").val((separator(data.vtasgravigv)));
    $("#vngraigvtotal2").val((data.vtasgravigv));
  })
}



function mostrarcomprasgrav()
{
  var period=$("#periodo").val();
  $.post("../ajax/sunat621.php?op=comprasgrav&periD="+period, function(data, status)
  {
    data = JSON.parse(data);  
    if (data.cprasgrav===null)
    {
    $("#cngra").val(0);
    $("#cngra2").val(0);
    $("#cngraigv").val(0);
    $("#cngraigv2").val(0);
    $("#cngraigvtotal").val(0);
    $("#cngraigvtotal2").val(0);
    }else{  
    $("#cngra").val(separator(data.cprasgrav));
    $("#cngra2").val(data.cprasgrav);
    $("#cngraigv").val(separator(data.cprasgravigv));
    $("#cngraigv2").val(data.cprasgravigv);
    $("#cngraigvtotal").val(separator(data.cprasgravigv));
    $("#cngraigvtotal2").val(data.cprasgravigv);
   }

  })


 

}


function separator(numb) {
    var str = numb.toString().split(".");
    str[0] = str[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return str.join(".");
}


function separator2(numb) {
    var str = numb.toString().split(",");
    str[0] = str[0].replace(/\B(?=(\d{3})+(?!\d))/g, "");
    return str.join(",");
}



function mostrarventasgravRenta()
{
  var period=$("#periodo").val();
  $.post("../ajax/sunat621.php?op=ventasgravRenta&periD="+period, function(data, status)
  {
    data = JSON.parse(data);    
    $("#vngrarenta").val(separator(data.vtasgravrenta));
    $("#vngrarenta2").val(data.vtasgravrenta);
    $("#vngrarenta1porc").val(separator(data.vtasgravigvrenta));
    $("#vngrarenta1porc2").val(data.vtasgravigvrenta);
    $("#vngrarentatotal").val(separator(data.vtasgravigvrenta));
    $("#vngrarentatotal2").val(data.vtasgravigvrenta);
  })
}



function calculos()
{
var tventas=parseFloat($("#vngraigvtotal2").val());
var tcompras=parseFloat($("#cngraigvtotal2").val());
var trenta=parseFloat($("#vngrarentatotal2").val());
var sfpa=parseFloat($("#sfpa").val());
var saldofinalfavor= parseFloat(tventas) - parseFloat(tcompras) ;

if (saldofinalfavor<0) {
  var subtigv=0;
}else{
      subtigv=saldofinalfavor;
}


$("#imresusa").val(separator(saldofinalfavor));
$("#imresusa2").val(saldofinalfavor.toFixed(2));

$("#rentatotal").val(separator(trenta.toFixed(2)));
$("#rentatotal2").val(trenta.toFixed(2));

var imresusa=parseFloat($("#imresusa2").val());

var tpsf= (imresusa - (sfpa));

$("#tpsf").val(separator(tpsf.toFixed(2)));
$("#tpsf2").val(tpsf.toFixed(2));
$("#subtigv").val(separator(subtigv.toFixed(2)));
$("#subtigv2").val(subtigv.toFixed(2));
$("#subtrenta").val(separator(trenta.toFixed(2)));
$("#subtrenta2").val(trenta.toFixed(2));

var totaligv=$("#subtigv2").val();
var totalrenta=$("#subtrenta2").val();

$("#totaldtigv").val(separator(totaligv));
$("#totaldtigv2").val(totaligv);
$("#totaldtrenta").val(separator(totalrenta));
$("#totaldtrenta2").val(totalrenta);
$("#impopagarigv").val($("#totaldtigv").val());
$("#impopagarigv2").val($("#totaldtigv2").val());
$("#impopagarrenta").val($("#totaldtrenta").val());
$("#impopagarrenta2").val($("#totaldtrenta2").val());


txt = document.getElementById("finalpagar");
txt.innerHTML="S/ "+separator(parseFloat(totaligv) + parseFloat(totalrenta));

txt2 = document.getElementById("finalpagar2");
txt2.innerHTML="S/ "+separator(parseFloat(totaligv) + parseFloat(totalrenta));
}

function igventas()
{

  $("#vngra2").val($("#vngra").val());
  var igvv=parseFloat($("#vngra2").val());
    var igvv2=(igvv * iva)/100;
    $("#vngraigv").val(separator(igvv2));
    $("#vngraigv2").val(igvv2.toFixed(2));

    $("#vngraigvtotal").val(separator(igvv2));
    $("#vngraigvtotal2").val(igvv2.toFixed(2));


}



function igvvcompr()
{

  $("#cngra2").val($("#cngra").val());
  //limpiar();
  var igvc=parseFloat($("#cngra2").val());
  var igvc2=(igvc * iva)/100;

    $("#cngraigv").val(separator(igvc2));
    $("#cngraigv2").val(igvc2.toFixed(2));

    $("#cngraigvtotal").val(separator(igvc2));
    $("#cngraigvtotal2").val(igvc2.toFixed(2));
}


function igvrenta()
{ 
  $("#vngrarenta2").val($("#vngrarenta").val());
  var igvr=parseFloat($("#vngrarenta2").val());
  var igvr2=(igvr * 1)/100;

   $("#vngrarenta1porc").val(separator(igvr2));
    $("#vngrarenta1porc2").val(igvr2.toFixed(2));

    $("#vngrarentatotal").val(separator(igvr2));
    $("#vngrarentatotal2").val(igvr2.toFixed(2));

  }



function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}


function valor0()
{
 // $("#sfpa").val("0");
}


document.onkeypress = stopRKey;



 function NumCheck(e, field) 
 {
// Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
  key = e.keyCode ? e.keyCode : e.which
  if(e.keyCode===13  && !e.shiftKey)
    {
       document.getElementById('precio_unitario[]').focus();  
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
          else 
          {
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



init();