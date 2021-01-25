<?php

session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header("Location: data_source/cerrarUsuario.php?error=1");
}

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
    <link rel="shortcut icon" href="img/logo_1.png" />
</head>
<style type="text/css">
td input  {
    width: 150px;
}
button {
    width: 85px;
}
</style>
<body>
    <?php include 'navbar.php';?>
    <div class="container  d-flex flex-column">      
    <div class="h3 text-center">Listado de Usuarios</div>      
        <table class="table ">      
            <thead>
                <tr>
                    <th >Nombre</th>
                    <th>1er Apellido</th>
                    <th>2º Apellido</th>
                    <th>Email</th>
                    <th>Contraseña</th>
                    <th>Roll</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <form action="data_source/nuevo_usuario.php"
                        class="d-flex justify-content-around p-3 m-2 border-bottom" method="post">
                        <td class="form-group ">
                            <input  type="text" name='nombre' placeholder="Nombre" id="newNombre" require>
                        </td>
                        <td class="form-group">
                            <input type="text" name='apellido1' placeholder="Apellido" id="newapellido1" require>
                        </td>
                        <td class="form-group">
                            <input type="text" name='apellido2' placeholder="Apellido" id="newApellido2">
                        </td>
                        <td class="form-group">
                            <input type="email" name='email' placeholder="Email" id="newEmail" require>
                        </td>
                        <td class="form-group">
                            <input type='password' name='password' placeholder="Contraseña" id="newPass" require>
                        </td>
                        <td class="form-group">
                            <select id='select' name='rol' require style="height:35px;">
                                <option value='Médico'>Médico</option>
                                <option value='Rastreador'>Rastreador</option>
                                <option value='Administrador'>Administrador</option>
                            </select>
                        </td>
                        <td><button name='submit' type="submit" class="btn btn-success   "
                                style="height:35px;">Nuevo</button>
                        </td>
                    </form>
                </tr>

                <?php

include 'data_source/listado_usuarios.php';

$rows = $result->num_rows;

for ($i = 1; $i <= $rows;) {
    foreach ($result as $key) {
        ?>
                <tr>
                    <form id='listado' action='data_source/actualizar_usuarios.php'
                        class='d-flex justify-content-around p-3 m-2 border-bottom' method='post'>
                        <td class='form-group'>
                            <input name='nombre' type='text' value=<?php echo $key['Nombre'] ?> require>
                        </td>
                        <td class='form-group'>
                            <input name='apellido1' type='text' value=<?php echo $key['Apellido_1'] ?> require>
                        </td>
                        <td class='form-group'>
                            <input name='apellido2' type='text' value=<?php echo $key['Apellido_2'] ?>>
                        </td>
                        <td class='form-group'>
                            <input name='email' type='text' value=<?php echo $key['Email'] ?>>
                        </td>
                        <td class='form-group'>
                            <input name='password' type='password' value=<?php echo $key['Contrasena'] ?> require>
                        </td>
                        <td class='form-group'>
                            <select id='select' name='rol' require style="height:35px;">
                                <option value=<?php echo $key['Roll'] ?>><?php echo $key['Roll'] ?></option>
                                <option value='Médico'>Médico</option>
                                <option value='Rastreador'>Rastreador</option>
                                <option value='Administrador'>Administrador</option>
                            </select>
                        </td>
                        <td>
                            <button type='submit' name='submit' value=<?php echo $key['ID'] ?>
                                class='btn btn-primary ' style="height:35px;">Modificar</button>
                        </td>
                    </form>
                </tr>
                <?php        
$i++;
    }
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



</body>

</html>