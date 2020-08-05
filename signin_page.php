<?php

    require 'vendor/autoload.php';
    
    include 'config/config.php';    
    
    try {
		$bdd = new PDO($dbdsn, $dbusername, $dbpassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
    }
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

                                
                                ini_set( 'display_errors', 1);
                                errot_reporting( E_ALL );
                                $from = "bryanrasamizafy98@gmail.com";
                                $to ="rasamizafybryan98@gmail.com";
                                $subject = "Vérification PHP Mail";
                                $message = "PHP mail marche";
                                $headers = "From:" . $from;
                                mail($to,$subject,$message, $headers);
                                echo "L'email a été envoyé.";

                                // $email = new \SendGrid\Mail\Mail();
                                // $email->setFrom("bryanrasamizafy98@gmail.com", "Bababry");
                                // $email->setSubject("Sending with Twilio SendGrid is Fun");
                                // $email->addTo("rasamizafybryan98@gmail.com", "Bryan");
                                // $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
                                // $email->addContent(
                                //     "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
                                // );
                                // $sendgrid = new \SendGrid('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');
                                // try {
                                //     $response = $sendgrid->send($email);
                                //     print $response->statusCode() . "\n";
                                //     print_r($response->headers());
                                //     print $response->body() . "\n";
                                // } catch (Exception $e) {
                                //     echo 'Caught exception: '. $e->getMessage() ."\n";
                                // }

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
