var tabla;


function init(){
 
    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);  
    });

}
    cont=0;
    conNO=1;
    conmg=0;
    conNO2=0;
    detalles=0;



//Obtenemos la fecha actual
    $("#fecha_emision").prop("disabled",false);
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var f=new Date();
    cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 

    //Para hora y minutos
    //&var today = now.getFullYear()+"-"+(month)+"-"+(day)+" "+(cad) ;
    var today = (day)+""+(month)+""+now.getFullYear();
    $('#fechag').val(today);


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

  function limpiar() {
    
    $("#fechacomp").val("");
    $("#tipocp").val("");
    $("#seriecp").val("");
    $("#numerocp").val("");
    $("#numeroft").val("0");
    $("#tipodc").val("");
    $("#numerodc").val("");
    $("#nombrecli").val("");
    $("#totalvvg").val("");
    $("#totalvve").val("0.00");
    $("#totalvoi").val("0.00");
    $("#isc").val("0.00");
    $("#igv").val("");
    $("#otrosc").val("0.00");
    $("#total").val("");
    $("#tipocpm").val("");
    $("#seriecpm").val("");
    $("#numerocpm").val("");
    
    //cont=0;
    
  }

    function eliminarDetalle(indice){
    $("#fila" + indice).remove();
    calcularTotales();
    detalles=detalles-1;
    conNO=conNO - 1;
    conmg=conmg - 1;
    actualizanorden();
    evaluar()
  }

  function agregarComprobante()
  {
    var motivoc=$("#motivoc").val();
    var fechacomp=$("#fechacomp").val();
    var tipocp=$("#tipocp").val();
    var seriecp=$("#seriecp").val();
    var numerocp=$("#numerocp").val();
    var numeroft=$("#numeroft").val();
    var tipodc=$("#tipodc").val();
    var numerodc=$("#numerodc").val();
    var nombrecli=$("#nombrecli").val();
    var totalvvg=$("#totalvvg").val();
    var totalvve=$("#totalvve").val();
    var totalvoi=$("#totalvoi").val();
    var isc=$("#isc").val();
    var igv=$("#igv").val();
    var otrosc=$("#otrosc").val();
    var total=$("#total").val();
    var tipocpm=$("#tipocpm").val();
    var seriecpm=$("#seriecpm").val();
    var numerocpm=$("#numerocpm").val();
    
        var contador=1;
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><button type="button" class="btn btn-danger" style="font-size: 8px" onclick="eliminarDetalle('+(cont) +')">X</button></td>'+
        '<td><input type="text" name="motivoc[]" id="motivoc[]" value="'+motivoc+'"  style="width:15pt"></td>'+
        '<td><input type="text" name="fechacomp[]" id="fechacomp[]" value="'+fechacomp+'"  style="width:65pt"></td>'+
        '<td><input type="text" name="tipocp[]" id="tipocp[]" value="'+tipocp+'"  style="width:20pt"></td>'+
        '<td><input type="text" name="seriecp[]" id="seriecp[]" value="'+seriecp+'"  style="width:55pt"></td>'+
        '<td><input type="text" name="numerocp[]" id="numerocp[]" value="'+numerocp+'"  style="width:55pt"></td>'+
        '<td><input type="text" name="numeroft[]" id="numeroft[]" value="'+numeroft+'"  style="width:15pt"></td>'+
        '<td><input type="text" name="tipodc[]" id="tipodc[]" value="'+tipodc+'"  style="width:15pt"></td>'+
        '<td><input type="text" name="numerodc[]" id="numerodc[]" value="'+numerodc+'"  style="width:75pt"></td>'+
        '<td><input type="text" name="nombrecli[]" id="nombrecli[]" value="'+nombrecli+'"  style="width:125pt"></td>'+
        '<td><input type="text" name="totalvvg[]" id="totalvvg[]" value="'+totalvvg+'"  style="width:55pt"></td>'+
        '<td><input type="text" name="totalvve[]" id="totalvve[]" value="'+totalvve+'"  style="width:55pt"></td>'+
        '<td><input type="text" name="totalvoi[]" id="totalvoi[]" value="'+totalvoi+'"  style="width:55pt"></td>'+
        '<td><input type="text" name="isc[]" id="isc[]" value="'+isc+'"  style="width:55pt"></td>'+
        '<td><input type="text" name="igv[]" id="igv[]" value="'+igv+'"  style="width:55pt"></td>'+
        '<td><input type="text" name="otrosc[]" id="otrosc[]" value="'+otrosc+'"  style="width:55pt"></td>'+
        '<td><input type="text" name="total[]" id="total[]" value="'+total+'"  style="width:55pt"></td>'+
        '<td><input type="text" name="tipocpm[]" id="tipocpm[]" value="'+tipocpm+'"  style="width:15pt"></td>'+
        '<td><input type="text" name="seriecpm[]" id="seriecpm[]" value="'+seriecpm+'"  style="width:55pt"></td>'+
        '<td><input type="text" name="numerocpm[]" id="numerocpm[]" value="'+numerocpm+'"  style="width:55pt"></td>'+

        '</tr>'
        
        detalles=detalles+1;
        cont++;

        $('#detalles').append(fila);
        limpiar();
       
 }

 function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardarcliente").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/rcontingencia.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    
              bootbox.alert(datos);           
              limpiar();
              $(".filas").remove();
        }

    });
    

}
  

  init();