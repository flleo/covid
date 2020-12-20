<?php
    /* Autor Adrian */
    class Cuentas{

        public static function login(){
            $host = "localhost";
            $db = "covid_usuario";
            $usuarios = "login";
            $pass = "1234";
            $conn = new mysqli($host, $usuarios, $pass,$db);

            return $conn;
        }

        public static function loginAdmin(){
            $host = "localhost";
            $db = "covid_usuario";
            $usuarios = "admin";
            $pass = "1234";
            $conn = new mysqli($host, $usuarios, $pass,$db);

            return $conn;
        }
    }

?>