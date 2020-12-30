<?php

session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Médico') {
    header("Location: data_source/cerrarUsuario.php?error=1");
}

?>

<!DOCTYPE html>
	<html lang="es">
	<head>
	<title>Covid - Médico</title>
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
	<?php include 'navbar.php';
?>
		<div class="container d-flex justify-content-center p-5">
        <div class="row-flex" >
                <div class="h3 text-center">Listado de Pacientes</div>
                <form action="data_source/listado_pacientes.php" method="post" class="mt-5">
                    <input name="contagiado" type="checkbox" class="mr-2"> Contagiados
                    <input name="asintomatico" type="checkbox" class="m-2"> Asintomáticos
                    <input name="recuperado" type="checkbox" class="m-2"> Curados
                    <input name="fallecido" type="checkbox" class="m-2"> Fallecidos
                    <button name="submit" type="submit" class="btn  border-primary ml-2 ">Listar</button>
                </form>
<?php if (isset($_GET['pacientes'])) {
    $response = $_GET['pacientes'];
    $rows = $response->num_rows;
    for ($i = 1; $i <= $rows;) {
        foreach ($response as $key) {
            ?>
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
	        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
	    </script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
	        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
	    </script>
	</body>

	</html>

