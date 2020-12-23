<?php
/* Autor fede */
if(isset($_SESSION['rol']) && $_SESSION['rol'] != 'Administrador')   header("Location:./index.php?error='1'");  
require './bdd/config.php';
require './bdd/consulta.php';

$conn = Cuentas::login();
$result = Consulta::listado_usuarios($conn);
