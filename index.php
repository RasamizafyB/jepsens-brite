<?php
if(!isset($_SESSION)){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="src/css/style.css">
</head>
<body>
<body>
    <?php 
        if(isset($_GET['id']) AND $_GET['id'] == $_SESSION['id']){
            include("layout/header.php");
        }else{
            include("layout/header.inc.php");
        }
    ?>
    <main>
        <div class="feedback">
        <?php date_default_timezone_set('Europe/Paris')?>
        <div class="range">
        
        <?php 
            if(isset($_GET['id']) AND $_GET['id'] == $_SESSION['id']){
                ?>
                <a href="event.php?id=<?php echo $_SESSION['id']; ?>" class="buttonadd">events</a>
                <a href="past_event.php?id=<?php echo $_SESSION['id']; ?>" class="buttonadd">past events</a>
                <a href="create_event.php?id=<?php echo $_SESSION['id']; ?>" class="buttonadd">+ add event</a>
        <?php
            }else{
                ?>
                <a href="event.php" class="buttonadd">events</a>
                <a href="past_event.php" class="buttonadd">past events</a>
        <?php
            }
            ?>
        </div>
            <div id="slider">
                <?php include("slider.php"); ?>
            </div>
        <section class="article">

        <i class="fab fa-readme buttonsection"></i>
        <i class="fas fa-pen buttonsection"></i>
        <i class="fas fa-trash buttonsection"></i>

        <img src="src/img/téléchargement.jpg" alt="image event" class="imgevent">
        <h2 class="titre-h2">Bassleader reactivated world <div class="category">concert</div></h2>
        <h5 class="date"><?php echo date('H:i, D d/m/Y')?></h5>
        <p class="description"><strong>description:</strong>
         Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p>
        <p class="author">auteur</p>
        </section >
        <section class="article">

        <i class="fab fa-readme buttonsection"></i>
        <i class="fas fa-pen buttonsection"></i>
        <i class="fas fa-trash buttonsection"></i>

        <img src="src/img/2016-Daydream-Festival.jpg" alt="image event" class="imgevent">
        <h2 class="titre-h2">Daydream festival<div class="category">concert</div></h2>
        <h5 class="date"><?php echo date('H:i, D d/m/Y')?></h5>
        <p class="description"><strong>description:</strong> Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p>
        <p class="author">auteur</p>
        </section >
        <section class="article">

        <i class="fab fa-readme buttonsection"></i>
        <i class="fas fa-pen buttonsection"></i>
        <i class="fas fa-trash buttonsection"></i>

        <img src="src/img/dominator.jpg" alt="image event" class="imgevent">
        <h2 class="titre-h2">Dominator 2020<div class="category">concert</div></h2>
        <h5 class="date"><?php echo date('H:i, D d/m/Y')?></h5>
        <p class="description"><strong>description:</strong> Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p>
        <p class="author">auteur</p>
        </section >
        </div>
    </main>
    <?php include("layout/footer.inc.php");?>
    <script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>
