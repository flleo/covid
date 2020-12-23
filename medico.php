<?php

if(isset($_SESSION['rol']) && $_SESSION['rol'] != 'medico')   header("Location:./index.php?error='1'");  
echo 'medico';
?>

