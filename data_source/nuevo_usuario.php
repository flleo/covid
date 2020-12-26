<?php
/* Autor fede */
require '../bdd/config.php';
require '../bdd/consulta.php';
session_start();

if (isset($_POST['submit'])) {   
    $conn = Cuentas::loginAdmin();
    $result = Consulta::ingresarUsuario($conn);
    if ($result) {
       header("Location:../administrador.php");              
    } else {
        header("Location:../index.php?error='1'");
    }
}



