<html>
    <head>
        <title>homepage</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php include("layout/header.inc.php");?>
        <main>
            <div class="feedback">
                <?php date_default_timezone_set('Europe/Paris')?>
                <div class="range">
                    <button class="buttonadd" onclick=window.location.href='http://localhost/jepsen_brite/jepsen-brite/vue/event.php?'>events</button>
                    <button class="buttonadd" onclick=window.location.href='http://localhost/jepsen_brite/jepsen-brite/vue/past_event.php?'>past events</button>
                    <button class="buttonadd" onclick=window.location.href='http://localhost/jepsen_brite/jepsen-brite/vue/create_event.php?'>+ add event</button>
                </div>
<section class="article">
<div class="range1">
<i class="fab fa-readme buttonsection"></i>
<i class="fas fa-pen buttonsection"></i>
<i class="fas fa-trash buttonsection"></i>
</div>
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