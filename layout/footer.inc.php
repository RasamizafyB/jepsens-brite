<?php
   if(!isset($_SESSION)){
    session_start();
}
?>

<html>
<head>
<link rel="stylesheet" href="src/css/style.css">
</head>
<body>
<footer>
<i class="fab fa-github fa-2x buttonsection" onclick=window.location.href='https://github.com/biomath-421/jepsen-brite/tree/master'></i>
<a href='../about.php?id=<?php echo $_SESSION['id']; ?>' class="buttonsection">about</a>
<p > made by Saïd El Mohor, Mathieu Bourlard, Bryan Rasamizafy</p>
</footer>
<script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>

