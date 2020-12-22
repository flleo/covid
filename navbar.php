<?php
$user = '';
if(isset($_SESSION['nombre'])) $user = $_SESSION['nombre'];
?>
<!-- author: fedelleos@gmail.com -->

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php"><img id='logo' src="img/logo.jpg"><span class="ml-5 text-success">Centro
            Covid
            2020</span></a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="d-flex ml-auto">
            <?php if($user == 'Login') {   
                echo '          
                <a class="nav-link text-info" href="index.php?log=pa">Pacientes <span
                        class="sr-only">(current)</span></a>
                <a class="nav-link text-info" href="index.php?log=pe">Personal del centro</a>
                ';
            } else {    
                switch($_SESSION['rol']) {
                    case 'administrador': 
                        echo '          
                        <a class="nav-link text-info" href="usuarios.php?log=pa">Usuarios <span
                                class="sr-only">(current)</span></a>
                        <a class="nav-link text-info" href="pacientes.php?log=pe">Pacientes</a>
                        ';
                        break;
                    case 'rastreador': 
                          
                        break;
                }            
                echo '
                <a id="user" class="nav-link text-success" href="modificar_usuario.php">'. $user.'<span
                        class="sr-only">(current)</span></a>
                <a class="nav-link text-secondary" href="index.php">Salir</a>
                ';
            }
            
            ?>
        </div>
    </div>
</nav>