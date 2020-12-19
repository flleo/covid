<?php
session_start();
$user = 'User';
if(isset($_SESSION['user'])) $user = $_SESSION['user'];
?>
<!-- author: fedelleos@gmail.com -->
<link rel="stylesheet" href="css/css.css">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php"><img id='logo' src="img/logo.jpg"><span class="ml-5 text-success">Centro Covid
            2020</span></a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="d-flex ml-auto">
            <a class="nav-link text-info" href="index.php?log=pa">Pacientes <span class="sr-only">(current)</span></a>
            <a class="nav-link text-info" href="index.php?log=pe">Personal del centro</a>
            <a class="nav-link text-info" href="modificar_usuario.php"><?php echo $user; ?><span class="sr-only">(current)</span></a>
            <a class="nav-link text-secondary" href="#">Salir</a>
        </div>
    </div>
</nav>