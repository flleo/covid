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
</head>

<body>
    <?php include 'navbar.php';?>
    <div class="container d-flex flex-column justify-content-start p-5 mx-2">
            <div class="row d-flex align-items-center row-1 ml-5">
                <label for="buscador">Busqueda por 1er apellido: </label>
                <input type="text" name="buscador" id="buscador" class="form-control m-4 col-2">
            </div>
            <!-- Usuarios -->
            <div id="usuarios" class="row-flex ml-5  col-12">
                <div class="h3 text-center">Listado de Usuarios</div>
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
                    <form action="data_source/nuevo_usuario.php" class="d-flex justify-content-around p-3 m-2 border-bottom"
                        method="post">
                        <div class="form-group">
                            <input type="text" name='nombre' placeholder="Enter email" id="newNombre" require>
                        </div>
                        <div class="form-group">
                            <input type="text" name='apellido1' placeholder="Enter email" id="newapellido1" require>
                        </div>
                        <div class="form-group">
                            <input type="text" name='apellido2' placeholder="Enter email" id="newApellido2">
                        </div>
                        <div class="form-group">
                            <input type="email" name='email' placeholder="Enter email" id="newEmail" require>
                        </div>
                        <div class="form-group">
                            <input type='password' name='password' placeholder="Enter email" id="newPass" require>
                        </div>
                        <div class="form-group">
                            <select id='select' name='rol' require>
                                <option value='Medico'>Médico</option>
                                <option value='Rastreador'>Rastreador</option>
                                <option value='Administrador'>Administrador</option>
                            </select>
                        </div>
                        <button name='submit' type="submit" class="btn btn-success col-1">Nuevo</button>
                    </form>
                </div>

                <?php

include 'data_source/listado_usuarios.php';

$rows = $result->num_rows;
for ($i = 1; $i <= $rows;) {
    foreach ($result as $key) {
?>
                    <div id='listado'>
                        <form action='data_source/actualizar_usuarios.php' class='d-flex justify-content-around p-3 m-2 border-bottom' method='post'>
                            <div class='form-group'>
                                <input name='nombre' type='text' value=" <?php echo $key['Nombre'] ?> " require >
                            </div>
                                <div class='form-group'>
                                    <input name='apellido1' type='text' value=" <?php echo $key['Apellido_1']?>  " require>
                                </div>
                                <div class='form-group'>
                                    <input name='apellido2' type='text' value="  <?php echo $key['Apellido_2']?>  " >
                                </div>
                                <div class='form-group'>
                                    <input name='email' type='text' value="  <?php echo $key['Email']?>  " >
                                </div>
                                <div class='form-group'>
                                    <input name='password' type='password' value="   <?php echo $key['Contrasena']?>  " require>
                                </div>
                                <div class='form-group'>
                                    <select id='select' name='rol' require>
                                        <option value="  <?php echo $key['Roll'] ?> ">"   <?php echo $key['Roll']?>  "</option>
                                        <option value='Médico'>Medico</option>
                                        <option value='Rastreador'>Rastreador</option>
                                        <option value='Administrador'>Administrador</option>
                                    </select>
                                </div>
                                <button type='submit' name='submit' value="   <?php echo $key['ID']?>  " class='btn btn-primary col-1'>Modificar</button>    
                        </form>                         
                    </div>
<?php
        $i++;
    }
}
?>
            </div>
  
            <!-- Pacientes . Hay que ocultarlo para que no salga de comienzo-->
            <div id="pacientes" class="row-flex " style="display:none;">            
                <div class="h3 text-center">Listado de Pacientes</div>
                <form action="data_source/listado_pacientes.php" method="post" class="mt-5">
                    <input name="contagiado" type="checkbox" class="mr-2"> Contagiados
                    <input name="asintomatico" type="checkbox" class="m-2"> Asintomáticos
                    <input name="recuperado" type="checkbox" class="m-2"> Curados
                    <input name="fallecido" type="checkbox" class="m-2"> Fallecidos
                    <button name="submit" type="submit" class="btn  border-primary ml-2 ">Listar</button>
                </form>
                <table class="table">
                    <thread id="pacientes_enunciado" class="d-flex justify-content-around  p-3 m-2 border-bottom">
                        <tr>
                            <th>Dni</th>
                            <th>Código de Acceso</th>
                            <th>Email</th>
                            <th>Nombre</th>
                            <th>1er Apellido</th>
                            <th>2º Apellido</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th> </th>
                        </tr>
                    </thread>
                    <tbody>
                        <tr>
                            <form action="data_source/nuevo_paciente.php"
                                class="d-flex justify-content-around p-3 m-2 border-bottom" method="post">
                                <td class="form-group">
                                    <input type="text" name='dni' placeholder="Enter dni" id="newDni" require>
                                </td>
                                <td class="form-group">
                                    <input type='text' disabled>
                                </td>
                                <td class="form-group">
                                    <input type="email" name='email' placeholder="Enter email" id="newEmail">
                                </td>
                                <td class="form-group">
                                    <input type="text" name='nombre' placeholder="Enter name" id="newNombre" require>
                                </td>
                                <td class="form-group">
                                    <input type="text" name='apellido1' placeholder="Enter 1er apellido"
                                        id="newapellido1" require>
                                </td>
                                <td class="form-group">
                                    <input type="text" name='apellido2' placeholder="Enter 2º apellido"
                                        id="newApellido2">
                                </td>
                                <td class="form-group">
                                    <input type='text' name='telefono' placeholder="Enter telefono" id="newTelefono"
                                        require>
                                </td>
                                <td class="form-group">
                                    <select id='select' name='estado' require>
                                        <option value='Contagiado'>Contagiado</option>
                                        <option value='Asintomático'>Asintomático</option>
                                        <option value='Recuperado'>Recuperado</option>
                                        <option value='Fallecido'>Fallecido</option>
                                    </select>
                                </td>
                                <td><button name='submit' type="submit" role="button"
                                        class="btn btn-success ">Nuevo</button></td>
                            </form>
                        </tr>
                  
                        <?php

