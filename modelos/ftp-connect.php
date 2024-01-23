<?php
    abstract class connection
    {
        private static $_server;
        private static $_user;
        private static $_password;
        private static $_port;
        private static $ini_file = "parameters.ini"; // Archivo de configuracion
        private static $_showErrors;
        public $connection;
 
        protected function print_error($exception)
        {
            die($exception);
        }
        protected function isUsable($tocheck)
        {
            if (empty($tocheck) || ($tocheck == ''))
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        private function parse_config_data()
        {
            $config_data = parse_ini_file(self::$ini_file); // recibiendo la configuracion del archivo 'parameters.ini'
            if (!self::isUsable( $config_data["FTP_SERVER"]) || !self::isUsable($config_data["FTP_USER"]) || !self::isUsable($config_data["FTP_PASSWORD"]))
            {
                return self::print_error("EmptyDataException");
            }
            //asginando los datos de configuracio a las variables
            self::$_server = $config_data["FTP_SERVER"];
            self::$_port = $config_data["FTP_PORT"];
            self::$_user = $config_data["FTP_USER"];
            self::$_password = $config_data["FTP_PASSWORD"];
            self::$_showErrors = $config_data["SHOW_ERRORS"];
            return;
        }
        // esta funcion realiza la conexion al servidor ftp
        protected function _login()
        {
            if (!ftp_login($this->connection, self::$_user, self::$_password))
            {
                self::print_error("LoginErrorException");
            }
            else
            {
                return ftp_login($this->connection, self::$_user, self::$_password);
            }
        }
        public function __construct()
        {
            self::parse_config_data(); // Asigna los datos del archivo parameters.ini
            error_reporting(self::$_showErrors); // reporta errores si los hay
            if (!self::isUsable(self::$_port))
            {
                if (ftp_connect(self::$_server)) // Verifica si hay conexion con el servidor
                {
                    $this->connection = ftp_connect(self::$_server); // Asigna la conexion
                }
                else
                {
                    self::print_error("InvalidDataException"); // si aparce un error lo muesra
                }
            }
            else
            {
                if (ftp_connect(self::$_server, self::$_port))
                {
                    $this->connection = ftp_connect(self::$_server, self::$_port); // establesco la conexion mediante la url o IP del servidor mas su puerto
                }
                else
                {
                    self::print_error("InvalidDataException");
                }
            }
            return self::_login(); // en caso de funcionar todo bien realiza la conexion
        }
    }
?>