<?php
    session_start();

    include 'config/config.php';

    try {
		$bdd = new PDO($dbdsn, $dbusername, $dbpassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
    }

    if(isset($_SESSION) AND $_SESSION['admin'] == 1){
        $requserAdminEvent = $bdd->query("SELECT * FROM evenement ORDER BY id DESC");
        $requserAdminUser = $bdd->query("SELECT * FROM utilisateur ORDER BY id DESC");

        if(isset($_GET['supprimerUser']) AND !empty($_GET['supprimerUser'])){
            $supprimerUser = (int) $_GET['supprimerUser'];
            $deleteUser = $bdd->prepare('DELETE FROM utilisateur WHERE id = ? LIMIT 1');
            $deleteUser->execute(array($supprimerUser));
            header('Location: admin.php');
        }
        if(isset($_GET['adminUser']) AND !empty($_GET['adminUser'])){
            $admin = (int) $_GET['adminUser'];
            $adminUser = $bdd->prepare('UPDATE `utilisateur` SET `admin`= 1 WHERE id = ? ');
            $adminUser->execute(array($admin));
            header('Location: admin.php');
        }
        if(isset($_GET['supprimerEvent']) AND !empty($_GET['supprimerEvent'])){
            $supprimerEvent = (int) $_GET['supprimerEvent'];
            $deleteEvent = $bdd->prepare('DELETE FROM evenement WHERE id = ? LIMIT 1');var_dump($user['admin']);
            $deleteEvent->execute(array($supprimerEvent));
            header('Location: admin.php');
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page administrateur</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous"> 
</head>
<body>
    <div class='admin'>
        <div class='user'>
            <h2>Utilisateurs du site</h2>
            <?php
                while($AdminUser = $requserAdminUser->fetch()){
            ?>
            <ul>
                <li>
                    <?php echo $AdminUser['pseudo']; 
                        if($AdminUser['admin'] != 1){
                    ?> 
                        <a href="admin.php?id=<?= $_SESSION['id'] ?>&supprimerUser=<?= $AdminUser['id'] ?>"><i class="fas fa-trash buttonsection"></i></a>
                        <a href="admin.php?id=<?= $_SESSION['id'] ?>&adminUser=<?= $AdminUser['id'] ?>"><i class="fas fa-user-cog"></i></a>
                        <?php } ?>
                </li>
            </ul>
            <?php } ?>
        </div>
        <div class='event'>
            <h2>Evénements du site</h2>
            <?php 
                while($AdminEvent = $requserAdminEvent->fetch()){
            ?>
             <ul>
                <li>
                    <?php echo $AdminEvent['titre'];?>
                    <a href="admin.php?id=<?= $_SESSION['id'] ?>&supprimerEvent=<?= $AdminEvent['id'] ?>"><i class="fas fa-trash buttonsection"></i></a>
                </li>
            </ul>
            <?php } ?>
        </div> 
        <a href="user.php?id=<?= $_SESSION['id'] ?>">Back</a>    
    </div>
</body>
</html>
<?php } ?>