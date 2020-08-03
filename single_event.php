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
    if(isset($_GET['event']) AND $_GET['event'] > 0){
        $getIdEvent = (int) $_GET['event'];
        $reqTemplateEvent = $bdd->prepare("SELECT * FROM evenement WHERE id = ?");
        $reqTemplateEvent->execute(array($getIdEvent));
        $templateEvent = $reqTemplateEvent->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Event</title>

    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>
</head>
<body>
    <?php 
        if(isset($_GET['id']) AND $_GET['id'] == $_SESSION['id']){
            include("layout/header.php");
        }else{
            include("layout/header.inc.php");
        }
    ?>
    <div class="card col-lg-4" style="width: 25%;">
      <img class="card-img-top" src="event/image/<?php echo $templateEvent['image'] ?>" alt="Card image cap">
      <div class="card-body">
        <h5 class="card-title"><?= $templateEvent['titre'] ?></h5>
        <p class="card-text"><?= $templateEvent['date'] ?>, <?= $templateEvent['time'] ?></p>
        <p class="card-text"><strong>description:</strong><br /><?= $templateEvent['description'] ?></p>
        <p class="card-text">Auteur: <br /> <?= $templateEvent['auteur'] ?> </p>
      </div>
    </div>
    <div class="modalDialog">
        <div>	
            <?php
                if(isset($_GET['id']) AND $_GET['id'] == $_SESSION['id']){
            ?>
                <div class='commentaireUser' style='display:inline;'>
                    <img src="user/avatar/<?php echo $userinfo['avatar']; ?>" alt="avatar" width='45' style="border-radius:22.5px; margin-left: 10px; display: flex; align-self: center;">
                    <h2> <?php echo $_SESSION['pseudo']; ?></h2>
                </div>
                <form action="" method='POST' class='formComment'>
                    <textarea class="title_input"placeholder="écrivez votre commentaire"></textarea>
                    <input type="button" class='buttonadd' value='commenter'>
                </form>
                <p class="commentaire">Affichage des commentaires</p>
            <?php
                }else{
            ?>
                    <p class="commentaire">Affichage des commentaires</p>
            <?php
                }
            ?>
        </div>
    </div>
</body>
</html>
<?php
    }
?>