<?php
session_start();
include 'admin/src/php/utils/liste_includes.php';
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./lib/css/style.css"/>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="./lib/js/fonction_jquery.js"></script>
    <title>Cinema</title>
</head>
<body>
<header id="header">

</header>
<nav>
    <?php
    if(file_exists('./lib/php/menu.php')){
        include('./lib/php/menu.php');
    }
    ?>
    <a href="index_.php?page=login.php">Connexion</a>
</nav>

<section id="mains">

    <?php
    if(!isset($_SESSION['page'])){
        $_SESSION['page']="accueil.php";
    }
    if(isset($_GET['page'])){
        $_SESSION['page'] = $_GET['page'];
    }
    $path='./pages/'.$_SESSION['page'];
    if(file_exists($path)){
        include ($path);
    }else{
        include ('./pages/page404.php');
    }
    ?>
</section>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

</body>
</html>