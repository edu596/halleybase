
var fecha = new Date();
var ano = fecha.getFullYear();
$("#ano").val(ano);

var mes = fecha.getMonth();
$("#mes").val(mes+1);

calcularmargeng();




$.post("../ajax/inventarios.php?op=selectAlm", function(r){
            $("#almacenlista").html(r);
            $('#almacenlista').selectpicker('refresh');



alma=$("#almacenlista").val();
$.post("../ajax/articulo.php?op=comboarticulomg&anor="+ano+"&aml="+alma, function(r){
$("#codigoInterno").html(r);
$("#codigoInterno").selectpicker('refresh');
});
});



function actualizarartialma()
{
alma=$("#almacenlista").val();
$.post("../ajax/articulo.php?op=comboarticulomg&anor="+ano+"&aml="+alma, function(r){
$("#codigoInterno").html(r);
$("#codigoInterno").selectpicker('refresh');
});


}


function eliminarmargen()
{
    bootbox.confirm("Esta seguro de eliminar", function(result)
    {
        if (result)
        {
          $.post("../ajax/repmargenganancia.php?op=eliminarmargen", function(r){
            alert(r);
            calcularmargeng() ;
                });            
        }

    })



}




function calcularmargeng() 
{ 	
	 $.post("../ajax/repmargenganancia.php?op=eliminarmargen", function(r){
     });         

    var opcion = $("#opcion1").val();
    var $idarticulo = $("#codigoInterno").val();
    var $ano = $("#ano").val();
    var $mes = $("#mes").val();

        
    tabla=$('#tbllistado').dataTable(

    {

        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        // "processing": true,
        // "language": { 
        //     'loadingRecords': '&nbsp;',
        //     'processing': '<i class="fa fa-spinner fa-spin"></i> Procesando datos.. espere'
        // },


        buttons: [     

                ],
        "ajax":
                {
                    url: '../ajax/repmargenganancia.php?op=calcularmargen&idart='+$idarticulo+'&ano='+$ano+'&mes='+$mes+'&opt='+opcion,
                    type : "post",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    
                    }
               },

        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "asc" ]]//Ordenar (columna,orden)
    }
    ).DataTable();
    
    tabla.ajax.reload();    

}

