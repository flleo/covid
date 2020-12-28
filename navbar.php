<?php

$user = '';

if (isset($_SESSION['nombre'])) {
    $user = $_SESSION['nombre'];
}

?>
<!-- author: fedelleos@gmail.com -->

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php"><img id='logo' src="img/logo.jpg"><span class="ml-5 text-success">Centro
            Covid
            2020</span></a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="d-flex ml-auto">
            <?php if ($user == '') {
    echo '
                <a class="nav-link text-info" href="index.php?log=us">Usuarios<span
                        class="sr-only">(current)</span></a>
                <a class="nav-link text-info" href="index.php?log=pa">Pacientes</a>
                ';
} else {
    if (isset($_SESSION['rol'])) {
        echo '
                                <a class="nav-link text-info"  onclick="usuarios()" href="">Usuarios <span
                                        class="sr-only">(current)</span></a>
                                <a class="nav-link text-info"  onclick="pacientes()" href="#">Pacientes</a>
                                ';
    }

    echo '<a id="user" class="nav-link text-success" href="modificar_usuario.php">' . $user . '<span
                class="sr-only">(current)</span></a>
                <a class="nav-link text-secondary" href="./data_source/cerrarUsuario.php">Salir<span
                        class="sr-only">(current)</span></a>';
}

?>
        </div>
    </div>
</nav>