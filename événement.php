<?php 
  if(!isset($_SESSION)){
    session_start();
}

    include 'config/config.php';
    include 'user.php';

	try {
		$bdd = new PDO($dbdsn, $dbusername, $dbpassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
    }
    if(isset($_GET['id']) AND $_GET['id'] == $_SESSION['id'] AND $_SESSION['id'] == 1){
        $getidAdmin = intval($_GET['id']);
        $requserAdmin = $bdd->query("SELECT * FROM evenement ORDER BY id DESC");
        if(isset($_GET['supprimer']) AND !empty($_GET['supprimer'])){
            $supprimer = (int) $_GET['supprimer'];
            $deleteUser = $bdd->prepare('DELETE FROM evenement WHERE id = ? LIMIT 1');
            $deleteUser->execute(array($supprimer));
            header("Location: événement.php?id=" .$_SESSION['id']);
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evenement</title>
</head>
<body>
    <div class='membre'>
        <ul>
            <?php
                while($Admin = $requserAdmin->fetch()){
            ?>
                <li>
                    <?php echo $Admin['titre'];?><a href="événement.php?supprimer=<?= $Admin['id'] ?>"><i class="fas fa-trash buttonsection"></i></a>
                </li>
            <?php   
                }
            ?>
        </ul>
    </div> 
    <a href="user.php?id=<?= $_SESSION['id']; ?>">Back</a>
</body>
</html>
<?php 
    }
?>