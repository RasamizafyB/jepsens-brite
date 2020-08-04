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
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header after connection</title>

    <link rel="stylesheet" href="./src/css/style.css">
</head>
<body>
    <header>
        <div class='avatar'>
            <?php if(isset($_SESSION['id'])){ ?>
            <a href="./user.php?id=<?php echo $_SESSION['id']; ?>"><img src="./user/avatar/<?php echo $userinfoHeader['avatar']; ?>" alt="avatar" width='45' style="border-radius:22.5px; margin-left: 10px; display: flex; align-self: center;"></a>
            <?php } ?>
        </div>
        <div class='bouton'>
            <a href="./index.php" class="logoimg"><img src="./src/img/jepsen_brite.png" alt="logo jepsen-brite"></a>
            <?php if(isset($_SESSION['id'])){ ?>
                <a href="./logout.php" class='buttonsignup'>Log out</a>
            <?php }else{ ?>
                <a href="./signin_page.php" class='buttonsignin'>Sign in</a>
                <a href="./signup_page.php" class='buttonsignup'>Sign up</a>
            <?php } ?>
        </div>
    </header>
</body>
</html>