if (isset($_GET['pacientes'])) {
    $response = $_GET['pacientes'];
    $rows = $response->num_rows;
    for ($i = 1; $i <= $rows;) {
        foreach ($response as $key) {
                        ?>
                    <tr id="listado" class="listado">
                        <form action="data_source/actualizar_pacientes.php" class="d-flex justify-content-around p-3 m-2 border-bottom" method="post">
                            <td class="form-group">
                                <input type="text" name="dni"  placeholder="Enter dni"  value="<?php echo $key['dni'] ?> " require >
                            </td>
                            <td class="form-group">
                                <input type="text" name="codigo_acceso" value=" '. $key['codigo_acceso'] . '" require >
                            </td>
                            <td class="form-group">
                                <input type="email" name="email" placeholder="Enter email"  value="<?php echo $key['email'] ?> " >
                            </td>
                            <td class="form-group">
                                <input type="text" name="nombre" placeholder="Enter name"  value="<?php echo $key['Nombre'] ?> " require >
                            </td>
                            <td class="form-group">
                                <input type="text" name="apellido1"  placeholder="Enter 1er apellido" value="<?php echo $key['apellido_1'] ?> " require >
                            </td>
                            <td class="form-group">
                                <input type="text" name="apellido2"  placeholder="Enter 2º apellido" value="<?php echo $key['apellido_2'] ?> "  >
                            </td>
                            <td class="form-group">
                                <input type="text" name="telefono"  placeholder="Enter telefono"  value="<?php echo $key['telefono'] ?> " require >
                            </td>
                            <td class="form-group">
                                <select id="select" name="estado" value="<?php echo $key['estado'] ?> " require >
                                    <option value="Contagiado">Contagiado</option>
                                    <option value="Asintomático">Asintomático</option>
                                    <option value="Recuperado">Recuperado</option>
                                    <option value="Fallecido">Fallecido</option>
                                </select>
                            </td>
                            <td><button type="submit" name="submit" value="<?php echo $key['dni'] ?> " class="btn btn-primary col-1">Modificar</button><td>
                        </form>
                    </tr>
                </tbody>
            </table>           
<?php
$i++;
        }
    }
}

?>

        </div>

    </div>




            <!-- jQuery first, then Popper.js, then Bootstrap JS -->

            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
                integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
                crossorigin="anonymous">
            </script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
                integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
                crossorigin="anonymous">
            </script>
            <script src="./js/ajax.js"></script>
            <script>
            function usuarios() {
                $('#usuarios').show();
                $('#pacientes').hide();
            }

            function pacientes() {
                $('#pacientes').show();
                $('#usuarios').hide();
            }
            // No funciona
            $.ajax({
                url: 'administrador.php?pacientes',
                type: 'get',
                success: function(response) {
                    $('#pacientes').show();
                    $('#usuarios').hide();
                }
            });

            var xhttp = new XMLHttpRequest();
            xhttp.open("GET", "administrador.php?pacientes", true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {

                    // Response
                    pacientes();

                }
            };
            xhttp.send();
            </script>

</body>

</html>