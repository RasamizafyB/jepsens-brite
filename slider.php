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
    $reqevent = $bdd->prepare("SELECT * FROM evenement WHERE date >= ? ORDER BY date, time LIMIT 3");
    $reqevent->execute(array($date));

?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial scale=1.0">
        <title>slider</title>

        <link rel="shortcut icon" href="https://img.icons8.com/color/48/000000/naruto.png" type="image/x-icon">
        <link rel="stylesheet" href="src/css/slider.css">
    </head>
    <body>
        
        <div class="container">
            <div class="slider">
                <?php
            while($event = $reqevent->fetch()){
        // var_dump($event);
        ?>
                <div class="slide slide1" style= "background-image:url('event/image/<?=$event['image'];?>');background-size: cover;background-position:center;">
                    <div class="caption">
                    <a href="show_event.php?id=<?= $event['0']?>"><?= $event['titre'] ?></a>

                    </div>
                </div>
                <?php
            };
            ?>
                
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>