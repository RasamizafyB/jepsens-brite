<?php
    session_start();
    include 'config/config.php';

    try {
        $bdd = new PDO($dbdsn, $dbusername, $dbpassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
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
        <?php
            $date = date('Y-m-d');
            $reqpastevent = $bdd->prepare("SELECT evenement.*, categorie.title, utilisateur.pseudo, utilisateur.id FROM evenement 
                                            LEFT JOIN utilisateur ON auteur = utilisateur.id
                                            LEFT JOIN categorie ON categorie_id = categorie.id
                                            WHERE date < ? ORDER BY date, time");
            $reqpastevent->execute(array($date));
            while($pastevent = $reqpastevent->fetch()){
        ?>
        <section class="article">
            <a href="show_event.php?id=<?= $pastevent['0']?>"><i class="fab fa-readme buttonsection"></i></a>
            <img src="event/image/<?= $pastevent['image']; ?>" alt="image event" class="imgevent">
            <h2 class="titre-h2"><?= $pastevent['titre']; ?> <div class="category"><?= $pastevent['title'] ?></div></h2>
            <p>Auteur : <a class="h4" href="<?php echo "user.php?id=".$pastevent['id'];?>"><?= $pastevent['pseudo']; ?></a></p>
            <h5 class="date"><?= $pastevent['date']; ?>, <?= $pastevent['time'];?></h5>
            <p><?= $pastevent['adresse']; ?>, <?= $pastevent['cp'];?> <?= $pastevent['ville'];?></p>
        </section >
        <?php       
            }
        ?>
    </div>
</main>
<?php include("layout/footer.inc.php");?>

<script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>