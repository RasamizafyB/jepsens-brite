<?php
if(!isset($_SESSION)){
    session_start();
}
?>

<html>
<head>
<title>past events</title>
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
<main class="grid">
<table  class="categoryzone">
    <tr><th>Catégories</th></tr>
    <tr>
        <td class="inputcheck">
            <div>
                <input type="checkbox" id="all" name="all">
                <label for="concert">
                    All
                </label>
            </div>
        </td>
    </tr>
    <tr>
        <td class="inputcheck">
            <div>
                <input type="checkbox" id="concert" name="concert">
                <label for="concert">
                    concert
                </label>
            </div>
        </td>
    </tr>
    <tr>
        <td class="inputcheck">
            <div>
                <input type="checkbox" id="culture" name="culture">
                <label for="culture">
                    culture
                </label>
            </div>
        </td>
    </tr>
    <tr>    <td class="inputcheck"><div><input type="checkbox" id="manifestation" name="manifestation"><label for="manifestation">manifestation</label></div></td>
    </tr>
    <tr><td class="inputcheck"><div><input type="checkbox" id="musee" name="musee"><label for="musee">musée</label></div></td></tr>
    </table>
    <div class="feedback">
<?php date_default_timezone_set('Europe/Paris')?>
    <div class="range">
    <?php 
            if(isset($_GET['id']) AND $_GET['id'] == $_SESSION['id']){
        ?>
                <a href="event.php?id=<?php echo $_SESSION['id']; ?>" class="buttonadd">events</a>
                <a href="past_event.php?id=<?php echo $_SESSION['id']; ?>" class="buttonadd">past events</a>
                <a href="create_event.php?id=<?php echo $_SESSION['id']; ?>" class="buttonadd">+ add even</a>
        <?php
            }else{
        ?>
                <a href="event.php" class="buttonadd">events</a>
                <a href="past_event.php" class="buttonadd">past events</a>
        <?php
            }
        ?>
</div>
<section class="article">
    
    <i class="fab fa-readme"></i>
    <i class="fas fa-pen"></i>
    <i class="fas fa-trash"></i>
    
    <img src="src/img/téléchargement.jpg" alt="image event" class="imgevent">
    <h2 class="Titre-h2">Bassleader reactivated world <div class="category">concert</div></h2>
    <h5 class="date"><?php echo date('H:i, D d/m/Y')?></h5>
    <p class="description"><strong>description:</strong> Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p>
    <p class="author">auteur</p>
</section >
<section class="article">
    
    <i class="fab fa-readme"></i>
    <i class="fas fa-pen"></i>
    <i class="fas fa-trash"></i>
    
    <img src="src/img/2016-Daydream-Festival.jpg" alt="image event" class="imgevent">
    <h2 class="Titre-h2">Daydream festival<div class="category">concert</div></h2>
    <h5 class="date"><?php echo date('H:i, D d/m/Y')?></h5>
    <p class="description"><strong>description:</strong> Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p>
    <p class="author">auteur</p>
</section >
<section class="article">
    
    <i class="fab fa-readme"></i>
    <i class="fas fa-pen"></i>
    <i class="fas fa-trash"></i>
    
    <img src="src/img/dominator.jpg" alt="image event" class="imgevent">
    <h2 class="Titre-h2">Dominator 2020<div class="category">concert</div></h2>
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