<?php
    session_start();
?>

<html>
<head>
<title>homepage</title>
<link rel="stylesheet" href="src/css/style.css">
</head>
<body>
    <?php 
        if(isset($_GET['id']) AND $_GET['id'] == $_SESSION['id']){
            include("layout/header.php");
        }else{
            include("layout/header.inc.php");
        }
    ?>
<main>
    <p class="about">Jepsen-Brite is a displaying event website, where each person has an equality in action. all people can create or browse event.</p>
</main>
<script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>