<?php

$login = $email = $pass = $dni = $code = $user_type = '';


if(isset($_GET['log'])) {
    if($_GET['log'] == 'pa') {        
        $user_type = 'paciente';       
    } else {
        $user_type = 'usuario';        
    }
}


?>
<!doctype html>
<html lang="es">
<head>
<title>Covid - Login</title>
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
if(isset($_SESSION['email'])) $email = $_SESSION['email'];
if(isset($_SESSION['password'])) $pass = $_SESSION['password'];
if(isset($_SESSION['dni'])) $dni = $_SESSION['dni'];
if(isset($_SESSION['code'])) $code = $_SESSION['code'];

if(isset($_POST['submit'])) {
    if(isset($_POST['email'])) {
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['password'] = $_POST['password'];
    } else {
        $_SESSION['dni'] = $_POST['dni'];
        $_SESSION['code'] = $_POST['code'];
    }
}
  
?>
    <div class="container d-flex justify-content-center p-5">
     
        <div id="login-box" class="col-md-6">
            <form id="login-form" action="./data_source/validar_login.php" method="post">
                <h3 class="text-center text-info">Login</h3>
                <?php
                    if($user_type == 'usuario') {
                        echo '
                    <div class="form-group">
                        <label for="email" class="text-info">Email</label><br>
                        <input type="email" name="email" id="email" class="form-control" value="'.$email.'" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="text-info">Password:</label><br>
                        <input type="password" name="password" id="password" class="form-control" value="'.$pass.'" required>
                    </div>
                    ';
                    }  else {
                        echo '
                    <div class="form-group">
                        <label for="dni" class="text-info">Dni</label><br>
                        <input type="dni" name="dni" id="dni" class="form-control" value="'.$dni .'" required>
                    </div>
                    <div class="form-group">
                        <label for="code" class="text-info">Código de acceso</label><br>
                        <input type="text" name="code" id="code" class="form-control" value="'.$code.'" required>
                    </div>
                    ';
                    }
                ?>
                <div class="form-group">
                    <input type="click" name="button" class="btn btn-info btn-md" value="Entrar" data-action=<?php echo $user_type ?>>
                </div>
            </form>
        </div>

    </div>


   
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src='js/scripts.js'></script>
</body>

</html>