function init()
{
document.getElementById('nruc').focus(); 
var fecha = new Date();
var ano = fecha.getFullYear();
var mes = fecha.getMonth();
$("#anor").val(ano);
$("#mesr").val(mes);


$.post("../ajax/persona.php?op=combocliente", function(r){
$("#nruc").html(r);
$("#nruc").selectpicker('refresh');
});


}


function enviar() {
document.formEnviar.action = "../reportes/ventasxcliente.php";
document.formEnviar.target = "_blank";
document.formEnviar.submit();
document.formEnviar.action = "../reportes/PDF_MC_Table2.php";
document.formEnviar.target = "_self";
document.formEnviar.submit(); 
return true;

}

function llenarCampo()
{

var numero=$("#nruc").val();

if(numero==""){
alert ("Llenar número de documento");
document.getElementById("nruc").focus();

}

}

function limpiarFac()
{


document.getElementById("nruc").focus();
// document.getElementById("chk1").disabled=false;
// document.getElementById("chk1").checked=true;
// document.getElementById("chk1").value="1";

}

function limpiarBol()
{


document.getElementById("nruc").focus();
d//ocument.getElementById("chk1").disabled=true;
//document.getElementById("chk1").checked=false;
//document.getElementById("chk1").value="0";

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

init();

function listarventasxruc()
{
   var $nruc= $("#nruc").val(); 
   var $anor= $("#anor option:selected").val();
   var $mesr= $("#mesr option:selected").val();
   var tp= $("#tipopago option:selected").val();

    tablaArti=$('#tablar').dataTable(
    {
        
        
        "aProcessing": true,
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
                    url: '../ajax/ventas.php?op=listarventasxruc&nruc='+$nruc+'&anor='+$anor+'&mesr='+$mesr+'&tip='+tp,
                    type : "post",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },

        "bDestroy": true,
        "iDisplayLength": 10,//Paginación
        "order": [[ 1, "desc" ]]//Ordenar (columna,orden)

    }).DataTable();

$('#tablar').DataTable().ajax.reload();
}



