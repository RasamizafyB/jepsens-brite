<?php
    session_start();

    include 'config/config.php';

    try {
		$bdd = new PDO($dbdsn, $dbusername, $dbpassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
    }
    if(isset($_SESSION['id'])){
        $getidHeader = intval($_SESSION['id']);
        $requserHeader = $bdd->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $requserHeader->execute(array($getidHeader));
        $userinfoHeader = $requserHeader->fetch();
        $_SESSION['admin'] = $userinfoHeader['admin'];
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
        if(isset($_GET['desadminUser']) AND !empty($_GET['desadminUser'])){
            $desadmin = (int) $_GET['desadminUser'];
            $desadminUser = $bdd->prepare('UPDATE `utilisateur` SET `admin`= 0 WHERE id = ? ');
            $desadminUser->execute(array($desadmin));
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
        <link rel="stylesheet" href="src/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous"> 
</head>
<body>
<?php include("layout/header.php"); ?>
    <main>
        <section class="article">
    <div class='admin'>
        <div class='user'>
            <table>
            <th ><h2 class="titre-h2 h2center">Utilisateurs du site</h2></th>
            <?php
                while($AdminUser = $requserAdminUser->fetch()){
            ?>
                <tr>
                <td class="author">
                    <?php echo $AdminUser['pseudo']; 
                        if($AdminUser['admin'] != 1){
                    ?> </td>
                        <td><a href="admin.php?id=<?= $_SESSION['id'] ?>&adminUser=<?= $AdminUser['id'] ?>"><i class="fas fa-user-cog buttonsection"></i></a></td>
                        <td><a href="admin.php?id=<?= $_SESSION['id'] ?>&supprimerUser=<?= $AdminUser['id'] ?>"><i class="fas fa-trash buttonsection" style="color:red;"></i></a></td>
                        <?php }else{ ?>
                        <td><a href="admin.php?id=<?= $_SESSION['id'] ?>&desadminUser=<?= $AdminUser['id'] ?>"><i class="fas fa-user-check" style="color:green;"></i></a></td>
                        <?php } ?>
                        </tr>
                        <?php } ?>
                    </table>
                    </div>
        </section>
        <section class="article">
        <div class='event'>
            <table>
            <th><h2 class="titre-h2 h2center">Evénements du site</h2></th>
            <?php 
                while($AdminEvent = $requserAdminEvent->fetch()){
            ?>
             <tr>
                <td class="author">
                    <?php echo $AdminEvent['titre'];?>
                    <a href="admin.php?id=<?= $_SESSION['id'] ?>&supprimerEvent=<?= $AdminEvent['id'] ?>"></td><td><i class="fas fa-trash buttonsection" style="color:red;"></i></a>
                </td>
                </tr>
            <?php } ?>
                </table>
        </section>
        </div> 
        <a href="user.php?id=<?= $_SESSION['id'] ?>" style="margin-left:20px"><i class="fas fa-arrow-left buttonsection"></i></a>    
    </div>
    </main>
    <?php include('layout/footer.inc.php')?>
</body>
</html>
<?php }else{
  header('Location: user.php?id='. $_SESSION['id']); 
}?>