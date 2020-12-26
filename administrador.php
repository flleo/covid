<?php

    session_start();

    if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') header("Location:index.php");

?>
<!doctype html>
<html lang="es">

<head>
    <title>Covid - Administrador</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="fedelleos@gmail.com" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- css -->
    <link rel="stylesheet" href="css/css.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
</head>

<body>
    <?php include 'navbar.php';?>
    <input type="text" name="buscador" id="buscador" class="form-control" >
    <div class="container d-flex justify-content-center p-5">
        
        <table id="usuarios" class="table table-hover ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">1º Apellido</th>
                    <th scope="col">2º Apellido</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contraseña</th>
                    <th scope="col">Roll</th>
                </tr>
            </thead>
            <tbody>
                <form action="data_source/nuevo_usuario.php" method="post">
                    <tr>
                        <td>*</td>
                        <td><input name="nombre"></td>
                        <td><input name="apellido1"></td>
                        <td><input name="apellido2"></td>
                        <td><input name="email" type="email" ></td>
                        <td><input name="password" type="password"></td>
                        <td><select id="select" name="rol" >
                            <option value="Medico">Medico</option>
                            <option value="Rastreador">Rastreador</option>
                            <option value="Administrador">Administrador</option>
                        </select></td>
                        <td><button name="submit" class="btn" type="submit">Nuevo</button></td>
                    </tr>
                </form>
                <?php
                include 'data_source/listado_usuarios.php';
                $result;
                $rows = $result->num_rows;
                    for($i=1; $i<=$rows; )
                        foreach ($result as $key) {
                            echo '
                            <form action="data_source/actualizar_usuario.php" method="post">
                            <tr >
                            <th scope="row">'.$i.'</th>
                            <td hidden><input name="id" type="number" value="'.$key['ID'].'"></td>
                            <td ><input name="nombre" value="'.$key['Nombre'].'"></td>
                            <td ><input name="apellido1" value="'.$key['Apellido1'].'"</td>
                            <td ><input name="apellido2" value="'.$key['Apellido2'].'"</td>
                            <td ><input name="email" type="email" value="'.$key['Email'].'"</td>
                            <td ><input name="password" type="password" value="'.$key['Contrasena'].'"</td>
                            <td><select id="select" name="rol" >
                            <option value="'.$key['Roll'].'">'.$key['Roll'].'</option>
                            <option value="Medico">Medico</option>
                            <option value="Rastreador">Rastreador</option>
                            <option value="Administrador">Administrador</option>
                            </select></td>
                            <td><button name="submit" class="btn" type="submit">Modificar</button></td>
                            </tr>
                            </form>
                            ';
                            $i++;
                        }
                ?>

            </tbody>
        </table>
    </div>



    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="./js/ajax.js"></script>
<!--     <script>
    function usuarios() {

        $('#usuarios').show();
        $('#pacientes').hide();
    }

    function pacientes() {
        $('#usuarios').hide();
        $('#pacientes').show();
    }
    </script> -->
</body>

</html>