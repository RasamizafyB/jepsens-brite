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
            <a href="./user.php?id=<?php echo $_SESSION['id']; ?>"><img src="./user/avatar/<?php echo $userinfo['avatar']; ?>" alt="avatar" width='45' style="border-radius:22.5px; margin-left: 10px; display: flex; align-self: center;"></a>
        </div>
        <div class='bouton'>
            <a href="./index.php?id=<?php echo $_SESSION['id']; ?>" class="logoimg"><img src="./src/img/jepsen_brite.png" alt="logo jepsen-brite"></a>
            <button class="buttonsearch"><i class="fas fa-search"></i></button>
            <a href="./logout.php" class='buttonsignup'>Log out</a>
        </div>
    </header>
</body>
</html>