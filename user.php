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
    if(isset($_GET['id']) AND $_GET['id'] > 0){
        $getid = intval($_GET['id']);
        $requser = $bdd->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $requser->execute(array($getid));
        $userinfo = $requser->fetch();
        if(isset($_GET['supprimerUser']) AND !empty($_GET['supprimerUser'])){
            $supprimerUser = (int) $_GET['supprimerUser'];
            $deleteUser = $bdd->prepare('DELETE FROM utilisateur WHERE id = ? LIMIT 1');
            $deleteUser->execute(array($supprimerUser));
            header('Location: user.php?id=' .$_SESSION['id']);
        }
        if(isset($_GET['supprimerEvent']) AND !empty($_GET['supprimerEvent'])){
            $supprimerEvent = (int) $_GET['supprimerEvent'];
            $deleteEvent = $bdd->prepare('DELETE FROM evenement WHERE id = ? LIMIT 1');
            $deleteEvent->execute(array($supprimerEvent));
            header('Location: user.php?id=' .$_SESSION['id']);
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil user</title>

    <link rel="stylesheet" href="src/css/style.css">

    <script type="text/javascript">
        function ConfirmDelete()
        {
            if (confirm("Delete Account?")){
                location.href="<?php echo "delete_profile.php?id=".$_SESSION['id']; ?>";
            }     
        }
    </script>
</head>
<body>
    <?php include("layout/header.php");?>
        <main>
            <div class="feedback">
                <?php date_default_timezone_set('Europe/Paris'); ?>
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
                <section class="article">
                    <div class="range1">
                        <?php
                            if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'] AND $_SESSION['id'] == 1){
                        ?>
                            <a href="edit_profile.php?id=<?php echo $_SESSION['id']; ?>"><i class="fas fa-pen buttonsection"></i></a>
                        <?php
                            }elseif(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']){
                        ?>
                            <a href="edit_profile.php?id=<?php echo $_SESSION['id']; ?>"><i class="fas fa-pen buttonsection"></i></a>
                            <button class='deletebutton' onclick="ConfirmDelete()"><i class="fas fa-trash buttonsection"></i></button>
                        <?php        
                            }
                        ?> 
                    </div>
                        <img src="user/avatar/<?php echo $userinfo['avatar']; ?>" alt="image user" class="imguser" width='150'>
                        <h2 class="titre-h2"><?php echo $userinfo['pseudo']; ?></h2>
                        <h5 class="email"><?php echo $userinfo['mail']; ?></h5>
                        <?php if($_SESSION['id'] == $_GET['id'] AND $_SESSION['id'] == 1){?>
                            <p>Administrateur</p>
                        <?php }else{ ?>
                            <p>Utilisateur</p>
                        <?php } ?>   
                </section>
            </div>
            <?php
                if(isset($_GET['id']) AND $_GET['id'] == $_SESSION['id'] AND $_SESSION['id'] == 1){
                    $getidAdmin = intval($_GET['id']);
            ?>
            <div class='admin'>
                <div class='user'>
                    <h2>Utilisateurs du site</h2>
                    <?php
                        $requserAdmin = $bdd->query("SELECT * FROM utilisateur ORDER BY id DESC");
                        while($Admin = $requserAdmin->fetch()){
                    ?>
                    <ul>
                        <li>
                            <?php echo $Admin['pseudo']; 
                                if($Admin['id'] != 1){
                            ?> 
                                <a href="user.php?id=<?= $_SESSION['id'] ?>&supprimerUser=<?= $Admin['id'] ?>"><i class="fas fa-trash buttonsection"></i></a>
                                <?php } ?>
                        </li>
                    </ul>
                    <?php } ?>
                </div>
                <div class='event'>
                    <h2>Evénements du site</h2>
                    <?php 
                        $requserAdmin = $bdd->query("SELECT * FROM evenement ORDER BY id DESC");
                        while($Admin = $requserAdmin->fetch()){
                    ?>
                     <ul>
                        <li>
                            <?php echo $Admin['titre'];?>
                            <a href="user.php?id=<?= $_SESSION['id'] ?>&supprimerEvent=<?= $Admin['id'] ?>"><i class="fas fa-trash buttonsection"></i></a>
                        </li>
                    </ul>
                    <?php } ?>
                </div>     
            </div>
            <?php } ?>
        </main>
        <script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>
<?php
    }else{
        header("Location: index.php");
    }
?>