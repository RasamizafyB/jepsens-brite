<?php
    session_start();

    include 'config/config.php';

    try {
		$bdd = new PDO($dbdsn, $dbusername, $dbpassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
    }
    if(isset($_SESSION['id'])){
        var_dump($_SESSION['id']);
        $requser = $bdd->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $requser->execute(array($_SESSION['id']));
        $useredit = $requser->fetch();
        
        if($_POST['formEdit']){
            if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $useredit['pseudo']){
                $newpseudo = htmlspecialchars($_POST['newpseudo']);
                $insertpseudo = $bdd->prepare("UPDATE utilisateur SET pseudo = ? WHERE id = ?");
                $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
                header('Location: user.php?id='.$_SESSION["id"]);
            }
            $oldPassword = sha1($_POST['password']);
            if($_SESSION['password'] == $oldPassword){
                if(isset($_POST['newpassword']) AND !empty($_POST['newpassword']) AND isset($_POST['confirmnewpassword']) AND !empty($_POST['confirmnewpassword'])){
                    $newpassword = sha1($_POST['newpassword']);
                    $confirmnewpassword = sha1($_POST['confirmnewpassword']);
                    if($newpassword == $confirmnewpassword){
                        $insertpassword = $bdd->prepare("UPDATE utilisateur SET password = ? WHERE id = ?");
                        $insertpassword->execute(array($newpassword, $_SESSION['id']));
                        header('Location: user.php?id='.$_SESSION["id"]);
                    }else{
                        $error = "Your PASSWORD doesn't match!";
                    }
                }
            }else{
                $error = 'Old password deasn\'t correct';
            }
            if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])){
                $tailleMax = 2097152;
                $extensoinValide = array('jpg', 'jpeg', 'png', 'gif');
                if($_FILES['avatar']['size'] <= $tailleMax){
                    $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
                    if(in_array($extensionUpload, $extensoinValide)){
                        $chemin = "user/avatar/".$_SESSION['id'].".".$extensionUpload;
                        $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                        if($resultat){
                            $updateAvatar = $bdd->prepare('UPDATE utilisateur SET avatar = :avatar WHERE id = :id');
                            $updateAvatar->execute(array(
                                'avatar' => $_SESSION['id'].".".$extensionUpload,
                                'id' => $_SESSION['id']
                            ));
                            header('Location: user.php?id='. $_SESSION['id']);
                        }else{
                            $error = 'Error during import file';
                        }
                    }else{
                        $error = 'The image format must be in JPG, JPEG, PNG or GIF';
                    }
                }else{
                    $error = 'Your AVATAR is so big';
                } 
            }
        }
?>

<html>
<head>
    <title>edit profile</title>
    <link rel="stylesheet" href="src/css/style.css">
</head>
<body>
    <?php include("layout/header.php");?>
    <main>
        <div class="feedback">
            <section class="article">
                <form action="" method='POST' enctype='multipart/form-data'>
                    <h2 class="titre-h2 h2center" style="text-align: center">Edit profile</h2>
                    <h5 class="email"><?php echo $useredit['mail']; ?></h5>
                    <h5 class="email">New username</h5>
                    <input type="text" class="title_input"placeholder="<?php echo $useredit['pseudo']; ?>" name='newpseudo'></input>
                    <h5 class="email">New password?</h5>
                    <input type="password" class="title_input"placeholder="ancient password?" name='password'></input>
                    <input type="password" class="title_input"placeholder="New password." name='newpassword'></input>
                    <input type="password" class="title_input"placeholder="Confirm new password." name='confirmnewpassword'></input>
                    <h5 class="email">New avatar?</h5>
                    <input type="file" class="title_input" placeholder="nouvel avatar?" name='avatar'></input>
                    <input type=submit class="title_input" placeholder="confirm" name='formEdit'>
                </form>
            </section >
            <?php
                if(isset($error)){
            ?>
                <div class="error">
                    <p><i class="fas fa-times"></i> <?php echo $error ?> <i class="fas fa-times"></i></p>
                </div>
            <?php
                }
            ?>
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