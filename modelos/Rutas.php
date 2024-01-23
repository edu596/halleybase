<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Rutas
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($rutadata,$rutafirma,$rutaenvio, $rutarpta, $rutadatalt, $rutabaja, $rutaresumen, $rutadescargas, $rutaple,$idempresa,$unziprpta , $rutaarticulos, $rutalogo,  $rutausuarios, $salidafacturas, $salidaboletas)
    {
        $sql="insert into
         rutas (
            rutadata,
            rutafirma,
            rutaenvio,
            rutarpta,
            rutadatalt,
            rutabaja,
            rutaresumen,
            rutadescargas,
            rutaple,
            idempresa,
            unziprpta,
            $rutaarticulos, $rutalogo,  $rutausuarios, salidafacturas, salidaboletas
            
            )
        values ('$rutadata','$rutafirma','$rutaenvio', '$rutarpta', '$rutadatalt', '$rutabaja', '$rutaresumen', '$rutadescargas', '$rutaple', '$idempresa', '$unziprpta',  '$rutaarticulos', '$rutalogo',  '$rutausuarios', '$salidafacturas', '$salidaboletas'   )";

        $pathRuta = $rutadata;
        if (!is_dir($pathRuta)) {
            mkdir($pathRuta, 0777, true);
        }

        $pathFirma = $rutafirma;
        if (!is_dir($pathFirma)) {
            mkdir($pathFirma, 0777, true);
        }

        $pathEnvio = $rutaenvio;
        if (!is_dir($pathEnvio)) {
            mkdir($pathEnvio, 0777, true);
        }

        $pathRpta = $rutarpta;
        if (!is_dir($pathRpta)) {
            mkdir($pathRpta, 0777, true);
        }

        $pathDataal = $rutadatalt;
        if (!is_dir($pathDataal)) {
            mkdir($pathDataal, 0777, true);
        }

        $pathBaja = $rutabaja;
        if (!is_dir($pathBaja)) {
            mkdir($pathBaja, 0777, true);
        }

        $pathResumen = $rutaresumen;
        if (!is_dir($pathResumen)) {
            mkdir($pathResumen, 0777, true);
        }

        $pathDescargas = $rutadescargas;
        if (!is_dir($pathDescargas)) {
            mkdir($pathDescargas, 0777, true);
        }

        $pathPle = $rutaple;
        if (!is_dir($pathPle)) {
            mkdir($pathPle, 0777, true);
        }

        $pathUnzip = $unziprpta;
        if (!is_dir($pathUnzip)) {
            mkdir($pathUnzip, 0777, true);
        }

        $pathArti = $rutaarticulos;
        if (!is_dir($pathArti)) {
            mkdir($pathArti, 0777, true);
        }

        $pathLogo = $rutalogo;
        if (!is_dir($pathLogo)) {
            mkdir($pathLogo, 0777, true);
        }

        $pathUsuario = $rutausuarios;
        if (!is_dir($pathUsuario)) {
            mkdir($pathUsuario, 0777, true);
        }


        $pathSalidaF = $salidafacturas;
        if (!is_dir($pathSalidaF)) {
            mkdir($pathSalidaF, 0777, true);
        }


        $pathSalidaB = $salidaboletas;
        if (!is_dir($pathSalidaB)) {
            mkdir($pathSalidaB, 0777, true);
        }


        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para editar registros
    public function editar($idruta,$rutadata,$rutafirma,$rutaenvio, $rutarpta, $rutadatalt, $rutabaja, $rutaresumen, $rutadescargas, $rutaple,$idempresa, $unziprpta , $rutaarticulos, $rutalogo,  $rutausuarios, $salidafacturas, $salidaboletas)
    {
        $sql="update rutas 
        set 
        rutadata='$rutadata',
        rutafirma='$rutafirma',
         rutaenvio='$rutaenvio',
         rutarpta='$rutarpta',
         rutadatalt='$rutadatalt',
         rutabaja='$rutabaja',
         rutaresumen='$rutaresumen',
         rutadescargas='$rutadescargas',
         rutaple='$rutaple',
         idempresa='$idempresa',
         unziprpta='$unziprpta',
         rutaarticulos='$rutaarticulos', 
         rutalogo='$rutalogo',  
         rutausuarios='$rutausuarios',
         salidafacturas='$salidafacturas',
         salidaboletas='$salidaboletas'
        where 
        idruta='$idruta'";


        $pathRuta = $rutadata;
        if (!is_dir($pathRuta)) {
            mkdir($pathRuta, 0777, true);
        }

        $pathFirma = $rutafirma;
        if (!is_dir($pathFirma)) {
            mkdir($pathFirma, 0777, true);
        }

        $pathEnvio = $rutaenvio;
        if (!is_dir($pathEnvio)) {
            mkdir($pathEnvio, 0777, true);
        }

        $pathRpta = $rutarpta;
        if (!is_dir($pathRpta)) {
            mkdir($pathRpta, 0777, true);
        }

        $pathDataal = $rutadatalt;
        if (!is_dir($pathDataal)) {
            mkdir($pathDataal, 0777, true);
        }

        $pathBaja = $rutabaja;
        if (!is_dir($pathBaja)) {
            mkdir($pathBaja, 0777, true);
        }

        $pathResumen = $rutaresumen;
        if (!is_dir($pathResumen)) {
            mkdir($pathResumen, 0777, true);
        }

        $pathDescargas = $rutadescargas;
        if (!is_dir($pathDescargas)) {
            mkdir($pathDescargas, 0777, true);
        }

        $pathPle = $rutaple;
        if (!is_dir($pathPle)) {
            mkdir($pathPle, 0777, true);
        }

        $pathUnzip = $unziprpta;
        if (!is_dir($pathUnzip)) {
            mkdir($pathUnzip, 0777, true);
        }

        $pathArti = $rutaarticulos;
        if (!is_dir($pathArti)) {
            mkdir($pathArti, 0777, true);
        }

        $pathLogo = $rutalogo;
        if (!is_dir($pathLogo)) {
            mkdir($pathLogo, 0777, true);
        }

        $pathUsuario = $rutausuarios;
        if (!is_dir($pathUsuario)) {
            mkdir($pathUsuario, 0777, true);
        }


        $pathSalidaF = $salidafacturas;
        if (!is_dir($pathSalidaF)) {
            mkdir($pathSalidaF, 0777, true);
        }


        $pathSalidaB = $salidaboletas;
        if (!is_dir($pathSalidaB)) {
            mkdir($pathSalidaB, 0777, true);
        }


        return ejecutarConsulta($sql);
    }
 
   
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idruta)
    {
        $sql="select
         * 
        from
        rutas  
        where 
        idruta='$idruta'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar2($idempresa)
    {
        $sql="select * from rutas r inner join empresa e on r.idempresa=e.idempresa  
        where 
        e.idempresa='$idempresa'";
        return ejecutarConsulta($sql);
    }

    public function listar($idempresa)
    {
        $sql="select * from rutas r inner join empresa e on r.idempresa=e.idempresa where e.idempresa='$idempresa'";
        return ejecutarConsulta($sql);      
    }
 
 
}
 
?>