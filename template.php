<?php
    if(!isset($_SESSION)){
        session_start();
    }
?>

<html>
    <head>
        <title>template</title>
        <link rel="stylesheet" href="src/css/template.css">
    </head>
    <body>

<section class="article">
<?php
    if(isset($_GET['id']) AND $_GET['id'] == $_SESSION['id']){
?>
        <a href="#openModal"><i class="fab fa-readme buttonsection"></i></a>
        <a href="#editModal"><i class="fas fa-pen buttonsection"></i></a>
        <i class="fas fa-trash buttonsection"></i>
<?php
    }else{
?>
        <a href="#openModal"><i class="fab fa-readme buttonsection"></i></a>
<?php
    }
?>

        <img src="src/img/téléchargement.jpg" alt="image event" class="imgevent">
            <h2 class="titre-h2">Bassleader reactivated world <div class="category">concert</div></h2>
                <h5 class="date"><?php echo date('H:i, D d/m/Y')?></h5>
</section >
<div id="openModal" class="modalDialog">
    <div>	<a href="#close" title="Close"><i class="fas fa-times buttonsection"></i></a>
    <img src="src/img/téléchargement.jpg" alt="image event" class="imgevent">
        <h2 class="titre-h2">Bassleader reactivated world <div class="category">concert</div></h2>
            <h5 class="date">date événement</h5>
                <p class="description"><strong>description:</strong>
                    Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p>
            <p class="author">auteur</p>
            <textarea class="title_input"placeholder="écrivez votre commentaire"></textarea>
            <p class="commentaire">commentaires</p>
    </div>
</div>
<div id="editModal" class="editmodalDialog">
    <div>	<a href="#close" title="Close"><i class="fas fa-times buttonsection"></i></a>
        <h2 class="Titre-h2 h2center" style="font-size:30px;">Modifier l'événément</h2>
            <h2 class="Titre-h2">Modifier le titre</h2>
                <input type="text" class="title_input"placeholder="Titre"></input>
            <h2 class="Titre-h2">Modifier la description</h2>
                <input type="text" class="descr_input"placeholder="insérez votre description ici"></input>
            <h2 class="Titre-h2">Modifier l'affiche</h2>
                <input type="file" class="title_input"></input>
            <h2 class="Titre-h2">Modifier la catégorie</h2>
                <input type="text" class="title_input"placeholder="catégorie"></input>
                
                <input type=submit class="title_input"></input>
    </div>
</div>
<script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>