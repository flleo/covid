<?php
include 'navbar.php';

/*  echo $action  */

$nombre = $apellido1 = $apellido2 = $email = $pass = $dni = $telefono = '';
?>

<!doctype html>
<html lang="en">

<head>
    <title>covid - modifica usuario</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="fedelleos@gmail.com" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/css.css">
</head>

<body>
    <div class="container d-flex justify-content-center p-5">
        <div id="login-box" class="col-md-6">
            <form id="login-form" action="" method="post">
                <h3 class="text-center text-info">Modificar Usuario</h3>
                <?php
                    if($_SESSION['user_type'] == 'usuario') {
                        echo '
                        <div class="form-group">
                        <label for="nombre" class="text-info">Nombre</label><br>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="'.$nombre.'" required>
                        </div>
                        <div class="form-group">
                        <label for="apellido1" class="text-info">Apellido1</label><br>
                        <input type="text" name="apellido1" id="apellido1" class="form-control" value="'.$apellido1.'" required>
                        </div>
                        <div class="form-group">
                        <label for="apellido2" class="text-info">Apellido2</label><br>
                        <input type="text" name="apellido2" id="apellido2" class="form-control" value="'.$apellido2.'" required>
                        </div>
                    <div class="form-group">
                    <label for="email" class="text-info">Email</label><br>
                    <input type="email" name="email" id="email" class="form-control" value="'.$email.'" required>
                    </div>
                    <div class="form-group">
                    <label for="password" class="text-info">Password</label><br>
                    <input type="text" name="password" id="password" class="form-control" value="'.$pass.'" required>
                    </div>
                    ';
                    }  else {
                        echo '
                    <div class="form-group">
                    <label for="dni" class="text-info">Dni</label><br>
                    <input type="dni" name="dni" id="dni" class="form-control" value="'.$dni .'" required>
                    </div>
                    <div class="form-group">
                    <label for="email" class="text-info">Email</label><br>
                    <input type="email" name="email" id="email" class="form-control" value="'.$email.'" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="text-info">Nombre</label><br>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="'.$nombre.'" required>
                        </div>
                        <div class="form-group">
                        <label for="apellido1" class="text-info">Apellido1</label><br>
                        <input type="text" name="apellido1" id="apellido1" class="form-control" value="'.$apellido1.'" required>
                        </div>
                        <div class="form-group">
                        <label for="apellido2" class="text-info">Apellido2</label><br>
                        <input type="text" name="apellido2" id="apellido2" class="form-control" value="'.$apellido2.'" required>
                        </div>
                    <div class="form-group">
                    <label for="telefono" class="text-info">Teléfono</label><br>
                    <input type="text" name="telefono" id="telefono" class="form-control" value="'.$telefono.'" required>
                    </div>
                    ';
                    }
                ?>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-info btn-md" value="Grabar">
                </div>
            </form>
        </div>
    </div>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>