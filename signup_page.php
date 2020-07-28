<?php
    session_start();

    include 'config/config.php';

	try {
		$bdd = new PDO($dbdsn, $dbusername, $dbpassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}
	if(isset($_POST['formLog'])){
        $pseudolog = htmlspecialchars($_POST['usernameLog']);
		$passwordlog = sha1($_POST['passwordLog']);
		if(!empty($pseudolog) AND !empty($passwordlog)){
			$requser = $bdd->prepare('SELECT * FROM utilisateur WHERE pseudo = ? AND password = ?');
			$requser->execute(array($pseudolog, $passwordlog));
			$userexist = $requser->rowCount();
			if($userexist == 1){
				$userinfo = $requser->fetch();
				$_SESSION['id'] = $userinfo['id'];
				$_SESSION['pseudo'] = $userinfo['pseudo'];
				$_SESSION['email'] = $userinfo['email'];
				$_SESSION['password'] = $userinfo['password'];
				header("Location: index.php?id=".$_SESSION['id']);
			}else{
				$error = "Incorrect USERNAME or PASSWORD";
			}
		}else{
			$error = "Complet the form please!";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>

    <link rel="stylesheet" href="src/css/style.css">
</head>
<body>
    <?php include("layout/header.inc.php");?>
    <form action='' method='POST'>
    	<h2 class="Titre-h2 h2center">connexion</h2>
    	<input type="text" class="title_input" placeholder="Nickname" name='usernameLog'>
    	<input type="password" class="title_input" placeholder="Password" name='passwordLog'>
    	<input type=submit class="title_input" placeholder="confirm" name='formLog'>
    </form>
	<?php
        if(isset($error)){
    ?>
        <div class="error">
            <p><i class="fas fa-times"></i> <?php echo $error ?> <i class="fas fa-times"></i></p>
        </div>
    <?php
        }
    ?>
    <script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>
