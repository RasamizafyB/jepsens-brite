<?php
    if(!isset($_SESSION)){
        session_start();
    }
    include 'config/config.php';

    try {
		$bdd = new PDO($dbdsn, $dbusername, $dbpassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
    }
    
    $reqevent = $bdd->query("SELECT * FROM evenement ORDER BY date, time LIMIT 5");
    while($event = $reqevent->fetch()){
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
            <a href="single_event?event=<?= $event['id']?>"><i class="fab fa-readme buttonsection"></i></a>
            <a href="single_event?event=<?= $event['id']?>"><i class="fas fa-pen buttonsection"></i></a>
            <i class="fas fa-trash buttonsection"></i>
    <?php
        }else{
    ?>
            <a href="single_event?event=<?= $event['id']?>"><i class="fab fa-readme buttonsection"></i></a>
    <?php
        }
    ?>
        <img src="event/image/<?= $event['image']; ?>" alt="image event" class="imgevent">
        <h2 class="titre-h2"><?= $event['titre']; ?> <div class="category"><?= $event['categorie_id'] ?></div></h2>
        <h5 class="date"><?= $event['date']; ?>, <?= $event['time'];?></h5>
    </section >
   
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
<?php
    }
?>