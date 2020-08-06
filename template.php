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
    $time = date("H:i");
    $reqevent = $bdd->prepare("SELECT evenement.*, categorie.title, utilisateur.pseudo, utilisateur.id FROM evenement 
                                LEFT JOIN utilisateur ON auteur = utilisateur.id
                                LEFT JOIN categorie ON categorie_id = categorie.id  
                                WHERE date >= ? ORDER BY date, time LIMIT 4, 5;");
    $reqevent->execute(array($date));
    while($event = $reqevent->fetch()){
        // var_dump($event);
?>
<html>
    <head>
        <title>template</title>
        <link rel="stylesheet" href="src/css/template.css">
    </head>
    <body>
    <section class="article">
        <a href="show_event.php?id=<?= $event['0']?>"><i class="fab fa-readme buttonsection"></i></a>
        <?php if(isset($event['image']) AND empty($event['11'])){ ?>
            <img src="event/image/<?= $event['image']; ?>" alt="image event" class="imgevent">
        <?php }elseif(isset($event['11']) AND empty($event['image'])){ ?>
            <iframe class="imgevent" src="https://www.youtube.com/embed/<?= $event["11"]; ?>" frameborder="0" 
                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <?php } ?>  
        <h2 class="titre-h2"><?= $event['titre']; ?> <div class="category"><?= $event['title'] ?></div></h2>
        <p class="author">Auteur : <a href="<?php echo "user.php?id=".$event['id'];?>" class="buttonsection" style="text-decoration:none"><?= $event['pseudo']; ?></a></p>
        <h5 class="date">Date : <?= $event['date']; ?>, <?= $event['time'];?></h5>
        <p class="date">Adresse : <?= $event['adresse']; ?>, <?= $event['cp'];?> <?= $event['ville'];?></p>
    </section >
    <script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>
<?php
    }
?>