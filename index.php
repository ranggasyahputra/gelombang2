<?php

// use function PHPSTORM_META\type;

session_start();

if (isset($_SESSION["status"]) && $_SESSION["status"] === "login") {
    $role = $_SESSION["role"];
    if(isset($role) && $role == "admin"){
        header("location:dashboard/index-admin.php?message=selamat datang kembali");
    } else {
        header("location:dashboard/index-employee.php?message=selamat datang kembali");
        
    }
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://kit.fontawesome.com/2ce69c7166.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Page Absensi</title>
</head>

<body>
    <div class="container">
        <div class="cover">
            <div class="cover-item"></div>
        </div>
        <div class="container-login">
            <div class="wrapper">
                <form action="login.php" method="POST" class="login-form">
                    <h3 class="login-title">
                        Login
                    </h3>
                    <i class="login-status">
                        <?php
                        if (isset($_GET["message"])) {
                            echo $_GET["message"];
                        }
                        ?>
                    </i>
                    <p>NIP</p>
                    <input name="user_id" type="number" class="login-input" required >
                    <p>PASSWORD</p>
                    <input name="password" type="password" class="login-input" required>

                    <button type="submit" name="login" class="button-input">MASUK</button>
                </form>
            </div>
        </div>
        <div class="cover">
            <div class="cover-item1"></div>
        </div>
    </div>
</body>

</html>