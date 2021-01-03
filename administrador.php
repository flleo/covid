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
    <script type="text/javascript" src="js/cliente.js"></script>
    <style type="text/css">
    #individuo {
        cursor: pointer;
    }

    #individuo:hover {
        color: blue;
    }
    </style>
</head>

<body>
    <?php include 'navbar.php';?>
    <div class="container d-flex flex-column justify-content-start p-5 mx-2">
        
        <!-- Usuarios -->
        <div id="usuarios" class="row-flex ml-5  col-12">
            <div class="row d-flex align-items-center row-1 ml-5">
                <label for="buscador">Busqueda por 1er apellido: </label>
                <input type="text" name="buscador" id="buscador" class="form-control m-4 col-2">
            </div>
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
                            <option value='Médico'>Médico</option>
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
                <form action='data_source/actualizar_usuarios.php'
                    class='d-flex justify-content-around p-3 m-2 border-bottom' method='post'>
                    <div class='form-group'>
                        <input name='nombre' type='text' value=<?php echo $key['Nombre'] ?> require>
                    </div>
                    <div class='form-group'>
                        <input name='apellido1' type='text' value=<?php echo $key['Apellido_1']?> require>
                    </div>
                    <div class='form-group'>
                        <input name='apellido2' type='text' value=<?php echo $key['Apellido_2']?>>
                    </div>
                    <div class='form-group'>
                        <input name='email' type='text' value=<?php echo $key['Email']?>>
                    </div>
                    <div class='form-group'>
                        <input name='password' type='password' value=<?php echo $key['Contrasena']?> require>
                    </div>
                    <div class='form-group'>
                        <select id='select' name='rol' require>
                            <option value=<?php echo $key['Roll'] ?>><?php echo $key['Roll']?></option>
                            <option value='Médico'>Medico</option>
                            <option value='Rastreador'>Rastreador</option>
                            <option value='Administrador'>Administrador</option>
                        </select>
                    </div>
                    <button type='submit' name='submit' value=<?php echo $key['ID']?>
                        class='btn btn-primary col-1'>Modificar</button>
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
            <div class="container">
                <button type="button" onclick="lista('')" class="btn btn-primary btn-sm">Lista completa</button>
            </div>

            <div class="container" id="menu_medico">

                <form id='form'>
                    <div class='row'>
                        <div class='col-2'>
                            <label for="apellido_1">Primer apellido</label><br>
                            <input type='text' name='apellido_1' id="apellido_1">
                        </div>
                        <div class='col-2'>
                            <label for="apellido_2">Segundo apellido</label><br>
                            <input type='text' name='apellido_2' id="apellido_2">
                        </div>
                        <div class='col-2'>
                            <label for="nombre">Nombre</label><br>
                            <input type='text' name='nombre' id="nombre">
                        </div>
                        <div class='col-2'>
                            <label for="dni">D.N.I / N.I.E</label><br>
                            <input type='text' name='dni' id="dni">
                        </div>
                        <div class='col-2'>
                            <label for="codigo_acceso">Código de acceso</label><br>
                            <input type='text' name='codigo_acceso' id="codigo_acceso">
                        </div>
                        <div class='col-2'><button type='button' onclick='busqueda()' class='btn btn-secondary btn-sm'
                                title="Para buscar, introduzca un dni, un código de acceso o un primer apellido. La prioridad de búsqueda se hará en ese orden obviando el resto de datos. Para filtrar por estado, únicamente marque los estados que quiere recuperar">Buscar</button>
                        </div>

                    </div>
                    <div class="container">
                        <label class="checkbox-inline">
                            <input type="checkbox" id="contagiado" value=""> Contagiado
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" id="curado" value=""> Curado
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" id="fallecido" value=""> Fallecido
                        </label>
                    </div>

                </form>
                <hr>
                <h4 id="titulo"></h4>


            </div>

            <div class="container" id="seccion_administrador">
            </div>
            <div class="container" id="adicional">
             
            </div>


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
    <script type="text/javascript">
    lista(<?php echo $_SESSION['id']; ?>);
    </script>
    <script>
    function usuarios() {
        $('#usuarios').show();
        $('#pacientes').hide();
    }

    function pacientes() {
        $('#pacientes').show();
        $('#usuarios').hide();
    }
    
    </script>

</body>

</html>