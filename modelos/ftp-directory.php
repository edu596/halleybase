<?php
    require_once("ftp-connect.php");
 
    class ftp_directory extends connection
    {
        //Establece las opciones/permisos de navegacion
        private static $_acceptedOptions = array("name", "goto", "display", "create", "delete", "count");
        public function manipulate_directory($params, $others)
        {
            if (!self::isUsable($params) || !in_array($params, self::$_acceptedOptions))
            {
                return self::print_error("InvalidParameterException");
            }
            if ($params == "name") // nombre del usuario
            {
                return self::pwd();
            }
            else if ($params == "goto") // Ir a un directorio especifico
            {
                if (!self::isUsable($others))
                {
                    return self::print_error("InvalidInstructionRequestException");
                }
                else
                {
                    if (self::chdir($others)) // CAMBIAR DE DIRECTORIO
                    {
                        return "Directory Change Successful";
                    }
                    else
                    {
                        return "We were unable to change the directory";
                    }
                }
            }


            else if ($params == "display") // VER Y/O LISTAR LOS ARCHIVOS Y DIRECTORIOS
            {
                if (!self::isUsable($others))
                {
                    return self::print_error("InvalidInstructionRequestException");
                }
                else
                {
                   return self::nlist($others);
                   //$nombres=array();
                   //$nombres[]=self::nlist($others);
                   //return var_dump($nombres);
                  //for($i=2; $i < count($nombres) ; $i++){
                   //foreach ($nombres as $v1 ) {
             		
                   //return self::nlist($others).$v1;
                   //}
               	//}

                   
                   
                }
            }
            else if ($params == "create") // CREAR UN DIRECTORIO
            {
                if (!self::isUsable($others))
                {
                    return self::print_error("InvalidInstructionRequestException");
                }
                else
                {
                    if (self::mkdir($others))
                    {
                        return "$others created successfully";
                    }
                    else
                    {
                        return "We Could Not Create The Directory: $others";
                    }
                }
            }
            else if ($params == "delete") // BORRAR UN DIRECTORIO
            {
                if (!self::isUsable($others))
                {
                    return self::print_error("InvalidInstructionRequestException");
                }
                else
                {
                    if (self::rmdir($others))
                    {
                        return "$others deleted successfully";
                    }
                    else
                    {
                        return "We Could Not Delete The Directory: $others";
                    }
                }
            }
            else if ($params == "count") // BORRAR UN DIRECTORIO
            {
                if (!self::isUsable($others))
                {
                    return self::print_error("InvalidInstructionRequestException");
                }
                else
                {
                    if (self::rmdir($others))
                    {
                        return "$others deleted successfully";
                    }
                    else
                    {
                        return "We Could Not Delete The Directory: $others";
                    }
                }
            }
        }
 
        // Funcion que verifica en cada funcion que la conexion y la clave que se proporciono
        // sea la correcta
        private function pwd()
        {
            return ftp_pwd($this->connection);
        }
 
        // Funcion que nos permite navegar entre directorios
        private function chdir($location)
        {
            if ($location == "true")
            {
                if (!ftp_cdup($this->connection))
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }
            else
            {
                if (!ftp_chdir($this->connection, $location))
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }
        }
        // funcion que recibe la lista de directorio y la muestra
        protected function nlist($location)
        {
            if (!ftp_nlist($this->connection, $location))
            {
                return "Unable to retrieve current directories files/folders";
            }
            else
            {
                return ftp_nlist($this->connection, $location);
            }
        }
        protected function mkdir($name)
        {
            if (!ftp_mkdir($this->connection, $name))
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        // Funcion que BORRA un directorio
        protected function rmdir($name)
        {
            if (!ftp_rmdir($this->connection, $name))
            {
                return false;
            }
            else
            {
                return true;
            }
        }
    }
?>