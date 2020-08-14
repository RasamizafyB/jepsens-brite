<?php
    
    include 'config/config.php';    
    
    try {
		$bdd = new PDO($dbdsn, $dbusername, $dbpassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
    }

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/phpmailer/phpmailer/src/Exception.php';
    require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'vendor/phpmailer/phpmailer/src/SMTP.php';

    if(isset($_POST['formInscription'])){
        if(!empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['confirmpassword'])){
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $email = htmlspecialchars($_POST['email']);
            $password = sha1($_POST['password']);
            $confirm_password = sha1($_POST['confirmpassword']);
            $defaultAvatar = "default.jpeg";

            $pseudolength = strlen($pseudo);
            if($pseudolength <= 20){
                $reqpseudo = $bdd->prepare("SELECT * FROM utilisateur WHERE pseudo = ?");
                $reqpseudo->execute(array($pseudo));
                $pseudoexist = $reqpseudo->rowCount();
                if($pseudoexist == 0){
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $reqmail = $bdd->prepare("SELECT * FROM utilisateur WHERE mail = ?");
                        $reqmail->execute(array($email));
                        $mailexist = $reqmail->rowCount();
                        if($mailexist == 0){
                            if($password == $confirm_password){
                                $insertMember = $bdd->prepare("INSERT INTO utilisateur(pseudo, password, mail, avatar) VALUE (:pseudo, :password, :mail, :avatar)");
                                $insertMember->execute(array(
                                    'pseudo' => $pseudo,
                                    'password' => $password,
                                    'mail' => $email,
                                    'avatar' => $defaultAvatar
                                ));

                                $maileditevent = new PHPMailer();
                                $maileditevent->IsSMTP();
                                $maileditevent->Mailer = "smtp";
                                $maileditevent->SMTPAuth   = true;
                                $maileditevent->SMTPSecure = "tls";
                                $maileditevent->Port       = 587;
                                $maileditevent->Host       = "smtp.gmail.com";
                                $maileditevent->Username   = "bryanrasamizafy98@gmail.com";
                                $maileditevent->Password   = "apzoeiruty135";
                
                                $maileditevent->IsHTML(true);
                                $maileditevent->AddAddress($email, $pseudo);
                                $maileditevent->SetFrom("bryanrasamizafy98@gmail.com", "JEPSENS-BRITE");
                                $maileditevent->AddReplyTo("bryanrasamizafy98@gmail.com", "Teem media");
                                $maileditevent->AddCC("cc-recipient-email@domain", "cc-recipient-name");
                                $maileditevent->Subject = "Jepsens-brite event";
                                $contenteditevent = "<p>Congratulation" . $pseudo . ".</p>
                                  <p>Your registration has been successfully created.</p>
                                  <p>Welcome to the great team of JEPSENS-BRITE.</p>
                                  <p>Cordially,</p>
                                  <p>The JEPSENS-BRITE team.</p>
                                      <img src='https://cdn.discordapp.com/attachments/734665861394071563/740911873318322266/jepsen_brite.png' alt='jepsens-brite'> 
                                  ";
                                $maileditevent->MsgHTML($contenteditevent);
                                $maileditevent->send();

                                $done = "Your account is done!";

                            }else{
                                $error = "Your PASSWORD doesn't match!";
                            }
                        }else{
                            $error = "This EMAIL alrady exists!";
                        }
                    }else{
                        $error = "Your EMAIL isn't valide!";
                    }
                }else{
                    $error = "This USERNAME alrady exists!";
                }
            }else{
                $error = "Your PSEUDO is too long!";
            }
        }else{
            $error = "Complet form please!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>

    <link rel="shortcut icon" href="https://img.icons8.com/color/48/000000/naruto.png" type="image/x-icon">
    <link rel="stylesheet" href="src/css/style.css">
</head>
<body>
    <?php include("layout/header.php");?>

    <form action='' method='POST'>
    <h2 class="Titre-h2 h2center">inscription</h2>
        <input type="text" class="title_input" name='pseudo' placeholder="Nickname">
        <input type="email" class="title_input" name='email' placeholder="Email">
        <input type="password" class="title_input" name='password' placeholder="Password">
        <input type="password" class="title_input" name='confirmpassword' placeholder="Confirm Password">
        <input type=submit class="title_input" name='formInscription'>
    </form>

    <?php
        if(isset($error)){
    ?>
        <div class="error">
            <p><i class="fas fa-times"></i> <?php echo $error ?> <i class="fas fa-times"></i></p>
        </div>
    <?php
        }
        if(isset($done)){
    ?>
        <div class="done">
            <p><i class="fas fa-check"></i> <?php echo $done?> <i class="fas fa-check"></i></p>
        </div>
    <?php
        }
    ?>

    <script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>
