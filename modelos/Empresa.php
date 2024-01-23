<?php 

//Incluímos inicialmente la conexión a la base de datos

require "../config/Conexion.php";

 

Class Empresa

{

    //Implementamos nuestro constructor

    public function __construct()

    {

 

    }

 

    //Implementamos un método para insertar registros

    public function insertar($razonsocial,$ncomercial,$domicilio,$ruc,$tel1,$tel2,$correo,
        $web,$webconsul,$imagen, $ubigueo, $igv, $porDesc, $codubigueo, $ciudad, $distrito,
                $interior,
                $codigopais, $banco1, $cuenta1 , $banco2, $cuenta2 , $banco3, $cuenta3 , $banco4, $cuenta4, $cuentacci1,
                $cuentacci2,
                $cuentacci3,
                $cuentacci4, $tipoimpresion, $textolibre, $envioauto, $rutarchivos)
    {



        $sw=true;





        $sql="insert into
         empresa (nombre_razon_social,
            nombre_comercial,
            domicilio_fiscal,
            numero_ruc,
            telefono1, 
            telefono2, 
            correo, 
            web,
            webconsul, 
            logo,
            ubigueo,
            codubigueo,
            ciudad,
            distrito,
            interior,
            codigopais,
            banco1,
            cuanta1,
            banco2,
            cuenta2
            banco3,
            cuenta3,
            banco4,
            cuenta4,
            cuentacci1,
                cuentacci2,
                cuentacci3,
                cuentacci4,
                tipoimpresion,
                textolibre,
                envioauto,
                rutarchivos

            )

        values ('$razonsocial','$ncomercial','$domicilio','$ruc','$tel1','$tel2','$correo','$web','$webconsul','$imagen', '$ubigueo', '$codubigueo', '$ciudad', '$distrito', '$interior', '$codigopais' , '$banco1' , '$cuenta1' , '$banco2' , '$cuenta2' , '$banco3' , '$cuenta3' , '$banco4' , '$cuenta4' , '$cuentacci1', '$cuentacci2', '$cuentacci3', '$cuentacci4', '$tipoimpresion', '$textolibre', '$envioauto', '$rutarchivos')";
        $idempresanew=ejecutarConsulta_retornarID($sql);

        $sqlConf="insert into
         configuraciones 
         (
            idempresa,
            igv,
            porDesc
            )
        values ('$idempresanew','$igv','$porDesc')";
        ejecutarConsulta($sqlConf) or $sw = false;


        


      

        return $sw;

    }

 

    //Implementamos un método para editar registros

    public function editar($idempresa,$razonsocial,$ncomercial,$domicilio,$ruc,$tel1,$tel2,$correo,$web,$webconsul,$imagen, $ubigueo, $igv, $porDesc, $codubigueo, $ciudad,

                $distrito,

                $interior,

                $codigopais ,$banco1, $cuenta1 , $banco2, $cuenta2 , $banco3, $cuenta3 , $banco4, $cuenta4, $cuentacci1,

                $cuentacci2,

                $cuentacci3,

                $cuentacci4, $tipoimpresion, $textolibre, $envioauto, $rutarchivos)

    {



        $sw=true;



        $sql="update empresa 

        set 

        nombre_razon_social='$razonsocial', 

        nombre_comercial='$ncomercial', 

        domicilio_fiscal='$domicilio', 

        numero_ruc='$ruc', 

        telefono1='$tel1', 

        telefono2='$tel2', 

        correo='$correo', 

        web='$web', 

        webconsul='$webconsul', 

        logo='$imagen',

        ubigueo='$ubigueo',

        codubigueo='$codubigueo',

        ciudad='$ciudad',

        distrito='$distrito',

        interior='$interior',

        banco1='$banco1',

        cuenta1='$cuenta1',

        banco2='$banco2',

        cuenta2='$cuenta2',

        banco3='$banco3',

        cuenta3='$cuenta3',

        banco4='$banco4',

        cuenta4='$cuenta4',

        cuentacci1='$cuentacci1',

        cuentacci2='$cuentacci2',

        cuentacci3='$cuentacci3',

        cuentacci4='$cuentacci4',

        codigopais='$codigopais',

        tipoimpresion='$tipoimpresion',
        textolibre= '$textolibre',
        envioauto='$envioauto',
        rutarchivos='$rutarchivos'

        where 

        idempresa='$idempresa'";



        $sqlConf="update configuraciones 

        set 

        igv='$igv', 

        porDesc='$porDesc' 

        where 

        idempresa='$idempresa'";





        ejecutarConsulta($sql) or $sw = false;

        ejecutarConsulta($sqlConf) or $sw = false;



        return $sw;

    }





   

    //Implementar un método para mostrar los datos de un registro a modificar

    public function mostrar($idempresa)

    {

        $sql="select  *  from
         empresa e  inner join  configuraciones cf on e.idempresa=cf.idempresa 
         inner join rutas r on e.idempresa=r.idempresa
         where 
         e.idempresa='$idempresa'";

        return ejecutarConsultaSimpleFila($sql);

    }



    public function listar()

    {

        $sql="select * from empresa e inner join rutas r on e.idempresa=r.idempresa where e.idempresa='1'";

        return ejecutarConsulta($sql);      

    }

 

 

}

 

?>