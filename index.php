<?php
    //INICIAMOS LA SESSION
    session_start();

    include("db.php");
    //PARA OBTENER LA SESSION,
    //COMPROBAMOS LA ID QUE ME ESTA ALMACENANDO LA SESSION ESTA DENTRO DE LA DB
    if(isset($_SESSION['user_id'])) {
        $records = $conn-> prepare('SELECT id, email, password FROM users WHERE id = :id');
        //REEMPLAZAMOS EL DATO
        $records->bindParam(':id', $_SESSION['user_id']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        $user = null;
        //COMPROBAMOS QUE NO ESTA VACIO Y LUEGO LO ALMACENAMOS EN LA VARIABLE USER
        if(count($results) > 0){
            $user = $results;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome to your Application</title>
        <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>

        <?php include("partials/header.php")?>

        <?php if(!empty($user)): ?>
            <br>Welcome. <?= $user['email'] ?>
            <br>Youy are Successfully Logged In
            <a href="logout.php">Logout</a>
        <?php else: ?>

            <h1>Please Login or SignUp</h1>

            <a href="login.php">Login</a> or
            <a href="signup.php">SignUp</a>
        <?php endif; ?>
    </body>
</html>
