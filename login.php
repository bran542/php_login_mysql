<?php
    session_start();
    //SI EXISTE UN USER, REDIRECCIONAMOS PARA QUE NO VUELVA A SALIR EL FORMULARIO LOGIN
    if (isset($_SESSION['user_id'])){
        header('Location: /php_login_mysql');
    }

    include("db.php");

    if(!empty($_POST['email']) && !empty($_POST['password'])) {
        $records = $conn->prepare('SELECT id, email, password FROM users WHERE email=:email');
        //REEMPLAZAR POR EL DATO QUE NOS MANDA EL NAVEGADOR (MEDIANTE POST)
        $records->bindParam(':email', $_POST['email']);
        //EJECUTAMOS LA CONSULTA
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        $message = '';

        //SI EL RESULTADO QUE OBTENEMOS NO ESTA VACIO
        //COMPARAMOS LA PASSWORD QUE OBTENEMOS DEL FORMULARIO POST CON LA DE NUESTRA DB
        //SI ESTAS COINCIDEN ENTONCES ES CORRECTO EL USER QUE ESTA ENTRANDO AL SISTEMA
        if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
            //ASIGNAMOS EN MEMORIA UNA SESSION
            $_SESSION['user_id'] = $results['id'];
            header('Location: /php_login_mysql');
        } else {
            $message = 'Sorry, Those credentials do not match';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <?php include("partials/header.php")?>
        <h1>Login</h1>
        <span>or <a href="signup.php">SignUp</a></span>

        <?php if(!empty($message)): ?>
            <p><?php $message ?></p>
        <?php endif;?>
        
        <form action="login.php" method="POST">
            <input type="text" name="email" placeholder="Enter your mail">
            <input type="password" name="password" placeholder="Enter your password">
            <input type="submit" value="Send">
        </form>

    </body>
</html>