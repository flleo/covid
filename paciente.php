<?php
if(isset($_SESSION['rol']) && $_SESSION['rol'] != 'paciente')   header("Location:./index.php?error='1'");  
echo 'paciente';

?>

