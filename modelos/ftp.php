<?php
//ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    require_once("ftp-directory.php");
    class ftp extends ftp_directory
    {
        /* // FUNCION PARA DESCARGAR LOS ARCHIVOS
                A ESTA FUNCION LE ENVIAMOS:
                $file: Archivo a Descargar
                $location : Ruta donde Donde se guardara
                $mode: Modo de Descarga
        *********************************************************/
        public function download($file, $location, $mode)
        {
            if ($mode != "FTP_ASCII" || $mode != "FTP_BINARY")
            {
                $mode == "FTP_ASCII";
            }
            if (!self::isUsable($location))
            {
                $location = $file;
            }
            if (!self::isUsable($file))
            {
                return self::print_error("InvalidParameterException");
            }
            if (ftp_get($this->connection, $location, $file, $mode))
            {
                return "Download Successful. $file saved to $location";
            }
            else
            {
                return "Could Not Download Specified File";
            }
        }
    }
?>