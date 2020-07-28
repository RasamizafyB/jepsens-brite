<?php
    session_start();
    
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
                            if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']){
                        ?>
                            <a href="edit_profile.php?id=<?php echo $_SESSION['id']; ?>"><i class="fas fa-pen buttonsection"></i></a>
                            <button class='deletebutton' onclick="ConfirmDelete()"><i class="fas fa-trash buttonsection"></i></button>
                        <?php
                            }
                        ?> 
                    </div>
                        <img src="user/avatar/<?php echo $userinfo['avatar']; ?>" alt="image user" class="imguser" width='150'>
                        <h2 class="Titre-h2"><?php echo $userinfo['pseudo']; ?></h2>
                        <h5 class="email"><?php echo $userinfo['mail']; ?></h5>
                </section>
            </div>
        </main>
        <script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>
<?php
    }else{
        header("Location: index.php");
    }
?>