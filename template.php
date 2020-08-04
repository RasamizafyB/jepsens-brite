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
    $date = date("Y-m-d");
    $reqevent = $bdd->prepare("SELECT evenement.*, categorie.title, utilisateur.pseudo, utilisateur.id FROM evenement 
                                LEFT JOIN utilisateur ON auteur = utilisateur.id
                                LEFT JOIN categorie ON categorie_id = categorie.id  
                                WHERE date >= ? ORDER BY date, time LIMIT 5");
    $reqevent->execute(array($date));
    while($event = $reqevent->fetch()){
?>
<html>
    <head>
        <title>template</title>
        <link rel="stylesheet" href="src/css/template.css">
    </head>
    <body>
    <section class="article">
        <a href="show_event.php?id=<?= $event['0']?>"><i class="fab fa-readme buttonsection"></i></a>
        <img src="event/image/<?= $event['image']; ?>" alt="image event" class="imgevent">
        <h2 class="titre-h2"><?= $event['titre']; ?> <div class="category"><?= $event['title'] ?></div></h2>
        <p>Auteur : <a class="h4" href="<?php echo "user.php?id=".$event['id'];?>"><?= $event['pseudo']; ?></a></p>
        <h5 class="date">Date : <?= $event['date']; ?>, <?= $event['time'];?></h5>
        <p>Adresse : <?= $event['adresse']; ?>, <?= $event['cp'];?> <?= $event['ville'];?></p>
    </section >
    <script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>
<?php
    }
?>