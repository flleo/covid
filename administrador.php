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
    <div class="container-fluid">
        <div class="d-flex justify-content-around  p-3 m-2 border-bottom">
            <div>Nombre</div>
            <div>1 Apellido</div>
            <div>2 Apellido</div>
            <div>Email</div>
            <div>Contraseña</div>
            <div>Roll</div>
            <div></div>
        </div>
        <div>
            <form action="data_source/nuevo_usuario.php" class="d-flex justify-content-around p-3 m-2 border-bottom" method="post">
                <div class="form-group">
                    <input type="text" name='nombre'  placeholder="Enter email" id="newNombre">
                </div>
                <div class="form-group">
                    <input type="text" name='apellido1'  placeholder="Enter email" id="newapellido1">
                </div>
                <div class="form-group">
                    <input type="text" name='apellido2'  placeholder="Enter email" id="newApellido2">
                </div>
                <div class="form-group">
                    <input type="email" name='email' placeholder="Enter email" id="newEmail">
                </div>
                <div class="form-group">
                    <input type='password' name='password'  placeholder="Enter email" id="newPass">
                </div>
                <div class="form-group">
                    <select id='select' name='rol' >
                        <option value='Medico'>Medico</option>
                        <option value='Rastreador'>Rastreador</option>
                        <option value='Administrador'>Administrador</option>
                    </select>
                </div>
                    <button name='submit' type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div id='listado'>
        <?php
            include 'data_source/listado_usuarios.php';
            $rows = $result->num_rows;
            for($i=1; $i<=$rows; )
                foreach ($result as $key) {
                    echo "
                    <div class='listado'>
                    <form action='data_source/actualizar_usuario.php' class='d-flex justify-content-around p-3 m-2 border-bottom' method='post'>
                        <div class='form-group'>
                            <input name='nombre' type='text' value=".$key['Nombre'].">
                        </div>
                        <div class='form-group'>
                            <input name='apellido1' type='text' value=".$key['Apellido1'].">
                        </div>
                        <div class='form-group'>
                            <input name='apellido2' type='text' value=".$key['Apellido2'].">
                        </div>
                        <div class='form-group'>
                            <input name='email' type='text' value=".$key['Email'].">
                        </div>
                        <div class='form-group'>
                            <input name='password' type='text' value=".$key['Contrasena'].">
                        </div>
                        <div class='form-group'>
                            <select id='select' name='rol' >
                                <option value=".$key['Roll'].">".$key['Roll']."</option>
                                <option value='Medico'>Medico</option>
                                <option value='Rastreador'>Rastreador</option>
                                <option value='Administrador'>Administrador</option>
                            </select>
                        </div>
                            <button type='submit' name='submit' value=".$key['ID']." class='btn btn-primary'>Submit</button>
                    </form>
                </div>
                    
                    ";
                    $i++;
                }
        ?>
        </div>
    </div>



    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="./js/ajax.js"></script>
</body>

</html>